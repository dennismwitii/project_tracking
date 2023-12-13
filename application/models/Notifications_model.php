<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Notifications_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
    }

    function get_notifications_list($user_id, $workspace_id)
    {

        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';
        $where = '';
        $get = $this->input->get();
        if (isset($get['sort']))
            $sort = strip_tags($get['sort']);
        if (isset($get['offset']))
            $offset = strip_tags($get['offset']);
        if (isset($get['limit']))
            $limit = strip_tags($get['limit']);
        if (isset($get['order']))
            $order = strip_tags($get['order']);
        if (isset($get['search']) &&  !empty($get['search'])) {
            $search = strip_tags($get['search']);
            $where .= " where (notification like '%" . $search . "%' OR date_created LIKE '%" . $search . "%')";
        }
        if (isset($get['type']) &&  !empty($get['type'])) {
            $where .= empty($where) ? " where type='" . $get['type'] . "'" : " and type='" . $get['type'] . "'";
        }

        if (isset($get['user_type']) &&  empty($get['user_type']) && is_admin()) {
            $where .= "";
        } else {
            $where .= empty($where) ? " where FIND_IN_SET($user_id, user_ids)" : " and FIND_IN_SET($user_id, user_ids)";
        }
        $where .= empty($where) ? " where workspace_id=" . $workspace_id : " and workspace_id=" . $workspace_id;
        $query = $this->db->query("SELECT COUNT('id') as total FROM `notifications`" . $where);

        $res = $query->result_array();
        foreach ($res as $row) {
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT * FROM notifications" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit);

        // print_r($this->db->last_query());   
        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        // $this->config->load('taskhub');

        foreach ($res as $row) {
            if ($row['type'] == 'event') {
                $action = '<a href="' . base_url('calendar/' . $row['type_id']) . '" class="btn btn-light mr-2"><i class="fas fa-eye"></i>';
            }
            if ($row['type'] == 'announcement') {
                $action = '<a href="' . base_url('announcements/details/' . $row['type_id']) . '" class="btn btn-light mr-2"><i class="fas fa-eye"></i>';
            }
            if ($row['type'] == 'project') {
                $action = '<a href="' . base_url('projects/details/' . $row['type_id']) . '" class="btn btn-light mr-2"><i class="fas fa-eye"></i>';
            }
            if ($row['type'] == 'task') {
                $action = '<a href="' . base_url('projects/tasks/' . $row['type_id']) . '" class="btn btn-light mr-2"><i class="fas fa-eye"></i>';
            }
            $tempRow['id'] = $row['id'];
            $tempRow['notification'] = '<a href="notifications/details/' . $row['id'] . '">' . $row['notification'] . '</a>';
            $tempRow['date_created'] = date("d-M-Y H:i:s", strtotime($row['date_created']));
            $action .= is_admin() ? ' <a href="#" class="dropdown-item has-icon delete-notification-alert" data-notification-id="' . $row['id'] . '"><i class="far fa-trash-alt"></i></a>' : '';

            $action_btns = '<div class="btn-group no-shadow">
                                ' . $action . '
                                </div>';
            $tempRow['action'] = $action_btns;


            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    function get_notifications($id, $workspace_id)
    {
        $query = $this->db->query("select * from notifications where !FIND_IN_SET($id, read_by) AND FIND_IN_SET($id, user_ids) AND workspace_id=$workspace_id ORDER BY id DESC LIMIT 0,4");

        return $query->result_array();
    }
    function mark_all_as_read($user_id)
    {
        $query = $this->db->query("SELECT id,read_by FROM notifications WHERE FIND_IN_SET($user_id, user_ids) AND !FIND_IN_SET($user_id, read_by)");
        foreach ($query->result_array() as $row) {
            $read_by_ids = $row['read_by'] != 0 && $row['read_by'] != '' ? $row['read_by'] . ',' . $user_id : $user_id;
            $this->db->query("UPDATE notifications SET read_by='" . $read_by_ids . "' WHERE id=" . $row['id']);
        }
        return true;
    }

    function mark_notification_as_read($id, $user_id)
    {
        $query = $this->db->query("SELECT read_by FROM notifications WHERE FIND_IN_SET($user_id, user_ids) AND !FIND_IN_SET($user_id, read_by) AND id=" . $id);
        // print_r($this->db->last_query());
        // return false;
        $result = $query->result_array();
        if (!empty($result)) {
            $read_by_ids = $result[0]['read_by'] != 0 && $result[0]['read_by'] != '' ? $result[0]['read_by'] . ',' . $user_id : $user_id;
            $this->db->query("UPDATE notifications SET read_by='" . $read_by_ids . "' WHERE id=" . $id);
        }

        return true;
    }

    function delete_notification($id, $user_id)
    {
        $notification = $this->get_notification_by_id($id);
        if (!empty($notification) && (is_admin())) {
            if ($this->db->delete('notifications', array('id' => $id)))
                return 1;
            else
                return 0;
        } else {
            return 2;
        }
    }

    public function get_notification_by_id($id)
    {
        $query = $this->db->query('SELECT n.*,CONCAT(first_name," ",last_name) as user_full_name from notifications n LEFT JOIN users u ON u.id=n.user_id WHERE n.id=' . $id);
        // print_r($this->db->last_query());
        return $query->result_array();
    }

    public function get_id_by_type_id($id, $type, $user_id)
    {
        $query = $this->db->query("SELECT id FROM notifications WHERE type_id=" . $id . " AND type='" . $type . "' AND !FIND_IN_SET($user_id, read_by) AND FIND_IN_SET($user_id, user_ids)");
        // print_r($this->db->last_query());
        // return false;
        return $query->result_array();
    }
    function store_notification($data)
    {
        if ($this->db->insert('notifications', $data))
            return $this->db->insert_id();
        else
            return false;
    }
}

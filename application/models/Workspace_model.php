<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Workspace_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
    }

    function create_workspace($data)
    {
        $this->db->insert('workspace', $data);
        return $this->db->insert_id();
    }

    function edit_workspace($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('workspace', $data))
            return true;
        else
            return false;
    }

    function add_workspace_ids_to_users($workspace_id, $user_id)
    {
        $query = $this->db->query('SELECT workspace_id FROM users WHERE id=' . $user_id . ' ');

        foreach ($query->result_array() as $row) {
            $product_ids = $row['workspace_id'];
        }

        $workspace_ids = !empty($product_ids) ? $product_ids . ',' . $workspace_id : $workspace_id;

        if ($this->db->query('UPDATE users SET workspace_id="' . $workspace_ids . '" WHERE id=' . $user_id . ' '))
            return true;
        else
            return false;
    }

    function get_workspace($workspace_id)
    {
        $this->db->from('workspace');
        $this->db->where('status', 1);
        // $this->db->or_where('id', 1);
        $this->db->where_in('id', $workspace_id);
        $query = $this->db->get();
        return $query->result();
    }
    function get_workspace_list()
    {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'ASC';
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
            $where = " where (title like '%" . $search . "%' OR date_created like '%" . $search . "%')";
        }

        $query = $this->db->query("SELECT count(*) as total FROM workspace" . $where);
        $total = 0;
        $res = $query->result_array();
        foreach ($res as $row) {
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT * FROM workspace" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit);

        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($res as $row) {
            if (is_admin()) {
                $action = '<div class="dropdown card-widgets">
                    <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item has-icon modal-edit-workspace-ajax" href="#" data-id="' . $row['id'] . '"><i class="fas fa-pencil-alt"></i>' . (!empty($this->lang->line('label_edit')) ? $this->lang->line('label_edit') : 'Edit') . '</a>
                        <a class="dropdown-item has-icon delete-workspace-alert" href="#" data-id="' . $row['id'] . '"><i class="far fa-trash-alt"></i>' . (!empty($this->lang->line('label_delete')) ? $this->lang->line('label_delete') : 'Delete') . '</a>
                    </div>
                </div>';

                $action_btns = '<div class="btn-group no-shadow">
                            ' . $action . '
                </div>';
            }
            $users_icon = base_url('assets/img/avatar/avatar-1.png');
            $clients_icon = base_url('assets/img/avatar/avatar-4.png');
            $status = $row['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">De-Active</span>';
            $tempRow['id'] = $row['id'];
            $tempRow['title'] = $row['title'];
            $tempRow['users'] = '<a href="#" class="modal-workspace-users-ajax" data-id="' . $row['id'] . '"><img alt="image" class="mr-3 rounded-circle" width="40" src=' . $users_icon . '></a>';
            $tempRow['clients'] = '<a href="#" class="modal-workspace-clients-ajax" data-id="' . $row['id'] . '"><img alt="image" class="mr-3 rounded-circle" width="40" src=' . $clients_icon . '></a>';
            $tempRow['status'] = $status;
            $tempRow['date_created'] = date("d-M-Y H:i:s", strtotime($row['date_created']));
            $tempRow['action'] = is_admin() ? $action_btns : '-';
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    function get_workspace_by_id($id)
    {
        $this->db->from('workspace');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function delete_workspace($id)
    {
        $this->db->delete('activity_log', array('workspace_id' => $id));
        $this->db->delete('announcements', array('workspace_id' => $id));
        $this->db->delete('chat_group_members', array('workspace_id' => $id));
        $this->db->delete('chat_groups', array('workspace_id' => $id));
        /* Deleting chat media */
        $query = $this->db->query("SELECT * FROM chat_media WHERE workspace_id=$id");
        $chat_media = $query->result_array();
        if (!empty($chat_media)) {
            foreach ($chat_media as $media) {
                unlink('assets/chats/' . $media['file_name']);
            }
        }
        $this->db->delete('chat_media', array('workspace_id' => $id));
        $this->db->delete('comments', array('workspace_id' => $id));
        /* Deleting email attachments */
        $query = $this->db->query("SELECT attachments FROM emails WHERE workspace_id=$id");
        $attachments = $query->result_array();
        foreach($attachments as $attachment){
                $attachments = explode(",",$attachment['attachments']);
                    for ($i = 0; $i < count($attachments); $i++) {
                        if(file_exists('assets/attachments/' . $attachments[$i])){
                            unlink('assets/attachments/' . $attachments[$i]);
                        } 
                }
        }
        
        $this->db->delete('emails', array('workspace_id' => $id));
        $this->db->delete('estimates', array('workspace_id' => $id));
        $this->db->delete('estimate_items', array('workspace_id' => $id));
        $this->db->delete('events', array('workspace_id' => $id));
        $this->db->delete('expenses', array('workspace_id' => $id));
        $this->db->delete('expense_types', array('workspace_id' => $id));
        $this->db->delete('invoices', array('workspace_id' => $id));
        $this->db->delete('invoice_items', array('workspace_id' => $id));
        $this->db->delete('items', array('workspace_id' => $id));
        $this->db->delete('leaves', array('workspace_id' => $id));
        $this->db->delete('messages', array('workspace_id' => $id));
        $this->db->delete('milestones', array('workspace_id' => $id));
        $this->db->delete('notes', array('workspace_id' => $id));
        $this->db->delete('notifications', array('workspace_id' => $id));
        $this->db->delete('payment_mode', array('workspace_id' => $id));
        $this->db->delete('payments', array('workspace_id' => $id));
        /* Deleting project media */
        $query = $this->db->query("SELECT file_name FROM project_media WHERE workspace_id=$id");
        $data = $query->result_array();
        foreach ($data as $row) {
            unlink('assets/project/' . $row['file_name']);
        }
        $this->db->delete('project_media', array('workspace_id' => $id));
        $this->db->delete('tasks', array('workspace_id' => $id));
        $this->db->delete('projects', array('workspace_id' => $id));
        $this->db->delete('taxes', array('workspace_id' => $id));
        $this->db->delete('unit', array('workspace_id' => $id));
        // Removing users from workspace
        $query = $this->db->query("SELECT id,workspace_id FROM users WHERE FIND_IN_SET(" . $id . ",workspace_id)");
        $data = $query->result_array();
        foreach ($data as $row) {
            $array1 = Array($id);
            $array2 = explode(',', $row['workspace_id']);
            $array3 = array_diff($array2, $array1);
            $output = implode(',', $array3);
            $this->db->query('UPDATE users SET workspace_id="' . $output . '" WHERE id=' . $row['id']);

        }
        if ($this->db->delete('workspace', array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    function get_workspace_count($status=''){
        $this->db->from('workspace');
        if(!empty($status)){
            $this->db->where('status',1);
        }
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }
}

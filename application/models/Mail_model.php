<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mail_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
    }

    function get_mail_list($workspace_id)
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
            $where = " and (subject like '%" . $search . "%' OR message like '%" . $search . "%' OR date_sent like '%" . $search . "%')";
        }
        $query = $this->db->query("SELECT count(*) as total FROM emails WHERE workspace_id = $workspace_id" . $where);
        $total = 0;
        $res = $query->result_array();
        foreach ($res as $row) {
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT * FROM emails WHERE workspace_id = $workspace_id " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit);

        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($res as $row) {
            if (is_admin()) {
                $action = '<div class="dropdown card-widgets">
                    <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">';
                if ($row['status'] == 2) {
                    $action .= '<a href="#" class="dropdown-item has-icon retry-alert" data-id="' . $row['id'] . '""><i class="fas fa-redo"></i>' . (!empty($this->lang->line('label_retry')) ? $this->lang->line('label_retry') : 'Retry') . '</a>';
                }
                if ($row['status'] == 3) {
                    $action .= '<a href="#" class="dropdown-item has-icon send-now-alert" data-id="' . $row['id'] . '""><i class="fas fa-paper-plane"></i>' . (!empty($this->lang->line('label_send_now')) ? $this->lang->line('label_send_now') : 'Send now') . '</a>';
                }
                $action .= '<a class="dropdown-item has-icon" href="' . base_url('send-mail/details/' . $row['id']) . '" target="_blank"><i class="fas fa-eye"></i>' . (!empty($this->lang->line('label_view')) ? $this->lang->line('label_view') : 'View') . '</a>
                        <a href="#" class="dropdown-item has-icon delete-mail-alert" data-id="' . $row['id'] . '"><i class="far fa-trash-alt"></i>' . (!empty($this->lang->line('label_delete')) ? $this->lang->line('label_delete') : 'Delete') . '</a>
                    </div>
                </div>';
                $action_btns = '<div class="btn-group no-shadow">
                ' . $action . '
                </div>';
            }
            if ($row['status'] == 1) {
                $status = "<div class='badge badge-success'>Sent</label>";
            } elseif ($row['status'] == 2) {
                $status = "<div class='badge badge-danger'>Failed</label>";
            } elseif ($row['status'] == 3) {
                $status = "<div class='badge badge-primary'>Draft</label>";
            } else {
                $status = '';
            }
            $tempRow['id'] = $row['id'];
            $tempRow['workspace_id'] = $row['workspace_id'];
            $tempRow['to'] = $row['to'];
            $tempRow['subject'] = $row['subject'];
            $tempRow['message'] = $row['message'];
            $tempRow['status'] = $status;
            $tempRow['date_sent'] = $row['date_sent'];
            $tempRow['action'] = is_admin() ? $action_btns : '-';
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    function get_mail_by_id($id)
    {
        $this->db->from('emails');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }


    function add_mail($data)
    {
        if ($this->db->insert('emails', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function update_mail($data, $id)
    {
        $this->db->where('id', $id);
        if ($this->db->update('emails', $data))
            return true;
        else
            return false;
    }

    function delete_mail($id)
    {
        /* Deleting attachments */
        $query = $this->db->query("SELECT attachments FROM emails WHERE id=$id");
        $attachments = $query->result_array();
        if (!empty($attachments) && isset($attachments[0])) {
            $attachments = explode(",", $attachments[0]['attachments']);
            for ($i = 0; $i < count($attachments); $i++) {
                if (file_exists('assets/attachments/' . $attachments[$i])) {
                    unlink('assets/attachments/' . $attachments[$i]);
                }
            }
        }
        $this->db->where('id', $id);
        if ($this->db->delete('emails'))
            return true;
        else
            return false;
    }

    function get_to_emails($workspace_id)
    {
        $query = $this->db->query("SELECT `to` FROM emails WHERE workspace_id=" . $workspace_id);
        $result = $query->result_array();
        return $result;
    }
}

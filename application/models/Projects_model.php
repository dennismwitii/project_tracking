<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Projects_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'file']);
    }

    function get_projects_list($workspace_id, $user_id)
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
            $where = " and (id like '%" . $search . "%' OR title like '%" . $search . "%' OR description like '%" . $search . "%' OR status like '%" . $search . "%' OR task_count like '%" . $search . "%')";
        }

        if (isset($get['status']) && !empty($get['status'])) {
            $status = strip_tags($get['status']);
            $where .= " and status='" . $status . "'";
        }

        if (isset($get['user_id']) && !empty($get['user_id']) && empty($get['client_id'])) {
            $user_id = strip_tags($get['user_id']);
        }

        if (isset($get['client_id']) && !empty($get['client_id']) && empty($get['user_id'])) {
            $user_id = strip_tags($get['client_id']);
        }

        if (isset($get['client_id']) && !empty($get['client_id']) && isset($get['user_id']) && !empty($get['user_id'])) {
            $user_id = strip_tags($get['user_id']);
            $client_id = strip_tags($get['client_id']);
            if (!is_client($user_id)) {
                $where .= " AND FIND_IN_SET($client_id,client_id)";
            } else {
                $where .= " AND FIND_IN_SET($user_id,user_id)";
            }
        }

        if (!is_client($user_id)) {
            $query = $this->db->query("SELECT COUNT(id) as total FROM projects WHERE FIND_IN_SET($user_id,user_id) AND workspace_id=$workspace_id " . $where);
        } else {
            $query = $this->db->query("SELECT COUNT(id) as total FROM projects WHERE FIND_IN_SET($user_id,client_id) AND workspace_id=$workspace_id " . $where);
        }

        $res = $query->result_array();
        foreach ($res as $row) {
            $total = $row['total'];
        }

        if (!is_client($user_id)) {
            $query = $this->db->query("SELECT * FROM projects WHERE FIND_IN_SET($user_id,user_id) AND workspace_id= $workspace_id " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit);
        } else {
            $query = $this->db->query("SELECT * FROM projects WHERE FIND_IN_SET($user_id,client_id) AND workspace_id= $workspace_id " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit);
        }
        // print_r($this->db->last_query());    
        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        $this->config->load('taskhub');
        $progress_bar_classes = $this->config->item('progress_bar_classes');

        foreach ($res as $row) {
            $profile = '';
            $cprofile = '';
            $tempRow['id'] = $row['id'];

            $projects_user_ids = explode(',', $row['user_id']);
            $projects_userss = $this->users_model->get_user_array_responce($projects_user_ids);
            $i = 0;
            $j = count($projects_userss);
            foreach ($projects_userss as $projects_users) {
                if ($i < 2) {
                    if (isset($projects_users['profile']) && !empty($projects_users['profile'])) {
                        $profile .= '<a href="' . base_url('assets/profiles/' . $projects_users['profile']) . '" data-lightbox="images" data-title="' . $projects_users['first_name'] . '">
                        <img alt="image" class="mr-1 rounded-circle" width="30" src="' . base_url('assets/profiles/' . $projects_users['profile']) . '">
                        </a>';
                    } else {
                        $profile .= '<figure class="avatar mr-1 avatar-sm" data-toggle="tooltip" data-title="' . $projects_users['first_name'] . '" data-initial="' . mb_substr($projects_users['first_name'], 0, 1) . '' . mb_substr($projects_users['last_name'], 0, 1) . '">
                </figure>';
                    }
                    $j--;
                }
                $i++;
            }

            if ($i > 2) {
                $profile .= '<figure class="avatar mr-1 avatar-sm" data-toggle="tooltip" data-title="+' . $j . '" data-initial="+' . $j . '"> </figure>';
            }

            if (!empty($profile)) {
                $profiles = '<li class="media">
                    ' . $profile . '
                    </li>';
            } else {
                $profiles = 'Not assigned.';
            }

            $projects_client_ids = explode(',', $row['client_id']);
            $projects_clients = $this->users_model->get_user_array_responce($projects_client_ids);

            $ci = 0;
            $cj = count($projects_clients);
            foreach ($projects_clients as $projects_client) {
                if ($ci < 2) {
                    if (isset($projects_client['profile']) && !empty($projects_client['profile'])) {

                        $cprofile .= '<a href="' . base_url('assets/profiles/' . $projects_client['profile']) . '" data-lightbox="images" data-title="' . $projects_client['first_name'] . '">
                        <img alt="image" class="mr-3 rounded-circle" width="50" src="' . base_url('assets/profiles/' . $projects_client['profile']) . '">
                        </a>';
                    } else {
                        $cprofile .= '<figure class="avatar mr-1 avatar-sm" data-toggle="tooltip" data-title="' . $projects_client['first_name'] . '" data-initial="' . mb_substr($projects_client['first_name'], 0, 1) . '' . mb_substr($projects_client['last_name'], 0, 1) . '">
                </figure>';
                    }
                    $cj--;
                }
                $ci++;
            }

            if ($ci > 2) {
                $cprofile .= '<figure class="avatar mr-1 avatar-sm" data-toggle="tooltip" data-title="+' . $j . '" data-initial="+' . $j . '"> </figure>';
            }

            if (!empty($cprofile)) {
                $cprofiles = '<li class="media">
                    ' . $cprofile . '
                    </li>';
            } else {
                $cprofiles = 'Not assigned';
            }

            $tempRow['project_progress'] = $this->get_project_progress($row['id'], $workspace_id);

            $action = '<a href="' . base_url('projects/details/' . $row['id']) . '" class="btn btn-light mr-2"><i class="fas fa-eye"></i></a>';

            if ($this->ion_auth->is_admin($user_id) || is_editor($user_id)) {
                $action .= '<div class="dropdown card-widgets">
                                <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item has-icon modal-edit-project-ajax" href="#" data-id="' . $row['id'] . '"><i class="fas fa-pencil-alt"></i>' . (!empty($this->lang->line('label_edit')) ? $this->lang->line('label_edit') : 'Edit') . '</a>
                                    <a class="dropdown-item has-icon delete-project-alert" href="' . base_url('projects/delete/' . $row['id']) . '" data-project_id="' . $row['id'] . '"><i class="far fa-trash-alt"></i>' . (!empty($this->lang->line('label_delete')) ? $this->lang->line('label_delete') : 'Delete') . '</a>
                                </div>
                            </div>';
            }

            $action_btns = '<div class="btn-group no-shadow">
                        ' . $action . '
                        </div>';
            $tempRow['projects_userss'] = $profiles;
            $tempRow['projects_clientss'] = $cprofiles;
            $tempRow['title'] = $row['title'];
            $tempRow['description'] = mb_substr($row['description'], 0, 20) . '...';
            $project_status = !empty($this->lang->line('label_' . $row['status'])) ? $this->lang->line('label_' . $row['status']) : $row['status'];
            $tempRow['status'] = '<div class="badge badge-' . $row["class"] . ' projects-badge">' . $project_status . '</div>';
            $tempRow['task_count'] = $row['task_count'];

            $tempRow['action'] = $action_btns;

            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    function create_project($data)
    {
        if ($this->db->insert('projects', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function get_project_progress($id = '', $workspace_id)
    {
        $query = $this->db->query("SELECT class,status, COUNT(*) AS Total , ROUND((COUNT(*) / (SELECT COUNT(*) FROM tasks WHERE project_id=$id AND workspace_id=$workspace_id)) * 100) AS percentage FROM tasks WHERE project_id=$id AND workspace_id=$workspace_id GROUP BY status");

        // return $this->db->last_query();
        return $query->result_array();
    }

    function get_project($workspace_id, $user_id, $filter = '', $user_type = 'normal', $limit = '', $start = '')
    {

        if (!empty($limit)) {
            $where_limit = ' LIMIT ' . $limit;
            if (!empty($start)) {
                $where_limit .= ' OFFSET ' . $start;
            }
        } else {
            $where_limit = '';
        }

        if (!empty($filter)) {
            $where = "AND status='$filter'";
        } else {
            $where = '';
        }
        if ($user_type != 'normal') {
            $query = $this->db->query('SELECT * FROM projects WHERE FIND_IN_SET(' . $user_id . ',`client_id`) AND workspace_id=' . $workspace_id . ' ' . $where . 'ORDER BY id desc ' . $where_limit);
        } else {
            $query = $this->db->query('SELECT * FROM projects WHERE FIND_IN_SET(' . $user_id . ',`user_id`) AND workspace_id=' . $workspace_id . ' ' . $where . 'ORDER BY id desc ' . $where_limit);
        }
        return $query->result_array();
    }

    function edit_project($data, $id)
    {
        $this->db->where('id', $id);
        if ($this->db->update('projects', $data))
            return true;
        else
            return false;
    }

    function project_comment_count_update($id)
    {
        if ($this->db->query('UPDATE projects SET comment_count = `comment_count`+1 WHERE id=' . $id . ''))
            return true;
        else
            return false;
    }

    function add_file($data)
    {
        if ($this->db->insert('project_media', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function project_task_count_update($id)
    {
        if ($this->db->query('UPDATE projects SET task_count = `task_count`+1 WHERE id=' . $id . ''))
            return true;
        else
            return false;
    }

    function project_task_count_decreas($id)
    {
        if ($this->db->query('UPDATE projects SET task_count = `task_count`-1 WHERE id=' . $id . ''))
            return true;
        else
            return false;
    }

    function delete_project($id)
    {
        $this->db->delete('comments', array('project_id' => $id));
        $this->db->delete('tasks', array('project_id' => $id));
        $this->db->delete('milestones', array('project_id' => $id));
        $query = $this->db->query("SELECT * FROM project_media WHERE type_id=$id AND type='project' ");
        $data = $query->result_array();
        $abspath = getcwd();
        foreach ($data as $row) {
            unlink('assets/project/' . $row['file_name']);
        }
        $this->db->delete('project_media', array('type_id' => $id, 'type' => 'project'));

        if ($this->db->delete('projects', array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    function delete_file($id)
    {
        $query = $this->db->query('SELECT * FROM project_media WHERE id=' . $id . '');
        $data = $query->result_array();
        if (!empty($data)) {
            $abspath = getcwd();
            if (unlink('assets/project/' . $data[0]['file_name'])) {
                $this->db->delete('project_media', array('id' => $id));
                return true;
            } else {
                return false;
            }
        }
    }

    function get_project_by_id($project_id)
    {
        $query = $this->db->query('SELECT * FROM projects WHERE id=' . $project_id . ' ');
        return $query->result_array();
    }

    function get_files($type_id, $type)
    {
        $query = $this->db->query('SELECT * FROM project_media WHERE type="' . $type . '" AND type_id=' . $type_id . '');
        return $query->result_array();
    }
    function get_project_users($id)
    {
        $query = $this->db->query('SELECT user_id FROM projects WHERE id=' . $id);
        return $query->result_array();
    }
    function get_project_clients($id)
    {
        $query = $this->db->query('SELECT client_id FROM projects WHERE id=' . $id);
        // print_r($this->db->last_query());
        return $query->result_array();
    }
    function send_email($user_ids, $project_id, $admin_id)
    {
        
        $recepients = array();
        $project = $this->get_project_by_id($project_id);
        $admin = $this->users_model->get_user_by_id($admin_id);
        $admin_name = $admin[0]['first_name'] . ' ' . $admin[0]['last_name'];
        for ($i = 0; $i < count($user_ids); $i++) {
            $query = $this->db->query("SELECT email FROM users WHERE id=" . $user_ids[$i]);
            $data = $query->result_array();
            if(isset($data[0]) && !empty($data[0])){
                array_push($recepients,$data[0]['email']);
            }
        }
        $recepients = implode(",",$recepients);
            $from_email = get_admin_email();
            $mail_type = get_mail_type();
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype($mail_type);
            $this->email->from($from_email, get_compnay_title());
            $this->email->to($recepients);
            $this->email->subject('Added in new project');
            $body = "<html>
                <body>
                    <h1>New project</h1>
                    <p>" . $admin_name . " just added you in new project <b>" . $project[0]['title'] . "</b> ID#" . $project[0]['id'] . " </p>
                    <p>Go To your project <a href='" . base_url() . "'>Click Here</a></p>
                </body>
            </html>";

            $this->email->message($body);
            $this->email->send();
        
    }
    function get_projects($workspace_id){
        $this->db->where('workspace_id', $workspace_id);
        $this->db->from('projects');
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
}

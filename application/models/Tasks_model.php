<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_model extends CI_Model 
{ 
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
function get_tasks_list($workspace_id,$user_id){
 
    $offset = 0;$limit = 10;
    $sort = 'id'; $order = 'ASC';
    $where = '';
    $get = $this->input->get();
    if(isset($get['sort']))
        $sort = strip_tags($get['sort']);
    if(isset($get['offset']))
        $offset = strip_tags($get['offset']);
    if(isset($get['limit']))
        $limit = strip_tags($get['limit']);
    if(isset($get['order']))
        $order = strip_tags($get['order']);
    if(isset($get['search']) &&  !empty($get['search'])){
        $search = strip_tags($get['search']);
        $where .= " and (t.id like '%".$search."%' OR t.title like '%".$search."%' OR t.description like '%".$search."%' OR t.priority like '%".$search."%' OR t.status like '%".$search."%' OR p.title like '%".$search."%' OR t.due_date like '%".$search."%')";
    }

    if(isset($get['project']) && !empty($get['project'])){
        $search = strip_tags($get['project']);
        $where .=" and (p.title like '%".$search."%')";
    }
    if(isset($get['status']) && !empty($get['status'])){
        $status = strip_tags($get['status']);
        $where .= " and t.status='".$status."'";
    }


    if(isset($get['from']) && isset($get['to']) && !empty($get['from'])  && !empty($get['to']) ){
        $from = strip_tags($get['from']);
        $to = strip_tags($get['to']);
        $where .= " and t.due_date>='".$from."' and t.due_date<='".$to."' ";   
    }

    if(isset($get['user_id']) && !empty($get['user_id']) && empty($get['client_id'])){
        $user_id = strip_tags($get['user_id']);
    }
    
    if(isset($get['client_id']) && !empty($get['client_id']) && empty($get['user_id'])){
        $user_id = strip_tags($get['client_id']);
    }

    if(isset($get['client_id']) && !empty($get['client_id']) && isset($get['user_id']) && !empty($get['user_id'])){
        $user_id = strip_tags($get['client_id']);
        $client_id = strip_tags($get['user_id']);
        if(is_client($user_id)){
            $where .= " AND FIND_IN_SET($client_id,t.user_id)";
        }
    }

    if(is_admin($user_id)){
        $where .= " ";
    }elseif(is_client($user_id)){
        $where .= " and FIND_IN_SET($user_id,p.client_id)";
    }else{
        $where .= " and FIND_IN_SET($user_id,t.user_id)";
    }

    $query = $this->db->query("SELECT COUNT('t.id') as total FROM `tasks` t LEFT JOIN
        projects p ON t.project_id=p.id WHERE t.workspace_id=$workspace_id".$where);
    // print_r($this->db->last_query());
    $res = $query->result_array();
    foreach($res as $row){
        $total = $row['total'];
    }
    
    $query = $this->db->query("SELECT t.*,p.title as project_title,p.client_id as client_id FROM tasks t LEFT JOIN
        projects p ON t.project_id=p.id WHERE t.workspace_id=$workspace_id".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);

    // print_r($this->db->last_query());    
    $res = $query->result_array();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();
    
    $this->config->load('taskhub');
    $progress_bar_classes = $this->config->item('progress_bar_classes');

    foreach($res as $row){

        $profile = '';
        $cprofile = '';
        $tempRow['id'] = $row['id'];
        
        $projects_user_ids = explode(',',$row['user_id']);
		$projects_userss = $this->users_model->get_user_array_responce($projects_user_ids);
        $i = 0;
        $j = count($projects_userss);
        foreach($projects_userss as $projects_users){ 
            if($i < 2){
                if(isset($projects_users['profile']) && !empty($projects_users['profile'])){
                    
                $profile .= '<a href="'.base_url('assets/profiles/'.$projects_users['profile']).'" data-lightbox="images" data-title="'. $projects_users['first_name'].'">
                        <img alt="image" class="mr-1 rounded-circle" width="30" src="'.base_url('assets/profiles/'.$projects_users['profile']).'">
                        </a>';
                
                }else{
                $profile .= '<figure class="avatar mr-1 avatar-sm" data-toggle="tooltip" data-title="'.$projects_users['first_name'].'" data-initial="'.mb_substr($projects_users['first_name'], 0, 1).''.mb_substr($projects_users['last_name'], 0, 1).'">
                </figure>';
                }
            $j--;
            }
            $i++;
        }
        
        if($i > 2){
            $profile .= '<figure class="avatar mr-1 avatar-sm" data-toggle="tooltip" data-title="+'.$j.'" data-initial="+'.$j.'">
        </figure>';
        }
        
        if(!empty($profile)){
        $profiles = '<li class="media">
                    '.$profile.'
                    </li>';
        }else{
            $profiles = 'Not Found!';
        }

        $projects_client_ids = explode(',',$row['client_id']);
        $projects_clients = $this->users_model->get_user_array_responce($projects_client_ids);
        
        $ci = 0;
        $cj = count($projects_clients);
        foreach($projects_clients as $projects_client){ 
            if($ci < 2){
                if(isset($projects_client['profile']) && !empty($projects_client['profile'])){
                    
                $cprofile .= '<a href="'.base_url('assets/profiles/'.$projects_client['profile']).'" data-lightbox="images" data-title="'. $projects_client['first_name'].'">
                        <img alt="image" class="mr-3 rounded-circle" width="50" src="'.base_url('assets/profiles/'.$projects_client['profile']).'">
                        </a>';
                
                }else{
                $cprofile .= '<figure class="avatar mr-1 avatar-sm" data-toggle="tooltip" data-title="'.$projects_client['first_name'].'" data-initial="'.mb_substr($projects_client['first_name'], 0, 1).''.mb_substr($projects_client['last_name'], 0, 1).'">
                </figure>';
                }
            $cj--;
            }
            $ci++;
        }
        
        if($ci > 2){
            $cprofile .= '<figure class="avatar mr-1 avatar-sm" data-toggle="tooltip" data-title="+'.$j.'" data-initial="+'.$j.'">
        </figure>';
        }
        
        if(!empty($cprofile)){
        $cprofiles = '<li class="media">
                    '.$cprofile.'
                    </li>';
        }else{
            $cprofiles = 'Not Found!';
        }


        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['description'] = $row['description'];
        $priority = !empty($this->lang->line('label_'.$row['priority']))?$this->lang->line('label_'.$row['priority']):$row['priority'];
        $tempRow['priority'] = '<div class="badge badge-'.$row["class"].' projects-badge">'.ucwords($priority).'</div>';
        $task_status = !empty($this->lang->line('label_'.$row['status']))?$this->lang->line('label_'.$row['status']):$row['status']; 
        $tempRow['status'] = '<div class="badge badge-'.$progress_bar_classes[$row["status"]].' projects-badge">'.ucwords($task_status).'</div>';
        
        $tempRow['due_date'] = $row['due_date'];
        $tempRow['project_id'] = $row['project_id'];
        $tempRow['project_title'] = ucwords($row['project_title']);
        $tempRow['projects_userss'] = $profiles;
        $tempRow['projects_clientss'] = $cprofiles;
        $tempRow['action'] = '<a href="'.base_url('projects/tasks/'.$row['project_id']).'" class="btn btn-light"><i class="fas fa-eye"></i></a>';
        
        $rows[] = $tempRow;
    }
    
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

    function create_tast($data){
        if($this->db->insert('tasks', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function get_project($workspace_id, $user_id){
        $query = $this->db->query('SELECT * FROM projects WHERE FIND_IN_SET('.$user_id.',`user_id`) AND workspace_id='.$workspace_id.'');
        return $query->result_array();
    }

    function edit_task($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('tasks', $data))
            return true;
        else
            return false;
    }

    function delete_task($id){
        $this->db->delete('comments', array('task_id' => $id));
        $query = $this->db->query("SELECT * FROM project_media WHERE type_id=$id AND type='task' ");
        $data = $query->result_array();
        if(!empty($data)){
            $abspath = getcwd();
            foreach($data as $row){
                unlink($abspath.'\assets\project\\'.$row['file_name']);
            }
            $this->db->delete('project_media', array('type_id' => $id, 'type' => 'task'));
        }
        $query = $this->db->query("SELECT * FROM tasks WHERE id=$id");
        $data = $query->result_array();
        $comment_count = $data[0]['comment_count'];
        $project_id = $data[0]['project_id'];

        $this->db->query("UPDATE projects SET comment_count = `comment_count`-$comment_count WHERE id=$project_id ");

        if($this->db->delete('tasks', array('id' => $id)))
            return true;
        else
            return false;
    }

    function get_task_by_id($task_id){
        $query = $this->db->query('SELECT t.*,u.first_name as user_name,u.profile as profile, m.title as milestone_name FROM tasks t 
        LEFT JOIN users u ON t.user_id = u.id
        LEFT JOIN milestones m ON t.milestone_id = m.id
        WHERE t.id='.$task_id.' ');
        $tasks = $query->result_array();

        $product = array();
        $i=0;

        foreach($tasks as $task){
            $product[$i] = $task;
            $query = $this->db->query('SELECT c.*,u.first_name as commenter_name FROM comments c LEFT JOIN users u ON c.user_id = u.id WHERE task_id='.$task['id'].' ');
            $product[$i]['comments'] = $query->result_array();
            $query = $this->db->query('SELECT * FROM project_media WHERE type="task" AND type_id='.$task['id'].' ');
            $product[$i]['project_media'] = $query->result_array();
            $query = $this->db->query('SELECT * FROM users WHERE FIND_IN_SET(id,"'.$task['user_id'].'")');
            $product[$i]['task_users'] = $query->result_array();
        }
        return $product;
    }

    function get_task_by_project_id($project_id){
        $query = $this->db->query('SELECT t.*,u.first_name,u.last_name,u.profile FROM tasks t 
        LEFT JOIN users u ON t.user_id = u.id
        LEFT JOIN milestones m ON t.milestone_id = m.id
        WHERE t.project_id='.$project_id.' ');
        $tasks = $query->result_array();

        $product = array();
        $i=0;

        foreach($tasks as $task){
            $product[$i] = $task;
            $query = $this->db->query('SELECT c.*,u.first_name as commenter_name FROM comments c LEFT JOIN users u ON c.user_id = u.id WHERE task_id='.$task['id'].' ');
            $product[$i]['comments'] = $query->result_array();
            $query = $this->db->query('SELECT * FROM project_media WHERE type="task" AND type_id='.$task['id'].' ');
            $product[$i]['project_media'] = $query->result_array();
            $query = $this->db->query('SELECT * FROM users WHERE FIND_IN_SET(id,"'.$task['user_id'].'")');
            $product[$i]['task_users'] = $query->result_array();
            $i++;
        }
        return $product;

    }

    function task_status_update($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('tasks', $data))
            return true;
        else
            return false;
    }

    function add_task_comment($data){
        if($this->db->insert('comments', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function task_comment_count_update($id){
        if($this->db->query('UPDATE tasks SET comment_count = `comment_count`+1 WHERE id='.$id.''))
            return true;
        else
            return false;
    }

    function get_task_users($id){
        $query = $this->db->query('SELECT user_id FROM tasks WHERE id='.$id);
        return $query->result_array();
     }
     function send_email($user_ids,$task_id,$admin_id){
        $recepients = array();
        $task = $this->get_task_by_id($task_id);
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
            $this->email->set_newline('\r\n');
            $this->email->set_mailtype($mail_type);
            $this->email->from($from_email, get_compnay_title());
            $this->email->to($recepients);
            $this->email->subject('Assigned new task');  
            $body = "<html>
                <body>
                    <h1>New task</h1>
                    <p>".$admin_name." just assigned you new task <b>".$task[0]['title']."</b> ID#".$task[0]['id']." </p>
                    <p>Go To your task <a href='".base_url()."'>Click Here</a></p>
                </body>
            </html>";

            $this->email->message($body);
            $this->email->send();
        // }


        }
}
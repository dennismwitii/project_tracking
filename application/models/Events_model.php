<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Events_model extends CI_Model
{ 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language','text']);
        $this->load->model(['users_model']);
    }
    
    
    function fetch_events($user_id,$workspace_id){
        $where = is_admin()?"":"where user_id=$user_id || is_public=1";
        $where .= empty($where)?" where workspace_id=".$workspace_id:" and workspace_id=".$workspace_id;
        $query= $this->db->query("SELECT * FROM events ".$where);
        $res = $query->result_array();
        // print_r($this->db->last_query());
        return $res;
    }

    function create_event($data){
        $data['title'] = $this->db->escape_str($data['title']);
        if($this->db->insert('events', $data))
        // print_r($this->db->last_query());
            return $this->db->insert_id();
        else
            return false;
    }
    function get_events_list($user_id,$workspace_id){
 
    $offset = 0;$limit = 10;
    $sort = 'from_date'; $order = 'ASC';
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
        $where .= " where (e.id like '%".$search."%' OR title LIKE '%".$search."%' OR username LIKE '%".$search."%' OR from_date LIKE '%".$search."%' OR to_date LIKE '%".$search."%')";
    }
    if(isset($get['type']) &&  !empty($get['type'])){
        $now = date('Y-m-d H:i:s');
        $where .= empty($where)?" WHERE DATE_FORMAT(from_date, '%Y-%m-%d %H-%i-%s') >= '".$now."'":" AND DATE_FORMAT(from_date, '%Y-%m-%d %H-%i-%s') > '".$now."'";
    }
    $where .= empty($where)?" where e.workspace_id=".$workspace_id:" and e.workspace_id=".$workspace_id;
    $where .= is_admin()?"":" AND ( is_public=1 || user_id=".$user_id.")";
 
    $query = $this->db->query("SELECT COUNT('id') as total FROM `events` e LEFT JOIN users u ON u.id=e.user_id".$where);

    $res = $query->result_array();
    foreach($res as $row){
        $total = $row['total'];
    }
    
    $query = $this->db->query("SELECT e.*,u.username as user_name FROM events e JOIN users u ON e.user_id=u.id".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);

    // print_r($this->db->last_query());
    $res = $query->result_array();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();
    
    // $this->config->load('taskhub');
   
// $curdate=strtotime($now);
        foreach($res as $row){

            $is_public = $row['is_public']==0?'<div class="badge badge-danger projects-badge">No</div>':'<div class="badge badge-success projects-badge">Yes</div>';

            $tempRow['id'] = $row['id'];
            $tempRow['user_id'] = $row['user_id'];
            $tempRow['user_name'] = $row['user_name'];
            $tempRow['title'] = stripslashes($row['title']);
            $tempRow['from_date'] = date("d-M-Y H:i:s", strtotime($row['from_date']));
            $tempRow['to_date'] = date("d-M-Y H:i:s", strtotime($row['to_date']));
            $tempRow['is_public'] = $is_public;
            $tempRow['date_created'] = date("d-M-Y H:i:s", strtotime($row['date_created']));


            $action = '<div class="dropdown card-widgets">
                            <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item has-icon modal-edit-event-ajax" href="#" data-id="'.$row['id'].'"><i class="fas fa-pencil-alt"></i>'.(!empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit').'</a>

                                <a class="dropdown-item has-icon delete-event-alert" href="'.base_url('calendar/delete/'.$row['id']).'" data-event-id="'.$row['id'].'"><i class="far fa-trash-alt"></i>'.(!empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete').'</a>
                            </div>
                        </div>';

            $action_btns = '<div class="btn-group no-shadow">
                            '.$action.'
                            </div>';
            // $tempRow['action'] = $row['user_id']==$_SESSION['user_id'] || (is_admin() || is_super() || is_developer())?$action_btns:'-';
            $tempRow['action'] = $row['user_id']==$_SESSION['user_id'] || is_admin()?$action_btns:'-';
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
        
        
    }
    
    function delete_event($id,$user_id){
        $event = $this->get_event_by_id($id);
        if(!empty($event) && ($event[0]['user_id'] == $user_id || is_admin())){
            if($this->db->delete('events', array('id' => $id)))
                return 1;
            else
                return 0;
        }else{
            return 2;
        }
    }

    function get_event_by_id($event_id){
        $this->db->select('*');
        $this->db->where('id',$event_id);
        $query = $this->db->get('events');
        return $query->result_array();
    }
    
    function edit_event($data,$id,$user_id){
        if(isset($data['title']) && !empty($data['title'])){
            $data['title'] = $this->db->escape_str($data['title']);
        }
        $event = $this->get_event_by_id($id);
        if(!empty($event) && ($event[0]['user_id'] == $user_id || is_admin())){
            $this->db->where('id', $id);
            if($this->db->update('events', $data))
            // print_r($this->db->last_query());
                return 1;
            else
                return 0; 
        }else{
            return 2;
        }
        
    }
    
}
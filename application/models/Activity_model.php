<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model
{ 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
    }

    function store_activity($data){
        if($this->db->insert('activity_log', $data))
            return $this->db->insert_id();
        else
            return false;
    }

     function get_activity_list($user_id,$workspace_id){
 
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
            $where .= " where (id like '%".$search."%' OR user_id LIKE '%".$search."%' OR user_name LIKE '%".$search."%' OR type LIKE '%".$search."%' OR activity LIKE '%".$search."%'  OR date_created LIKE '%".$search."%' OR project_title LIKE '%".$search."%' OR task_title LIKE '%".$search."%' OR comment LIKE '%".$search."%')";
        }
        if(isset($get['activity']) && !empty($get['activity'])){
            $where .= empty($where)?" WHERE activity = '".$get['activity']."'":" AND activity = '".$get['activity']."'";
        }
        if(isset($get['activity_type']) && !empty($get['activity_type'])){
            $where .= empty($where)?" WHERE type = '".$get['activity_type']."'":" AND type = '".$get['activity_type']."'";
        }
        $where .= empty($where)?" where workspace_id=".$workspace_id:" and workspace_id=".$workspace_id;

        $query = $this->db->query("SELECT COUNT('id') as total FROM `activity_log`".$where);

        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }
        
        $query = $this->db->query("SELECT * FROM activity_log".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);

        // print_r($this->db->last_query());
        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        
        // $this->config->load('taskhub');

            foreach($res as $row){
                if($row['activity']=='Created'){
                    $activity = "<span class='badge badge-success'>Created</span>";
                }if($row['activity']=='Updated'){
                    $activity = "<span class='badge badge-info'>Updated</span>"; 
                }if($row['activity']=='Deleted'){
                    $activity = "<span class='badge badge-danger'>Deleted</span>"; 
                }if($row['activity']=='Uploaded'){
                    $activity = "<span class='badge badge-warning'>Uploaded</span>"; 
                }
                $user_name =  $row['user_id'] == $user_id?'You':$row['user_name'];
                $tempRow['id'] = $row['id'];
                $tempRow['workspace_id'] = $row['workspace_id'];
                $tempRow['user_id'] = $row['user_id'];
                $tempRow['user_name'] = $user_name;
                $tempRow['type'] = $row['type'];
                $tempRow['project_id'] = $row['project_id'];
                $tempRow['project_title'] = $row['project_title'];
                $tempRow['task_id'] = $row['task_id'];
                $tempRow['task_title'] = $row['task_title'];
                $tempRow['comment_id'] = $row['comment_id'];
                $tempRow['comment'] = $row['comment'];
                $tempRow['file_id'] = $row['file_id'];
                $tempRow['file_name'] = $row['file_name'];
                $tempRow['milestone_id'] = $row['milestone_id'];
                $tempRow['milestone'] = $row['milestone'];
                $tempRow['activity'] = $activity;
                $tempRow['message'] = $row['message'];
                $tempRow['date_created'] = date("d-M-Y H:i:s", strtotime($row['date_created']));


                $action = '
                            <a class="dropdown-item has-icon delete-activity-alert" href="'.base_url('activity-logs/delete/'.$row['id']).'" data-activity-id="'.$row['id'].'"><i class="far fa-trash-alt"></i></a>
                            
                        ';

                $action_btns = '<div class="btn-group no-shadow">
                                '.$action.'
                                </div>';
                $tempRow['action'] = is_admin()?$action_btns:'';
                   
                
                $rows[] = $tempRow;
            }

            $bulkData['rows'] = $rows;
            print_r(json_encode($bulkData));
        
        
    }

    function delete_activity($id){
        $activity = $this->get_activity_by_id($id);
        if(!empty($activity) && is_admin()){
            if($this->db->delete('activity_log', array('id' => $id)))
                return true;
            else
                return false;
        }else{
            return false;
        }
    }

    function get_activity_by_id($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $query = $this->db->get('activity_log');
        return $query->result_array();
    }

    

}
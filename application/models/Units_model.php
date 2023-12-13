<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Units_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->model(['projects_model']);
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
    function get_units_list($workspace_id){ 
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
            $where = " and (title like '%".$search."%' OR description like '%".$search."%' OR workspace_id like '%".$search."%')";
        }

        $query = $this->db->query("SELECT count(*) as total FROM unit WHERE FIND_IN_SET($workspace_id, workspace_id) ".$where);
        $total = 0;
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT * FROM unit WHERE FIND_IN_SET($workspace_id, workspace_id) ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
    
        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $action = '';
        $action_btn = '';
        foreach($res as $row){
            $action = '';
            $tempRow['id'] = $row['id'];
            $action_btn = '';
            if(is_admin()){    
                $action .= '<div class="dropdown card-widgets">
                    <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item has-icon modal-edit-unit-btn" href="#" data-id="'.$row['id'].'"><i class="fas fa-pencil-alt"></i>'.(!empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit').'</a>
                        <a class="dropdown-item has-icon delete-unit-alert" href="'.base_url('unit/delete/'.$row['id']).'" data-unit_id="'.$row['id'].'"><i class="far fa-trash-alt"></i>'.(!empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete').'</a>
                    </div>
                </div>';
            }
            $tempRow['title'] = $row['title'];
            $tempRow['description'] = $row['description'];
            $tempRow['action'] = $action;
            $rows[] = $tempRow;
        }
    
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    function get_units($workspace_id){
        $this->db->where('workspace_id', $workspace_id);
        $this->db->from('unit');
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_unit_by_id($unit_id){

        $this->db->from('unit');
        $this->db->where('id', $unit_id);
        $query = $this->db->get();
        return $query->result_array();
    }


    function add_unit($data){
        if($this->db->insert('unit', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function edit_unit($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('unit', $data))
            return true;
        else
            return false;
    }

    function delete_unit($unit_id){
        $this->db->where('id', $unit_id);
        if($this->db->delete('unit'))
            return true;
        else
            return false;
    }
}
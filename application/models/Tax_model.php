<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->model(['projects_model']);
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
    function get_tax_list($workspace_id){ 
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
            $where = " and (title like '%".$search."%' OR description like '%".$search."%' OR percentage like '%".$search."%' OR workspace_id like '%".$search."%')";
        }

        $query = $this->db->query("SELECT count(*) as total FROM taxes WHERE FIND_IN_SET($workspace_id, workspace_id) ".$where);
        $total = 0;
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT * FROM taxes WHERE FIND_IN_SET($workspace_id, workspace_id) ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
    
        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach($res as $row){
            $tempRow['id'] = $row['id'];
            if(is_admin()){    
                $action = '<div class="dropdown card-widgets">
                    <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item has-icon modal-edit-tax-btn" href="#" data-id="'.$row['id'].'"><i class="fas fa-pencil-alt"></i>'.(!empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit').'</a>
                        <a class="dropdown-item has-icon delete-tax-alert" href="'.base_url('tax/delete/'.$row['id']).'" data-tax_id="'.$row['id'].'"><i class="far fa-trash-alt"></i>'.(!empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete').'</a>
                    </div>
                </div>';
                $action_btns = '<div class="btn-group no-shadow">
                            '.$action.'
                            </div>';
            }
            $tempRow['title'] = $row['title'];
            $tempRow['description'] = $row['description'];
            $tempRow['percentage'] = $row['percentage'];
            $tempRow['action'] = is_admin()?$action_btns:'-';
            $rows[] = $tempRow;
        }
    
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    function get_taxes($workspace_id){
        $this->db->where('workspace_id', $workspace_id);
        $this->db->from('taxes');
        $this->db->order_by("percentage", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_tax_by_id($tax_id){

        $this->db->from('taxes');
        $this->db->where('id', $tax_id);
        $query = $this->db->get();
        return $query->result_array();
    }


    function add_tax($data){
        if($this->db->insert('taxes', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function edit_tax($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('taxes', $data))
            return true;
        else
            return false;
    }

    function delete_tax($tax_id){
        $this->db->where('id', $tax_id);
        if($this->db->delete('taxes'))
            return true;
        else
            return false;
    }
}
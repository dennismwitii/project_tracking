<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
    function get_expense_type_list($workspace_id){ 
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
            $where = " and (title like '%".$search."%' OR description like '%".$search."%' OR created_on like '%".$search."%' OR workspace_id like '%".$search."%')";
        }

        $query = $this->db->query("SELECT count(*) as total FROM expense_types WHERE FIND_IN_SET($workspace_id, workspace_id) ".$where);
        $total = 0;
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT * FROM expense_types WHERE FIND_IN_SET($workspace_id, workspace_id) ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
    
        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach($res as $row){
            
            if(is_admin()){    
                $action = '<div class="dropdown card-widgets">
                    <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item has-icon modal-edit-expense-type-ajax" href="#" data-id="'.$row['id'].'"><i class="fas fa-pencil-alt"></i>'.(!empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit').'</a>
                        <a class="dropdown-item has-icon delete-expense-type-alert" href="'.base_url('expenses/delete_expense_type/'.$row['id']).'" data-type-id="'.$row['id'].'"><i class="far fa-trash-alt"></i>'.(!empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete').'</a>
                    </div>
                </div>';
            }
            $action_btns = '<div class="btn-group no-shadow">
                            '.$action.'
                            </div>';
            $tempRow['id'] = $row['id'];
            $tempRow['workspace_id'] = $row['workspace_id'];
            $tempRow['title'] = $row['title'];
            $tempRow['description'] = $row['description'];
            $tempRow['created_on'] = $row['created_on'];
            $tempRow['action'] = is_admin()?$action_btns:'-';
            $rows[] = $tempRow;
        }
    
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    function get_expense_list($workspace_id){ 
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
            $where = " and (e.title like '%".$search."%' OR e.note like '%".$search."%' OR e.amount like '%".$search."%' OR expense_date like '%".$search."%' OR e.created_on like '%".$search."%')";
        }

        $query = $this->db->query("SELECT count(id) as total FROM expenses e WHERE workspace_id = $workspace_id".$where);
        // print_r($this->db->last_query());
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT e.*,CONCAT(first_name,' ',last_name) as user_name, et.title as expense_type FROM expenses e LEFT JOIN users u on u.id=e.user_id LEFT JOIN expense_types et ON e.expense_type_id=et.id WHERE e.workspace_id = $workspace_id".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
    
        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach($res as $row){
            if(is_admin()){    
                $action = '<div class="dropdown card-widgets">
                    <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item has-icon modal-edit-expense-ajax" href="#" data-id="'.$row['id'].'"><i class="fas fa-pencil-alt"></i>'.(!empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit').'</a>
                        <a class="dropdown-item has-icon delete-expense-alert" href="'.base_url('expenses/delete_expense/'.$row['id']).'" data-expense-id="'.$row['id'].'"><i class="far fa-trash-alt"></i>'.(!empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete').'</a>
                    </div>
                </div>';
            
                $action_btns = '<div class="btn-group no-shadow">
                            '.$action.'
                </div>';
            }
            $tempRow['id'] = $row['id'];
            $tempRow['user_id'] = $row['user_id'];
            $tempRow['user_name'] = $row['user_name'];
            $tempRow['workspace_id'] = $workspace_id;
            $tempRow['expense_type_id'] = $row['expense_type_id'];
            $tempRow['expense_type'] = $row['expense_type'];
            $tempRow['title'] = $row['title'];
            $tempRow['note'] = $row['note'];
            $tempRow['amount'] = $row['amount'];
            $tempRow['expense_date'] = $row['expense_date'];
            $tempRow['created_on'] = $row['created_on'];
            $tempRow['action'] = is_admin()?$action_btns:'-';
            $rows[] = $tempRow;
        }
    
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    function get_expense_by_id($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $query = $this->db->get('expenses');
        return $query->result_array();
    }
    function get_expense_type_by_id($id){

        $this->db->from('expense_types');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function add_expense($data){
        if($this->db->insert('expenses', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function edit_expense($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('expenses', $data))
            return true;
        else
            return false;
    }

    function delete_expense($id){
        $this->db->where('id', $id);
        if($this->db->delete('expenses'))
            return true;
        else
            return false;
    }
    function add_expense_type($data){
        if($this->db->insert('expense_types', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function edit_expense_type($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('expense_types', $data))
            return true;
        else
            return false;
    }

    function delete_expense_type($id){
        $this->db->where('id', $id);
        if($this->db->delete('expense_types'))
            return true;
        else
            return false;
    }

    function get_expense_types($workspace_id){
        $this->db->select('*');
        $this->db->where('workspace_id',$workspace_id);
        $this->db->order_by("id", "desc");
        $query = $this->db->get('expense_types');
        return $query->result_array();
    }
}
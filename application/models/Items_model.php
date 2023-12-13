<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Items_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
    function get_item_list($workspace_id){ 
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
            $where = " and (i.title like '%".$search."%' OR i.description like '%".$search."%' OR i.workspace_id like '%".$search."%')";
        }

        $query = $this->db->query("SELECT count(*) as total FROM items i WHERE workspace_id = $workspace_id".$where);
        $total = 0;
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT i.*,u.title as unit FROM items i LEFT JOIN unit u ON i.unit_id=u.id WHERE i.workspace_id = $workspace_id".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
    
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
                        <a class="dropdown-item has-icon modal-edit-item-ajax" href="#" data-id="'.$row['id'].'"><i class="fas fa-pencil-alt"></i>'.(!empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit').'</a>
                        <a class="dropdown-item has-icon delete-item-alert" href="#" data-id="'.$row['id'].'"><i class="far fa-trash-alt"></i>'.(!empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete').'</a>
                    </div>
                </div>';
            
                $action_btns = '<div class="btn-group no-shadow">
                            '.$action.'
                </div>';
            }
            $tempRow['id'] = $row['id'];
            $tempRow['workspace_id'] = $row['workspace_id'];
            $tempRow['unit_id'] = $row['unit_id'];
            $tempRow['title'] = $row['title'];
            $tempRow['description'] = $row['description'];
            $tempRow['unit'] = $row['unit'];
            $tempRow['price'] = $row['price'];
            $tempRow['action'] = is_admin()?$action_btns:'-';
            $rows[] = $tempRow;
        }
    
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    function get_item_by_id($item_id){

        $this->db->from('items');
        $this->db->where('id', $item_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_items($workspace_id){
        $this->db->where('workspace_id', $workspace_id);
        $this->db->from('items');
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    function add_item($data){
        if($this->db->insert('items', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function edit_item($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('items', $data))
            return true;
        else
            return false;
    }

    function delete_item($item_id){
        $this->db->where('id', $item_id);
        if($this->db->delete('items'))
            return true;
        else
            return false;
    }
}
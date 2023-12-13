<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Estimates_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    function get_estimates_list($workspace_id){ 
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
            $where = " and (id like '%".$search."%' OR name like '%".$search."%' OR amount like '%".$search."%' OR estimate_date like '%".$search."%' OR valid_upto_date like '%".$search."%' OR created_on like '%".$search."%')";
        }
        if(isset($get['status']) &&  $get['status'] != ''){
            $status = strip_tags($get['status']);
            $where .= " AND status=".$status;
        }

        $query = $this->db->query("SELECT count(id) as total FROM estimates WHERE workspace_id = $workspace_id".$where);
        // print_r($this->db->last_query());
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT * FROM estimates WHERE workspace_id = $workspace_id".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
    
        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach($res as $row){
            if($row['status']==1){
                $status = '<div class="badge badge-primary">SENT</div>';
              }elseif($row['status']==2){
                $status = '<div class="badge badge-success">ACCEPTED</div>';
              }elseif($row['status']==3){
                $status = '<div class="badge badge-info">DRAFT</div>';
              }elseif($row['status']==4){
                $status = '<div class="badge badge-danger">DECLINED</div>';
              }elseif($row['status']==5){
                $status = '<div class="badge badge-warning">EXPIRED</div>';
              }else{
                $status = '<div class="badge badge-light">N/A</div>';
              }
            $tempRow['id'] = '<a href="'.base_url('estimates/view-estimate/'.$row['id']).'" target="_blank">ESTMT-'.$row['id'].'</a><div class="table-links">
                <a href="'.base_url('estimates/estimate/'.$row['id']).'" target="_blank">View</a>
                <div class="bullet"></div>
                <a href="'.base_url('estimates/edit-estimate/'.$row['id']).'">Edit</a>
                <div class="bullet"></div>
                <a href="'.base_url('estimates/view-estimate/'.$row['id']).'" target="_blank">PDF</a>
                <div class="bullet"></div>
                <a href="#" data-estimate-id="'.$row['id'].'" class="text-danger delete-estimate-alert">Trash</a>
                
            </div>';
            $tempRow['workspace_id'] = $workspace_id;
            $tempRow['name'] = $row['name'];
            $tempRow['amount'] = number_format((float)$row['amount'], 2, '.', '');
            $tempRow['estimate_date'] = $row['estimate_date'] != '0000-00-00 00:00:00'?date("d-M-Y", strtotime($row['estimate_date'])):"-";
            $tempRow['valid_upto_date'] = $row['valid_upto_date'] != '0000-00-00 00:00:00'?date("d-M-Y", strtotime($row['valid_upto_date'])):"-";
            $tempRow['created_on'] = date("d-M-Y", strtotime($row['created_on']));
            $tempRow['status'] = $status;
            $rows[] = $tempRow;
        }
    
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    function get_estimate_by_id($estimate_id){
        $this->db->from('estimates');
        $this->db->where('id',$estimate_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_estimate_item_by_id($estimate_item_id){

        $this->db->where('id', $estimate_item_id);
        $this->db->from('estimate_items');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_estimate_items($estimate_id){
        $this->db->select('ei.*,i.title,t.title as tax_title,t.percentage as tax_percentage,u.title as unit_title');
        $this->db->from('estimate_items ei');
        $this->db->join('items i','ei.item_id = i.id','left');
        $this->db->join('taxes t','ei.tax_id = t.id','left');
        $this->db->join('unit u','ei.unit_id = u.id','left');
        $this->db->where('ei.estimate_id',$estimate_id);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_count($workspace_id,$status=""){
        $this->db->where('workspace_id', $workspace_id);
        $this->db->from('estimates');
        if($status != ""){
            $this->db->where('status', $status);
        }
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }
    function get_not_assigned($workspace_id){
        $this->db->where('workspace_id', $workspace_id);
        $this->db->from('estimates');
        $this->db->where('status', 0);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }
    function add_estimate($data){
        if($this->db->insert('estimates', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function add_estimate_item($data){
        if($this->db->insert('estimate_items', $data))
            return $this->db->insert_id();
        else
            return false;
    }
    function update_estimate($data,$estimate_id){
        $this->db->where('id',$estimate_id);
        return $this->db->update('estimates',$data);

   }
   function update_estimate_item($data,$estimate_item_id){
    $this->db->where('id',$estimate_item_id);
    return $this->db->update('estimate_items',$data);

}

    function delete_estimate($id){
        if($this->db->delete('estimate_items', array('estimate_id' => $id))){
            if($this->db->delete('estimates', array('id' => $id))){
                return true;
            }else{
                return false;
            }
        }
            
    }
    function delete_estimate_item($id){
        if($this->db->delete('estimate_items', array('id' => $id))){
            return true;
        }else{
            return false;
            
        }
            
    }
}
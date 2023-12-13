<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    function get_invoices_list($workspace_id){ 
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
            $where = " and (id like '%".$search."%' OR name like '%".$search."%' OR amount like '%".$search."%' OR invoice_date like '%".$search."%' OR due_date like '%".$search."%' OR created_on like '%".$search."%')";
        }
        if(isset($get['status']) &&  $get['status'] != ''){
            $status = strip_tags($get['status']);
            $where .= " AND status=".$status;
        }

        $query = $this->db->query("SELECT count(id) as total FROM invoices WHERE workspace_id = $workspace_id".$where);
        // print_r($this->db->last_query());
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }

        $query = $this->db->query("SELECT * FROM invoices WHERE workspace_id = $workspace_id".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
    
        $res = $query->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach($res as $row){
            if($row['status']==1){
                $status = '<div class="badge badge-success">FULLY PAID</div>';
              }elseif($row['status']==2){
                $status = '<div class="badge badge-warning">PARTIALLY PAID</div>';
              }elseif($row['status']==3){
                $status = '<div class="badge badge-info">DRAFT</div>';
              }elseif($row['status']==4){
                $status = '<div class="badge badge-danger">CANCELLED</div>';
              }elseif($row['status']==5){
                $status = '<div class="badge badge-primary">DUE</div>';
              }else{
                $status = '<div class="badge badge-light">N/A</div>';
              }
            $tempRow['id'] = '<a href="'.base_url('invoices/view-invoice/'.$row['id']).'" target="_blank">INVOC-'.$row['id'].'</a><div class="table-links">
                <a href="'.base_url('invoices/invoice/'.$row['id']).'" target="_blank">View</a>
                <div class="bullet"></div>
                <a href="'.base_url('invoices/edit-invoice/'.$row['id']).'">Edit</a>
                <div class="bullet"></div>
                <a href="'.base_url('invoices/view-invoice/'.$row['id']).'" target="_blank">PDF</a>
                <div class="bullet"></div>
                <a href="#" data-invoice-id="'.$row['id'].'" class="text-danger delete-invoice-alert">Trash</a>
            </div>';
            $tempRow['workspace_id'] = $workspace_id;
            $tempRow['project_id'] = $row['project_id'];
            $tempRow['name'] = $row['name'];
            $tempRow['amount'] = number_format((float)$row['amount'], 2, '.', '');
            $tempRow['invoice_date'] = $row['invoice_date'] != '0000-00-00 00:00:00'?date("d-M-Y", strtotime($row['invoice_date'])):"-";
            $tempRow['due_date'] = $row['due_date'] != '0000-00-00 00:00:00'?date("d-M-Y", strtotime($row['due_date'])):"-";
            $tempRow['created_on'] = date("d-M-Y", strtotime($row['created_on']));
            $tempRow['status'] = $status;
            $rows[] = $tempRow;
        }
    
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    function get_invoice_by_id($invoice_id){
        $this->db->select('i.*,p.title as project_title');
        $this->db->from('invoices i');
        $this->db->join('projects p','i.project_id = p.id','left');
        $this->db->where('i.id',$invoice_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_invoices($workspace_id){
        $this->db->select('id');
        $this->db->where('workspace_id',$workspace_id);
        $this->db->order_by("id", "desc");
        $query = $this->db->get('invoices');
        return $query->result_array();
    }
    function get_invoice_items($invoice_id){
        $this->db->select('ii.*,i.title,t.title as tax_title,t.percentage as tax_percentage,u.title as unit_title');
        $this->db->from('invoice_items ii');
        $this->db->join('items i','ii.item_id = i.id','left');
        $this->db->join('taxes t','ii.tax_id = t.id','left');
        $this->db->join('unit u','ii.unit_id = u.id','left');
        $this->db->where('ii.invoice_id',$invoice_id);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_count($workspace_id,$status=""){
        $this->db->where('workspace_id', $workspace_id);
        $this->db->from('invoices');
        if($status != ""){
            $this->db->where('status', $status);
        }
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }
    function get_not_assigned($workspace_id){
        $this->db->where('workspace_id', $workspace_id);
        $this->db->from('invoices');
        $this->db->where('status', 0);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }
    function add_invoice($data){
        if($this->db->insert('invoices', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function add_invoice_item($data){
        if($this->db->insert('invoice_items', $data))
            return $this->db->insert_id();
        else
            return false;
    }
    function update_invoice($data,$invoice_id){
        $this->db->where('id',$invoice_id);
        return $this->db->update('invoices',$data);

   }
   function update_invoice_item($data,$invoice_item_id){
    $this->db->where('id',$invoice_item_id);
    return $this->db->update('invoice_items',$data);

}

    function delete_invoice($id){
        if($this->db->delete('invoice_items', array('invoice_id' => $id)) && $this->db->delete('payments', array('invoice_id' => $id))){
            if($this->db->delete('invoices', array('id' => $id))){
                return true;
            }else{
                return false;
            }
        }
            
    }
}
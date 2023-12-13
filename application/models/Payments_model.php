<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payments_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }

    function get_payments_list($workspace_id){ 
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
            $where = " and (note like '%".$search."%' OR p.workspace_id like '%".$search."%' OR amount like '%".$search."%' OR payment_date like '%".$search."%')";
        }

        $query = $this->db->query("SELECT count(*) as total FROM payments p WHERE p.workspace_id = $workspace_id".$where);
        $total = 0;
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }
        $query = $this->db->query("SELECT p.*,u.first_name,u.last_name,pm.title as payment_mode FROM payments p LEFT JOIN users u on p.user_id=u.id LEFT JOIN payment_mode pm ON p.payment_mode_id=pm.id WHERE p.workspace_id = $workspace_id".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
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
                        <a class="dropdown-item has-icon modal-edit-payment-ajax" href="#" data-id="'.$row['id'].'"><i class="fas fa-pencil-alt"></i>'.(!empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit').'</a>
                        <a class="dropdown-item has-icon delete-payment-alert" href="#" data-payment-id="'.$row['id'].'"><i class="far fa-trash-alt"></i>'.(!empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete').'</a>
                    </div>
                </div>';
                $action_btns = '<div class="btn-group no-shadow">
                            '.$action.'
                            </div>';
            }
            $tempRow['id'] = $row['id'];
            $tempRow['workspace_id'] = $row['workspace_id'];
            $tempRow['invoice_id'] = !empty($row['invoice_id'])?'INVOC-'.$row['invoice_id']:(!empty($this->lang->line('label_not_assigned')) ? $this->lang->line('label_not_assigned') : 'Not assigned');
            $tempRow['user_id'] = $row['user_id'];
            $tempRow['user_name'] = !empty($row['user_id'])?$row['first_name'].' '.$row['last_name']:(!empty($this->lang->line('label_not_assigned')) ? $this->lang->line('label_not_assigned') : 'Not assigned');
            $tempRow['note'] = $row['note'];
            $tempRow['payment_mode_id'] = $row['payment_mode_id'];
            $tempRow['payment_mode'] = $row['payment_mode'];
            $tempRow['amount'] = $row['amount'];
            $tempRow['payment_date'] = date("d-M-Y H:i:s", strtotime($row['payment_date']));
            $tempRow['created_on'] = $row['created_on'];
            $tempRow['action'] = is_admin()?$action_btns:'-';
            $rows[] = $tempRow;
        }
    
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }
    
    function get_payment_mode_list($workspace_id){ 
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
            $where = " and (title like '%".$search."%' OR workspace_id like '%".$search."%')";
        }

        $query = $this->db->query("SELECT count(*) as total FROM payment_mode WHERE FIND_IN_SET($workspace_id, workspace_id) ".$where);
        $total = 0;
        $res = $query->result_array();
        foreach($res as $row){
            $total = $row['total'];
        }
        $query = $this->db->query("SELECT * FROM payment_mode WHERE FIND_IN_SET($workspace_id, workspace_id) ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit);
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
                        <a class="dropdown-item has-icon modal-edit-payment-mode-ajax" href="#" data-id="'.$row['id'].'"><i class="fas fa-pencil-alt"></i>'.(!empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit').'</a>
                        <a class="dropdown-item has-icon delete-payment-mode-alert" data-payment-mode-id="'.$row['id'].'"><i class="far fa-trash-alt"></i>'.(!empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete').'</a>
                    </div>
                </div>';
                $action_btns = '<div class="btn-group no-shadow">
                            '.$action.'
                            </div>';
            }
            $tempRow['id'] = $row['id'];
            $tempRow['title'] = $row['title'];
            $tempRow['created_on'] = $row['created_on'];
            $tempRow['action'] = is_admin()?$action_btns:'-';
            $rows[] = $tempRow;
        }
    
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    function get_payment_mode_by_id($payment_mode_id){

        $this->db->from('payment_mode');
        $this->db->where('id', $payment_mode_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_payment_by_id($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $query = $this->db->get('payments');
        return $query->result_array();
    }
    function get_payments_by_invoice_id($invoice_id){

        $this->db->select('p.*,pm.title as payment_mode,i.amount as total_amount');
        $this->db->from('payments p');
        $this->db->join('payment_mode pm','p.payment_mode_id = pm.id','left');
        $this->db->join('invoices i','p.invoice_id = i.id','left');
        $this->db->where('p.invoice_id',$invoice_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function add_payment($data){
        if($this->db->insert('payments', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function add_payment_mode($data){
        if($this->db->insert('payment_mode', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function edit_payment_mode($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('payment_mode', $data))
            return true;
        else
            return false;
    }
    function edit_payment($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('payments', $data))
            return true;
        else
            return false;
    }
    function delete_payment($payment_id){
        $this->db->where('id', $payment_id);
        if($this->db->delete('payments'))
            return true;
        else
            return false;
    }
    function delete_payment_mode($payment_mode_id){
        $this->db->where('id', $payment_mode_id);
        if($this->db->delete('payment_mode'))
            return true;
        else
            return false;
    }

    function get_payment_modes($workspace_id){
        $this->db->select('id,title');
        $this->db->where('workspace_id',$workspace_id);
        $this->db->order_by("id", "desc");
        $query = $this->db->get('payment_mode');
        return $query->result_array();
    }

    function get_amount_left($invoice_id){
        $query = $this->db->query('SELECT SUM(amount) as paid_amount FROM payments WHERE invoice_id='.$invoice_id);
        $res = $query->result_array();
        $paid_amount = $res[0]['paid_amount'];
        $query = $this->db->query('SELECT amount FROM invoices WHERE id='.$invoice_id);
        $res = $query->result_array();
        $amount = $res[0]['amount'];
        $amount_left = $amount - $paid_amount;
        return $amount_left;
    }
}
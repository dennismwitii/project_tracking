<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Language_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
    function create_language($data){
        $this->db->insert('languages', $data);
        return $this->db->insert_id();
    }

    function update_language($lang, $data){
        $this->db->where('language', $lang);
        if($this->db->update('languages', $data))
            return true;
        else
            return false;
    }

    function add_workspace_ids_to_users($workspace_id, $user_id){
        $query = $this->db->query('SELECT workspace_id FROM users WHERE id='.$user_id.' ');

            foreach ($query->result_array() as $row)
            {
                $product_ids = $row['workspace_id'];
            }

            $workspace_ids = !empty($product_ids)?$product_ids.','.$workspace_id:$workspace_id;

        if($this->db->query('UPDATE users SET workspace_id="'.$workspace_ids.'" WHERE id='.$user_id.' '))
            return true;
        else
            return false;
            
    } 

    function get_workspace($workspace_id){
        $this->db->from('workspace');
        $this->db->where_in('id', $workspace_id);
        $query = $this->db->get();
        return $query->result();
    }
}
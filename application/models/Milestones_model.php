<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Milestones_model extends CI_Model 
{ 
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
    function create_milestone($data){
        if($this->db->insert('milestones', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function get_project($workspace_id, $user_id){
        $query = $this->db->query('SELECT * FROM projects WHERE FIND_IN_SET('.$user_id.',`user_id`) AND workspace_id='.$workspace_id.'');
        return $query->result_array();
    }

    function edit_milestone($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('milestones', $data))
            return true;
        else
            return false;
    }

    function delete_milestone($id){
        if($this->db->delete('milestones', array('id' => $id)))
            return true;
        else
            return false;
    }

    function get_milestone_by_id($milestone_id){
        $query = $this->db->query('SELECT * FROM milestones WHERE id='.$milestone_id.' ');
        return $query->result_array();
    }

    function get_milestone_by_project_id($project_id, $workspace_id){
        $query = $this->db->query('SELECT * FROM milestones WHERE project_id='.$project_id.' AND workspace_id='.$workspace_id.' ');
        return $query->result_array();
    }
}
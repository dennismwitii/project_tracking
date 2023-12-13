<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notes_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
    function create_note($data){
        if($this->db->insert('notes', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function edit_note($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('notes', $data))
            return true;
        else
            return false;
    }

    function delete_note($id,$user_id){
        $note = $this->get_note_by_id($id);
        if(!empty($note) && $note[0]['user_id'] == $user_id){
            if($this->db->delete('notes', array('id' => $id)))
                return true;
            else
                return false;
        }else{
            return false;
        }
    }

    function get_note($workspace_id, $user_id){
        $query = $this->db->query('SELECT * FROM notes WHERE workspace_id='.$workspace_id.' AND user_id='.$user_id.' ORDER BY id desc');
        return $query->result();
    }

    function get_note_by_id($note_id){
        $query = $this->db->query('SELECT * FROM notes WHERE id='.$note_id.' ');
        return $query->result_array();
    }
}
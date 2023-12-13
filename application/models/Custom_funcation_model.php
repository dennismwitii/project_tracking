<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_funcation_model extends CI_Model 
{ 
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
    function format_size_units($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' KB';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    function get_count($field,$table,$where = ''){ 
        if(!empty($where))
            $where = "where ".$where;

        $query = $this->db->query("SELECT COUNT(".$field.") as total FROM ".$table." ".$where." ");
        $res = $query->result_array();
        if(!empty($res)){
            return $res[0]['total'];
        }
        
    }

}
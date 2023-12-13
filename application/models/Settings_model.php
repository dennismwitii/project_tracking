<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model
{ 
    public function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->db->query('SET time_zone = "+05:30"');
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }
    
    function save_settings($setting_type,$data){
        $this->db->where('type', $setting_type);
        if($this->db->update('settings', $data))
            return true;
        else
            return false; 
    }
}
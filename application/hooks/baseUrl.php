<?php

class BaseUrl {

    function MyBaseUrl() {

        $CI =& get_instance();
        $CI->db->from('settings');
        $CI->db->where(['type'=>'general']);
        $query = $CI->db->get();
        $confiemail = $query->result_array();
        
        if(!empty($confiemail[0]['data'])){
            $confiemail = json_decode($confiemail[0]['data']);
 
            if(!empty($confiemail->app_url)){
                $CI->config->set_item('base_url', $confiemail->app_url);
            }

        }

    }

}

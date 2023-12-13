<?php

class MyOtherClass {

    function MyOtherfunction() {

        $CI =& get_instance();
        $CI->db->from('settings');
        $CI->db->where(['type'=>'email']);
        $query = $CI->db->get();
        $confiemail = $query->result_array();
        
        if(!empty($confiemail[0]['data'])){
            $confiemail = json_decode($confiemail[0]['data']);

            if($confiemail->smtp_encryption == 'off'){
                $smtp_encryption = $confiemail->smtp_host;
            }else{
                $smtp_encryption = $confiemail->smtp_encryption.'://'.$confiemail->smtp_host;
            }
            
            $data = array(
                'mailtype' => $confiemail->mail_content_type,
                'protocol' => 'SMTP',
                'smtp_host' => $smtp_encryption,
                'smtp_port' => $confiemail->smtp_port,
                'smtp_user' => $confiemail->email,
                'smtp_pass' => $confiemail->password,
                'charset' => 'utf-8',
                'newline' => '\r\n',
            ); 

            $CI->config->set_item('email_config', $data);
        }

    }

}

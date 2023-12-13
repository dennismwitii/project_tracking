<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model
{ 
    public function __construct()
	{ 
		parent::__construct();
        $this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
    }

    function create_group($data){
        if($this->db->insert('chat_groups', $data))
            return $this->db->insert_id();
        else
            return false; 
    }

    function make_me_online($id, $data){
        $this->db->where('id', $id);
        if($this->db->update('users', $data))
            return true;
        else
            return false; 
    }

    function edit_group($data,$id){
        $this->db->where('id', $id);
        if($this->db->update('chat_groups', $data))
            return true;
        else
            return false; 
    }

    function add_group_members($data){

        $query = $this->db->query("SELECT count(id) as total FROM chat_group_members WHERE workspace_id=".$data['workspace_id']." AND group_id=".$data['group_id']." AND user_id=".$data['user_id']." ");
        $result = $query->result_array();
        $result = $result[0]['total'];

        if($result == 0){
            if($this->db->insert('chat_group_members', $data))
                return $this->db->insert_id();
            else
                return false; 
        }
    }

    function remove_all_group_members($id, $user_id){
        $user_id = implode(",",$user_id);
        if($this->db->query("DELETE FROM chat_group_members WHERE group_id = $id AND user_id NOT IN ($user_id) "))
            return true;
        else
            return false; 
    }

    function make_group_admin($id, $user_id){
        $user_id = implode(",",$user_id);

        if($this->db->query("UPDATE chat_group_members SET is_admin=1 WHERE group_id = $id AND is_admin=0 AND user_id IN ($user_id) "))
            if($this->db->query("UPDATE chat_group_members SET is_admin=0 WHERE group_id = $id AND is_admin=1 AND user_id NOT IN ($user_id) "))
                return true;
            else
                return false; 
        else
            return false; 
    }
    
    function get_group_members($group_id){
        $query = $this->db->query("SELECT gm.*,g.title,g.description FROM chat_group_members gm 
        LEFT JOIN chat_groups g ON gm.group_id = g.id
        WHERE gm.group_id=$group_id ");
        return $query->result_array();
    }

    function check_group_admin($group_id, $user_id){
        
        $query = $this->db->query("SELECT * FROM chat_group_members WHERE group_id=$group_id AND user_id=$user_id AND is_admin=1 ");
        $data = $query->result_array();

        if(!empty($data))
            return true;
        else
            return false; 

    }

    function delete_group($group_id, $user_id, $workspace_id){

        $query = $this->db->query("SELECT * FROM messages WHERE workspace_id=$workspace_id AND to_id=$group_id AND type='group' ");
        $messages = $query->result_array();

        if(!empty($messages)){
            $abspath = getcwd();
            foreach($messages as $message){
                $query = $this->db->query("SELECT * FROM chat_media WHERE workspace_id=$workspace_id AND message_id=".$message['id']);
                $chat_media = $query->result_array();
                if(!empty($chat_media)){
                    foreach($chat_media as $media){
                        unlink('assets/chats/'.$media['file_name']);
                    }
                }
                $this->db->delete('chat_media', array('workspace_id' => $workspace_id, 'message_id' => $message['id']));
            }
            
        }

        $this->db->delete('chat_group_members', array('workspace_id' => $workspace_id, 'group_id' => $group_id));

        $this->db->delete('chat_groups', array('workspace_id' => $workspace_id, 'id' => $group_id));

        if($this->db->delete('messages', array('workspace_id' => $workspace_id, 'to_id' => $group_id, 'type' => 'group'))){
            return true;
        }else{
            return false;
        }
    }
    
    function delete_msg($from_id, $msg_id, $workspace_id){

        $query = $this->db->query("SELECT * FROM chat_media WHERE workspace_id=$workspace_id AND message_id=$msg_id ");
        $data = $query->result_array();
        if(!empty($data)){
            $abspath = getcwd();
            foreach($data as $row){
                unlink('assets/chats/'.$row['file_name']);
            }
            $this->db->delete('chat_media', array('workspace_id' => $workspace_id, 'message_id' => $msg_id));
        }

        if($this->db->query("DELETE FROM messages WHERE workspace_id=$workspace_id AND from_id=$from_id AND id=$msg_id")){
            return true;
        }else{
            return false;
        }
    }

    function get_members($workspace_id){

        $this->db->from('users');
        $this->db->where_in('id', $workspace_id);
        $this->db->order_by("first_name", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_groups($user_id, $workspace_id){

        $sql = "SELECT gm.*,g.title,g.description,g.created_by,g.no_of_members FROM chat_group_members gm 
        LEFT JOIN chat_groups g ON gm.group_id = g.id
        WHERE gm.workspace_id=$workspace_id AND gm.user_id=$user_id 
        ORDER BY g.title ASC";
        $query = $this->db->query($sql);
        $groups =  $query->result_array();
        return $groups;
    }

    function get_groups_all($user_id, $workspace_id){
        $group_ids = array();
        $my_groups = $this->get_groups($user_id, $workspace_id);
        foreach($my_groups as $my_group){
            $group_ids[] =  $my_group['group_id'];
        }

        if(!empty($group_ids)){
            $group_ids = implode(",", $group_ids);

            $sql = "SELECT * FROM chat_groups WHERE id NOT IN ($group_ids) ORDER BY title ASC";
            $query = $this->db->query($sql);
            $groups =  $query->result_array();
            return $groups;
        }
        
    }

    function get_unread_msg_count($type, $from_id, $to_id, $workspace_id){
        $query1 = "SELECT count(id) as total FROM messages WHERE type='$type' AND is_read=1 AND workspace_id=$workspace_id AND from_id=$from_id AND to_id=$to_id";
        $query1 = $this->db->query($query1);
        $total = $query1->result_array();
        return $total[0]['total'];
    }

    function mark_msg_read($type, $from_id, $to_id, $workspace_id){
        if($type == 'person'){
            if($this->db->query("UPDATE messages SET is_read=0 WHERE type='$type' AND is_read=1 AND workspace_id=$workspace_id AND from_id=$from_id AND to_id=$to_id"))
                return true;
            else
                return false;
        }else{
            if($this->db->query("UPDATE chat_group_members SET is_read=0 WHERE is_read=1 AND workspace_id=$workspace_id AND group_id=$from_id AND user_id=$to_id"))
                return true;
            else
                return false;
        }

    }

    function set_group_msg_as_unread($group_id, $my_id, $workspace_id){
        if($this->db->query("UPDATE chat_group_members SET is_read=1 WHERE is_read=0 AND workspace_id=$workspace_id AND group_id=$group_id AND user_id!=$my_id "))
            return true;
        else
            return false;

    }

    function update_web_fcm($user_id, $fcm){
        if($this->db->query('UPDATE users SET web_fcm="'.$fcm.'" WHERE id='.$user_id.' '))
            return true;
        else
            return false;
    }

    function send_msg($data){

        if($this->db->insert('messages', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function get_msg_by_id($msg_id, $to_id, $from_id, $type){

        $sql = "SELECT * FROM messages WHERE id='$msg_id' ";
        $query = $this->db->query($sql);
        $messages =  $query->result_array();
        $product = array();
        $i=0;
        foreach($messages as $message){
            $product[$i] = $message;

            if($type == 'person'){
                if($to_id == $message['to_id']){
                    $me_user = $this->switch_chat($message['from_id'],$type);
                    $product[$i]['picture'] = substr($me_user[0]['first_name'], 0, 1).''.substr($me_user[0]['last_name'], 0, 1);
                    
                    $product[$i]['profile'] = $me_user[0]['profile'];

                    $product[$i]['senders_name'] = $me_user[0]['first_name'].' '.$me_user[0]['last_name']
                    ;
                    
                    $product[$i]['position'] ='right';
                }else{
                    $oppo_user = $this->switch_chat($message['from_id'],$type);
                    $product[$i]['picture'] =substr($oppo_user[0]['first_name'], 0, 1).''.substr($oppo_user[0]['last_name'], 0, 1);

                    $product[$i]['profile'] = $oppo_user[0]['profile'];

                    $product[$i]['senders_name'] =$oppo_user[0]['first_name'].' '.$oppo_user[0]['last_name'];
                    
                    $product[$i]['position'] ='left';
                }
            }else{

                // new group msg arrived and you have change here

                $oppo_user = $this->switch_chat($message['from_id'],'person');
                $product[$i]['picture'] =substr($oppo_user[0]['first_name'], 0, 1).''.substr($oppo_user[0]['last_name'], 0, 1);

                $product[$i]['profile'] = $oppo_user[0]['profile'];
                
                $product[$i]['senders_name'] = $oppo_user[0]['first_name'].' '.$oppo_user[0]['last_name'];

                if($from_id == $message['from_id']){
                    $product[$i]['position'] ='right';
                }else{
                    $product[$i]['position'] ='left';
                }
            }
            
            $i++;
        }
        return $product; 
    }

    function load_chat($type = '', $from_id, $to_id, $workspace_id,$offset = '', $limit = '',$sort = '',$order = '',$search = ''){
        
        // $from_id is a group id when $type is = group 

        $search = ($search !== '' && $search !== '')?" AND (`message` like '%".$search."%') ":"";

        if($type == 'person'){
            $query1 = "SELECT count(id) as total FROM messages WHERE type='$type' AND workspace_id=$workspace_id $search AND ((from_id=$from_id AND to_id=$to_id) OR (from_id=$to_id AND to_id=$from_id)) ";
        }elseif($type == 'group'){
            $query1 = "SELECT count(id) as total FROM messages WHERE type='$type' AND workspace_id=$workspace_id AND to_id=$from_id $search";
        }else{
            $query1 = "SELECT count(id) as total FROM messages WHERE workspace_id=$workspace_id $search";
        }
        $query1 = $this->db->query($query1);
        $rowcount = $query1->result_array();
        $rowcount = $rowcount[0]['total'];

        if($type == 'person'){
            $sql = "SELECT * FROM messages WHERE type='$type' AND workspace_id=$workspace_id $search AND ((from_id=$from_id AND to_id=$to_id) OR (from_id=$to_id AND to_id=$from_id)) ";
        }elseif($type == 'group'){
            $sql = "SELECT * FROM messages WHERE type='$type' AND workspace_id=$workspace_id AND to_id=$from_id $search ";
        }else{
            $sql = "SELECT * FROM messages WHERE workspace_id=$workspace_id $search ";
        }

        if(empty($search)){
            $sql .= ($sort !== '' && $order !== '')?" ORDER BY $sort $order ":"";
            $sql .= ($offset !== '' && $limit !== '' )?" Limit $offset,$limit ":"";
        }

        $query = $this->db->query($sql);
        $messages =  $query->result_array();
        $product = array();
        $i=0;

        foreach($messages as $message){
            $product['msg'][$i] = $message;
            $me_user = $this->switch_chat($message['from_id'],'person');

            $product['msg'][$i]['picture'] = substr($me_user[0]['first_name'], 0, 1).''.substr($me_user[0]['last_name'], 0, 1);

            $product['msg'][$i]['profile'] = $me_user[0]['profile'];;

            $product['msg'][$i]['senders_name'] = $me_user[0]['first_name'].' '.$me_user[0]['last_name'];
            if($message['type'] == 'group'){
                $me_user = $this->switch_chat($message['to_id'],'group');
                $product['msg'][$i]['group_name'] = '#'.$me_user[0]['title'];
            }elseif($message['type'] == 'person'){
                $product['msg'][$i]['group_name'] = $me_user[0]['first_name'].' '.$me_user[0]['last_name'];
            }
            $i++;
        }
        $product['total_msg'] = $rowcount;
        return $product;
    }

    function get_media($msg_id){
        $query = $this->db->query("SELECT * FROM chat_media WHERE message_id=$msg_id ");
        return $query->result_array();
    }

    function add_file($data){
        if($this->db->insert('chat_media', $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function switch_chat($user_or_group_id, $type){

        if($type == 'person'){
            $query = $this->db->query("SELECT * FROM users WHERE id=$user_or_group_id ");
        }else{
            $query = $this->db->query("SELECT * FROM chat_groups WHERE id=$user_or_group_id ");
        }

        $messages =  $query->result_array();
        return $messages;
    }

    function get_user_picture($user_id){
        $query = $this->db->query("SELECT * FROM users WHERE id='$user_id' ");
        $messages =  $query->result_array();
        $picture = substr($messages[0]['first_name'], 0, 1).''.substr($messages[0]['last_name'], 0, 1);
        return $picture;
    }

    function get_web_fcm($user_id){
        $query = $this->db->query("SELECT web_fcm FROM users WHERE id=$user_id ");
        return $query->result_array();
    }

	function add_media_ids_to_msg($msg_id, $media_id){

        $query = $this->db->query('SELECT media FROM messages WHERE id='.$msg_id.' ');

        if(!empty($query)){
            foreach ($query->result_array() as $row)
            {
                $product_ids = $row['media'];
            }
            $ids = !empty($product_ids)?$product_ids.','.$media_id:$media_id;
        }
        
        if($this->db->query('UPDATE messages SET media="'.$ids.'" WHERE id='.$msg_id.' '))
            return true;
        else
            return false;
            
    } 

    function make_user_admin($workspace_id, $user_id){

        // in this func we are adding users id in the workspace - data format 1,2,3 

        $query = $this->db->query('SELECT admin_id FROM workspace WHERE id='.$workspace_id.' ');

        if(!empty($query)){
            foreach ($query->result_array() as $row)
            {
                $product_ids = $row['admin_id'];
            }
            $admin_id = $product_ids.','.$user_id;
        }
        
        if($this->db->query('UPDATE workspace SET admin_id="'.$admin_id.'" WHERE id='.$workspace_id.' '))
            return true;
        else
            return false;
            
    } 

    function remove_user_from_admin($workspace_id, $user_id){

        // in this func we are adding users id in the workspace - data format 1,2,3 
        $query = $this->db->query('SELECT admin_id FROM workspace WHERE FIND_IN_SET('.$user_id.',`admin_id`) and id ='.$workspace_id.' ');
        $result = $query->result_array();
        if(!empty($result)){
            $admin_id = $result[0]['admin_id'];
            $admin_id = preg_replace('/\s+/', '', $admin_id);
            $admin_ids = explode(",",$admin_id);
            if (($key = array_search($user_id, $admin_ids)) !== false) {
                unset($admin_ids[$key]);
            }
            $admin_id = implode(",",$admin_ids);
            if($this->db->query('UPDATE workspace SET admin_id="'.$admin_id.'" WHERE id='.$workspace_id.' '))
                return true;
            else
                return false;
        }else{
            return false;
        }            
    } 

    function remove_user_from_workspace($workspace_id, $user_id){
        $this->remove_user_from_admin($workspace_id, $user_id);
        $query = $this->db->query('SELECT user_id FROM workspace WHERE FIND_IN_SET('.$user_id.',`user_id`) and id ='.$workspace_id.' ');
        $result = $query->result_array();
        if(!empty($result)){
            $admin_id = $result[0]['user_id'];
            $admin_id = preg_replace('/\s+/', '', $admin_id);
            $admin_ids = explode(",",$admin_id);
            if (($key = array_search($user_id, $admin_ids)) !== false) {
                unset($admin_ids[$key]);
            }
            $admin_id = implode(",",$admin_ids);
            if($this->db->query('UPDATE workspace SET user_id="'.$admin_id.'" WHERE id='.$workspace_id.' ')){

                $query = $this->db->query('SELECT workspace_id FROM users WHERE FIND_IN_SET('.$workspace_id.',`workspace_id`) and id ='.$user_id.' ');
                $result = $query->result_array();
                if(!empty($result)){
                    $admin_id = $result[0]['workspace_id'];
                    $admin_id = preg_replace('/\s+/', '', $admin_id);
                    $admin_ids = explode(",",$admin_id);
                    if (($key = array_search($workspace_id, $admin_ids)) !== false) {
                        unset($admin_ids[$key]);
                    }
                    $admin_id = implode(",",$admin_ids);
                    if($this->db->query('UPDATE users SET workspace_id="'.$admin_id.'" WHERE id='.$user_id.' ')){
                        $query = $this->db->query('SELECT id,user_id FROM projects WHERE FIND_IN_SET('.$user_id.',`user_id`) and workspace_id ='.$workspace_id.' ');
                        $results = $query->result_array();
                        if(!empty($results)){
                            foreach($results as $result){
                                $admin_id = $result['user_id'];
                                $id = $result['id'];
                                $admin_id = preg_replace('/\s+/', '', $admin_id);
                                $admin_ids = explode(",",$admin_id);
                                if (($key = array_search($user_id, $admin_ids)) !== false) {
                                    unset($admin_ids[$key]);
                                }
                                $admin_id = implode(",",$admin_ids);
                                $this->db->query('UPDATE projects SET user_id="'.$admin_id.'" WHERE id='.$id.' ');      
                            }
                        }
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                return false;
            }
        }else{
            return false;
        }            
    } 

    function get_user($user_id){

        // $user_id is array of users ids 

        $this->db->from('users');
        $this->db->where_in('id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_user_array_responce($user_id){

        // $user_id is array of users ids 

        $this->db->from('users');
        $this->db->where_in('id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_user_not_in_workspace($user_id){

        // $user_id is array of users ids 

        $this->db->from('users');
        $this->db->where_not_in('id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_users_by_email($email){

        $this->db->from('users');
        $this->db->where('`email` like "%'.$email.'%" or `first_name` like "%'.$email.'%" or `last_name` like "%'.$email.'%" ');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_users_by_email_for_add($email){

        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_user_by_id($user_id){

        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
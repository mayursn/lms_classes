<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {

    protected $primary_key = 'user_id';
    public $belongs_to = array('role');
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set the timestamps for created and updated field
     * @param mixed $user
     * @return mixed
     */
    protected function timestamps($user) {
        
        if(check_role_approval())
        {
            $user['is_active'] = 0;
        }
        
        $user['created_at'] = $user['updated_at'] = date('Y-m-d H:i:s');
       
        return $user;
    }

   /**
     * Set the update timestamps 
     * @param mixed $user
     * @return mixed
     */
    protected function update_timestamps($user) {
        
        if(check_role_approval())
        {
            $user['is_active'] = 0;
        }
        
        $user['updated_at'] = date('Y-m-d H:i:s');
        return $user;
    }

    /**
     * Get users
     * @return type
     */
    public function get_users() {
        return $this->db->select()
                        ->from('user')
                        ->join('role', 'role.role_id = user.role_id')
                        ->where_not_in('role_name', [
                            'Student', 'Professor'
                        ])->get()->result();
    }
    
    function get_user()
    {
        return $this->db->select()
                        ->from('user')
                        ->join('role', 'role.role_id = user.role_id')
                        ->where('user_id',$this->session->userdata('user_id'))->get()->result();
    }

    

}

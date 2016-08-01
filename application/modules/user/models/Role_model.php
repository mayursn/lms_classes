<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends MY_Model {
    
    protected $primary_key = 'role_id';
    
    public $has_many = array('user');

    public $before_create = array('timestamps');
    
    public $before_update = array('update_timestamps');
    
    /**
     * Set the timestamps for created and updated field
     * @param mixed $role
     * @return mixed
     */
    protected function timestamps($role) {
        $role['created_at'] = $role['updated_at'] = date('Y-m-d H:i:s');
        
        return $role;
    }
    
    /**
     * Set the update timestamp field
     * @param mixed $role
     * @return mixed
     */
    protected function update_timestamps($role) {
        $role['updated_at'] = date('Y-m-d H:i:s');
        
        return $role;
    }
}

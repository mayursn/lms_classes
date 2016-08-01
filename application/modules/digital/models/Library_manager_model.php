<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Library_manager_model extends MY_Model {
    
    protected $primary_key = 'lm_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    
    /**
     * Set timestamp field
     * @param array $library
     * @return array
     */
    protected function timestamps($library) {
         if(check_role_approval())
        {
            $library['lm_status'] = 0;
        }
        
        $library['created_date'] = $library['updated_date'] = date('Y-m-d H:i:s');
        
        return $library;
    }
     protected function update_timestamps($library)
    {
        if(check_role_approval())
        {
            $library['lm_status'] = 0;
        }
        
        $library['updated_date'] = date('Y-m-d H:i:s');
        return $library;
    }
    
}
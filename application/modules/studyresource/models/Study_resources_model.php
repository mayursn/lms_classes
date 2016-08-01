<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Study_resources_model extends MY_Model {
    
    protected $primary_key = 'study_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    
    /**
     * Set timestamp field
     * @param array $studyresource
     * @return array
     */
    protected function timestamps($studyresource) {
         if(check_role_approval())
        {
            $studyresource['study_status'] = 0;
        }
        
        $studyresource['created_date'] = $studyresource['updated_date'] = date('Y-m-d H:i:s');        
        return $studyresource;
    }
     protected function update_timestamps($studyresource)
    {
        if(check_role_approval())
        {
            $studyresource['study_status'] = 0;
        }
        
        $studyresource['updated_date'] = date('Y-m-d H:i:s');
        return $studyresource;
    }
}
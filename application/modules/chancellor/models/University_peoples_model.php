<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class University_peoples_model extends MY_Model {
    
    protected $primary_key = 'university_people_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    
    
     protected function timestamps($university) {
       
        if(check_role_approval())
        {
            $university['status'] = 0;
        }
        
        $university['created_date'] =  $university['updated_date']= date('Y-m-d H:i:s');
        
        return $university;
    }
    protected function update_timestamps($university)
    {
        if(check_role_approval())
        {
            $university['status'] = 0;
        }
        
        $university['updated_date'] = date('Y-m-d H:i:s');
        return $university;
    }
   
}
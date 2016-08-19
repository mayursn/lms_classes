<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends MY_Model {

    protected $primary_key = 'course_id';    
    public $before_create = array('timestamps');    
    public $before_update = array('update_timestamps');
    public $before_get = array('check_status');

    /**
     * Set the timestamp
     * @param array $branch
     */
    protected function timestamps($branch) {  
        if(check_role_approval())
        {
            $branch['course_status'] = 0;
        }
        
        $branch['created_date'] =  $branch['updated_date'] = date('Y-m-d H:i:s');

        return $branch;
    }

     protected function update_timestamps($branch)
    {
        if(check_role_approval())
        {
            $branch['course_status'] = 0;
        }
        
        $branch['updated_date'] = date('Y-m-d H:i:s');
        return $branch;
    }
    
    function get_all_course()
    {
        return $this->db->get($this->_table)->result();
    }    
    function check_status()
    {
        $this->db->where('course_status','1');
    }
}


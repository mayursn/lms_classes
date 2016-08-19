<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment_manager_model extends MY_Model {
    
    protected $primary_key = 'assign_id';
    
    public $before_create = array('timestamps');
    
    public $before_get = array('department_filter');
    
   
    
    
    /**
     * Set timestamp field
     * @param array $degree
     * @return array
     */
    protected function timestamps($assignment) {
         if(check_role_approval())
            {
                $assignment['assign_status'] = 0;
            }

        $assignment['created_date'] = date('Y-m-d H:i:s');        
        return $assignment;
    }
    
    function department_filter()
    {
        if($this->session->userdata('professor_id'))
        {
            $dept = $this->session->userdata('professor_department');
            $this->db->where('assign_degree',$dept);
        }
    }
    
}
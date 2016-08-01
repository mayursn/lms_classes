<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Smart_syllabus_model extends MY_Model {
    
    protected $primary_key = 'syllabus_id';
    
    public $before_create = array('timestamps');
     public $before_get = array('department_filter');
    
    
    /**
     * Set timestamp field
     * @param array $syallbus
     * @return array
     */
    protected function timestamps($syallbus) {
        $syallbus['created_date'] = date('Y-m-d H:i:s');        
        return $syallbus;
    }
    
    function department_filter()
    {
        if($this->session->userdata('professor_id'))
        {
            $dept = $this->session->userdata('professor_department');
            $this->db->where('syllabus_degree',$dept);
        }
    }
   
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Degree_model extends MY_Model {
    
    protected $primary_key = 'd_id';
    
    public $before_create = array('timestamps');
    public $before_get = array('department_filter');
    public $before_update = array('update_timestamps');

    /**
     * Set timestamp field
     * @param array $degree
     * @return array
     */
    protected function timestamps($degree) {
        if(check_role_approval())
        {
            $degree['d_status'] = 0;
        }
        
        $degree['created_date'] = $degree['updated_date']= date('Y-m-d H:i:s');
        
        return $degree;
    }
    protected function update_timestamps($degree)
    {
        if(check_role_approval())
        {
            $degree['d_status'] = 0;
        }
        
        $degree['updated_date'] = date('Y-m-d H:i:s');
        return $degree;
    }
   function department_filter()
   {
       
       if($this->session->userdata('professor_id'))
       {           
          $this->db->where('d_id',$this->session->userdata('professor_department'));
       }   
   }
    
}
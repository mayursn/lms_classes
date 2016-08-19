<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Participate_student_model extends MY_Model {
    
    protected $primary_key = 'participate_student_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $activity
     * @return array
     */
    protected function timestamps($activity) {
        $activity['apply_date'] = date('Y-m-d H:i:s');        
        return $activity;
    }
    function get_not_participate_list()
    {
        $std_id = $this->session->userdata('std_id');
        return $this->db->query("SELECT * FROM participate_manager WHERE pp_id not in (select pp_id from participate_student where student_id=$std_id )")->result_array();
    }
    
      
   
}
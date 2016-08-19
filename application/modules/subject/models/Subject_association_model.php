<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_association_model extends MY_Model {
    
    protected $primary_key = 'sa_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $subject
     * @return array
     */
    protected function timestamps($subject) {
        $subject['created_date'] = date('Y-m-d H:i:s');
        
        return $subject;
    }
    
    public function get_subject_list($degree,$course_id,$sem)
    {
        $this->db->join('subject_manager s','s.sm_id = sa.sm_id');
        $this->db->where("sa.degree_id",$degree);
        $this->db->where("sa.course_id",$course_id);
        $this->db->where("sa.sem_id",$sem);
         return $this->db->get('subject_association sa')->result();
         
         
         
         
         
        
    }
    
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student_upload_model extends MY_Model {
    
    protected $primary_key = 'upload_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $uploads
     * @return array
     */
    protected function timestamps($uploads) {
        $uploads['created_date'] = date('Y-m-d H:i:s');        
        return $uploads;
    }
    
      
    function getstudent_upload()
    {
        $std_id = $this->session->userdata('std_id');
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get_where('student_upload',array('std_id'=>$std_id))->result();
    }
}
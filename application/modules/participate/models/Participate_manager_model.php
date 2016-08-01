<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Participate_manager_model extends MY_Model {
    
    protected $primary_key = 'pp_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    /**
     * Set timestamp field
     * @param array $participate
     * @return array
     */
    protected function timestamps($participate) {
         if(check_role_approval())
        {
            $participate['pp_status'] = 0;
        }
        
        $participate['created_date'] =  $participate['updated_date'] = date('Y-m-d H:i:s');        
        return $participate;
    }
    protected function update_timestamps($participate)
    {
        if(check_role_approval())
        {
            $participate['pp_status'] = 0;
        }
        
        $participate['updated_date'] = date('Y-m-d H:i:s');
        return $participate;
    }
    public function get_survey()
    {
          $this->db->select("ls.*,s.*");
        $this->db->from('survey ls');
        $this->db->join("student s", "s.std_id=ls.student_id");
        $this->db->group_by('ls.student_id');
         return $this->db->get()->result();
    }
    
    public function get_students()
    {
        $this->db->select('std_id,name');
        $this->db->distinct('s.student_id');
        $this->db->join('student std','std.std_id = s.student_id');
        return $this->db->get('survey s')->result();
                
    }
    
    public function get_question()
    {
        return  $this->db->select('sq_id, question, question_description, question_status')->from('survey_question')->get()->result();
    }
    
    public function get_volunteer()
    {
        return $this->db->select('student_id, pp_id, participate_student_id, comment')->from('participate_student')->get()->result_array();
    }
    
    public function get_uploads()
    {
        return $this->db->select('std_id, upload_file_name,upload_title,upload_desc')->from('student_upload')->get()->result_array();
    }
}
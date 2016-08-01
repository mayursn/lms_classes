<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vocational_course_model extends MY_Model {
    
    protected $primary_key = 'vocational_course_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    public $before_get = array('professor_vocational_course');


    /**
     * Set timestamp field
     * @param array $vocationalcourse
     * @return array
     */
    protected function timestamps($vocationalcourse) {
        if(check_role_approval())
        {
            $vocationalcourse['status'] = 0;
        }
        $vocationalcourse['created_date	'] = date('Y-m-d H:i:s');
        
        return $vocationalcourse;
    }

     protected function update_timestamps($vocationalcourse)
    {
        if(check_role_approval())
        {
            $vocationalcourse['status'] = 0;
        }
        
        $vocationalcourse['updated_date'] = date('Y-m-d H:i:s');
       
        return $vocationalcourse;
    }
    function professor_vocational_course()
    {
        if($this->session->userdata('professor_id'))
        {
            $id = $this->session->userdata('professor_id');
            $this->db->where('professor_id',$id);
        }
    }
    
    function get_vocational_student($id)
    {
         return $this->db->select('vocational_course_fee.*, student.std_first_name,student.std_last_name,student.name, vocational_course.course_name,course_category.*,d.d_name,c.c_name,s.s_name')
                        ->from('vocational_course_fee')
                        ->where('vocational_course_fee.vocational_course_id',$id)
                        ->join('student', 'student.std_id = vocational_course_fee.student_id')
                        ->join('vocational_course', 'vocational_course.vocational_course_id = vocational_course_fee.vocational_course_id')
                        ->join('course_category', 'course_category.category_id = vocational_course.category_id')
                        ->join('degree d','d.d_id=student.std_degree')
                        ->join('course c','c.course_id=student.course_id')
                        ->join('semester s','s.s_id=student.semester_id')
                        ->get()
                        ->result();
    }
    
}
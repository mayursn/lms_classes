<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Graduates_model extends MY_Model {
    
    protected $primary_key = 'graduates_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $graduates
     * @return array
     */
    protected function timestamps($graduates) {
        $graduates['created_at'] = date('Y-m-d H:i:s');        
        return $graduates;
    }
    
    
        /**
     * Get all graduates
     * @return mixed
     */
    function get_all_graduates() {
        return $this->db->select()
                        ->from('graduates')
                        ->join('student', 'student.std_id = graduates.student_id')
                        ->join('degree', 'degree.d_id = graduates.degree_id')
                        ->join('course', 'course.course_id = graduates.course_id')
                        ->join('semester', 'semester.s_id = graduates.semester_id')
                        ->order_by('graduates.created_at', 'DESC')
                        ->get()
                        ->result();
    }

   
}

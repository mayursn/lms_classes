<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Internal_marks_model extends MY_Model {
    
    protected $primary_key = 'int_marks_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $marks
     * @return array
     */
    protected function timestamps($marks) {
        $marks['created_date'] = date('Y-m-d H:i:s');        
        return $marks;
    }
    
     /**
     * Update marks of the exam
     * @param array $data
     * @param array $where
     * @return int
     */
    function internal_update($data, $where) {
        $this->db->where($where);
        $insert_id = $this->db->update('internal_marks', $data);

        return $insert_id;
    }
    
    function get_student_internal_marks($where)
    {
        return $this->db->get_where("internal_marks",$where)->row();
    }
    
    
}
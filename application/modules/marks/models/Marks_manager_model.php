<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_manager_model extends MY_Model {
    
    protected $primary_key = 'mm_id';
    
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
    function mark_update($data, $where) {
        $this->db->where($where);
        $insert_id = $this->db->update('marks_manager', $data);

        return $insert_id;
    }
    
    
}
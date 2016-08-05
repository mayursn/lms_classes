<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fees_structure_model extends MY_Model {
    
    protected $primary_key = 'fees_structure_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $fees
     * @return array
     */
    protected function timestamps($fees) {
        $fees['created_at'] = date('Y-m-d H:i:s');        
        return $fees;
    }
    
    
      ///// Fees Structure /////
    /**
     * Get all fees structure
     * @return array
     */
    function get_all_fees_structure() {
        
        if($this->session->userdata('professor_id'))
        {
            $degree_id = $this->session->userdata('professor_department');
            $this->db->where('degree_id', $degree_id);
            $this->db->or_where('degree_id ', 'All'); 
        }
        return $this->db->select()
                        ->from('fees_structure')                      
                        ->get()
                        ->result();
    }
    
    
     /**
     * Fee structure filter
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semeter
     * @return mixed
     */
    function fee_structure_filter($degree, $course, $batch, $semeter) {
        return $this->db->select()
                        ->from('fees_structure')
                        ->join('course', 'course.course_id = fees_structure.course_id')
                        ->join('semester', 'semester.s_id = fees_structure.sem_id')
                        ->join('batch', 'batch.b_id = fees_structure.batch_id')
                        ->join('degree', 'degree.d_id = fees_structure.degree_id')
                        ->where(array(
                            'fees_structure.degree_id' => $degree,
                            'fees_structure.course_id' => $course,
                            'fees_structure.batch_id' => $batch,
                            'fees_structure.sem_id' => $semeter
                        ))->order_by('created_at', 'DESC')
                        ->get()
                        ->result();
    }
    
     /**
     * Student paid fees 
     * @param int $fees_structure_id
     * @param int $student_id
     * @return array
     */
    function student_paid_fees($fees_structure_id, $student_id) {
        return $this->db->select('*')
                        ->from('student_fees')
                        ->join('fees_structure', 'fees_structure.fees_structure_id = student_fees.fees_structure_id', 'left')
                        ->where(array(
                            'fees_structure.fees_structure_id' => $fees_structure_id,
                            'student_fees.student_id' => $student_id
                        ))
                        ->get()
                        ->result();
    }
    
    function  paid_student_fees($fees_structure_id,$stdid)
    {
        $this->db->where('student_id',$stdid);
        $this->db->where('fees_structure_id',$fees_structure_id);
        return $this->db->get('student_fees')->result();
    }

}
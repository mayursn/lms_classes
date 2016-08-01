<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student_fees_model extends MY_Model {
    
    protected $primary_key = 'student_fees_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $fees
     * @return array
     */
    protected function timestamps($fees) {
        $fees['paid_created_at'] = date('Y-m-d H:i:s');        
        return $fees;
    }
    
    /**
     * Student fees record
     * @param int $student_id
     * @return array
     */
    function fees_record($student_id) {
        return $this->db->select()
                        ->from('student_fees')
                        ->join('course', 'course.course_id = student_fees.course_id')
                        ->join('fees_structure', 'fees_structure.fees_structure_id = student_fees.fees_structure_id')
                        ->join('semester', 'semester.s_id = student_fees.sem_id')
                        ->where('student_fees.student_id', $student_id)
                        ->order_by('student_fees.paid_created_at', 'DESC')
                        ->get()
                        ->result();
    }
    
    /**
     * Invoice details
     * @param int $id
     * @return object
     */
    function invoice_detail($id) {
        return $this->db->select('*')
                        ->from('student_fees')
                        ->join('fees_structure', 'fees_structure.fees_structure_id = student_fees.fees_structure_id')
                        ->join('student', 'student.std_id = student_fees.student_id')
                        ->where('student_fees_id', $id)
                        ->get()
                        ->row();
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
    
    
      /**
     * All student fees details
     */
    function all_student_fees() {
        return $this->db->select()
                        ->from('student_fees')
                        ->join('fees_structure', 'fees_structure.fees_structure_id = student_fees.fees_structure_id')
                        ->join('student', 'student.std_id = student_fees.student_id')
                        ->join('course', 'course.course_id = student_fees.course_id')
                        ->join('semester', 'semester.s_id = student_fees.sem_id')
                        ->join('degree', 'degree.d_id = student.std_degree')
                        ->join('batch', 'batch.b_id = student.std_batch')
                        ->order_by('paid_created_at', 'DESC')
                        ->get()
                        ->result();
    }
    
     /**
     * Make payment student list
     * @param int $degree
     * @param int $course
     * @param int $batch
     * @param int $semester
     * @param int $fee_structure
     * @return mixed
     */
    function make_payment_student_list($degree, $course, $batch, $semester, $fee_structure) {
        return $this->db->select()
                        ->from('student_fees')
                        ->join('student', 'student.std_id = student_fees.student_id')
                        ->join('degree', 'degree.d_id = student.std_degree')
                        ->join('course', 'course.course_id = student_fees.course_id')
                        ->join('batch', 'batch.b_id = student.std_batch')
                        ->join('semester', 'semester.s_id = student_fees.sem_id')
                        ->where([
                            'student_fees.course_id' => $course,
                            'student_fees.sem_id' => $semester,
                            'student_fees.fees_structure_id' => $fee_structure,
                            'student.std_degree' => $degree,
                            'student.std_batch' => $batch
                        ])->get()->result();
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
        $where1 = "fees_structure.degree_id='$degree' OR fees_structure.degree_id='All'";
        $where2 = "fees_structure.course_id='$course' OR fees_structure.course_id='All'";
        $where3 = "fees_structure.batch_id='$batch' OR fees_structure.batch_id='All'";
        $where4 = "fees_structure.sem_id='$semeter' OR fees_structure.sem_id='All'";

        return $this->db->select()
                        ->from('fees_structure')
                        ->join('course', 'course.course_id = fees_structure.course_id')
                        ->join('semester', 'semester.s_id = fees_structure.sem_id')
                        ->join('batch', 'batch.b_id = fees_structure.batch_id')
                        ->join('degree', 'degree.d_id = fees_structure.degree_id')
                        ->where($where1)
                        ->where($where2)
                        ->where($where3)
                        ->where($where4)
                        ->order_by('created_at', 'DESC')
                        ->get()
                        ->result();
    }

}
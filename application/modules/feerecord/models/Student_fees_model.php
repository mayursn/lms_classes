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
                        ->join('admission_plan', 'admission_plan.admission_plan_id = student_fees.admission_plan_id')
                        ->join('branch_location', 'branch_location.branch_id = student_fees.branch_id')
                        ->join('course', 'course.course_id = student_fees.course_id')
                        ->join('fees_structure', 'fees_structure.fees_structure_id = student_fees.fees_structure_id')
                        ->join('class', 'class.class_id = student_fees.class_id')
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
                        ->join('branch_location', 'branch_location.branch_id = student_fees.branch_id')
                        ->join('admission_plan', 'admission_plan.admission_plan_id = student.admission_plan_id')
                        ->join('class', 'class.class_id = student.class_id')
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
    function make_payment_student_list($branch, $course, $admission_plan, $class, $fee_structure) {
        return $this->db->select()
                        ->from('student_fees')
                        ->join('student', 'student.std_id = student_fees.student_id')
                        ->join('branch_location', 'branch_location.branch_id = student.branch_id')
                        ->join('course', 'course.course_id = student_fees.course_id')
                        ->join('admission_plan', 'admission_plan.admission_plan_id = student.admission_plan_id')
                        ->join('class', 'class.class_id = student_fees.class_id')
                        ->where([
                            'student_fees.course_id' => $course,
                            'student_fees.class_id' => $class,
                            'student_fees.fees_structure_id' => $fee_structure,
                            'student.branch_id' => $branch,
                            'student.admission_plan_id' => $admission_plan
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
    function fee_structure_filter($branch, $course, $admission_plan, $class) {
        $where1 = "fees_structure.branch_id='$branch'";
        $where2 = "fees_structure.course_id='$course'";
        $where3 = "fees_structure.admission_plan_id='$admission_plan'";
        $where4 = "fees_structure.class_id='$class'";

        return $this->db->select()
                        ->from('fees_structure')
                        ->join('course', 'course.course_id = fees_structure.course_id')
                        ->join('branch_location', 'branch_location.branch_id = fees_structure.branch_id')
                        ->join('admission_plan', 'admission_plan.admission_plan_id = fees_structure.admission_plan_id')
                        ->join('class', 'class.class_id = fees_structure.class_id')
                        ->where($where1)
                        ->where($where2)
                        ->where($where3)
                        ->where($where4)
                        ->order_by('created_at', 'DESC')
                        ->get()
                        ->result();
    }
    
    function get_fees_list($student_detail)
    {
        $this->db->where('course_id',$student_detail->course_id);
        $this->db->where('branch_id',$student_detail->branch_id);
        $this->db->where('class_id',$student_detail->class_id);
        $this->db->where('admission_plan_id',$student_detail->admission_plan_id);
        return $this->db->get('fees_structure')->result();
        
    }

}
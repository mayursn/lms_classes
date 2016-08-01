<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_time_table_model extends MY_Model {
    
    protected $primary_key = 'exam_time_table_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $exam
     * @return array
     */
    protected function timestamps($exam) {
        $exam['created_at'] = date('Y-m-d H:i:s');        
        return $exam;
    }
    
    //// Exam time table /////
    /**
     * Get time table list
     * @return array
     */
    function time_table() {
        return $this->db->select()
                        ->from('exam_time_table')
                        ->join('exam_manager', 'exam_manager.em_id = exam_time_table.exam_id')
                        ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('batch', 'batch.b_id = exam_time_table.batch_id')
                        ->join('degree', 'degree.d_id = exam_time_table.degree_id')
                        ->order_by('em_date', 'DESC')
                        ->get()
                        ->result();
    }
    
      /**
     * Get all exam types
     * @return array
     */
    function get_all_exam_type() {
        return $this->db->select('exam_type_id, exam_type_name, status')
                        ->from('exam_type')
                        ->where('status', 1)
                        ->get()
                        ->result();
    }
    
     /**
     * Check exam duplication
     * @param int $degree
     * @param int $course
     * @param int $batch
     * @param int $sem
     * @param string $title
     * @return object
     */
    function exam_duplication_check($degree, $course, $batch, $sem, $title) {
        return $this->db->get_where('exam_manager', array(
                    'degree_id' => $degree,
                    'course_id' => $course,
                    'batch_id' => $batch,
                    'em_semester' => $sem,
                    'em_name' => $title
                ))->row();
    }
    
    function get_exam_details($param2)
    {
    
return $this->db->select('exam_manager.*, exam_type.*, course.*, semester.*')
        ->from('exam_manager')
        ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
        ->join('course', 'course.course_id = exam_manager.course_id')
        ->join('semester', 'semester.s_id = exam_manager.em_semester')
        ->where('exam_manager.em_id', $param2)
        ->get()
        ->row();
    }
    
    /**
     * Get filter exam
     * @param type $degree
     * @param type $course
     * @param type $batch
     * @param type $semester
     * @return type
     */
    function get_exam_filter($degree, $course, $batch, $semester) {
        return $this->db->select('exam_manager.*, exam_type.*, course.*, semester.*, batch.*, degree.*')
                        ->from('exam_manager')
                        ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('batch', 'batch.b_id = exam_manager.batch_id')
                        ->join('degree', 'degree.d_id = exam_manager.degree_id')
                        ->where(array(
                            'exam_manager.degree_id' => $degree,
                            'exam_manager.course_id' => $course,
                            'exam_manager.batch_id' => $batch,
                            'exam_manager.em_semester' => $semester
                        ))
                        ->order_by('em_date', 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * Time table duplication
     * @param int $exam
     * @param int $subject
     * @return object
     */
    function exam_time_table_duplication($exam, $subject) {
        return $this->db->get_where('exam_time_table', array(
                    'exam_id' => $exam,
                    'subject_id' => $subject
                ))->row();
    }
    
    function get_exam_listing($student_details)
    {
      return  $this->db->select()
                ->from('exam_manager')
                ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
                ->join('semester', 'semester.s_id = exam_manager.em_semester')
                ->where(array(
                    'exam_manager.course_id' => $student_details->course_id,
                    'exam_manager.em_semester' => $student_details->semester_id,
                    'exam_manager.exam_ref_name' => 'reguler'
                ))
                ->order_by('exam_manager.em_start_time', 'DESC')
                ->get()
                ->result();
    }
    
    function get_exam_subject_details($exam)
    {
       return $this->db->select()
                    ->from('exam_time_table')
                    ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
                    ->where('exam_time_table.exam_id', $exam->em_id)
                    ->get()
                    ->result();
    }
    
    function get_marks_subject($student_id,$exam)
    {
        return $this->db->select()
                    ->from('marks_manager')
                    ->join('subject_manager', 'subject_manager.sm_id = marks_manager.mm_subject_id')
                    ->where(array(
                        'mm_std_id' => $student_id,
                        'mm_exam_id' => $exam->em_id
                    ))
                    ->get()
                    ->result();
    }
    
    function get_exam_type_marks($exam)
    {
       return  $this->db->select()
                        ->from('exam_manager')
                        ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->where(array(
                            'exam_manager.exam_ref_id' => $exam->em_id
                        ))
                        ->order_by('exam_manager.em_start_time', 'DESC')
                        ->get()
                        ->result();
    }
    /**
     * Exam details
     * @param int $exam_id
     * @return object
     */
    function exam_detail($exam_id) {
        return $this->db->select()
                        ->from('exam_manager')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('exam_seat_no', 'exam_seat_no.exam_id = exam_manager.em_id')
                        ->where('em_id', $exam_id)
                        ->where('exam_seat_no.student_id', $this->session->userdata('std_id'))
                        ->get()
                        ->row();
    }
    
     /**
     * Exam schedule
     * @param int $exam_id
     * @return array
     */
    function exam_schedule($exam_id) {
        return $this->db->select()
                        ->from('exam_time_table')
                        ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
                        ->where('exam_time_table.exam_id', $exam_id)
                        ->get()
                        ->result();
    }
    
     /**
     * Exam schedule filter
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     * @param string $exam
     * @return mixed
     */
    function exam_schedule_filter($degree, $course, $batch, $semester, $exam) {
        return $this->db->select()
                        ->from('exam_time_table')
                        ->join('exam_manager', 'exam_manager.em_id = exam_time_table.exam_id')
                        ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('batch', 'batch.b_id = exam_time_table.batch_id')
                        ->join('degree', 'degree.d_id = exam_time_table.degree_id')
                        ->where(array(
                            'exam_time_table.degree_id' => $degree,
                            'exam_time_table.course_id' => $course,
                            'exam_time_table.batch_id' => $batch,
                            'exam_time_table.semester_id' => $semester,
                            'exam_time_table.exam_id' => $exam
                        ))
                        ->order_by('em_date', 'DESC')
                        ->get()
                        ->result();
    }

}
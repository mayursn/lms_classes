<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends MY_Model {

    protected $primary_key = 'std_id';
    public $belongs_to = array('user');

    public $before_create = array('timestamps');

    /**
     * Set the timestamp fields
     * @param array $student
     * @return array
     */
    protected function timestamps($student) {
        $student['created_date'] = date('Y-m-d H:i:s');

        return $student;
    }
    
     function student_details($student_id) {
        return $this->db->select('student.*,u.*, student.created_date AS Joining_date,b.*,c.*,ap.*')
                        ->from('student')
                        ->join('user u', 'u.user_id = student.user_id')                        
                        ->join('branch_location b', 'b.branch_id = student.branch_id')                        
                        ->join('course c', 'c.course_id = student.course_id')                        
                        ->join('admission_plan ap', 'ap.admission_plan_id = student.admission_plan_id')                        
                        ->where('student.std_id', $student_id)
                        ->get()
                        ->row();
    }
    
    function get_classes_student_list(){
        
        
        $this->db->join('user u','s.user_id=u.user_id');
        return $this->db->get('student s')->result();
    }
     /**
     * Student list from degree, course, batch, and semester
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     * @return mixed
     */
    function student_list_from_degree_course_batch_semester($degree, $course, $batch, $semester) {
        return $this->db->get_where('student', array(
                    'std_degree' => $degree,
                    'course_id' => $course,
                    'std_batch' => $batch,
                    'semester_id' => $semester
                ))->result();
    }
    
    function submitassignment($id)
    {
        $this->db->select('s.*,a.*');
        $this->db->where('s.student_id',$id);
       $this->db->from('assignment_submission s');
       $this->db->join('assignment_manager a', 'a.assign_id=s.assign_id');                       
       return $this->db->get()->result();
    }
    /**
     * studen to do list
     * @return mixed
     */
    function get_todo()
    {
        $date = date('Y-m-d');
        $date = date('Y-m-d', strtotime('-6 days', strtotime($date)));        
        $login_type = $this->session->userdata("role_name");
        $login_id = $this->session->userdata("std_id");
        $this->db->select('todo_id,todo_title,todo_datetime,todo_status');
        $this->db->where("todo_role",$login_type);
        $this->db->where("todo_role_id",$login_id);
        $this->db->where('todo_datetime >= ', $date);
        $this->db->order_by("todo_datetime","asc");
        return $this->db->get("todo_list")->result();
        
    }
    
    function get_timline_todolist()
    {
        $this->db->select('todo_id,todo_title,todo_datetime');
        return $this->db->get_where('todo_list',array('todo_role'=>'student','user_role_id'=>$this->session->userdata('user_id')))->result();
      //  return $this->db->get_where('todo_list',array('todo_datetime >='=> date('Y-m-d H:m:s'),'todo_role'=>'student','todo_role_id'=>$this->session->userdata('student_id')))->result();
    }
    function get_timline_event()
    {
        $this->db->select('event_id,event_name,event_date');
        return $this->db->get('event_manager')->result();
        //return $this->db->get_where('event_manager',array('event_date >='=> date('Y-m-d H:m:s')))->result();
    }
    
     function get_timeline_date_count()
    {
        $todolist=$this->db->query('SELECT DISTINCT date(todo_datetime) from todo_list where todo_datetime >= "'.date('Y-m-d').'"')->result();
        $event=$this->db->query('SELECT DISTINCT date(event_date) from event_manager where event_date >= "'.date('Y-m-d').'"')->result();
        
        foreach ($todolist as $todo) {
            foreach ($todo as $row) {               
                $data[]=$row;
            }
        }
         foreach ($event as $ev) {
            foreach ($ev as $row) {               
                $data[]=$row;
            }
        }
       
        
        $result=  array_unique($data);
        return $result;
//        if(count($todolist)>count($event))
//        {
//            return $todolist;
//        }
//        else
//        {
//            return $event;
//        }
    }
    
     /**
     * 
     * @param int $user_id
     * @return mixed
     */
    function get_growth($user_id)
    {
        
        //return $this->db->query("SELECT SUM(marks_manager.mark_obtained) as total, SUM(exam_manager.total_marks) as totalmarks,marks_manager.mm_std_id,semester.s_name FROM  marks_manager JOIN exam_manager ON marks_manager.mm_exam_id = exam_manager.em_id JOIN semester ON exam_manager.em_semester=semester.s_id WHERE marks_manager.mm_std_id='".$user_id."' GROUP BY exam_manager.em_semester")->result();            
      return $this->db->query("SELECT SUM(marks_manager.mark_obtained) as total, SUM(exam_manager.total_marks) as totalmarks,marks_manager.mm_std_id FROM  marks_manager JOIN exam_manager ON marks_manager.mm_exam_id = exam_manager.em_id  WHERE marks_manager.mm_std_id='".$user_id."'")->result();         
      
        
    }
    
    /**
     * Student bacth and course details
     * @param int $student_id
     * @return object
     */
    function student_batch_course_detail($student_id) {
        return $this->db->select()
                        ->from('batch')
                        ->join('student', 'student.std_batch = batch.b_id')
                        ->join('course', 'course.course_id = student.course_id')
                        ->where('student.std_id', $student_id)
                        ->get()
                        ->row();
    }
    
    
    /**
     * Students exam marks
     * @param int $student_id
     * @param int $exam_id
     * @return array
     */
    function student_marks($student_id, $exam_id) {
        return $this->db->select()
                        ->from('marks_manager')
                        ->join('subject_manager', 'subject_manager.sm_id = marks_manager.mm_subject_id')
                        ->where(array(
                            'mm_std_id' => $student_id,
                            'mm_exam_id' => $exam_id
                        ))
                        ->get()
                        ->result();
    }
    
     /**
     * Student exam list
     * @param string $course
     * @param string $semeseter
     * @return array
     */
    function student_exam_list($course, $admission_plan,$branch) {
        return $this->db->select()
                        ->from('exam_manager')
                        ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
                        ->join('admission_plan', 'admission_plan.admission_plan_id = exam_manager.admission_plan_id')
                        ->where(array(
                            'exam_manager.course_id' => $course,
                            'exam_manager.admission_plan_id' => $admission_plan,
                            'exam_manager.branch_id' => $branch,
                            'exam_manager.exam_ref_name' => 'reguler'
                        ))
                        ->order_by('exam_manager.em_start_time', 'DESC')
                        ->get()
                        ->result();
    }
    
    
    
    function get_student_optimize()
    {
        return  $student = $this->db->select('std_id, std_first_name, std_last_name')->from('student')->get()->result();
    }
    
    /**
     * get student details
     * @param int $std_id
     */
    function get_student_by_id($std_id)
    {
     
                                     $this->db->join('degree', 'degree.d_id=student.std_degree');
                                     $this->db->join('semester', 'semester.s_id=student.semester_id');
                                     $this->db->join('batch', 'batch.b_id=student.std_batch');
                                     $this->db->join('course', 'course.course_id=student.course_id');
                                     $this->db->select('student.std_id, student.std_roll, student.name, degree.d_name, course.c_name, batch.b_name, semester.s_name,student.std_first_name,student.std_last_name');
                                     $this->db->from('student');
                                 
                                     $this->db->where('std_id', $std_id);
                                  return   $this->db->get()->row();
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
    
    function total_class_of_subject($subject, $student) {
       return   $this->db->select()
                ->from('attendance')
                ->join('class_routine', 'class_routine.ClassRoutineId = attendance.class_routine_id')
                ->where([
                    'attendance.student_id' => $student,
                    'class_routine.SubjectID' => $subject
                ])->get()->num_rows();
        
    }
    
    function total_present_class_of_subject($subject, $student) {
        return $this->db->select()
                ->from('attendance')
                ->join('class_routine', 'class_routine.ClassRoutineId = attendance.class_routine_id')
                ->where([
                    'attendance.student_id' => $student,
                    'class_routine.SubjectID' => $subject,
                    'is_present'    => 1
                ])->get()->num_rows();
    }
    
    function attendance_detail_report($student, $subject) {
         return $this->db->select()
                ->from('attendance')
                ->join('class_routine', 'class_routine.ClassRoutineId = attendance.class_routine_id')
                ->where([
                    'class_routine.SubjectID' => $subject,
                    'attendance.student_id'    => $student
                ])->order_by('date_taken', 'DESC')->get()->result();
       
    }
    function student_only_info($id) {
        return $this->db->select()
                ->from('student')
                ->where([
                    'std_id'    => $id
                ])->get()->row();
    }
    
    /**
     * Student subject list
     * @param string $branch
     * @param string $sem
     * @return mixed
     */
    function student_subject_list($branch, $sem) {
        return  $this->db->select()
                ->from('subject_manager sm')
                ->join('subject_association sa','sa.sm_id=sm.sm_id')                
                ->where([
                    'sa.course_id'  => $branch,
                    'sa.sem_id' => $sem
                ])->get()->result();
         
        
       
        
    }
    
    function get_student_subject_attendance($branch,$course,$admission_plan,$class){
        $this->db->join('subject_manager sm','sm.sm_id=sa.sm_id');
        $this->db->where('sa.branch_id',$branch);
        $this->db->where('sm.course_id',$course);
        $this->db->where('sa.admission_plan_id',$admission_plan);
        return $this->db->get('subject_association sa')->result();        
        
    }
    
    
    /**
     * Student class routine information
     * @param string $degree
     * @param string $branch
     * @param string $batch
     * @param string $semester
     * @param string $class
     * @return mixed
     */
    function student_class_routine($degree, $branch, $batch, $semester, $class) {
        return $this->db->get_where('class_routine', [
                    'DepartmentID' => $degree,
                    'BranchID' => $branch,
                    'BatchID' => $batch,
                    'SemesterID' => $semester,
                    'ClassID' => $class
                ])->result();
    }
    
    /**
     * Student exam detail 29-07-2016
     * @param int $student_id
     * @param int $exam_id
     * @return mixed array
     */
     function student_exam_detail($student_id,$exam_id) {
        return $this->db->select()
                        ->from('exam_manager')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('exam_seat_no', 'exam_seat_no.exam_id = exam_manager.em_id')
                        ->where('em_id', $exam_id)
                        ->where('exam_seat_no.student_id',$student_id)
                        ->get()
                        ->row();
    }
    
    /**
     * student total class 29-07-2016
     * @param int $branch
     * @param int $course
     * @param int $admission_plan
     * @param int $class
     * @param int $sm_id
     * @param int $std_id
     * @return mixed array
     */
    function get_student_total_class($branch,$course,$admission_plan,$class,$sm_id,$std_id)
    {
                       $this->db->select();                
                        $this->db->where('branch_id',$branch);
                       $this->db->where("course_id",$course);
                       $this->db->where("admission_plan_id",$admission_plan);
                       $this->db->where("class_id",$class);
                       $this->db->where("sm_id",$sm_id);
                       $this->db->where('student_id',$std_id);
                       return  $this->db->get('attendance')->result();
    }
    
    /**
     * student present count 29-07-2016
     * @param int $branch
     * @param int $course
     * @param int $admission_plan
     * @param int $class
     * @param int $sm_id
     * @param int $std_id
     * @return mixed array
     */
    function get_present_class_student($branch,$course,$admission_plan,$class,$sm_id,$std_id)
    {
                      $this->db->select();                
                        $this->db->where('branch_id',$branch);
                       $this->db->where("course_id",$course);
                       $this->db->where("admission_plan_id",$admission_plan);
                       $this->db->where("class_id",$class);
                       $this->db->where("sm_id",$sm_id);
                       $this->db->where('student_id',$std_id);
                       $this->db->where('is_present','1');
                       return  $this->db->get('attendance')->result();
    }

    
    function student_attendance_detail($branch,$course,$admission_plan,$class,$std_id,$sm_id)
    {
                     $this->db->select();                
                        $this->db->where('branch_id',$branch);
                       $this->db->where("course_id",$course);
                       $this->db->where("admission_plan_id",$admission_plan);
                       $this->db->where("class_id",$class);
                       $this->db->where("sm_id",$sm_id);
                       $this->db->where('student_id',$std_id);                       
                       return  $this->db->get('attendance')->result();
    }
}

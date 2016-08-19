<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('attendance/Attendance_model');
        $this->load->model('department/Degree_model');
        $this->load->model('courses/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('student/Student_model');
        $this->load->model('professor/Professor_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
      
    }

    function index() {
        $this->load->model('branch/Branch_location_model');
        $this->load->model('courses/Course_model');
        $this->load->model('admission_plan/Admission_plan_model');
        $this->load->model('subject/Subject_manager_model');
         $this->data['course'] = '';
        $this->data['branch'] = '';
        $this->data['admission_plan'] = '';
        $this->data['class'] = '';
        $this->data['class_name'] = '';
        $this->data['professor'] = '';
        $this->data['class_routine'] = '';
        $this->data['date'] = '';
        $this->data['student'] = array();
        //$this->data['professor_class_routine_list'] = array();
        if ($_POST) {
            $this->data['title'] = 'Attendance';
            $this->data['page'] = 'attendance'; 
            $this->data['student'] = $this->get_student_list($_POST);
            $this->data['date'] = $_POST['date'];
            $this->data['branch'] = $this->Branch_location_model->order_by_column('branch_name');
            $this->data['branch_name'] = $this->Branch_location_model->get($_POST['branch']);
            $this->data['course_name'] = $this->Course_model->get($_POST['course']);
            $this->data['course'] = $this->Course_model->order_by_column('c_name');
            $this->data['class'] = $this->Class_model->order_by_column('class_name');
            $this->data['class_name'] = $this->Class_model->get($_POST['class']);
            $this->data['admission_plan'] = $this->Admission_plan_model->order_by_column('admission_duration');            
            $this->data['subject'] = $this->Subject_manager_model->order_by_column('subject_name');            
            $this->data['subject_name'] = $this->Subject_manager_model->get($_POST['subject']);            
            $this->data['admission_duration'] = $this->Admission_plan_model->get($_POST['admission_plan']);            
            $this->__template('attendance/attendance', $this->data);
           die;
        }
        $this->data['title'] = 'Attendance';
        $this->data['page'] = 'attendance';                
        $this->data['branch'] = $this->Branch_location_model->order_by_column('branch_name');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['admission_plan'] = $this->Admission_plan_model->order_by_column('admission_duration');
        $this->data['class'] = $this->Class_model->order_by_column('class_name');
      //  $this->data['professor_class_routine_list'] = '';
         $this->__template('attendance/index', $this->data);
    }
    
    function get_student_list($post)
    {
        $branch = $post['branch'];
        $course = $post['course'];
        $admission_plan = $post['admission_plan'];
        $class = $post['class'];
        return $this->Student_model->get_many_by(array(
            'branch_id' => $branch,
            'course_id' => $course,
            'class_id' => $class,
            'admission_plan_id' => $admission_plan));
        
        
    }
    /**
     * Submit student class routine attendance
     */
    function take_class_routine_attendance() {
        if ($_POST) {
           
            
            $this->load->model('admin/Crud_model');
            $student = $this->Student_model->get_many_by(array(
                    'branch_id' => $_POST['branch'],
                    'course_id' => $_POST['course'],
                    'admission_plan_id' => $_POST['admission_plan'],                    
                    'class_id' => $_POST['class']
                ));                    
            foreach ($student as $row) {
               
                $date = date('Y-m-d', strtotime($_POST['date']));
                
                
                
                $status = $this->Attendance_model->get_attendance_status($_POST['branch'],$_POST['course'],
                                                $_POST['admission_plan'],$_POST['class'],$date,$row->std_id,$_POST['subject']);
                                                
                //check for existing attendnace
                if ($status) {
                    //update existing attendance of the student
                    if (isset($_POST['student_' . $status->student_id])) {
                        //present
                        $update['is_present'] = 1;
                    } else {
                        //absent
                        $update['is_present'] = 0;
                    }
                    $this->Attendance_model->save_student_attendance($update, $status->attendance_id);
                } else {
                    $save = array(
                        'course_id' => $_POST['course'],
                        'branch_id' => $_POST['branch'],
                        'admission_plan_id' => $_POST['admission_plan'],                        
                        'class_id' => $_POST['class'],                                                
                        'date_taken' => $date,
                        'sm_id'=>$_POST['subject']
                    );
                    if (isset($_POST['student_' . $row->std_id])) {
                        //present student
                        $save['student_id'] = $row->std_id;
                        $save['is_present'] = 1;
                    } else {
                        //absent student
                        $save['student_id'] = $row->std_id;
                        $save['is_present'] = 0;
                    }
                    $this->Attendance_model->save_student_attendance($save);
                }
            }
        }
        $this->session->set_flashdata('flash_message', 'Attendance is successfully updated.');
        redirect(base_url('attendance'));
    }


    function professor_date_wise_class_routine($id, $date) {
        date_default_timezone_set('Etc/UTC');
        $attendance_data = array();
        require 'vendor/autoload.php';
        $this->load->library('Class_routine_attendance');
        $this->load->model('Crud_model');
        if ($_POST) {
            $class_routine = $this->Attendance_model->professor_class_routine_attendance($id, $date);
            $attendance_routine = array();
            $selected_date = date('Y-m-d', strtotime($date));
            foreach ($class_routine as $row) {
                if ($row->RecurrenceRule) {
                    //parse reccurrence rule
                    $rule = $this->class_routine_attendance->parse_reccurrence_rule($row->RecurrenceRule);
                    $rule_array = array();
                    $reccur_rule = '';
                    foreach ($rule as $key => $value) {
                        $separate_rule = explode('=>', $value);
                        $reccur_rule .= "'$separate_rule[0]' => '$separate_rule[1]'" . ';';
                    }
                    $conditional_rules = $this->class_routine_attendance->conditional_reccurrence_rule($reccur_rule);
                    $conditional_rules['DTSTART'] = $row->Start;
                    $rrule = new RRule\RRule($conditional_rules);
                    foreach ($rrule as $occurrence) {
                        if ($occurrence->format('Y-m-d') == $selected_date) {
                            array_push($attendance_routine, $row);
                            //echo $occurrence->format('Y-m-d');
                            break;
                        }
                        //break;
                    }
                } else {
                    //single schedule event
                    array_push($attendance_routine, $row);
                }
            }
        }

        foreach ($attendance_routine as $row) {
            array_push($attendance_data, $row);
        }

        return $attendance_routine;
    }
    
    
    function take_attedance($class_routine_id, $date) {
        $this->load->model('admin/Crud_model');
        $this->data['title'] = 'Class Routine Attendance';
        $this->data['page'] = 'attendance';
        $this->data['class_routine_details'] = $this->Attendance_model->class_routine_details($class_routine_id);
        $this->data['department'] = $this->data['class_routine_details']->DepartmentID;
        $this->data['branch'] = $this->data['class_routine_details']->BranchID;
        $this->data['batch'] = $this->data['class_routine_details']->BatchID;
        $this->data['semester'] = $this->data['class_routine_details']->SemesterID;
        $this->data['class_name'] = $this->data['class_routine_details']->ClassID;
        $this->data['professor'] = $this->data['class_routine_details']->ProfessorID;
        $this->data['class_routine'] = $this->data['class_routine_details']->ClassRoutineId;
        $this->data['date'] = $date;
        
        $this->data['department_name'] = $this->data['class_routine_details']->d_name;
        $this->data['branch_name'] = $this->data['class_routine_details']->c_name;
        $this->data['semester_name'] = $this->data['class_routine_details']->s_name;
        $this->data['class_name_detail'] = $this->data['class_routine_details']->class_name;
        $this->data['subject_name'] = $this->data['class_routine_details']->subject_name;
        $this->data['start_time'] = $this->data['class_routine_details']->Start;
        $this->data['end_time'] = $this->data['class_routine_details']->End;
        
        if ($this->data['class_routine_details']) {
                    $department_id = $this->data['class_routine_details']->DepartmentID;
                    $branch_id = $this->data['class_routine_details']->BranchID; 
                    $batch_id = $this->data['class_routine_details']->BatchID; 
                    $semester_id = $this->data['class_routine_details']->SemesterID;
                    $class_id = $this->data['class_routine_details']->ClassID;
            $this->data['student'] = $student = $this->Student_model->get_many_by(array(
                    'std_degree' => $department_id,
                    'course_id' => $branch_id,
                    'std_batch' => $batch_id,
                    'semester_id' => $semester_id,
                    'class_id' => $class_id
                ));
            
        }
        $this->__template('attendance/attendance', $this->data);
    }

    function class_routine()
    {
        $this->load->model('branch/Branch_location_model');
        $this->load->model('courses/course_model');
        $this->load->model('classes/Class_model');
        $this->load->model('admission_plan/Admission_plan_model');
        $this->load->model('subject/Subject_manager_model');
        
        if($_POST)
        {
            $this->data['branch'] = $this->Branch_location_model->order_by_column('branch_name');
            $this->data['branch_name'] = $this->Branch_location_model->get($_POST['branch']);
            $this->data['course_name'] = $this->Course_model->get($_POST['course']);
            $this->data['course'] = $this->Course_model->order_by_column('c_name');
            $this->data['class'] = $this->Class_model->order_by_column('class_name');
            $this->data['class_name'] = $this->Class_model->get($_POST['class']);
            $this->data['admission_plan'] = $this->Admission_plan_model->order_by_column('admission_duration');            
            $this->data['subject'] = $this->Subject_manager_model->order_by_column('subject_name');            
            $this->data['subject_name'] = $this->Subject_manager_model->get($_POST['subject']);            
            $this->data['admission_duration'] = $this->Admission_plan_model->get($_POST['admission_plan']);            
             $this->data['date'] = $_POST['date'];
            $branch = $_POST['branch'];
            $this->data['branch_id'] = $_POST['branch'];
            
            $course = $_POST['course'];
            $this->data['course_id'] = $_POST['course'];
            $admission_plan = $_POST['admission_plan'];
            $this->data['admission_plan_id'] = $admission_plan;
            $class = $_POST['class'];
            $this->data['class_id'] = $class;
            $subject = $_POST['subject'];
            $this->data['subject_id'] = $subject;
            $date = $_POST['date'];
            $this->data['date_id'] = $date;
            $this->data['page'] = 'attendance';
            $this->data['title'] = 'Attendance';
        //$this->db->join('branch_location','branch_location.branch_id=attendance.branch_id');
                                        //$this->db->join('course','course.course_id=attendance.course_id');
                                        //$this->db->join('admission_plan','admission_plan.admission_plan_id=attendance.admission_plan_id');
                                        //$this->db->join('class','class.class_id=attendance.class_id');
                                        //$this->db->join('subject_manager','subject_manager.sm_id=attendance.sm_id');
                                        
                                         $this->db->select();
                                         $this->db->join('course','course.course_id=attendance.course_id');
                                         $this->db->join('branch_location','branch_location.branch_id=attendance.branch_id');
                                         $this->db->join('admission_plan','admission_plan.admission_plan_id=attendance.admission_plan_id');
                                         $this->db->join('subject_manager','attendance.sm_id=subject_manager.sm_id');
                                         $this->db->join('class','class.class_id=attendance.class_id');
                                         $this->db->join('student','student.std_id=attendance.student_id');
                               $this->data['attendance'] =    $this->db->get_where('attendance',array("attendance.branch_id"=>$branch,
                                            "attendance.course_id"=>$course,
                                            "attendance.admission_plan_id"=>$admission_plan,
                                            "attendance.sm_id"=>$subject,
                                            "attendance.class_id"=>$class,
                                            'attendance.date_taken'=>$date
                                            ))->result(); 
                                
        $this->__template('attendance/attendance_std_list', $this->data);
        }
    }
    
    function get_date_list($branch='',$course='',$admission_plan,$subject,$class_name)
    {
        $this->db->order_by('attendance_id','DESC');
        $this->db->group_by('date_taken');
        $dates = $this->db->get_where('attendance',array("branch_id"=>$branch,
                    "course_id"=>$course,
                    "admission_plan_id"=>$admission_plan,
                    "sm_id"=>$subject,
                    "class_id"=>$class_name  
                    ))->result();
        
        echo json_encode($dates);
        
    }
}

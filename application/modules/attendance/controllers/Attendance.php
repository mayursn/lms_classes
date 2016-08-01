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
        $this->load->model('branch/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('student/Student_model');
        $this->load->model('professor/Professor_model');
      
    }

    function index() {
         $this->data['department'] = '';
        $this->data['branch'] = '';
        $this->data['batch'] = '';
        $this->data['semester'] = '';
        $this->data['class_name'] = '';
        $this->data['professor'] = '';
        $this->data['class_routine'] = '';
        $this->data['date'] = '';
        $this->data['student'] = array();
        $this->data['professor_class_routine_list'] = array();
        if ($_POST) {
            $this->data['professor_class_routine_list'] = $this->professor_date_wise_class_routine(
                    $this->session->userdata('professor_id'), $_POST['date']);
            $this->data['date'] = $_POST['date'];
           
        }
        $this->data['title'] = 'Attendance';
        $this->data['page'] = 'attendance';        
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $this->data['class'] = $this->Class_model->order_by_column('class_name');
         $this->__template('attendance/index', $this->data);
    }
    
    /**
     * Submit student class routine attendance
     */
    function take_class_routine_attendance() {
        if ($_POST) {
            $this->load->model('admin/Crud_model');
            $student = $this->Student_model->get_many_by(array(
                    'std_degree' => $_POST['department'],
                    'course_id' => $_POST['branch'],
                    'std_batch' => $_POST['batch'],
                    'semester_id' => $_POST['semester'],
                    'class_id' => $_POST['class']
                ));                    
            foreach ($student as $row) {
                $date = date('Y-m-d', strtotime($_POST['date']));
                $status = $this->Attendance_model->get(array(
                            'department_id' => $_POST['department'],
                            'branch_id' => $_POST['branch'],
                            'batch_id' => $_POST['batch'],
                            'semester_id' => $_POST['semester'],
                            'class_id' => $_POST['class'],
                            'class_routine_id' => $_POST['class_routine'],
                            'date_taken' => $date,
                            'student_id' => $row->std_id
                        ));
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
                        'department_id' => $_POST['department'],
                        'branch_id' => $_POST['branch'],
                        'batch_id' => $_POST['batch'],
                        'semester_id' => $_POST['semester'],
                        'class_id' => $_POST['class'],
                        'professor_id' => $_POST['professor'],
                        'class_routine_id' => $_POST['class_routine'],
                        'date_taken' => $date
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

}

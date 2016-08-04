<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exam extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('exam/Exam_manager_model');
        $this->load->model('department/Degree_model');
        $this->load->model('courses/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('student/Student_model');
        $this->load->model('exam/Exam_seat_no_model');
        $this->load->model('exam/Internal_exam_model');
        $this->load->model('quiz/Quiz_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    function index() {
        $this->data['title'] = 'Exam';
        $this->data['page'] = 'exam';
        $this->load->model('branch/Branch_location_model');
        $this->load->model('courses/Course_model');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');                
        $this->data['branch'] = $this->Branch_location_model->order_by_column('branch_name');
       
        if($this->session->userdata('std_id'))
        {
         $std = $this->session->userdata('std_id');
        $student_details = $this->Student_model->get($std);
        
        $this->data['exam_listing'] = $this->Exam_manager_model->student_exam_list($student_details->branch_id, $student_details->course_id,$student_details->admission_plan_id);

        //check for time table
        $student_id = $this->session->userdata('std_id');
        foreach ($this->data['exam_listing'] as $exam) {
            $is_pass = TRUE;
            //find exam schedule
            $exam_schedule = $this->Exam_manager_model->exam_schedule($exam->em_id);

            //find marks
            $exam_marks = $this->Exam_manager_model->student_marks($student_id, $exam->em_id);

            //check for pass or fail
            foreach ($exam_marks as $mark) {
                if ($mark->mark_obtained < $exam->passing_mark) {
                    $is_pass = FALSE;
                    break;
                }
            }

          
        }
        $this->data['page'] = 'exam';
        $this->data['title'] = 'Exam';
        clear_notification('exam_manager', $this->session->userdata('std_id'));
        clear_notification('exam_time_table', $this->session->userdata('std_id'));
        unset($this->session->userdata('notifications')['exam_manager']);
        unset($this->session->userdata('notifications')['exam_time_table']);
        $this->__template('exam/exam_listing', $this->data);
        }
        else{
        $this->data['exams'] = $this->Exam_manager_model->exam_details();
      
        $this->__template('exam/index', $this->data);
          }
    }

    function create($id = '') {
        if ($_POST) {            
            //check for duplication
            $is_record_present = $this->Exam_manager_model->exam_duplication_check(
                    $_POST['branch'], $_POST['course'], $_POST['admission_plan'], $_POST['exam_name']);

            if (count($is_record_present)) {
                $this->flash_notification('Data is already present.');
                redirect(base_url() . 'exam');
            } else {
                  $data = array(
                        'em_name' => $this->input->post('exam_name', TRUE),
                        'em_type' => $this->input->post('exam_type', TRUE),
                        'total_marks' => $this->input->post('total_marks', TRUE),
                        'passing_mark' => $this->input->post('passing_marks', TRUE),
                        'em_year' => $this->input->post('year', TRUE),
                        'branch_id' => $this->input->post('branch', TRUE),
                        'course_id' => $this->input->post('course', TRUE),
                        'em_semester' => '1',                            
                        'admission_plan_id' => $this->input->post('admission_plan', TRUE),                        
                        'em_status' => $this->input->post('status', TRUE),
                        'em_date' => date('Y-m-d',  strtotime($this->input->post('date', TRUE))),
                        'em_start_time' => date('Y-m-d', strtotime($this->input->post('start_date_time', TRUE))),
                        'em_end_time' => date('Y-m-d', strtotime($this->input->post('end_date_time', TRUE))),
                        'result_type' => $this->input->post('resulttype', TRUE),
                        'exam_mode' => $this->input->post('exammode', TRUE)
                    );
                  
                   
                $this->db->insert('exam_manager',$data);
                $insert_id = $this->db->insert_id();
                $exam_mode = $this->input->post('exammode');                
                    /** end Quiz Create */
                    //$this->exam_email_notification($_POST);
                    $this->flash_notification("Exam successfully added.");

                    //create seat no
                    $seat_no_initial = chr(mt_rand(65, 90));

                    //get students
                    $students_info = $this->Student_model->get_many_by(array(
                        'branch_id' => $_POST['branch'],
                        'course_id' => $_POST['course'],
                        'admission_plan_id' => $_POST['admission_plan']
                        
                    ));



                    $seat_no = str_pad($insert_id, 4, 0, STR_PAD_RIGHT);
                    $seat_no .= mt_rand(12348, 69535);

                    //echo '<pre>';
                    foreach ($students_info as $student) {
                        //var_dump($student);
                        $seat_no++;
                        $student_seat_no = $seat_no_initial . $seat_no;
                        $this->Exam_seat_no_model->insert([
                            'student_id' => $student->std_id,
                            'exam_id' => $insert_id,
                            'seat_no' => $student_seat_no
                        ]);
                    }
                    
                $admission_plan = $_POST['admission_plan'];
                $branch = $_POST['branch'];
                $course = $_POST['course'];      
                
                $this->db->where('branch_id', $branch);                  
                $this->db->where('course_id', $course);
                $this->db->where('admission_plan_id', $admission_plan);
                
                $students = $this->db->get('student')->result();
                
                $std_id = '';
                foreach ($students as $std) {
                    $id = $std->std_id;
                    $std_id[] = $id;
                    //  $student_id = implode(",",$id);
                    // $std_ids[] =$student_id;
                }
                if ($std_id != '') {
                    $student_ids = implode(",", $std_id);
                } else {
                    $student_ids = '';
                }
                $this->db->where("notification_type", "exam_manager");
                $res = $this->db->get("notification_type")->row();
                if ($res != '') {
                    $notification_id = $res->notification_type_id;
                    $notify['notification_type_id'] = $notification_id;
                    $notify['student_ids'] = $student_ids;
                    $notify['branch_id'] = $branch;
                    $notify['course_id'] = $course;
                    $notify['admission_plan_id'] = $admission_plan;                                    
                    $notify['data_id'] = $insert_id;
                    $this->db->insert("notification", $notify);
                 
                }
                    
                    
                    //exit;
                    //create_notification('exam_manager', $_POST['branch'], $_POST['course'], $_POST['batch'], $_POST['semester'], $insert_id);
                    $this->flash_notification("Exam Successfully added.");
                        redirect(base_url('exam'));               
            }
            redirect(base_url() . 'exam');
        }
    }

    function update($param2) {
        if ($_POST) {
            
                $data = array(
                    'em_name' => $this->input->post('exam_name', TRUE),
                    'em_type' => $this->input->post('exam_type', TRUE),
                    'total_marks' => $this->input->post('total_marks', TRUE),
                    'em_year' => $this->input->post('year', TRUE),
                    'branch_id' => $this->input->post('branch', TRUE),
                    'course_id' => $this->input->post('course', TRUE),
                    'admission_plan_id' => $this->input->post('admission_plan', TRUE),
                    'em_semester' => $this->input->post('admission_plan', TRUE),
                    'em_status' => $this->input->post('status', TRUE),
                    'em_date' => date('Y-m-d',  strtotime($this->input->post('date', TRUE))),
                    'em_start_time' => date('Y-m-d', strtotime($this->input->post('start_date_time', TRUE))),
                    'em_end_time' => date('Y-m-d', strtotime($this->input->post('end_date_time', TRUE))),
                    'result_type' => $this->input->post('resulttype', TRUE),
                    'exam_mode' => $this->input->post('exammode', TRUE),
                );
                $this->Exam_manager_model->update($param2, $data);
                $exam = $this->Exam_manager_model->get($param2);
                $exam_mode = $this->input->post('exammode');               
                $this->flash_notification("Exam successfully updated");
                redirect(base_url('exam'));            
        }
    }
    
    /**
     * Exam ajax filter
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     */
    function get_exam_filter($branch, $course, $admission_plan) {
        $this->data['exams'] = $this->Exam_manager_model->get_exam_filter($branch, $course, $admission_plan);
        $this->load->view("exam/exam_filter", $this->data);
    }
    
    function delete($id='')
    {
        $this->Exam_manager_model->delete($id);
        $this->flash_notification("Exam Deleted successfully");
        redirect(base_url().'exam');
        
    }
    
     /**
     * Examination
     * Contains the exam, exam schedule and its marks
     */
    function exam_list_from_degree_and_course($branch, $course, $admission_plan, $type = '') {
        $this->load->model('admin/Crud_model');
        $exam_list = $this->Exam_manager_model->get_many_by( array(
                    'branch_id' => $branch,
                    'course_id' => $course,
                    'admission_plan_id' => $admission_plan,                    
                    'exam_ref_name' => $type
                ));

        echo json_encode($exam_list);
    }
    
    /**
     * Get exam list by course name and semester
     * @param type $course_id
     * @param type $semester_id
     * 
     */
    function get_exam_list($branch_id = '', $course_id = '', $admission_id = '',  $time_table = '') {
        
        $exam_detail = $this->Exam_manager_model->get_exam_list($branch_id, $course_id, $admission_id);
        echo "<option value=''>Select</option>";
        foreach ($exam_detail as $row) {
            ?>
            <option value="<?php echo $row->em_id ?>"
            <?php if ($row->em_id == $time_table) echo 'selected'; ?>><?php echo $row->em_name . '  (Marks' . $row->total_marks . ')'; ?></option>
            <!--echo "<option value={$row->em_id}>{$row->em_name}  (Marks{$row->total_marks})</option>";-->
            <?php
        }
    }
    
    
    /**
     * Student Exam Schedule
     * Exam schedule
     * @param string $exam_id
     */
    function exam_schedule($exam_id = '') {
        $this->data['exam_details'] = $this->Exam_manager_model->student_exam_detail($exam_id);        
        $this->data['time_table'] = $this->Exam_manager_model->exam_schedule($exam_id);
        $this->data['page'] = 'exam_schedule';
        $this->data['title'] = 'Exam Schedule';
        $this->__template('exam/exam_schedule', $this->data);
    }
    
    
    function internal()
    {
        
        $this->data['page'] = 'internal';
        $this->data['title'] = 'Internal Exam Marks';
        $this->data['internal'] = $this->Internal_exam_model->get_all();
        $this->__template('exam/internal', $this->data);
    }

    function internal_create()
    {
        if($_POST)
        {
           $this->Internal_exam_model->insert(array("course_id"=>$_POST['course'],
                                                    "sem_id"=>$_POST['semester'],
                                                    "sm_id"=>$_POST['subject'],
                                                    "internal_title"=>$_POST['exam_name'],
                                                    "internal_marks"=>$_POST['total_marks']
                                                    )); 
           $message = "Internal marks successfully added";
           $this->flash_notification($message);
           redirect(base_url().'exam/internal');
        }
    }
    
    function internal_update($param='')
    {
        if($_POST)
        {
           $this->Internal_exam_model->update($param,array("course_id"=>$_POST['course'],
                                                    "sem_id"=>$_POST['semester'],
                                                    "sm_id"=>$_POST['subject'],
                                                    "internal_title"=>$_POST['exam_name'],
                                                    "internal_marks"=>$_POST['total_marks']
                                                    )); 
           $message = "Internal marks successfully updated";
           $this->flash_notification($message);
           redirect(base_url().'exam/internal');
        }
    }
    
    function internal_delete($id= '')
    {
        $this->Internal_exam_model->delete($id);
        $message = "Internal marks successfully deleted";
        $this->flash_notification($message);
        redirect(base_url().'exam/internal');
    }
    
    
}

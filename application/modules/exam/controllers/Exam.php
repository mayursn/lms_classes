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
        $this->load->model('branch/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('student/Student_model');
        $this->load->model('exam/Exam_seat_no_model');
    }

    function index() {
        $this->data['title'] = 'Exam';
        $this->data['page'] = 'exam';
        
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
       
        if($this->session->userdata('std_id'))
        {
         $std = $this->session->userdata('std_id');
        $student_details = $this->Student_model->get($std);
        
        $this->data['exam_listing'] = $this->Exam_manager_model->student_exam_list($student_details->course_id, $student_details->semester_id);

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
                    $_POST['degree'], $_POST['course'], $_POST['batch'], $_POST['semester'], $_POST['exam_name']);

            if (count($is_record_present)) {
                $this->flash_notification('Data is already present.');
                redirect(base_url() . 'exam');
            } else {
                if ($this->form_validation->run('exam_insert_update') != FALSE) {
                    $data = array(
                        'em_name' => $this->input->post('exam_name', TRUE),
                        'em_type' => $this->input->post('exam_type', TRUE),
                        'total_marks' => $this->input->post('total_marks', TRUE),
                        'passing_mark' => $this->input->post('passing_marks', TRUE),
                        'em_year' => $this->input->post('year', TRUE),
                        'degree_id' => $this->input->post('degree', TRUE),
                        'course_id' => $this->input->post('course', TRUE),
                        'batch_id' => $this->input->post('batch', TRUE),
                        'em_semester' => $this->input->post('semester', TRUE),
                        'em_status' => $this->input->post('status', TRUE),
                        'em_date' => $this->input->post('date', TRUE),
                        'em_start_time' => $this->input->post('start_date_time', TRUE),
                        'em_end_time' => $this->input->post('end_date_time', TRUE),
                    );
                    $insert_id = $this->Exam_manager_model->insert($data);


                    //$this->exam_email_notification($_POST);
                    $this->flash_notification("Exam successfully added.");

                    //create seat no
                    $seat_no_initial = chr(mt_rand(65, 90));

                    //get students
                    $students_info = $this->Student_model->get_many_by(array(
                        'std_degree' => $_POST['degree'],
                        'course_id' => $_POST['course'],
                        'std_batch' => $_POST['batch'],
                        'semester_id' => $_POST['semester']
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
                    //exit;
                    create_notification('exam_manager', $_POST['degree'], $_POST['course'], $_POST['batch'], $_POST['semester'], $insert_id);
                    $this->flash_notification("Exam Successfully added.");
                    redirect(base_url('exam'));
                } else {
                    $page_data['edit_error'] = validation_errors();
                    $this->flash_notification(validation_errors());
                }
            }
            redirect(base_url() . 'exam');
        }
    }

    function update($param2) {
        if ($_POST) {
            if ($this->form_validation->run('exam_insert_update') != FALSE) {
                $data = array(
                    'em_name' => $this->input->post('exam_name', TRUE),
                    'em_type' => $this->input->post('exam_type', TRUE),
                    'total_marks' => $this->input->post('total_marks', TRUE),
                    'em_year' => $this->input->post('year', TRUE),
                    'degree_id' => $this->input->post('degree', TRUE),
                    'course_id' => $this->input->post('course', TRUE),
                    'batch_id' => $this->input->post('batch', TRUE),
                    'em_semester' => $this->input->post('semester', TRUE),
                    'em_status' => $this->input->post('status', TRUE),
                    'em_date' => $this->input->post('date', TRUE),
                    'em_start_time' => $this->input->post('start_date_time', TRUE),
                    'em_end_time' => $this->input->post('end_date_time', TRUE),
                );
                $this->Exam_manager_model->update($param2, $data);
                $this->flash_notification("Exam successfully updated");
                redirect(base_url('exam'));
            } else {
                $page_data['edit_error'] = validation_errors();
                redirect(base_url('exam'));
            }
        }
    }
    
    /**
     * Exam ajax filter
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     */
    function get_exam_filter($degree, $course, $batch, $semester) {
        $this->data['exams'] = $this->Exam_manager_model->get_exam_filter($degree, $course, $batch, $semester);
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
    function exam_list_from_degree_and_course($degree, $course, $batch, $semester, $type = '') {
        $this->load->model('admin/Crud_model');
        $exam_list = $this->Exam_manager_model->get_many_by( array(
                    'degree_id' => $degree,
                    'course_id' => $course,
                    'batch_id' => $batch,
                    'em_semester' => $semester,
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
    function get_exam_list($degree_id = '', $course_id = '', $batch_id = '', $semester_id = '', $time_table = '') {
        
        $exam_detail = $this->Exam_manager_model->get_exam_list($degree_id, $course_id, $batch_id, $semester_id);
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
    
    
    

}

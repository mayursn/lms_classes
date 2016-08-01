<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Examschedual extends MY_Controller {

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
        $this->load->model('examschedual/Exam_time_table_model');
    }

    function index() {
        $this->data['title'] = 'Exam Schedual';          
        $this->data['time_table'] = $this->Exam_time_table_model->time_table();
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $this->data['page'] = 'exam_time_table';
        $this->__template('examschedual/index', $this->data);
    }

    function create($id = '') {
        if ($_POST) {
           
             $is_record_present = $this->Exam_time_table_model->exam_time_table_duplication(
                        $_POST['exam'], $_POST['subject']);

                if (count($is_record_present)) {
                    $this->flash_notification('Data is already present.');
                     redirect(base_url('examschedual'));
                } else {
                    // do form validation
                    if ($this->form_validation->run('time_table_insert_update') != FALSE) {
                        //create
                        $insert_id = $this->Exam_time_table_model->insert(array(
                            'degree_id' => $this->input->post('degree', TRUE),
                            'course_id' => $this->input->post('course', TRUE),
                            'batch_id' => $this->input->post('batch', TRUE),
                            'semester_id' => $this->input->post('semester', TRUE),
                            'exam_id' => $this->input->post('exam', TRUE),
                            'subject_id' => $this->input->post('subject', TRUE),
                            'exam_date' => $this->input->post('exam_date', TRUE),
                            'exam_start_time' => $this->input->post('start_time', TRUE),
                            'exam_end_time' => $this->input->post('end_time', TRUE),
                        ));
                        
                        create_notification('exam_time_table', $_POST['degree'], $_POST['course'], $_POST['batch'], $_POST['semester'], $insert_id);
                        $this->flash_notification("Exam Schedual successfully added.");
                        redirect(base_url('examschedual'));
                    }
                }
        }
    }

    function update($param2) {
        if ($_POST) {
           if ($this->form_validation->run('time_table_insert_update') != FALSE) {
                    //update
                    $this->Exam_time_table_model->update($param2,array(
                        'degree_id' => $this->input->post('degree', TRUE),
                        'course_id' => $this->input->post('course', TRUE),
                        'batch_id' => $this->input->post('batch', TRUE),
                        'exam_id' => $this->input->post('exam', TRUE),
                        'subject_id' => $this->input->post('subject', TRUE),
                        'exam_date' => $this->input->post('exam_date', TRUE),
                        'exam_start_time' => $this->input->post('start_time', TRUE),
                        'exam_end_time' => $this->input->post('end_time', TRUE),
                            ));
                    $this->flash_notification("Exam Schedual successfully updated.");
                    redirect(base_url('examschedual'));
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
        redirect(base_url().'examschedual');
        
    }

    
    
    /**
     * Get subject list by course and semester
     * @param type $course_id
     * @param type $semester_id
     */
    function subject_list($course_id = '', $semester_id, $time_table = '') {
        $this->load->model('subject/Subject_manager_model');
        $subjects = $this->Subject_manager_model->get_many_by(
                array(
                    'sm_course_id' => $course_id,
                    'sm_sem_id' => $semester_id
                ));
        echo "<option vale=''>Select</option>";
        foreach ($subjects as $row) {
            ?>
            <option value="<?php echo $row->sm_id; ?>"
            <?php if ($row->sm_id == $time_table) echo 'selected'; ?>><?php echo $row->subject_name . '  Code: ' . $row->subject_code; ?>
            </option>
            <!--echo "<option value={$row->sm_id}>{$row->subject_name}  (Code: {$row->subject_code})</option>";-->
            <?php
        }
    }
    
     /**
     * Get exam list by course name and semester
     * @param type $course_id
     * @param type $semester_id
     * 
     */
    function get_exam_list($degree_id = '', $course_id = '', $batch_id = '', $semester_id = '', $time_table = '') {
        $this->load->model('department/Degree_model');
        $exam_detail = $this->Degree_model->get_many_by(array(
                            'course_id' => $course_id,
                            'em_semester' => $semester_id,
                            'degree_id' => $degree_id,
                            'batch_id' => $batch_id,
                            'exam_ref_name' => 'reguler'
                        ));
        echo "<option value=''>Select</option>";
        foreach ($exam_detail as $row) {
            ?>
            <option value="<?php echo $row->em_id ?>"
            <?php if ($row->em_id == $time_table) echo 'selected'; ?>><?php echo $row->em_name . '  (Marks' . $row->total_marks . ')'; ?></option>
            <!--echo "<option value={$row->em_id}>{$row->em_name}  (Marks{$row->total_marks})</option>";-->
            <?php
        }
    }
    
    function schedule($id = '')
    {
       
         $student_detail = $this->db->select('std_id, semester_id, std_degree, course_id, class_id, std_batch')
                ->from('student')
                ->where('std_id', $this->session->userdata('std_id'))
                ->get()
                ->row();
        
        $this->data['title'] = 'Exam Schedual';  
        $this->data['page'] = 'schedule';
        $this->data['exam_listing'] = $this->student_exam_listing_widget($student_detail);
        if(!empty($id))
        {
         $this->data['exam_details'] = $this->Exam_time_table_model->exam_detail($id);
        
         $this->data['time_table'] = $this->Exam_time_table_model->exam_schedule($id);
        }
         $this->__template('examschedual/schedule', $this->data);
    }
    
    
    function student_exam_listing_widget($student_details) {       
       
        
        $page_data['exam_listing'] = $this->Exam_time_table_model->get_exam_listing($student_details);
        //check for time table
        $student_id = $this->session->userdata('std_id');
        foreach ($page_data['exam_listing'] as $exam) {
            $is_pass = TRUE;
            //find exam schedule
            $exam_schedule = $this->Exam_time_table_model->get_exam_subject_details($exam);
            //find marks
            $exam_marks = $this->Exam_time_table_model->get_marks_subject($student_id,$exam);

            //check for pass or fail
            foreach ($exam_marks as $mark) {
                if ($mark->mark_obtained < $exam->passing_mark) {
                    $is_pass = FALSE;
                    break;
                }
            }

            //find remedial exams if fail
            if (!$is_pass) {
                $remedial_exam = get_exam_type_marks($exam);

                foreach ($remedial_exam as $remedial) {
                    $is_remedial_exam_pass = FALSE;
                    array_push($page_data['exam_listing'], $remedial);
                    //check for exam schedule
                    $remedial_exam_schedule = $this->db->select()
                            ->from('exam_time_table')
                            ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
                            ->where('exam_time_table.exam_id', $remedial->em_id)
                            ->get()
                            ->result();

                    foreach ($remedial_exam_schedule as $schedule) {
                        //check for marks
                        $marks = $this->db->select()
                                ->from('marks_manager')
                                ->join('subject_manager', 'subject_manager.sm_id = marks_manager.mm_subject_id')
                                ->where(array(
                                    'mm_std_id' => $student_id,
                                    'mm_exam_id' => $remedial->em_id
                                ))
                                ->get()
                                ->result();

                        //check for pass or fail
                        foreach ($marks as $m) {
                            if ($m->mark_obtained >= $remedial->passing_mark) {
                                $is_remedial_exam_pass = TRUE;
                            } else {
                                $is_remedial_exam_pass = FALSE;
                                break;
                            }
                        }
                        if (!$is_remedial_exam_pass)
                            break;
                    }
                    if ($is_remedial_exam_pass)
                        break;
                }
            }
        }

        return $page_data['exam_listing'];
    }
    
     /**
     * Exam schedule ajax filter
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     * @param string $exam
     */
    function get_exam_schedule_filter($degree, $course, $batch, $semester, $exam) {
        $this->data['time_table'] = $this->Exam_time_table_model->exam_schedule_filter($degree, $course, $batch, $semester, $exam);
        $this->load->view("examschedual/exam_schedule_filter", $this->data);
    }

}

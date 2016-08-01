<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('assignment/Assignment_manager_model');
        $this->load->model('department/Degree_model');
        $this->load->model('branch/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('assignment/Assignment_submission_model');
        $this->load->model('student/Student_model');
        $this->load->model('academic_year/Academic_year_model');
        $this->load->model('subject/Subject_manager_model');
        
    }

    /**
     * index page
     */
    function index() {
        $this->data['title'] = 'Assignment';
        $this->data['page'] = 'assignment';
        $active = $this->Academic_year_model->get_many_by(array("current_year_status" => 'active'));
        $start_year = $active[0]->start_year;
        $end_year = $active[0]->end_year;
        $array = array("start_year" => $start_year,
            "end_year" => $end_year);
        $this->data['assignment'] = $this->Assignment_manager_model->get_many_by($array);
        $this->data['submitedassignment'] = $this->Assignment_submission_model->get_submitted_assignments();
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['degree'] = $this->Degree_model->get_all();
        $this->data['page'] = 'assignment';
        $this->data['late_submitted'] = $this->Assignment_submission_model->get_late_submitted_assignment();
        $this->data['not_submitted'] = $this->Crud_model->get_not_submitted_assignment();
        $this->__template('assignment/index', $this->data);
    }

    /**
     * create assignment
     */
    function create() {
        if ($_POST) {


            if ($_FILES['assignmentfile']['name'] != "") {

                $config['upload_path'] = 'uploads/project_file';
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                //$this->upload->set_allowed_types('*');	

                if (!$this->upload->do_upload('assignmentfile')) {
                    $this->session->set_flashdata('flash_message', "Invalid File!");
                    redirect(base_url() . 'assignment/', 'refresh');
                } else {
                    $file = $this->upload->data();

                    $data['assign_filename'] = $file['file_name'];
                    $file_url = base_url() . 'uploads/project_file/' . $data['assign_filename'];
                }
            } else {
                $data['assign_filename'] = '';
                $file_url = '';
            }
            $academy = $this->Academic_year_model->get_current_year();
            $data['start_year'] = $academy->start_year;
            $data['end_year'] = $academy->end_year;
            $data['course_id'] = $this->input->post('course');
            $data['assign_title'] = $this->input->post('title');
            $data['sm_id'] = $this->input->post('subject');
            $data['assign_url'] = $file_url;
            $data['assign_sem'] = $this->input->post('semester');
            $data['class_id'] = $this->input->post('class');
            $data['assign_desc'] = $this->input->post('description');
            $data['assign_dos'] = nice_date($this->input->post('submissiondate'), 'Y-m-d');
            $data['assignment_instruction'] = $this->input->post('instruction');
            $data['assign_status'] = $this->input->post('status');
            $data['created_date'] = date('Y-m-d');
            $data['assign_degree'] = $this->input->post('degree');

            $last_id = $this->Assignment_manager_model->insert($data);


            $assign_degree = $data['assign_degree'];
            $assign_sem = $data['assign_sem'];
            $course_id = $data['course_id'];
            $std_array  = array("semester_id"=> $assign_sem,
                  "std_degree"=> $assign_degree,
                'course_id'=>$course_id);
            $students = $this->Student_model->get_many_by($std_array);         
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
            $this->db->where("notification_type", "assignment_manager");
            $res = $this->db->get("notification_type")->result();
            if ($res != '') {
                $notification_id = $res[0]->notification_type_id;
                $notify['notification_type_id'] = $notification_id;
                $notify['student_ids'] = $student_ids;
                $notify['degree_id'] = $assign_degree;
                $notify['course_id'] = $course_id;
                $notify['semester_id'] = $assign_sem;
                $notify['data_id'] = $last_id;
                $this->db->insert("notification", $notify);
            }

            $this->session->set_flashdata('flash_message', 'Assignment Added Successfully');
            redirect(base_url() . 'assignment/', 'refresh');
        }

        redirect(base_url('assignment'));
    }

    /**
     * delete assignment
     * @param int $id
     */
    function delete($id) {
        $this->Assignment_manager_model->delete($id);
        $this->session->set_flashdata('flash_message', 'Assignment is successfully deleted.');
        redirect(base_url('assignment'));
    }

    /**
     * update assignment
     * @param int $id
     */
    function update($id = '') {
        $data = array();
        if ($_POST) {

            if ($_FILES['assignmentfile']['name'] != "") {

                $config['upload_path'] = 'uploads/project_file';
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                //$this->upload->set_allowed_types('*');	

                if (!$this->upload->do_upload('assignmentfile')) {
                    $this->session->set_flashdata('flash_message', "Invalid File!");
                    redirect(base_url() . 'assignment/', 'refresh');
                } else {
                    $file = $this->upload->data();

                    $data['assign_filename'] = $file['file_name'];
                    $file_url = base_url() . 'uploads/project_file/' . $data['assign_filename'];
                }
            } else {

                $file_url = $this->input->post('assignmenturl');
            }


            $data['course_id'] = $this->input->post('course');
            $data['assign_title'] = $this->input->post('title');
            $data['assign_url'] = $file_url;
            $data['sm_id'] = $this->input->post('subject');
            $data['assignment_instruction'] = $this->input->post('instruction');
            $data['assign_sem'] = $this->input->post('semester');
            $data['class_id'] = $this->input->post('class');
            $data['assign_desc'] = $this->input->post('description');
            $data['assign_dos'] = nice_date($this->input->post('submissiondate1'), 'Y-m-d');
            $data['assign_degree'] = $this->input->post('degree');
            $data['assign_status'] = 1;

            $this->Assignment_manager_model->update($id, $data);
            $this->session->set_flashdata('flash_message', 'Assignment Updated Successfully');
        }

        redirect(base_url('assignment'));
    }

    /**
     * reopen assignment
     * @param int $id
     */
    function reopen($id = '') {
        if ($_POST) {
            $implode = implode(",", $this->input->post('student'));
            if (!empty($implode)) {
                $insert['student_id'] = $implode;
                $insert['assign_id'] = $id;
                $this->Assignment_submission_model->insert_update_assignment_reopen($insert, $id);
                $this->session->set_flashdata('flash_message', 'Assignment reopen Successfully');
                redirect(base_url() . 'assignment/', 'refresh');
            } else {
                $this->session->set_flashdata('flash_message', 'Assignment reopen failed');
                redirect(base_url() . 'assignment/', 'refresh');
            }
        }
    }

    /**
     * filter assignment
     * @param string $param
     */
    function getassignment($param = '') {
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['class'] = $this->Class_model->order_by_column('class_name');
        $current = $this->Academic_year_model->get_many_by(array("current_year_status" => "active"));
        $start_year = $current[0]->start_year;
        $end_year = $current[0]->end_year;

        if ($param == 'allassignment') {
            $degree = $this->input->post('degree');
            $course = $this->input->post('course');
            $subject = $this->input->post('subject');
            $semester = $this->input->post("semester");
            $class = $this->input->post("divclass");
            $get_by_many = array("assign_degree" => $degree,
                "course_id" => $course,
                "sm_id" => $subject,
                "assign_sem" => $semester,
                "class_id" => $class,
                "start_year" => $start_year,
                "end_year" => $end_year);
            $this->data['assignment'] = $this->Assignment_manager_model->get_many_by($get_by_many);

            $this->data['param'] = $param;
        }


        if ($param == "submitted") {

            $degree = $this->input->post('degree');
            $course = $this->input->post('course');
            $subject = $this->input->post('subject');
            $semester = $this->input->post("semester");
            $this->data['submitedassignment'] = $this->Assignment_submission_model->get_submitted_subject_assignment($course, $subject, $degree, $semester,$start_year,$end_year);
            $this->data['param'] = $param;
        }

        if ($param == "notsubmitted") {
            $degree = $this->input->post('degree');
            $course = $this->input->post('course');
            $subject = $this->input->post('subject');
            $semester = $this->input->post("semester");
            $class = $this->input->post("divclass");
            $assign_id = $this->input->post("assign_id");
            $this->data['not_submitted'] = $this->Assignment_submission_model->not_submitted_subject_assignment($course, $subject, $degree, $semester, $class, $assign_id);
            $this->data['param'] = $param;
            $this->data['assign_id'] = $assign_id;
        }
        if ($param == "assessments") {
            $degree = $this->input->post('degree');
            $course = $this->input->post('course');
            $subject = $this->input->post('subject');
            $semester = $this->input->post("semester");
            $this->data['submitedassignment'] = $this->Assignment_submission_model->filter_assessment($course, $subject, $degree, $semester,$start_year,$end_year);
            $this->data['param'] = $param;
        }
        $this->load->view("assignment/getassignment", $this->data);
    }

    /**
     * Assignment list
     */
    function getassignment_list() {
        $degree = $this->input->post('degree');
        $course = $this->input->post('course');
        $subject = $this->input->post('subject');
        $semester = $this->input->post("semester");
        $class = $this->input->post("divclass");
        $current = $this->Academic_year_model->get_many_by(array("current_year_status" => "active"));
        $start_year = $current[0]->start_year;
        $end_year = $current[0]->end_year;
        $get_by_many = array("assign_degree" => $degree,
            "course_id" => $course,
            "sm_id" => $subject,
            "assign_sem" => $semester,
            "class_id" => $class,
            "start_year" => $start_year,
            "end_year" => $end_year);
        $res = $this->Assignment_manager_model->get_many_by($get_by_many);
        echo json_encode($res);
    }
    
    
    /**
     * check duplicate assignment
     */

    function checkassignments() {
        $degree = $this->input->post('degree');
        $course = $this->input->post('course');
        $subject = $this->input->post('subject');
        $semester = $this->input->post('semester');
        $title = $this->input->post('title');
        $get_by_many = array("assign_degree" => $degree,
            "course_id" => $course,
            "sm_id" => $subject,
            "assign_sem" => $semester,
            'assign_title' => $title);
        $res = $this->Assignment_manager_model->get_many_by($get_by_many);
        echo json_encode($res);
    }

    /**
     * check assignment
     */
    function checkassignment($id = '') {
        $degree = $this->input->post('degree');
        $course = $this->input->post('course');
        $subject = $this->input->post('subject');
        $semester = $this->input->post('semester');
        $title = $this->input->post('title');
        $get_by_many = array("assign_degree" => $degree,
            "course_id" => $course,
            "sm_id" => $subject,
            "assign_sem" => $semester,
            'assign_title' => $title,
            'assign_id!=' => $id);
        $res = $this->Assignment_manager_model->get_many_by($get_by_many);
        echo json_encode($res);
    }

    /**
     * student submit assignment
     */
    function submission() {
        $this->load->model('academic_year/Academic_year_model');
        $std_id = $this->session->userdata('std_id');
        $std = $this->Student_model->get($std_id);

        $this->data['title'] = 'Assignment';
        $this->data['page'] = 'assignment';
        $current_year = $this->Academic_year_model->get_many_by(array('current_year_status' => 'active'));
        $start_year = $current_year[0]->start_year;
        $end_year = $current_year[0]->end_year;
        $this->data['submitassignment'] = $this->Assignment_submission_model->student_submitted_assignment_list();
        $this->data['assignment'] = $this->Assignment_manager_model->get_many_by(
                array('assign_degree' => $std->std_degree,
                    'assign_sem' => $std->semester_id,
                    'course_id' => $std->course_id,
                    'class_id' => $std->class_id,
                    'start_year' => $start_year,
                    'end_year' => $end_year)
        );
         clear_notification('assignment_manager', $this->session->userdata('std_id'));
         unset($this->session->userdata('notifications')['project_manager']);
        $this->data['assessment'] = $this->Assignment_submission_model->student_assessment();
        
        $this->__template('assignment/submission', $this->data);
    }

    /**
     * submit assignment
     */
    function submit_assignment() {
        $this->load->model('academic_year/Academic_year_model');
        if ($_POST) {
            if ($_FILES['document_file']['name'] != "") {
                $config['upload_path'] = 'uploads/project_file';
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                //$this->upload->set_allowed_types('*');	
                if (!$this->upload->do_upload('document_file')) {
                    $datafile = array('msg' => $this->upload->display_errors());
                } else {
                    $file = $this->upload->data();
                    $data['document_file'] = $file['file_name'];
                }
            }
            $data['comment'] = $this->input->post('comment');
            $data['assign_id'] = $this->input->post('assignment_id');
            $ids = $this->input->post('assignment_id');
            $row = $this->Assignment_manager_model->get($ids);
            // $row = $this->db->get_where("assignment_manager",array("assign_id"=>$ids))->row();
            $submission_date = $row->assign_dos;
            $data['submission_date'] = $submission_date;
            $data['assign_degree'] = $row->assign_degree;
            $data['assign_batch'] = $row->assign_batch;
            $data['assign_sem'] = $row->assign_sem;
            $data['course_id'] = $row->course_id;
            $data['class_id'] = $row->class_id;
            $data['student_id'] = $this->session->userdata('std_id');
            $data['submited_date'] = date('Y-m-d');
            $current = $this->Academic_year_model->get_many_by(array('current_year_status' => 'active'));
            $data['start_year'] = $current[0]->start_year;
            $data['end_year'] = $current[0]->end_year;
            $this->Assignment_submission_model->insert($data);
            //$this->db->insert('assignment_submission', $data);
            $this->flash_notification('Assignment is successfully added.');
            redirect(base_url() . 'assignment/submission', 'refresh');
        }
    }

}

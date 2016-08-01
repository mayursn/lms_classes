<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Syllabus extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('syllabus/Smart_syllabus_model');
        $this->load->model('department/Degree_model');
        $this->load->model('branch/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('student/Student_model');
    }

    function index() {
        $this->data['title'] = 'Syllabus';
        $this->data['page'] = 'syllabus';
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        if ($this->session->userdata('std_id')) {
            $std = $this->session->userdata('std_id');
            $student = $this->Student_model->get($std);
            $std_degree = $student->std_degree;
            $course_id = $student->course_id;
            $semester_id = $student->semester_id;
            $this->data['syllabus'] = $this->Smart_syllabus_model->get_many_by(array("syllabus_degree" => $std_degree, "syllabus_course" => $course_id, "syllabus_sem" => $semester_id));          
        }
        else{
        $this->data['syllabus'] = $this->Smart_syllabus_model->order_by_column('created_date');
        }
        
        $this->__template('syllabus/index', $this->data);
    }

    function create() {
        if ($_POST) {

            if ($_FILES['syllabusfile']['name'] != "") {
                $path = FCPATH . 'uploads/syllabus';
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $config['upload_path'] = 'uploads/syllabus';
                $config['allowed_types'] = 'pdf|doc|docx|ppt|pptx';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                //$this->upload->set_allowed_types('*');	

                if (!$this->upload->do_upload('syllabusfile')) {
                    $this->session->set_flashdata('flash_message', "Invalid File!");
                    redirect(base_url() . 'syllabus/', 'refresh');
                } else {
                    $file = $this->upload->data();
                    $insert['syllabus_filename'] = $file['file_name'];
                }
            } else {
                $insert['syllabus_filename'] = '';
            }

            $insert['syllabus_title'] = $this->input->post('title');
            $insert['syllabus_degree'] = $this->input->post('degree');
            $insert['syllabus_course'] = $this->input->post('course');
            $insert['syllabus_sem'] = $this->input->post('semester');
            $insert['syllabus_desc'] = $this->input->post('description');

            $this->Smart_syllabus_model->insert($insert);
            $this->flash_notification("Syllabus successfully added.");
            redirect(base_url() . 'syllabus/', 'refresh');
        }
    }

    function update($param2 = '') {
        if ($_POST) {


            $syllabus = $this->Smart_syllabus_model->get($param2);

            if ($_FILES['syllabusfile']['name'] != "") {
                $path = FCPATH . 'uploads/syllabus';
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $config['upload_path'] = 'uploads/syllabus';
                $config['allowed_types'] = 'pdf|doc|docx|ppt|pptx';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                //$this->upload->set_allowed_types('*');	

                if (!$this->upload->do_upload('syllabusfile')) {
                    $this->session->set_flashdata('flash_message', "Invalid File!");
                    redirect(base_url() . 'syllabus/', 'refresh');
                } else {
                    $file = $this->upload->data();
                    $insert['syllabus_filename'] = $file['file_name'];
                }
            } else {

                $insert['syllabus_filename'] = $syllabus->syllabus_filename;
            }

            $insert['syllabus_title'] = $this->input->post('title');
            $insert['syllabus_degree'] = $this->input->post('degree');
            $insert['syllabus_course'] = $this->input->post('course');
            $insert['syllabus_sem'] = $this->input->post('semester');
            $insert['syllabus_desc'] = $this->input->post('description');
            $insert['update_date'] = date('Y-m-d H:i:s');

            $this->Smart_syllabus_model->update($param2, $insert);
            $this->flash_notification("Syllabus successfully updated");
            redirect(base_url() . 'syllabus/', 'refresh');
        }
    }

    function delete($id = '') {
        $this->Smart_syllabus_model->delete($id);
        $this->flash_notification("Syllabus successfully deleted");
        redirect(base_url() . 'syllabus/');
    }

    /**
     * 
     */
    function getsyllabus($param = '') {
        $degree = $this->input->post('degree');
        $course = $this->input->post('course');
        $semester = $this->input->post("semester");
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $array = array("syllabus_course" => $course,
            "syllabus_degree" => $degree,
            "syllabus_sem" => $semester);
        $this->data['syllabus'] = $this->Smart_syllabus_model->get_many_by($array);

        $this->load->view("syllabus/getsyllabus", $this->data);
    }

}

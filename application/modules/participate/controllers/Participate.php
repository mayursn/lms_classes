<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Participate extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('participate/Participate_manager_model');
        $this->load->model('department/Degree_model');
        $this->load->model('branch/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('student/Student_model');
        $this->load->model('participate/Survey_question_model');
        $this->load->model('participate/Student_upload_model');
        $this->load->model('participate/Survey_model');
        $this->load->model('participate/Participate_student_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
          
        
    }
    
    /**
     * list of participate, survey question suevey , student upload document
     */

    function index() {
        $this->data['title'] = 'Participate';
        $this->data['page'] = 'participate';
        $this->data['participate'] = $this->Participate_manager_model->order_by_column('created_date');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $this->data['questions'] = $this->Participate_manager_model->get_question();
        $this->data['student'] = $this->Participate_manager_model->get_students();
        $this->data['survey'] = $this->Participate_manager_model->get_survey();
        $this->data['page'] = 'participate';
        $this->data['title'] = 'Participate';
        $this->data['edit_participate'] = 'Edit Participate';
        $this->data['add_title'] = 'Add Participate';
        $this->data['volunteer'] = $this->Participate_manager_model->get_volunteer();
        $this->data['uploads'] = $this->Participate_manager_model->get_uploads();
        $this->data['page'] = 'participate';
        $this->__template('participate/index', $this->data);
    }

    /**
     * Add Participate
     */
    function create() {

        if ($_POST) {
            $data = array();
            $data['pp_degree'] = $this->input->post('degree');
            $data['pp_title'] = $this->input->post('title');
            $data['pp_batch'] = $this->input->post('batch');

            $data['pp_semester'] = $this->input->post('semester');
            $data['pp_desc'] = $this->input->post('description');
            $data['pp_dos'] = $this->input->post('dateofsubmission');
            $data['pp_status'] = $this->input->post('status');

            $data['pp_course'] = $this->input->post('course');
            $data['created_date'] = date('Y-m-d');


            $this->db->insert('participate_manager', $data);
            $last_id = $this->db->insert_id();
            $batch = $data['pp_batch'];
            $degree = $data['pp_degree'];
            $semester = $data['pp_semester'];
            $course = $data['pp_course'];
            if ($degree == 'All') {
                $this->db->select('std_id');
                $students = $this->db->get('student')->result();
            } else {
                if ($course == 'All') {
                    $this->db->select('std_id');
                    $this->db->where('std_degree', $degree);
                    $students = $this->db->get('student')->result();
                } else {
                    if ($batch == 'All') {
                        $this->db->select('std_id');
                        $this->db->where('std_degree', $degree);
                        $this->db->where('course_id', $course);
                        $students = $this->db->get('student')->result();
                    } else {
                        if ($semester == 'All') {
                            $this->db->select('std_id');
                            $this->db->where('std_batch', $batch);
                            $this->db->where('std_degree', $degree);
                            $this->db->where('course_id', $course);
                            $students = $this->db->get('student')->result();
                        } else {
                            $this->db->select('std_id');
                            $this->db->where('std_batch', $batch);
                            $this->db->where('std_degree', $degree);
                            $this->db->where('course_id', $course);
                            $this->db->where('semester_id', $semester);
                            $students = $this->db->get('student')->result();
                        }
                    }
                }
            }
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
            $this->db->where("notification_type", "participate_manager");
            $res = $this->db->get("notification_type")->result();
            if ($res != '') {
                $notification_id = $res[0]->notification_type_id;
                $notify['notification_type_id'] = $notification_id;
                $notify['student_ids'] = $student_ids;
                $notify['degree_id'] = $data['pp_degree'];
                $notify['course_id'] = $data['pp_course'];
                $notify['batch_id'] = $data['pp_batch'];
                $notify['semester_id'] = $data['pp_semester'];
                $notify['data_id'] = $last_id;
                $this->db->insert("notification", $notify);
            }
            $this->flash_notification('Participate Added successfully');
            redirect(base_url() . 'participate/', 'refresh');
        }

        redirect(base_url('participate'));
    }

    /**
     * Delete Participate
     * @param int $id
     */
    function delete($id) {
        $this->Participate_manager_model->delete($id);
        $this->flash_notification('Participate is successfully deleted');
        redirect(base_url('participate'));
    }
    
    /**
     * Update Participate
     * @param int $id
     */

    function update($id = '') {
        $data = array();
        if ($_POST) {
            $data['pp_degree'] = $this->input->post('degree');
            $data['pp_title'] = $this->input->post('title');
            $data['pp_batch'] = $this->input->post('batch');
            $data['pp_semester'] = $this->input->post('semester');
            $data['pp_desc'] = $this->input->post('description');
            $data['pp_dos'] = $this->input->post('dateofsubmission1');
            $data['pp_course'] = $this->input->post('course');
            $data['pp_status'] = $this->input->post('status');
            $this->Participate_manager_model->update($id, $data);
            $this->flash_notification('Participate Updated Successfully');
        }

        redirect(base_url('participate'));
    }
    
    function delete_question($id='')
    {
         $this->Survey_question_model->delete($id);
         $this->flash_notification('Survey Question is successfully deleted');
        redirect(base_url('participate'));
    }
    
    /**
     * add survey question
     */
    function create_question()
    {
        if($_POST)
        {

            $indata['question'] = $this->input->post('question');
            $indata['question_status'] = $this->input->post('status');
            $indata['question_description'] = $this->input->post('description');

            $this->Survey_question_model->insert($indata);
            $this->flash_notification('Question Added Successfully');
            redirect(base_url('participate'));
        }
    }
    
    /**
     * Update Survey Question 
     * @param int $param
     */
    
    public function update_question($param='')
    {
         $indata['question'] = $this->input->post('question');
         $indata['question_status'] = $this->input->post('status');
         $indata['question_description'] = $this->input->post('description');         
         $this->Survey_question_model->update($param, $indata);
         $this->flash_notification('Question Update Successfully');
         redirect(base_url('participate'));
    }

    /**
     * Get Course
     * @param string $param
     */
    function get_cource($param = '') {
         $did = $this->input->post("degree");
         $cource = $this->db->get_where("course", array("degree_id" => $did))->result_array();
        echo json_encode($cource);
    }

    /**
     * Get batches
     * @param string $param
     */
    function get_batchs($param = '') {
       $cid = $this->input->post("course");
        $did = $this->input->post("degree");
        $batch = $this->db->query("SELECT * FROM batch WHERE FIND_IN_SET('" . $did . "',degree_id) AND FIND_IN_SET('" . $cid . "',course_id)")->result_array();
        echo json_encode($batch);
    }

    /**
     * get all semester
     */
    function get_semesterall() {

         $cid = $this->input->post("course");

        if ($cid == 'All') {
            $course = $this->db->get('course')->result_array();
        } else {

            $course = $this->db->get_where('course', array('course_id' => $cid))->result_array();
        }

        $semexplode = explode(',', $course[0]['semester_id']);
        $semester = $this->db->get('semester')->result_array();
        $semdata = '';
        foreach ($semester as $sem) {
            if (in_array($sem['s_id'], $semexplode)) {
                $semdata[] = $sem;
            }
        }
        echo json_encode($semdata);
    }
    
    function upload()
    {
         if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $config['upload_path'] = 'uploads/project_file';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            //$this->upload->set_allowed_types('*');
            if (!$this->upload->do_upload('fileupload')) {
                $this->flash_notification( 'Please upload valid file.');
                redirect(base_url() . 'participate/upload/', 'refresh');
            } else {
                $file = $this->upload->data();
                $data['upload_file_name'] = $file['file_name'];
                $file_url = base_url() . 'uploads/project_file/' . $data['upload_file_name'];
                $data['upload_url'] = $file_url;
            }
            $data['upload_title'] = $this->input->post('title');
            $data['upload_desc'] = $this->input->post('description');
            $data['std_id'] = $this->session->userdata('std_id');            
            $this->Student_upload_model->insert($data);
            $this->flash_notification('Detail is successfully added.');
            redirect(base_url() . 'participate/upload/', 'refresh');
        }
        
       $this->data['upload_data'] = $this->Student_upload_model->getstudent_upload();
        $this->data['page'] = 'upload_data';
        $this->data['title'] = 'Upload';
         $this->__template('participate/uploads', $this->data);
    }
    
    function survey()
    {
        if($_POST)
        {
             $std_id = $this->session->userdata("std_id");
            foreach ($_POST as $key => $val):

                if (strpos($key, 'question_id') !== false) {
                    $id = explode("question_id", $key);
                    if ($val != '') {
                        $sq_id = $id[1];
                        $this->addrating($sq_id, $val, $std_id);
                    }
                }


            endforeach;


            $survey = $this->Survey_question_model->get_survey_question();
            $count = 1;
            foreach ($survey as $res) {
                // echo $count;
                $question[] = $this->input->post('question_id' . $count);
                $field[] = $this->input->post('Field' . $count);
                $que = implode(",", $question);
                $status = implode(",", $field);
                $count++;
            }


            $insert_data = array_combine(explode(",", $que), explode(",", $status));
            
            $data['sq_id'] = $que;
            $data['survey_status'] = $status;

            $data['student_id'] = $this->session->userdata('std_id');

            $this->db->insert('survey_list', $data);
            
            $this->flash_notification('Survey added successfully');
            redirect(base_url() . 'participate/survey', 'refresh');
        }
        $std = $this->session->userdata("std_id");
        $this->data['survey'] = $this->Survey_model->get_student_survey();
        $this->data['page'] = 'participate';
        $this->data['title'] = 'Survey Application Form';
        $this->data['param'] = '';
        $this->__template('participate/survey', $this->data);
    }

     /*
     * Add Rating to survey question
     */

    function addrating($id, $rating, $std_id) {
        // $id  = $this->input->post('id');  
        // $rating = $this->input->post('rating'); 
        // $std_id = $this->session->userdata('login_user_id');
        $data['sq_id'] = $id;
        $data['student_id'] = $std_id;
        $data['std_rating'] = $rating;
        $count = $this->Survey_model->getrepeat($data);
        if ($count > 0) {
            $udata['std_rating'] = $rating;
            $this->Survey_model->updatesurveyrating($udata, $id, $std_id);
        } else {
            $this->Survey_model->insert($data);
        }
    }
    
     /**
     * Volunteer
     * @param string $param
     */
    function volunteer($param = '') {
        if ($param == "create") {
            $p_id = $this->input->post('pp_id');
            $std_id = $this->input->post('std_id');
            $status = $this->input->post('p_status');
            
            $get_by_many = array('pp_id' => $p_id, 'student_id' => $std_id);
           $res = $this->Participate_student_model->count_by($get_by_many);
            
            if ($res > 0) {
                $this->flash_notification('Data already exists');
                redirect(base_url() . 'participate/volunteer/', 'refresh');
            }
            $data['pp_id'] = $this->input->post('pp_id');
            $data['student_id'] = $this->input->post('std_id');
            $data['p_status'] = $this->input->post('p_status');
            $data['comment'] = $this->input->post('comment');
           // $this->db->insert("participate_student", $data);
            $this->Participate_student_model->insert( $data);
            
            $this->flash_notification('Participation successfully');
            redirect(base_url() . 'participate/volunteer', 'refresh');
        }
        clear_notification('participate_manager', $this->session->userdata('std_id'));
        unset($this->session->userdata('notifications')['participate_manager']);
        $this->data['page'] = 'participate_form';
        $this->data['title'] = 'Volunteer Form';
        $this->__template('participate/participate_form', $this->data);
    }

    function get_desc()
    {
          $pp_id = $this->input->post('pp_id');
        if ($pp_id != "") {
            $res =$this->Participate_manager_model->get($pp_id);
            $date = date_formats($res->pp_dos);
            $json = array("pp_desc" => $res->pp_desc, "pp_dos" => $date);
            echo json_encode($json);
        }
    }
    
     /* worked by Mayur Panchal 29-3-2016 */

    /**
     * confirm participate
     * @param int $param
     */
    function confirmparticipate($param = '') {
        if ($param != '') {
            $pp_id = $param;
            $this->Participate_student_model->delete($pp_id);
            
            $this->flash_notification('Volunteer Disapprove Successfully');
            redirect(base_url('participate'));
        }
    }

}

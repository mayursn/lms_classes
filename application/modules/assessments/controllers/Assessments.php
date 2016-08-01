<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assessments extends MY_Controller {

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
        $this->load->model('academic_year/Academic_year_model');
    }

    function index() {
        
        $this->data['title'] = 'Assessment';
        $this->data['page'] = 'assessment';
        $this->data['assignment'] = $this->Assignment_manager_model->order_by_column('assign_dos');
        $this->data['submitedassignment'] = $this->Assignment_submission_model->get_assessment_assignment();
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');       
        $this->data['page'] = 'assignment';
        $current = $this->Academic_year_model->get_many_by(array('current_year_status'=>'active'));
        $start_year = $current[0]->start_year;
        $end_year  = $current[0]->end_year;
        $this->data['assessment'] = $this->Assignment_submission_model->get_assessments($start_year,$end_year);
        $this->__template('assessments/index', $this->data);
    }
    
    function create($id='')
    {
        if($_POST)
        {
            $data['feedback'] = $this->input->post('feedback');
            $data['grade'] = $this->input->post('grade');
            $data['user_role'] = $this->session->userdata("role_name");
            $data['user_role_id'] = $this->session->userdata("role_id");
            $data['assessment_status'] = '1';           
            $this->Assignment_submission_model->update($id,$data);
            $this->flash_notification("Assessment successfully added.");
            redirect(base_url('assessments'));
        }
    }

}

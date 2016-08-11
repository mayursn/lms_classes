<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('reports/Reports_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    /**
     * Index action
     */
    function index() {
        $this->data['student_count'] = array();
        $this->data['date'] = array();
        
        // daily student registered
        for ($i = 0; $i < 7; $i++) {
            array_push($this->data['date'], date_formats($i . ' days ago'));
            array_push($this->data['student_count'], $this->Reports_model->daily_registered_students(date('Y-m-d', strtotime($i . ' days ago'))));
        }
        
        // student count by region wise
        $this->data['region_students'] = $this->Reports_model->student_cout_with_regions();            
        
        // department wise student count
        $this->data['department_wise_student'] = $this->Reports_model->department_wise_student();
       
        
        $this->data['title'] = 'Reports';
        $this->data['page'] = 'reports';
        $this->__template('reports/index', $this->data);
    }
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller {

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

    /**
     * Search module
     * 
     * @return response
     */
    function index() {
        $this->load->helper('search');
        $this->data['search_result'] = array();
        $this->data['page'] = 'search_result';
        $this->data['title'] = 'Search Result';
        if ($_POST) {
            $this->data['title'] = 'Search Result';
            if ($_POST['search'] != '')
                $this->data['search_result'] = global_search($_POST['search'], $_POST);
            $this->data['search_string'] = $_POST['search'];
            unset($_POST['search']);
            $this->data['from'] = $_POST;
        }
        //$this->data['page'] = 'search_result';
        $this->__template('search/index', $this->data);
    }

   

}

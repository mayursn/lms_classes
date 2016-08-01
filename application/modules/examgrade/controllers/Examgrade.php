<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Examgrade extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('examgrade/Grade_model');
        $this->load->model('department/Degree_model');
        $this->load->model('branch/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('student/Student_model');
        $this->load->model('exam/Exam_seat_no_model');
    }

    function index() {
        $this->data['title'] = 'Exam Grade';
        $this->data['page'] = 'grade';
        $this->data['grade'] = $this->Grade_model->order_by_column('grade_name');        
        $this->__template('examgrade/index', $this->data);
    }

    function create($id = '') {
        if ($_POST) {
           $this->Grade_model->insert(array(
                    'from_marks' => $_POST['from_marks'],
                    'to_marks' => $_POST['to_marks'],
                    'grade_name' => $_POST['grade_name'],
                    'comment' => $_POST['description']
                ));
           $this->flash_notification("Grade successfully added.");
           redirect(base_url().'examgrade');
        }
    }

    function update($param2) {
        if ($_POST) {
            $this->Grade_model->update($param2, array(
                    'from_marks' => $_POST['from_marks'],
                    'to_marks' => $_POST['to_marks'],
                    'grade_name' => $_POST['grade_name'],
                    'comment' => $_POST['description']
                        ) );
                $this->flash_notification("Grade successfully updated.");
           redirect(base_url().'examgrade');
        }
    }
    
    
    function delete($id='')
    {
        $this->Grade_model->delete($id);
        $this->flash_notification("Grade successfully Deleted.");
        redirect(base_url().'examgrade');
        
    }
    

}

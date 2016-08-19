<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('classes/Class_model');
        $this->load->model('branch/Branch_location_model');
        $this->load->model('courses/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('admission_plan/Admission_plan_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    /**
     * Index action
     */
    function index() {
        $this->data['title'] = 'Class';
        $this->data['page'] = 'class';
        $this->data['classes'] = $this->Class_model->get_all();
        $this->__template('classes/index', $this->data);
    }

    /**
     * Create class
     */
    function create() {
        if ($_POST) {
            $this->Class_model->insert(array(
                'class_name' => $_POST['class_name']
            ));
            $this->flash_notification('Class is successfully added.');
        }

        redirect(base_url('classes'));
    }

    /**
     * Delete class
     * @param string $id
     */
    function delete($id) {
        if ($id) {
            $this->Class_model->delete($id);
            $this->flash_notification('Class is successfully deleted.');
        }

        redirect(base_url('classes'));
    }

    /**
     * Update class
     * @param string $id
     */
    function update($id) {
        if ($_POST) {
            $this->Class_model->update($id, array(
                'class_name' => $_POST['class_name']
            ));
            $this->flash_notification('Class is successfully updated.');
        }

        redirect(base_url('classes'));
    }
    
    function toppers()
    {
        $this->data['title'] = 'Toppers';
        $this->data['page'] = 'toppers';
        $this->data['classes'] = $this->Class_model->get_all();
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['admission_plan'] = $this->Admission_plan_model->order_by_column('admission_duration');        
        $this->data['branch'] = $this->Branch_location_model->order_by_column('branch_name');
        $this->__template('classes/toppers', $this->data);
    }
    
    function get_toppers($branch,$course,$admission_plan,$exam,$class)
    {
        $this->db->select('SUM(marks_manager.mark_obtained) as total,marks_manager.mm_std_id,marks_manager.mm_exam_id,student.std_first_name,student.std_last_name,exam_manager.em_name,SUM(exam_manager.total_marks) as outmark');
        $this->db->group_by('marks_manager.mm_std_id');
        $this->db->where("marks_manager.mm_exam_id",$exam);
        $this->db->join("student","student.std_id=marks_manager.mm_std_id");
        $this->db->join("exam_manager","exam_manager.em_id=marks_manager.mm_exam_id");
        $this->db->order_by('total','DESC');
        
        $this->db->limit(3);        
        $this->data['toppers'] = $this->db->get('marks_manager')->result();   
         $this->data['title'] = 'Toppers';
        $this->data['page'] = 'toppers';
         $this->load->view('classes/toppers_list', $this->data);
    }

}

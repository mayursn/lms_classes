<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class courses extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('courses/Course_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    /**
     * Index action
     */
    function index() {
        $this->data['title'] = 'Course';
        $this->data['page'] = 'course';
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->__template('courses/index', $this->data);
    }

    /**
     * Create new branch
     */
    function create() {
        if ($_POST) {            
            $admission_plan = implode(",",$_POST['admission_plan']);
            $this->Course_model->insert(array(
                'c_name' => $_POST['c_name'],
                'course_status'=>$_POST['course_status'],
                'admission_plan_id'=>$admission_plan
            ));
            $this->flash_notification('Course is successfully added.');
        }

        redirect(base_url('courses'));
    }

    /**
     * Delete branch
     * @param type $id
     */
    function delete($id) {
        if($id) {
            $this->Course_model->delete($id);
            $this->flash_notification('course is successfully deleted.');
        }
        
        redirect(base_url('courses'));
    }

    /**
     * Update branch information
     * @param string $id
     */
    function update($id) {
        if ($_POST) {      
              $admission_plan = implode(",",$_POST['admission_plan']);
            $this->Course_model->update($id, array(
                'c_name' => $_POST['c_name'],   
                'course_status'=>$_POST['course_status'],
                'admission_plan_id'=>$admission_plan
            ));
            $this->flash_notification('course is successfully updated.');
        }

        redirect(base_url('courses'));
    }

    /**
     * Check course if avail
     */
    function check_course() {
        $data = $this->db->get_where('course', array('c_name' => $this->input->post('course')))->result();

        if (count($data) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
    
    function get_admission_plan($course_id='')
    {
      $admission_plan  = $this->Course_model->get($course_id);
      $this->load->model('admission_plan/Admission_plan_model');
      $plans = explode(",",$admission_plan->admission_plan_id);
      foreach($plans as $plan):
          $plan_array = $this->Admission_plan_model->get($plan);
          $json[] = $plan_array;
      endforeach;
      echo json_encode($json);
    }
    
    function get_all_courses()
    {
        $res = $this->Course_model->order_by_column('c_name');
        echo json_encode($res);
    }

}

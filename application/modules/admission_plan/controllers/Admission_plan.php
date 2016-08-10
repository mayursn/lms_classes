<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admission_plan extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
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
        $this->data['title'] = 'Admission Plan';
        $this->data['page'] = 'admission_plan';
        $this->data['admission_plan'] = $this->Admission_plan_model->get_all_plan();
        $this->__template('admission_plan/index', $this->data);
    }

    /**
     * Create admission type
     */
    function create() {
        if ($_POST) {
            $this->Admission_plan_model->insert(array(
                'admission_duration' => $_POST['admission_plan'],
                'admission_plan_status' => $_POST['at_status']
            ));
            $this->flash_notification('Admission type is successfully added.');
        }

        redirect(base_url('admission_plan'));
    }

    /**
     * Update admission type
     * @param string $id
     */
    function update($id) {
        if ($_POST) {
            $this->Admission_plan_model->update($id, array(
                'admission_duration' => $_POST['admission_plan'],
                'admission_plan_status' => $_POST['at_status']
            ));
            $this->flash_notification('Admission plan is successfully updated.');
        }

        redirect(base_url('admission_plan'));
    }

    /**
     * Delete admission type
     * @param string $id
     */
    function delete($id) {
        if ($id) {
            $this->Admission_plan_model->delete($id);
            $this->flash_notification('Admission plan is successfully deleted.');
        }

        redirect(base_url('admission_plan'));
    }

    /**
     * Check admission type
     */
    function check_admission_plan() {
        $this->db->where('admission_plan_status','1');
        $data = $this->db->get_where('admission_plan', array('admission_duration' => $this->input->post('admission_plan')))->result();
        if (count($data) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
    
    

}

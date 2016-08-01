<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('department/Degree_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    function index() {
        $this->data['title'] = 'Department';
        $this->data['page'] = 'department';
        $this->data['department'] = $this->Degree_model->order_by_column('d_name');
        $this->__template('department/index', $this->data);
    }

    /**
     * Create new deparmtents
     */
    function create() {
        if ($_POST) {
            $this->Degree_model->insert(array(
                'd_name' => $_POST['d_name'],
                'd_status' => $_POST['degree_status']
            ));
            $this->session->set_flashdata('flash_message', 'Department is successfully added.');
        }

        redirect(base_url('department'));
    }

    function view($id) {
        
    }

    function edit($id) {
        
    }

    /**
     * Delete department
     * @param string $id
     */
    function delete($id) {
        $this->Degree_model->delete($id);
        $this->session->set_flashdata('flash_message', 'Department is successfully deleted.');

        redirect(base_url('department'));
    }

    /**
     * Update department 
     * @param string $id
     */
    function update($id = '') {
        if ($_POST) {
            $this->Degree_model->update($id, array(
                'd_name' => $_POST['d_name'],
                'd_status' => $_POST['degree_status']
            ));
            $this->flash_notification('Department is successfully updated.');
        }

        redirect(base_url('department'));
    }

    function check_degree() {
        $data = $this->db->get_where('degree', array('d_name' => $this->input->post('course')))->result();
        if (count($data) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    /**
     * Check duplicate department
     * @param string $id
     */
    function check_duplicate_department($id = '') {
        $degree = $this->input->post('d_name');
        $data = $this->db->get_where('degree', array('d_name' => $degree,
                    'd_id!=' => $id))->result_array();
        echo json_encode($data);
    }

}

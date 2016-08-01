<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Semester extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('semester/Semester_model');
    }

    /**
     * Index action
     */
    function index() {
        $this->data['title'] = 'Semester';
        $this->data['page'] = 'semester';
        $this->data['semester'] = $this->Semester_model->get_all();
        $this->__template('semester/index', $this->data);
    }

    /**
     * Create semester
     */
    function create() {
        if($_POST) {
            $this->Semester_model->insert(array(
                's_name'    => $_POST['s_name'],
                's_status'  => $_POST['semester_status']
            ));
            $this->flash_notification('Semester is successfully added.');
        }
        
        redirect(base_url('semester'));
    }

    /**
     * Update semester
     * @param string $id
     */
    function update($id) {
        if($_POST) {
            $this->Semester_model->update($id, array(
                's_name'    => $_POST['s_name'],
                's_status'  => $_POST['semester_status']
            ));
        }
        
        redirect(base_url('semester'));
    }

    /**
     * Delete semester
     * @param string $id
     */
    function delete($id) {
        if($id) {
            $this->Semester_model->delete($id);
            $this->flash_notification('Semester is successfully deleted.');
        }
        
        redirect(base_url('semester'));
    }

    /**
     * Check semester
     */
    function check_semester() {
        $data = $this->db->get_where('semester', array('s_name' => $this->input->post('semester')))->result();
        if (count($data) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
    
    /**
     * Semester from branch
     * @param string $branch
     */
    function semester_branch($branch) {
        $semester = $this->Semester_model->semester_branch($branch);
        
        echo json_encode($semester);
    }

}

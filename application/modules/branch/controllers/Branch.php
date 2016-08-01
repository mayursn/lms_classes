<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('branch/Course_model');
    }

    /**
     * Index action
     */
    function index() {
        $this->data['title'] = 'Branch';
        $this->data['page'] = 'branch';
        $this->data['branch'] = $this->Course_model->branch_with_degree();
        $this->__template('branch/index', $this->data);
    }

    /**
     * Create new branch
     */
    function create() {
        if ($_POST) {
            $semester = implode(',', $_POST['semester']);
            $this->Course_model->insert(array(
                'c_name' => $_POST['c_name'],
                'course_alias_id' => $_POST['course_alias_id'],
                'c_description' => $_POST['c_description'],
                'course_status' => $_POST['course_status'],
                'degree_id' => $_POST['degree'],
                'semester_id' => $semester
            ));
            $this->flash_notification('Branch is successfully added.');
        }

        redirect(base_url('branch'));
    }

    /**
     * Delete branch
     * @param type $id
     */
    function delete($id) {
        if($id) {
            $this->Course_model->delete($id);
            $this->flash_notification('Branch is successfully deleted.');
        }
        
        redirect(base_url('branch'));
    }

    /**
     * Update branch information
     * @param string $id
     */
    function update($id) {
        if ($_POST) {
            $semester = implode(',', $_POST['semester']);
            $this->Course_model->update($id, array(
                'c_name' => $_POST['c_name'],
                'course_alias_id' => $_POST['course_alias_id'],
                'c_description' => $_POST['c_description'],
                'course_status' => $_POST['course_status'],
                'degree_id' => $_POST['degree'],
                'semester_id' => $semester
            ));
            $this->flash_notification('Branch is successfully updated.');
        }

        redirect(base_url('branch'));
    }

    /**
     * Check course if avail
     */
    function check_course() {
        $data = $this->db->get_where('course', array('c_name' => $this->input->post('course'),
                    'degree_id' => $this->input->post('degree')))->result();

        if (count($data) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
    
    /**
     * Department branch
     * @param type $id
     */
    function department_branch($id) {
        $branch = $this->Course_model->department_branch($id);
        
        echo json_encode($branch);
    }

}

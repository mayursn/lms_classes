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
        $this->load->model('branch/Branch_location_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    /**
     * Index action
     */
    function index() {
        $this->data['title'] = 'Branch';
        $this->data['page'] = 'branch';
        $this->data['branch'] = $this->Branch_location_model->order_by_column('branch_name');
        $this->__template('branch/index', $this->data);
    }

    /**
     * Create new branch
     */
    function create() {
        if ($_POST) {
            
            $this->Branch_location_model->insert(array(
                'branch_name' => $_POST['c_name'],
                'branch_location' => $_POST['branch_location'],                
                'branch_status' => $_POST['branch_status']
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
            $this->Branch_location_model->delete($id);
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
            $this->Branch_location_model->update($id, array(
                'branch_name' => $_POST['c_name'],
                'branch_location' => $_POST['branch_location'],                
                'branch_status' => $_POST['branch_status']
            ));
            $this->flash_notification('Branch is successfully updated.');
        }

        redirect(base_url('branch'));
    }

    /**
     * Check course if avail
     */
    function check_branch() {
        $data = $this->db->get_where('branch_location', array('branch_name' => $this->input->post('course'),
                    'branch_location' => $this->input->post('branch_location')))->result();

        if (count($data) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
    
  

}

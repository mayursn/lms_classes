<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admission_type extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('admission_type/Admission_type_model');
    }

    /**
     * Index action
     */
    function index() {
        $this->data['title'] = 'Admission type';
        $this->data['page'] = 'admission_type';
        $this->data['admission_type'] = $this->Admission_type_model->get_all();
        $this->__template('admission_type/index', $this->data);
    }

    /**
     * Create admission type
     */
    function create() {
        if ($_POST) {
            $this->Admission_type_model->insert(array(
                'at_name' => $_POST['at_name'],
                'at_status' => $_POST['at_status']
            ));
            $this->flash_notification('Admission type is successfully added.');
        }

        redirect(base_url('admission_type'));
    }

    /**
     * Update admission type
     * @param string $id
     */
    function update($id) {
        if ($_POST) {
            $this->Admission_type_model->update($id, array(
                'at_name' => $_POST['at_name'],
                'at_status' => $_POST['at_status']
            ));
            $this->flash_notification('Admission type is successfully updated.');
        }

        redirect(base_url('admission_type'));
    }

    /**
     * Delete admission type
     * @param string $id
     */
    function delete($id) {
        if ($id) {
            $this->Admission_type_model->delete($id);
            $this->flash_notification('Admission type is successfully deleted.');
        }

        redirect(base_url('admission_type'));
    }

    /**
     * Check admission type
     */
    function check_admission_type() {
        $data = $this->db->get_where('admission_type', array('at_name' => $this->input->post('admission_type')))->result();
        if (count($data) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

}

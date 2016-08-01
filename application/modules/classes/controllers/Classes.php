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

}

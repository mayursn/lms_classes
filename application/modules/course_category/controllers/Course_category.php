<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Course_category extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('course_category/Course_category_model');
    }

    /**
     * Index action
     */
    function index() {
        $this->data['title'] = 'Course category';
        $this->data['page'] = 'course_category';
        $this->data['course_category'] = $this->Course_category_model->get_all();
        $this->__template('course_category/index', $this->data);
    }

    /**
     * Create course category
     */
    function create() {
        if ($_POST) {
            $this->Course_category_model->insert(array(
                'category_name' => $_POST['category_name'],
                'category_status' => $_POST['category_status'],
                'category_desc' => $_POST['category_desc']
            ));
            $this->flash_notification('Course category is successfully added.');
        }

        redirect(base_url('course-category'));
    }

    /**
     * Delete course category
     * @param string $id
     */
    function delete($id) {
        if ($id) {
            $this->Course_category_model->delete($id);
            $this->flash_notification('Course category is successfully deleted.');
        }

        redirect(base_url('course-category'));
    }

    /**
     * Update course category
     * @param string $id
     */
    function update($id) {
        if ($_POST) {
            $this->Course_category_model->update($id, array(
                'category_name' => $_POST['category_name'],
                'category_status' => $_POST['category_status'],
                'category_desc' => $_POST['category_desc']
            ));
            $this->flash_notification('Course category is successfully updated.');
        }

        redirect(base_url('course-category'));
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Graduate extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('graduate/Graduates_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    function index() {
        $this->data['title'] = 'Toppers Graduate';
        $this->data['page'] = 'graduate';
        $this->data['graduates'] = $this->Graduates_model->get_all_graduates();
        $this->__template('graduate/index', $this->data);
    }

    /**
     * Create new deparmtents
     */
    function create() {
         if ($_POST) {
              if (is_uploaded_file($_FILES['main_img']['tmp_name'])) {
                    $path = FCPATH . 'uploads/student_image/';
                    if (!is_dir($path)) {
                        mkdir($path, 0777);
                    }
                    $ext = explode(".", $_FILES['main_img']['name']);
                    $ext_file = strtolower(end($ext));
                    $image1 = date('dmYhis') . 'main.' . $ext_file;
                    $config['upload_path'] = 'uploads/student_image';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['file_name'] = $image1;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $main_img = $config['file_name'];
                    //$this->upload->set_allowed_types('*');	

                    if (!$this->upload->do_upload('main_img')) {
                        $this->session->set_flashdata('flash_message', "Invalid File!");
                        redirect(base_url() . 'graduate/', 'refresh');
                    } else {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = 'uploads/student_image/' . $main_img;
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['width'] = 50;
                        $config['height'] = 50;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $file = $this->upload->data();
                        $thumb_img = $file['raw_name'] . '_thumb' . $file['file_ext']; // Here it is
                    }
                } else {
                    $main_img = '';
                }

                $this->Graduates_model->insert(array(
                    'student_id' => $_POST['student'],
                    'degree_id' => $_POST['degree'],
                    'course_id' => $_POST['course'],
                    'batch_id' => $_POST['batch'],
                    'semester_id' => $_POST['semester'],
                    'description' => $_POST['description'],
                    'graduate_year' => $_POST['year'],
                    "student_img" => $main_img,
                    "std_thumb_img" => $thumb_img));
                $this->flash_notification("New Graduate student successfully added");
           
            }
             redirect(base_url('graduate'));
   
    }

    function view($id) {
        
    }

    function edit($id) {
        
    }

    /**
     * Delete Charity Fund
     * @param string $id
     */
    function delete($id) {
        $this->Graduates_model->delete($id);
        $this->flash_notification('Graduate Student is successfully deleted.');
        redirect(base_url('graduate'));
    }

    /**
     * Update Charity Fund 
     * @param string $id
     */
    function update($id = '') {
        if ($_POST) {
               $graduate_std = $this->Graduates_model->get($id);

                if ($_FILES['main_img']['name'] != "") {
                    $path = FCPATH . 'uploads/student_image/';
                    if (!is_dir($path)) {
                        mkdir($path, 0777);
                    }
                    $ext = explode(".", $_FILES['main_img']['name']);
                    $ext_file = strtolower(end($ext));
                    $image1 = date('dmYhis') . 'main.' . $ext_file;
                    $config['upload_path'] = 'uploads/student_image/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['file_name'] = $image1;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $main_img = $config['file_name'];
                    //$this->upload->set_allowed_types('*');	

                    if (!$this->upload->do_upload('main_img')) {
                        $this->session->set_flashdata('flash_message', "Invalid File!");
                        redirect(base_url() . 'graduate/', 'refresh');
                    } else {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = 'uploads/student_image/' . $main_img;
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['width'] = 50;
                        $config['height'] = 50;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $file = $this->upload->data();
                        $thumb_img = $file['raw_name'] . '_thumb' . $file['file_ext']; // Here it is
                    }
                } else {
                    $main_img = $graduate_std->student_img;
                    $thumb_img = $graduate_std->std_thumb_img;
                }
                $this->Graduates_model->update($id,array(
                    'student_id' => $_POST['student'],
                    'degree_id' => $_POST['degree'],
                    'course_id' => $_POST['course'],
                    'batch_id' => $_POST['batch'],
                    'semester_id' => $_POST['semester'],
                    'description' => $_POST['description'],
                    'graduate_year' => $_POST['year'],
                    "student_img" => $main_img,
                    "std_thumb_img" => $thumb_img));
                $this->flash_notification("Graduate student successfully updated");
               
        }

        redirect(base_url('graduate'));
    }

}

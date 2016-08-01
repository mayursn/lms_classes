<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chancellor extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('chancellor/University_peoples_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    function index() {
        $this->data['title'] = 'Chancellor';
        $this->data['page'] = 'chancellor';
        $this->data['chancellor'] = $this->University_peoples_model->order_by_column('people_name');
       
        $this->__template('chancellor/index', $this->data);
    }
    
    function create() {
        if ($_POST) {
                $data['people_name'] = $this->input->post('name');
                $data['people_phone'] = $this->input->post('mobileno');
                $data['people_email'] = $this->input->post('email_id');
                $data['people_designation'] = $this->input->post('designation');
                $data['people_description'] = $this->input->post('description');
                $data['facebook_link'] = $this->input->post('facebook');
                $data['twitter_link'] = $this->input->post('twitter');
                $data['google_plus_link'] = $this->input->post('googleplus');

                if ($_FILES['profilefile']['name'] != '') {

                    $config['upload_path'] = 'uploads/system_image';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('profilefile')) {
                        $this->flash_notification("Invalid File!");
                        redirect(base_url('chancellor'));
                    } else {
                        $file = $this->upload->data();
                        $data['people_photo'] = $file['file_name'];
                    }
                } else {

                    $data['people_photo'] = '';
                }

                $this->University_peoples_model->insert($data);
                
           $this->flash_notification('Chancellor is successfully added.');
        }

        redirect(base_url('chancellor'));
    }
    
     function delete($id) {
        $this->University_peoples_model->delete($id);
        $this->flash_notification('Chancellor is successfully deleted.');

        redirect(base_url('chancellor'));
    }
    
    function update($id = '') {
        if ($_POST) {
              $data['people_name'] = $this->input->post('name');
                $data['people_phone'] = $this->input->post('mobileno');
                $data['people_email'] = $this->input->post('email_id');
                $data['people_designation'] = $this->input->post('designation');
                $data['people_description'] = $this->input->post('description');
                $data['facebook_link'] = $this->input->post('facebook');
                $data['twitter_link'] = $this->input->post('twitter');
                $data['google_plus_link'] = $this->input->post('googleplus');

                if ($_FILES['profilefile']['name'] != '') {
                    unlink("uploads/system_image/" . $this->input->post('txtoldfile'));
                    $config['upload_path'] = 'uploads/system_image';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('profilefile')) {
                        $this->flash_notification("Invalid File!");
                        redirect(base_url() . 'chancellor/', 'refresh');
                    } else {
                        $file = $this->upload->data();
                        $data['people_photo'] = $file['file_name'];
                    }
                }
                $this->University_peoples_model->update($id, $data);
            $this->flash_notification('Chancellor is successfully updated.');
        }

        redirect(base_url('chancellor'));
    }
}

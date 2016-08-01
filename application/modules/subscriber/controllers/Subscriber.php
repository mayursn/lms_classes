<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber extends MY_Controller {
    
    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('subscriber/Subscriber_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }
    
     function index() {
        $this->data['title'] = 'Subscriber';
        $this->data['page'] = 'subscriber';
        $this->data['subscriber'] = $this->Subscriber_model->order_by_column('id');
        $this->__template('subscriber/index', $this->data);
    }
    
      function delete($id) {
        $this->Subscriber_model->delete($id);
        $this->session->set_flashdata('flash_message', 'Subscriber is successfully deleted.');
        redirect(base_url('subscriber'));
    }
}
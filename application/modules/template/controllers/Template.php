<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends MY_Controller {
    
    /**
     * Constructor
     * 
     * @return void
     */
    function __constuct() {
        parent::__constuct();
    }
    
    /**
     * Render the view page in the template
     * @param string $page_name
     * @param mixed $data
     */
    function render($page_name='', $data = array()) {
        if($this->session->userdata('std_id'))
        {
            $this->load->view('std_header', $data);
        }
        else{
            $this->load->view('header', $data);
        }
        $this->load->view($page_name);
        $this->load->view('footer');
    }
    
    /**
     * Display modal popup
     * @param string $page_name
     * @param array $data
     */
    function modal($page_name, $data) {
        $this->load->view($page_name, $data);
    }
}
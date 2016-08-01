<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

    public $data = array();

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *'); 
        $this->load->language('lms');
        $this->data['currency'] = system_info('currency');

        if ($this->is_user_logged_in()) {
            $this->login_user_role_permission();           
            if(!count($this->data['permission'])) {
                echo '<h3>You don\'t have permission to access any module. Pleace contact admin</h3>';
                exit;
            }
        }
        if($this->session->userdata('std_id'))
        {
         $notification = show_notification($this->session->userdata('std_id'));                            
         $this->session->set_userdata('notifications', $notification);
        }
        if ($this->session->userdata('last_activity')) {
            user_activity();
        }
        //$this->output->enable_profiler(TRUE);
    }

    /**
     * Check user logged in or not then redirect
     */
    function login_check_and_redirect_user() {
        $is_user_logged_in = $this->is_user_logged_in();

        if ($is_user_logged_in) {
            redirect(base_url('user/dashboard'));
        } else {
            redirect(base_url('user/login'));
        }
    }

    /**
     * Redirect on login page if user not logged in
     */
    function redirect_if_user_not_logged_in() {
        $is_user_logged_in = $this->is_user_logged_in();

        if (!$is_user_logged_in) {
            redirect(base_url('user/login'));
        }
    }

    /**
     * Check for whether user logged in or not
     * @return boolean
     */
    function is_user_logged_in() {
        $is_user_logged_in = (bool) $this->session->userdata('is_logged_in');

        return $is_user_logged_in;
    }

    /**
     * Template
     * @param string $page_name
     * @param mixed $data
     */
    function __template($page_name, $data) {
        echo Modules::run('template/template/render', $page_name, $data);
    }

    /**
     * Modal
     * @param string $page_name
     * @param mixed $data
     */
    function __modal($page_name, $data) {
        echo Modules::run('template/template/modal', $page_name, $data);
    }

    /**
     * Set the flash notifacation
     * @param string $message
     */
    function flash_notification($message) {
        $this->session->set_flashdata('flash_message', $message);
    }

    /**
     * Get the login user permission
     */
    function login_user_role_permission() {
        $this->load->model('user/Module_role_permission_model');
        $login_user_details = $this->session->all_userdata();

        $user_role_module = $this->Module_role_permission_model
                ->role_permission_with_module($login_user_details['role_id']);

        foreach($user_role_module as $row) {
            $module = str_replace(' ', '_', $row->module_name);
            $this->data['permission'][$module] = array();
            array_push($this->data['permission'][$module], str_split($row->user_permission));
        }
    }

    /**
     * Email configuration and load library
     */
    function __config_and_load_email_library() {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'mayur.panchal@searchnative.in',
            'smtp_pass' => 'Mayur@@123',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        
        return $config;
    }

}

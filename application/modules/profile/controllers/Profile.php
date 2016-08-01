<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('profile/Profile_model');
        $this->load->model('user/User_model');
    }

    function index() {
        $this->data['title'] = 'Profile';
        $this->data['page'] = 'profile';
         $this->data['profile'] = $this->User_model->get_user();
        $this->__template('profile/index', $this->data);
    }
    
    function checkpassword()
    {
        $oldpassword=$this->input->post('oldpassword');
        $currentpassword=hash('md5', trim($this->input->post('currentpassword')) . config_item('encryption_key'));
        
        if($oldpassword==$currentpassword)
        {
            echo 'true';
        }
        else
        {
            echo 'false';
        }
    }
    
    function change_password()
    {
         if ($_POST) {
        $data=array('password'=>hash('md5', trim($this->input->post('new_password')) . config_item('encryption_key')));
        $this->User_model->update($this->session->userdata('user_id'),$data);
        
         $this->flash_notification('Password is successfully updated.');
        }
        redirect(base_url('profile'));
    }
    
    function change_profile()
    {
        
        $data=array('first_name'=>$this->input->post('fname'),
                    'last_name'=>$this->input->post('lname'),
                    'email'=>$this->input->post('email'),
                    'gender'=>$this->input->post('gender'),
                    'mobile'=>$this->input->post('mobile'),
                    'city'=>$this->input->post('city'),
                    'zip_code'=>$this->input->post('zip')
            );
        
        $filedata=Modules::run('professor/update_professor_profile_pic',$_FILES);
        if($filedata!="")
        {
           $data['profile_pic']=$filedata; 
        }
        $this->User_model->update($this->session->userdata('user_id'),$data);
        if($this->session->userdata('role_name')=="Staff")
        {
            $dataprofessor=array('name'=>$this->input->post('fname'),
                    'email'=>$this->input->post('email'),
                    'mobile'=>$this->input->post('mobile'),
                    'city'=>$this->input->post('city'),
                    'zip'=>$this->input->post('zip'));
            $this->Profile_model->professor_update($this->session->userdata('user_id'),$dataprofessor);
        }
         redirect(base_url('profile'));
    }
}

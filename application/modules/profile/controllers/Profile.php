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
        $this->load->model('student/Student_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    function index() {
        $this->data['title'] = 'Profile';
        $this->data['page'] = 'profile';
         $this->data['profile'] = $this->User_model->get_user();
         if($this->session->userdata('role_name')=='Student')
         {
             $this->data['studentprofile'] = $this->Student_model->get_by(array('user_id'=>$this->session->userdata('user_id')));
         }
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
        $this->User_model->password_update($this->session->userdata('user_id'),$data);
        
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
        $this->User_model->profile_update($this->session->userdata('user_id'),$data);
        if($this->session->userdata('role_name')=="Staff")
        {
            $dataprofessor=array('name'=>$this->input->post('fname'),
                    'email'=>$this->input->post('email'),
                    'mobile'=>$this->input->post('mobile'),
                    'city'=>$this->input->post('city'),
                    'zip'=>$this->input->post('zip'));
            $this->Profile_model->professor_update($this->session->userdata('user_id'),$dataprofessor);
        }
        $this->flash_notification("profile updated successfully.");
         redirect(base_url('profile'));
    }
    function student_change_profile()
    {
         $data=array('parent_name'=>$this->input->post('parentname'),
                    'parent_contact'=>$this->input->post('parentcontact'),
                    'parent_email'=>$this->input->post('parent_email_id'),
                    'std_fb'=>$this->input->post('facebook'),
                    'std_twitter'=>$this->input->post('twitter')
            );
          $this->Profile_model->student_update($this->session->userdata('user_id'),$data);
          redirect(base_url('profile'));
    }
    
    
}

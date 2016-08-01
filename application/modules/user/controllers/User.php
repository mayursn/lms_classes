<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('user/User_model');
        $this->load->model('todo/Todo_list_model');
        $this->load->model('professor/Professor_model');
    }

    /**
     * Index
     */
    function index() {
        if ($this->is_user_logged_in()) {
            redirect('user/dashboard');
        }
        $this->dashboard();
    }

    /**
     * Login
     */
    function login() {
        
        if ($this->is_user_logged_in()) {
            redirect('user/dashboard');
        }

        if ($_POST) {
            $email = trim($this->input->post('email'));
            $password = $this->__hash(trim($this->input->post('password')));
            $this->process_login($email, $password);
        }
        $this->data['title'] = 'User Login';
        $this->load->view('user/user/login', $this->data);
    }

    /**
     * Process login
     * @param string $email
     * @param string $passowrd
     */
    function process_login($email = '', $passowrd = '') {
        if ($email && $passowrd) {
            $user = $this->User_model->with('role')
                    ->get_by(array(
                'email' => $email,
                'password' => $passowrd,
                'is_active' => 1
                    )
            );

            if ($user) {
                if ($user->role->role_id == "3") {
                    $this->load->model('student/Student_model');
                    $user_id = $user->user_id;
                    $this->db->where("user_id", $user_id);
                    $std = $this->db->get("student")->row();
                    
                    $this->session->set_userdata("std_id", $std->std_id);
                    $this->session->set_userdata("std_degree", $std->std_degree);
                    $this->session->set_userdata("std_batch", $std->std_batch);
                    $this->session->set_userdata("course_id", $std->course_id);
                    $this->session->set_userdata("semester_id", $std->semester_id);
                    $this->session->set_userdata("class_id", $std->class_id);
                    
                   
                }

                if ($user->role->role_id == "2") {
                    $this->load->model('professor/Professor_model');
                    $user_id = $user->user_id;
                    $this->db->where("user_id", $user_id);
                    $professor = $this->db->get("professor")->row();
                    $this->session->set_userdata("professor_id", $professor->professor_id);
                    $this->session->set_userdata("professor_department", $professor->department);
                }
                $session_data = array(
                    'user_id' => $user->user_id,
                    'email' => $user->email,
                    'is_logged_in' => TRUE,
                    'role_id' => $user->role->role_id,
                    'role_name' => $user->role->role_name
                );
                $this->session->set_userdata($session_data);

                redirect(base_url('user/dashboard'));
            } else {
                $this->session->set_flashdata('message', 'Invalid username or password');
                $this->session->set_flashdata('type', 'danger');
                redirect(base_url('user/login'));
            }
        } else {
            redirect(base_url('user/login'));
        }
    }

    /**
     * Generate hash of the data
     * @param string $str
     * @return string
     */
    function __hash($str) {
        return hash('md5', $str . config_item('encryption_key'));
    }

    /**
     * Dashboard
     */
    function dashboard() {
        $this->redirect_if_user_not_logged_in();
        $this->data['title'] = 'Dashboard';
        $this->data['page'] = 'dashboard';
        $this->data['todolist'] = $this->Todo_list_model->get_todo();

        if ($this->session->userdata('std_id')) {
            $this->data['timeline'] = $this->Crud_model->get_timline();
            redirect(base_url() . 'student/dashboard');
        } elseif ($this->session->userdata('professor_id')) {
            redirect(base_url() . 'professor/dashboard');
        } else {

            $this->load->helper('report_chart');

            $this->data['new_student_joining'] = new_student_registration();
            $this->data['male_vs_female_course_wise'] = male_vs_female_course_wise();
            $this->calendar_json();
            $this->data['todolist'] = $this->Todo_list_model->get_todo();
            $this->data['recent_professor'] = $this->Professor_model->get_recent_professor();
            $this->data['title'] = 'Dashboard';
            $this->data['page'] = 'dashboard';
            $this->__template('user/user/dashboard', $this->data);
        }
    }

    /**
     * Logout from the system
     */
    function logout() {
        $this->session->sess_destroy();

        redirect(base_url('user/login'));
    }

    function change_password() {
        
    }

    function forgot_password() {
         $this->load->model('site/Site_model');
        if ($_POST) {
           
            //check for student
            $record = $this->Site_model->is_user_email_present($_POST['email']);
            
            if ($record) {
                // send email for forgot password
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'mayur.panchal@searchnative.in',
                    'smtp_pass' => 'Mayur@@123',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );

                $user_id = $record->user_id;
                $random_string = $this->random_string_generate();
               
                $this->update_forgot_password_key('', $user_id, $random_string);
                $url = $this->forgot_password_url('', $user_id, $random_string);
              
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('mayur.panchal@searchnative.in', 'Learning Management System');
                $this->email->to($_POST['email']);
                $this->email->subject('Reset your LMS password');
                $message = "Please click on below link to reset your LMS password";
                $message .= "<br/>";
                $message .= $url;
                
                $this->email->message($message);
                $this->email->send();
                $this->session->set_flashdata('success', 'Please check email to reset your password.');
                redirect(base_url('user/login'));
            } else {
                // email is not registered in the system
                $this->session->set_flashdata('email_not_found', 'Email is not registered in the system.');
                redirect(base_url('user/login'));
            }
            //check for admin
            //check for professor
        } else {
           redirect(base_url('user/login'));
    }
    }

      /**
     * Generate random string
     * @return string
     */
    function random_string_generate() {
        $this->load->helper('string');
        return random_string('alnum', 16);
    }
    
    
    /**
     * Update forgot password key for user
     * @param string $user_type
     * @param string $user_id
     * @param string $key
     */
    function update_forgot_password_key($user_type, $user_id, $key) {
        if ( $user_id != '' && $key != '') {
            $this->Site_model->update_forgot_password_key($user_type, $user_id, $key);
        } else {
            redirect(base_url('user/login'));
        }
    }
    
      /**
     * Forgot password url
     * @param string $user_type
     * @param string $user_id
     * @param string $random_string
     * @return string
     */
    function forgot_password_url($user_type, $user_id, $random_string) {
        $this->load->library('encrypt');
        $base_url = base_url();
        $user_type = hash('md5', $user_type . config_item('encryption_key'));

        return $base_url . 'user/reset_password/' .$user_id. '/' . 'user' . '/' . $random_string;
    }
    
     /**
     * Reset password
     * @param string $user_id
     * @param string $user_type
     * @param string $key
     */
    function reset_password($user_id = '', $user_type = '', $key = '') {
        $this->load->model('site/Site_model');
        if ($_POST) {
            if ($this->compare_reset_password($_POST['password'], $_POST['confirm_password'])) {
                // update password
                //$user_type = $this->check_user_type_hash($user_type);

                $data = array(
                    'password' => $this->__hash(trim($_POST['password']))
                    //'password' => hash('md5', $_POST['password'])
                );
                

                $user_data = $this->Site_model->update_password($user_type, $user_id, $data);

                //reset forgot password key
                $this->Site_model->reset_forgot_password_key($user_data['type'], $user_data['type_id'], $user_data['user_id']);

                $this->flash_notification('success', 'Password was successully reseted.');
                redirect(base_url('user/login'));
            } else {
                $this->flash_notification('danger', 'Password was mismatched.');
                redirect(base_url('user/reset_password/' . $user_id . '/' . $user_type . '/' . $key));
            }
        }

        if ($user_id && $user_type && $key) {
           // $user_type = $this->check_user_type_hash($user_type);
            $is_key_present = $this->Site_model->check_for_forgot_password_key($user_type, $key);
            if ($is_key_present) {
                $this->data['title'] = 'Forgot Password';
                $this->load->view('user/user/reset_password', $this->data);
                
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }
    
     /**
     * Check user type hash
     * @param string $hash
     * @return string
     */
    function check_user_type_hash($hash) {
//        if (hash('md5', 'admin' . config_item('encryption_key')) == $hash)
//            return 'admin';
//        elseif (hash('md5', 'student' . config_item('encryption_key')) == $hash)
//            return 'student';
//        elseif (hash('md5', 'professor' . config_item('encryption_key')) == $hash)
//            return 'professor';
         if (hash('md5', 'user' . config_item('encryption_key')) == $hash)
            return 'user';
    }
    
    /**
     * User list
     */
    function user_list() {
        $this->data['title'] = 'Users List';
        $this->data['page'] = 'user';
        $this->data['users'] = $this->User_model->get_users();
        $this->__template('user/user/user_list', $this->data);
    }

    /**
     * Compare reset password
     * @param string $password
     * @param strin $confirm_password
     * @return boolean
     */
    function compare_reset_password($password, $confirm_password) {
        if (trim($password) == trim($confirm_password)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Create user
     */
    function create() {
        if ($_POST) {
            $this->User_model->insert(array(
                'first_name' => $_POST['first_name'],
                'middle_name' => $_POST['middle_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => $this->__hash($_POST['password']),
                'gender' => $_POST['gender'],
                'mobile' => $_POST['mobile'],
                'phone' => $_POST['phone'],
                'city' => $_POST['city'],
                'zip_code' => $_POST['zip_code'],
                'address' => $_POST['address'],
                'role_id' => $_POST['role'],
                'is_active' => 1
            ));
            $this->flash_notification('New user is successfully created.');
        }

        redirect(base_url('user/user_list'));
    }

    function delete($id) {
        
    }

    /**
     * Update user information
     * @param string $id
     */
    function update($id = '') {
        if ($_POST) {
            $this->User_model->update($id, array(
                'first_name' => $_POST['first_name'],
                'middle_name' => $_POST['middle_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                //'password' => $this->__hash($_POST['password']),
                'gender' => $_POST['gender'],
                'mobile' => $_POST['mobile'],
                'phone' => $_POST['phone'],
                'city' => $_POST['city'],
                'zip_code' => $_POST['zip_code'],
                'address' => $_POST['address'],
                'role_id' => $_POST['role'],
                'is_active' => $_POST['status']
            ));
            $this->password_compare_and_update($id, $_POST['password']);
            $this->flash_notification('User is successfully updated.');
        }

        redirect(base_url('user/user_list'));
    }

      /**
     * Compare and update password
     * @param string $user_id
     * @param string $password
     * @return string
     */
    function password_compare_and_update($user_id, $password) {
        $user = $this->User_model->get($user_id);

        if ($user->password !== $password) {
            $password = Modules::run('user/__hash', $password);
            $this->User_model->update($user_id, array(
                'password' => $password
            ));
        }
    }

    /**
     * Check user email
     */
    function check_user_email($param = '') {
        $email = $this->input->post('email');
        if ($param == '') {
            $data = $this->User_model->get_by(array(
                'email' => $email
            ));
            if ($data) {
                echo "false";
            } else {
                echo "true";
            }
        } else {
            $data = $this->User_model->get_by(array(
                'user_id !=' => $this->input->post('userid'),
                'email' => $email
            ));
            if ($data) {
                echo "false";
            } else {
                echo "true";
            }
        }
    }

    function users_with_role($role_id) {
        $users = $this->User_model->with('role')
                ->get_many_by(array(
            'role_id' => $role_id
        ));

        echo json_encode($users);
    }   
/**
     * Calendate json
     */
    function calendar_json() {
        $this->load->helper('file');
        $this->db->select('event_date AS date, event_name AS title, event_location AS Location, event_desc AS description');
        $this->db->select('DATE_FORMAT(event_date, "%d %b %Y") AS event_start_date, TIME_FORMAT(event_date, "%h:%i %p") AS event_start_time');
        $this->db->from('event_manager');
        $query = $this->db->get();
        $file = FCPATH . 'event.humanDate.json.php';
        $result = json_encode($query->result());

        write_file($file, $result);
    }
  function get_today_event()
    {
        $event=$this->db->get_where('event_manager',array('date(event_date)'=>date('Y-m-d')))->result_array();
       
        echo json_encode($event);
    }

}

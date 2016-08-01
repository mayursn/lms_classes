<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vocationalcourse extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('vocationalcourse/Vocational_course_model');
        $this->load->model('vocationalcourse/Vocational_course_fee_model');
    }

    function index() {
        $this->data['title'] = 'Vocational Course';
        $this->data['page'] = 'Vocationalcourse';
       if($this->session->userdata('std_id'))
       {
         $this->data['register'] = $this->db->query('SELECT * FROM vocational_course 
                    WHERE EXISTS (SELECT vocational_course_id FROM vocational_course_fee
                    WHERE vocational_course_fee.vocational_course_id = vocational_course.vocational_course_id and vocational_course_fee.student_id= ' . $this->session->userdata('std_id') . ')  ORDER BY vocational_course.course_startdate DESC')->result_array();
         
       }
        $this->data['vocationalcourse'] = $this->Vocational_course_model->order_by_column('course_name');
        $this->data['vocationalcoursefee']=$this->Vocational_course_fee_model->get_course();
        
        $this->__template('vocationalcourse/index', $this->data);
    }
    
     function create() {
         if ($_POST) {
            
                $data['course_name'] = $this->input->post('course_name');
                $data['course_startdate'] = date('Y-m-d', strtotime($this->input->post('startdate')));
                $data['course_enddate'] = date('Y-m-d', strtotime($this->input->post('enddate')));
                $data['course_fee'] = $this->input->post('fee');
                $data['professor_id'] = $this->input->post('professor');
                $data['category_id'] = $this->input->post('category_id');
                $data['status'] = $this->status($this->input->post('course_status'));
                $this->Vocational_course_model->insert($data);
              
            $this->flash_notification('Vocational course is successfully added.');
        }
        redirect(base_url('vocationalcourse'));
    }
    
     function update($id = '') {
        if ($_POST) {
                  $data['course_name'] = $this->input->post('course_name');
                $data['course_startdate'] = date('Y-m-d', strtotime($this->input->post('startdate1')));
                $data['course_enddate'] = date('Y-m-d', strtotime($this->input->post('enddate1')));
                $data['course_fee'] = $this->input->post('fee');
                $data['professor_id'] = $this->input->post('professor');
                $data['category_id'] = $this->input->post('category_id');
                $data['status'] = $this->input->post('course_status');
                $data['updated_date'] = date('Y-m-d');
                $this->Vocational_course_model->update($id, $data);

            $this->flash_notification('Vocational course is successfully updated.');
        }

        redirect(base_url('vocationalcourse'));
    }
    function delete($id) {
        $this->Vocational_course_model->delete($id);
        $this->flash_notification('Vocational course is successfully deleted.');

        redirect(base_url('vocationalcourse'));
    }
    function vocational_registered_student($param1 = '')
    {
        $this->data['title'] = 'Vocational Course';
        $this->data['page'] = 'Vocationalcourse';
        $this->data['student'] = $this->Vocational_course_model->get_vocational_student($param1);
        $this->load->view('vocationalcourse/student', $this->data);
    }
    
    function register_course($param1 = '')
    {
        $this->data['vocationalcourse'] = $this->Vocational_course_model->get_by(array(
            'vocational_course_id' => $param1
        ));
        $this->data['page'] = 'register_vocational_course';
        $this->data['title'] = 'Vocational Course Fee';
        $this->__template('vocationalcourse/register_vocational_course', $this->data);
    }
    
    function pay_online_vocational_course() {
        if ($_POST) {
            //set payment data in session
            $session['payment_info'] = array(
                'student_id' => $this->session->userdata('user_id'),
                'amount' => $_POST['amount'],
                'vocational_courseid' => $_POST['voc_course'],
            );
            $this->session->set_userdata($session);
            //echo '<pre>';
            //var_dump($_POST);
            redirect(base_url('vocationalcourse/vocational_payment_gateway_type/' . $_POST['method']));
        } else {
            redirect(base_url('vocationalcourse'));
        }
    }
     function vocational_payment_gateway_type($type) {
        $this->load->model('admin/Crud_model');
        if ($type == 'authorize.net') {
            //load authorize.net payment getaway page
            $this->data['authorize_net'] = $this->Crud_model->authorize_net_config();
        }
        $this->data['title'] = 'Make Payment';
        $this->data['page'] = 'vocational_make_payment';
        $this->__template('vocationalcourse/vocational_make_payment', $this->data);
    }
     function status($str) {
        if ($str) {
            return 1;
        } else {
            return 0;
        }
    }
}

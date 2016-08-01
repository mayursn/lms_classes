<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('fees/Fees_structure_model');
        $this->load->model('student/Student_model');
        $this->load->model('department/Degree_model');
        $this->load->model('branch/Branch_location_model');
        $this->load->model('courses/Course_model');
        $this->load->model('admission_plan/Admission_plan_model');
        $this->load->model('classes/Class_model');
        $this->load->model('feerecord/Student_fees_model');
        $this->load->model('payment_gateway_config/Authorize_net_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    /**
     * index page
     */
    function index() {
        if($this->session->userdata('std_id'))
        {
            redirect(base_url().'payment/student_fees');
        }
        $this->data['department'] = '';
        $this->data['branch'] = '';
        $this->data['batch'] = '';
        $this->data['semester_list'] = '';
        $this->data['fee_structure'] = '';

        $this->data['title'] = 'Make Payment';
        $this->data['page'] = 'make_payment';
        $this->data['authorize_net'] = $this->Authorize_net_model->order_by_column('login_id');
        $this->data['branch'] = $this->Branch_location_model->order_by_column('branch_name');
        $this->data['class'] = $this->Class_model->order_by_column('class_name');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['admission_plan'] = $this->Admission_plan_model->order_by_column('admission_duration');
        $this->data['student_fees'] = $this->Student_fees_model->all_student_fees();

        $this->__template('payment/index', $this->data);
    }

    /**
     * Due Amount student list
     */
    function due_amount() {
        $this->load->model('student/Student_model');
        $this->data['course'] = '';
        $this->data['branch'] = '';
        $this->data['admission_plan'] = '';
        $this->data['class'] = '';
        $this->data['fee_structure'] = '';
        if ($_POST) {
            $this->data['course'] = $_POST['course'];
            $this->data['branch'] = $_POST['branch'];
            $this->data['admission_plan'] = $_POST['admission_plan'];
            $this->data['class'] = $_POST['class'];
            $this->data['fee_structure'] = $_POST['fee_structure'];

            $students = $this->Student_model->get_many_by(array(
                'branch_id' => $this->data['branch'],
                'course_id' => $this->data['course'],
                'admission_plan_id' => $this->data['admission_plan'],
                'class_id' => $this->data['class']));

            $this->data['students'] = $students;
            $this->data['fee_structure_info'] = $this->Fees_structure_model->get($_POST['fee_structure']);
        }
        $this->data['title'] = 'Due Amount';
        $this->data['page'] = 'due_amount';
        $this->load->model('branch/Branch_location_model');
        $this->load->model('course/Course_model');
        $this->load->model('classes/Class_model');
        $this->data['branch'] = $this->Branch_location_model->get_all();
        $this->data['course'] = $this->Course_model->get_all();
        $this->data['class'] = $this->Class_model->get_all();
        $this->__template('payment/due_amount', $this->data);
    }

    /**
     * insert payment
     */
    function create() {
        $this->Student_fees_model->insert([
            'student_id' => $_POST['student'],
            'fees_structure_id' => $_POST['fees_structure'],
            'paid_amount' => $_POST['fees'],
            'course_id' => $_POST['course'],
            'branch_id' => $_POST['branch'],
            'admission_plan_id' => $_POST['admission_plan'],
            'class_id' => $_POST['class'],
            'fee_title' => '',
            'remarks' => $_POST['c_description'],
            'payment_type' => 'cheque',
            'cheque_number' => $_POST['cheque_number'],
            'bank_name' => $_POST['bank_name'],
            'ac_holder_name' => $_POST['ac_holder_name'],
            'paid_created_at' => date('Y-m-d H:i:s', strtotime($_POST['date'] . date('H:i:s')))
        ]);
        $this->flash_notification('Student payment is successfully done.');
        redirect(base_url() . 'payment');
    }

    /**
     * Fee structure ajax filter
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     */
    function fee_structure_filter($degree, $course, $batch, $semester) {
        $this->data['fees_structure'] = $this->Fees_structure_model->fee_structure_filter($degree, $course, $batch, $semester);
        $this->load->view("fees/fee_structure_filter", $this->data);
    }

    /**
     * Student list with payment list
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     * @param string $fee_structure
     */
    function make_payment_student_list($branch = '', $course = '', $admission_plan = '', $class = '', $fee_structure = '') {
        $this->data['student_fees'] = $this->Student_fees_model->make_payment_student_list($branch, $course, $admission_plan, $class, $fee_structure);

        $this->load->view('payment/make_payment_student_list', $this->data);
    }

    /**
     * Fee structure filter
     * @param string $degree
     * @param string $branch
     * @param string $batch
     * @param string $semester
     */
    function student_fee_structure($branch,$course, $admission_plan, $class) {
        $fee_structure = $this->Student_fees_model->fee_structure_filter($branch, $course, $admission_plan, $class);

        echo json_encode($fee_structure);
    }

     /**
     * Course semester fees structure
     * @param string $course_id
     * @param string $semester_id
     */
    function course_semester_fees_structure($course_id = '', $semester_id = '') {
        $where1 = "course_id='$course_id' OR course_id='All'";
        $where2 = "sem_id='$semester_id' OR sem_id='All'";
        $this->db->where($where1);
        $this->db->where($where2);            
        $fees_structure = $this->db->get('fees_structure')->result();
        echo json_encode($fees_structure);
    }

    /**
     * Student paid fees
     * @param string $fees_structure_id
     * @param string $student_id
     */
    function student_paid_fees($fees_structure_id = '', $student_id = '') {
        $this->load->model('student/Student_model');
        $this->load->model('fees/Fees_structure_model');
        $page_data = array();
        $total_paid = 0;
        $fees_structure = $this->Fees_structure_model->get($fees_structure_id);
        $page_data['total_fees'] = $fees_structure->total_fee;
        $paid_fees = $this->Fees_structure_model->student_paid_fees($fees_structure_id, $student_id);
        if (count($paid_fees)) {
            foreach ($paid_fees as $paid) {
                $total_paid += $paid->paid_amount;
            }
        }
        if (count($fees_structure)) {
            $page_data['due_amount'] = $fees_structure->total_fee - $total_paid;
            $page_data['total_paid'] = $total_paid;
        } else {
            $page_data['due_amount'] = $fees_structure->total_fee;
            $page_data['total_paid'] = 0;
        }

        echo json_encode($page_data);
    }

    function student_fees() {
        $this->load->model('Student/Student_model');
        $this->data['student_detail'] = $this->Student_model->get($this->session->userdata('std_id'));
        $student_detail = $this->data['student_detail'];
        $this->data['fees_structure'] = $this->Student_fees_model->get_fees_list($student_detail);
        //$this->data['semester'] = $this->Semester_model->get_all();
        $this->data['fees_record'] = $this->Student_fees_model->fees_record($this->session->userdata('std_id'));
        $this->data['page'] = 'student_fees';
        $this->data['title'] = 'Pay Online';
        clear_notification('fees_structure', $this->session->userdata('std_id'));
        unset($this->session->userdata('notifications')['fees_structure']);
        $this->__template('student/student_fees', $this->data);
    }
    
    /**
     * Pay online
     */
    function pay_online() {
        if ($_POST) {
            //set payment data in session
            $session['payment_info'] = array(
                'student_id' => $this->session->userdata('std_id'),
                'fees_structure' => $_POST['fees_structure'],
                'semester' => $_POST['semester'],
                'amount' => $_POST['amount'],
                'title' => $_POST['title'],
                'remarks' => $_POST['description']
            );
            $this->session->set_userdata($session);
            //echo '<pre>';
            //var_dump($_POST);
            redirect(base_url('payment/payment_gateway_type/' . $_POST['method']));
        } else {
            redirect(base_url('payment/student_fees'));
        }
    }
    
      /**
     * Payment gateway type
     * @param string $type
     */
    function payment_gateway_type($type) {
        $this->load->model('payment_gateway_config/Authorize_net_model');
        $this->load->model('branch/Branch_location_model');
        $this->load->model('courses/Course_model');
        $this->load->model('admission_plan/Admission_plan_model');
        $this->load->model('classes/Class_model');
        
        if ($type == 'authorize.net') {
            //load authorize.net payment getaway page
            $this->data['authorize_net'] = $this->Authorize_net_model->order_by_column('login_id');
            $this->data['branch'] = $this->Degree_model->get_all();
            $this->data['course'] = $this->Course_model->get_all();
            $this->data['class'] = $this->Class_model->get_all();
            $this->data['admission_plan'] = $this->Admission_plan_model->get_all();
        }
        $this->data['title'] = 'Make Payment';
        $this->data['page'] = 'make_payment';
        $this->__template('payment/make_payment', $this->data);
    }
    
    
    /**
     * Verify and print verify card details
     */
    function verify_card_detail($cc_number) {
        $cc_details = $this->validateCreditcard_number($cc_number);
        echo json_encode($cc_details);
    }
    
     /**
     * Validate credit card number
     * @param int $cc_num
     * @return array
     */
    function validateCreditcard_number($cc_num) {
        $credit_card_number = $this->sanitize($cc_num);
        // Get the first digit
        $data = array();
        $firstnumber = substr($credit_card_number, 0, 1);
        // Make sure it is the correct amount of digits. Account for dashes being present.
        switch ($firstnumber) {
            case 3:
                $data['card_type'] = "American Express";
                if (!preg_match('/^3\d{3}[ \-]?\d{6}[ \-]?\d{5}$/', $credit_card_number)) {
                    //return 'This is not a valid American Express card number';
                    $data['status'] = 'false';
                    return $data;
                }
                break;
            case 4:
                $data['card_type'] = "Visa";
                if (!preg_match('/^4\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number)) {
                    //return 'This is not a valid Visa card number';
                    $data['status'] = 'false';
                    return $data;
                }
                break;
            case 5:
                $data['card_type'] = "MasterCard";
                if (!preg_match('/^5\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number)) {
                    //return 'This is not a valid MasterCard card number';
                    $data['status'] = 'false';
                    return $data;
                }
                break;
            case 6:
                $data['card_type'] = "Discover";
                if (!preg_match('/^6011[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number)) {
                    //return 'This is not a valid Discover card number';
                    $data['status'] = 'false';
                    return $data;
                }
                break;
            default:
                //return 'This is not a valid credit card number';
                $data['card_type'] = "Invalid";
                $data['status'] = 'false';
                return $data;
        }
        // Here's where we use the Luhn Algorithm
        $credit_card_number = str_replace('-', '', $credit_card_number);
        $map = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 2, 4, 6, 8, 1, 3, 5, 7, 9);
        $sum = 0;
        $last = strlen($credit_card_number) - 1;
        for ($i = 0; $i <= $last; $i++) {
            $sum += $map[$credit_card_number[$last - $i] + ($i & 1) * 10];
        }
        if ($sum % 10 != 0) {
            //return 'This is not a valid credit card number';
            $data['status'] = 'false';
            return $data;
        }
        // If we made it this far the credit card number is in a valid format
        $data['status'] = 'true';
        return $data;
    }

    /**
     * Sanitize the input
     */
    function sanitize($value) {
        return trim(strip_tags($value));
    }



     /**
     * Authorize.net payment
     */
    function authorize_net_make_payment() {
        $this->load->library('authorize_net');
        if ($_POST) {
            $student_detail = $this->Student_model->get($this->session->userdata('std_id'));
            $cc_details = $this->validateCreditcard_number($_POST['card_number']);
            if ($cc_details['status'] == 'false') {
                // invalid card details
                echo 'invalid card details';
                //$this->do_payment();
            } else {
                $student_data =$this->Student_model->get($this->session->userdata('payment_data')['student_id']); 
                $auth_net = array(
                    'x_card_num' => $_POST['card_number'], // Visa
                    'x_exp_date' => $_POST['month'] . '/17',
                    'x_card_code' => $_POST['cvv'],
                    'x_description' => 'Authorize.net transaction',
                    'x_amount' => $this->session->userdata('payment_info')['amount'],
                    'x_first_name' => $student_detail->std_first_name,
                    'x_last_name' => $student_detail->std_last_name,
                    'x_address' => $student_detail->address,
                    'x_city' => $student_detail->city,
                    'x_state' => $student_detail->state,
                    'x_zip' => $student_detail->zip,
                    'x_country' => $student_detail->country,
                    'x_phone' => $student_detail->std_mobile,
                    'x_email' => $student_detail->email,
                    'x_customer_ip' => $this->input->ip_address(),
                );
                $this->authorize_net->setData($auth_net);
                // redirect after order completion
                $status = array();
                // Try to AUTH_CAPTURE
                if ($this->authorize_net->authorizeAndCapture()) {
                    $this->flash_notification('Transaction is successfully done.');
                    $student_detail = $this->Student_model->get($this->session->userdata('std_id'));
                    //insert into db
                    $this->Student_fees_model->insert(array(
                        'student_id' => $this->session->userdata('payment_info')['student_id'],
                        'fees_structure_id' => $this->session->userdata('payment_info')['fees_structure'],
                        'paid_amount' => $this->session->userdata('payment_info')['amount'],
                        'course_id' => $student_detail->course_id,
                        'branch_id' => $student_detail->branch_id,
                        'admission_plan_id' => $student_detail->admission_plan_id,
                        'class_id' => $student_detail->class_id,                        
                        'fee_title' => $this->session->userdata('payment_info')['title'],
                        'remarks' => $this->session->userdata('payment_info')['remarks']
                    ));
                    //remove session
                    $this->session->unset_userdata('payment_info');
                    $this->flash_notification('Transaction successfully completed.');
                    redirect(base_url('feerecord/'));
                } else {
                    $this->session->set_flashdata('Transaction incomplete', '<p>' . $this->authorize_net->getError() . '</p>');
                    //remove session
                    $this->session->unset_userdata('payment_data');
                    //remove session
                    $this->session->unset_userdata('payment_info');
                    redirect(base_url('feerecord'));
                }
            }
        }
    }
    
     function vocational_payment_gateway_type($type) {
       $this->load->model('payment_gateway_config/Authorize_net_model');
       
        if ($type == 'authorize.net') {
            //load authorize.net payment getaway page
            $this->data['authorize_net'] = $this->Authorize_net_model->order_by_column('login_id');
        }
        $this->data['title'] = 'Make Payment';
        $this->data['page'] = 'vocational_make_payment';
        $this->__template('payment/vocational_make_payment', $this->data);
    }
    
      function pay_online_vocational_course() {
        if ($_POST) {
            //set payment data in session
            $session['payment_info'] = array(
                'student_id' => $this->session->userdata('std_id'),
                'amount' => $_POST['amount'],
                'vocational_courseid' => $_POST['voc_course'],
            );
            $this->session->set_userdata($session);
            
            //echo '<pre>';
            //var_dump($_POST);
            redirect(base_url('payment/vocational_payment_gateway_type/' . $_POST['method']));
        } else {
            redirect(base_url('payment/vocationalcourse'));
        }
    }
    
    
      function vocational_authorize_net_make_payment() {
        $this->load->library('authorize_net');
        
        $this->load->model('vocationalcourse/Vocational_course_fee_model');
        $this->load->model('Student/Student_model');
        if ($_POST) {
            $student_detail = $this->Student_model->get($this->session->userdata('std_id'));

            $cc_details = $this->validateCreditcard_number($_POST['card_number']);
            if ($cc_details['status'] == 'false') {
                // invalid card details
                echo 'invalid card details';
                //$this->do_payment();
            } else {
                $student_data =  $this->Student_model->get($this->session->userdata('payment_data')['student_id']);
                $auth_net = array(
                    'x_card_num' => $_POST['card_number'], // Visa
                    'x_exp_date' => $_POST['month'] . '/17',
                    'x_card_code' => $_POST['cvv'],
                    'x_description' => 'Authorize.net transaction',
                    'x_amount' => $this->session->userdata('payment_info')['amount'],
                    'x_first_name' => $student_detail->std_first_name,
                    'x_last_name' => $student_detail->std_last_name,
                    'x_address' => 'Address',
                    'x_city' => $student_detail->city,
                    'x_state' => 'State',
                    'x_zip' => $student_detail->zip,
                    'x_country' => 'India',
                    'x_phone' => $student_detail->std_mobile,
                    'x_email' => 'mayur.panchal@searchnative.in',
                    'x_customer_ip' => $this->input->ip_address(),
                );
                $this->authorize_net->setData($auth_net);
                // redirect after order completion
                $status = array();
                // Try to AUTH_CAPTURE
                if ($this->authorize_net->authorizeAndCapture()) {

                    $this->flash_notification('Transaction is successfully done.');

                    $student_detail = $this->Student_model->get($this->session->userdata('std_id'));
                    //insert into db   
                    $std_id = $this->session->userdata('payment_info')['student_id'];
                    $amount = $this->session->userdata('payment_info')['amount'];
                    $course_id = $this->session->userdata('payment_info')['vocational_courseid'];
                    $vocational_info_insert  = array(
                        'student_id' => $std_id,
                        'pay_amount' => $amount,
                        'vocational_course_id' => $course_id,
                        'pay_date' => date('Y-m-d')
                    );
                    $this->Vocational_course_fee_model->insert($vocational_info_insert);
                    
                    //remove session
                    $this->session->unset_userdata('payment_info');
                    redirect(base_url('vocationalcourse'));
                } else {
                    $this->flash_notification('<p>' . $this->authorize_net->getError() . '</p>');
                    //remove session
                    $this->session->unset_userdata('payment_data');
                    //remove session
                    $this->session->unset_userdata('payment_info');
                    redirect(base_url('vocationalcourse'));
                }
            }
        }
    }
    
    function get_fees_structure($branch='',$course='',$admission_plan='')
    {
        $this->db->where("branch_id",$branch);
        $this->db->where("course_id",$course);
        $this->db->where("admission_plan_id",$admission_plan);
        
        $res = $this->db->get('fees_structure')->result();
        echo json_encode($res);
    }
    

}

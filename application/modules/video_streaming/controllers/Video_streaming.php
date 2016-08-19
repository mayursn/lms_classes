<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Video_streaming extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Video_streaming/Broadcast_and_streaming_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    /**
     * Index action
     */
    function index() {
        $this->load->model('department/Degree_model');
        $this->data['title'] = 'Video streaming';
        $this->data['page'] = 'video_streaming';
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        if($this->session->userdata('std_id'))
        {
        $this->db->like("created_at",date('Y-m-d'));
        $this->db->where("is_active",'1');
        $this->data['streaming']= $this->db->get("broadcast_and_streaming")->result();        
        $this->__template('video_streaming/std_index', $this->data);
        }
        else{
        $this->__template('video_streaming/index', $this->data);
        }
    }

    function create_private_broadcast() {
        if ($_POST['url_link']) {
            $url = $_POST['url_link'];
        } else {
            $url = '';
        }

        //for active status check permission for create
        if ($this->session->userdata('login_type') == 'admin') {
            $is_active = 1;
        } else {
            $is_active = 0;
        }

        $this->Broadcast_and_streaming_model->insert(array(
            'title' => $_POST['title'],
            'degree_id' => $_POST['degree'],
            'course' => $_POST['course'],
            'batch' => $_POST['batch'],
            'semester' => $_POST['semester'],
            'url_link' => $url,
            'is_active' => $is_active
        ));

        if ($_POST['degree'] == 'all') {
            //send to all
            $students = $this->db->get('student')->result();
            $message = "Live straming broadcast was created for all students at " . date('F d, Y');
            $message .= " and its details listed below. ";
            $message .= "<br/>Stream Name: " . $_POST['title'];
            $message .= "<br/>Date: " . date('F d, Y h:i A');
            $message .= "<br/><br/><a href=" . base_url('index.php?login') . ">Click here </a> to login.";
        } else {
            //filter
            $students = $this->db->select()
                    ->from('student')
                    ->join('degree', 'degree.d_id = student.std_degree')
                    ->join('course', 'course.course_id = student.course_id')
                    ->join('batch', 'batch.b_id = student.std_batch')
                    ->join('semester', 'semester.s_id = student.semester_id')
                    ->where('student.std_degree', $_POST['degree'])
                    ->where('student.course_id', $_POST['course'])
                    ->where('student.std_batch', $_POST['batch'])
                    ->where('student.semester_id', $_POST['semester'])
                    ->get()
                    ->result();
            $message = "Live streaming multicast created on " . date('F d, Y');
            $message .= ". And its details is listed below";
            $message .= "<br/>Title: " . $_POST['title'];
            $message .= "<br/>Course: " . $students[0]->d_name;
            $message .= "<br/>Branch: " . $students[0]->c_name;
            $message .= "<br/>Batch: " . $students[0]->b_name;
            $message .= "<br/>Semester: " . $students[0]->s_name;
            $message .= "<br/>Date: " . date('F d, Y h:i A');
            $message .= "<br/><br/><a href=" . base_url('index.php?login') . ">Click here </a> to login.";
        }
        $this->load->helper('notification');
        $subject = 'Live Video Streaming and Conference';

        //video_streaming_email_notification($students, $subject, $message);
    }

    /**
     * Start video streaming
     */
    function assign_live_stream() {
        $this->db->where('title', $_POST['title']);
        $this->db->update('broadcast_and_streaming', array(
            'course' => $_POST['course'],
            'semester' => $_POST['semester'],
            'is_active' => $_POST['is_active']
        ));
    }

    /**
     * Set inactive video streaming
     * @param type $id
     */
    function in_active_streaming($id) {
        $this->db->where('title', $id);
        $this->db->update('broadcast_and_streaming', array(
            'is_active' => '0'
        ));
    }

    /**
     * Start or stop video streaming
     * @param type $stream_name
     */
    function start_stop_streaming($stream_name, $status) {
        $this->Broadcast_and_streaming_model->start_stop_streaming($stream_name, $status);
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->helper('email/system_email');
        $this->load->model('email/Email_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    function index() {
        
    }

    /**
     * Email compose
     */
    function compose() {
        
        $this->load->model('department/Degree_model');
        $this->load->model('user/Role_model');

        if ($_POST) {            
            $attachments = $this->attachments();
            $subject = $_POST['subject'];
            $message = trim($_POST['message']);
            
            /*if($_POST['user_type'] == 'all') {
                $this->load->model('user/User_model');
                $users = $this->User_model->get_all();
            }*/
            
            $this->Email_model->insert(array(
                'email_from' => $this->session->userdata('user_id'),
                'email_to' => implode(",", $_POST['email']),
                'subject' => $_POST['subject'],
                'message' => $_POST['message'],
                'external_email' => $_POST['cc'],
                'email_read' => '',
                'attachments' => $attachments['filnames']
            ));

            if($_POST['cc'])
                $this->setemail($_POST['cc'], $subject, $message, $attachments['files']);

            $this->flash_notification('Message is sent successfully');
            redirect(base_url('email/compose'));
        }
        $this->data['title'] = 'Compose email';
        $this->data['page'] = 'compose';
        $this->load->model('branch/Branch_location_model');
        $this->load->model('courses/Course_model');
        $this->data['branch'] = $this->Branch_location_model->order_by_column('branch_name');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['user_type'] = $this->Role_model->order_by_column('role_name');
        $this->__template('email/compose', $this->data);
    }

    /**
     * View inbox email
     * @param string $id
     */
    function view_inbox($id) {
        $this->data['email'] = $this->Email_model->email_inbox_details($id);
        $this->data['title'] = $this->data['email']->subject;
        $this->data['page'] = 'inbox';
        $this->Email_model->update_email_view_status($id, $this->session->userdata('user_id'));
        $this->__template('email/view_inbox', $this->data);
    }
    
    /**
     * View sent email details
     * @param string $id
     */
    function view_sent($id) {
        $this->data['email'] = $this->Email_model->get($id);
        $this->data['title'] = $this->data['email']->subject;
        $this->data['sent_list'] = $this->Email_model->email_sent_user_list($this->data['email']->email_to);
        $this->data['page'] = 'sent';
        $this->__template('email/view_sent', $this->data);
    }

    /**
     * Email inbox
     */
    function inbox() {
        $this->data['title'] = 'Inbox';
        $this->data['page'] = 'inbox';
        $this->data['inbox'] = $this->Email_model->email_inbox($this->session->userdata('user_id'));
        $this->__template('email/inbox', $this->data);
    }

    /**
     * Sent items
     */
    function sent() {
        $this->data['title'] = 'Sent Email';
        $this->data['page'] = 'sent';
        $this->data['sent_mail'] = $this->Email_model->sent_email($this->session->userdata('user_id'));
        $this->__template('email/sent', $this->data);
    }

    /**
     * Email reply
     * @param string $id
     */
    function reply($id) {
        $this->load->model('user/User_model');
        $this->data['title'] = 'Email reply';
        $this->data['page'] = 'email_reply';
        $this->data['email'] = $this->Email_model->get($id);
        $this->data['sender'] = $this->User_model->get($this->data['email']->email_from);       
        $this->__template('email/reply', $this->data);
    }

    /**
     * Set mail config
     */
    function setemail($emails_list, $subject = '', $message = '', $attachment = array()) {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'mayur.panchal@searchnative.in',
            'smtp_pass' => 'Mayur@@123',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        //$this->load->library('email');
        $subject = $subject;
        $message = $message;
        $emails = explode(',', $emails_list);
        foreach ($emails as $email) {
            $this->email->clear(TRUE);
            $this->sendEmail($email, $subject, $message, $attachment);
        }
    }

    /**
     * Send email
     * @param string $email
     * @param string $subject
     * @param string $message
     */
    public function sendEmail($email, $subject, $message, $attachments) {
        //$this->email->set_newline("\r\n");
        $this->email->from('mayur.panchal@searchnative.in', 'Search Native India');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        //$files = array('D:\unit testing.docx', 'D:\vtiger trial version features.docx');
        foreach ($attachments as $row) {
            $this->email->attach($row);
        }
        if ($this->email->send()) {
            echo 'Email send.';
        } else {
            show_error($this->email->print_debugger());
        }
    }

    /**
     * Email attachment
     * @return string
     */
    function attachments() {
        ini_set('max_execution_time', 500);
        $data = array();
        if ($_POST) {
            $filename = '';
            $attachments = array();

            if ($_FILES['userfile']['name'][0] != '') {
                $files = $_FILES;
                $cpt = count($_FILES['userfile']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
                    $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                    $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
                    $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

                    $this->upload->initialize($this->set_upload_options());
                    $this->upload->do_upload();
                    $uploaded = $this->upload->data();
                    $filename .= $uploaded['file_name'] . ',';
                    array_push($attachments, $uploaded['full_path']);
                }
            }
            $data['files'] = $attachments;
            $data['filnames'] = rtrim($filename, ',');

            return $data;
        }
    }

    /**
     * Set upload options
     * @return mixed
     */
    function set_upload_options() {
        //upload an image options
        $config = array(
            'upload_path' => './uploads/emails/',
            'allowed_types' => 'gif|jpg|png|pdf|xlsx|xls|doc|docx|ppt|pptx|pdf|zip|rar|gzip|tar',
            'max_size' => '10000'
        );

        return $config;
    }
    
    /**
     * 
     * @param int $id
     */
    function sentdelete($id= '')
    {
       $this->Email_model->delete($id);
       $this->flash_notification("Email Deleted successfully");
       redirect('email/sent');
    }
    
    
    function delete($id='')
    {
        $this->Email_model->delete($id);
       $this->flash_notification("Email Deleted successfully");
       redirect('email/inbox');
    }

}

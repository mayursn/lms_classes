<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feerecord extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('feerecord/Student_fees_model');
        $this->load->model('student/Student_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
       
      
    }

    function index() {
        $this->load->model('semester/Semester_model');
        $this->data['title'] = 'Fee Record';
        $this->data['page'] = 'fees_record';
          $this->data['student_detail'] = $this->Student_model->get_many_by(array(
                    'std_id' => $this->session->userdata('std_id')
                ));
              
        $this->data['fees_structure'] = '';
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['fees_record'] = $this->Student_fees_model->fees_record($this->session->userdata('std_id'));
     
        $this->__template('feerecord/index', $this->data);
    }
    
    
    /**
     * Invoice details
     * @param string $id
     */
    function invoice($id = '') {
        $this->data['page'] = 'invoice';
        $this->data['title'] = 'Student invoice';
        $this->data['invoice'] = $this->Student_fees_model->invoice_detail($id);
        $paid_fees = $this->Student_fees_model->student_paid_fees($this->data['invoice']->fees_structure_id, $this->data['invoice']->std_id);
        $total_paid = 0;
        if (count($paid_fees)) {
            foreach ($paid_fees as $paid) {
                $total_paid += $paid->paid_amount;
            }
        }
        $this->data['due_amount'] = $this->data['invoice']->total_fee - $total_paid;
        $this->data['total_paid'] = $total_paid;
        $this->__template('feerecord/invoice', $this->data);
    }
    
      /**
     * Invoice print
     * @param string $id
     */
    function invoice_print($id) {
        $this->data['invoice'] = $this->Student_fees_model->invoice_detail($id);
        $paid_fees = $this->Student_fees_model->student_paid_fees($this->data['invoice']->fees_structure_id, $this->data['invoice']->std_id);
        $total_paid = 0;
        if (count($paid_fees)) {
            foreach ($paid_fees as $paid) {
                $total_paid += $paid->paid_amount;
            }
        }
        $this->data['title'] = 'Invoice';
        $this->data['due_amount'] = $this->data['invoice']->total_fee - $total_paid;
        $this->data['total_paid'] = $total_paid;
        $html = utf8_encode($this->load->view('feerecord/invoice_print', $this->data, true));
        //this the the PDF filename that user will get to download
        $pdfFilePath = "invoice copy.pdf";
        //load mPDF library
        $this->load->library('m_pdf');
        //load the view and saved it into $html variable
        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
    
    function student_fees() {
        $this->load->model('student/Student_model');
        $this->load->model('semester/Semester_model');
        $this->data['student_detail'] = $this->Student_model->get($this->session->userdata('std_id'));
        
           $this->data['fees_structure'] = '';
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['fees_record'] = $this->Student_fees_model->fees_record($this->session->userdata('std_id'));
        $this->data['page'] = 'student_fees';
        $this->data['title'] = 'Pay Online';
        clear_notification('fees_structure', $this->session->userdata('std_id'));
        unset($this->session->userdata('notifications')['fees_structure']);
        $this->__template('feerecord/student_fees', $this->data);
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Academic_year extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();

        $this->load->model("academic_year/Academic_year_model");
    }

    /**
     * Restore databse
     */
    function index() {
        $this->data['academy'] = $this->Academic_year_model->order_by_column('year');
        $this->data['title'] = 'Academic Year';
        $this->data['page'] = 'academic_year';
        $this->__template('academic_year/index', $this->data);
    }

    function create() {
        $start_dates = $this->input->post('from_date');
        $end_dates = $this->input->post('to_date');
        
        $nice_date1 = nice_date($this->input->post('from_date'),"m/d/Y");
        $nice_date2 = nice_date($this->input->post('to_date'),"m/d/Y");
        $date1 = explode("/", $nice_date1);
        $date2 = explode("/", $nice_date2);

        $start_month = $date1[0];
        $start_date = $date1[1];
        $start_year = $date1[2];

        $end_month = $date2[0];
        $end_date = $date2[1];
        $end_year = $date2[2];

        $start_dates = date("Y-m-d", strtotime($start_dates));

        $end_dates = date("Y-m-d", strtotime($end_dates));
        if ($start_dates == $end_dates) {
            $this->flash_notification("Same Date Not allowed");
            redirect(base_url() . 'academic_year/', 'refresh');
        }

        if ($start_dates > $end_dates) {
            $this->flash_notification("Pass Date Not allowed");
            redirect(base_url() . 'academic_year/', 'refresh');
        }

        $result = $this->Academic_year_model->get_many_by(array("start_year" => $start_year));

        if (!empty($result)) {
            $this->flash_notification('This Year is already added in academic year');
            redirect(base_url() . 'academic_year/', 'refresh');
        } else {

            $data = array("from_month" => $start_month,
                "to_month" => $end_month,
                "start_date" => $start_dates,
                "end_date" => $end_dates,
                "start_year" => $start_year,
                "end_year" => $end_year);

            $this->Academic_year_model->insert($data);

            $this->flash_notification("Academic year successfully added");
            redirect(base_url() . 'academic_year/', 'refresh');
        }
    }
    

    
        public function update_academic_year()
        {
               $update1 = array("current_year_status"=>"active");
               $update2 = array("current_year_status"=>"inactive");
               $this->db->update("academic_year",$update1,array("academic_id"=>$this->input->post('set_academic_year')));
               $this->db->update("academic_year",$update2,array("academic_id !="=>$this->input->post('set_academic_year')));

               $this->flash_notification("Academic Year set successfully");
               redirect(base_url() . 'academic_year/', 'refresh');
        }
}

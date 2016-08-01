<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('holiday/Holiday_model');
    }

    function index() {
        $this->data['title'] = 'Holiday';
        $this->data['page'] = 'holiday';
        $this->data['holiday'] = $this->Holiday_model->order_by_column('holiday_startdate');
       
        $this->__template('holiday/index', $this->data);
    }
    
     function create() {
        if ($_POST) {
            $this->Holiday_model->insert(array(
                'holiday_name' => $_POST['holiday_name'],
                'holiday_startdate' =>date('Y-m-d H:i:s', strtotime($_POST['holiday_startdate'])),
                'holiday_enddate' => date('Y-m-d H:i:s', strtotime($_POST['holiday_enddate'])),
                'holiday_year' => date('Y', strtotime($this->input->post('holiday_startdate'))),
                'holiday_status' =>$_POST['holiday_status']
            ));
            $this->flash_notification('Holiday is successfully added.');
        }

        redirect(base_url('holiday'));
    }
    
      function delete($id) {
        $this->Holiday_model->delete($id);
        $this->flash_notification('Holiday is successfully deleted.');

        redirect(base_url('holiday'));
    }

     function update($id = '') {
        if ($_POST) {
                $this->Holiday_model->update($id, array(
                 'holiday_name' => $_POST['holiday_name'],
                'holiday_startdate' => date('Y-m-d H:i:s', strtotime($_POST['holiday_startdate1'])),
                'holiday_enddate' => date('Y-m-d H:i:s', strtotime($_POST['holiday_enddate1'])),
                'holiday_year' => date('Y', strtotime($this->input->post('holiday_startdate1'))),
                'holiday_status' =>$_POST['holiday_status']
            ));
            $this->flash_notification('Holiday is successfully updated.');
        }

        redirect(base_url('holiday'));
    }
    
}

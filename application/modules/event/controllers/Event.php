<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller
{
    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('event/Event_manager_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }
    
    function index() {
        $this->data['title'] = 'Event';
        $this->data['page'] = 'event';
        $this->data['events'] = $this->Event_manager_model->order_by_column('event_date');
        $this->__template('event/index', $this->data);
    }
    
    function create()
    {
         if ($_POST) {
             $data = array();
             $data['event_name'] = $this->input->post('event_name');
                $data['event_location'] = $this->input->post('event_location');
                $data['event_desc'] = $this->input->post('event_desc');
                $event_date = nice_date($this->input->post('event_date'),'Y-m-d');                
                $data['event_date'] = date('Y-m-d H:i:s', strtotime($event_date.' '.$_POST['event_time']));                                
                $data['event_end_date'] = $this->input->post('event_end_date');
                $data['group_id'] = $this->input->post('group');
                $data['status'] = $this->input->post('status');
            $this->Event_manager_model->insert($data);            
             $this->flash_notification('Event is successfully added.');   
        }

        redirect(base_url('event'));
    }
    
      function delete($id) {
        $this->Event_manager_model->delete($id);
         $this->flash_notification('Event is successfully deleted.');   

        redirect(base_url('event'));
    }
    
    function update($id='')
    {
        $data = array();
                  if ($_POST) {
                $data['event_name'] = $this->input->post('event_name');
                $data['event_location'] = $this->input->post('event_location');
                $data['event_desc'] = $this->input->post('event_desc');
                $event_date = nice_date($this->input->post('event_date'),'Y-m-d');                
                $data['event_date'] = date('Y-m-d H:i:s', strtotime($event_date.' '.$_POST['event_time']));                                
                $data['event_end_date'] = $this->input->post('event_end_date');
                $data['group_id'] = $this->input->post('group');
                $data['status'] = $this->input->post('status');
            $this->Event_manager_model->update($id,$data);
            $this->flash_notification('Event is successfully updated.');
        }

        redirect(base_url('event'));
    }


}

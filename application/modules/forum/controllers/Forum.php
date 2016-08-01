<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends MY_Controller
{
    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('forum/Forum_model');
    }
    
    function index() {
        $this->data['title'] = 'Forum';
        $this->data['page'] = 'forum';
        $this->data['forum'] = $this->Forum_model->order_by_column('created_date');
        $this->__template('forum/index', $this->data);
    }
    
    function create()
    {
         if ($_POST) {
             $data = array();
              $data['forum_title'] = $this->input->post("forum_title");
            $data['forum_status'] = $this->input->post("forum_status");
            $this->Forum_model->insert($data);            
             $this->flash_notification('Forum is successfully added.');   
        }

        redirect(base_url('forum'));
    }
    
      function delete($id) {
        $this->Forum_model->delete($id);
         $this->flash_notification('Forum is successfully deleted.');   

        redirect(base_url('forum'));
    }
    
    function update($id='')
    {
        $data = array();
                  if ($_POST) {
                 $data['forum_title'] = $this->input->post("forum_title");
            $data['forum_status'] = $this->input->post("forum_status");
            $this->Forum_model->update($id,$data);
            $this->flash_notification('Forum is successfully updated.');
        }

        redirect(base_url('forum'));
    }


}

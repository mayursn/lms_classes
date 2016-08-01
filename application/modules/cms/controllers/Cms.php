<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('cms/Cms_manager_model');
    }

    function index() {
        $this->data['title'] = 'cms manager';
        $this->data['page'] = 'cms';
        $this->data['cms'] = $this->Cms_manager_model->order_by_column('c_title');       
        $this->__template('cms/index', $this->data);
    }
    
    
    function create()
    {
        if($_POST)
        {
              $data['c_title'] = $this->input->post('c_title');
                $data['c_slug'] = $this->input->post('c_slug');
                $data['c_description'] = $this->input->post('c_description');
                $data['c_status'] = $this->input->post('c_status');
                $this->Cms_manager_model->insert($data);
                
                $this->flash_notification('CMS page is successfully added.');
                redirect(base_url() . 'cms/', 'refresh');
        
        }
    }
    
    
    function update($param2='')
    { 
            $data['c_title'] = $this->input->post('c_title');
            $data['c_slug'] = $this->input->post('c_slug');
            $data['c_description'] = $this->input->post('edit_content_data');
            $data['c_status'] = $this->input->post('c_status');
            $this->Cms_manager_model->update($param2,$data);
            $this->flash_notification("CMS page is successfully updated");
            redirect(base_url() . 'cms/', 'refresh');
    
    }
    
    function delete($id='')
    {
        $this->Cms_manager_model->delete($id);
        $this->flash_notification("CMS page is successfully deleted");
        redirect(base_url() . 'cms/');
    }
    
    
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_pages extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('cms_pages/Cms_manager_model');
    }

    function index() {
        $this->data['title'] = 'cms manager';
        $this->data['page'] = 'cms';
        $this->data['cms'] = $this->Cms_manager_model->order_by_column('c_title');       
        $this->__template('cms_pages/index', $this->data);
    }
    
    
    function create()
    {
        if($_POST)
        {
              $data['c_title'] = $this->input->post('c_title');
                $data['c_slug'] = $this->input->post('c_slug');
                $data['c_description'] = $this->input->post('c_description');
                $data['c_status'] = $this->status($this->input->post('c_status'));
                $this->cms_manager_model->insert($data);
                
                $this->flash_notification('CMS page is successfullt added.');
                redirect(base_url() . 'cms_pages/', 'refresh');
        
        }
    }
    
    
    function update($param2='')
    { 
        if($_POST)
        {
            
          
                $syllabus = $this->Smart_syllabus_model->get($param2);

                if ($_FILES['syllabusfile']['name'] != "") {
                    $path = FCPATH . 'uploads/syllabus';
                    if (!is_dir($path)) {
                        mkdir($path, 0777);
                    }
                    $config['upload_path'] = 'uploads/syllabus';
                    $config['allowed_types'] = 'pdf|doc|docx|ppt|pptx';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    //$this->upload->set_allowed_types('*');	

                    if (!$this->upload->do_upload('syllabusfile')) {
                        $this->session->set_flashdata('flash_message', "Invalid File!");
                        redirect(base_url() . 'syllabus/', 'refresh');
                    } else {
                        $file = $this->upload->data();
                        $insert['syllabus_filename'] = $file['file_name'];
                    }
                } else {

                    $insert['syllabus_filename'] = $syllabus->syllabus_filename;
                }

                $insert['syllabus_title'] = $this->input->post('title');
                $insert['syllabus_degree'] = $this->input->post('degree');
                $insert['syllabus_course'] = $this->input->post('course');
                $insert['syllabus_sem'] = $this->input->post('semester');
                $insert['syllabus_desc'] = $this->input->post('description');
                $insert['update_date'] = date('Y-m-d H:i:s');

                $this->Smart_syllabus_model->update($param2,$insert);
                $this->flash_notification("Syllabus successfully updated");
                redirect(base_url() . 'syllabus/', 'refresh');
        }
    }
    
    function delete($id='')
    {
        $this->Smart_syllabus_model->delete($id);
        $this->flash_notification("Syllabus successfully deleted");
        redirect(base_url() . 'syllabus/');
    }
    /**
     * 
     */
    function getsyllabus($param = '') {
        $degree = $this->input->post('degree');
        $course = $this->input->post('course');
        $semester = $this->input->post("semester");
        $data['course'] = $this->Course_model->order_by_column('c_name');
        $data['semester'] = $this->Semester_model->order_by_column('s_name');
        $data['degree'] = $this->Degree_model->order_by_column('d_name');
        $array = array("syllabus_course"=> $course,
                        "syllabus_degree"=>$degree,
            "syllabus_sem"=>$semester);
        $data['syllabus'] = $this->Smart_syllabus_model->get_many_by($array);

        $this->load->view("syllabus/getsyllabus", $data);
    }

     function status($str) {
        if ($str) {
            return 1;
        } else {
            return 0;
        }
    }
    
    
}

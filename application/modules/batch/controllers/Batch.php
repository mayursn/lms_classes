<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Batch extends MY_Controller {
    
    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('batch/Batch_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }
    
    function index()
    {
         $this->data['title'] = "Batch";
        $this->data['batches'] = $this->db->get('batch')->result_array();
        $this->data['degree'] = $this->db->get('degree')->result_array();
        $this->data['course'] = $this->db->get('course')->result();
        $this->data['page'] = 'batch';
        $this->__template('batch/index', $this->data);
    }
    
    function create()
    {
                $data['b_name'] = $this->input->post('b_name');
                $data['degree_id'] = implode(',', $this->input->post('degree'));
                $data['course_id'] = implode(',', $this->input->post('course'));
                $data['b_status'] = $this->status($this->input->post('batch_status'));
                $data['created_date'] = date('Y-m-d');
                $this->Batch_model->insert($data);
        $this->flash_notification("Batch successfully added");
        redirect(base_url() . 'batch/', 'refresh');
    }
    
    function update($param2='')
    {
                $data['b_name'] = $this->input->post('b_name');
                $data['degree_id'] = implode(',', $this->input->post('degree1'));
                $data['course_id'] = implode(',', $this->input->post('course1'));
                $data['b_status'] = $this->status($this->input->post('batch_status'));
                $this->Batch_model->update($param2,$data);    
                
        $this->flash_notification("Batch successfully updated");
        redirect(base_url() . 'batch/', 'refresh');
    }
    
    function status($str) {
        if ($str) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Batch by department and branch
     * @param string $department
     * @param string $branch
     */
    function department_branch_batch($department, $branch) {
        $batch = $this->Batch_model->department_branch_batch($department, $branch);
        
        echo json_encode($batch);
    }
    
    /**
     * get course list
     * 
     */
    function get_cource_multiple($param = '') {
        $did = implode(',', $this->input->post("degree"));
        $courceid = explode(',', $this->input->post("courseid"));
        $cource = $this->db->query("select * from course where degree_id in($did)")->result_array();
        $html = '';
        foreach ($cource as $c) {
            if (in_array($c['course_id'], $courceid)) {
                $html .='<option value="' . $c['course_id'] . '" selected>' . $c['c_name'] . '</option>';
            } else {
                $html .='<option value="' . $c['course_id'] . '">' . $c['c_name'] . '</option>';
            }
        }
        echo $html;
    }
    
     function check_batch() {
        $degree = $this->input->post("degree");
        $course = $this->input->post("course");
        $data = $this->Batch_model->check($degree,$course);
        echo json_encode($data);
    }
    
    function delete($id)
    {
        $this->Batch_model->delete($id);
        $this->flash_notification("Batch successfully deleted");
        redirect(base_url() . 'batch/', 'refresh');
    }
}
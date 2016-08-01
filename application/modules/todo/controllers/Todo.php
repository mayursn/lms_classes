<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('todo/Todo_list_model');
        
    }

     function changestatus() {        
        if ($_POST) {
            $id = $this->input->post('id');
            $data['todo_status'] = $this->input->post('status');
            $this->Todo_list_model->update($id,$data);
        }
    }
     function removetodolist() {        
        if ($_POST) {
            $id = $this->input->post('id');
            
            $this->Todo_list_model->delete($id);
        }
    }
    
       
    /**
     *  Add To do list
     */
    function add_to_do_student() {
        
        $this->load->model('todo/Todo_list_model');
        if ($_POST) {
            $title = $this->input->post('title');
            $todo_date = $this->input->post('todo_date');
            $todo_time = $this->input->post('todo_time');
            $datetime = $todo_date . ' ' . $todo_time;

            $datetime = strtotime($datetime);
            $datetime = date('Y-m-d H:i:s', $datetime);

            $data['todo_datetime'] = $datetime;
            $data['todo_title'] = $title;
            $data['todo_role'] = 'student' ;        
             $data['user_role_id'] = $this->session->userdata('user_id');
            $this->Todo_list_model->insert($data);
            $this->data['todolist'] = $this->Todo_list_model->get_student_todo();
            $this->load->view("todo/getstudent_todo", $this->data);
        }
    }
    
    function student_todoupdateform($param = '') {
          $this->load->model('todo/Todo_list_model');
        $this->data['todolist'] = $this->Todo_list_model->get($param);
        $this->load->view("todo/student-todoupdate-form", $this->data);
    }
        
    
     function student_updatetodolist() {
        if ($_POST) {
            $title = $this->input->post('title');
            $todo_date = $this->input->post('todo_date');
            $todo_time = $this->input->post('todo_time');
            $datetime = $todo_date . ' ' . $todo_time;
            $datetime = strtotime($datetime);
            $data['todo_datetime'] = date('Y-m-d H:i:s', $datetime);          
            $data['todo_title'] = $title;
            $id = $this->input->post('todo_id');
            $this->Todo_list_model->update( $id, $data);
           
            $this->data['todolist'] = $this->Todo_list_model->get_student_todo();
            $this->load->view("todo/getstudent_todo", $this->data);
        }
    }
}

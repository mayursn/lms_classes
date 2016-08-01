<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Todo_list_model extends MY_Model {
    
    protected $primary_key = 'todo_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $todo
     * @return array
     */
    protected function timestamps($todo) {
        $todo['created_date'] = date('Y-m-d H:i:s');        
        return $todo;
    }
    
    function get_student_todo()
    {
        $date = date('Y-m-d');
        $date = date('Y-m-d', strtotime('-6 days', strtotime($date)));        
        //$login_type = "student";        
        $login_id = $this->session->userdata("user_id");
        $this->db->select('todo_id,todo_title,todo_datetime,todo_status');        
        $this->db->where("user_role_id",$login_id);
        $this->db->where('todo_datetime >= ', $date);
        $this->db->order_by("todo_datetime","asc");
        return $this->db->get("todo_list")->result();
    }
    
    /**
     * studen to do list
     * @return mixed
     */
    function get_todo()
    {
        $date = date('Y-m-d');
        $date = date('Y-m-d', strtotime('-6 days', strtotime($date)));        
       // $login_type = $this->session->userdata("role_name");
        $login_id = $this->session->userdata("user_id");
        $this->db->select('todo_id,todo_title,todo_datetime,todo_status');        
        $this->db->where("user_role_id",$login_id);
        $this->db->where('todo_datetime >= ', $date);
        $this->db->order_by("todo_datetime","asc");
        return $this->db->get("todo_list")->result();
        
    }
    
   
}

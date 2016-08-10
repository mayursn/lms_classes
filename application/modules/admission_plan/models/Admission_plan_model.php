<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admission_plan_model extends MY_Model {

    protected $primary_key = 'admission_plan_id';
    
   // public $before_get = array('check_status');
    
   
    
    function get_all_plan()
    {
        return $this->db->get($this->_table)->result();;
    }
   
}

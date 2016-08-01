<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday_model extends MY_Model {
    
    protected $primary_key = 'holiday_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $degree
     * @return array
     */
    protected function timestamps($holiday) {
        $holiday['created_date'] = date('Y-m-d H:i:s');
        
        return $holiday;
    }
    
}
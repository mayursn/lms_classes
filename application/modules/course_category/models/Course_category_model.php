<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Course_category_model extends MY_Model {
    
    protected $primary_key = 'category_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp fields
     * @param array $course_category
     * @return array
     */
    protected function timestamps($course_category) {
        $course_category['created_date'] = date('Y-m-d H:i:s');
        
        return $course_category;
    }
}
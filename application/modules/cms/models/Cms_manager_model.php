<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_manager_model extends MY_Model {
    
    protected $primary_key = 'c_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $cms
     * @return array
     */
    protected function timestamps($cms) {
        $cms['created_date'] = date('Y-m-d H:i:s');        
        return $cms;
    }
}
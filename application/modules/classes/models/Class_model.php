<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_model extends MY_Model {
    
    protected $primary_key = 'class_id';
    
    public $before_create = array('timestamps');
    
    public $before_update = array('update_timestamps');
    
    /**
     * Set timestamp fields
     * @param array $class
     * @return array
     */
    protected function timestamps($class) {
        $class['created_date'] = $class['updated_date'] = date('Y-m-d H:i:s');
        
        return $class;
    }
    
    /**
     * Set update timestamp field
     * @param array $class
     * @return array
     */
    protected function update_timestamps($class) {
        $class['updated_date'] = date('Y-m-d H:i:s');
        
        return $class;
    }    
    
    public function get_class_name($class_id)
    {
        $this->db->where("class_id",$class_id);
        return  $this->db->get('class')->row()->class_name;
        
    }
}
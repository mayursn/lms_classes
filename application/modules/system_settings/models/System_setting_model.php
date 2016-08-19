<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System_setting_model extends MY_Model {
    
    protected $primary_key = 'settings_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $degree
     * @return array
     */
    protected function timestamps($system_setting) {
        $system_setting['created_date'] = date('Y-m-d H:i:s');
        
        return $system_setting;
    }
    
    /**
     * get setting option
     * @param string $type
     * @param string $obj
     * @param string $fields
     * @return mixed
     */
    public function get_settings($obj)
    {
        return $this->db->get_where('system_setting',array('type'=>$obj))->row()->description;
    }
    
    function update_by_type($type,$description)
    {
        $data = array('description'=>$description);
         $this->db->where('type', $type);         
         $this->db->update('system_setting', $data);
    }
}
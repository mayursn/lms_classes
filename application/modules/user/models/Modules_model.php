<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modules_model extends MY_Model {

    protected $primary_key = 'module_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set the timestamp fields
     * @param array $modules
     * @return array
     */
    protected function timestamps($modules) {
        $modules['created_at'] = $modules['updated_at'] = date('Y-m-d H:i:s');

        return $modules;
    }

    /**
     * Set the update timestamp field
     * @param array $modules
     * @return array
     */
    protected function update_timestamps($modules) {
        $modules['updated_at'] = date('Y-m-d H:i:s');

        return $modules;
    }

}

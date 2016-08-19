<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admission_type_model extends MY_Model {

    protected $primary_key = 'at_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');


    /**
     * Set timestamp fields
     * @param array $admission_type
     * @return type
     */
    protected function timestamps($admission_type) {
         if(check_role_approval())
        {
            $admission_type['at_status'] = 0;
        }
        $admission_type['created_date'] = $admission_type['updated_date'] = date('Y-m-d H:i:s');

        return $admission_type;
    }
    protected function update_timestamps($admission_type)
    {
        if(check_role_approval())
        {
            $admission_type['at_status'] = 0;
        }
        
        $admission_type['updated_date'] = date('Y-m-d H:i:s');
        return $admission_type;
    }

}

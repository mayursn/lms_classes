<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_location_model extends MY_Model {

    protected $primary_key = 'branch_id';
    
    public $before_create = array('timestamps');   
    public $before_update = array('update_timestamps');
    public $before_get = array('check_status');

    /**
     * Set the timestamp
     * @param array $branch
     */
    protected function timestamps($branch) {  
        if(check_role_approval())
        {
            $branch['branch_status'] = 0;
        }
        
        $branch['created_date'] =  $branch['updated_date'] = date('Y-m-d H:i:s');

        return $branch;
    }

     protected function update_timestamps($branch)
    {
        if(check_role_approval())
        {
            $branch['branch_status'] = 0;
        }
        
        $branch['updated_date'] = date('Y-m-d H:i:s');
        return $branch;
    }
    
    function get_all_branch()
    {
        return $this->db->get($this->_table)->result();
    }
    
    function check_status()
    {
        $this->db->where('branch_status','1');
    }



}

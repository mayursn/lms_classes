<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Last_activity_model extends MY_Model {

    protected $primary_key = 'activity_id';
    public $before_create = array('timestamps');
    /**
     * Set timestamp fields
     * @param array $activity
     * @return array
     */
    protected function timestamps($activity) {
        $activity['activity_datetime'] = date('Y-m-d H:i:s');
        
        return $activity;
    }

    
     function get_recent_activity() {
        $this->db->select('activity,activity_datetime');
        $this->db->from("last_activity");
        $this->db->order_by("activity_id", "desc");        
        $this->db->where("activity_user_role_id", $this->session->userdata('user_id'));
        $this->db->limit("10");
        return $this->db->get()->result();
    }

}

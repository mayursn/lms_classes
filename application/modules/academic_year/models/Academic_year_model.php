<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Academic_year_model extends MY_Model {

    protected $primary_key = 'academic_id';


    function get_current_year()
    {
        $this->db->where("current_year_status","active");
        return $this->db->get('academic_year')->row();
    }
}

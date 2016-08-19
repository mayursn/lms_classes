<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vocational_course_fee_model extends MY_Model {
    
    protected $primary_key = 'voc_course_fee_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $vocationalcoursefee
     * @return array
     */
    protected function timestamps($vocationalcoursefee) {
        $vocationalcoursefee['pay_date'] = date('Y-m-d H:i:s');
        
        return $vocationalcoursefee;
    }
    
    function get_course()
    {
        $this->db->select('vc.*,s.std_id,s.user_id');
        $this->db->from('vocational_course_fee vc');
        $this->db->join('student s','s.std_id=vc.student_id');
        return $this->db->get()->result();
    }
}
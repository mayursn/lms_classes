<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_model extends MY_Model {

    protected $_table = 'subject_manager';
    protected $primary_key = 'sm_id';
    public $before_create = array('timestamps');

    /**
     * Set timestamps fields
     * @param array $subject
     * @return array
     */
    protected function timestamps($subject) {
        $subject['created_date'] = date('Y-m-d H:i:s');

        return $subject;
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Charity_fund_model extends MY_Model {
    
    protected $primary_key = 'charity_fund_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $degree
     * @return array
     */
    protected function timestamps($charity_fund) {
        $charity_fund['created_at'] = date('Y-m-d H:i:s');        
        return $charity_fund;
    }
}

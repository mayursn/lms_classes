<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_slider_model extends MY_Model {

    protected $primary_key = 'banner_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set the timestamp
     * @param array $banner
     * @return array
     */
    protected function timestamps($banner) {
        
         if(check_role_approval())
        {
            $banner['banner_status'] = 0;
        }
        
        $banner['created_date'] = date('Y-m-d H:i:s');
        return $banner;
    }
    protected function update_timestamps($banner)
    {
        if(check_role_approval())
        {
            $banner['banner_status'] = 0;
        }
        
        $banner['updated_date'] = date('Y-m-d H:i:s');
        return $banner;
    }
    
}

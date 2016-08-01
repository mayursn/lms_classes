<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_model extends MY_Model {
    
    protected $primary_key = 'forum_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    
    /**
     * Set timestamp field
     * @param array $degree
     * @return array
     */
    protected function timestamps($forum) {
        if(check_role_approval())
        {
            $forum['forum_status'] = 0;
        }
        
        $forum['created_date'] =  $forum['updated_date'] = date('Y-m-d H:i:s');
        
        return $forum;
    }
    protected function update_timestamps($forum)
    {
        if(check_role_approval())
        {
            $forum['forum_status'] = 0;
        }
        
        $forum['updated_date'] = date('Y-m-d H:i:s');
        return $forum;
    }
}
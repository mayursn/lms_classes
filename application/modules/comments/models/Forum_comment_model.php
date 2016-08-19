<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_comment_model extends MY_Model {
    
    protected $primary_key = 'forum_comment_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    
    /**
     * Set timestamp field
     * @param array $forumcomment
     * @return array
     */
    protected function timestamps($forumcomment) {
          if(check_role_approval())
        {
            $forumcomment['foram_comment_status'] = 0;
        }
        
        $forumcomment['created_date'] =  $forumcomment['updated_date'] = date('Y-m-d H:i:s');
        
        return $forumcomment;
    }
     protected function update_timestamps($forumcomment)
    {
        if(check_role_approval())
        {
            $forumcomment['foram_comment_status'] = 0;
        }
        
        $forumcomment['updated_date'] = date('Y-m-d H:i:s');
        return $forumcomment;
    }
}
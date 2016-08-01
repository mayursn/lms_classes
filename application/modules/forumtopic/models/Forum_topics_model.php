<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_topics_model extends MY_Model {
    
    protected $primary_key = 'forum_topic_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    
    /**
     * Set timestamp field
     * @param array $forumtopic
     * @return array
     */
    protected function timestamps($forumtopic) {
        if(check_role_approval())
        {
            $forumtopic['forum_topic_status'] = 0;
        }
        $forumtopic['created_date'] = date('Y-m-d H:i:s');
        
        return $forumtopic;
    }
    
    protected function update_timestamps($forumtopic)
    {
        if(check_role_approval())
        {
            $forumtopic['forum_topic_status'] = 0;
        }
        
        $forumtopic['updated_date'] = date('Y-m-d H:i:s');
        return $forumtopic;
    }
}
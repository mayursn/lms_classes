<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_questions_model extends MY_Model {
    
    protected $primary_key = 'quiz_question_id';
    public $has_many = array('quiz_question_options');
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    
    /**
     * Set timestamps fields
     * @param array $quiz
     * @return array
     */
    protected function timestamps($quiz_questions) {
        $quiz_questions['created_at'] = $quiz_questions['updated_at'] = date('Y-m-d H:i:s');
        
        return $quiz_questions;
    }
    
    /**
     * Set update timestamp field
     * @param array $quiz
     * @return array
     */
    protected function update_timestamps($quiz_questions) {
        $quiz_questions['updated_at'] = date('Y-m-d H:i:s');
        
        return $quiz_questions;
    }
    
    function quiz_questions_detail($quiz_id)
    {
        $this->db->select();        
        $this->db->where('qq.quiz_id',$quiz_id);
        return $this->db->get('quiz_questions qq')->result();     
    }
    
    
}

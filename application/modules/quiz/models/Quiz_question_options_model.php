<?php

class Quiz_question_options_model extends MY_Model {

    protected $primary_key = 'quiz_question_option_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set timestamps fields
     * @param array $quiz
     * @return array
     */
    protected function timestamps($quiz_question_options) {
        $quiz_question_options['created_at'] = $quiz_question_options['updated_at'] = date('Y-m-d H:i:s');

        return $quiz_question_options;
    }

    /**
     * Set update timestamp field
     * @param array $quiz
     * @return array
     */
    protected function update_timestamps($quiz_question_options) {
        $quiz_question_options['updated_at'] = date('Y-m-d H:i:s');

        return $quiz_question_options;
    }

    function get_question_option($question)
    {
        $this->db->where('quiz_question_id',$question);
      return   $this->db->get('quiz_question_options')->result();
    }
}

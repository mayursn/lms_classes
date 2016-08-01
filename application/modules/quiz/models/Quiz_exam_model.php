<?php

class Quiz_exam_model extends MY_Model {

    protected $primary_key = 'quiz_exam_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set timestamp fields 
     * @param array $quiz_exam
     * @return arry
     */
    protected function timestamps($quiz_exam) {
        $quiz_exam['created_at'] = $quiz_exam['updated_at'] = date('Y-m-d H:i:s');

        return $quiz_exam;
    }

    /**
     * Set update timestamp field
     * @param array $quiz_exam
     * @return array
     */
    protected function update_timestamps($quiz_exam) {
        $quiz_exam['updated_at'] = date('Y-m-d H:i:s');

        return $quiz_exam;
    }

}

<?php

class Quiz_result_model extends MY_Model {

    protected $primary_key = 'quiz_result_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set timestamps fields
     * @param array $quiz
     * @return array
     */
    protected function timestamps($quiz_result) {
        $quiz_result['created_at'] = $quiz_result['updated_at'] = date('Y-m-d H:i:s');

        return $quiz_result;
    }

    /**
     * Set update timestamp field
     * @param array $quiz
     * @return array
     */
    protected function update_timestamps($quiz_result) {
        $quiz_result['updated_at'] = date('Y-m-d H:i:s');

        return $quiz_result;
    }

    /**
     * Total quiz attempts
     * @param string $user_id
     * @param string $quiz_id
     * @return int
     */
    public function total_exam_attempts($quiz_id, $user_id) {
        return $this->db->select()
                        ->from($this->_table)
                        ->where('user_id', $user_id)
                        ->where('quiz_id', $quiz_id)
                        ->get()->num_rows();
    }   
    

    /**
     * 
     * @param int $quiz_id
     * @return mixed array
     */
    function get_quiz_history($quiz_id)
    {
        return $this->db->select('')
                        ->from('quiz_result')
                        ->join("quiz", "quiz.quiz_id = quiz_result.quiz_id")
                        ->join('user', 'user.user_id = quiz_result.user_id')
                        ->join('student', 'student.user_id = user.user_id')
                        ->where('quiz_result.quiz_id', $quiz_id)
                        ->group_by('quiz_result.user_id')
                        ->get()->result();
        
    }
}

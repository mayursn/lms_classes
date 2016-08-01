<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends MY_Model {

    protected $primary_key = 'quiz_id';
    public $has_many = array('quiz_questions');
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    //public $before_get = array('filter_quiz');

    /**
     * Set timestamps fields
     * @param array $quiz
     * @return array
     */
    protected function timestamps($quiz) {
        $quiz['created_at'] = $quiz['updated_at'] = date('Y-m-d H:i:s');

        return $quiz;
    }

    /**
     * Set update timestamp field
     * @param array $quiz
     * @return array
     */
    protected function update_timestamps($quiz) {
        $quiz['updated_at'] = date('Y-m-d H:i:s');

        return $quiz;
    }

    /**
     * Filter quiz
     */
    protected function filter_quiz() {
        if ($this->session->userdata('role_name') == 'Student') {
            $student = $this->db->get_where('student', array(
                        'user_id' => $this->session->userdata('user_id')
                    ))->row();
            $quiz = $this->db->get_where('quiz', array(
                        'department_id' => $student->std_degree,
                        'branch_id' => $student->course_id,
                        'batch_id' => $student->std_batch,
                        'semester_id' => $student->semester_id
                    ))->result();
        }
    }

    /**
     * All quiz details
     * @return array
     */
    public function quiz_details() {
        return $this->db->select()
                        ->from($this->_table)
                        ->join("degree", "degree.d_id = $this->_table.department_id")
                        ->join("course", "course.course_id = $this->_table.branch_id")
                        ->join("batch", "batch.b_id = $this->_table.batch_id")
                        ->join("semester", "semester.s_id = $this->_table.semester_id")
                        ->where("$this->_table.status", 1)
                        ->order_by("$this->_table.start_date", "DESC")
                        ->get()->result();
    }

    /**
     * Single quiz details
     * @param string $quiz_id
     * @return object
     */
    public function single_quiz_details($quiz_id) {
        return $this->db->select()
                        ->from($this->_table)
                        ->join("degree", "degree.d_id = $this->_table.department_id")
                        ->join("course", "course.course_id = $this->_table.branch_id")
                        ->join("batch", "batch.b_id = $this->_table.batch_id")
                        ->join("semester", "semester.s_id = $this->_table.semester_id")
                        ->where("$this->_table.status", 1)
                        ->where("$this->primary_key", $quiz_id)
                        ->order_by("$this->_table.start_date", "DESC")
                        ->get()->row();
    }

    /**
     * Exam validity type
     * @param string $quiz_id
     * @return string
     */
    public function quiz_validity_type($quiz_id) {
        return $this->db->select()
                        ->from($this->_table)
                        ->where('quiz_id', $quiz_id)
                        ->get()->row()->validity_type;
    }

    /**
     * User quiz history
     * @param string $user_id
     * @return array
     */
    public function user_quiz_history($user_id) {
        return $this->db->select('quiz_result.*, MAX(obtained_marks) AS BestResult, COUNT(*) AS TotalAttempts, quiz.*')
                        ->from('quiz_result')
                        ->join("$this->_table", "$this->_table.quiz_id = quiz_result.quiz_id")
                        ->where("quiz_result.user_id", $user_id)
                        ->group_by("quiz_result.quiz_id")
                        ->order_by('quiz_result.created_at', 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * View user quiz history
     * @param string $quiz_id
     * @param string $user_id
     * @return array
     */
    public function view_history($quiz_id, $user_id) {
        return $this->db->select()
                        ->from('quiz_result')
                        ->join("$this->_table", "$this->_table.quiz_id = quiz_result.quiz_id")
                        ->join('user', 'user.user_id = quiz_result.user_id')
                        ->where('quiz_result.quiz_id', $quiz_id)
                        ->where('quiz_result.user_id', $user_id)
                        ->get()->result();
    }

}

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
        //->where("$this->_table.status", 1)
        return $this->db->select()
                        ->from($this->_table)                                               
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
    /**
     * 
     * @param int $quiz_id
     * @return mixed array
     */
    function get_quiz_history($quiz_id)
    {
        return $this->db->select('quiz_result.*, MAX(obtained_marks) AS BestResult, COUNT(*) AS TotalAttempts, quiz.*,student')
                        ->from('quiz_result')
                        ->join("$this->_table", "$this->_table.quiz_id = quiz_result.quiz_id")
                        ->join('user', 'user.user_id = quiz_result.user_id')
                        ->join('student', 'student.user_id = user.user_id')
                        ->where('quiz_result.quiz_id', $quiz_id)
                        ->get()->result();
    }
    
    /**
     * View user quiz history
     * @param string $quiz_id
     * @param string $user_id
     * @return array
     */
    public function get_history_attempt($quiz_id,$user_id) {
       return $this->db->select('quiz_result.*, MAX(obtained_marks) AS BestResult, COUNT(*) AS TotalAttempts, quiz.*')
                        ->from('quiz_result')
                        ->join("$this->_table", "$this->_table.quiz_id = quiz_result.quiz_id")
                        ->where("quiz_result.user_id", $user_id)
                        ->where("quiz_result.quiz_id",$quiz_id)
                        ->order_by('quiz_result.created_at', 'DESC')
                        ->get()
                        ->result();
         
    }
    
    public function get_student_quiz($department,$branch,$batch,$semester)
    {
        $this->db->where('status','1');
        $this->db->where('department_id',$department);
        $this->db->or_where('department_id','All');
        $this->db->where('branch_id',$branch);
        $this->db->or_where('branch_id','All');
        $this->db->where('batch_id',$batch);
        $this->db->or_where('batch_id','All');
        $this->db->where('semester_id',$semester);               
        $this->db->or_where('semester_id','All');        
        
        $result = $this->db->get($this->_table)->result();           
        $result_array = array();
        $i=0;
        foreach ($result as $row):
            if($row->department_id=="All" || $row->department_id==$department)
            {
                if($row->branch_id=="All" || $row->branch_id==$branch)
                {
                    if($row->batch_id=="All" || $row->batch_id==$batch)
                    {
                        if($row->semester_id=="All" || $row->semester_id==$semester)
                        {
                            $result_array[] = (object) array('quiz_id' => $row->quiz_id,
            'title' => $row->title,
            'description' =>$row->description,
            'department_id' => $row->department_id,
            'branch_id' => $row->branch_id,
            'batch_id' => $row->batch_id,
            'semester_id' => $row->semester_id,
            'sm_id' => $row->sm_id,
            'validity_type' => $row->validity_type,
            'validity_value' => $row->validity_value,
            'total_marks' => $row->total_marks,
            'nagative_mark_status' => $row->nagative_mark_status,
            'nagative_mark' =>$row->nagative_mark, 
            'total_questions' => $row->total_questions,
            'timer_status' => $row->timer_status,
            'timer_value' => $row->timer_value,
            'difficulty_level' => $row->difficulty_level,
            'start_date' => $row->start_date,
            'end_date' => $row->end_date,
            'result_date' => $row->result_date,
            'status' => $row->status,
            'created_at' => $row->created_at,
            'updated_at' => $row->updated_at);
                        }
                    }
                }
            }
            $i++;
        endforeach;
       
        return $result_array;
        
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends MY_Controller {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('quiz/Quiz_model');
        $this->load->model('quiz/Quiz_question_options_model');
        $this->load->model('quiz/Quiz_questions_model');
        $this->load->model('quiz/Quiz_exam_model');
        $this->load->model('quiz/Quiz_result_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    /**
     * Index
     */
    function index() {
        $this->data['title'] = 'Quiz';
        $this->data['page'] = 'quiz';
        if($this->session->userdata('std_id'))
        {
            $std_id = $this->session->userdata('std_id');
            $this->load->model('student/Student_model');
           $student= $this->Student_model->get($std_id);
                    $department = $student->std_degree;
                    $branch = $student->course_id;
                    $batch = $student->std_batch;
                    $semester = $student->semester_id;
                   
            $this->data['quiz'] =  $this->Quiz_model->get_student_quiz($department,$branch,$batch,$semester);
            
       }else{
        
        $this->data['quiz'] = $this->Quiz_model->quiz_details();
        }
        
        $this->session->unset_userdata('quiz_id');
        $this->__template('quiz/index', $this->data);
    }

    /**
     * Index action
     */
    function create() {
        if ($_POST) {
           
            //                'difficulty_level' => $_POST['difficulty_level'],
            //              'result_date' => date('Y-m-d', strtotime($_POST['result_date']))
            $insert_id = $this->Quiz_model->insert(array(
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'department_id' => $_POST['department'],
                'branch_id' => $_POST['branch'],
                'batch_id' => $_POST['batch'],
                'semester_id' => $_POST['semester'],
                'sm_id'=>$_POST['subject'],
                'validity_type' => $_POST['validity_type'],
                'validity_value' => $_POST['validity_value'],
                'total_marks' => $_POST['total_marks'],
                'nagative_mark_status' => $_POST['nagative_marks_status'],
                'nagative_mark' => $_POST['nagative_marks'],
                'total_questions' => $_POST['total_questions'],
                'timer_status' => $_POST['timer_status'],
                'timer_value' => $_POST['timer_value'],
                'start_date' => date('Y-m-d', strtotime($_POST['start_date'])),
                'end_date' => date('Y-m-d', strtotime($_POST['end_date'])),
                'status' => $_POST['status']
  
            ));
//            $quiz = $this->Quiz_model->get($insert_id);
//            for ($i = 1; $i <= $quiz->total_questions; $i++) {
//                //insert questions
//                $question_id = $this->Quiz_questions_model->insert(array(
//                    'quiz_id' => $insert_id,
//                    'question_type' => '',
//                    'total_answer' => '',
//                    'question' => '',
//                    'currect_answer' => '',
//                    'answer_description' => ''
//                ));
//
//                //insert question
//                for ($j = 1; $j <= 4; $j++) {
//                    $option_id = $this->Quiz_question_options_model->insert(array(
//                        'quiz_id' => $insert_id,
//                        'quiz_question_id' => $question_id,
//                        'option_no' => $j,
//                        'question_option' => ''
//                    ));
//                }
//            }
            $this->flash_notification('Quiz is successfully added.');

            redirect(base_url('quiz/add_quiz_questions/' . $insert_id));
        }

        redirect(base_url('quiz'));
    }

    /**
     * Add quiz questions
     * @param string $quiz_id
     */
    function add_quiz_questions($quiz_id = '') {
        if ($_POST) {
            
            $question_1_option_1 = $_POST['question_1_option_1'];
            $question_1 = $_POST['question_1'];
            $question_1_answer = $_POST['question_1_answer'];
            
            
            if(!empty($question_1_option_1) && !empty($question_1) && !empty($question_1_answer))                
            {
            $quiz = $this->Quiz_model->get($quiz_id);
            for ($i = 1; $i <= $quiz->total_questions; $i++) {
                //insert questions
                $question_id = $this->Quiz_questions_model->insert(array(
                    'quiz_id' => $quiz_id,
                    'question_type' => $_POST['question_type_' . $i],
                    'total_answer' => count(explode(',', $_POST['question_' . $i . '_answer'])),
                    'question' => $_POST['question_' . $i],
                    'currect_answer' => $_POST['question_' . $i . '_answer'],
                    'answer_description' => ''
                ));

                //insert question
                for ($j = 1; $j <= 6; $j++) {
                    $option_id = $this->Quiz_question_options_model->insert(array(
                        'quiz_id' => $quiz_id,
                        'quiz_question_id' => $question_id,
                        'option_no' => $j,
                        'question_option' => $_POST['question_' . $i . '_option_' . $j]
                    ));
                }
            }
            $this->flash_notification('Quiz questions is successfully added.');

            redirect(base_url('quiz'));
            }else{
            $this->session->set_flashdata('error_message','Please enter required field.');

            redirect(base_url('quiz/add_quiz_questions/'.$quiz_id));   
            }
        }
        $this->data['title'] = 'Add Quiz Questions';
        $this->data['page'] = 'question';
        $this->data['quiz'] = $this->Quiz_model->single_quiz_details($quiz_id);
        $this->__template('quiz/add_quiz_questions', $this->data);
    }

    /**
     * Add quiz questions
     * @param string $quiz_id
     */
    function edit_quiz_questions($quiz_id = '') {
        
        if ($_POST) {           
            $quiz = $this->Quiz_model->get($quiz_id);
            $quiz_question = $this->Quiz_questions_model->quiz_questions_detail($quiz_id);        
            for ($i = 0; $i <= count($quiz_question)-1; $i++) {
                //insert questions
                $k = $i+1;
                //echo ;
                $question_id = $quiz_question[$i]->quiz_question_id;
                  $this->Quiz_questions_model->update($question_id,array(                    
                    'quiz_id' => $quiz_id,
                    'question_type' => $_POST['question_type_' .$k ],
                    'total_answer' => count(explode(',', $_POST['question_' . $k . '_answer'])),
                    'question' => $_POST['question_' . $k],
                    'currect_answer' => $_POST['question_' . $k . '_answer'],
                    'answer_description' => ''
                ));
               
                //insert question
                for ($j = 1; $j <= 4; $j++) {
                   $array = array(                                               
                        'question_option' => $_POST['question_' . $k . '_option_' . $j]
                    );
                   $this->db->where('quiz_id',$quiz_id);
                   $this->db->where('option_no',$j);
                   $this->db->where('quiz_question_id',$question_id);
                   $this->db->update('quiz_question_options',$array);
                }
                
            }
             
            $this->flash_notification('Quiz questions is successfully added.');

            redirect(base_url('quiz'));
        }
        $this->data['title'] = 'Edit Quiz Questions';
        $this->data['page'] = 'question';
        $this->data['quiz'] = $this->Quiz_model->single_quiz_details($quiz_id);  
        $this->data['quiz_question'] = $this->Quiz_questions_model->quiz_questions_detail($quiz_id);        
        $this->__template('quiz/edit_quiz_question', $this->data);
    }
     /**
     * Quiz instruction
     * @param type $id
     */
    function instruction($id = '') {
        if ($_POST) {
            $this->session->set_userdata('quiz_id', $_POST['quiz_id']);
            redirect('quiz/play_online_quiz/' . $id);
        }
        $this->data['quiz'] = $this->Quiz_model->get($id);
        if($this->data['quiz']->validity_type=="Attempt")
        {
           $validityvalue= $this->data['quiz']->validity_value;
           $attemptcount=$this->Quiz_result_model->get_many_by(array(
                'quiz_id' => $id,
                'user_id'=>$this->session->userdata('user_id')
            ));
           if(count($attemptcount)>=$validityvalue)
           {
               $this->session->set_userdata('quiznotification','You already attemp this quiz');
               redirect('quiz');
           }
        }
        if ($this->data['quiz']) {
            $this->data['title'] = 'Quiz Instruction';
            $this->data['page'] = 'quiz';
            $this->__template('quiz/instruction', $this->data);
        } else {
            redirect('quiz');
        }
    }
    /**
     * Play online quiz
     * @param string $quiz_id
     */
    function play_online_quiz($quiz_id) {
        //call validate function
        if ($this->session->userdata('quiz_id') != hash('sha1', $quiz_id)) {
          
            $is_avail_quiz = $this->Quiz_model->get($quiz_id);
          
            if ($is_avail_quiz) {
                redirect('quiz/instruction/' . $quiz_id);
            } else {
                redirect('quiz');
            }
        }
        if ($_POST) {
            //quiz status variables            
            $currect_answer = 0;
            $incurrect_answer = 0;
            $nagative_marks = 0.0;
            $total_marks = 0.0;

            $quiz = $this->Quiz_model->get($quiz_id);
            $quiz_questions = $this->Quiz_questions_model->get_many_by(array(
                'quiz_id' => $quiz_id
            ));

            $per_question_marks = number_format(($quiz->total_marks / count($quiz_questions)), 2);
            $i=0;
            //user quiz answers
            foreach ($quiz_questions as $row) {
                $i++;
                $quiz_exam_id=$_POST['quiz_exam_id_'.$i];
                $data = array(
                    'quiz_id' => $quiz_id,
                    'quiz_question_id' => $row->quiz_question_id,
                    'user_id' => $this->session->userdata('user_id')
                );
                if (isset($_POST['question_' . $row->quiz_question_id])) {
                    $data['answer'] = implode(',', $_POST['question_' . $row->quiz_question_id]);
                } else {
                    $data['answer'] = '';
                }

                //check for currect answer
                if ($data['answer'] == $row->currect_answer) {
                    $currect_answer++;
                } else {
                    if ($data['answer'] != '') {
                        $incurrect_answer++;
                    }
                }
                $this->Quiz_exam_model->update($quiz_exam_id,$data);
            }

            //check for nagative marks
            if ($quiz->nagative_mark_status) {
                $nagative_marks = $incurrect_answer * ($quiz->nagative_mark * $per_question_marks);
            }

            $total_marks = ($per_question_marks * $currect_answer) - $nagative_marks;

            //check for nagative total marks
            if ($total_marks < 0) {
                $total_marks = 0;
            }

            //user result
            $this->Quiz_result_model->update($_POST['quiz_result_id'],array(
                'quiz_id' => $quiz_id,
                'user_id' => $this->session->userdata('user_id'),
                'total_question_attemps' => $currect_answer + $incurrect_answer,
                'currect_answers' => $currect_answer,
                'obtained_marks' => $total_marks
            ));
            $this->flash_notification('Exam is successfully submitted.');
            //$this->session->unset_userdata('quiz_id');
            $user_id = $this->session->userdata('user_id');
            $result_id = $_POST['quiz_result_id'];
            redirect(base_url('quiz/result/'.$quiz_id.'/'.$user_id.'/'.$result_id));
        }
        
        //insert blank data in quiz_exam and quiz_exam_result
        
        $currect_answer = 0;
            $incurrect_answer = 0;
            $nagative_marks = 0.0;
            $total_marks = 0.0;

            $quiz = $this->Quiz_model->get($quiz_id);
            $quiz_questions = $this->Quiz_questions_model->get_many_by(array(
                'quiz_id' => $quiz_id
            ));

            $per_question_marks = number_format(($quiz->total_marks / count($quiz_questions)), 2);

            //user quiz answers
            foreach ($quiz_questions as $row) {
                $data = array(
                    'quiz_id' => $quiz_id,
                    'quiz_question_id' => $row->quiz_question_id,
                    'user_id' => $this->session->userdata('user_id')
                );
                if (isset($_POST['question_' . $row->quiz_question_id])) {
                    $data['answer'] = implode(',', $_POST['question_' . $row->quiz_question_id]);
                } else {
                    $data['answer'] = '';
                }

                //check for currect answer
                if ($data['answer'] == $row->currect_answer) {
                    $currect_answer++;
                } else {
                    if ($data['answer'] != '') {
                        $incurrect_answer++;
                    }
                }
               $quiz_exam_id[]=$this->Quiz_exam_model->insert($data);
            }

            //check for nagative marks
            if ($quiz->nagative_mark_status) {
                $nagative_marks = $incurrect_answer * ($quiz->nagative_mark * $per_question_marks);
            }

            $total_marks = ($per_question_marks * $currect_answer) - $nagative_marks;

            //check for nagative total marks
            if ($total_marks < 0) {
                $total_marks = 0;
            }

            //user result
          $quiz_result_id=  $this->Quiz_result_model->insert(array(
                'quiz_id' => $quiz_id,
                'user_id' => $this->session->userdata('user_id'),
                'total_question_attemps' => $currect_answer + $incurrect_answer,
                'currect_answers' => $currect_answer,
                'obtained_marks' => $total_marks
            ));
          $this->data['quiz_result_id']=$quiz_result_id;
          $this->data['quiz_exam_id']=$quiz_exam_id;
          //end
        $this->data['title'] = 'Play online quiz';
        $this->data['page'] = 'quiz';
        $this->data['quiz'] = $this->Quiz_model->single_quiz_details($quiz_id);
        $this->__template('quiz/play_online_quiz', $this->data);
    }
    
    function insertquizunload($quiz_id)
    {
             $currect_answer = 0;
            $incurrect_answer = 0;
            $nagative_marks = 0.0;
            $total_marks = 0.0;

            $quiz = $this->Quiz_model->get($quiz_id);
            $quiz_questions = $this->Quiz_questions_model->get_many_by(array(
                'quiz_id' => $quiz_id
            ));

            $per_question_marks = number_format(($quiz->total_marks / count($quiz_questions)), 2);
            $i=0;
            //user quiz answers
            foreach ($quiz_questions as $row) {
                $i++;
                $quiz_exam_id=$_POST['quiz_exam_id_'.$i];
                $data = array(
                    'quiz_id' => $quiz_id,
                    'quiz_question_id' => $row->quiz_question_id,
                    'user_id' => $this->session->userdata('user_id')
                );
                if (isset($_POST['question_' . $row->quiz_question_id])) {
                    $data['answer'] = implode(',', $_POST['question_' . $row->quiz_question_id]);
                } else {
                    $data['answer'] = '';
                }

                //check for currect answer
                if ($data['answer'] == $row->currect_answer) {
                    $currect_answer++;
                } else {
                    if ($data['answer'] != '') {
                        $incurrect_answer++;
                    }
                }
                $this->Quiz_exam_model->update($quiz_exam_id,$data);
            }

            //check for nagative marks
            if ($quiz->nagative_mark_status) {
                $nagative_marks = $incurrect_answer * ($quiz->nagative_mark * $per_question_marks);
            }

            $total_marks = ($per_question_marks * $currect_answer) - $nagative_marks;

            //check for nagative total marks
            if ($total_marks < 0) {
                $total_marks = 0;
            }

            //user result
            $this->Quiz_result_model->update($_POST['quiz_result_id'],array(
                'quiz_id' => $quiz_id,
                'user_id' => $this->session->userdata('user_id'),
                'total_question_attemps' => $currect_answer + $incurrect_answer,
                'currect_answers' => $currect_answer,
                'obtained_marks' => $total_marks
            ));

    }
    /**
     * Check for quiz is available to user or not
     * @param string $quiz_id
     * @param string $user_id
     * @return boolean
     */
    function is_quiz_available_to_user($quiz_id = '', $user_id = '') {
        $quiz = $this->Quiz_model->get($quiz_id);
        if ($quiz->validity_type == 'Day') {            
            //$end =  date('Y-m-d', strtotime($quiz->end_date. ' + 2 days'));
            //  && strtotime(date('Y-m-d')) >= $end
            if (strtotime(date('Y-m-d')) <= strtotime($quiz->end_date)) {
                return TRUE;
            }
        } else {
            $total_attempts = $this->Quiz_result_model->total_exam_attempts($quiz_id, $user_id);
            if ($quiz->validity_value > $total_attempts) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Edit quiz details
     * @param string $quiz_id
     */
    function edit($quiz_id = '') {
        $this->load->model('department/Degree_model');
        $this->load->model('branch/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('subject/Subject_manager_model');
        if ($quiz_id) {
            $this->data['title'] = 'Edit Quiz';
            $this->data['page'] = 'quiz';
            $this->data['department'] = $this->Degree_model->order_by_column('d_name');
            $this->data['branch'] = $this->Course_model->order_by_column('c_name');
            $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
            $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
            $this->data['subject'] = $this->Subject_manager_model->order_by_column('subject_name');
            
            $this->data['quiz'] = $this->Quiz_model->get($quiz_id);
            $this->data['quiz_questions'] = $this->Quiz_questions_model->get_many_by(array(
                'quiz_id' => $quiz_id
            ));
            $this->__template('quiz/edit', $this->data);
        }

        //redirect('quiz');
    }

    /**
     * Update quiz
     * @param string $id
     */
    function update($id = '') {
        if ($_POST) {   
            
            //  'difficulty_level' => $_POST['difficulty_level'],
            //  'result_date' => date('Y-m-d', strtotime($_POST['result_date']))
            $this->Quiz_model->update($id, array(
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'department_id' => $_POST['department'],
                'branch_id' => $_POST['branch'],
                'batch_id' => $_POST['batch'],
                'semester_id' => $_POST['semester'],
                'sm_id' => $_POST['subject'],
                'validity_type' => $_POST['validity_type'],
                'validity_value' => $_POST['validity_value'],
                'total_marks' => $_POST['total_marks'],
                'nagative_mark_status' => $_POST['nagative_marks_status'],
                'nagative_mark' => $_POST['nagative_marks'],
                'total_questions' => $_POST['total_questions'],
                'timer_status' => $_POST['timer_status'],
                'timer_value' => $_POST['timer_value'],              
                'start_date' => date('Y-m-d', strtotime($_POST['start_date'])),
                'end_date' => date('Y-m-d', strtotime($_POST['end_date'])),
                'status' => $_POST['status']
               
            ));
            $this->flash_notification('Quiz is successfully updated.');
        }

        redirect(base_url('quiz'));
    }

    function update_question($question_id = '') {
        if ($_POST) {
           
            //update question
            $this->Quiz_questions_model->update($question_id, array(
                'question' => $_POST['question'],
                'question_type' => $_POST['question_type'],
                'currect_answer' => $_POST['currect_answer']
            ));

            //question options
            $i = 1;
            $options = $this->Quiz_question_options_model->get_many_by(array(
                'quiz_question_id' => $question_id
            ));

            foreach ($options as $row) {
                $this->Quiz_question_options_model->update($row->quiz_question_option_id, array(
                    'question_option' => $_POST['option_' . $i]
                ));
                $i++;
            }
            redirect(base_url('quiz/edit/'.$_POST['quiz_id']));
        }
        
        
        
    }

    

    /**
     * Delete question details
     * @param string $quiz_id
     * @param string $question_id
     */
    function delete_question($quiz_id = '', $question_id = '') {
        if ($question_id) {
            $this->Quiz_questions_model->delete($question_id);

            //update total question
            $this->update_total_question_after_delete($quiz_id);
            $this->flash_notification('Question is successfully deleted.');
        }

        redirect(base_url('quiz/edit/' . $quiz_id));
    }

    /**
     * 
     * @param type $quiz_id
     */
    function update_total_question_after_delete($quiz_id) {
        $sql = "UPDATE quiz SET total_questions = total_questions - 1 ";
        $sql .= "WHERE quiz_id = ? ";
        $sql .= "AND total_questions > 0";
        $this->db->query($sql, [$quiz_id]);
    }
    /**
     * 
     * @param type $quiz_id
     */
    function update_total_question_after_create($quiz_id) {
        $sql = "UPDATE quiz SET total_questions = total_questions + 1 ";
        $sql .= "WHERE quiz_id = ? ";        
        $this->db->query($sql, [$quiz_id]);
    }

    function user_quiz_history() {
        $this->data['title'] = 'Quiz History';
        $this->data['page'] = 'quiz_history';        
        $this->data['quiz_history'] = $this->Quiz_model->user_quiz_history($this->session->userdata('user_id'));
        $this->__template('quiz/user_quiz_history', $this->data);
    }

    function view_history($quiz_id, $user_id) {
        $this->load->model('user/User_model');
        $this->data['title'] = 'Quiz History';
        $this->data['page'] = 'quiz_history';
        $this->data['history'] = $this->Quiz_model->view_history($quiz_id, $user_id);        
        $this->data['user'] = $this->User_model->get($user_id);
        $this->data['quiz'] = $this->Quiz_model->get($quiz_id);
        $this->__template('quiz/view_history', $this->data);
    }

    function quiz_history($quiz_id) {
        $this->load->model('user/User_model');
        $this->data['title'] = 'Quiz History';
        $this->data['page'] = 'quiz_history';
        $this->data['quiz_history'] = $this->Quiz_result_model->get_quiz_history($quiz_id);          
        $this->__template('quiz/get_user_quiz_history', $this->data);
        //$result =  $this->Quiz_model->get_quiz_history($quiz_id);
       
    }

    function create_question($quiz_id)
    {
        $this->load->model('quiz/Quiz_questions_model');
        if($_POST)
        {
             $quiz = $this->Quiz_model->get($quiz_id);            
                //insert questions
                $question_id = $this->Quiz_questions_model->insert(array(
                    'quiz_id' => $quiz_id,
                    'question_type' => $_POST['question_type'],
                    'total_answer' => count(explode(',', $_POST['question_answer'])),
                    'question' => $_POST['question'],
                    'currect_answer' => $_POST['question_answer'],
                    'answer_description' => ''
                ));

                //insert question
                for ($j = 1; $j <= 6; $j++) {
                    $option_id = $this->Quiz_question_options_model->insert(array(
                        'quiz_id' => $quiz_id,
                        'quiz_question_id' => $question_id,
                        'option_no' => $j,
                        'question_option' => $_POST['question_option_' . $j]
                    ));
                }
                $quiz = $this->Quiz_questions_model->get_many_by(array("quiz_id"=>$quiz_id));
                $quiz_total_question = count($quiz);
                $total_question_data = array("total_questions"=>$quiz_total_question);
                $this->update_total_question($quiz_id,$total_question_data);                               
        }   
            $this->flash_notification('Quiz questions is successfully added.');

            redirect(base_url('quiz/edit/'.$quiz_id));
        
    }
    
    function update_total_question($quiz_id,$data)
    {
        $this->Quiz_model->update($quiz_id,$data);
    }
    
     function delete($id)
    {
       $this->Quiz_model->delete($id);       
        redirect(base_url('quiz'));
    }
    
    function result($quiz_id='',$user_id='',$result_id='')
    {
        $this->db->select('quiz_result.*,s.*,q.*,MAX(obtained_marks) AS BestResult, COUNT(*) AS TotalAttempts');
        $this->db->where('quiz_result.user_id',$user_id);
        $this->db->where('quiz_result.quiz_id',$quiz_id);
        $this->db->where('quiz_result.quiz_result_id',$result_id);
        $this->db->join('student s','s.user_id=quiz_result.user_id');
        $this->db->join('quiz q','q.quiz_id=quiz_result.quiz_id');
        $this->data['quiz_history'] = $this->db->get('quiz_result')->row();
        $this->data['title'] = 'Quiz Result';
        $this->data['page'] = 'quiz_history';       
        $this->__template('quiz/instant_result', $this->data);
        
       
    }
    
    function change_dateformat()
    {
        error_reporting(0);
        $date = $_POST['getdate'];
        $days = $_POST['days'];
        $days = $days." days";
        $date=date_create($_POST['getdate']);
        date_add($date,date_interval_create_from_date_string($days));
        $date_final = date_format($date,"Y-m-d");
        echo date_formats($date_final);
        
    }
}
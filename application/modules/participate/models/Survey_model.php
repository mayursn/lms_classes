<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_model extends MY_Model {
    
    protected $primary_key = 'survey_id';
    
    
    /**
     * check duplicate
     * @param mixed array $data
     * @return type mixed array
     */
    function getrepeat($data)
    {
        return $this->db->get_where("survey",array("sq_id"=>$data['sq_id'],"student_id"=>$data['student_id']))->num_rows();
    }
    
   
     /**
     * 
     * @param mixed array $data
     */
    function addsurveyrating($data)
    {
        $this->db->insert("survey",$data);
    }
    
    
    function get_student_survey()
    {
        $std_id = $this->session->userdata('std_id');
         return $this->db->query(" SELECT * FROM `survey_question` where sq_id not in (SELECT sq_id FROM survey where student_id='".$std_id."') and question_status='1'")->result();    
    }
    
    /**
     * update survey question rating
     * @param mixed array $udata
     * @param int $id
     * @param int $std_id
     */
    function updatesurveyrating($udata,$id,$std_id)
    {
        
        $this->db->update("survey",$udata,array("sq_id"=>$id,"student_id"=>$std_id));
    }
   
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Courseware_model extends MY_Model {
    
    protected $primary_key = 'courseware_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    
    /**
     * Set timestamp fields
     * @param array $courseware
     * @return array
     */
    protected function timestamps($courseware) {
         if(check_role_approval())
        {
            $courseware['status'] = 0;
        }
        $courseware['created_date'] = $courseware['updated_date'] = date('Y-m-d H:i:s');
        
        return $courseware;
    }
    protected function update_timestamps($courseware)
    {
        if(check_role_approval())
        {
            $courseware['status'] = 0;
        }
        
        $courseware['updated_date'] = date('Y-m-d H:i:s');
        return $courseware;
    }
    
    public  function get_courseware()
    {
         $this->db->select('cw.courseware_id, cw.topic, cw.status, cw.chapter, cw.description, '
                . 'cw.attachment, c.course_id, c.c_name, sub.subject_name');
        $this->db->from('courseware cw');
        $this->db->join('course c', 'c.course_id=cw.branch_id');        
        $this->db->join('subject_manager sub', 'sub.sm_id=cw.subject_id');
          if($this->session->userdata('std_id'))
          {
                $course_id = $this->session->userdata('course_id');
                $this->db->where("cw.branch_id",$course_id);            
          }
        return $this->db->get()->result_array();
    }
 
    /**
     * get subject data
     * @param int $id
     * @return mixed array
     */
    function getsubject($id) {
        return $this->db->get_where('subject_manager', array('sm_course_id' => $id))->result_array();
    }

    function get_courseware_array($branch,$subject,$chapter,$topic,$editid)
    {
            $this->db->where('branch_id', $branch);
            $this->db->where('subject_id',$subject);
            $this->db->where('chapter',$chapter);
            $this->db->where('topic', $topic);
            $this->db->where_not_in('courseware_id', $editid);
            return $this->db->get('courseware')->result();
    }
    
    function get_duplicate($branch,$subject,$chapter,$topic)
    {
        $this->db->where('branch_id', $branch);
            $this->db->where('subject_id',$subject);
            $this->db->where('chapter', $chapter);
            $this->db->where('topic', $topic);
            return $this->db->get('courseware')->result();
    }
}
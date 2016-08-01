<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_manager_model extends MY_Model {
    
    protected $primary_key = 'sm_id';
    
    public $before_create = array('timestamps');
    
    /**
     * Set timestamp field
     * @param array $subject
     * @return array
     */
    protected function timestamps($subject) {
        $subject['created_date'] = date('Y-m-d H:i:s');
        
        return $subject;
    }
    
    function subjectdetail($id)
    {
         $this->db->select('sa.*,d.d_name,c.c_name,s.s_name,p.name,sm.subject_name,sm.subject_code');
             $this->db->where('sa.sm_id', $id);
             $this->db->from('subject_association sa');
             $this->db->join('degree d','d.d_id=sa.degree_id');
             $this->db->join('course c','c.course_id=sa.course_id');
             $this->db->join('semester s','s.s_id=sa.sem_id');
             $this->db->join('professor p','p.professor_id=sa.professor_id');
             $this->db->join('subject_manager sm','sm.sm_id=sa.sm_id'); 
            return $this->db->get()->result();
    }
    
    function subject_detail_create($data)
    {
        return $this->db->insert('subject_association',$data);
    }
    function subject_detail_update($id,$data)
    {
        $this->db->where('sa_id', $id);
        return $this->db->update('subject_association', $data);
    }
    function subject_detail_delete($id)
    {
        $this->db->where('sa_id', $id);
        return $this->db->delete('subject_association');
    }
    
    function branch_subject($courseid)
    {
        $this->db->select();
        $this->db->where('sa.course_id',$courseid);
        $this->db->from('subject_association sa');
        $this->db->join('subject_manager s','s.sm_id=sa.sm_id');
        return $this->db->get()->result();
    }
}
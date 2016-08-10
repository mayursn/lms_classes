<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_manager_model extends MY_Model {
    
    protected $primary_key = 'sm_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');
    public $before_get = array('check_status');
    
    /**
     * Set timestamp field
     * @param array $subject
     * @return array
     */
    protected function timestamps($subject) {
	  if(check_role_approval())
        {
            $subject['sm_status'] = 0;
        }
        $subject['created_date'] = $subject['updated_date'] = date('Y-m-d H:i:s');
        
        return $subject;
    }

  protected function update_timestamps($subject)
    {
        if(check_role_approval())
        {
            $subject['sm_status'] = 0;
        }
        
        $subject['updated_date'] = date('Y-m-d H:i:s');
        return $subject;
    }
    
    function subjectdetail($id)
    {
            $this->db->select('sa.*,sm.subject_name,sm.subject_code,b.*');
            $this->db->where('sm.sm_id', $id);             
            $this->db->from('subject_association sa');             
            $this->db->join('branch_location b','b.branch_id=sa.branch_id');             
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
    function get_subject_name($id)
    {
        $this->db->where('sm_id',$id);
        return $this->db->get('subject_manager')->row()->subject_name;
    }
    function subejct_list_branch_sem($course,$admission_plan)    
    {
        
        $this->db->where("course_id",$course);
        $this->db->where("admission_plan_id",$admission_plan);
        return $this->db->get('subject_manager')->result();
        
       
    }
    
    function subject_from_dept_branch_sem($dept,$branch,$sem)
    {
        $this->db->join("subject_manager s","s.sm_id = sa.sm_id");
        $this->db->where("sa.degree_id",$dept);
        $this->db->where("sa.course_id",$branch);
        $this->db->where("sa.sem_id",$sem);
        return $this->db->get_where("subject_association sa")->result();
    }
    
    function subject_list_admission_plan($branch,$course,$admission_plan)
    {
        $this->db->where('sm.course_id',$course);
        $this->db->where('sa.branch_id',$branch);
        $this->db->where('sa.admission_plan_id',$admission_plan);
        $this->db->join("subject_association sa",'sa.sm_id=sm.sm_id');
        return  $this->db->get('subject_manager sm')->result();
     
    }
    
    function get_all_subject()
    {
        return $this->db->get($this->_table)->result();
    }
    
    function check_status()
    {
        
    }
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_manager_model extends MY_Model {

    protected $primary_key = 'pm_id';
    public $before_create = array('timestamps');
    public $before_get = array('department_filter');
    public $before_update = array('update_timestamps');
    /**
     * Set timestamp field
     * @param array $degree
     * @return array
     */
    
    
    protected function timestamps($assignment) {
         if(check_role_approval())
        {
            $assignment['pm_status'] = 0;
        }
        $assignment['created_date'] = $assignment['updated_date'] = date('Y-m-d H:i:s');
        return $assignment;
    }
     protected function update_timestamps($project)
    {
        $project['updated_date'] = date('Y-m-d H:i:s');
        return $project;
    }
    function department_filter()
    {
        if($this->session->userdata('professor_id'))
        {
            $dept = $this->session->userdata('professor_department');
            $this->db->where("pm_degree",$dept);
        }
    }
    
    public function get_student_project_list($degree,$batch,$sem,$course,$class,$std_id)
    {
        return $this->db->query("SELECT * FROM project_manager WHERE pm_degree='$degree' AND pm_batch = '$batch' AND pm_semester = '$sem' AND pm_course = '$course' AND class_id='$class' AND FIND_IN_SET('$std_id',pm_student_id)")->result();
    }
    public function submitted_project_by_student($std_id)
    {
        
                                $this->db->select('s.dos,s.document_file,a.pm_title');
                                $this->db->from('project_document_submission s');
                                $this->db->join('project_manager a', 'a.pm_id=s.project_id');
                                $this->db->where('s.student_id', $std_id);
                                 return $this->db->get();                               
    }

}

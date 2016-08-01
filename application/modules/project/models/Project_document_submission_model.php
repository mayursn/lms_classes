<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_document_submission_model extends MY_Model {

    protected $primary_key = 'project_document_id';
    public $before_create = array('timestamps');

    /**
     * Set timestamp field
     * @param array $degree
     * @return array
     */
    protected function timestamps($assignment) {
        $assignment['dos'] = date('Y-m-d H:i:s');
        return $assignment;
    }

    public function get_submitted_project($degree, $course, $batch, $semester) {
        $this->db->select("ps.student_id,ps.project_id,ps.dos,ps.description,ps.document_file,pm_id,pm.pm_title,pm.pm_degree,pm.pm_course,pm.pm_batch,pm.pm_semester,s.std_id, s.std_first_name, s.std_last_name, s.email");
        $this->db->from('project_document_submission ps');
        $this->db->join("project_manager pm", "pm.pm_id=ps.project_id");
        $this->db->join("student s", "s.std_id=ps.student_id");
        $this->db->where("pm_course", $course);
        $this->db->where("pm_batch", $batch);
        $this->db->where("pm_degree", $degree);
        $this->db->where("pm_semester", $semester);
        return $this->db->get()->result();
    }
    
      /**
     * submitted project
     * @return mixed array
     */
    function get_all_submitted_project()
    {
        $this->db->select("ps.student_id,ps.project_id,ps.dos,ps.description,ps.document_file,pm_id,pm.pm_title,pm.pm_degree,pm.pm_course,pm.pm_batch,pm.pm_semester,s.std_id, s.std_first_name, s.std_last_name, s.email");
        $this->db->from('project_document_submission ps');
        $this->db->join("project_manager pm", "pm.pm_id=ps.project_id");
        $this->db->join("student s", "s.std_id=ps.student_id");
          if($this->session->userdata('professor_id'))
        {
            $dept = $this->session->userdata('professor_department');
            $this->db->where("pm.pm_degree",$dept);
        }
        return  $this->db->get();
    }
    
    

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Professor_model extends MY_Model {

    protected $primary_key = 'professor_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set timestamp fields
     * @param array $professor
     * @return array
     */
    protected function timestamps($professor) {
        $professor['created_at'] = $professor['updated_at'] = date('Y-m-d H:i:s');

        return $professor;
    }

    /**
     * Set update timestamp field
     * @param array $professor
     * @return array
     */
    protected function update_timestamps($professor) {
        $professor['updated_at'] = date('Y-m-d H:i:s');

        return $professor;
    }

    /**
     * 
     */
    function get_recent_professor() {
        $this->db->select("professor_id,name,image_path,created_at,designation");
        $this->db->from("professor");
        $this->db->order_by("created_at", "DESC");
        //$this->db->limit(8);
        return $this->db->get()->result();
    }
    
     /**
     * Find the class routine for attendance
     * @param mixed $where
     * @return mixed
     */
    function class_routine_attendance($where) {
        return $this->db->select()
                        ->from('class_routine')
                        ->join('subject_manager', 'subject_manager.sm_id = class_routine.SubjectID')
                        ->where(array(
                            'class_routine.DepartmentID' => $where['department_id'],
                            'DATE_FORMAT(class_routine.Start, "%Y-%m-%d") <= ' => date('Y-m-d', strtotime($where['class_date'])),
                            'class_routine.BranchID' => $where['branch_id'],
                            'class_routine.BatchID' => $where['batch_id'],
                            'class_routine.SemesterID' => $where['semester_id'],
                            'class_routine.ClassID' => $where['class_id'],
                            'class_routine.ProfessorID' => $where['professor_id']
                        ))->order_by('class_routine.ClassRoutineId', 'ASC')->get()->result();
    }
    
  /**
     * Professor class schedule
     * @return mixed
     */
    function professor_class_schedule() {
        return $this->db->get_where('class_routine', [
                    'ProfessorID' => $this->session->userdata('professor_id')
                ])->result();
    }


}

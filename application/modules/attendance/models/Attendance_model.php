<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends MY_Model {
    
    protected $primary_key = 'attendance_id';
    
    public $before_create = array('timestamps');
    public $before_update = array('timestamps_update');
    
    /**
     * Set timestamp field
     * @param array $attendance
     * @return array
     */
    protected function timestamps($attendance) {
        $attendance['created_at'] = date('Y-m-d H:i:s');        
        return $attendance;
    }
    
    protected function timestamps_update($attendance) {
         $attendance['updated_at'] = date('Y-m-d H:i:s');        
        return $attendance;
    }


    /**
     * Save student attendance
     * @param mixed $data
     * @param string $id
     * @return int
     */
    function save_student_attendance($data, $id = NULL) {
        $insert_id = 0;
        if ($id) {
            //update
            $this->db->where('attendance_id', $id);
            $this->db->update('attendance', $data);
        } else {
            //insert
            $this->db->insert('attendance', $data);
            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }
      /**
     * Find the class routine for attendance
     * @param string $where
     * @return mixed
     */
    function professor_class_routine_attendance($professor_id, $date) {
        return $this->db->select()
                        ->from('class_routine')
                        ->join('subject_manager', 'subject_manager.sm_id = class_routine.SubjectID')
                        ->join('degree', 'degree.d_id = class_routine.DepartmentID')
                        ->join('course', 'course.course_id = class_routine.BranchID')
                        ->join('semester', 'semester.s_id = class_routine.SemesterID')
                        ->join('class', 'class.class_id = class_routine.ClassID')
                        ->where(array(
                            //'class_routine.DepartmentID' => $where['department_id'],
                            'DATE_FORMAT(class_routine.Start, "%Y-%m-%d") <= ' => date('Y-m-d', strtotime($date)),
                            //'class_routine.BranchID' => $where['branch_id'],
                            // 'class_routine.BatchID' => $where['batch_id'],
                            //'class_routine.SemesterID' => $where['semester_id'],
                            //'class_routine.ClassID' => $where['class_id'],
                            'class_routine.ProfessorID' => $professor_id
                        ))->order_by('class_routine.ClassRoutineId', 'ASC')->get()->result();
    }
    
    function class_routine_details($class_routine_id) {
        return $this->db->select()
                        ->from('class_routine')
                        ->join('subject_manager', 'subject_manager.sm_id = class_routine.SubjectID')
                        ->join('degree', 'degree.d_id = class_routine.DepartmentID')
                        ->join('course', 'course.course_id = class_routine.BranchID')
                        ->join('semester', 'semester.s_id = class_routine.SemesterID')
                        ->join('class', 'class.class_id = class_routine.ClassID')
                        //->join('batch', 'batch.batch_id = class_routine.BatchID')
                        ->where([
                            'class_routine.ClassRoutineID' => $class_routine_id
                        ])->get()->row();
    }

    /**
     * Class routine status
     * @param string $class_routine_id
     * @param string $date
     * @return int
     */
    function class_routine_status($class_routine_id, $date) {
        return $this->db->select()
                ->from('attendance')
                ->where([
                    'class_routine_id'  => $class_routine_id,
                    'date_taken'    => $date
                ])->get()->num_rows();
    }
    
    
    function get_attendance_status($branch,$course,$admission_plan,$class,$date,$std_id,$subject)
    {
                $this->db->where('course_id',$course);
                $this->db->where('branch_id',$branch);
                $this->db->where('admission_plan_id',$admission_plan);
                $this->db->where('date_taken',$date);
                $this->db->where('class_id',$class);                
                $this->db->where('student_id',$std_id);
                $this->db->where('sm_id',$subject);
                return $this->db->get('attendance')->row();
    }
}
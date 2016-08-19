<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends MY_Model {

    /**
     * Daily registered students count
     * @param string $date
     * @return int
     */
    function daily_registered_students($date) {
        return $this->db->select()
                        ->from('student')
                        ->like('created_date', $date)
                        ->get()->num_rows();
    }
    
    
    /**
     * Student count with region
     * @return array
     */
    function student_cout_with_regions() {
//        return $this->db->select('COUNT(*) AS Total, city')
//                ->from('student')
//                ->group_by('city')                
//                ->get()->result();
         
       return $this->db->select('count(city) AS Total, city')
               ->from('student')
               ->group_by('city')   
               ->order_by('Total','desc')
               ->limit(5)
               ->get()
               ->result();        
    }
    
    /**
     * Department wise student count
     * @return array
     */
    function department_wise_student() {
        return $this->db->select('COUNT(*) AS Total, c_name')
                ->from('student')
                ->join('course', 'course.course_id = student.course_id')
                ->group_by('student.course_id')
                ->having('Total > 0')
                ->get()->result();
    }

   

}

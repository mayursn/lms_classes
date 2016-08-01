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
        return $this->db->select('COUNT(*) AS Total, city')
                ->from('student')
                ->group_by('city')
                ->get()->result();
    }
    
    /**
     * Department wise student count
     * @return array
     */
    function department_wise_student() {
        return $this->db->select('COUNT(*) AS Total, d_name')
                ->from('student')
                ->join('degree', 'degree.d_id = student.std_degree')
                ->group_by('std_degree')
                ->having('Total > 0')
                ->get()->result();
    }

   

}

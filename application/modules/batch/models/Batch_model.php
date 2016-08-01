<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Batch_model extends MY_Model {

    protected $primary_key = 'b_id';
    public $before_create = array('timestamps');

    /**
     * Set timestamp field
     * @param array $batch
     * @return array
     */
    protected function timestamps($batch) {
        $batch['created_date'] = date('Y-m-d H:i:s');

        return $batch;
    }

    /**
     * Batch by department and branch
     * @param string $department
     * @param string $branch
     * @return array
     */
    function department_branch_batch($department, $branch) {
        $batch = $this->db->query("SELECT * FROM batch WHERE FIND_IN_SET('" . $department . "',degree_id) AND FIND_IN_SET('" . $branch . "',course_id)")->result();
        
        return $batch;
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Batch extends MY_Controller {
    
    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('batch/Batch_model');
    }
    
    /**
     * Batch by department and branch
     * @param string $department
     * @param string $branch
     */
    function department_branch_batch($department, $branch) {
        $batch = $this->Batch_model->department_branch_batch($department, $branch);
        
        echo json_encode($batch);
    }
}
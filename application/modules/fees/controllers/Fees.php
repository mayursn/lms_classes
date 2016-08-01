<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fees extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('fees/Fees_structure_model');
        $this->load->model('student/Student_model');
        $this->load->model('department/Degree_model');
        $this->load->model('branch/Course_model');
        $this->load->model('semester/Semester_model');
         $this->load->model('batch/Batch_model');
         
        
       
      
    }

    function index() {
       $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['fees_structure'] = $this->Fees_structure_model->get_all_fees_structure();
        $this->data['title'] = 'Fee Structure';
        $this->data['page'] = 'fee_structure';
     
        $this->__template('fees/index', $this->data);
    }
    
    
    function create()
    {
         //check for duplication
                $is_record_present = $this->Fees_structure_model->get_many_by(array(
                    'degree_id' => $_POST['degree'],
                    'course_id' => $_POST['course'],
                    'batch_id' => $_POST['batch'],
                    'sem_id' => $_POST['semester'],
                    'title' => $_POST['title']
                ));
                if (count($is_record_present)) {
                    $this->session->set_flashdata('flash_message', 'Data is already present');
                    redirect(base_url().'fees');
                } else {
                 $inser_data = array(
                        'title' => $this->input->post('title', TRUE),
                        'degree_id' => $this->input->post('degree', TRUE),
                        'course_id' => $this->input->post('course', TRUE),
                        'batch_id' => $this->input->post('batch', TRUE),
                        'sem_id' => $this->input->post('semester', TRUE),
                        'total_fee' => $this->input->post('fees', TRUE),
                        'description' => $this->input->post('description', TRUE),
                        'fee_start_date' => nice_date($this->input->post('start_date', TRUE),"Y-m-d"),
                        'fee_end_date' => nice_date($this->input->post('end_date', TRUE),"Y-m-d"),
                        'fee_expiry_date' => nice_date($this->input->post('expiry_date', TRUE),"Y-m-d"),
                        'penalty' => $this->input->post('penalty', TRUE)
                    );
                   $insert_id = $this->Fees_structure_model->insert($inser_data);
                    //create notification for students
                    create_notification('fees_structure', $_POST['degree'], $_POST['course'], $_POST['batch'], $_POST['semester'], $insert_id);
                    $this->flash_notification('Fee structure is successfully added.');
                    redirect(base_url().'fees');
                }
    }
    function update($param2 ='')
    {
        
         $this->Fees_structure_model->update($param2,array(
                    'title' => $this->input->post('title', TRUE),
                    'degree_id' => $this->input->post('degree', TRUE),
                    'course_id' => $this->input->post('course', TRUE),
                    'batch_id' => $this->input->post('edit_batch', TRUE),
                    'sem_id' => $this->input->post('semester', TRUE),
                    'total_fee' => $this->input->post('fees', TRUE),
                   'fee_start_date' => nice_date($this->input->post('start_date', TRUE),"Y-m-d"),
                   'fee_end_date' => nice_date($this->input->post('end_date', TRUE),"Y-m-d"),
                   'fee_expiry_date' => nice_date($this->input->post('expiry_date', TRUE),"Y-m-d"),
                    'penalty' => $this->input->post('penalty', TRUE),
                    'description' => $this->input->post('description', TRUE),
                        ));
                $this->flash_notification('Fee structure is successfully updated.');
                redirect(base_url().'fees');
    }
    
      /**
     * Fee structure ajax filter
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     */
    function fee_structure_filter($degree, $course, $batch, $semester) {
         if ($degree == "All") {
             $this->data['fees_structure'] = $this->Fees_structure_model->get_all();
         }else {
            if ($course == "All") {
                
                $this->data['fees_structure'] = $this->Fees_structure_model->get_many_by(array("degree_id"=>$degree));
            }
            else{
                if ($batch == "All") {
                    $this->data['fees_structure'] = $this->Fees_structure_model->get_many_by(array("degree_id"=>$degree,"course_id"=>$course));
                }
                else{
                    if ($semester == "All") {
                           $this->data['fees_structure'] = $this->Fees_structure_model->get_many_by(array("degree_id"=>$degree,"course_id"=>$course,"batch_id"=>$batch));
                    }
                    else{
                    $this->data['fees_structure'] = $this->Fees_structure_model->get_many_by(array("degree_id"=>$degree,"course_id"=>$course,"batch_id"=>$batch,"sem_id"=>$semester));    
                    }
                    
                }
            }
            }
      //  $this->data['fees_structure'] = $this->Fees_structure_model->fee_structure_filter($degree, $course, $batch, $semester);
        $this->load->view("fees/fee_structure_filter", $this->data);
    }
    
    function delete($id='')
    {
        $this->Fees_structure_model->delete($id);
        $this->flash_notification('Fee structure is successfully deleted.');
                redirect(base_url().'fees');
    }
    
     /**
     * Fees structure details
     * @param string $course_id
     * @param string $semester_id
     */
    function fees_structure_details($course_id = '', $semester_id = '') {
        $fees_structure = $this->Fees_structure_model->get_many_by(array(
                            'course_id' => $course_id,
                            'sem_id' => $semester_id,
                            'fee_expiry_date >= ' => date('Y-m-d')
                        ));
        echo json_encode($fees_structure);
    }
    
     /**
     * Fees structure details
     * @param string $course_id
     * @param string $semester_id
     */
    function fees_structure_details_student($course_id = '', $semester_id = '') {        
        $where1 = "course_id='$course_id' OR course_id='All'";
        $where2 = "sem_id='$semester_id' OR sem_id='All'";

        $this->db->where($where1);
        $this->db->where($where2);       
        $this->db->where('fee_expiry_date >= ',date('Y-m-d'));
       $fees_structure = $this->db->get('fees_structure')->result();
        //$fees_structure = $this->Fees_structure_model->get_many_by();
        echo json_encode($fees_structure);
    }
    
     /**
     * Student fees structure details
     * @param string $fees_structure_id
     */
    function student_fees_structure_details($fees_structure_id) {
        $fees_structure = $this->Fees_structure_model->get($fees_structure_id);
        echo json_encode($fees_structure);
    }
    
     /**
     * Course semester paid fee
     * @param int $fees_structure_id
     */
    function course_semester_paid_fee($fees_structure_id) {
        $student_detail = $this->Student_model->get($this->session->userdata('std_id'));
        //$fees_structure = $this->Student_model->fees_structure_details($fees_structure_id);
        $paid_fees = $this->Fees_structure_model->student_paid_fees($fees_structure_id, $student_detail->std_id);
        $total_paid = 0;
        if (count($paid_fees)) {
            foreach ($paid_fees as $paid) {
                $total_paid += $paid->paid_amount;
            }
        }
        echo json_encode($total_paid);
    }
    
    /**
     * Get Course
     * @param string $param
     */
    function get_cource($param = '') {
        
        $did = $this->input->post("degree");
         $cource = $this->db->get_where("course", array("degree_id" => $did))->result_array();
        echo json_encode($cource);
    }
    
    /**
     * Get batches
     * @param string $param
     */
    function get_batchs($param = '') {
        $cid = $this->input->post("course");
        $did = $this->input->post("degree");
        $batch = $this->db->query("SELECT * FROM batch WHERE FIND_IN_SET('" . $did . "',degree_id) AND FIND_IN_SET('" . $cid . "',course_id)")->result_array();
        echo json_encode($batch);
    }
    
     /**
     * get all semester
     */
    function get_semesterall() {

        $cid = $this->input->post("course");

        if ($cid == 'All') {
            $course = $this->db->get('course')->result_array();
        } else {

            $course = $this->db->get_where('course', array('course_id' => $cid))->result_array();
        }

        $semexplode = explode(',', $course[0]['semester_id']);
        $semester = $this->db->get('semester')->result_array();
        $semdata = '';
        foreach ($semester as $sem) {
            if (in_array($sem['s_id'], $semexplode)) {
                $semdata[] = $sem;
            }
        }
        echo json_encode($semdata);
    }


}

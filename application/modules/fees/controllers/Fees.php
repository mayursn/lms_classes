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
        $this->load->model('courses/Course_model');
        $this->load->model('semester/Semester_model');
         $this->load->model('batch/Batch_model');
         if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
        
       
      
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
                    'branch_id' => $_POST['branch'],
                    'course_id' => $_POST['course'],
                    'admission_plan_id' => $_POST['admission_plan'],
                    'class_id' => $_POST['class'],                    
                    'title' => $_POST['title']
                ));
                if (count($is_record_present)) {
                    $this->session->set_flashdata('flash_message', 'Data is already present');
                    redirect(base_url().'fees');
                } else {
                 $inser_data = array(
                        'title' => $this->input->post('title', TRUE),
                        'branch_id' => $this->input->post('branch', TRUE),
                        'course_id' => $this->input->post('course', TRUE),
                        'admission_plan_id' => $this->input->post('admission_plan', TRUE),
                        'class_id' => $this->input->post('class', TRUE),
                        'total_fee' => $this->input->post('fees', TRUE),
                        'description' => $this->input->post('description', TRUE),
                        'fee_start_date' => nice_date($this->input->post('start_date', TRUE),"Y-m-d"),
                        'fee_end_date' => nice_date($this->input->post('end_date', TRUE),"Y-m-d"),
                        'fee_expiry_date' => nice_date($this->input->post('expiry_date', TRUE),"Y-m-d"),
                        'penalty' => $this->input->post('penalty', TRUE)
                    );
                   $insert_id = $this->Fees_structure_model->insert($inser_data);
                   
                
                $admission_plan = $_POST['admission_plan'];
                $branch = $_POST['branch'];
                $course = $_POST['course'];      
                $class = $_POST['class'];      
                $this->db->where('branch_id', $branch);                  
                $this->db->where('course_id', $course);
                $this->db->where('admission_plan_id', $admission_plan);
                $this->db->where('class_id', $class);
                $students = $this->db->get('student')->result();
                
                $std_id = '';
                foreach ($students as $std) {
                    $id = $std->std_id;
                    $std_id[] = $id;
                    //  $student_id = implode(",",$id);
                    // $std_ids[] =$student_id;
                }
                if ($std_id != '') {
                    $student_ids = implode(",", $std_id);
                } else {
                    $student_ids = '';
                }
                $this->db->where("notification_type", "fees_structure");
                $res = $this->db->get("notification_type")->row();
                if ($res != '') {
                    $notification_id = $res->notification_type_id;
                    $notify['notification_type_id'] = $notification_id;
                    $notify['student_ids'] = $student_ids;
                    $notify['branch_id'] = $branch;
                    $notify['course_id'] = $course;
                    $notify['admission_plan_id'] = $admission_plan;                    
                    $notify['class_id'] = $class;                    
                    $notify['data_id'] = $insert_id;
                    $this->db->insert("notification", $notify);
                 
                }
                    //create notification for students
                    //create_notification('fees_structure', $_POST['branch'], $_POST['course'], $_POST['admission_plan'], $_POST['class'], $insert_id);
                    $this->flash_notification('Fee structure is successfully added.');
                    redirect(base_url().'fees');
                }
    }
    function update($param2 ='')
    {
        
         $this->Fees_structure_model->update($param2,array(
                    'title' => $this->input->post('title', TRUE),
                    'branch_id' => $this->input->post('branch', TRUE),
                    'course_id' => $this->input->post('course', TRUE),
                    'admission_plan_id' => $this->input->post('admission_plan', TRUE),
                    'class_id' => $this->input->post('class', TRUE),
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
    function fee_structure_filter($branch, $course, $admission_plan, $class) {
 
        $this->data['fees_structure'] = $this->Fees_structure_model->get_many_by(
                array("branch_id"=>$branch,
            "course_id"=>$course,
            "admission_plan_id"=>$admission_plan,
            "class_id"=>$class));    
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

     function check_student_paidfee()
    {
        $fees_structure_id=$this->input->post('fees_structure');
        $student_id=$this->input->post('student_id');
        $paid_fees = $this->Fees_structure_model->paid_student_fees($fees_structure_id,$student_id);
        if(count($paid_fees)>0)
        {
            echo 'false';
        }
        else
        {
            echo 'true';
        }
    }

}

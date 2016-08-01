<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marks extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('marks/Marks_manager_model');
        $this->load->model('department/Degree_model');
        $this->load->model('courses/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('examschedual/Exam_time_table_model');
        $this->load->model('exam/Exam_manager_model');
        $this->load->model('student/Student_model');
        $this->load->model('marks/Internal_marks_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
            
    }

    /**
     * Index action
     */
    function index($branch_id = '', $course_id = '', $admission_plan_id = '', $exam_id = '', $student_id = '') {
        $this->data['semester_id'] = '';
        $this->data['title'] = 'Marks';
        $this->data['page'] = 'marks';        
        $this->load->model('branch/Branch_location_model');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['branch'] = $this->Branch_location_model->order_by_column('branch_name');
        $this->data['time_table'] = $this->Exam_time_table_model->time_table();
        if($_POST)
        {
            //echo "<pre>";
           // print_r($_POST);
            
            //exam details

            $exam_detail = $this->Exam_manager_model->exam_detail($exam_id);

            //subject details
            $subject_details = $this->Exam_manager_model->exam_time_table_subject_list($exam_id);

            //$subject_details = $this->Crud_model->exam_time_table_subject_list($exam_detail[0]->em_id);
            //student list
            $student_list = $this->Student_model->get_many_by(array(
                    'branch_id' => $branch_id,
                    'course_id' => $course_id,
                    'admission_plan_id' => $admission_plan_id                    
                ));

            $total_students = $_POST['total_student'];


            for ($i = 1; $i <= $total_students; $i++) {
                //subject loop
                if ($student_id != '') {
                    if ($student_id != $student_list[$i - 1]->std_id)
                        continue;
                }
                for ($j = 0; $j < count($subject_details); $j++) {
                    //where

                    $where = array(
                        'mm_std_id' => $student_list[$i - 1]->std_id,
                        'mm_subject_id' => $subject_details[$j]->sm_id,
                        'mm_exam_id' => $exam_detail[0]->em_id,
                    );
                    $marks = $this->Marks_manager_model->get_many_by($where);
                    $int_sm_id = $subject_details[$j]->sm_id;                                         
                    if (count($marks)) {
                        if ($student_id != '') {
                            $this->Marks_manager_model->mark_update(array(
                                'mm_std_id' => $student_list[$i - 1]->std_id,
                                'mm_subject_id' => $subject_details[$j]->sm_id,
                                'mm_exam_id' => $exam_detail[0]->em_id,
                                'mark_obtained' => $_POST["mark_1_{$student_list[$i - 1]->std_id}_{$exam_detail[0]->em_id}_{$subject_details[$j]->sm_id}"],
                                'mm_remarks' => $_POST["remark_1_{$student_list[$i - 1]->std_id}_{$exam_detail[0]->em_id}"],
                                    ), $where);
                        } else {
                            $this->Marks_manager_model->mark_update(array(
                                'mm_std_id' => $student_list[$i - 1]->std_id,
                                'mm_subject_id' => $subject_details[$j]->sm_id,
                                'mm_exam_id' => $exam_detail[0]->em_id,
                                'mark_obtained' => $_POST["mark_{$i}_{$student_list[$i - 1]->std_id}_{$exam_detail[0]->em_id}_{$subject_details[$j]->sm_id}"],
                                'mm_remarks' => $_POST["remark_{$i}_{$student_list[$i - 1]->std_id}_{$exam_detail[0]->em_id}"],
                                    ), $where);
                                
                        }
                        //udpate                        
                    } else {
                        //insert    
                        if ($student_id != '') {
                        $insert_id =     $this->Marks_manager_model->insert(array(
                                'mm_std_id' => $student_list[$i - 1]->std_id,
                                'mm_subject_id' => $subject_details[$j]->sm_id,
                                'mm_exam_id' => $exam_detail[0]->em_id,
                                'mark_obtained' => $_POST["mark_1_{$student_list[$i - 1]->std_id}_{$exam_detail[0]->em_id}_{$subject_details[$j]->sm_id}"],
                                'mm_remarks' => $_POST["remark_1_{$student_list[$i - 1]->std_id}_{$exam_detail[0]->em_id}"],
                            ));
                           
                        } else {
                        $insert_id =     $this->Marks_manager_model->insert(array(
                                'mm_std_id' => $student_list[$i - 1]->std_id,
                                'mm_subject_id' => $subject_details[$j]->sm_id,
                                'mm_exam_id' => $exam_detail[0]->em_id,
                                'mark_obtained' => $_POST["mark_{$i}_{$student_list[$i - 1]->std_id}_{$exam_detail[0]->em_id}_{$subject_details[$j]->sm_id}"],
                                'mm_remarks' => $_POST["remark_{$i}_{$student_list[$i - 1]->std_id}_{$exam_detail[0]->em_id}"],
                            ));
                        
                        }

                $admission_plan = $admission_plan_id;
                $branch = $branch_id;
                $course = $course_id;      
                
                $this->db->where('branch_id', $branch);                  
                $this->db->where('course_id', $course);
                $this->db->where('admission_plan_id', $admission_plan);
                
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
                $this->db->where("notification_type", "marks_manager");
                $res = $this->db->get("notification_type")->row();
                if ($res != '') {
                    $notification_id = $res->notification_type_id;
                    $notify['notification_type_id'] = $notification_id;
                    $notify['student_ids'] = $student_ids;
                    $notify['branch_id'] = $branch;
                    $notify['course_id'] = $course;
                    $notify['admission_plan_id'] = $admission_plan;                                    
                    $notify['data_id'] = $insert_id;
                    $this->db->insert("notification", $notify);
                 
                }
                        //create_notification('marks_manager', $student_list[$i - 1]->std_degree, $student_list[$i - 1]->course_id, $student_list[$i - 1]->std_batch, $student_list[$i - 1]->semester_id, $insert_id, $student_list[$i - 1]->std_id);
                    }
                }
            }
            if ($student_id != '') {
                $this->flash_notification('Exam marks is successfully updated.');
                redirect(base_url('marks/index/' . $branch_id . '/' . $course_id . '/' . $admission_plan_id . '/' . $exam_id . '/' . $student_id));
            }
            $this->flash_notification('Exam marks is successfully updated.');
            redirect(base_url('marks/index/' . $branch_id . '/' . $course_id . '/' . $admission_plan_id  . '/' . $exam_id));

        }
        $this->data['branch_id'] = '';
        $this->data['course_id'] = '';
        $this->data['admission_plan_id'] = '';
        $this->data['exam_id'] = '';        
        $this->data['student_id'] = $student_id;
        $this->data['student_list'] = array();
        $this->data['subject_details'] = array();
        $this->data['exam_detail'] = array();
        if ($branch_id != '' && $course_id != '' && $admission_plan_id != '' && $exam_id != '') {
            //assign variable
            $this->data['branch_id'] = $branch_id;
            $this->data['course_id'] = $course_id;
            $this->data['admission_plan_id'] = $admission_plan_id;            
            $this->data['exam_id'] = $exam_id;

            //exam details
            $this->data['exam_detail'] = $this->Exam_manager_model->exam_detail($exam_id);

            //subject details
            $this->data['subject_details'] = $this->Exam_manager_model->exam_time_table_subject_list($exam_id);

            //student list
           //  $student_list = $this->Student_model->get_many_by
            $this->data['student_list'] = $this->Student_model->get_many_by(array(
                    'branch_id' => $branch_id,
                    'course_id' => $course_id,
                    'admission_plan_id' => $admission_plan_id                    
                ));
            
        }
        
        $this->__template('marks/index', $this->data);
    }

    /**
     * Create semester
     */
    function create() {
        if($_POST) {
            $this->Semester_model->insert(array(
                's_name'    => $_POST['s_name'],
                's_status'  => $_POST['semester_status']
            ));
            $this->flash_notification('Semester is successfully added.');
        }
        
        redirect(base_url('semester'));
    }

    /**
     * Update semester
     * @param string $id
     */
    function update($id) {
        if($_POST) {
            $this->Semester_model->update($id, array(
                's_name'    => $_POST['s_name'],
                's_status'  => $_POST['semester_status']
            ));
        }
        
        redirect(base_url('semester'));
    }

    /**
     * Delete semester
     * @param string $id
     */
    function delete($id) {
        if($id) {
            $this->Semester_model->delete($id);
            $this->flash_notification('Semester is successfully deleted.');
        }
        
        redirect(base_url('semester'));
    }

    /**
     * Check semester
     */
    function check_semester() {
        $data = $this->db->get_where('semester', array('s_name' => $this->input->post('semester')))->result();
        if (count($data) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
    
    /**
     * Semester from branch
     * @param string $branch
     */
    function semester_branch($branch) {
        $semester = $this->Semester_model->semester_branch($branch);
        
        echo json_encode($semester);
    }
    
    
    /**
     * Download exam marsheet report
     * @param string $exam_id
     */
    public function download_statement_marks($exam_id = '') {
        $this->load->model('exam/Exam_manager_model');
        $this->load->model('student/Student_model');
        $page_data['exam_details'] = $this->Exam_manager_model->get($exam_id);
        $student_details = $this->Student_model->get($this->session->userdata('std_id'));
        $page_data['student_detail'] = $student_details;
        $page_data['batch_detail'] = $this->Student_model->student_batch_course_detail($student_details->std_id);
        $page_data['student_marks'] = $this->Student_model->student_marks($student_details->std_id, $exam_id);
        $page_data['exam_listing'] = $this->Student_model->student_exam_list($student_details->course_id, $student_details->semester_id);
        //$page_data = array();
        $html = utf8_encode($this->load->view('marks/marks_statement', $page_data, true));
        //this the the PDF filename that user will get to download
        $pdfFilePath = "student marksheet.pdf";
        //load mPDF library
        $this->load->library('m_pdf');
        //load the view and saved it into $html variable
        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }


}

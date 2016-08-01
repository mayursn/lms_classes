<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Import_export extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->helper('import_export/import_export');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
        //error_reporting(0);
        
    }

    /**
     * Import data
     */
    function import($param1 = '') {
        $this->load->model('department/Degree_model');
        if ($_FILES) {
            $file_name = $_FILES['userfile']['tmp_name'];
            $this->load->library('import_export/CSVReader');
            $csv_result = $this->csvreader->parse_file($file_name);
            
            switch ($_POST['module']) {
                case 'degree':
                    //import degree CSV
                    foreach ($csv_result as $result) {
                        $where = array(
                            'd_name' => $result['Department']
                        );
                        $data = array(
                            'd_name' => $result['Department'],
                            'd_status' => 1
                        );
                        import_degree($data, $where);
                    }
                    break;

                case 'admission_type':
                    //import admission type
                    foreach ($csv_result as $result) {
                        $where = array(
                            'at_name' => $result['Admission Type']
                        );
                        $data = array(
                            'at_name' => $result['Admission Type'],
                            'at_status' => 1
                        );
                        import_admission_type($data, $where);
                    }
                    break;
                case 'batch':
                    //import batch
                    foreach ($csv_result as $result) {
                        $where = array(
                            'degree' => array(
                                'd_name' => $result['Department']
                            ),
                            'course' => array(
                                'c_name' => $result['Branch']
                            )
                        );
                        $data = array(
                            'b_name' => $result['Batch'],
                            'b_status' => 1
                        );
                        import_batch($data, $where);
                    }
                    break;
                case 'event_manager':
                    //import event manager
                    foreach ($csv_result as $result) {
                        $where = array(
                            'event_name' => $result['Event Name']
                        );
                        $event_date = date('Y-m-d',  strtotime($result['Event Date']));
                        if($result['Event End Date']!="")
                        {
                        $event_end_date = date('Y-m-d',  strtotime($result['Event End Date']));
                        }else{
                            $event_end_date = date('Y-m-d',  strtotime($result['Event Date']));
                        }
                        $data = array(
                            'event_name' => $result['Event Name'],
                            'event_location' => $result['Event Location'],
                            'event_desc' => $result['Event Description'],
                            'event_date' => $event_date,
                            'event_end_date' => $event_end_date,
                            'event_time' => $result['Event Time']
                        );
                        import_event_manager($data, $where);
                    }
                    break;
                case 'exam_manager':
                    //exam manager csv import
                    foreach ($csv_result as $result) {
                        $where = array(
                            'degree' => array(
                                'd_name' => $result['Department'],
                            ),
                            'course_name' => array(
                                'c_name' => $result['Branch']
                            ),
                            'batch' => array(
                                'b_name' => $result['Batch']
                            ),
                            'semester' => array(
                                's_name' => $result['Semester']
                            ),
                            'exam_type' => array(
                                'exam_type_name' => $result['Exam Type']
                            )
                        );
                        $data = array(
                            'em_name' => $result['Exam Name'],
                            'em_status' => 1,
                            'total_marks' => $result['Total Marks'],
                            'passing_mark' => $result['Passing Marks'],
                            'em_date' => date('Y-m-d',  strtotime($result['Start Date'])),
                            'em_end_time'=>date('Y-m-d',  strtotime($result['End Date']))
                        );
                        import_exam_manager($data, $where);
                    }
                    break;
                case 'fees_structure':
                    //fees structure csv import
                    foreach ($csv_result as $result) {                    
                        $where = array(
                            'semester' => array(
                                's_name' => $result['Semester']
                            ),
                            'course' => array(
                                'c_name' => $result['Branch']
                            ),
                            'degree' => array(
                                'd_name' => $result['Department']
                            ),
                            'batch' => array(
                                'b_name' => $result['Batch']
                            ),
                            'fees_structure' => array(
                                'title' => $result['Title']
                            )
                        );
                        $start_date = date('Y-m-d',strtotime($result['Start Date']));
                        
                        if($result['Due Date']!="")
                        {
                            $end_date = date('Y-m-d',strtotime($result['Due Date']));
                            $fee_expiry_date = date('Y-m-d',strtotime($result['Due Date']));
                        }
                        else{
                            $fee_expiry_date = date('Y-m-d',strtotime($result['Start Date']));
                            $end_date = date('Y-m-d',strtotime($result['Start Date']));
                        }
                        $data = array(
                            'title' => $result['Title'],
                            'total_fee' => $result['Fee'],
                            'fee_start_date' => $start_date,
                            'fee_end_date' => $end_date,
                            'fee_expiry_date'=>$fee_expiry_date,
                            'penalty' => $result['Penalty']
                        );                       
                        import_fees_structure($data, $where);
                    }
                    break;
                case 'subject':
                    //import subject csv
                    foreach ($csv_result as $result) {
                        $where = array(
                            'subject' => array(
                            'subject_name' => $result['Subject Name'],
                            'subject_code'  => $result['Subject Code']
                            )
                        );
                        $data = array(
                            'subject_name' => $result['Subject Name'],
                            'subject_code' => $result['Subject Code']
                        );
                       
                        import_subject($data, $where);
                    }
                    break;
                case 'exam_marks':
                    $this->load->model('Admin/Crud_model');
                    $exam_id = $_POST['exam_detail'];
                    $course_id = $_POST['course_detail'];
                    $semester_id = $_POST['sem_detail'];
                    $subjects = $this->Crud_model->exam_subjects($exam_id);

                    $exam_subject = array();
                    foreach ($subjects as $row) {
                        array_push($exam_subject, $row->subject_name);
                    }
                    foreach ($csv_result as $result) {
                        $where = array(
                            'marks' => array(
                                'mm_exam_id' => $exam_id,
                                'mm_std_id' => $result['Student ID']
                            ),
                            'subject' => $exam_subject
                        );
                        $data = $result;

                        import_exam_marks($data, $where);
                    }
                    //exit;
                    break;
                case 'student':
                    //import student
                    foreach ($csv_result as $result) {
                        $where = array(
                            'student_roll_no' => array(
                                'std_roll' => $result['Roll No']
                            ),
                            'std_email' => array(
                                'email' => $result['Email']
                            ),
                            'class'=>array(
                                "class_name"=>$result['Class']
                                ),
                            'semester' => array(
                                's_name' => $result['Semester']
                            ),
                            'course' => array(
                                'c_name' => $result['Branch']
                            ),
                            'batch' => array(
                                'b_name' => $result['Batch']
                            ),
                            'degree' => array(
                                'd_name' => $result['Department']
                            ),
                            'admission_type' => array(
                                'at_name' => $result['Admission Type']
                            )
                        );
                        $data = array(
                            'email' => $result['Email'],
                            'std_roll' => $result['Roll No'],
                            'std_first_name' => $result['First Name'],
                            'std_last_name' => $result['Last Name'],
                            'std_gender' => $result['Gender'],
                            'address' => $result['Address'],
                            'country' => $result['Country'],
                            'state' => $result['State'],
                            'city' => $result['City'],
                            'zip' => $result['Zip'],
                            'std_birthdate' => $result['Birth Date'],
                            'std_marital' => $result['Merital'],
                            'std_about' => $result['About'],
                            'std_mobile' => $result['Mobile'],
                            'password' =>Modules::run('user/__hash', '12345'),
                        );
                        import_student($data, $where);
                    }
                    break;
                case 'course':
                    //import course csv
                    foreach ($csv_result as $result) {
                        $where = array(
                            'course' => array(
                                'c_name' => $result['Branch']
                            ),
                            'degree' => array(
                                'd_name' => $result['Department']
                            )
                        );
                        $data = array(
                            'c_name' => $result['Branch'],
                            'c_description' => $result['Description'],
                            'course_alias_id' => $result['Branch Code']
                        );
                        import_course($data, $where);
                    }
                    break;
                case 'exam_time_table':
                    foreach ($csv_result as $result) {
                    $this->db->where("subject_name",$result['Subject Name']);
                    $sm_id = $this->db->get('subject_manager')->row()->sm_id;      
                    
                        $where = array(
                            'subject_association' => array(
                                'sm_id' => $sm_id,
                                'course_id' => $_POST['course_detail'],
                                'sem_id' => $_POST['sem_detail']
                            ),
                            'time_table' => array(
                                'exam_id' => $_POST['exam_detail']
                            )
                        );                        
                        $data = array(
                            'exam_date' => $result['Exam Date'],
                            'exam_start_time' => date('h:i A',  strtotime($result['Start Time'])),
                            'exam_end_time' => date('h:i A',  strtotime($result['End Time'])),
                            'degree_id' => $_POST['degree'],
                            'course_id' => $_POST['course_detail'],
                            'batch_id' => $_POST['batch'],
                            'semester_id' => $_POST['sem_detail']
                        );                       
                        exam_time_table_import($data, $where);
                    }
                    break;
            }
            $this->session->set_flashdata('flash_message', 'Data is successfully imported.');
            redirect(base_url('import_export/import'));
        }
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $this->data['title'] = 'Import';
        $this->data['page'] = 'import';
        $this->__template('import_export/import', $this->data);
    }

    /**
     * Download import sheet
     * @param string $param1
     */
    function download_import($param1 = '') {
        $this->load->helper('download');
        $sheet_name = '';

        switch ($param1) {
            case 'exam_manager':
                //exam manager
                $this->import_demo_sheet_download_config('Exam Manager');
                //import_export_helper function
                exam_manager();
                break;
            case 'course':
                $this->import_demo_sheet_download_config('Branch');
                //import_export_helper function
                course();
                break;
            case 'degree':
                $this->import_demo_sheet_download_config('Department');
                degree();
                break;
            case 'admission_type':
                $this->import_demo_sheet_download_config('Admission Type');
                admission_type();
                break;
            case 'batch':
                $this->import_demo_sheet_download_config('Batch');
                batch();
                break;
            case 'event_manager':
                $this->import_demo_sheet_download_config('Event Manager');
                event_manager();
                break;
            case 'exam_manager':
                $this->import_demo_sheet_download_config('Exam Manager');
                exam_manager();
                break;
            case 'fees_structure':
                $this->import_demo_sheet_download_config('Fee Structure');
                fees_structure();
                break;
            case 'subject':
                $this->import_demo_sheet_download_config('Subject');
                subject();
                break;
            case 'exam_marks':
                $this->import_demo_sheet_download_config('Exam Marks');
                exam_marks();
                break;
            case 'student':
                $this->import_demo_sheet_download_config('Student');
                student_import_sample();
                break;
            case 'exam_time_table':
                $this->import_demo_sheet_download_config('Exam Time Table');
                exam_time_table();
                break;
            default:
            //default sheet
        }
    }

    /**
     * Import demo sheet download configuration
     * @param string $sheet_name
     */
    function import_demo_sheet_download_config($sheet_name) {
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename={$sheet_name}" . ".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    /**
     * Exoprt
     */
    function export() {
        $this->load->model('department/Degree_model');
        $this->load->model('branch/Course_model');
        $this->load->model('semester/Semester_model');

        $this->data['title'] = 'Export';
        $this->data['page'] = 'export';
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['semester'] = $this->Semester_model->get_all();
        $this->__template('import_export/export', $this->data);
    }

    /**
     * Export csv from data
     * @param string $name
     */
    function export_csv($name = '', $type = '') {
        $this->load->model('import_export/Export_model');
        switch ($name) {
            case 'exam_manager':
                //download exam manager csv
//                $result = $this->Export_model->exam_manager();
//                echo "<pre>";
//                print_r($result->result());
//                die;
               
                //csv_from_result($result, 'Exam Manager'); //@param $result object, string filename
                $this->load->helper('import_export');
                $this->import_demo_sheet_download_config('Exam Manager');
                exam_export_data();
                break;
            case 'event_manager':
                //download event manager csv
                $result = $this->Export_model->event_manager();
                csv_from_result($result, 'Event Manager');
                break;
            case 'course':
                //download course csv
                $result = $this->Export_model->course();
                csv_from_result($result, 'Branch');
                break;
            case 'degree':
                //download degree csv
                $result = $this->Export_model->degree();
                csv_from_result($result, 'Department');
                break;
            case 'semester':
                //download semester csv
                $result = $this->Export_model->semester();
                csv_from_result($result, 'Semester');
                break;
            case 'student':
                //download student csv
                $result = $this->Export_model->student();
                csv_from_result($result, 'Student');
                break;
            case 'system_setting':
                //download system setting csv
                $result = $this->Export_model->system_setting();
                csv_from_result($result, 'System Settings');
                break;
            case 'project_manager':
                //download project manager csv
                $result = $this->Export_model->project_manager();
                csv_from_result($result, 'Project Manager');
                break;
            case 'admission_type':
                //download admission type
                $result = $this->Export_model->admission_type();
                csv_from_result($result, 'Admission Type');
                break;
            case 'batch':
                //download batch csv
                //$result = $this->Export_model->batch();
                $this->load->helper('import_export');
                $this->import_demo_sheet_download_config('Batch');
                batch_export($type);
                //csv_from_result($result, 'Batch');
                break;
            case 'fees_structure':
                //download batch csv
                $result = $this->Export_model->fees_structure();
                csv_from_result($result, 'Fees Structure');
                break;
            case 'subject':
                //download subject csv
                $result = $this->Export_model->subject_export();
                csv_from_result($result, 'Subject Association');
                break;
            case 'subject_list':
                 $result = $this->Export_model->subject_list_export();
                csv_from_result($result, 'Subject List');
                break;
                break;
            case 'exam_marks':
                $this->load->helper('import_export');
                $this->import_demo_sheet_download_config('Exam Marks');
                exam_marks($type);
                break;
            default:
                redirect(base_url('admin/export'));
        }
    }
    
    /**
     * Get exam list by course name and semester
     * @param type $course_id
     * @param type $semester_id
     * 
     */
    function get_exam_list($degree_id = '', $course_id = '', $batch_id = '', $semester_id = '', $time_table = '') {
        $this->load->model('admin/Crud_model');
        $exam_detail = $this->Crud_model->get_exam_list($degree_id, $course_id, $batch_id, $semester_id);
        echo "<option value=''>Select</option>";
        foreach ($exam_detail as $row) {
            ?>
            <option value="<?php echo $row->em_id ?>"
            <?php if ($row->em_id == $time_table) echo 'selected'; ?>><?php echo $row->em_name . '  (Marks' . $row->total_marks . ')'; ?></option>
            <!--echo "<option value={$row->em_id}>{$row->em_name}  (Marks{$row->total_marks})</option>";-->
            <?php
        }
    }

    

    
    /**
     * All exam lists
     * @param string $course_id
     * @param string $semester_id
     * @param string $time_table
     */
    function all_exam_list($course_id = '', $semester_id = '', $time_table = '') {
        $this->load->model('admin/Crud_model');
        $exam_detail = $this->Crud_model->all_exam_list($course_id, $semester_id);
        echo "<option value=''>Select</option>";
        foreach ($exam_detail as $row) {
            ?>
            <option value="<?php echo $row->em_id ?>"
            <?php if ($row->em_id == $time_table) echo 'selected'; ?>><?php echo $row->em_name . '  (Marks' . $row->total_marks . ') - ' . ucfirst($row->exam_ref_name); ?></option>
            <!--echo "<option value={$row->em_id}>{$row->em_name}  (Marks{$row->total_marks})</option>";-->
            <?php
        }
    }

}

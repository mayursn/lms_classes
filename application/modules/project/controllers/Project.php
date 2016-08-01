<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('project/Project_manager_model');
        $this->load->model('project/Project_document_submission_model');
        $this->load->model('department/Degree_model');
        $this->load->model('branch/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $this->load->model('classes/Class_model');
        $this->load->model('student/Student_model');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
    }

    function index() {
        if($this->session->userdata('std_id'))
        {
            redirect(base_url().'project/submission');
        }
        $this->data['title'] = 'Project';
        $this->data['page'] = 'project';
        $this->data['project'] = $this->Project_manager_model->order_by_column('pm_dos');
        $this->data['submitedproject'] = $this->Project_document_submission_model->get_all_submitted_project();
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');;
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');

        $this->data['student'] = $this->db->select('std_id, std_first_name, std_last_name')->from('student')->get()->result();

        $this->__template('project/index', $this->data);
    }

    function create() {
        if ($_POST) {
           
            $checkstd = $this->input->post('student');
            if (empty($checkstd)) {
                $this->session->set_flashdata('flash_message', "Student not found, data not added!");
                redirect(base_url() . 'project/', 'refresh');
            }
            if ($_FILES['projectfile']['name'] != "") {
                $allowed_type = "gif|jpg|png|doc|docx|pdf|zip|rar";
                $all_type = explode("|", $allowed_type);
                $n_number_of_file = sizeof($_FILES['projectfile']['name']);
                for ($j = 0; $j < count($_FILES['projectfile']['name']); $j++) {
                    $p_file_ext = explode(".", $_FILES['projectfile']['name'][$j]);
                    $p_ext_file = strtolower(end($p_file_ext));
                    if (!in_array($p_ext_file, $all_type)) {
                        $this->session->set_flashdata('flash_message', "Invalid File!");
                        redirect(base_url() . 'project');
                    }
                }


                // retrieve the number of images uploaded;
                $number_of_files = sizeof($_FILES['projectfile']['tmp_name']);
                // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
                $files = $_FILES['projectfile'];
                $errors = array();

                // first make sure that there is no error in uploading the files
                for ($i = 0; $i < $number_of_files; $i++) {
                    if ($_FILES['projectfile']['error'][$i] != 0)
                        $errors[$i][] = 'Couldn\'t upload file ' . $_FILES['projectfile']['name'][$i];
                }
                if (sizeof($errors) == 0) {
                    // now, taking into account that there can be more than one file, for each file we will have to do the upload
                    // we first load the upload library
                    $this->load->library('upload');
                    if (!is_dir(FCPATH . 'uploads/photogallery')) {
                        $path = FCPATH . 'uploads/photogallery';
                        mkdir($path, 0777);
                    }
                    // next we pass the upload path for the images
                    $config['upload_path'] = FCPATH . 'uploads/project_file';
                    // also, we make sure we allow only certain type of images
                    $config['allowed_types'] = 'gif|jpg|png|doc|docx|pdf|zip|rar';
                    for ($i = 0; $i < $number_of_files; $i++) {
                        $_FILES['projectfile']['name'] = $files['name'][$i];
                        $_FILES['projectfile']['type'] = $files['type'][$i];
                        $_FILES['projectfile']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['projectfile']['error'] = $files['error'][$i];
                        $_FILES['projectfile']['size'] = $files['size'][$i];

                        $file_ext = explode(".", $_FILES['projectfile']['name']);
                        $ext_file = strtolower(end($file_ext));
                        $config['file_name'] = $i . date('dmYhis') . '.' . $ext_file;

                        //now we initialize the upload library
                        $this->upload->initialize($config);
                        // we retrieve the number of files that were uploaded
                        if ($this->upload->do_upload('projectfile')) {
                            $sdata['uploads'][$i] = $this->upload->data();
                        } else {
                            $sdata['upload_errors'][$i] = $this->upload->display_errors();
                        }
                    }
                } else {

                    $this->session->set_flashdata('flash_message', 'invalid file');
                    redirect(base_url() . 'project');
                }

                $upload_files = $sdata['uploads'];
                for ($u = 0; $u < count($upload_files); $u++) {
                    $uploaded_file[] = $upload_files[$u]['file_name'];
                }

                if (!empty($uploaded_file)) {
                    $data['pm_filename'] = implode(",", $uploaded_file);
                } else {
                    $data['pm_filename'] = '';
                }
            } else {
                
            }
            $data['pm_degree'] = $this->input->post('degree');
            $data['pm_title'] = $this->input->post('title');
            $data['pm_batch'] = $this->input->post('batch');
            // $data['pm_url'] = $file_url;
            $data['pm_semester'] = $this->input->post('semester');
            $data['class_id'] = $this->input->post('class');
            $data['pm_desc'] = $this->input->post('description');
            $data['pm_dos'] = $this->input->post('dateofsubmission');
            $data['pm_status'] = $this->input->post('status');
            // $data['pm_student_id'] = $this->input->post('student');
            $stud = implode(',', $this->input->post('student'));
            $data['pm_student_id'] = $stud;
            $data['pm_course'] = $this->input->post('course');
            $data['created_date'] = date('Y-m-d');
            $last_id = $this->Project_manager_model->insert($data);
            $this->db->where("notification_type", "project_manager");
            $res = $this->db->get("notification_type")->result();
            if ($res != '') {
                $notification_id = $res[0]->notification_type_id;
                $notify['notification_type_id'] = $notification_id;
                $notify['student_ids'] = $data['pm_student_id'];
                $notify['degree_id'] = $data['pm_degree'];
                $notify['course_id'] = $data['pm_course'];
                $notify['batch_id'] = $data['pm_batch'];
                $notify['semester_id'] = $data['pm_semester'];
                $notify['data_id'] = $last_id;
                $this->db->insert("notification", $notify);
            }
            $this->session->set_flashdata('flash_message', 'Project is successfully added');
            redirect(base_url() . 'project/', 'refresh');
        }

        redirect(base_url('project'));
    }

    function delete($id) {
        $this->Project_manager_model->delete($id);
        $this->session->set_flashdata('flash_message', 'Project is successfully deleted.');

        redirect(base_url('project'));
    }

    function update($id = '') {
        $data = array();
        if ($_POST) {
            $checkstd = $this->input->post('student');
            if (empty($checkstd)) {
                $this->session->set_flashdata('flash_message', "Student not found, data not added!");
                redirect(base_url() . 'project/', 'refresh');
            }
            $this->db->select('pm_filename');
            $res_file = $this->db->get_where('project_manager', array("pm_id" => $id))->row();
            if ($_FILES['projectfile']['name'] != "") {
                if (!empty($_FILES['projectfile']['name'][0])) {
                    $allowed_type = "gif|jpg|png|doc|docx|pdf|zip|rar";
                    $all_type = explode("|", $allowed_type);
                    $n_number_of_file = sizeof($_FILES['projectfile']['name']);
                    for ($j = 0; $j < count($_FILES['projectfile']['name']); $j++) {
                        $p_file_ext = explode(".", $_FILES['projectfile']['name'][$j]);
                        $p_ext_file = strtolower(end($p_file_ext));
                        if (!in_array($p_ext_file, $all_type)) {
                            $this->session->set_flashdata('flash_message', "Invalid File!");
                            redirect(base_url() . 'project');
                        }
                    }


                    // retrieve the number of images uploaded;
                    $number_of_files = sizeof($_FILES['projectfile']['tmp_name']);
                    // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
                    $files = $_FILES['projectfile'];
                    $errors = array();

                    // first make sure that there is no error in uploading the files
                    for ($i = 0; $i < $number_of_files; $i++) {
                        if ($_FILES['projectfile']['error'][$i] != 0)
                            $errors[$i][] = 'Couldn\'t upload file ' . $_FILES['projectfile']['name'][$i];
                    }
                    if (sizeof($errors) == 0) {
                        // now, taking into account that there can be more than one file, for each file we will have to do the upload
                        // we first load the upload library
                        $this->load->library('upload');
                        if (!is_dir(FCPATH . 'uploads/project_file')) {
                            $path = FCPATH . 'uploads/project_file';
                            mkdir($path, 0777);
                        }
                        // next we pass the upload path for the images
                        $config['upload_path'] = FCPATH . 'uploads/project_file';
                        // also, we make sure we allow only certain type of images
                        $config['allowed_types'] = 'gif|jpg|png|doc|docx|pdf|zip|rar';
                        for ($i = 0; $i < $number_of_files; $i++) {
                            $_FILES['projectfile']['name'] = $files['name'][$i];
                            $_FILES['projectfile']['type'] = $files['type'][$i];
                            $_FILES['projectfile']['tmp_name'] = $files['tmp_name'][$i];
                            $_FILES['projectfile']['error'] = $files['error'][$i];
                            $_FILES['projectfile']['size'] = $files['size'][$i];

                            $file_ext = explode(".", $_FILES['projectfile']['name']);
                            $ext_file = strtolower(end($file_ext));
                            $config['file_name'] = $i . date('dmYhis') . '.' . $ext_file;

                            //now we initialize the upload library
                            $this->upload->initialize($config);
                            // we retrieve the number of files that were uploaded
                            if ($this->upload->do_upload('projectfile')) {
                                $sdata['uploads'][$i] = $this->upload->data();
                            } else {
                                $sdata['upload_errors'][$i] = $this->upload->display_errors();
                            }
                        }
                    } else {
                        $error = $this->lang_message('invalid_image');
                        $this->session->set_flashdata('flash_message', $error);
                        redirect(base_url() . 'project');
                    }

                    $upload_files = $sdata['uploads'];
                    for ($u = 0; $u < count($upload_files); $u++) {
                        $uploaded_file[] = $upload_files[$u]['file_name'];
                    }

                    if (!empty($uploaded_file)) {
                        $new_gallery = implode(",", $uploaded_file);
                    }
                    $old_gal = $res_file->pm_filename;

                    if (!empty($old_gal)) {
                        $data['pm_filename'] = $new_gallery . ',' . $old_gal;
                    } else {
                        $data['pm_filename'] = $new_gallery;
                    }
                } else {
                    $data['pm_filename'] = $res_file->pm_filename;
                }
            } else {
                
            }

            $data['pm_degree'] = $this->input->post('degree');
            $data['pm_title'] = $this->input->post('title');
            $data['pm_batch'] = $this->input->post('batch');
            $data['pm_semester'] = $this->input->post('semester');
            $data['class_id'] = $this->input->post('class2');
            $data['pm_desc'] = $this->input->post('description');
            $data['pm_dos'] = $this->input->post('dateofsubmission1');
            $data['pm_status'] = $this->input->post('status');
            $stud = implode(',', $this->input->post('student'));
            $data['pm_student_id'] = $stud;
            $data['pm_course'] = $this->input->post('course');

            $this->Project_manager_model->update($id, $data);
            $this->session->set_flashdata('flash_message', "Project is successfully updated.");
            redirect(base_url() . 'project/', 'refresh');
        }

        redirect(base_url('project'));
    }

    /**
     * Project list
     * @param String $param
     */
    function getprojects($param = '') {
        $this->data['degree'] = $this->Degree_model->order_by_column('d_name');
        $this->data['course'] = $this->Course_model->order_by_column('c_name');
        $this->data['batch'] = $this->Batch_model->order_by_column('b_name');
        $this->data['semester'] = $this->Semester_model->order_by_column('s_name');
        $this->data['class'] = $this->Class_model->order_by_column('class_name');


        if ($param == 'allproject') {
            $degree = $this->input->post('degree');
            $course = $this->input->post('course');
            $batch = $this->input->post('batch');
            $semester = $this->input->post("semester");
            $class = $this->input->post("divclass");
            $this->data['student'] = $this->db->select('std_id, name, email, std_first_name, std_last_name')->from('student')->get()->result();
            $get_by_many = array("pm_degree" => $degree,
                "pm_course" => $course,
                "pm_batch" => $batch,
                "pm_semester" => $semester,
                "class_id" => $class);
            $this->data['project'] = $this->Project_manager_model->get_many_by($get_by_many);

            $this->data['param'] = $param;

            $this->load->view("project/getprojects", $this->data);
        }
        if ($param == 'submitted') {
            $degree = $this->input->post('degree');
            $course = $this->input->post('course');
            $batch = $this->input->post('batch');
            $semester = $this->input->post("semester");
            $this->data['student'] = $this->db->select('std_id, email, name, std_first_name, std_last_name')->from('student')->get()->result();
            $this->data['submitedproject'] = $this->Project_document_submission_model->get_submitted_project($degree, $course, $batch, $semester);
            $this->data['param'] = $param;
            $this->load->view("project/getprojects", $this->data);
        }
    }

    /**
     * batch wise student
     * @param int $param
     */
    function batchwisestudentcheckbox($param = '') {
        $batch = $this->input->post("batch");
        $sem = $this->input->post("sem");
        $degree = $this->input->post("degree");
        $course = $this->input->post("course");
        $html = '';
        if ($param != '') {
            $edit_data = $this->Project_manager_model->get($param);
            $student = $edit_data->pm_student_id;
            $std = explode(",", $student);
        }

        if ($batch != "") {
            $this->db->select('std_id,std_first_name,std_last_name');
            $getmany = array(
                "std_batch" => $batch,
                'semester_id' => $sem,
                'std_status' => 1,
                'course_id' => $course,
                'std_degree' => $degree);
            $datastudent = $this->Student_model->get_many_by($getmany);
            //$this->db->get_where("student", )->result();            
            foreach ($datastudent as $rowstu) {
                if (isset($std)) {
                    if (in_array($rowstu->std_id, $std)) {
                        $html .='<div class="checkedstudent"><input type="checkbox" class="checkbox1" onclick="uncheck();" name="student[]" value="' . $rowstu->std_id . '" checked="">' . $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name . '</div>';
                    } else {
                        $html .='<div class="checkedstudent"><input type="checkbox" class="checkbox1" onclick="uncheck();" name="student[]" value="' . $rowstu->std_id . '">' . $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name . '</div>';
                    }
                } else {
                    $html .='<div class="checkedstudent"><input type="checkbox" class="checkbox1" onclick="uncheck();" name="student[]" value="' . $rowstu->std_id . '">' . $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name . '</div>';
                }
            }
        }
    }

    /* checkboxstudent 4-4-2016 Mayur Panchal */

    function checkboxstudent($param = '') {

        $batch = $this->input->post("batch");
        $sem = $this->input->post("sem");
        $degree = $this->input->post("degree");
        $course = $this->input->post("course");
        $class = $this->input->post("divclass");
        $get_by_many = array("std_batch" => $batch,
            'std_status' => 1,
            "semester_id" => $sem,
            'course_id' => $course,
            'std_degree' => $degree,
            'class_id' => $class);

        $datastudent = $this->Student_model->get_many_by($get_by_many);
        $html = '';
        if ($param != '') {
            $edit_data = $this->Project_manager_model->get($param);
            $student = $edit_data->pm_student_id;
            $std = explode(",", $student);
        }

        foreach ($datastudent as $rowstu) {
            //$rowstu->std_id . . $rowstu->name;
            if (isset($std)) {
                if (in_array($rowstu->std_id, $std)) {
                    $html .='<div class="checkedstudent"><input type="checkbox" class="checkbox1" onclick="uncheck();" name="student[]" value="' . $rowstu->std_id . '" checked="">' . $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name . '</div>';
                } else {
                    $html .='<div class="checkedstudent"><input type="checkbox" class="checkbox1" onclick="uncheck();" name="student[]" value="' . $rowstu->std_id . '">' . $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name . '</div>';
                }
            } else {
                $html .='<div class="checkedstudent"><input type="checkbox" class="checkbox1" onclick="uncheck();" name="student[]" value="' . $rowstu->std_id . '">' . $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name . '</div>';
            }
        }
        echo $html;
    }

    /**
     * Check duplicate entry
     * 
     */
    function checkprjects() {
        $degree = $this->input->post('degree');
        $course = $this->input->post('course');
        $batch = $this->input->post('batch');
        $semester = $this->input->post('semester');
        $title = $this->input->post('title');
        $get_by_many = array("pm_degree" => $degree,
            "pm_course" => $course,
            "pm_batch" => $batch,
            "pm_semester" => $semester,
            "pm_title" => $title);
        $res = $this->Project_manager_model->get_many_by($get_by_many);
        echo json_encode($res);
    }

    /**
     * check duplicate project
     * @param int $id
     */
    function checkprjectsedit($id = '') {
        $degree = $this->input->post('degree');
        $course = $this->input->post('course');
        $batch = $this->input->post('batch');
        $semester = $this->input->post('semester');
        $title = $this->input->post('title');

        $get_by_many = array('pm_degree' => $degree,
            'pm_course' => $course,
            'pm_title' => $title,
            'pm_batch' => $batch, 'pm_semester' => $semester, 'pm_id!=' => $id);
        $res = $this->Project_manager_model->get_many_by($get_by_many);
        echo json_encode($res);
    }

    function submission() {
        if(!$this->session->userdata('std_id'))
        {
            redirect(base_url().'project');
        }
        $this->load->model('student/Student_model');
        $std_id = $this->session->userdata('std_id');        
        $std = $this->Student_model->get($std_id);
        $degree = $std->std_degree;
        $batch = $std->std_batch;
        $sem = $std->semester_id;
        $course = $std->course_id;        
        $class = $std->class_id;        
        
        $this->data['project'] =  $this->Project_manager_model->get_student_project_list($degree,$batch,$sem,$course,$class,$std_id);
                //$this->data['project'] = 
        // $page_data['project'] = $this->db->get_where('project_manager', array("pm_student_id" => $this->session->userdata('std_id')))->result();           
        //$this->data['student'] = $this->db->get('student')->result();
        $this->data['page'] = 'project';
        $this->data['title'] = 'Projects';
        $this->data['param'] = "submission";
        clear_notification('project_manager', $this->session->userdata('std_id'));
        unset($this->session->userdata('notifications')['project_manager']);
        $this->__template('project/submission', $this->data);
    }
    
    function submit_project()
    {
        if($_POST)
        {
            if ($_FILES['document_file']['name'] != "") {
                    $allowed_type= "gif|jpg|png|doc|docx|pdf|zip|rar";
                    $all_type = explode("|",$allowed_type);
                    $n_number_of_file = sizeof($_FILES['document_file']['name']);
                    for($j=0;$j<count($_FILES['document_file']['name']);$j++)
                    {
                        $p_file_ext = explode(".", $_FILES['document_file']['name'][$j]);
                        $p_ext_file = strtolower(end($p_file_ext));
                        if(!in_array($p_ext_file, $all_type))
                        {
                            $this->flash_notification("Invalid File!");
                            redirect(base_url().'project/submission');
                        }
                        
                    }
                
                    
                // retrieve the number of images uploaded;
                $number_of_files = sizeof($_FILES['document_file']['tmp_name']);
                // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
                $files = $_FILES['document_file'];
                $errors = array();

                // first make sure that there is no error in uploading the files
                for ($i = 0; $i < $number_of_files; $i++) {
                    if ($_FILES['document_file']['error'][$i] != 0)
                        $errors[$i][] = 'Couldn\'t upload file ' . $_FILES['document_file']['name'][$i];
                }
                if (sizeof($errors) == 0) {
                    // now, taking into account that there can be more than one file, for each file we will have to do the upload
                    // we first load the upload library
                    $this->load->library('upload');
                    if (!is_dir(FCPATH . 'uploads/photogallery')) {
                        $path = FCPATH . 'uploads/photogallery';
                        mkdir($path, 0777);
                    }
                    // next we pass the upload path for the images
                    $config['upload_path'] = FCPATH . 'uploads/project_file';
                    // also, we make sure we allow only certain type of images
                    $config['allowed_types'] = 'gif|jpg|png|doc|docx|pdf|zip|rar';
                    for ($i = 0; $i < $number_of_files; $i++) {
                        $_FILES['document_file']['name'] = $files['name'][$i];
                        $_FILES['document_file']['type'] = $files['type'][$i];
                        $_FILES['document_file']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['document_file']['error'] = $files['error'][$i];
                        $_FILES['document_file']['size'] = $files['size'][$i];

                        $file_ext = explode(".", $_FILES['document_file']['name']);
                        $ext_file = strtolower(end($file_ext));
                        $config['file_name'] = $i . date('dmYhis') . '.' . $ext_file;

                        //now we initialize the upload library
                        $this->upload->initialize($config);
                        // we retrieve the number of files that were uploaded
                        if ($this->upload->do_upload('document_file')) {
                            $sdata['uploads'][$i] = $this->upload->data();
                        } else {
                            $sdata['upload_errors'][$i] = $this->upload->display_errors();
                        }
                    }
                } else {
                    $error = $this->lang_message('invalid_image');
                    $this->flash_notification($error);
                    redirect(base_url() . 'project/submission');
                }

                $upload_files = $sdata['uploads'];
                for ($u = 0; $u < count($upload_files); $u++) {
                    $uploaded_file[] = $upload_files[$u]['file_name'];
                }

                if (!empty($uploaded_file)) {
                    $data['document_file'] = implode(",", $uploaded_file);
                    
                } else {
                    $data['document_file'] = '';
                }

                } else {

                   
                }
                

                
            $data['description'] = $this->input->post('comment');
            $data['project_id'] = $this->input->post('project_id');
            $data['student_id'] = $this->session->userdata('std_id');
            $data['dos'] = date('Y-m-d');
            
            $this->Project_document_submission_model->insert( $data);
            $this->flash_notification('Project added successfully');
            redirect(base_url() . 'project/submission', 'refresh');
            
        }
    }

}

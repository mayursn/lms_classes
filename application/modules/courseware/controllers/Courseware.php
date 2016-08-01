<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Courseware extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('courseware/Courseware_model');
    }

    /**
     * Index action
     */
    function index() {
        $this->data['title'] = 'Courseware';
        $this->data['page'] = 'courseware';
        $this->data['courseware'] = $this->Courseware_model->get_courseware();
        $this->__template('courseware/index', $this->data);
    }

    /**
     * Create new branch
     */
    function create() {
        if ($_POST) {
            if ($_FILES['attachment']['name'] != "") {
                    $path = FCPATH . 'uploads/courseware';
                    if (!is_dir($path)) {
                        mkdir($path, 0777);
                    }
                    $config['upload_path'] = 'uploads/courseware';
                    $config['allowed_types'] = '*';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    //$this->upload->set_allowed_types('*');	

                    if (!$this->upload->do_upload('attachment')) {
                        $this->session->set_userdata('last_activity', "Courseware create operation failed Invalid File!.");
                        $this->session->set_userdata('activity_status', "0");
                        $this->flash_notification($this->upload->display_errors());
                        redirect(base_url() . 'courseware/', 'refresh');
                    } else {
                        $file = $this->upload->data();
                        $insert['attachment'] = $file['file_name'];
                    }
                } else {
                    $insert['attachment'] = '';
                }

                $insert['topic'] = $this->input->post('topic');
                $insert['description'] = $this->input->post('description');
                $insert['branch_id'] = $this->input->post('branch');
                $insert['subject_id'] = $this->input->post('subject');
                $insert['chapter'] = $this->input->post('chapter');
                $insert['status'] = $this->input->post('status');
                $insert['professor_id'] = $this->session->userdata('role_id');
                $insert['created_date'] = date('Y-m-d');

                $this->Courseware_model->insert($insert);
                $this->session->set_userdata('last_activity', "Courseware Chapter added " . $this->input->post('chapter'));
                $this->session->set_userdata('activity_status', "1");
                $this->flash_notification("Courseware added successfully");
               
        }

        redirect(base_url('courseware'));
    }

    /**
     * Delete branch
     * @param type $id
     */
    function delete($id) {
        if($id) {
            $this->Courseware_model->delete($id);
            $this->flash_notification('courseware is successfully deleted.');
        }        
        redirect(base_url('courseware'));
    }

    /**
     * Update branch information
     * @param string $id
     */
    function update($id) {
        if ($_POST) {
              if ($_FILES['attachment']['name'] != "") {
                    if ($this->input->post('oldfile') != "") {
                        error_reporting(0);
                        unlink("uploads/courseware/" . $this->input->post('oldfile'));
                    }
                    $path = FCPATH . 'uploads/courseware';
                    if (!is_dir($path)) {
                        mkdir($path, 0777);
                    }
                    $config['upload_path'] = 'uploads/courseware';
                    $config['allowed_types'] = '*';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    //$this->upload->set_allowed_types('*');	

                    if (!$this->upload->do_upload('attachment')) {
                        $this->session->set_userdata('last_activity', "Courseware Chapter update operation failed Invalid File!");
                        $this->session->set_userdata('activity_status', "0");
                        $this->session->set_flashdata('flash_message', $this->upload->display_errors());
                        redirect(base_url() . 'professor/courseware/', 'refresh');
                    } else {
                        $file = $this->upload->data();
                        $insert['attachment'] = $file['file_name'];
                    }
                }
                $insert['topic'] = $this->input->post('topic');
                $insert['description'] = $this->input->post('description');
                $insert['branch_id'] = $this->input->post('branch');
                $insert['subject_id'] = $this->input->post('subject');
                $insert['chapter'] = $this->input->post('chapter');
                $insert['status'] = $this->input->post('status');
                $insert['updated_date'] = date('Y-m-d');

                $this->Courseware_model->update($id,$insert);
                $this->session->set_userdata('last_activity', "Courseware Chapter updated " . $this->input->post('chapter'));
                $this->session->set_userdata('activity_status', "1");
                $this->flash_notification("Courseware Updated Successfully");                
        }

        redirect(base_url('courseware'));
    }

    /**
     * Check course if avail
     */
    function check_course() {
        $data = $this->db->get_where('course', array('c_name' => $this->input->post('course'),
                    'degree_id' => $this->input->post('degree')))->result();

        if (count($data) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
    
    /**
     * Department branch
     * @param type $id
     */
    function department_branch($id) {
        $branch = $this->Course_model->department_branch($id);
        
        echo json_encode($branch);
    }

      function getsubject() {
        $this->data['subject'] = $this->Courseware_model->getsubject($this->input->post('id'));
        echo json_encode($this->data['subject']);
    }
    
     function getcourseware($param1 = "") {
        if ($param1 == "edit") {
            $branch = $this->input->post('branch');
            $subject = $this->input->post('subject');
            $chapter = $this->input->post('chapter');
            $topic = $this->input->post('topic');
            $editid =  $this->input->post('editid');
           
            
             $data = $this->Courseware_model->get_courseware_array($branch,$subject,$chapter,$topic,$editid);
          
//            echo $this->db->last_query();
//            print_r($data);
//            exit;
            if (count($data) > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }else{
            $branch =  $this->input->post('branch');
            $subject =  $this->input->post('subject');
            $chapter =  $this->input->post('chapter');
            $topic =  $this->input->post('topic');
            
            
            $data = $this->Courseware_model->get_duplicate($branch,$subject,$chapter,$topic);

            if (count($data) > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }
    
    function getcoursewareedit()
    {
         $branch = $this->input->post('branch');
            $subject = $this->input->post('subject');
            $chapter = $this->input->post('chapter');
            $topic = $this->input->post('topic');
            $editid =  $this->input->post('editid');
           
            
             $data = $this->Courseware_model->get_courseware_array($branch,$subject,$chapter,$topic,$editid);
          
//            echo $this->db->last_query();
//            print_r($data);
//            exit;
            if (count($data) > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
    }

}

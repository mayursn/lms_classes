<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forumtopic extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('forumtopic/Forum_topics_model');
    }

    function index() {
        $this->data['title'] = 'Forum Topics';
        $this->data['page'] = 'forum_topic';
        $this->data['forum_topic'] = $this->Forum_topics_model->order_by_column('created_date');
        $this->__template('forumtopic/index', $this->data);
    }

    function create() {
        if ($_POST) {
            $data = array();
            if ($_FILES['topicfile']['name'] != "") {
                if (!is_dir(FCPATH . 'uploads/forum_file')) {
                    $path = FCPATH . 'uploads/forum_file';
                    mkdir($path, 0777);
                }

                $config['upload_path'] = 'uploads/forum_file';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|ppt|pptx|txt';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                //$this->upload->set_allowed_types('*');	

                if (!$this->upload->do_upload('topicfile')) {
                    $this->session->set_flashdata('flash_message', "Invalid File!");
                    redirect(base_url('admin/forumtopics/'));
                } else {
                    $file = $this->upload->data();

                    $data['topic_file'] = $file['file_name'];
                }
            }
            $data['forum_topic_title'] = $this->input->post('topic_title');
            $data['forum_topic_status'] = $this->input->post('topic_status');
            $data['forum_topic_desc'] = $this->input->post('description');
            $data['user_role'] = $this->session->userdata('role_name');
            $data['user_role_id'] = $this->session->userdata('user_id');
            $data['forum_id'] = $this->input->post('forum_id');

            $this->Forum_topics_model->insert($data);
            $this->flash_notification('Forum Topic is successfully added.');
        }

        redirect(base_url('forumtopic'));
    }

    function delete($id) {
        $this->Forum_topics_model->delete($id);
        $this->flash_notification('Forum topic is successfully deleted.');

        redirect(base_url('forumtopic'));
    }

    function update($id = '') {
        $data = array();
        if ($_POST) {
            if ($_FILES['topicfile']['name'] != "") {
             if (!is_dir(FCPATH . 'uploads/forum_file')) {
                        $path = FCPATH . 'uploads/forum_file';
                        mkdir($path, 0777);
                    }
            
             $config['upload_path'] = 'uploads/forum_file';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|ppt|pptx|txt';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    //$this->upload->set_allowed_types('*');	

                    if (!$this->upload->do_upload('topicfile')) {
                        $this->session->set_flashdata('flash_message', "Invalid File!");
                       redirect(base_url('admin/forumtopics/'));
                    } else {
                        $file = $this->upload->data();

                        $data['topic_file'] = $file['file_name'];
                       
                    }
             }
            $topic = $this->Forum_topics_model->get($id);
            $data['forum_topic_title'] = $this->input->post('topic_title');
            $data['forum_topic_status'] = $this->input->post('topic_status');
            $data['forum_id'] = $this->input->post('forum_id');
            $data['forum_topic_desc'] = $this->input->post('description');
            if ($topic->user_role == $this->session->userdata('role_name')) {
                $data['user_role'] = $this->session->userdata('role_name');
                $data['user_role_id'] = $this->session->userdata('user_id');
                
            }
            $this->Forum_topics_model->update($id, $data);
            $this->flash_notification('Forum Topic is successfully updated.');
        }

        redirect(base_url('forumtopic'));
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('comments/Forum_comment_model');
        $this->load->model('forumtopic/Forum_topics_model');
    }

    function index($id='') {
        $this->data['title'] = 'Forum Comments';
        $this->data['page'] = 'forum_comment';
        $get_by_many = array("forum_topic_id" =>$id);
        $this->data['forum_comment'] = $this->Forum_comment_model->get_many_by($get_by_many);
        $this->data['param'] = $id;
        // $this->data['forum_comment'] = $this->Forum_comment_model->order_('created_date');
        $this->__template('comments/index', $this->data);
    }
    
    function viewcomments($id='')
    {
        
        $this->data['title'] = 'Forum Comments';
        $this->data['page'] = 'forum_comment';
        $get_by_many = array("forum_topic_id" =>$id);
        $this->data['forum_comment'] = $this->Forum_comment_model->get_many_by($get_by_many);
        $this->data['param'] = $id;
        $this->__template('comments/index', $this->data);
    }

    function create($param2='') {
        
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
                      redirect(base_url('admin/forumcomment/'.$param2));
                    } else {
                        $file = $this->upload->data();

                        $data['topic_file'] = $file['file_name'];
                       
                    }
             }
            $data['forum_topic_id'] = $param2;
            $data['forum_comments'] = $this->input->post('comment');
            $data['forum_comment_status'] = '1';
            $data['user_role'] = $this->session->userdata('role_name');
            $data['user_role_id'] = $this->session->userdata('user_id');
           
            $this->Forum_comment_model->insert($data);
            $this->flash_notification('Forum comment is successfully added.');
            }

        redirect(base_url('comments/viewcomments/'.$param2));
    
    }

    function delete($id) {
      $comment =   $this->Forum_comment_model->get($id);
      $forum_topic =  $this->Forum_topics_model->get($comment->forum_topic_id);
        $this->Forum_comment_model->delete($id);
        $this->flash_notification('Forum comment is successfully deleted.');
        $param = $forum_topic->forum_topic_id;
        redirect(base_url('comments/viewcomments/'.$param));
    }

    function update($id = '') {
        if($_POST)
        {
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
                      redirect(base_url('comments/viewcomments/'.$id));
                    } else {
                        $file = $this->upload->data();

                        $data['topic_file'] = $file['file_name'];
                       
                    }
             }
            $data['forum_topic_id'] = $id;
            $comment_id = $this->input->post("comment_id");
            $data['forum_comments'] = $this->input->post('comment');
            $data['forum_comment_status'] = $this->input->post('comment_status');
            $data['user_role'] = $this->session->userdata('role_name');
            $data['user_role_id'] = $this->session->userdata('user_id');
        
            $this->Forum_comment_model->update($id, $data);
            $this->flash_notification('Forum Comment is successfully updated.');
        }

        redirect(base_url('comments/viewcomments/'.$id));
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_slider extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('media/Banner_slider_model');
         $this->load->model('media/Slide_setting_model');
        
    }

    function index() {
        $this->data['title'] = 'Banner Slider';
        $this->data['page'] = 'bannerslider';
        $this->data['banners'] = $this->Banner_slider_model->order_by_column('banner_id');
        $this->data['general'] = $this->Slide_setting_model->general_setting();
        $this->__template('media/bannerslider/index', $this->data);
    }

    function create() {
        if ($_POST) {
            if (is_uploaded_file($_FILES['main_img']['tmp_name'])) {
                $path = FCPATH . 'uploads/bannerimg/';
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }

                $allowed_types = 'gif|jpg|png|jpeg';
                $type = explode("|", $allowed_types);
                $ext = explode(".", $_FILES['main_img']['name']);
                $ext_file = strtolower(end($ext));
                $image1 = date('dmYhis') . 'main.' . $ext_file;

                if (in_array($ext_file, $type)) {
                    $upl_path = FCPATH . 'uploads/bannerimg/' . $image1;
                    move_uploaded_file($_FILES['main_img']['tmp_name'], $upl_path);
                    $main_img = $image1;
                } else {
                    $error = "Invalid main image";
                    $this->session->set_flashdata('flash_message', $error);
                    redirect(base_url() . 'media/banner_slider');
                }
            }


            $title = $this->input->post("title");
            $status = $this->input->post("status");
            $slide_option = $this->input->post("slide_option");
            $description = $this->input->post("description");
            $insert = array("banner_title" => $title,
                "banner_desc" => $description,
                "banner_status" => $status,
                "banner_img" => $main_img,
                "slide_option" => $slide_option);


            $this->Banner_slider_model->insert($insert);
            $this->flash_notification('flash_message', "Banner Slider Image Added Successfully");
            redirect(base_url() . 'media/banner_slider');
        }
    }

    function update($param2='') {
        if ($_POST) {
            $banner = $this->Banner_slider_model->get($param2);
            if (is_uploaded_file($_FILES['main_img']['tmp_name'])) {
                $path = FCPATH . 'uploads/bannerimg/';
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }

                $allowed_types = 'gif|jpg|png|jpeg';
                $type = explode("|", $allowed_types);
                $ext = explode(".", $_FILES['main_img']['name']);
                $ext_file = strtolower(end($ext));
                $image1 = date('dmYhis') . 'main.' . $ext_file;

                if (in_array($ext_file, $type)) {
                    $upl_path = FCPATH . 'uploads/bannerimg/' . $image1;
                    move_uploaded_file($_FILES['main_img']['tmp_name'], $upl_path);
                    $main_img = $image1;
                } else {
                    $error = $this->lang_message('invalid_main_image');
                    $this->session->set_flashdata('flash_message', $error);
                    redirect(base_url() . 'media/banner_slider');
                }
            } else {
                $main_img = $banner->banner_img;
            }


            $title = $this->input->post("title");
            $status = $this->input->post("status");
            $description = $this->input->post("description");
            $slide_option = $this->input->post("slide_option");

            $insert = array("banner_title" => $title,
                "banner_desc" => $description,
                "banner_status" => $status,
                "banner_img" => $main_img,
                "slide_option" => $slide_option);

            $this->Banner_slider_model->update($param2,$insert);

            $this->flash_notification('flash_message', "Banner Slider Image Updated Successfully");
            redirect(base_url() . 'media/banner_slider');
        }
    }
    
    function delete($id)
    {
        $this->Banner_slider_model->delete($id);
        $this->flash_notification("Banner Slider successfully deleted");
        redirect(base_url().'media/banner_slider');
    }
    
    function general()
    {
         if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
                $pause_time = $this->input->post("pause_time");
                $pause_on_hover = $this->input->post("pause_on_hover");
                $caption_opacity = $this->input->post("caption_opacity");
                $anim_speed = $this->input->post("anim_speed");
                $update_general = array("pause_time" => $pause_time,
                    "pause_on_hover" => $pause_on_hover,
                    "caption_opacity" => $caption_opacity,
                    "anim_speed" => $anim_speed);

                $this->Slide_setting_model->update("1",$update_general);

               
                $this->flash_notification('flash_message', "Slider General Setting Updated Successfully");
                redirect(base_url() . 'media/banner_slider');
            }
    }

}

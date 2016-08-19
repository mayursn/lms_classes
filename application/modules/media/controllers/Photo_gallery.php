<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_gallery extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('media/Photo_gallery_model');
        $this->load->model('media/Gallery_folder_model');
        
    }

    function index() {
        $this->data['title'] = 'Photo Gallery';
        $this->data['page'] = 'photogallery';
        $this->data['folder'] = $this->Gallery_folder_model->get_all_folder();
        $this->__template('media/photogallery/index', $this->data);
    }

    function folder_create($id='')
    {
        if($_POST)
        {
            $insert_data['folder_name']  = $this->input->post('folder_name');
            $insert_data['folder_parent_id'] = $this->input->post('parent_id');
            $parent_id = $this->input->post('parent_id');
            $insert_data['folder_status'] = $this->input->post('status');
            $this->Gallery_folder_model->insert($insert_data);            
            $this->flash_notification("flash_message","Folder Successfully Created");
            if($parent_id!="")
            {
            redirect(base_url().'media/photo_gallery/gallery_view/'.$parent_id);
            }else{
                redirect(base_url().'media/photo_gallery/');
            }
        }
    }
    
    function gallery_view($id='')
    {
       $this->data['child_folder']= $this->Gallery_folder_model->get_child_folderlist($id);       
        $this->data['title'] = 'Folder ';
        $this->data['page'] = 'folder';
        $this->data['add_title'] ="Add Folder";
        $this->data['edit_title'] = "Update Folder";
        $this->data['folder'] = $this->Gallery_folder_model->get_all_folder();
        
        $this->data['folder_photo'] = $this->Photo_gallery_model->get_all_folder_photo($id);
        
        $this->data['folder_id']  = $id;
        $this->__template('media/photogallery/folderview', $this->data);
    }
    
    function addphoto($id='')
    {
        
             if ($this->input->post()) {
                // retrieve the number of images uploaded;
                $number_of_files = sizeof($_FILES['galleryimg']['tmp_name']);
                // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
                $files = $_FILES['galleryimg'];
                $errors = array();

                // first make sure that there is no error in uploading the files
                for ($i = 0; $i < $number_of_files; $i++) {
                    if ($_FILES['galleryimg']['error'][$i] != 0)
                        $errors[$i][] = 'Couldn\'t upload file ' . $_FILES['galleryimg']['name'][$i];
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
                    $config['upload_path'] = FCPATH . 'uploads/photogallery';
                    // also, we make sure we allow only certain type of images
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    for ($i = 0; $i < $number_of_files; $i++) {
                        $_FILES['galleryimg']['name'] = $files['name'][$i];
                        $_FILES['galleryimg']['type'] = $files['type'][$i];
                        $_FILES['galleryimg']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['galleryimg']['error'] = $files['error'][$i];
                        $_FILES['galleryimg']['size'] = $files['size'][$i];

                        $file_ext = explode(".", $_FILES['galleryimg']['name']);
                        $ext_file = strtolower(end($file_ext));
                        $config['file_name'] = $i . date('dmYhis') . '.' . $ext_file;

                        //now we initialize the upload library
                        $this->upload->initialize($config);
                        // we retrieve the number of files that were uploaded
                        if ($this->upload->do_upload('galleryimg')) {
                            $data['uploads'][$i] = $this->upload->data();
                        } else {
                            $data['upload_errors'][$i] = $this->upload->display_errors();
                        }
                    }
                } else {
                    $error = $this->lang_message('invalid_image');
                    $this->session->set_flashdata('flash_message', $error);
                  redirect(base_url() . 'media/photo_gallery/gallery_view/'.$id);
                }

                $upload_files = $data['uploads'];
                for ($u = 0; $u < count($upload_files); $u++) {
                    $uploaded_file[] = $upload_files[$u]['file_name'];
                }

                if (!empty($uploaded_file)) {
                    $gallery = implode(",", $uploaded_file);
                } else {
                    $gallery = '';
                }

                $status = $this->input->post("status");
               
                $gallery_img = $gallery;
                $insert = array( "gallery_img" => $gallery_img,
                                "gal_status" => $status,
                    "folder_id"=>$id);
                $this->Photo_gallery_model->insert($insert);

                
                $this->flash_notification('flash_message', 'Photos is added successfully');
                redirect(base_url() . 'media/photo_gallery/gallery_view/'.$id);
            }
    }
    
    function removefolder($id ='')
    {
        if(!empty($id))
        {
            $this->Gallery_folder_model->remove_folder_info($id);
        }
    }
    
    function renamefolder($id = '')
    {
        $name = $this->input->post('folder_name');
        if(!empty($name))
        {
        $data = array("folder_name"=>$name);
        $this->db->update("gallery_folder",$data,array("folder_id"=>$id));
        $this->Gallery_folder_model->update($id,$data);
        echo $name;
        }
    }
    
    /**
     * Remove image
     */
    function removeimg() {

        $item = $_POST['image'];
        $id = $_POST['id'];
        $get_gallery = $this->Photo_gallery_model->getgallery($id);
        $str = $get_gallery[0]->gallery_img;

        $parts = explode(',', $str);

        while (($i = array_search($item, $parts)) !== false) {
            unset($parts[$i]);
        }

        $new_img = implode(',', $parts);
        $data = array("gallery_img" => $new_img);
        $this->Photo_gallery_model->update($id,$data);
        echo $item;
    }
}

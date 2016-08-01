<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_gallery_model extends MY_Model {

    protected $primary_key = 'gallery_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set the timestamp
     * @param array $gallery
     * @return array
     */
    protected function timestamps($gallery) {
	if(check_role_approval())
        {
            $gallery['gal_status'] = 0;
        }
        $gallery['created_date'] = date('Y-m-d H:i:s');

        return $gallery;
    }	
    protected function update_timestamps($gallery)
    {
        if(check_role_approval())
        {
            $gallery['gal_status'] = 0;
        }
        
        $gallery['updated_date'] = date('Y-m-d H:i:s');
        return $gallery;
    }
    function get_all_folder_photo($id) {
        return $this->db->get_where("photo_gallery", array("folder_id" => $id))->result();
    }

    function get_folder_name($folder_id, $field = 'folder_name') {
        return $this->db->get_where('gallery_folder', array("folder_id" => $folder_id))->row()->$field;
    }

    public function getgallery($id) {
        return $this->db->get_where("photo_gallery", array("gallery_id" => $id))->result();
    }

}

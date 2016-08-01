<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_folder_model extends MY_Model {

    protected $primary_key = 'folder_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set the timestamp
     * @param array $folder
     * @return array
     */
    protected function timestamps($folder) {
	if(check_role_approval())
        {
            $folder['folder_status'] = 0;
        }
        $folder['created_at'] = date('Y-m-d H:i:s');
        return $folder;
    }
    
     protected function update_timestamps($folder)
    {
        if(check_role_approval())
        {
            $folder['folder_status'] = 0;
        }
        
        $folder['updated_date'] = date('Y-m-d H:i:s');
        return $folder;
    }

    public function get_all_folder_view()
    {
        return $this->db->get('gallery_folder')->result();
    }
    function get_child_folderlist($id)
    {
        return $this->db->get_where("gallery_folder",array("folder_parent_id"=>$id))->result();
    }

    function get_all_folder()
    {
        $this->db->where("folder_parent_id","0");
        return $this->db->get("gallery_folder")->result();
    }
    
    /**
     * Remove all data related to folder
     * @param int $id
     */
    function remove_folder_info($id)
    {
        $this->db->where("folder_parent_id",$id);        
        $res = $this->db->get("gallery_folder")->result();
        if(!empty($res))
        {
            foreach($res as $row)
            {
                $folder_id = $row->folder_id;
                $folder_id;
                $this->db->where("folder_id",$folder_id);
                $gallery = $this->db->get("photo_gallery")->result();
                echo "<pre>";
                print_r($gallery);
                foreach($gallery as $rows)
                {
                    $this->db->delete("photo_gallery",array("folder_id"=>$folder_id));
                }
                
                 $this->db->delete("gallery_folder",array("folder_id"=>$folder_id));
            }

        }
         $this->db->delete("gallery_folder",array("folder_id"=>$id));
    }
}

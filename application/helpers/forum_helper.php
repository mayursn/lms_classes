<?php
/*
 * Forum Helper 
 * @return mixed data
 * this helper create for get forum user role data
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('roleuserdatatopic')) {

    function roleuserdatatopic($role,$role_id) {
        $CI = & get_instance();
        $CI->load->database();
                
        $CI->db->where('user_id', $role_id);
        $res = $CI->db->get('user')->row();
        if(@$res->first_name!=""){     
            return @$res->first_name.'   '.$res->last_name;
        }        
    }

}

/*
 * 
 * 
 */

if (!function_exists('roleuserdatacomment')) {

    /**
     * 
     * @param String $role
     * @param int $role_id
     * @return mixed
     */
    function roleuserdatacomment($role,$role_id) {
        $CI = & get_instance();
        $CI->load->database();         
        $CI->db->where('user_id', $role_id);
        return $res = $CI->db->get('user')->row();
    
    }

}


if (!function_exists('roleimgpath')) {

    /**
     * user image path
     * @param String $role
     * @param int $role_id
     * @return mixed String
     */
    function roleimgpath($role,$role_id) {
        $CI = & get_instance();
        $CI->load->database();
         $CI->db->where('user_id', $role_id);
         $res = $CI->db->get('user')->row();
        if($role!="student"){        
       
         if($res->user_id!="")
         {
            return $path = 'uploads/system_image/'.$res->profile_pic;
         }         
         else{
            return $path = "uploads/user1.jpg";
         }
        
        }
        
        if($role=="student"){        
        $CI->db->where('user_id', $role_id);
         $res = $CI->db->get('student')->row();
         if($res->profile_photo!="")
         {
            return $path = 'uploads/student_image/'.$res->profile_photo;
         }         
         else{
            return $path = "uploads/user1.jpg";
         }
        }
        if($role=="staff"){        
        $CI->db->where('professor_id', $role_id);
         $res = $CI->db->get('professor')->row();
         if($res->image_path!="")
         {
             //if(is_dir(FCPATH.'uploads/professor/'.$res[0]['image_path']))
             //{
              return $path = 'uploads/professor/'.$res->image_path;
             //}
             //else{
              //   return $path = "uploads/user1.jpg";
           //  }
         }
         else{
            return $path = "uploads/user1.jpg";
         }
        }
       
        
    }

}

if (!function_exists('countcommenttopic')) {
    /**
     * Topic total comments
     * @param int $topic_id
     */
    function countcommenttopic($topic_id)
    {
        $CI = &get_instance();
        $CI->db->where('forum_comment_status','1');
        return $CI->db->get_where("forum_comment",array("forum_topic_id"=>$topic_id))->num_rows();
    }
    
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends MY_Model {
    
    function professor_update($id,$data)
    {
        $this->db->where('user_id',$id);
        return $this->db->update('professor',$data);        
    }
    function student_update($id,$data)
    {
        $this->db->where('user_id',$id);
        return $this->db->update('student',$data);        
    }
}
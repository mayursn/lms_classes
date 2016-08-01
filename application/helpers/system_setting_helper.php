<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('system_name')) {

    function system_name() {
        $CI = & get_instance();
        $CI->load->database();

        $CI->db->select('settings_id, type, description');
        $CI->db->from('system_setting');
        $CI->db->where('type', 'system_name');
        $res = $CI->db->get()->result();
        if (!empty($res)) {
            return $res[0]->description;
        }
    }

}

if (!function_exists('system_info')) {

    /**
     * System information
     * @param string $type
     * @return string
     */
    function system_info($type) {
        $CI = & get_instance();
        $result = $CI->db->select('settings_id, type, description')->from('system_setting')->where([
            'type' => $type
        ])->get();

        if ($result->num_rows()) {
            return $result->row()->description;
        }

        return 'No data found';
    }

}


if (!function_exists('user_activity')) {
    function user_activity()
    {
         $CI = & get_instance();
         $user_id = $CI->session->userdata('role_id');
         $user_role = $CI->session->userdata('role_name');
         $activity_status = $CI->session->userdata('activity_status');


        // Update database
        $updated = $CI->db
              ->set('activity',$CI->session->userdata('last_activity'))              
              ->set('activity_user_role_id',$user_id)              
              ->set('activity_user_role',$user_role)  
              ->set('activity_status',$activity_status)
              ->insert('last_activity');
        $CI->session->unset_userdata('last_activity');
        $CI->session->unset_userdata('activity_status');
    }
}
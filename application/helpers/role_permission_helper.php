<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('check_permission')) {

    /**
     * Check global permission
     * @param array $array
     * @param string $value
     * @return boolean
     */
    function check_permission($array, $permission) {
        $index = -1;
        $search = 1;
        foreach ($array[$permission][0] as $val) {
            if ($val == $search) {
                $index = 1;
            }
        }
        if ($index == -1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

if (!function_exists('read_permission')) {

    /**
     * Check read permission
     * @param array $array
     * @param string $permission
     * @return boolean
     */
    function read_permission($array, $permission) {
        if ($array[$permission][0][1] == 1) {
            return TRUE;
        }

        return FALSE;
    }

}

if (!function_exists('create_permission')) {

    /**
     * Check for create permission
     * @param arrat $array
     * @param string $permission
     * @return boolean
     */
    function create_permission($array, $permission) {

        if ($array[$permission][0][0] == 1) {
            return TRUE;
        }

        return FALSE;
    }

}

if (!function_exists('update_permisssion')) {

    /**
     * Check update permission
     * @param array $array
     * @param string $permission
     * @return boolean
     */
    function update_permisssion($array, $permission) {
        if ($array[$permission][0][2] == 1) {
            return TRUE;
        }

        return FALSE;
    }

}

if (!function_exists('delete_permission')) {
    
    /**
     * Check delete permission
     * @param array $array
     * @param string $permission
     * @return boolean
     */
    function delete_permission($array, $permission) {
        if ($array[$permission][0][3] == 1) {
            return TRUE;
        }

        return FALSE;
    }
	
    function check_role_approval()
    {
         $CI = & get_instance();
       $roledata=array('Admin','Staff');
        if(!in_array($CI->session->userdata('role_name'),$roledata))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

}

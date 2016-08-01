<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/**
 * CodeIgniter Date time format Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/date_helper.html
 */

// ------------------------------------------------------------------------
/*
 * @date $date 
 * date_formats() return F d, Y format date
 * $date = 11-10-2015
 */

if(!function_exists('date_formats'))
{
    function date_formats($date)
    {
        $CI = & get_instance();
        $CI->load->database();
        $CI->db->where('type','system_date_format');
        $res = $CI->db->get('system_setting')->row();      
        if($res->description=="m-d-Y")
        {
           
            $description = $res->description;
        }
        else{
            $description = $res->description;
        }
      $return_date =  nice_date($date,$res->description);
        //$return_date = date($description,strtotime($date));
       return $return_date;
       
    }
    
}

/*
 * @date $date 
 * datetime_formats() return F d, Y h:i:s A format date
 * $date = 11-10-2015 19:24:00 return October 11, 1994 07:24:00 PM
 * 
 */
if(!function_exists('datetime_formats'))
{
    function datetime_formats($datetime)
    {
         $CI = & get_instance();
        $CI->load->database();
        $CI->db->where('type','system_date_format');
        $res = $CI->db->get('system_setting')->row(); 
        $format = $res->description;
       $return_date = date($format." h:i:s A",strtotime($datetime));
       return $return_date;
       
    }
    
}

/**
 * @param $datetime
 * pass $datetime in Y-m-d H:i:s format
 * return duration between two datetime
 */

if(!function_exists('date_duration'))
{
    function date_duration($datetime)
    {
        $uploaded = date("Y-m-d H:i",strtotime($datetime));
        $datetime = date("Y-m-d H:i:s",strtotime($datetime));
        $datetime2 = date("Y-m-d H:i:s",strtotime($datetime));
       
        $date1 =  strtotime(date("Y-m-d H:i:s"));
        $date2 =  strtotime($datetime);
        $strtime1 = date("Y-m-d H:i:s");
        $strtime2 = $datetime; 
        $current = strtotime(date("Y-m-d H:i"));
        $uploaded = strtotime($uploaded);
        if($current == $uploaded)
        {
         $timeFirst  = strtotime(date("Y-m-d H:i:s"));
         $timeSecond = strtotime($datetime2);
        $differenceInSeconds = $timeFirst - $timeSecond ;
            return "a few seconds ago";
        }
        if($strtime1 > $strtime2)
        {
        $dateDiff    = $date1 - $date2;   
        $fullDays    = floor($dateDiff/(60*60*24));   
        $fullHours   = floor(($dateDiff-($fullDays*60*60*24))/(60*60));   
        $fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);      
        if ($fullDays > 0) {
                if ($fullDays == "1") {
                    return $fullDays . " day ago";
                } else {
                    return $fullDays . " days ago";
                }
            }
            if ($fullHours > 0) {
                if ($fullHours == '1') {
                    return $fullHours . " hour ago";
                } else {
                    return $fullHours . " hours ago";
                }
            }
            if ($fullMinutes > 0) {
                if ($fullMinutes == '1') {
                    return $fullMinutes . "  minute ago";
                } else {
                    return $fullMinutes . "  minutes ago";
                }
            }
        }
        if ($strtime2 > $strtime1) {
             $dateDiff    = $date2 - $date1;   
        $fullDays    = floor($dateDiff/(60*60*24));   
        $fullHours   = floor(($dateDiff-($fullDays*60*60*24))/(60*60));   
        $fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);      
        if ($fullDays > 0) {
                if ($fullDays == "1") {
                    return $fullDays . " day left";
                } else {
                    return $fullDays . " days left";
                }
            }
            if ($fullHours > 0) {
                if ($fullHours == '1') {
                    return $fullHours . " hour left";
                } else {
                    return $fullHours . " hours left";
                }
            }
            if ($fullMinutes > 0) {
                if ($fullMinutes == '1') {
                    return $fullMinutes . "  minute left";
                } else {
                    return $fullMinutes . "  minutes left";
                }
            }
        }        
    }
}

/*
 * @date $date 
 * datetime_formats() return F d, Y h:i:s A format date
 * $date = 11-10-2015 19:24:00 return October 11, 1994 07:24:00 PM
 * 
 */
if(!function_exists('js_dateformat'))
{
    function js_dateformat()
    {
         $CI = & get_instance();
        $CI->load->database();
        $CI->db->where('type','system_date_format');
        $res = $CI->db->get('system_setting')->row(); 
        $format = $res->description;    
        if(!empty($format))
        {
        $CI->db->where('php_dateformat',$format);
        $res2 = $CI->db->get('system_dateformat')->row(); 
        return $res2->js_dateformat;
        
        }
        else{
            $format = "MM d, yyyy";
            return $format;
        }
       
    }
    
}

    
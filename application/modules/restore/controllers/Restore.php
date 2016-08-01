<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Restore extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();

      
    }
   
    
    /**
     * Restore databse
     */
    function index() {
        $this->load->helper('backup_restore');
        if ($_FILES) {
            $this->load->helper('file');
            $file_name = $_FILES['userfile']['tmp_name'];
            $file_restore = $this->load->file($file_name, true);
            $file_array = explode(';', $file_restore);

            //truncate the table
            //get the list of table which will going to truncate
            $truncate_list = backup_and_restore_table();

            foreach ($truncate_list as $truncate) {
                $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                $this->db->query('TRUNCATE `' . $truncate . '`');
                $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
            }

            foreach ($file_array as $query) {
                if (trim($query) != '') {
                    $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                    $this->db->query($query);
                    $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
                }
            }
            $this->flash_notification('flash_message', 'System is successfully restored.');
            redirect(base_url('restore'));
        }
        $this->data['title'] = 'System Restore';
        $this->data['page'] = 'restore';
        $this->__template('restore/index', $this->data);
    }
}

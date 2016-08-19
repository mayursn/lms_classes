<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
      
    }
    
    public function index()
    {
        
        //load backup and restore helper
        $this->load->helper('backup_restore');
        $list = list_tables();
        $this->load->dbutil();

        //backup and restore ignore table list
        $remove_list = backup_restore_table_ignore_list();

        foreach ($remove_list as $search) {
            if (($key = array_search($search, $list)) !== FALSE) {
                unset($list[$key]);
            }
        }

        $prefs = array(
            'tables' => $list,
            'ignore' => array(),
            'format' => 'txt',
            'filename' => $this->db->database . ' ' . date("Y-m-d-H-i-s") . '-backup.sql',
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n"
        );

        $backup = & $this->dbutil->backup($prefs);

        $this->load->helper('download');
        force_download('System-Backup_' . date('d-m-Y h:i:s A') . '.sql', $backup);
        $this->session->set_flashdata('flash_message', 'System backup successfully.');
        //redirect(base_url('admin/backup'));
    }
}

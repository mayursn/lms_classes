<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System_settings extends MY_Controller
{
    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('system_settings/System_setting_model');
    }
    
    
   /**
    * view system setting option
    */
    function index() {
        $this->data['title'] = 'System Settings';
        $this->data['page'] = 'system_setting';
        $this->data['events'] = $this->System_setting_model->order_by_column('settings_id');
        $this->__template('system_settings/index', $this->data);
    }
       
    
    function update($id='')
    {
        $data = array();
        if ($_POST) {
            
                $system_name = $this->input->post('system_name');                                
                $this->System_setting_model->update_by_type('system_name',$system_name);                
                
                $phone = $this->input->post('phone');               
                $this->System_setting_model->update_by_type('phone',$phone);                

                $paypal_email = $this->input->post('paypal_email');
                $this->System_setting_model->update_by_type('paypal_email',$paypal_email);                

                $currency = $this->input->post('currency');
                $this->System_setting_model->update_by_type('currency',$currency);                
               
                $system_email = $this->input->post('system_email');
                $this->System_setting_model->update_by_type('system_email',$system_email);                
             


                $country_code = $this->input->post('countryCode');
                $this->System_setting_model->update_by_type('country_code',$country_code);                
               
                $system_date_format = $this->input->post('system_date_format');              
                $this->System_setting_model->update_by_type('system_date_format',$system_date_format);                
          
                 $this->flash_notification('System settings is successfully updated.');
                redirect(base_url() . 'system_settings/', 'refresh');           
        }

        
    }


}

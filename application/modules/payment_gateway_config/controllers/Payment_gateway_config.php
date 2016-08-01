<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_gateway_config extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('payment_gateway_config/Authorize_net_model');
    }

    function index() {
        $this->data['title'] = 'Authorize.net Configuration';
        $this->data['page'] = '';
        $this->data['authorize_net'] = $this->Authorize_net_model->order_by_column('login_id');
        $this->__template('payment_gateway_config/index', $this->data);
    }

   
    /**
     * Update Payment configuration 
     * @param string $id
     */
    function update($id = '') {
        
        if ($_POST) {
            $id = $this->input->post('config_id', TRUE);
            if ($id != '') {
                // update configuration
                $this->Authorize_net_model->update($id, array(
                    'login_id' => $this->input->post('login_id', TRUE),
                    'transaction_key' => $this->input->post('transaction_key', TRUE),
                    'success_url' => $this->input->post('success_url', TRUE),
                    'failure_url' => $this->input->post('failure_url', TRUE),
                    'cancel_url' => $this->input->post('cancel_url', TRUE),
                    'status' => $this->input->post('status', TRUE)
                        )
                );
                  $this->flash_notification('Authorize.net payment gateway configutaion updated.');                   
            } else {
                // add new configuration
                $this->Authorize_net_model->insert(array(
                    'login_id' => $this->input->post('login_id', TRUE),
                    'transaction_key' => $this->input->post('transaction_key', TRUE),
                    'success_url' => $this->input->post('success_url', TRUE),
                    'failure_url' => $this->input->post('failure_url', TRUE),
                    'cancel_url' => $this->input->post('cancel_url', TRUE),
                    'status' => $this->input->post('status', TRUE)
                        )
                );
                $this->flash_notification('Authorize.net configuration successfully added.');                   
                
            }
            redirect(base_url('payment_gateway_config'));
        }
        
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Charity_fund extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model('charity_fund/Charity_fund_model');
    }

    function index() {
        $this->data['title'] = 'Charity Fund';
        $this->data['page'] = 'charity_fund';
        $this->data['charity_fund'] = $this->Charity_fund_model->order_by_column('amount');
        $this->__template('charity_fund/index', $this->data);
    }

    /**
     * Create new deparmtents
     */
    function create() {
         if ($_POST) {
           
                //create charity fund
                if ($_POST['donation_type'] == 'cheque') {
                    $data['cheque_number'] = $_POST['cheque_cheque_number'];
                    $data['account_number'] = $_POST['cheque_account_number'];
                    $data['account_holder_name'] = $_POST['cheque_account_holder_name'];
                    $data['branch_code'] = $_POST['cheque_branch_code'];
                    $data['bank_name'] = $_POST['cheque_bank_name'];
                } elseif ($_POST['donation_type'] == 'dd') {
                    $data['account_number'] = $_POST['dd_account_number'];
                    $data['account_holder_name'] = $_POST['dd_account_holder_name'];
                    $data['branch_code'] = $_POST['dd_branch_code'];
                    $data['bank_name'] = $_POST['dd_bank_name'];
                }
                $data['donor_name'] = $_POST['donor_name'];
                $data['donor_mobile'] = $_POST['donor_mobile'];
                $data['email'] = $_POST['donor_email'];
                $data['amount'] = $_POST['amount'];
                $data['donation_type'] = $_POST['donation_type'];
                $data['description'] = $_POST['description'];
                $data['donation_date'] = $_POST['date'];
                $this->Charity_fund_model->insert($data);
                 $this->flash_notification('Charity Fund is successfully added.');
            redirect(base_url('charity_fund'));
            }
   
    }

    function view($id) {
        
    }

    function edit($id) {
        
    }

    /**
     * Delete Charity Fund
     * @param string $id
     */
    function delete($id) {
        $this->Charity_fund_model->delete($id);
        $this->flash_notification('Charity Fund is successfully deleted.');
        redirect(base_url('charity_fund'));
    }

    /**
     * Update Charity Fund 
     * @param string $id
     */
    function update($id = '') {
        if ($_POST) {
            
                if ($_POST['donation_type'] == 'cheque') {
                    $data['cheque_number'] = $_POST['cheque_cheque_number'];
                    $data['account_number'] = $_POST['cheque_account_number'];
                    $data['account_holder_name'] = $_POST['cheque_account_holder_name'];
                    $data['branch_code'] = $_POST['cheque_branch_code'];
                    $data['bank_name'] = $_POST['cheque_bank_name'];
                } elseif ($_POST['donation_type'] == 'dd') {
                    $data['account_number'] = $_POST['dd_account_number'];
                    $data['account_holder_name'] = $_POST['dd_account_holder_name'];
                    $data['branch_code'] = $_POST['dd_branch_code'];
                    $data['bank_name'] = $_POST['dd_bank_name'];
                }
                $data['donor_name'] = $_POST['donor_name'];
                $data['donor_mobile'] = $_POST['donor_mobile'];
                $data['email'] = $_POST['donor_email'];
                $data['amount'] = $_POST['amount'];
                $data['donation_type'] = $_POST['donation_type'];
                $data['description'] = $_POST['description'];
                $data['donation_date'] = $_POST['date'];
                $this->Charity_fund_model->update($id,$data);
            $this->flash_notification('Charity Fund is successfully updated.');
        }

        redirect(base_url('charity_fund'));
    }

}

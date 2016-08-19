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
         $this->load->library('authorize_net');
         if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }
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
               } elseif ($_POST['donation_type'] == 'authorize') {
                   
                   $cc_details = $this->validateCreditcard_number($_POST['card_number']);
            if ($cc_details['status'] == 'false') {
                // invalid card details
                echo 'invalid card details';
                //$this->do_payment();
            } else {
                      $data['card_holder_name'] = $_POST['card_holder_name'];
                    $auth_net = array(
                        'x_card_num' => $_POST['card_number'], // Visa
                        'x_exp_date' => $_POST['month'] . '/17',
                        'x_card_code' => $_POST['cvv'],
                        'x_description' => 'Authorize.net transaction',
                        'x_amount' => $_POST['amount'],
                        'x_first_name' => $_POST['card_holder_name'],
                        'x_last_name' => $_POST['donor_name'],
                        'x_phone' => $_POST['donor_mobile'],
                        'x_email' => $_POST['donor_email'],
                        'x_customer_ip' => $this->input->ip_address(),
                    );
                    $this->authorize_net->setData($auth_net);
                    // redirect after order completion
                    $status = array();
                    // Try to AUTH_CAPTURE
                    if ($this->authorize_net->authorizeAndCapture()) {
                        $details = $this->authorize_net->authorizeAndCapture();                        
                        $this->flash_notification('Transaction is successfully done.');                        
                        //insert into db
                       
                        
                    } else {
                        $this->session->set_flashdata('Transaction incomplete', '<p>' . $this->authorize_net->getError() . '</p>');
                       
                        redirect(base_url('charity_fund'));
                    }
                }
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
                }elseif ($_POST['donation_type'] == 'authorize') {
                   if($_POST['card_number']!='' && $_POST['cvv']!=''){
                   $cc_details = $this->validateCreditcard_number($_POST['card_number']);
            if ($cc_details['status'] == 'false') {
                // invalid card details
                echo 'invalid card details';
                //$this->do_payment();
            } else {
                
                      $data['card_holder_name'] = $_POST['card_holder_name'];
                    $auth_net = array(
                        'x_card_num' => $_POST['card_number'], // Visa
                        'x_exp_date' => $_POST['month'] . '/17',
                        'x_card_code' => $_POST['cvv'],
                        'x_description' => 'Authorize.net transaction',
                        'x_amount' => $_POST['amount'],
                        'x_first_name' => $_POST['card_holder_name'],
                        'x_last_name' => $_POST['donor_name'],
                        'x_phone' => $_POST['donor_mobile'],
                        'x_email' => $_POST['donor_email'],
                        'x_customer_ip' => $this->input->ip_address(),
                    );
                    $this->authorize_net->setData($auth_net);
                    // redirect after order completion
                    $status = array();
                    // Try to AUTH_CAPTURE
                    if ($this->authorize_net->authorizeAndCapture()) {
                        $details = $this->authorize_net->authorizeAndCapture();                        
                        $this->flash_notification('Transaction is successfully done.');                        
                        //insert into db
                       
                        
                    } else {
                        $this->session->set_flashdata('Transaction incomplete', '<p>' . $this->authorize_net->getError() . '</p>');
                       
                        redirect(base_url('charity_fund'));
                    }
                }
                   }
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

    /**
     * Validate credit card number
     * @param int $cc_num
     * @return array
     */
    function validateCreditcard_number($cc_num) {
        $credit_card_number = $this->sanitize($cc_num);
        // Get the first digit
        $data = array();
        $firstnumber = substr($credit_card_number, 0, 1);
        // Make sure it is the correct amount of digits. Account for dashes being present.
        switch ($firstnumber) {
            case 3:
                $data['card_type'] = "American Express";
                if (!preg_match('/^3\d{3}[ \-]?\d{6}[ \-]?\d{5}$/', $credit_card_number)) {
                    //return 'This is not a valid American Express card number';
                    $data['status'] = 'false';
                    return $data;
                }
                break;
            case 4:
                $data['card_type'] = "Visa";
                if (!preg_match('/^4\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number)) {
                    //return 'This is not a valid Visa card number';
                    $data['status'] = 'false';
                    return $data;
                }
                break;
            case 5:
                $data['card_type'] = "MasterCard";
                if (!preg_match('/^5\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number)) {
                    //return 'This is not a valid MasterCard card number';
                    $data['status'] = 'false';
                    return $data;
                }
                break;
            case 6:
                $data['card_type'] = "Discover";
                if (!preg_match('/^6011[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number)) {
                    //return 'This is not a valid Discover card number';
                    $data['status'] = 'false';
                    return $data;
                }
                break;
            default:
                //return 'This is not a valid credit card number';
                $data['card_type'] = "Invalid";
                $data['status'] = 'false';
                return $data;
        }
        // Here's where we use the Luhn Algorithm
        $credit_card_number = str_replace('-', '', $credit_card_number);
        $map = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 2, 4, 6, 8, 1, 3, 5, 7, 9);
        $sum = 0;
        $last = strlen($credit_card_number) - 1;
        for ($i = 0; $i <= $last; $i++) {
            $sum += $map[$credit_card_number[$last - $i] + ($i & 1) * 10];
        }
        if ($sum % 10 != 0) {
            //return 'This is not a valid credit card number';
            $data['status'] = 'false';
            return $data;
        }
        // If we made it this far the credit card number is in a valid format
        $data['status'] = 'true';
        return $data;
    }
    /**
     * Sanitize the input
     */
    function sanitize($value) {
        return trim(strip_tags($value));
    }
}

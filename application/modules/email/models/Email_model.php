<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends MY_Model {

    protected $primary_key = 'email_id';
    public $before_create = array('timestamps');
    public $before_update = array('update_timestamps');

    /**
     * Set the timestamps fields
     * @param array $email
     * @return array
     */
    protected function timestamps($email) {
        $email['created_at'] = $email['updated_at'] = date('Y-m-d H:i:s');

        return $email;
    }

    /**
     * Set update timestamp field
     * @param array $email
     * @return array
     */
    protected function update_timestamps($email) {
        $email['updated_at'] = date('Y-m-d H:i:s');

        return $email;
    }

    /**
     * Email sent list
     * @param string $email_to
     * @return array
     */
    public function email_sent_user_list($email_to) {
        return $this->db->select()
                        ->from('user')
                        ->where_in("user_id", $email_to)
                        ->get()
                        ->result();
    }

    /**
     * Email inbox
     * @param string $user_id
     * @return array
     */
    public function email_inbox($user_id) {
        return $this->db->select('email.*, user.*, email.created_at AS EmailDate')
                        ->from($this->_table)
                        ->where("FIND_IN_SET('$user_id', email_to)")
                        //->where_in("$this->_table.email_to", $user_id)
                        ->join("user", "user.user_id = $this->_table.email_from")
                        ->order_by("$this->_table.email_id", 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * Email inbox details
     * @param string $id
     * @return object
     */
    public function email_inbox_details($id) {
        return $this->db->select()
                        ->from('user')
                        ->join("$this->_table", "$this->_table.email_from = user.user_id")
                        ->where("$this->_table.email_id", $id)
                        ->limit(1)
                        ->get()->row();
    }

    /**
     * User sent emails
     * @param string $user_id
     * @return array
     */
    public function sent_email($user_id) {
        return $this->db->select()
                        ->from($this->_table)
                        ->where_in("$this->_table.email_from", $user_id)
                        ->order_by("$this->_table.email_id", $user_id)
                        ->get()->result();
    }

    /**
     * Update email view status
     * @param string $id
     * @param string $user_id
     */
    public function update_email_view_status($id, $user_id) {
        $viewed_email_details = $this->email_viewed_by_user($id, $user_id);
        $email_details = $this->Email_model->get($id);
        if (!count($viewed_email_details)) {
            $email_read = $email_details->email_read;
            $email_read = ltrim($email_read . ',' . $user_id, ',');

            //update read status of the email
            $this->update($id, array(
                'email_read' => $email_read
            ));
        }
    }

    /**
     * Email details of viewed email by user
     * @param string $id
     * @param string $user_id
     * @return object
     */
    public function email_viewed_by_user($id, $user_id) {
        return $this->db->select()
                        ->from($this->_table)
                        ->where("$this->_table.email_id", $id)
                        ->where("FIND_IN_SET('$user_id', email_read)")
                        //->where("$this->_table.email_read", $user_id)
                        ->get()->row();
    }
    
    /**
     * Is email read by user or not
     * @param string $id
     * @param string $user_id
     * @return int
     */
    public function is_email_read_by_user($id, $user_id) {
        return $this->db->select()
                ->from($this->_table)
                ->where("$this->_table.email_id", $id)
                ->where("FIND_IN_SET('$user_id', email_read)")
                ->get()->num_rows();
    }

}

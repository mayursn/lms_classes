<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Broadcast_and_streaming_model extends MY_Model {

    protected $primary_key = 'id';
    public $before_create = array('timestamps');

    protected function timestamps($broadcast_and_streaming) {
        $broadcast_and_streaming['created_at'] = date('Y-m-d H:i:s');

        return $broadcast_and_streaming;
    }

    /**
     * Start or stop live streaming
     * @param string $stream_name
     * @param string $status
     */
    function start_stop_streaming($stream_name, $status) {
        if ($status == 'Start') {
            $is_active = 1;
        } else {
            $is_active = 0;
        }
        $this->db->where('title', $stream_name);
        $this->db->update($this->_table, array(
            'is_active' => $is_active
        ));
    }

}

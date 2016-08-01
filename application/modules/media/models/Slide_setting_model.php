<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Slide_setting_model extends MY_Model {

    protected $primary_key = 'slider_id';

    /**
     * get all setting
     * @return mixed
     */
    function general_setting() {
        $this->db->select('slider_id, pause_time, anim_speed, pause_on_hover, caption_opacity');
        $this->db->order_by("slider_id", 'DESC');
        $this->db->limit(1);
        return $this->db->get("slide_setting")->result();
    }

}

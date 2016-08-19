<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends CI_Model {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Get all courses
     * @return mixed
     */
    function get_all_courses() {
        return $this->db->get('degree')->result();
    }

    /**
     * Get all Syllabus
     * @return mixed
     */
    function get_all_syllabus() {
        return $this->db->get('smart_syllabus')->result();
    }

    /**
     * Course details
     * @param int $id
     * @return object
     */
    function course_details($id) {
        return $this->db->get_where('degree', array(
                    'd_id' => $id
                ))->row();
    }

    /**
     * Course branch
     * @param int $id
     * @return mixed
     */
    function course_branch($id) {
        return $this->db->get_where('course', array(
                    'degree_id' => $id
                ))->result();
    }

    /**
     * Branch details
     * @param int $id
     * @return object
     */
    function branch_details($id) {
        return $this->db->get_where('course', array(
                    'course_id' => $id
                ))->row();
    }

    /**
     * Get all branch
     * @return mixed
     */
    function all_branch() {
        return $this->db->get('course')->result();
    }

    /**
     * Save subscriber
     * @param mixed $data
     * @return int
     */
    function save_subscriber($data) {
        $this->db->insert('subscriber', $data);

        return $this->db->insert_id();
    }

    /**
     * Check email is already present or not
     * @param string $email
     * @return int
     */
    function check_subscriber($email) {
        return $this->db->get_where('subscriber', array(
                    'email' => $email
                ))->num_rows();
    }

    /**
     * Get recent events
     * @return mixed
     */
    function events() {
        $this->db->limit(3);
        $this->db->order_by('event_date', 'DESC');

        return $this->db->get('event_manager')->result();
    }

    /**
     * Get all banners
     * @return mixed
     */
    function banners() {
        $this->db->where('banner_status', '1');
        return $this->db->get('banner_slider')->result();
    }

    /**
     * Get recent graduates
     * @return mixed
     */
    function recent_graduates() {
        return $this->db->select()
                        ->from('graduates')
                        ->join('student', 'student.std_id = graduates.student_id')
                        ->join('degree', 'degree.d_id = graduates.degree_id')
                        ->join('course', 'course.course_id = graduates.course_id')
                        ->join('batch', 'batch.b_id = graduates.batch_id')
                        ->join('semester', 'semester.s_id = graduates.semester_id')
                        ->limit(10)
                        ->order_by('graduates_id', 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * get all setting
     * @return mixed
     */
    function banner_setting() {

        $this->db->order_by("slider_id", 'DESC');
        $this->db->limit(1);
        return $this->db->get("slide_setting")->result();
    }

    /**
     * All Events
     * @return mixed
     */
    function all_events() {
        $this->db->order_by('event_date', 'DESC');

        return $this->db->get('event_manager')->result();
    }

    /**
     * Get recent university peoples
     * @return mixed
     */
    function recent_universiy_peoples() {
        $this->db->order_by('university_people_id', 'DESC');
        $this->db->limit(4);

        return $this->db->get('university_peoples')->result();
    }

    /**
     * Topics crud
     * @return mixed
     */
    function create_topic($data) {
        $this->db->insert("forum_topics", $data);
    }

    function create_comment($data) {
        $this->db->insert("forum_comment", $data);
    }

    /**
     * Check for user email is present or not
     * @param string $email
     * @return object
     */
    function is_user_email_present($email) {
        //$users = ['student', 'admin', 'professor'];
//        foreach ($users as $user) {
            $record = $this->db->select()
                            ->from('user')
                            ->where('email', $email)
                            ->get()->row();

            if ($record) {
                return $record;
            }
       // }

        return '';
    }

    /**
     * Update forgot password key
     * @param string $user_type
     * @param string $user_id
     * @param string $key
     */
    function update_forgot_password_key($user_type, $user_id, $key) {
             $this->db->where('user_id', $user_id);
            $this->db->update('user', [
                'password_key' => $key
            ]);
        
//             switch ($user_type) {
//            case 'admin':
//                $this->db->where('admin_id', $user_id);
//                $this->db->update('admin', [
//                    'forgot_password_link' => $key
//                ]);
//                break;
//            case 'student':
//                $this->db->where('std_id', $user_id);
//                $this->db->update('student', [
//                    'forgot_password_link' => $key
//                ]);
//                break;
//            case 'professor':
//                $this->db->where('professor_id', $user_id);
//                $this->db->update('professor', [
//                    'forgot_password_link' => $key
//                ]);
//                break;
//        }
    }

    /**     
     * Check for forgot password link
     * @param string $type
     * @param string $key
     * @return int
     */
    function check_for_forgot_password_key($type, $key) {
        return $this->db->get_where($type, [
                    'password_key' => $key
                ])->num_rows();
    }

    /**
     * Update user password
     * @param string $type
     * @param string $id
     * @param string $data
     */
    function update_password($type, $id, $data) {
        $user_data = array();
        $this->db->where('user_id', $id);
            $this->db->update($type, $data);
            $user_data['type_id'] = 'user_id';
//        switch ($type) {
//            case 'admin':
//                $this->db->where('admin_id', $id);
//                $this->db->update('admin', $data);
//                $user_data['type_id'] = 'admin_id';
//                break;
//            case 'student':
//                $this->db->where('std_id', $id);
//                $this->db->update('student', $data);
//                $user_data['type_id'] = 'std_id';
//                break;
//            case 'professor':
//                $this->db->where('professor_id', $id);
//                $this->db->update('professor', $data);
//                $user_data['type_id'] = 'professor_id';
//                break;
//        }
        $user_data['type'] = $type;
        $user_data['user_id'] = $id;

        return $user_data;
    }

    /**
     * Reset forgot password link
     * @param string $type
     * @param string $type_id
     * @param string $id
     */
    function reset_forgot_password_key($type, $type_id, $id) {
        $this->db->where($type_id, $id);
        $this->db->update($type, [
            'password_key' => ''
        ]);
    }

    /**
     * user comment delete permission
     * @param String $user_role
     * @param int $user_id
     * @param int $comment_id
     */
    function get_user_comment_delete_permission($user_role, $user_id, $comment_id) {
        $this->db->where("user_role", $user_role);
        $this->db->where("user_role_id", $user_id);
        $this->db->where("forum_comment_id", $comment_id);
        return $this->db->get("forum_comment")->row();
    }

    /**
     * delete comment
     * @param int $id
     */
    function delete_comment($id = '') {
        $this->db->delete("forum_comment", array("forum_comment_id" => $id));
    }

    /**
     * update comment data
     * @param mixed $data
     * @param int $id
     */
    function update_comment($data, $id) {
        $this->db->update("forum_comment", $data, array("forum_comment_id" => $id));
    }

}

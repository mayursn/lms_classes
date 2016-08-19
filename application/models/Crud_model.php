<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*     * ****  
      Created :-- Mayur Panchal
      Message : -- For get question title

     * ** */

    function getquestion($table, $question = '', $field = 'question') {
        return $this->db->select($field)->from($table)
                        ->where('sq_id', $question)->get()->row()->$field;
        //return $this->db->get_where($table, array('sq_id' => $question))->row()->$field;
    }

    /*  End code */

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        // echo $type_id;
        return $this->db->get_where($type, array($type . '_id' => $type_id))->row()->$field;
    }

    /*     * ***
      Created : -- Brijesh
      Message :--  For subject section class name get
     * *** */

    function get_class_name_by_id($type, $type_id = '', $field = 'name_numeric') {
        return $this->db->get_where($type, array($type . '_id' => $type_id))->row()->$field;
    }

    /* End Code */

    /* Start syllabus */

    function update_syllabus($data, $id) {
        $this->db->update("smart_syllabus", $data, array("syllabus_id" => $id));
    }

    function delete_syllabus($id) {
        $this->db->where("syllabus_id", $id);
        $this->db->delete("smart_syllabus");
    }

    function getsyllabus($id) {
        $this->db->where("syllabus_id", $id);
        return $this->db->get('smart_syllabus')->result();
    }

    function get_syllabus() {
        return $this->db->get('smart_syllabus')->result();
    }

    function add_syllabus($data) {
        $this->db->insert("smart_syllabus", $data);
    }

    /* End Code */

    ////////STUDENT/////////////
    function get_students($class_id) {
        $query = $this->db->get_where('student', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_student_info($student_id) {
        $query = $this->db->get_where('student', array('student_id' => $student_id));
        return $query->result_array();
    }

    //////////SUBJECT/////////////
    function get_subjects() {
        $query = $this->db->get('subject');
        return $query->result_array();
    }

    function get_subject_info($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id));
        return $query->result_array();
    }

    function get_subjects_by_class($class_id) {
        $query = $this->db->get_where('subject', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_subject_name_by_id($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id))->row();
        return $query->name;
    }

    //////////EXAMS/////////////
    function get_exams() {
        $query = $this->db->get('exam');
        return $query->result_array();
    }

    function get_exam_info($exam_id) {
        $query = $this->db->get_where('exam', array('exam_id' => $exam_id));
        return $query->result_array();
    }

    //////////GRADES/////////////
    function get_grades() {
        $query = $this->db->get('grade');
        return $query->result_array();
    }

    function get_grade_info($grade_id) {
        $query = $this->db->get_where('grade', array('grade_id' => $grade_id));
        return $query->result_array();
    }

    function get_grade($mark_obtained) {
        $query = $this->db->get('grade');
        $grades = $query->result_array();
        foreach ($grades as $row) {
            if ($mark_obtained >= $row['mark_from'] && $mark_obtained <= $row['mark_upto'])
                return $row;
        }
    }

    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

    function get_system_settings() {
        $query = $this->db->get('settings');
        return $query->result_array();
    }

    ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '') {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';
        return $image_url;
    }

    /**
     * Get all student information
     * 
     * @return array
     */
    function get_all_students() {
        return $this->db->select()
                        ->from('student')
                        ->get()
                        ->result();
    }

    /**
     * List of all student which is belogs to particular course
     * @param int $course_id
     * @return array
     */
    function course_students($course_id) {
        return $this->db->select()
                        ->from('student')
                        ->where('course_id', $course_id)
                        ->order_by('std_first_name', 'ASC')
                        ->get()
                        ->result();
    }

    /**
     * Student list by course and semester
     * @param int $course_id
     * @param int $semester_id
     * @return array
     */
    function student_list_by_course_semester($degree_id, $course_id, $batch_id, $semester_id) {
        return $this->db->get_where('student', array(
                    'std_degree' => $degree_id,
                    'course_id' => $course_id,
                    'std_batch' => $batch_id,
                    'semester_id' => $semester_id
                ))->result();
    }

    /// Admin ///
    function admin_detail() {
        return $this->db->select()
                        ->from('admin')
                        ->get()
                        ->row();
    }

    /// Email ///
    /**
     * Store the email data
     * 
     * @param array $name email data
     * @return int last insert id
     */
    function store_email($data) {
        $insert_id = $this->db->insert('email', $data);

        return $insert_id;
    }

    /**
     * My email inbox
     * @param string $email
     * @return array
     */
    function my_inbox($email) {
        return $this->db->select()
                        ->from('email')
                        ->where('email_to', $email)
                        ->get()
                        ->result();
    }

    /**
     * My sent email list
     * @param string $email
     * @return array
     */
    function my_sent_mail($email) {
        return $this->db->select()
                        ->from('email')
                        ->order_by('email_id', 'DESC')
                        ->where('email_from', $email)
                        ->where('is_draft', 0)
                        ->get()
                        ->result();
    }

    /**
     * View my all drafts email
     * @param string $email
     * @return array
     */
    function my_drafts($email) {
        return $this->db->select()
                        ->from('email')
                        ->where('email_from', $email)
                        ->where('is_draft', 1)
                        ->get()
                        ->result();
    }

    /**
     * View email
     * @param int $id
     * @return array type
     */
    function view_mail($id) {
        return $this->db->select()
                        ->from('email')
                        ->where('email_id', $id)
                        ->get()
                        ->row();
    }

    /**
     * Delete email
     * @param int $id
     */
    function delete_email($id) {
        $this->db->where('email_id', $id);
        $this->db->delete('email');
    }

    /**
     * Get all exams
     * @return array
     */
    function get_all_exam() {
        return $this->db->select()
                        ->from('exam_manager')
                        ->get()
                        ->result();
    }

    /**
     * Get all exam types
     * @return array
     */
    function get_all_exam_type() {
        return $this->db->select('exam_type_id, exam_type_name, status')
                        ->from('exam_type')
                        ->where('status', 1)
                        ->get()
                        ->result();
    }

    /**
     * Get all course
     * @return array
     */
    function get_all_course() {
        return $this->db->select('course_id, c_name, course_alias_id, degree_id, semester_id, course_status')
                        ->from('course')
                        ->order_by('c_name', 'ASC')
                        ->get()
                        ->result();
    }

    /**
     * Get all semester
     * @return array
     */
    function get_all_semester() {
        return $this->db->select('s_id, s_name, s_status')
                        ->from('semester')
                        ->order_by('s_name', 'ASC')
                        ->get()
                        ->result();
    }

    /**
     * Insert exam
     * @param array $data
     * @return int
     */
    function insert_exam($data) {
        $insert_id = $this->db->insert('exam_manager', $data);

        return $insert_id;
    }

    /**
     * Update exam detail
     * @param int $id
     * @param array $data
     * @return int
     */
    function update_exam($id, $data) {
        $this->db->where('em_id', $id);
        $insert_id = $this->db->update('exam_manager', $data);

        return $insert_id;
    }

    /**
     * All exam detail
     * @return array
     */
    function exam_details() {
        return $this->db->select('exam_manager.*, exam_type.*, course.*, semester.*, batch.*, degree.*')
                        ->from('exam_manager')
                        ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('batch', 'batch.b_id = exam_manager.batch_id')
                        ->join('degree', 'degree.d_id = exam_manager.degree_id')
                        ->order_by('em_date', 'DESC')
                        ->get()
                        ->result();
    }

    function single_exam_detail($id) {
        return $this->db->select('exam_manager.*, exam_type.*, course.*, semester.*')
                        ->from('exam_manager')
                        ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->where('exam_manager.em_id', $id)
                        ->get()
                        ->result();
    }

    /**
     * Update email read status
     * @param int $id
     * @param array $status
     * @return int
     */
    function update_email_read_status($id, $data) {
        $this->db->where('email_id', $id);
        $this->db->update('email', $data);
    }

    ///// Payment Gateway Configuration //////

    function authorize_net_config() {
        return $this->db->select()
                        ->from('authorize_net')
                        ->get()
                        ->result();
    }

    /**
     * Update authorize payment gateway info
     * @param int $id
     * @param array $data
     */
    function authorize_net_config_update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('authorize_net', $data);
    }

    /**
     * Authorized payment gateway insert
     * @param array $data
     * @return int
     */
    function authorize_net_config_insert($data) {
        $id = $this->db->insert('authorize_net', $data);
        return $id;
    }

    ///// Degree /////
    function get_all_degree() {
        return $this->db->select('d_id, d_name, d_status')
                        ->from('degree')
                        ->order_by('d_name', 'ASC')
                        ->where('d_status', 1)
                        ->get()
                        ->result();
    }

    //// Batch /////
    function get_all_bacth() {
        return $this->db->select()
                        ->from('batch')
                        ->order_by('b_name', 'ASC')
                        ->get()
                        ->result();
    }

    //// Admission type /////
    function get_all_admission_type() {
        return $this->db->select()
                        ->from('admission_type')
                        ->order_by('at_name', 'ASC')
                        ->get()
                        ->result();
    }

    ///// CMS Manager /////
    /**
     * CMS manager
     * @param array $data
     * @param int/NULL $id
     * @return int
     */
    function cms_manager_save($data, $id = NULL) {
        if ($id == NULL) {
            //insert
            $insert_id = $this->db->insert('cms_pages', $data);
        } else {
            //update
            $this->db->where('am_id', $id);
            $insert_id = $this->db->update('cms_pages', $data);
        }

        return $insert_id;
    }

    /**
     * Get all cms pages 
     * @return array
     */
    function get_all_cms_pages() {
        return $this->db->select()
                        ->from('cms_pages')
                        ->join('course', 'course.course_id = cms_pages.am_course')
                        ->join('semester', 'semester.s_id = cms_pages.am_semester')
                        ->join('batch', 'batch.b_id = cms_pages.am_batch')
                        ->join('degree', 'degree.d_id = cms_pages.degree_id')
                        ->get()
                        ->result();
    }

    //// Exam time table /////
    /**
     * Get time table list
     * @return array
     */
    function time_table() {
        return $this->db->select()
                        ->from('exam_time_table')
                        ->join('exam_manager', 'exam_manager.em_id = exam_time_table.exam_id')
                        ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('batch', 'batch.b_id = exam_time_table.batch_id')
                        ->join('degree', 'degree.d_id = exam_time_table.degree_id')
                        ->order_by('em_date', 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * Get exam list
     * @param int $course_id
     * @param int $semester_id
     * @return array
     */
    function get_exam_list($degree_id, $course_id, $batch_id, $semester_id) {
        return $this->db->get_where('exam_manager', array(
                            'course_id' => $course_id,
                            'em_semester' => $semester_id,
                            'degree_id' => $degree_id,
                            'batch_id' => $batch_id,
                            'exam_ref_name' => 'reguler'
                        ))
                        ->result();
    }

    /**
     * All exam list
     * @param int $course_id
     * @param int $semester_id
     * @return array
     */
    function all_exam_list($course_id, $semester_id) {
        return $this->db->get_where('exam_manager', array(
                            'course_id' => $course_id,
                            'em_semester' => $semester_id,
                        ))
                        ->result();
    }

    /**
     * Get remedial exam list
     * @param int $course_id
     * @param int $semester_id
     * @return array
     */
    function get_remedial_exam_list($course_id, $semester_id) {
        $this->db->order_by('em_date', 'DESC');
        return $this->db->get_where('exam_manager', array(
                            'course_id' => $course_id,
                            'em_semester' => $semester_id,
                            'exam_ref_name' => 'remedial'
                        ))
                        ->result();
    }

    /**
     * Create or update time table
     * @param array $data
     * @param int $id
     * @return int
     */
    function exam_time_table_save($data, $id = NULL) {
        if ($id == NULL) {
            //create
            $insert_id = $this->db->insert('exam_time_table', $data);
        } else {
            //update
            $this->db->where('exam_time_table_id', $id);
            $insert_id = $this->db->update('exam_time_table', $data);
        }

        return $insert_id;
    }

    ///// Exam Manager //////
    function exam_detail($exam_id) {
        return $this->db->get_where('exam_manager', array(
                    'em_id' => $exam_id
                ))->result();
    }

    /**
     * Subject list by course and semester
     * @param int $course_id
     * @param int $semester_id
     * @return array
     */
    function subject_list($course_id, $semester_id) {
        return $this->db->get_where('subject_manager', array(
                    'sm_course_id' => $course_id,
                    'sm_sem_id' => $semester_id
                ))->result();
    }

    /**
     * Student exam mark
     * @param array $where
     * @return array
     */
    function student_exam_mark($where) {
        return $this->db->get_where('marks_manager', $where)->row();
    }

    /**
     * Insert marks of the exam 
     * @param array $data
     * @return int
     */
    function mark_insert($data) {
        $insert_id = $this->db->insert('marks_manager', $data);

        return $insert_id;
    }

    /**
     * Update marks of the exam
     * @param array $data
     * @param array $where
     * @return int
     */
    function mark_update($data, $where) {
        $this->db->where($where);
        $insert_id = $this->db->update('marks_manager', $data);

        return $insert_id;
    }

    ///// Fees Structure /////
    /**
     * Get all fees structure
     * @return array
     */
    function get_all_fees_structure() {
        return $this->db->select()
                        ->from('fees_structure')
                        ->join('course', 'course.course_id = fees_structure.course_id')
                        ->join('semester', 'semester.s_id = fees_structure.sem_id')
                        ->join('batch', 'batch.b_id = fees_structure.batch_id')
                        ->join('degree', 'degree.d_id = fees_structure.degree_id')
                        ->get()
                        ->result();
    }

    /**
     * Insert or update fees structure
     * @param array $data
     * @param int $id
     * @return int
     */
    function fees_structure_save($data, $id = NULL) {
        if ($id == NULL) {
            //create
            $insert_id = $this->db->insert('fees_structure', $data);
        } else {
            //update
            $this->db->where('fees_structure_id', $id);
            $insert_id = $this->db->update('fees_structure', $data);
        }

        return $insert_id;
    }

    /**
     * Course and semester fees structure
     * @param int $course_id
     * @param int $semester_id
     * @return array
     */
    function course_semester_fees_structure($course_id, $semester_id) {
        return $this->db->select()
                        ->from('fees_structure')
                        ->where(array(
                            'course_id' => $course_id,
                            'sem_id' => $semester_id
                        ))
                        ->get()
                        ->result();
    }

    /**
     * Single fees structure details
     * @param int $id
     * @return object
     */
    function fees_structure_details($id) {
        return $this->db->select()
                        ->from('fees_structure')
                        ->where('fees_structure_id', $id)
                        ->get()
                        ->row();
    }

    /**
     * Exam subjects
     * @param int $exam_id
     * @return array
     */
    function exam_subjects($exam_id) {
        return $this->db->select('subject_manager.sm_id, subject_manager.subject_name')
                        ->from('subject_manager')
                        ->join('exam_time_table', 'exam_time_table.subject_id = subject_manager.sm_id')
                        ->where('exam_time_table.exam_id', $exam_id)
                        ->get()
                        ->result();
    }

    /**
     * All student fees details
     */
    function all_student_fees() {
        return $this->db->select()
                        ->from('student_fees')
                        ->join('fees_structure', 'fees_structure.fees_structure_id = student_fees.fees_structure_id')
                        ->join('student', 'student.std_id = student_fees.student_id')
                        ->join('course', 'course.course_id = student_fees.course_id')
                        ->join('semester', 'semester.s_id = student_fees.sem_id')
                        ->join('degree', 'degree.d_id = student.std_degree')
                        ->join('batch', 'batch.b_id = student.std_batch')
                        ->order_by('paid_created_at', 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * Save the student fees data
     * @param array $data
     * @return int
     */
    function student_fees_save($data) {
        $this->db->insert('student_fees', $data);
        return $this->db->insert_id();
    }

    /**
     * Get all student by course and semester
     * @param int $course_id
     * @param int $semester_id
     * @return array
     */
    function course_semester_student($course_id, $semester_id) {
        return $this->db->select('std_id, email, name, std_first_name, std_last_name')
                        ->from('student')
                        ->where(array(
                            'course_id' => $course_id,
                            'semester_id' => $semester_id
                        ))
                        ->get()
                        ->result();
    }

    /**
     * Get all teachers
     * @return array
     */
    function get_all_teacher() {
        return $this->db->select()
                        ->from('professor')
                        ->get()->result();
    }

    /**
     * Get all admin details
     */
    function get_all_admin() {
        return $this->db->get('admin')->result();
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
        $this->db->update('broadcast_and_streaming', array(
            'is_active' => $is_active
        ));
    }

    /**
     * Get course details
     * @param int $course_id
     * @return object
     */
    function get_course_details($course_id) {
        return $this->db->get_where('course', array(
                    'course_id' => $course_id
                ))->row();
    }

    /**
     * Get semetser details
     * @param int $semester_id
     * @return object
     */
    function get_semetser_detail($semester_id) {
        return $this->db->get_where('semester', array(
                    's_id' => $semester_id
                ))->row();
    }

    /**
     * Course list by degree
     * @param int $degree_id
     * @return array
     */
    function course_list_from_degree($degree_id) {
        $this->db->order_by('c_name', 'ASC');
        return $this->db->get_where('course', array(
                    'degree_id' => $degree_id
                ))->result();
    }

    /**
     * Batch list from degree and course
     * @param int $degree
     * @param int $course
     * @return array
     */
    function batch_list_from_degree_and_course($degree, $course) {
        $query = "SELECT * FROM batch ";
        $query .= "WHERE FIND_IN_SET($degree, degree_id) ";
        $query .= "AND FIND_IN_SET($course, course_id)";
        $result = $this->db->query($query);

        return $result->result();
    }

    /**
     * Exam list from degree, course, batch and course
     * @param int $degree
     * @param int $course
     * @param int $batch
     * @param int $semester
     * @return array
     */
    function exam_list_from_degree_and_course($degree, $course, $batch, $semester, $type) {
        return $this->db->get_where('exam_manager', array(
                    'degree_id' => $degree,
                    'course_id' => $course,
                    'batch_id' => $batch,
                    'em_semester' => $semester,
                    'exam_ref_name' => $type
                ))->result();
    }

    /**
     * Subject list from course and semester
     * @param int $course
     * @param int $semester
     * @return array
     */
    function subject_list_from_course_and_semester($course, $semester) {
        return $this->db->get_where('subject_manager', array(
                    'sm_course_id' => $course,
                    'sm_sem_id' => $semester
                ))->result();
    }

    /**
     * Exam time table subject list
     * @param int $exam_id
     * @return array
     */
    function exam_time_table_subject_list($exam_id) {
        return $this->db->select()
                        ->from('exam_time_table')
                        ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
                        ->where('exam_time_table.exam_id', $exam_id)
                        ->get()
                        ->result();
    }

    /**
     * Check for duplication of fees structure
     * @param int $degree
     * @param int $course
     * @param int $batch
     * @param int $sem
     * @param string $title
     * @return object
     */
    function fees_structure_duplication($degree, $course, $batch, $sem, $title) {
        return $this->db->get_where('fees_structure', array(
                    'degree_id' => $degree,
                    'course_id' => $course,
                    'batch_id' => $batch,
                    'sem_id' => $sem,
                    'title' => $title
                ))->row();
    }

    /**
     * Check exam duplication
     * @param int $degree
     * @param int $course
     * @param int $batch
     * @param int $sem
     * @param string $title
     * @return object
     */
    function exam_duplication_check($degree, $course, $batch, $sem, $title) {
        return $this->db->get_where('exam_manager', array(
                    'degree_id' => $degree,
                    'course_id' => $course,
                    'batch_id' => $batch,
                    'em_semester' => $sem,
                    'em_name' => $title
                ))->row();
    }

    /**
     * Time table duplication
     * @param int $exam
     * @param int $subject
     * @return object
     */
    function exam_time_table_duplication($exam, $subject) {
        return $this->db->get_where('exam_time_table', array(
                    'exam_id' => $exam,
                    'subject_id' => $subject
                ))->row();
    }

    /**
     * Check duplication for cms pages
     * @param int $degree
     * @param int $course
     * @param int $batch
     * @param int $sem
     * @param string $title
     * @return object
     */
    function cms_page_duplication($degree, $course, $batch, $sem, $title) {
        return $this->db->get_where('cms_pages', array(
                    'degree_id' => $degree,
                    'am_course' => $course,
                    'am_batch' => $batch,
                    'am_semester' => $sem,
                    'am_title' => $title
                ))->row();
    }

    /**
     * Get all grade
     * @return array
     */
    function grade() {
        return $this->db->get('grade')->result();
    }

    /**
     * Insert or update grade
     * @param int $id
     * @param array $data
     */
    function save_grade($data, $id = NULL) {
        if ($id == NULL) {
            //create
            $this->db->insert('grade', $data);
        } else {
            //update
            $this->db->where('grade_id', $id);
            $this->db->update('grade', $data);
        }
    }

    /**
     * Get semesters from branch
     * @param int $branch_id
     */
    function get_semesters_of_branch($branch_id) {
        $course = $this->get_course_details($branch_id);
        $sem_ids = explode(',', $course->semester_id);
        $semester = $this->db->select()
                ->from('semester')
                ->where_in('s_id', $sem_ids)
                ->get()
                ->result();

        return $semester;
    }

    /**
     * Get exam list by course, branch, batch, semester
     * @param string $course
     * @param string $branch
     * @param string $batch
     * @param string $semester
     * @return array
     */
    function get_exam_list_data($course, $branch, $batch, $semester, $type) {
        return $this->db->get_where('exam_manager', array(
                    'degree_id' => $course,
                    'course_id' => $branch,
                    'batch_id' => $batch,
                    'em_semester' => $semester,
                    'exam_ref_name' => $type
                ))->result();
    }

    /**
     * Exam types
     * @return array
     */
    function exam_types() {
        return $this->db->select()
                        ->from('exam_type')
                        ->get()
                        ->result();
    }

    /**
     * Save remedial exam 
     * @param array $data
     * @param string $id
     * @return int
     */
    function save_remedial_exam($data, $id = NULL) {
        $insert_id = 0;
        if ($id == NULL) {
            //insert
            $this->db->insert('exam_manager', $data);
            $insert_id = $this->db->insert_id();
        } else {
            //update
            $this->db->where('em_id', $id);
            $this->db->update('exam_manager', $data);
            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }

    /**
     * Remedial exam lists
     * @return array
     */
    function remedial_exam_list() {
        return $this->db->select('exam_manager.*, exam_type.*, course.*, semester.*, batch.*, degree.*')
                        ->from('exam_manager')
                        ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('batch', 'batch.b_id = exam_manager.batch_id')
                        ->join('degree', 'degree.d_id = exam_manager.degree_id')
                        ->where('exam_manager.exam_ref_name', 'remedial')
                        ->get()
                        ->result();
    }

    /**
     * Remedial exam schedule
     * @return array
     */
    function remedial_exam_schedule() {
        return $this->db->select()
                        ->from('exam_time_table')
                        ->join('exam_manager', 'exam_manager.em_id = exam_time_table.exam_id')
                        ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('batch', 'batch.b_id = exam_time_table.batch_id')
                        ->join('degree', 'degree.d_id = exam_time_table.degree_id')
                        ->where('exam_manager.exam_ref_name', 'remedial')
                        ->get()
                        ->result();
    }

    /**
     * Remedial exam student list
     * @param int $exam_id
     * @param int $passing Passing marks for an exam
     * @return array
     */
    function remedial_exam_student_list($exam_id, $passing_marks) {
        return $this->db->select()
                        ->from('marks_manager')
                        ->join('student', 'student.std_id = marks_manager.mm_std_id')
                        ->where(array(
                            'mm_exam_id' => $exam_id,
                            'mark_obtained < ' => $passing_marks
                        ))->group_by('marks_manager.mm_std_id')->get()->result();
    }

    /**
     * Failed student subject list
     * @param int $exam_id
     * @param int $student_id
     * @param int $passing_marks
     * @return array
     */
    function remedial_exam_student_subject($exam_id, $student_id, $passing_marks) {
        return $this->db->select()
                        ->from('marks_manager')
                        ->where(array(
                            'mm_std_id' => $student_id,
                            'mm_exam_id' => $exam_id,
                            'mark_obtained < ' => $passing_marks
                        ))->get()->result();
    }

    /**
     * Event manager
     * @return array
     */
    function event_manager() {
        return $this->db->select('event_name,event_location,event_date,event_id')
                        ->from('event_manager')
                        ->order_by('event_date', 'DESC')
                        ->get()
                        ->result_array();
    }

    /**
     * Get all subscriber
     * @return array
     */
    function subscriber() {
        $this->db->select('id, email, created_at');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('subscriber')->result();
    }

    /**
     * Delete subscriber
     * @param string $id
     */
    function delete_subscriber($id) {
        $this->db->delete('subscriber', array(
            'id' => $id
        ));
    }

    /**
     * Save exam seat no 
     * @param mixed $data
     * @return int
     */
    function save_exam_seat_no($data) {
        $this->db->insert('exam_seat_no', $data);

        return $this->db->insert_id();
    }

    /**
     * Custom stduents details to generate seat no
     * @param mixed $where
     * @return object
     */
    function custom_student_details($where) {
        return $this->db->select('std_id, semester_id, std_degree, course_id')
                        ->from('student')
                        ->where($where)
                        ->get()
                        ->result();
    }

    /**
     * Student list from degree, course, batch, and semester
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     * @return mixed
     */
    function student_list_from_degree_course_batch_semester($degree, $course, $batch, $semester) {
        return $this->db->get_where('student', array(
                    'std_degree' => $degree,
                    'course_id' => $course,
                    'std_batch' => $batch,
                    'semester_id' => $semester
                ))->result();
    }

    /**
     * Insert or update graduates
     * @param mixed $data
     * @param string $id
     */
    function save_graduates($data, $id = NULL) {
        if ($id) {
            //update
            $this->db->update('graduates', $data, array(
                'graduates_id' => $id
            ));
        } else {
            //insert
            $this->db->insert('graduates', $data);
        }
    }

    /**
     * Get all graduates
     * @return mixed
     */
    function get_all_graduates() {
        return $this->db->select()
                        ->from('graduates')
                        ->join('student', 'student.std_id = graduates.student_id')
                        ->join('degree', 'degree.d_id = graduates.degree_id')
                        ->join('course', 'course.course_id = graduates.course_id')
                        ->join('semester', 'semester.s_id = graduates.semester_id')
                        ->order_by('graduates.created_at', 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * Insert or update charity fund
     * @param mixed $data
     * @param string $id
     * @return int
     */
    function save_charity_fund($data, $id = NULL) {
        $insert_id = 0;
        if ($id) {
            //update
            $this->db->update('charity_fund', $data, array(
                'charity_fund_id' => $id
            ));
            $insert_id = $this->db->insert_id();
        } else {
            //insert            
            $this->db->insert('charity_fund', $data);
            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }

    /**
     * Charity fund
     * @return mixed
     */
    function charity_fund() {
        $this->db->order_by('charity_fund_id', 'DESC');

        return $this->db->get('charity_fund')->result();
    }

    /**
     * Get graduates students
     * @param string $id
     */
    function get_graduate_student($id) {
        return $this->db->get_where('graduates', array("graduates_id" => $id))->result();
    }

    /**
     * Get filter exam
     * @param type $degree
     * @param type $course
     * @param type $batch
     * @param type $semester
     * @return type
     */
    function get_exam_filter($degree, $course, $batch, $semester) {
        return $this->db->select('exam_manager.*, exam_type.*, course.*, semester.*, batch.*, degree.*')
                        ->from('exam_manager')
                        ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('batch', 'batch.b_id = exam_manager.batch_id')
                        ->join('degree', 'degree.d_id = exam_manager.degree_id')
                        ->where(array(
                            'exam_manager.degree_id' => $degree,
                            'exam_manager.course_id' => $course,
                            'exam_manager.batch_id' => $batch,
                            'exam_manager.em_semester' => $semester
                        ))
                        ->order_by('em_date', 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * Exam schedule filter
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semester
     * @param string $exam
     * @return mixed
     */
    function exam_schedule_filter($degree, $course, $batch, $semester, $exam) {
        return $this->db->select()
                        ->from('exam_time_table')
                        ->join('exam_manager', 'exam_manager.em_id = exam_time_table.exam_id')
                        ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->join('batch', 'batch.b_id = exam_time_table.batch_id')
                        ->join('degree', 'degree.d_id = exam_time_table.degree_id')
                        ->where(array(
                            'exam_time_table.degree_id' => $degree,
                            'exam_time_table.course_id' => $course,
                            'exam_time_table.batch_id' => $batch,
                            'exam_time_table.semester_id' => $semester,
                            'exam_time_table.exam_id' => $exam
                        ))
                        ->order_by('em_date', 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * Fee structure filter
     * @param string $degree
     * @param string $course
     * @param string $batch
     * @param string $semeter
     * @return mixed
     */
    function fee_structure_filter($degree, $course, $batch, $semeter) {
        return $this->db->select()
                        ->from('fees_structure')
                        ->join('course', 'course.course_id = fees_structure.course_id')
                        ->join('semester', 'semester.s_id = fees_structure.sem_id')
                        ->join('batch', 'batch.b_id = fees_structure.batch_id')
                        ->join('degree', 'degree.d_id = fees_structure.degree_id')
                        ->where(array(
                            'fees_structure.degree_id' => $degree,
                            'fees_structure.course_id' => $course,
                            'fees_structure.batch_id' => $batch,
                            'fees_structure.sem_id' => $semeter
                        ))->order_by('created_at', 'DESC')
                        ->get()
                        ->result();
    }

    /**
     * Professor list
     * @return mixed
     */
    function professor() {
        return $this->db->select('professor_id, name, email, address, mobile, dob, designation')
                        ->from('professor')
                        ->order_by('name', 'ASC')
                        ->get()->result();
    }

    /**
     * Insert or update professor information
     * @param mixed $data
     * @param int $id
     * @return int
     */
    function save_professor($data, $id = NULL) {
        $insert_id = 0;
        if ($id) {
            //update
            $this->db->where('professor_id', $id);
            $this->db->update('professor', $data);
            $insert_id = $this->db->insert_id();
        } else {
            $this->db->insert('professor', $data);
            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }

    /**
     * Class routine professor list
     * @param string $subject_id
     * @return mixed
     */
    function class_routine_professor($subject_id) {
        $subject = $this->db->select()
                        ->from('subject_manager')
                        ->where([
                            'sm_id' => $subject_id
                        ])->get()->row();

        $professors = explode(',', $subject->professor_id);

        return $this->db->select()
                        ->from('professor')
                        ->where_in('professor_id', $professors)->get()->result();
    }

    /**
     * Filtered class routine
     * @param mixed $where
     * @return mixed
     */
    function filtered_class_routine($where) {
        return $this->db->get_where('class_routine', $where)->result();
    }

    /**
     * Professor based on department and branch
     * @param string $department
     * @param string $branch
     * @return mixed
     */
    function professor_by_department_and_branch($department, $branch) {
        return $this->db->get_where('professor', [
                    'department' => $department,
                    'branch' => $branch
                ])->result();
    }

    /*
     * 
     * Created by mayur panchal
     * Message : -- for get assessments
     */

    public function assessment() {
        return $this->db->get('assessments')->result_array();
    }

    public function create_assessment($data) {
        $this->db->insert("assessments", $data);
    }

    public function update_assessment($data, $id) {
        $this->db->update("assessments", $data, array("assessment_id" => $id));
    }

    public function delete_assessment($id) {
        $this->db->delete("assessments", array("assessment_id" => $id));
    }

    /**
     * Class list
     * @return mixed
     */
    function class_list() {
        return $this->db->get('class')->result();
    }

    /**
     * Student list by course and semester
     * @param int $course_id
     * @param int $semester_id
     * @return array
     */
    function student_list_by_department_course_batch_semester_class($degree_id, $course_id, $batch_id, $semester_id, $class_id) {
        return $this->db->select('std_id, email, std_first_name, std_last_name, std_roll')->from('student')->where(array(
                    'std_degree' => $degree_id,
                    'course_id' => $course_id,
                    'std_batch' => $batch_id,
                    'semester_id' => $semester_id,
                    'class_id' => $class_id
                ))->order_by('std_first_name', 'ASC')->get()->result();
    }

    /**
     * Save student attendance
     * @param mixed $data
     * @param string $id
     * @return int
     */
    function save_student_attendance($data, $id = NULL) {
        $insert_id = 0;
        if ($id) {
            //update
            $this->db->where('attendance_id', $id);
            $this->db->update('attendance', $data);
        } else {
            //insert
            $this->db->insert('attendance', $data);
            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }

    /**
     * 
     * @param string $department
     * @param string $branch
     * @param string $batch
     * @param string $semester
     * @param string $class
     * @param string $class_routine
     * @param string $date
     * @param string $student
     * @return int
     */
    function check_attendance_status($branch, $course, $admission_plan, $class, $date, $student) {
        return $this->db->select('attendance_id, is_present, student_id')
                        ->from('attendance')
                        ->where(array(
                            'course_id' => $course,
                            'branch_id' => $branch,
                            'admission_plan_id' => $admission_plan,
                            'class_id' => $class,
                            'date_taken' => $date,
                            'student_id' => $student
                        ))->get()->row();
    }

    /**
     * insert to do item
     * @param mixed $data
     */
    function insert_todo($data) {
        $this->db->insert("todo_list", $data);
    }

    /**
     * get all todo according to  user
     * @return mixed
     */
    function get_todo() {
        $date = date('Y-m-d');
        $date = date('Y-m-d', strtotime('-6 days', strtotime($date)));
        $login_type = $this->session->userdata("login_type");
        $login_id = $this->session->userdata("login_user_id");
        $this->db->where("todo_role", $login_type);
        $this->db->where("todo_role_id", $login_id);
        $this->db->where('todo_datetime >= ', $date);
        $this->db->order_by("todo_datetime", "asc");
        return $this->db->get("todo_list")->result();
    }

    /**
     * change status of to do list item
     * @param mixed $data
     * @param int $id
     */
    function change_status($data, $id) {
        $this->db->update("todo_list", $data, array("todo_id" => $id));
    }

    /**
     * delete from list
     * @param int $id
     */
    function removetodo($id) {
        $this->db->delete("todo_list", array("todo_id" => $id));
    }

    /**
     * 
     * @param int $id
     * @return mixed
     */
    function gettododata($id) {
        return $this->db->get_where("todo_list", array("todo_id" => $id))->row();
    }

    /**
     * update to do list
     * @param mixed $data
     * @param int $id
     */
    function update_todo($data, $id) {
        $this->db->update("todo_list", $data, array("todo_id" => $id));
    }

    /**
     * get all timeline
     * @return mixed
     */
    function gettimeline() {
        return $this->db->get('timeline')->result_array();
    }

    /**
     * 
     * @param mixed $data
     */
    function addtimeline($data) {
        $this->db->insert("timeline", $data);
    }

    /**
     * update timeline
     * @param mixed $data
     * @param int $id
     */
    function update_timeline($data, $id) {
        $this->db->update("timeline", $data, array("timeline_id" => $id));
    }

    /**
     * 
     * @param int $id
     */
    function delete_timeline($id) {
        $this->db->delete("timeline", array("timeline_id" => $id));
    }

    function get_timline() {
        $this->db->order_by('timeline_year', 'desc');
        return $this->db->get_where("timeline", array("timeline_status" => '1'))->result();
    }

    /**
     * submitted assignment 
     * @param int $id
     */
    function get_submitted_assignment($id) {
        return $this->db->get_where("assignment_submission", array("assignment_submit_id" => $id))->result();
    }

    /**
     * update submitted assignment
     * @param mixed array $data
     * @param int $id
     */
    function update_submitted_assessment($data, $id) {
        $this->db->update("assignment_submission", $data, array("assignment_submit_id" => $id));
    }

    /**
     * Fee structure save and update
     * @param mixed $data
     * @param int $id
     */
    function student_pay_fee_structure_save($data, $id) {
        if ($id) {
            //update
            $this->db->where('stduent_fees_id', $id);
            $this->db->update('student_fees');
        } else {
            //insert
            $this->db->insert('student_fees', $data);
        }
    }

    /**
     * Get all professor list
     * @return mixed
     */
    function get_all_professor() {
        return $this->db->get('professor')->result();
    }

    /**
     * 
     */
    function getquestion_status($queid, $field) {
        return $this->db->select($field)
                        ->from('survey_question')
                        ->where('sq_id', $queid)
                        ->get()
                        ->row()->$field;
        //return $this->db->get_where("survey_question", array("sq_id" => $queid))->row()->$field;
    }

    /**
     * vocational course student list
     * return mixed data
     */
    function get_vocational_student($id) {

        return $this->db->select('vocational_course_fee.*, student.*, vocational_course.*,course_category.*')
                        ->from('vocational_course_fee')
                        ->where('vocational_course_fee.vocational_course_id', $id)
                        ->join('student', 'student.std_id = vocational_course_fee.student_id')
                        ->join('vocational_course', 'vocational_course.vocational_course_id = vocational_course_fee.vocational_course_id')
                        ->join('course_category', 'course_category.category_id = vocational_course.category_id')
                        ->get()
                        ->result();
    }

    /**
     * 
     */
    function get_topics_list($id) {
        return $this->db->get_where("forum_topics", array("forum_id" => $id))->result();
    }

    /**
     * All subjects list
     * @return mixed
     */
    function get_all_subjects() {
        return $this->db->get_where('subject_manager', [
                    'sm_status' => 1
                ])->result();
    }

    /**
     * Make payment student list
     * @param int $degree
     * @param int $course
     * @param int $batch
     * @param int $semester
     * @param int $fee_structure
     * @return mixed
     */
    function make_payment_student_list($degree, $course, $batch, $semester, $fee_structure) {
        return $this->db->select()
                        ->from('student_fees')
                        ->join('student', 'student.std_id = student_fees.student_id')
                        ->join('degree', 'degree.d_id = student.std_degree')
                        ->join('course', 'course.course_id = student_fees.course_id')
                        ->join('batch', 'batch.b_id = student.std_batch')
                        ->join('semester', 'semester.s_id = student_fees.sem_id')
                        ->where([
                            'student_fees.course_id' => $course,
                            'student_fees.sem_id' => $semester,
                            'student_fees.fees_structure_id' => $fee_structure,
                            'student.std_degree' => $degree,
                            'student.std_batch' => $batch
                        ])->get()->result();
    }

    /**
     * 
     */
    function get_recent_professor() {
        $this->db->select("professor_id,name,image_path,created_at,designation");
        $this->db->from("professor");
        $this->db->order_by("created_at", "DESC");
        //$this->db->limit(8);
        return $this->db->get()->result();
    }

    function get_ratings($id) {
        $this->db->select('AVG(std_rating) as avg_r');
        return $this->db->get_where("survey", array("sq_id" => $id))->row();
    }

    /**
     * Subject list from branch
     * @param int $branch
     * @return mixed
     */
    function subject_list_from_branch($branch) {
        return $this->db->select()
                        ->from('subject_manager')
                        ->where([
                            'sm_course_id' => $branch
                        ])
                        ->get()->result();
    }

    function getsubject($id) {
        $this->db->where('sm_course_id', $id);
        return $this->db->get('subject_manager')->result();
    }

    function cms_manager() {
        return $this->db->select('c_id, c_title, c_slug, c_status')
                        ->from('cms_manager')
                        ->order_by('created_date', 'DESC')
                        ->get()
                        ->result_array();
    }

    /**
     * 
     * @param mixed array $data
     * @param int $assign_id
     */
    function insert_update_assignment_reopen($data, $assign_id) {
        $res = $this->db->get_where('assignment_reopen', array("assign_id" => $assign_id))->num_rows();
        if ($res < 1) {
            $this->db->insert("assignment_reopen", $data);
        } else {
            $this->db->where("assign_id", $assign_id);
            $this->db->update("assignment_reopen", $data);
        }
    }

    /**
     * 
     * @param int $assign_id
     * @return type mixed array
     */
    function get_student_reopen($assign_id) {
        $this->db->select('student_id');
        return $this->db->get_where('assignment_reopen', array("assign_id" => $assign_id))->result();
    }

    /**
     * 
     * @param int $assign_id
     * @param int $student_id
     * @return mixed array
     */
    function get_submitted_student($assign_id, $student_id) {
        $this->db->select('GROUP_CONCAT(student_id SEPARATOR ",") as student', FALSE);
        $this->db->where("assign_id", $assign_id);
        $this->db->where("student_id", $student_id);
        return $this->db->get("assignment_submission")->result();
    }

    /**
     * study resource
     * @return mixed array
     */
    function get_study_resources() {
        $this->db->select('study_id,study_title,study_degree,study_course,study_batch,study_sem,study_filename');
        $this->db->order_by('study_id', 'DESC');
        return $this->db->get('study_resources')->result();
    }

    /**
     * get all submitted assignment
     * @return mixed array
     */
    function get_submitted_assignments() {
        $this->db->select("ass.submited_date,ass.comment,ass.document_file,ass.assignment_submit_id,am.assign_id,am.assign_title,am.assign_degree,am.course_id,am.assign_batch,am.assign_sem,s.name");
        $this->db->from('assignment_submission ass');
        $this->db->join("assignment_manager am", "am.assign_id=ass.assign_id");
        $this->db->join("student s", "s.std_id=ass.student_id");
        return $this->db->get();
    }

    /**
     * all assignment
     * @return mixed array
     */
    function get_all_assignment() {
        $this->db->select('assign_id,assign_title,assign_degree,course_id,assign_batch,assign_sem,class_id,assign_desc,assign_filename,assign_dos');
        $this->db->order_by('assign_id', 'DESC');
        return $this->db->get('assignment_manager')->result();
    }

    /**
     * submitted project
     * @return mixed array
     */
    function get_all_submitted_project() {
        $this->db->select("ps.student_id,ps.project_id,ps.dos,ps.description,ps.document_file,pm_id,pm.pm_title,pm.pm_degree,pm.pm_course,pm.pm_batch,pm.pm_semester,s.std_id, s.std_first_name, s.std_last_name, s.email");
        $this->db->from('project_document_submission ps');
        $this->db->join("project_manager pm", "pm.pm_id=ps.project_id");
        $this->db->join("student s", "s.std_id=ps.student_id");
        return $this->db->get();
    }

    /**
     * get all project
     * @return mixed array
     */
    function get_all_projects() {
        $this->db->order_by('pm_id', 'DESC');
        return $this->db->get('project_manager')->result();
    }

    /**
     * get all class
     * @return mixed array
     */
    function get_all_class() {
        return $this->db->select()
                        ->from('class')
                        ->order_by('class_name', 'ASC')
                        ->get()
                        ->result();
    }

    /**
     * filter  assignment list
     * @param int $course
     * @param int $batch
     * @param int $degree
     * @param int $semester
     * @param int $class
     * @return mixed array
     */
    function filter_assignment($course, $batch, $degree, $semester, $class) {

        $this->db->where("course_id", $course);
        $this->db->where("assign_batch", $batch);
        $this->db->where("assign_degree", $degree);
        $this->db->where("assign_sem", $semester);
        $this->db->where("class_id", $class);
        $this->db->order_by('assign_id', 'DESC');
        return $this->db->get('assignment_manager')->result();
    }

    function filter_submitted_assignment($course, $batch, $degree, $semester) {
        $this->db->select("ass.*,am.*,s.*,s.class_id");
        $this->db->from('assignment_submission ass');
        $this->db->join("assignment_manager am", "am.assign_id=ass.assign_id");
        $this->db->join("student s", "s.std_id=ass.student_id");
        $this->db->where("am.course_id", $course);
        $this->db->where("am.assign_batch", $batch);
        $this->db->where("am.assign_degree", $degree);
        $this->db->where("am.assign_sem", $semester);
        //$this->db->where("am.class_id", $class);
        return $this->db->get()->result();
    }

    function filter_assessment($course, $batch, $degree, $semester) {
        $this->db->select("ass.*,am.*,s.*,s.class_id");
        $this->db->from('assignment_submission ass');
        $this->db->join("assignment_manager am", "am.assign_id=ass.assign_id");
        $this->db->join("student s", "s.std_id=ass.student_id");
        $this->db->where("am.course_id", $course);
        $this->db->where("am.assign_batch", $batch);
        $this->db->where("am.assign_degree", $degree);
        $this->db->where("am.assign_sem", $semester);
        //$this->db->where("am.class_id", $class);
        return $this->db->get()->result();
    }

    /**
     * group list
     * @return mixed array
     */
    function get_all_group() {
        $this->db->select('g_id,group_name');
        return $this->db->get('group')->result();
    }

    function get_all_course_optimize() {
        return $this->db->select('course_id,c_name')
                        ->from('course')
                        ->order_by('c_name', 'ASC')
                        ->get()
                        ->result();
    }

    function get_all_semester_optimize() {
        return $this->db->select('s_id,s_name')
                        ->from('semester')
                        ->order_by('s_name', 'ASC')
                        ->get()
                        ->result();
    }

    function get_all_batch_optimize() {

        return $this->db->select('b_id,b_name')
                        ->from('batch')
                        ->order_by('b_name', 'ASC')
                        ->get()
                        ->result();
    }

    function get_all_degree_optimize() {
        return $this->db->select('d_id,d_name')
                        ->from('degree')
                        ->order_by('d_name', 'ASC')
                        ->get()
                        ->result();
    }

    /**
     * Get all student information
     * 
     * @return array
     */
    function get_all_students_optimize() {
        return $this->db->select('std_id,name')
                        ->from('student')
                        ->get()
                        ->result();
    }

    function get_all_library() {
        return $this->db->select('lm_id, lm_title, lm_degree, lm_batch, lm_course, lm_url, lm_semester, lm_filename')->from('library_manager')->get()->result();
    }

    /**
     * Department and branch wise class routine
     * @param string $department_id
     * @param string $branch_id
     * @param string $date
     * @return mixed
     */
    function department_branch_wise_class_routine($department_id, $branch_id, $date) {
        return $this->db->select()
                        ->from('class_routine')
                        ->join('subject_manager', 'subject_manager.sm_id = class_routine.SubjectID')
                        ->join('degree', 'degree.d_id = class_routine.DepartmentID')
                        ->join('course', 'course.course_id = class_routine.BranchID')
                        ->join('semester', 'semester.s_id = class_routine.SemesterID')
                        ->join('class', 'class.class_id = class_routine.ClassID')
                        ->where(array(
                            //'class_routine.DepartmentID' => $where['department_id'],
                            'DATE_FORMAT(class_routine.Start, "%Y-%m-%d") <= ' => date('Y-m-d', strtotime($date)),
                            //'class_routine.BranchID' => $where['branch_id'],
                            // 'class_routine.BatchID' => $where['batch_id'],
                            //'class_routine.SemesterID' => $where['semester_id'],
                            //'class_routine.ClassID' => $where['class_id'],
                            'class_routine.DepartmentID' => $department_id,
                            'class_routine.BranchID' => $branch_id
                        ))->order_by('class_routine.ClassRoutineId', 'ASC')->get()->result();
    }

    /**
     * Exam list from department and branch
     * @param string $department
     * @param string $branch
     * @return mixed
     */
    function exam_list_by_department_and_branch($department, $branch) {
        return $this->db->select()
                        ->from('exam_manager')
                        ->join('degree', 'degree.d_id = exam_manager.degree_id')
                        ->join('course', 'course.course_id = exam_manager.course_id')
                        ->join('semester', 'semester.s_id = exam_manager.em_semester')
                        ->where([
                            'exam_manager.degree_id' => $department,
                            'exam_manager.course_id' => $branch
                        ])->get()->result();
    }

    function exam_toppers($exam) {
        $exam_details = $this->single_exam_detail($exam);
        $failed_students = $this->db->select('mm_std_id')
                        ->from('marks_manager')
                        ->where([
                            'mm_exam_id' => $exam,
                            'mark_obtained <' => $exam_details[0]->passing_mark
                        ])->group_by('mm_std_id')->get()->result();

        $failed_student_list = array();
        foreach ($failed_students as $row) {
            array_push($failed_student_list, $row->mm_std_id);
        }

        $toppers = $this->db->select('mm_std_id, std_roll, std_first_name, std_last_name, SUM(mark_obtained) AS Total')
                        ->from('marks_manager')
                        ->join('student', 'student.std_id = marks_manager.mm_std_id')
                        ->where([
                            'mm_exam_id' => $exam,
                            'mark_obtained >=' => $exam_details[0]->passing_mark
                        ])
                        ->where_not_in('mm_std_id', $failed_student_list)
                        ->order_by('Total', 'DESC')->limit(10)->group_by('mm_std_id')->get()->result();

        return $toppers;
    }

    /**
     * Pass fail students
     * @param type $exam
     * @return type
     */
    function pass_fail_students($exam) {
        $exam_details = $this->single_exam_detail($exam);
        $failed_students = $this->db->select('mm_std_id')
                        ->from('marks_manager')
                        ->where([
                            'mm_exam_id' => $exam,
                            'mark_obtained <' => $exam_details[0]->passing_mark
                        ])->group_by('mm_std_id')->get()->result();

        $data['failed_students'] = $failed_students;
         $failed_student_list = array();
        foreach ($failed_students as $row) {
            array_push($failed_student_list, $row->mm_std_id);
        }

        $toppers = $this->db->select('mm_std_id, std_roll, std_first_name, std_last_name, SUM(mark_obtained) AS Total')
                        ->from('marks_manager')
                        ->join('student', 'student.std_id = marks_manager.mm_std_id')
                        ->where([
                            'mm_exam_id' => $exam,
                            'mark_obtained >=' => $exam_details[0]->passing_mark
                        ])
                        ->where_not_in('mm_std_id', $failed_student_list)
                        ->order_by('Total', 'DESC')->group_by('mm_std_id')->get()->result();

        $data['pass_students'] = $toppers;
        $data['total_students'] = count($failed_student_list) + count($toppers);
        
        return $data;
    }

    /**
     * Exam schedule list
     * @param string $exam
     * @return mixed
     */
    function exam_schedule_list($exam) {
        return $this->db->select()
                        ->from('exam_time_table')
                        ->where([
                            'exam_id' => $exam
                        ])->get()->result();
    }
    
     function get_late_submitted_assignment()
    {
        $this->db->select("a.*,ass.*,d.d_name,c.c_name,b.b_name,s.s_name,cl.class_name,st.name,date_format(ass.submited_date, ('%Y-%m-%d')) as submitted_date, date_format(a.assign_dos, ('%Y-%m-%d')) as assign_submission_date");
        $this->db->join('assignment_manager a','a.assign_id=ass.assign_id');
        $this->db->join('degree d','d.d_id=a.assign_degree');
        $this->db->join('course c','c.course_id=a.course_id');
        $this->db->join('batch b','b.b_id=a.assign_batch');
        $this->db->join('semester s','s.s_id=a.assign_sem');
        $this->db->join('class cl','cl.class_id=a.class_id');
        $this->db->join('student st','st.std_id=ass.student_id');
        $where = "a.assign_dos < ass.submited_date";
        $this->db->where($where);
        return $this->db->get('assignment_submission as ass')->result();
        
        //return $this->db->query("SELECT * FROM assignment_submission LEFT JOIN assignment_manager ON assignment_manager.assign_id=assignment_submission.assign_id WHERE assignment_submission.submited_date > assignment_manager.assign_dos")->result();    }
    }
    
    
    /**
     * late submitted assignment
     * @return mixed
     */
    function get_not_submitted_assignment()
    {        
        $this->db->select();            
        $this->db->from('student st');
        $this->db->join('assignment_submission ass','ass.assign_id=a.assign_id');        
        $date=  date('Y-m-d');        
        $this->db->where("a.assign_dos < ",$date);
        $this->db->join('degree d','d.d_id=a.assign_degree');
        $this->db->join('course c','c.course_id=a.course_id');
        $this->db->join('batch b','b.b_id=a.assign_batch');
        $this->db->join('semester s','s.s_id=a.assign_sem');
        $this->db->join('class cl','cl.class_id=a.class_id');
        $this->db->where_not_in('st.std_id','ass.student_id');
        $this->db->where('st.std_degree','a.assign_degree');
        $this->db->where('st.course_id','a.course_id');
        $this->db->where('st.std_batch','a.assign_batch');
        $this->db->where('st.semester_id','a.assign_sem');
        $this->db->where('st.class_id','a.class_id');
        return $this->db->get('assignment_manager a')->result();
    }
    

}

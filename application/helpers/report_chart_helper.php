<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('new_student_registration')) {

    /**
     * New student registration
     */
    function new_student_registration() {
        $CI = & get_instance();
        $CI->load->database();

        $result = $CI->db->select('COUNT(std_id) AS Total, YEAR(created_date) AS Year')
                ->from('student')
                ->order_by('Year', 'DESC')
                ->group_by('Year')
                ->get()
                ->result();

        return $result;
    }

}

if (!function_exists('male_vs_female_course_wise')) {

    /**
     * Male vs female cours wise
     */
    function male_vs_female_course_wise() {
        $CI = & get_instance();
        $CI->load->database();

        $result['male'] = $CI->db->select('COUNT(std_id) AS TotalMale, c_name, YEAR(student.created_date) as Year')
                ->from('course')
                ->join('student', 'student.course_id = course.course_id')
                ->where('std_gender', 'Male')
                ->group_by('c_name')
                ->get()
                ->result();

        $result['female'] = $CI->db->select('COUNT(std_id) AS TotalMale, c_name, YEAR(student.created_date) as Year')
                ->from('course')
                ->join('student', 'student.course_id = course.course_id')
                ->where('std_gender', 'Female')
                ->group_by('c_name')
                ->get()
                ->result();

        return $result;
    }

}

if (!function_exists('course_male_student_count')) {

    /**
     * Student male count course wise
     * @param int $course_id
     * @return int
     */
    function course_male_student_count($course_id) {
        $CI = & get_instance();
        $CI->load->database();

        $result = $CI->db->select('COUNT(std_id) AS TotalMale')
                ->from('student')
                ->join('course', 'course.course_id = student.course_id')
                ->where('student.std_gender', 'Male')
                ->where('course.course_id', $course_id)
                ->get()
                ->row();
        return (int) $result->TotalMale;
    }

}

if (!function_exists('course_female_student_count')) {

    /**
     * Student female count course wise
     * @param int $course_id
     * @return int
     */
    function course_female_student_count($course_id) {
        $CI = & get_instance();
        $CI->load->database();

        $result = $CI->db->select('COUNT(std_id) AS TotalMale')
                ->from('student')
                ->join('course', 'course.course_id = student.course_id')
                ->where('student.std_gender', 'Female')
                ->where('course.course_id', $course_id)
                ->get()
                ->row();
        return (int) $result->TotalMale;
    }

}

if (!function_exists('course_wise_student')) {

    /**
     * Course Wise total student count
     * @param int $course_id
     * @return int
     */
    function course_wise_student($course_id) {
        $CI = & get_instance();
        $CI->load->database();

        $result = $CI->db->select('COUNT(std_id) AS Total')
                ->from('student')
                ->join('course', 'course.course_id = student.course_id')
                ->where('course.course_id', $course_id)
                ->get()
                ->row();
        return (int) $result->Total;
    }

}

if (!function_exists('male_female_students')) {

    /**
     * Male vs female students
     * @return array
     */
    function male_female_students() {
        $CI = & get_instance();
        $CI->load->database();

        $result['total_male_student'] = $CI->db->select('std_id')
                ->from('student')
                ->where('std_gender', 'Male')
                ->get()
                ->num_rows();

        $result['total_female_student'] = $CI->db->select('std_id')
                ->from('student')
                ->where('std_gender', 'Female')
                ->get()
                ->num_rows();

        return $result;
    }

}

if (!function_exists('total_count_of_student_branch_wise')) {

    /**
     * Total count of student branch wise
     * @return mixed
     */
    function total_count_of_student_branch_wise() {
        $CI = & get_instance();
        return $CI->db->select('COUNT(std_id) AS TotalStudent')
                        ->from('student')
                        ->join('course', 'course.course_id = student.course_id', 'right')
                        ->group_by('course.course_id')
                        ->get()->result();
    }

}

if (!function_exists('unique_branch_list')) {

    /**
     * Unique branch list
     * @return mixed
     */
    function unique_branch_list() {
        $CI = & get_instance();
        return $CI->db->select('course.c_name')
                        ->from('course')
                        ->get()->result();
    }

}

if (!function_exists('student_ratio_department_wise')) {

    /**
     * Student count ratio department wise
     * @return mixed
     */
    function student_ratio_department_wise() {
        $CI = & get_instance();
        return $CI->db->select('COUNT(std_id) AS TotalStudent, d_name')
                        ->from('student')
                        ->join('degree', 'degree.d_id = student.std_degree', 'right')
                        //->where('std_gender', 'Male')
                        ->group_by('degree.d_id')
                        ->get()->result();
    }

}

if (!function_exists('exam_subject_grade_total_students')) {

    function exam_subject_grade_total_students($exam) {
        $CI = & get_instance();

        $exam_details = $CI->Crud_model->single_exam_detail($exam);

        $total_marks = $exam_details[0]->total_marks;

        $subjects = $CI->Crud_model->exam_subjects($exam);

        $grades = $CI->Crud_model->grade();

        foreach ($subjects as $subject) {
            $data['subject'][$subject->subject_name] = array();
            foreach ($grades as $grade) {
                $data['subject'][$subject->subject_name][$grade->grade_name] = array();

                $marks = $CI->db->select("(mark_obtained * 100) / $total_marks")
                                ->from('marks_manager')
                                ->where([
                                    'mm_exam_id' => $exam,
                                    'mm_subject_id' => $subject->sm_id,
                                    '(mark_obtained * 100) / 50 >= ' => $grade->from_marks,
                                    "(mark_obtained * 100) / $total_marks <=" => $grade->to_marks
                                ])->get()->num_rows();
                array_push($data['subject'][$subject->subject_name][$grade->grade_name], $marks);
            }
        }
        
        return $data;
    }

}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// base rule
$base_rule = 'trim|required';

$config = array(
    /**
     * Exam insert update validation rules
     */
    'exam_insert_update' => array(
        array(
            'field' => 'exam_name',
            'label' => 'Exam name',
            'rules' => $base_rule . '|min_length[5]|max_length[255]'
        ),
        array(
            'field' => 'exam_type',
            'label' => 'Exam type',
            'rules' => $base_rule
        ),
        array(
            'field' => 'total_marks',
            'label' => 'Total marks',
            'rules' => $base_rule . '|numeric'
        ),
        array(
            'field' => 'year',
            'label' => 'Year',
            'rules' => $base_rule . '|numeric'
        ),
        array(
            'field' => 'course',
            'label' => 'Course',
            'rules' => $base_rule
        ),
        array(
            'field' => 'semester',
            'label' => 'Semester',
            'rules' => $base_rule
        ),
        array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => $base_rule . '|is_natural'
        ),
        array(
            'field' => 'date',
            'label' => 'Date',
            'rules' => $base_rule
        )        
    ),
    'time_table_insert_update' => array(
        array(
            'field' => 'course',
            'label' => 'Course',
            'rules' => $base_rule
        ),
        array(
            'field' => 'semester',
            'label' => 'Semester',
            'rules' => $base_rule
        ),
        array(
            'field' => 'exam',
            'label' => 'Exam',
            'rules' => $base_rule
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => $base_rule
        ),
        array(
            'field' => 'exam_date',
            'label' => 'Exam date',
            'rules' => $base_rule
        ),
        array(
            'field' => 'start_time',
            'label' => 'Start time',
            'rules' => $base_rule
        ),
        array(
            'field' => 'end_time',
            'label' => 'End time',
            'rules' => $base_rule
        )
    ),
    'degree_insert' => array(
        array(
            'field' => 'd_name',
            'label' => 'Department',
            'rules' => $base_rule.'|is_unique[degree.d_name]'
        )
    ),
    'assignment_insert' => array(
        array(
            'field' => 'title',
            'label' => 'Assignment',
            'rules' => $base_rule.'|is_unique[assignment_manager.assign_title]'
        ),
        array(
            'field' => 'degree',
            'label' => 'Department',
            'rules' => $base_rule
        ),
        array(
            'field' => 'course',
            'label' => 'Branch',
            'rules' => $base_rule
        ),
        array(
            'field' => 'batch',
            'label' => 'Batch',
            'rules' => $base_rule
        ),
        array(
            'field' => 'semester',
            'label' => 'Semester',
            'rules' => $base_rule
        ),
        array(
            'field' => 'class',
            'label' => 'Class',
            'rules' => $base_rule
        ),
        array(
            'field' => 'submissiondate',
            'label' => 'Submission Date',
            'rules' => $base_rule
        )
    )
           
);

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_routine extends MY_Controller {

    /**
     * Constructor
     * 
     * @return void
     */
    function __construct() {
        parent::__construct();
        $this->load->model("class_routine/Class_routine_model");
        $this->load->model("department/Degree_model");
         $this->load->model("Crud_model");
        date_default_timezone_set('Etc/UTC');
        if(!$this->session->userdata('user_id'))
        {
            redirect(base_url().'user/login');
        }

    }

    /**
     * class routine
     */
    function index() {
       
        if ($_POST) {
            $where = [
                'DepartmentID' => $_POST['department'],
                'BranchID' => $_POST['branch'],
                'BatchID' => $_POST['batch'],
                'SemesterID' => $_POST['semester'],
            ];

            if ($_POST['professor'] != '')
                $where['ProfessorID'] = $_POST['professor'];

            $class_routine = $this->Class_routine_model->get_many_by($where);
            $this->session->set_userdata('class_routine', $class_routine);

            $filter_data = [
                'DepartmentID' => $_POST['department'],
                'BranchID' => $_POST['branch'],
                'BatchID' => $_POST['batch'],
                'SemesterID' => $_POST['semester'],
            ];
            $filter_data['ProfessorID'] = $_POST['professor'];
            $this->session->set_userdata('filter_data', $filter_data);
            redirect(base_url('class_routine'));
        }
        $this->data['title'] = 'Class Routine';
        $this->data['page'] = 'class_routine';
        $this->data['department'] = $this->Degree_model->order_by_column('d_name');
        $this->__template('class_routine/index', $this->data);
    }
    
    
    function telerik_read() {
        //$event_data = $this->db->get('class_routine')->result();

        echo json_encode($this->session->userdata('class_routine'));
        $this->session->unset_userdata('class_routine');
        $this->session->unset_userdata('filter_data');
    }
    
    
    /**
     * Class routine update
     */
    function telerik_update() {
        $request = $_POST['models'];
        $data = json_decode($request);
        foreach ($data as $row) {
            $update = [
                'Title' => $row->Title,
                'Start' => $row->Start,
                'End' => $row->End,
                'StartTimezone' => $row->StartTimezone,
                'EndTimezone' => $row->EndTimezone,
                'Description' => $row->Description,
                'RecurrenceID' => $row->RecurrenceID,
                'RecurrenceRule' => $row->RecurrenceRule,
                'RecurrenceException' => $row->RecurrenceException,
                //'OwnerID' => $row->OwnerID,
                'IsAllDay' => $row->IsAllDay,
                'DepartmentID' => $row->DepartmentID,
                'BranchID' => $row->BranchID,
                'BatchID' => $row->BatchID,
                'SemesterID' => $row->SemesterID,
                'ClassID' => $row->ClassID,
                'SubjectID' => $row->SubjectID,
                'ProfessorID' => $row->ProfessorID,
            ];
            $this->db->where('ClassRoutineId', $row->ClassRoutineId);
            $this->db->update('class_routine', $update);
        }
    }
    
    
    function telerik_create() {
        $request = $_POST['models'];
        $data = json_decode($request);
        foreach ($data as $row) {
            $insert = [
                //'TaskID' => $row->TaskID,
                'Title' => $row->Title,
                'Start' => $row->Start,
                'End' => $row->End,
                'StartTimezone' => $row->StartTimezone,
                'EndTimezone' => $row->EndTimezone,
                'Description' => $row->Description,
                'RecurrenceID' => $row->RecurrenceID,
                'RecurrenceRule' => $row->RecurrenceRule,
                'RecurrenceException' => $row->RecurrenceException,
                //'OwnerID' => $row->OwnerID,
                'IsAllDay' => $row->IsAllDay,
                'DepartmentID' => $row->DepartmentID,
                'BranchID' => $row->BranchID,
                'BatchID' => $row->BatchID,
                'SemesterID' => $row->SemesterID,
                'ClassID' => $row->ClassID,
                'SubjectID' => $row->SubjectID,
                'ProfessorID' => $row->ProfessorID,
            ];
            $this->db->insert('class_routine', $insert);
        }
    }
    
    /**
     * Class routine delete
     */
    function telerik_delete() {
        $request = $_POST['models'];
        $data = json_decode($request);
        $this->db->delete('class_routine', ['ClassRoutineId' => $data[0]->ClassRoutineId]);
    }



}

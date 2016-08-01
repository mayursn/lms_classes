<?php
$this->load->model('branch/Branch_location_model');
$this->load->model('courses/Course_model');
$this->load->model('admission_plan/Admission_plan_model');
$this->load->model('classes/Class_model');
?>
<table class="table table-striped table-bordered table-responsive" id="fee-structure-data-tables">
    <thead>
        <tr>
            <th>No</th>
            <th>Title</th>            
            <th>Branch</th>
            <th>Course</th>
            <th>Admission Plan</th>
            <th>Class</th>
            <th>Fee</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($fees_structure as $row) { ?>
            <tr>
                <td><?php echo $row->fees_structure_id; ?></td>
                <td><?php echo $row->title; ?></td>
                <td><?php
                    $branch = $this->Branch_location_model->get($row->branch_id);
                    echo $branch->branch_name;   ?>
                </td>
                <td><?php
                    $course = $this->Course_model->get($row->course_id);
                    echo $course->c_name;   ?>
                </td>
                <td><?php
                    $plan = $this->Admission_plan_model->get($row->admission_plan_id);
                    echo $plan->admission_duration; ?>
                </td>
                <td><?php
                    $class = $this->Class_model->get($row->class_id);
                    echo $class->class_name; ?>
                </td>
                <td><?php echo $row->total_fee; ?></td>
                <td class="menu-action">
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/fees_edit/<?php echo $row->fees_structure_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>fees/delete/<?php echo $row->fees_structure_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
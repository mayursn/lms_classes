<?php
$this->load->model('department/Degree_model');
$this->load->model('branch/Course_model');
$this->load->model('batch/Batch_model');
$this->load->model('semester/Semester_model');
?>
<table class="table table-striped table-bordered table-responsive" id="fee-structure-data-tables">
    <thead>
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Department</th>
            <th>Branch</th>
            <th>Batch</th>
            <th>Semester</th>
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
                                    if($row->degree_id!="All")
                                    {
                                    $degree = $this->Degree_model->get($row->degree_id);
                                            echo $degree->d_name;
                                    }
                                    else{
                                        echo "All";
                                    }
                                    ?></td>
                                    <td><?php 
                                    if($row->course_id!="All")
                                    {
                                   $branch =  $this->Course_model->get($row->course_id);
                                    echo $branch->c_name; 
                                    }else{
                                        echo "All";
                                    }
                                    ?></td>
                                    <td><?php
                                    if($row->batch_id!="All")
                                    {
                                    $batch = $this->Batch_model->get($row->batch_id);
                                    echo $batch->b_name; 
                                    }else{
                                        echo "All";
                                    }
                                    ?></td>
                                    <td><?php 
                                    if($row->sem_id!="All")
                                    {
                                    $semester = $this->Semester_model->get($row->sem_id);
                                    
                                    echo $semester->s_name;
                                    }  else {
                                        echo "All";
                                    }
                                    ?></td>
                <td><?php echo $row->total_fee; ?></td>
                <td class="menu-action">
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_fees_structure/<?php echo $row->fees_structure_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>admin/fees_structure/delete/<?php echo $row->fees_structure_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
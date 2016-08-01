<?php
$create = create_permission($permission, 'Exam_Schedual');
$read = read_permission($permission, 'Exam_Schedual');
$update = update_permisssion($permission, 'Exam_Schedual');
$delete = delete_permission($permission, 'Exam_Schedual');
?>
 <?php if($create || $read || $update || $delete){ ?>
<table class="table table-striped table-bordered table-responsive" id="search-data-tables">
    <thead>
        <tr>
            <th>No</th>
            <th>Branch</th>
            <th>Course</th>
            <th>Admission Plan</th>            
            <th>Exam</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Time</th>
            <?php if($update || $delete){ ?>
            <th width="10%">Action</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = 1;
        foreach ($time_table as $row) {
            ?>
            <tr>
                <td><?php echo $counter; ?></td>
                <td><?php echo $row->branch_name; ?></td>
                <td><?php echo $row->c_name; ?></td>
                <td><?php echo $row->admission_duration; ?></td>                
                <td><?php echo $row->em_name; ?></td>
                <td><?php echo $row->subject_name; ?></td>
                <td><?php echo date_formats($row->exam_date); ?></td>
                <td><?php echo date('h:i A', strtotime(date('Y-m-d') . $row->exam_start_time)) . ' to ' . date('h:i A', strtotime(date('Y-m-d') . $row->exam_end_time)); ?></td>
                <?php if($update || $delete){ ?>
                <td class="menu-action">
                    <?php  if($update ){?>
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_exam_time_table/<?php echo $row->exam_time_table_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                    <?php } ?>
                    <?php if($delete){ ?>
                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>examschedual/delete/<?php echo $row->exam_time_table_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                    <?php } ?>
                </td>
                <?php } ?>
            </tr>
            <?php
            $counter++;
        }
        ?>
    </tbody>
</table>
 <?php } ?>
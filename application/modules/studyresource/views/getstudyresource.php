<!-- Start .row -->
<?php
$create = create_permission($permission, 'Study_Resource');
$read = read_permission($permission, 'Study_Resource');
$update = update_permisssion($permission, 'Study_Resource');
$delete = delete_permission($permission, 'Study_Resource');
$this->load->model('branch/Branch_location_model');
$this->load->model('courses/Course_model');
$this->load->model('admission_plan/Admission_plan_model');
?>
<?php if($create || $read || $update || $delete){ ?>
<table class="table table-striped table-bordered table-responsive" cellspacing=0 width=100% id="data-tables">
    <thead>
        <tr>
            <th>No</th>											
            <th><div>Title</div></th>											
            <th><div>Branch</div></th>
            <th><div>Course</div></th>
            <th><div>Admission Plan</div></th>											            											                                                           
            <th><div>File</div></th>											
            <?php if( $update || $delete){ ?>
                <th>Action</th>											
                <?php } ?>										
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        foreach ($studyresource as $row):
            ?>
            <tr>
                <td><?php echo $count++; ?></td>	
                <td><?php echo $row->study_title; ?></td>	
                <td><?php
                   $get_branch =$this->Branch_location_model->get($row->branch_id);
                   echo $get_branch->branch_name;
                    ?>
                </td>	
                <td><?php
                    $get_course = $this->Course_model->get($row->course_id);
                    echo $get_course->c_name;
                    ?>
                </td>
                <td>
                    <?php
                    $get_plan = $this->Admission_plan_model->get($row->admission_plan_id);
                    echo $get_plan->admission_duration;
                    ?>
                </td>	                
             <td><a href="<?php echo base_url() . 'uploads/project_file/' . $row->study_filename; ?>" download=""  title="<?php echo $row->study_filename; ?>"><i class="fa fa-download"></i></a></td>	
             <?php if($update || $delete){ ?>
                <td class="menu-action">
                  <?php if($update){ ?>
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/studyresource_edit/<?php echo $row->study_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                  <?php } ?>
                   <?php if($delete){ ?> 
                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>studyresource/delete/<?php echo $row->study_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>	
                   <?php } ?>
                </td>	
             <?php } ?>
            </tr>
        <?php endforeach; ?>						
    </tbody>
</table>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        "use strict";
        $('#data-tables').dataTable({"language": { "emptyTable": "No data available" }});
    });
    $(document).ready(function () {
        "use strict";
        $('#data-tabless').dataTable({"language": { "emptyTable": "No data available" }});
    });
</script>

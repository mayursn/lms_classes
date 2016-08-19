<?php
$create = create_permission($permission, 'Course');
$read = read_permission($permission, 'Course');
$update = update_permisssion($permission, 'Course');
$delete = delete_permission($permission, 'Course');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <?php if ($create) { ?>
                    <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/courses_create');" data-toggle="modal"><i class="fa fa-plus"></i> Course</a>
                <?php } ?>

                <?php if ($create || $read || $update || $delete) { ?>
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Course</th>
                                <th>Admission Plan</th>
                                <th>Status</th>
                                <?php if ($update || $delete) { ?>
                                    <th>Action</th>
                                <?php } ?>                                
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($course as $row): ?>
                                <tr>
                                    <td></td>                                    
                                    <td><?php echo $row->c_name; ?></td>    
                                    <?php $this->load->model('admission_plan/Admission_plan_model'); ?>
                                    <td style="white-space:pre"><?php
                                    $plan_id = explode(",",$row->admission_plan_id);
                                    foreach ($plan_id as $id):
                                    $plan =  $this->Admission_plan_model->get($id); 
                                    if($plan){
                                    echo $plan->admission_duration." <br/>\n";
                                    }
                                    endforeach;
                                    ?></td>                                    
                                    <td>
                                        <?php if ($row->course_status == '1') { ?>
                                            <span class="label label-primary mr6 mb6" >Active</span>
                                        <?php } else { ?>	
                                            <span class="label label-danger mr6 mb6" >InActive</span>
                                        <?php } ?>
                                    </td>
                                    <?php if ($update || $delete) { ?>
                                        <td class="menu-action">
                                            <?php if ($update) { ?>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/courses_edit/<?php echo $row->course_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                            <?php } ?>

                                            <?php if ($delete) { ?>
                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>course/delete/<?php echo $row->course_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                            <?php } ?>
                                        </td>
                                        <?php } ?>

                                </tr>
    <?php endforeach; ?>											
                        </tbody>
                    </table>
<?php } ?>

            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
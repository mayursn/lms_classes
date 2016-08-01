<?php
$create = create_permission($permission, 'Admission_Plan');
$read = read_permission($permission, 'Admission_Plan');
$update = update_permisssion($permission, 'Admission_Plan');
$delete = delete_permission($permission, 'Admission_Plan');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <?php if ($create) { ?>
                    <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/admission_plan_create');" data-toggle="modal"><i class="fa fa-plus"></i> Admission Plan</a>
                <?php } ?>

                <?php if ($create || $read || $update || $delete) { ?>
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Admission Plan</th>
                                <th>Status</th>
                                <?php if ($update || $delete) { ?>
                                    <th>Action</th>
                                <?php } ?>                                
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($admission_plan as $row): ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $row->admission_duration; ?></td>  
                                    <td>
                                        <?php if ($row->admission_plan_status == '1') { ?>
                                            <span class="label label-primary mr6 mb6" >Active</span>
                                        <?php } else { ?>	
                                            <span class="label label-danger mr6 mb6" >InActive</span>
                                        <?php } ?>
                                    </td>
                                    <?php if ($update || $delete) { ?>
                                        <td class="menu-action">
                                            <?php if ($update) { ?>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/admission_plan_edit/<?php echo $row->admission_plan_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                            <?php } ?>                                            
                                            <?php if ($delete) { ?>
                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>admission_plan/delete/<?php echo $row->admission_plan_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
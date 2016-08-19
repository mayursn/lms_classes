<?php
$create = create_permission($permission, 'Department');
$read = read_permission($permission, 'Department');
$update = update_permisssion($permission, 'Department');
$delete = delete_permission($permission, 'Department');
?>

<!-- Start .row -->
<div class=row> 
    <div class="col-lg-12">
        <div class=" panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>

                <?php if ($create) { ?>
                    <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/department_create');" data-toggle="modal"><i class="fa fa-plus"></i> Department</a>
                <?php } ?>

                <?php if ($create || $read || $update || $delete) { ?>
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Department Name</th>
                                <th>Status</th>
                                <?php if ($update || $delete) { ?>
                                    <th>Actions</th>
                                <?php } ?>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($department as $row) { ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $row->d_name; ?></td>
                                    <td>
                                        <?php if ($row->d_status == '1') { ?>
                                            <span class="label label-primary mr6 mb6" >Active</span>
                                        <?php } else { ?>	
                                            <span class="label label-danger mr6 mb6" >InActive</span>
                                        <?php } ?>
                                    </td>
                                    <?php if ($update || $delete) { ?>
                                        <td class="menu-action">
                                            <?php 
                                            if($update) { ?>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/department_edit/<?php echo $row->d_id; ?>');" data-toggle="modal"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                            <?php } ?>
                                            
                                            <?php
                                            if($delete) { ?>
                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>department/delete/<?php echo $row->d_id; ?>');" data-toggle="modal" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                            <?php } ?>                                            
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>					
                        </tbody>
                    </table>
                <?php } ?>


            </div>
        </div>
        <!-- End .panel -->
    </div>
</div>

</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->


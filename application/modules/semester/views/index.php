<?php
$create = create_permission($permission, 'Semester');
$read = read_permission($permission, 'Semester');
$update = update_permisssion($permission, 'Semester');
$delete = delete_permission($permission, 'Semester');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <?php if ($create) { ?>
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/semester_create');" data-toggle="modal" class="links"><i class="fa fa-plus"></i> Semester</a>
                <?php } ?>

                <?php if ($create || $read || $update || $delete) { ?>
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <?php if ($update || $delete) { ?>
                                    <th>Action</th>
                                <?php } ?>                                
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($semester as $row) { ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $row->s_name; ?></td>
                                     <td>
                                        <?php if ($row->s_status == '1') { ?>
                                            <span class="label label-primary mr6 mb6" >Active</span>
                                        <?php } else { ?>	
                                            <span class="label label-danger mr6 mb6" >InActive</span>
                                        <?php } ?>
                                    </td>
                                    <?php if ($update || $delete) { ?>
                                        <td class="menu-action">
                                            <?php if ($update) { ?>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/semester_edit/<?php echo $row->s_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                            <?php } ?>

                                            <?php if ($delete) { ?>
                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>semester/delete/<?php echo $row->s_id; ?>');"  data-toggle="tooltip" data-placement="top" > <span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
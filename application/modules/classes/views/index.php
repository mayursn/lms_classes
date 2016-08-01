<?php
$create = create_permission($permission, 'Class');
$read = read_permission($permission, 'Class');
$update = update_permisssion($permission, 'Class');
$delete = delete_permission($permission, 'Class');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <?php if (create_permission($permission, 'Class')) { ?>
                    <a href="#" class="links"  onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/classes_create');" data-toggle="modal"><i class="fa fa-plus"></i> Class</a>
                <?php } ?>

                <?php if ($create || $read || $update || $delete) { ?>
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Class</th>
                                <?php if ($update || $delete) { ?>
                                    <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($classes as $row): ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $row->class_name; ?></td> 

                                    <?php if ($update || $delete) { ?>
                                        <td class="menu-action">
                                            <?php if ($update) { ?>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/classes_edit/<?php echo $row->class_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                            <?php } ?>

                                            <?php if ($delete) { ?>
                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>classes/delete/<?php echo $row->class_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
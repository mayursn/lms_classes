<?php
$create = create_permission($permission, 'Course_Category');
$read = read_permission($permission, 'Course_Category');
$update = update_permisssion($permission, 'Course_Category');
$delete = delete_permission($permission, 'Course_Category');
?>
<!-- Start .row -->
<div class=row>                     

    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
            <div class="panel-body">
                <?php if ($create) { ?>
                    <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/course_category_create');" data-toggle="modal"><i class="fa fa-plus"></i> Category</a>
                <?php } ?>

                <?php if ($create || $read || $update || $delete) { ?>
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th><?php echo ucwords("category name"); ?></th>
                                <th><?php echo ucwords("Status"); ?></th>
                                <?php if ($update || $delete) { ?>
                                    <th><?php echo ucwords("Action"); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($course_category as $row) { ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $row->category_name; ?></td>                                               

                                    <td>
                                        <?php if ($row->category_status == '1') { ?>Active
                                        <?php } else { ?>	
                                            InActive
                                        <?php } ?>
                                    </td>
                                    <?php if ($update || $delete) { ?>
                                        <td class="menu-action">
                                            <?php if ($update) { ?>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/course_category_edit/<?php echo $row->category_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                            <?php } ?>  

                                            <?php if ($delete) { ?>
                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>course_category/delete/<?php echo $row->category_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
        <!-- row --> 
    </div>
</div></div></div>

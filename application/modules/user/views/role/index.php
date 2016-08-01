<!-- Start .row -->

<?php
$create = create_permission($permission, 'User_Role');
$read = read_permission($permission, 'User_Role');
$update = update_permisssion($permission, 'User_Role');
$delete = delete_permission($permission, 'User_Role');
$create_permission = create_permission($permission, 'User_Permission');
$read_permission = read_permission($permission, 'User_Permission');
$update_permission = update_permisssion($permission, 'User_Permission');
$delete_permission = delete_permission($permission, 'User_Permission');
?>
<div class=row> 
    <div class="col-lg-12">
        <div class=" panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/user_role_create');" data-toggle="modal"><i class="fa fa-plus"></i> Role</a>
                <?php } ?>
                <?php if($create || $read || $update || $delete){ ?>

                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Role Name</th>
                            <th>Status</th>

                            <?php if( $update || $delete  || $create_permission || $read_permission || $delete_permission || $update_permission){ ?>
                            <th>Actions</th>
                            <?php } ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $role) { ?>
                            <tr>
                                <td></td>
                                <td><?php echo $role->role_name; ?></td>
                                <td>
                                    <?php
                                    if ($role->is_active == 1)
                                        echo 'Active';
                                    else
                                        echo 'Inactive';
                                    ?>
                                </td>                               
                                <?php if( $update || $delete || $create_permission || $read_permission || $delete_permission || $update_permission){ ?>
                                <td>
                                    <?php if($create_permission || $read_permission || $delete_permission || $update_permission){ ?>
                                    <a href="<?php echo base_url(); ?>user/role/permission/<?php echo $role->role_id; ?>"><span class="label label-info mr6 mb6"><i class="fa fa-plus" aria-hidden="true"></i>Permission</span></a>
                                    <?php } ?>
                                    <?php if($update && $role->role_id!='1' && $role->role_id!='2'  && $role->role_id!='3'){ ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/user_role_edit/<?php echo $role->role_id; ?>');" data-toggle="modal"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                    <?php if($delete && $role->role_id!='1' && $role->role_id!='2'  && $role->role_id!='3'){ ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>user/role/delete/<?php echo $role->role_id; ?>');" data-toggle="modal" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>    
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


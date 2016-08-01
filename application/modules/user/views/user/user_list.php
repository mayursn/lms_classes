<!-- Start .row -->
<div class=row> 
    <div class="col-lg-12">
        <div class=" panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/user_user_create');" data-toggle="modal"><i class="fa fa-plus"></i> User</a>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Role Name</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td></td>
                                <td><?php echo $user->role_name; ?></td>
                                <td><?php echo $user->first_name; ?></td>
                                <td><?php echo $user->last_name; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php echo $user->mobile; ?></td>
                                <td>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/user_user_edit/<?php echo $user->user_id; ?>');" data-toggle="modal"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>user/delete/<?php echo $user->user_id; ?>');" data-toggle="modal" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>    
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End .panel -->
    </div>
</div>

</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->


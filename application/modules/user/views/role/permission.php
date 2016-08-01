<!-- Start .row -->

<?php
$create = create_permission($permission, 'User_Permission');
$read = read_permission($permission, 'User_Permission');
$update = update_permisssion($permission, 'User_Permission');
$delete = delete_permission($permission, 'User_Permission');
$createcheckall=0;
$readcheckall=0;
$updatecheckall=0;
$deletecheckall=0;
foreach ($modules as $row) {
$user_role_permission = ['0', '0', '0', '0']; 
     
    foreach($user_permission as $permission) {
        if($permission->module_id == $row->module_id) {
            $user_role_permission = str_split($permission->user_permission); 
            if($user_role_permission[0]==1)
            {
                $createcheckall++;
            }
            if($user_role_permission[1]==1)
            {
                $readcheckall++;
            }
            if($user_role_permission[2]==1)
            {
                $updatecheckall++;
            }
            if($user_role_permission[3]==1)
            {
                $deletecheckall++;
            }
        }
    }
}
?>
<div class=row> 
    <div class="col-lg-12">
        <div class=" panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <strong><?php echo $role_details->role_name; ?></strong> Role Permission
                </div>
            </div>
           
                <?php
                if($modules!="")
                {
                    ?>
             <div class=panel-body> 
                <form id="permission-form" class="form-horizontal form-groups-bordered" method="post" 
                      action="<?php echo base_url(); ?>user/role/module_role_permission">
                    <input type="hidden" name="role_id" value="<?php echo $role_details->role_id; ?>"/>
                    <?php  if($create || $update){ ?>
                    <div class="form-group">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <button type="submit" class="btn btn-info vd_bg-green" >Submit</button>
                        </div>
                         <?php } ?>
                    </div>
                  
                   
                    <?php if($create || $read || $update || $delete){ ?>
                    <table id="permission" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            
                            <tr>                                
                                <th>No</th>
                                <th>Module Name</th>
                                <?php if($create || $update){ ?>
                                <th colspan="4">Action</th>
                                <?php } ?>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>

                                <?php if($create || $update){ ?>

                                <td>
                                    <input type="checkbox" id="createall" onclick="create_uncheck();readcheckall();" class="all-create" <?php if($createcheckall==count($modules)){echo "checked"; } ?>/><strong>Check All</strong>
                                </td>
                                <td>
                                    <input type="checkbox" id="readall" onclick="read_uncheck();" class="all-read" <?php if($readcheckall==count($modules)){echo "checked"; } ?>/><strong>Check All</strong>
                                </td>
                                <td>
                                    <input type="checkbox" id="updateall" onclick="update_uncheck();readcheckall();" class="all-update" <?php if($updatecheckall==count($modules)){echo "checked"; } ?>/><strong>Check All</strong>
                                </td>
                                <td>
                                    <input type="checkbox" id="deleteall" onclick="delete_uncheck();readcheckall();" class="all-delete" <?php if($deletecheckall==count($modules)){echo "checked"; } ?>/><strong>Check All</strong>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php $counter = 0; ?>
                            <?php foreach ($modules as $row) { ?>
                                <?php $user_role_permission = ['0', '0', '0', '0']; ?>
                            
                                <?php
                                foreach($user_permission as $permission) {
                                    if($permission->module_id == $row->module_id) {
                                        $user_role_permission = str_split($permission->user_permission);                                        
                                        break;
                                    }
                                }
                                ?>
                            
                                <tr>
                                    <td><?php echo ++$counter; ?></td>
                                    <td><?php if($row->module_name=="Exam Schedual"){echo "Exam Schedule"; }else{echo $row->module_name;} ?></td>
                                     <?php if($create || $update){ 
                                         $redcheck="";
                                         if($user_role_permission[0] == 1 || $user_role_permission[1] == 1 || $user_role_permission[2] == 1 || $user_role_permission[3] == 1)
                                         {
                                             $readcheck="checked";
                                         }
                                         else
                                         {
                                              $readcheck="";
                                         }
                                         ?>
                                    <td>
                                        <input class="create-permission" type="checkbox" name="create_<?php echo $row->module_id; ?>" id="create_<?php echo $row->module_id; ?>"
                                               <?php if($user_role_permission[0] == 1) echo 'checked'; ?> onclick="readpermission(<?php echo $row->module_id; ?>);create_check()"/>Create
                                    </td>
                                    <td>
                                        <input  class="read-permission" type="checkbox" name="read_<?php echo $row->module_id; ?>" id="read_<?php echo $row->module_id; ?>"
                                            <?php echo $readcheck; ?>   <?php if($user_role_permission[1] == 1) echo 'checked'; ?>/>Read</td>
                                    <td>
                                        <input class="update-permission" type="checkbox" name="update_<?php echo $row->module_id; ?>" id="update_<?php echo $row->module_id; ?>"
                                               <?php if($user_role_permission[2] == 1) echo 'checked'; ?> onclick="readpermission(<?php echo $row->module_id; ?>); update_check()"/>Update</td>
                                    <td><input class="delete-permission" type="checkbox" name="delete_<?php echo $row->module_id; ?>" id="delete_<?php echo $row->module_id; ?>"
                                               <?php if($user_role_permission[3] == 1) echo 'checked'; ?> onclick="readpermission(<?php echo $row->module_id; ?>); delete_check()"/>Delete</td>

                                    <?php } ?>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    <?php } ?>

                </form>
            </div>
                <?php
                }
                else
                {
                    ?>
            <br>
                 <div class=panel-heading>
                    <h4 class=panel-title> Any module not assigned to this role.</h4>
                </div>
                <?php
                }
                ?>
        </div>
        <!-- End .panel -->
    </div>
</div>
</div>

</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->

<style>
    .checkbox-custom{
        display: inline-block;
    }
</style>

<script>
    function readpermission(id)
    {
      if($('#create_'+id).is(":checked") || $('#update_'+id).is(":checked") || $('#delete_'+id).is(":checked"))
      {
            $('#read_'+id).attr('checked', true);
        }
//        else
//        {
//             $('#read_'+id).attr('checked', false);
//        }
    }
    
    function readcheckall()
    {
        if($('#createall').is(":checked") || $('#updateall').is(":checked") || $('#deleteall').is(":checked") )
        {
            $('.read-permission').prop('checked', true);
            $('#readall').attr('checked', true);
        }
//        else
//        {
//            $('.read-permission').prop('checked', false);
//            $('#readall').attr('checked', false);
//        }
    }
    function create_check()
    {
        if($('.create-permission:checked').length == $('.create-permission').length)
        {
            $('.all-create').prop('checked', true);
            $('.all-read').prop('checked', true);
        }
        else
        {
            $('.all-create').prop('checked', false);
            $('.all-read').prop('checked', false);
        }
    }
    function update_check()
    {
           if($('.update-permission:checked').length == $('.update-permission').length)
        {
            $('.all-update').prop('checked', true);
            $('.all-read').prop('checked', true);
        }
        else
        {
            $('.all-update').prop('checked', false);
            $('.all-read').prop('checked', false);
        }
        
    }
    function delete_check()
    {
          if($('.delete-permission:checked').length == $('.delete-permission').length)
        {
            $('.all-delete').prop('checked', true);
            $('.all-read').prop('checked', true);
        }
        else
        {
            $('.all-delete').prop('checked', false);
            $('.all-read').prop('checked', false);
        }
    }
    
    function create_uncheck()
    {
        if ($('.all-create:checked').length == $('.all-create').length) {
            $('.create-permission').prop('checked', true);
        } else {
            $('.create-permission').prop('checked', false);
        }
    }

    function read_uncheck() {
        if ($('.all-read:checked').length == $('.all-read').length) {
            $('.read-permission').prop('checked', true);
        } else {
            $('.read-permission').prop('checked', false);
        }
    }

    function update_uncheck() {
        if ($('.all-update:checked').length == $('.all-update').length) {
            $('.update-permission').prop('checked', true);
        } else {
            $('.update-permission').prop('checked', false);
        }
    }

    function delete_uncheck() {
        if ($('.all-delete:checked').length == $('.all-delete').length) {
            $('.delete-permission').prop('checked', true);
        } else {
            $('.delete-permission').prop('checked', false);
        }
    }
</script>


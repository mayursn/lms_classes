<?php
$create = create_permission($permission, 'Student');    
$read = read_permission($permission, 'Student');
$update = update_permisssion($permission, 'Student');
$delete = delete_permission($permission, 'Student');

?>


<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh"></div>
        <div class=panel-body>
             <?php if ($create) { ?>
                     <a class="links"  onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/student_create');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Student </a>
                <?php } ?>
                     
  <?php if ($create || $read || $update || $delete) { ?>
            <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing="0" 
                   width="100%" height="100%">
                <thead>
                    <tr>
                        <th>No</th>												
                        <th>Image</th>
                        <th>Roll No</th>
                        <th>Student Name</th>													
                        <th>Email</th>												
                        <th>Mobile</th>	
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>	
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($student as $row): ?>
                    <tr>
                        <td></td>											
                        <td>
                            <?php if ($row->user->profile_pic != "") { ?>   
                            <img src="<?php echo base_url(); ?>uploads/system_image/<?php echo $row->user->profile_pic; ?>" height="70px" width="70px
                                 "/>
                                 <?php } else { ?>
                                        <img src="<?php echo base_url('assets/img/avatar.jpg'); ?>" height="70px" width="70px"/>
                                    <?php 
                                    }
                            ?>
                        </td>
                        <td><?php echo $row->std_roll; ?></td>
                        <td><?php echo $row->user->first_name . " " . $row->user->last_name; ?></td>					
                        <td><?php echo $row->user->email; ?></td>											
                        <td><?php echo $row->user->mobile; ?></td>	
                        <td><?php echo $row->user->address; ?></td>
                        <td>
                            <?php if ($row->user->is_active == '1') { ?>
                                <span class="label label-primary mr6 mb6" >Active</span>
                            <?php } else { ?>	
                                <span class="label label-danger mr6 mb6" >InActive</span>
                            <?php } ?>
                        </td>
                        <td class="menu-action">
                            <?php 
                                 if($update) { ?>
                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/student_edit/<?php echo $row->user->user_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                               <?php } ?>

                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/student_profiledetail/<?php echo $row->std_id; ?>');" data-original-title="view" data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-desktop" ></i>View</span></a>
                        </td> 
                    </tr>
                    <?php endforeach; ?>																
                </tbody>
            </table>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- End .panel -->
</div>
<!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".dataTables_paginate.pagination").click(function () {
            alert(1);
        });
    });
</script>
<!-- Start .row -->
<!-- Start .row -->
<?php
$create = create_permission($permission, 'University_Toppers');
$read = read_permission($permission, 'University_Toppers');
$update = update_permisssion($permission, 'University_Toppers');
$delete = delete_permission($permission, 'University_Toppers');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
         
            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links"   onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/graduate_create');" data-toggle="modal"><i class="fa fa-plus"></i> Graduate</a>
                <?php } ?>
                <?php if($create || $read || $update || $delete){ ?>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="10%">Image</th>
                            <th>Student</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Graduation Year</th>
                               <?php if($update || $delete){ ?>
                            <th>Action</th>
                               <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($graduates as $row) { ?>
                            <tr>
                                <td></td>
                                <td><img class="img-circle img-responsive" src="<?php echo base_url('uploads/student_image/' . $row->std_thumb_img); ?>"/></td>
                                <td><?php echo $row->std_first_name . ' ' . $row->std_last_name; ?></td>
                                <td><?php echo $row->d_name; ?></td>
                                <td><?php echo $row->c_name; ?></td>
                                <td><?php echo $row->graduate_year; ?></td>
                                   <?php if($update || $delete){ ?>
                                <td class="menu-action">
                                       <?php if($update){ ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/graduate_edit/<?php echo $row->graduates_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                       <?php } ?>
                                    <?php if($delete){?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>graduate/delete/<?php echo $row->graduates_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
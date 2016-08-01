<?php
$create = create_permission($permission, 'Department');
$read = read_permission($permission, 'Department');
$update = update_permisssion($permission, 'Department');
$delete = delete_permission($permission, 'Department');
?>
<!-- Start .row -->
<div class=row>       
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php if ($create) { ?>
                <a class="links"  onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/chancellor_create/');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Chancellor</a>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                     <?php } ?>
                     <?php if ($create || $read || $update || $delete) { ?>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Chancellor Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Speciality</th>
                             <?php if ($update || $delete) { ?>
                                    <th>Actions</th>
                                <?php } ?> 
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($chancellor as $row):
                            ?>
                            <tr>
                                <td></td>                                    
                                <td> <img src="<?= base_url() ?>/uploads/system_image/<?= $row->people_photo; ?>" height="70" width="70" id="blah"  /></td>
                                <td><?php echo $row->people_name; ?></td>
                                <td><?php echo $row->people_phone; ?></td> 
                                <td><?php echo $row->people_email; ?></td> 
                                <td><?php echo $row->people_designation; ?></td> 
                                  <?php if ($update || $delete) { ?>
                                <td class="menu-action">
                                     <?php 
                                            if($update) { ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/chancellor_edit/<?php echo $row->university_people_id;?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                            
                                <?php
                                if($delete) { ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>chancellor/delete/<?php echo $row->university_people_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
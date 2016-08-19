<?php
$create = create_permission($permission, 'Holiday');
$read = read_permission($permission, 'Holiday');
$update = update_permisssion($permission, 'Holiday');
$delete = delete_permission($permission, 'Holiday');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh"></div>
        <div class=panel-body>
            <?php if ($create) { ?>
            <a class="links" href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/holiday_create/');" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Holiday</a>
               <?php } ?>
              <?php if ($create || $read || $update || $delete) { ?>
            <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Holiday Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Year</th>
                        <th>Status</th>
                        <?php if ($update || $delete) { ?>
                                    <th>Actions</th>
                                <?php } ?> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($holiday as $row):
                        ?>
                        <tr>
                            <td></td>
                            <td><?php echo $row->holiday_name; ?></td>    
                            <td><?php echo date('F d, Y', strtotime($row->holiday_startdate)); ?></td>    
                            <td><?php echo date('F d, Y', strtotime($row->holiday_enddate)); ?></td>    
                            <td><?php echo $row->holiday_year; ?></td>   
                            <td>
                                <?php if ($row->holiday_status == '1') { ?>
                                    <span class="label label-primary mr6 mb6" >Active</span>
                                <?php } else { ?>	
                                    <span class="label label-danger mr6 mb6" >InActive</span>
                                <?php } ?>
                            </td>
                             <?php if ($update || $delete) { ?>
                            <td class="menu-action">
                                <?php 
                                            if($update) { ?>
                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/holiday_edit/<?php echo $row->holiday_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                <?php } ?>
                                            
                                <?php
                                if($delete) { ?>
                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>holiday/delete/<?php echo $row->holiday_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>	
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
<?php
$create = create_permission($permission, 'Subject');

$read = read_permission($permission, 'Subject');
$update = update_permisssion($permission, 'Subject');
$delete = delete_permission($permission, 'Subject');
?>
<!-- Middle Content Start -->    
<!-- Start .row -->
<div class=row>                      

    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
            <div class="panel-body">
                <?php if ($create) { ?>
                <a class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_create/');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Subject</a>
                 <?php } ?>
                
                <div id="getresponse">
                    
                <?php if ($create || $read || $update || $delete) { ?>
                <table class="table table-striped table-responsive table-bordered" id="datatable-list" >
                    <thead>
                        <tr>
                            <th>No</th>											
                            <th><?php echo ucwords("Subject Name"); ?></th>											
                            <th><?php echo ucwords("Subject Code"); ?></th>	
                            <th><?php echo ucwords("status"); ?></th>	
                            <th>Actions</th>								
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($subject as $row):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>	
                                <td><?php echo $row->subject_name; ?></td>												
                                <td><?php echo $row->subject_code; ?></td>						                                             
				 <td>
                                    <?php if ($row->sm_status == '1') { ?>
                                        <span class="label label-primary mr6 mb6" >Active</span>
                                    <?php } else { ?>	
                                        <span class="label label-danger mr6 mb6" >InActive</span>
                                    <?php } ?>
                                </td>
                                <td class="menu-action">
                                      <?php 
                                            if($update) { ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_edit/<?php echo $row->sm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                            
                                <?php
                                if($delete) { ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>subject/delete/<?php echo $row->sm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                   <?php } ?>   
                                    <a href="<?php echo base_url(); ?>subject/subject_detail/<?php echo $row->sm_id; ?>" data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6">Subject Detail</span></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>						
                    </tbody>
                 </table>
                     <?php } ?>
                </div>
            </div>
        </div>
        <!----TABLE LISTING ENDS--->

    </div>
</div>
</div></div>

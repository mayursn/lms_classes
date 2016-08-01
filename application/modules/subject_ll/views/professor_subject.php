<?php
$create = create_permission($permission, 'Subject');
$read = read_permission($permission, 'Subject');
$update = update_permisssion($permission, 'Subject');
$delete = delete_permission($permission, 'Subject');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                 <?php if ($create) { ?>
                <a class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_create/');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Subject</a>
                 <?php } ?>
                
                 <?php if ($create || $read || $update || $delete) { ?>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>											
                            <th>Subject Name</th>											
                            <th>Subject Code</th>											
                            <th>Branch</th>											
                            <th>Semester</th>		
                            <th>Action</th>		
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($subject as $row): ?>
                            <tr>
                                <td></td>	
                                <td><?php echo $row->subject_name; ?></td>												
                                <td><?php echo $row->subject_code; ?></td>
                                <td>
                                    <?php
                                    foreach ($course as $crs) {
                                        if ($crs->course_id == $row->course_id) {
                                            echo $crs->c_name;
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($semester as $sem) {
                                        if ($sem->s_id == $row->sem_id) {
                                            echo $sem->s_name;
                                        }
                                    }
                                    ?>

                                </td>
                                <td>
                                     <?php 
                                            if($update) { ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_edit/<?php echo $row->sm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                            
                                <?php
                                if($delete) { ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>subject/delete/<?php echo $row->sm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                   <?php } ?>   
                                    <a href="<?php echo base_url(); ?>subject/subject_detail/<?php echo $row->sm_id; ?>" data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6">Subject Detail</span></a>
                               
                                </td>
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
<?php
$create = create_permission($permission, 'Professor');
$read = read_permission($permission, 'Professor');
$update = update_permisssion($permission, 'Professor');
$delete = delete_permission($permission, 'Professor');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
            <div class=panel-body>
                <?php if ($create) { ?>
                <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/professor_create');" data-toggle="modal"><i class="fa fa-plus"></i> Staff</a>                
                <?php } ?>
                 <?php if ($create || $read || $update || $delete) { ?>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Professor Name</th>
                            <th width="10%">Email</th>
                            <th>Mobile</th>
                            <th width="15%">Address</th>
                            <th>Designation</th>
                            <th>DOB</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($professor as $row): ?>
                            <tr>
                                <td></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td><?php echo $row->mobile; ?></td>
                                <td><?php echo $row->address; ?></td>
                                <td><?php echo $row->designation; ?></td>
                                <td><?php echo date('M d, Y', strtotime($row->dob)); ?></td>
                                <td class="menu-action">
                                     <?php 
                                            if($update) { ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/professor_edit/<?php echo $row->professor_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                            
                                    <?php
                                    if($delete) { ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>professor/delete/<?php echo $row->professor_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                     <?php } ?>   
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/professor_subject/<?php echo $row->user_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6">Subject</span></a>
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
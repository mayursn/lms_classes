<?php
$create = create_permission($permission, 'Event');
$read = read_permission($permission, 'Event');
$update = update_permisssion($permission, 'Event');
$delete = delete_permission($permission, 'Event');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle"></div>
        <div class=panel-body>
            <?php if ($create) { ?>
            <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/event_create');" data-toggle="modal"><i class="fa fa-plus"></i> Event</a>
            <?php } ?>
            <?php if ($create || $read || $update || $delete) { ?>
            <table id="event-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Event Name</th>
                        <th>Location</th>
                        <th>Event Date</th>
                        <th>Event Time</th>
<th>Status</th>
                        <?php if ($update || $delete) { ?>
                        <th>Action</th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $counter = 0;
                    foreach ($events as $row):
                        ?>
                        <tr>
                            <td><?php echo ++$counter; ?></td>
                            <td><?php echo $row->event_name; ?></td>
                            <td><?php echo $row->event_location; ?></td>                          
                            <td><?php echo date_formats($row->event_date); ?></td> 
                            <td><?php echo date('h:i A', strtotime($row->event_date)); ?></td> 
                            <td>
                                 <?php if ($row->status == '1') { ?>
                                     <span class="label label-primary mr6 mb6" >Active</span>
                                 <?php } else { ?>	
                                     <span class="label label-danger mr6 mb6" >InActive</span>
                                 <?php } ?>
                            </td>
                            <?php if ($update || $delete) { ?>
                            <td class="menu-action">
                                 <?php if($update) { ?>
                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/event_edit/<?php echo $row->event_id; ?>');" data-toggle="modal"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                 <?php } ?>
                            <?php if ($delete) { ?>    
                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>event/delete/<?php echo $row->event_id; ?>');" data-toggle="modal" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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

<script>
    $(document).ready(function () {
        $('#event-datatable-list').DataTable({"language": { "emptyTable": "No data available" }});
    });
</script>

<?php
$create = create_permission($permission, 'Student');
$read = read_permission($permission, 'Student');
$update = update_permisssion($permission, 'Student');
$delete = delete_permission($permission, 'Student');

?>

  <?php if ($create || $read || $update || $delete) { ?>
<table id="datatable-list2" class="table table-striped table-bordered table-responsive text-center" cellspacing=0 width=100%>
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
                    <?php if ($row->user->profile_pic != '') { ?>
                        <img src="<?= base_url() ?>uploads/system_image/<?php echo $row->user->profile_pic; ?>" height="70px" width="70px"/>
                        <?php
                    } else {
                        ?>
                        <img src="<?= base_url('assets/img/avatar.jpg') ?>" height="70px" width="70px"/>
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
                    
                    <a href="<?php echo base_url()?>student/student_profile/<?php echo $row->std_id; ?>" data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Student Profile</span></a>
                </td>											
            </tr>
        <?php endforeach; ?>																			
    </tbody>
</table>
<?php } ?>
</div>
<script>
    var t = $('#datatable-list2').DataTable({
        "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
        "order": [[2, 'asc']],
        "language": {"emptyTable": "No data available"}
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

</script>
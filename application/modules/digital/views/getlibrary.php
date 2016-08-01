<!-- Start .row -->
<?php
$create = create_permission($permission, 'Library');
$read = read_permission($permission, 'Library');
$update = update_permisssion($permission, 'Library');
$delete = delete_permission($permission, 'Library');
?>
  <?php if ($create || $read || $update || $delete) { ?>
<table class="table table-striped table-bordered table-responsive" cellspacing=0 width=100% id="data-tables">
    <thead>
        <tr>

            <th>No</th>												
            <th>Library Name</th>
            <th>Department</th>
            <th>Branch</th>												
            <th>Batch</th>												
            <th>Semester</th>												
            <th>File</th>              
            <?php if ( $update || $delete) { ?>
                            <th>Action</th>	
                            <?php } ?>									
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        foreach ($library as $row):
            ?>
            <tr>
                <td><?php echo $count++; ?></td>	
                <td><?php echo $row->lm_title; ?></td>	
                <td><?php
                    if ($row->lm_degree != 'All') {
                        foreach ($degree as $dgr):
                            if ($dgr->d_id == $row->lm_degree):
                                echo $dgr->d_name;
                            endif;
                        endforeach;
                    }else {
                        echo 'All';
                    }
                    ?></td>
                <td>
                    <?php
                    if ($row->lm_course != 'All') {
                        foreach ($course as $crs) {
                            if ($crs->course_id == $row->lm_course) {
                                echo $crs->c_name;
                            }
                        }
                    } else {
                        echo 'All';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($row->lm_batch != 'All') {
                        foreach ($batch as $bch) {
                            if ($bch->b_id == $row->lm_batch) {
                                echo $bch->b_name;
                            }
                        }
                    } else {
                        echo "All";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($row->lm_semester != 'All') {
                        foreach ($semester as $sem) {
                            if ($sem->s_id == $row->lm_semester) {
                                echo $sem->s_name;
                            }
                        }
                    } else {
                        echo "All";
                    }
                    ?>													
                </td>	
                <td><a href="<?php echo base_url() . 'uploads/project_file/'.$row->lm_filename; ?>" download="" target="_blank" title="<?php echo $row->lm_filename; ?>"><i class="fa fa-download"></i></a></td>	             
<?php if($update || $delete){ ?>
                <td class="menu-action">
                    <?php if($update){ ?>
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/digital_edit/<?php echo $row->lm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                    <?php } ?>
                    <?php if($delete){ ?>
                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>digital/delete/<?php echo $row->lm_id; ?>');" title="Remove" data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>	
                    <?php } ?>
                </td>	
<?php } ?>
            </tr>
        <?php endforeach; ?>						
    </tbody>
</table>
  <?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        "use strict";
        $('#data-tables').dataTable({"language": { "emptyTable": "No data available" }});
    });
    $(document).ready(function () {
        "use strict";
        $('#data-tabless').dataTable({"language": { "emptyTable": "No data available" }});
    });
</script>
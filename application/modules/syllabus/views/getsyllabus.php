<!-- Start .row -->
<?php
$create = create_permission($permission, 'Syllabus');
$read = read_permission($permission, 'Syllabus');
$update = update_permisssion($permission, 'Syllabus');
$delete = delete_permission($permission, 'Syllabus');
?>
<?php if($create || $read || $update || $delete){ ?>


<table class="table table-striped table-bordered table-responsive" cellspacing=0 width=100% id="datatable-list">
    <thead>
        <tr>
            <th>No</th>												
            <th><div><?php echo ucwords("Syllabus Title"); ?></div></th>
            <th><div><?php echo ucwords("department"); ?></div></th>
            <th><div><?php echo ucwords("Branch"); ?></div></th>												                                                
            <th><div><?php echo ucwords("Semester"); ?></div></th>
            <th><div><?php echo ucwords("Description"); ?></div></th>
            <th><div><?php echo ucwords("File"); ?></div></th>         
            <?php if($update || $delete){ ?>
            <th><div><?php echo ucwords("Action"); ?></div></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        foreach ($syllabus as $row):
            ?>
            <tr>
                <td><?php echo $count++; ?></td>	

                <td><?php echo $row->syllabus_title; ?></td>	
                <td><?php
                    foreach ($degree as $dgr):
                        if ($dgr->d_id == $row->syllabus_degree):

                            echo $dgr->d_name;
                        endif;


                    endforeach;
                    ?></td>
                <td>
                    <?php
                    foreach ($course as $crs) {
                        if ($crs->course_id == $row->syllabus_course) {
                            echo $crs->c_name;
                        }
                    }
                    ?>
                </td>

                <td>
                    <?php
                    foreach ($semester as $sem) {
                        if ($sem->s_id == $row->syllabus_sem) {
                            echo $sem->s_name;
                        }
                    }
                    ?>													
                </td>	
                <td><?php echo wordwrap($row->syllabus_desc, 30, "<br>\n"); ?></td>
                <td id="downloadedfile"><a href="<?php echo base_url() . 'uploads/syllabus/' . $row->syllabus_filename; ?>" download="" title="<?php echo $row->syllabus_title; ?>"><i class="fa fa-download"></i></a></td>	                                                  
                <?php if($update || $delete){ ?>
                <td class="menu-action">
                    <?php if($update){ ?>
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/syllabus_edit/<?php echo $row->syllabus_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                    <?php } ?>
                    <?php if($delete){ ?>
                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>syllabus/delete/<?php echo $row->syllabus_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>	
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
        $('#datatable-list').dataTable({"language": { "emptyTable": "No data available" }});
    });
    $(document).ready(function () {
        "use strict";
        $('#data-tabless').dataTable({"language": { "emptyTable": "No data available" }});
    });
</script>

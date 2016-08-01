<?php if ($param == 'allproject') { ?>
<!-- Start .row -->
<!-- Start .row -->
<?php
$create = create_permission($permission, 'Project');
$read = read_permission($permission, 'Project');
$update = update_permisssion($permission, 'Project');
$delete = delete_permission($permission, 'Project');
?>
    <?php if($create || $read || $update || $delete){ ?>
    <table class="table table-striped table-bordered table-responsive" cellspacing=0 width=100% id="data-tables">
        <thead>
            <tr>
                <th>No</th>											
                <th>Project Title</th>
                <th>Student Name</th>											
                <th>Department</th>	
                <th>Branch</th>
                <th>Batch</th>											
                <th>Semester</th>
                <th><?php echo ucwords("class"); ?></th>
                <th>File</th>
                <th>Date of submission</th>			
                <?php if($update || $delete){ ?>
                <th>Action</th>	
                 <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($project as $row):
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>	
                    <td><?php echo $row->pm_title; ?></td>	
                    <td>
                        <?php
                        $stu = explode(',', $row->pm_student_id);
                        $i = 1;

                        foreach ($student as $std) {


                            if (in_array($std->std_id, $stu)) {

                                if ($i < 3) {
                                    echo $std->std_first_name . '&nbsp' . $std->std_last_name . ', ';
                                }
                                $i++;
                            }
                        }
                        if (count($stu) > 2) {
                            ?>
                            <a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/view_student_name/<?php echo $row->pm_id; ?>');" style="cursor:pointer; text-decoration: none;">Read More</a>
                            <?php
                        }
                        ?>
                    </td>  
                    <td>
                        <?php
                        foreach ($degree as $deg) {
                            if ($deg->d_id == $row->pm_degree) {
                                echo $deg->d_name;
                            }
                        }
                        ?>
                    </td>	
                    <td>
                        <?php
                        foreach ($course as $crs) {
                            if ($crs->course_id == $row->pm_course) {
                                echo $crs->c_name;
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($batch as $bch) {
                            if ($bch->b_id == $row->pm_batch) {
                                echo $bch->b_name;
                            }
                        }
                        ?>
                    </td>	
                    <td>
                        <?php
                        foreach ($semester as $sem) {
                            if ($sem->s_id == $row->pm_semester) {
                                echo $sem->s_name;
                            }
                        }
                        ?>

                    </td>
                    <td>
                        <?php
                        foreach ($class as $c) {
                            if ($c->class_id == $row->class_id) {
                                echo $c->class_name;
                            }
                        }
                        ?>
                    </td>
                    <td id="downloadedfile"> 
                        <?php
                        if (!empty($row->pm_filename)) {
                            $all_files = explode(",", $row->pm_filename);
                            foreach ($all_files as $p_file):
                                ?>                                                    
                                <a href="<?php echo base_url() . 'uploads/project_file/' . $p_file; ?>" download="" title="download"><i class="fa fa-download"></i></a>

                                <?php
                            endforeach;
                        }
                        ?>
                    </td>
                    <td><?php echo date_formats($row->pm_dos); ?></td>	
                <?php if($update  || $delete){ ?>
                    <td class="menu-action">
                        <?php  if($update){?>
                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/project_edit/<?php echo $row->pm_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                        <?php } ?>
                        <?php if($delete){ ?>
                        <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>project/delete/<?php echo $row->pm_id; ?>');" title="Remove" data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>	
                        <?php } ?>

                    </td>	
                <?php  } ?>
                </tr>
            <?php endforeach; ?>						
        </tbody> 
    </table>

<script type="text/javascript">
    $(document).ready(function () {
        "use strict";
        $('#data-tables').dataTable({"language": {"emptyTable": "No data available"}});
    });   
</script>
<?php } ?>
    <?php
}
if ($param == 'submitted') {
    ?>

    <table class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%  id="data-tabless">
        <thead>
            <tr>
                <th>No</th>												
                <th>Project Title</th>
                <th>Student Name</th>                                                											
                <th>Department</th>	
                <th>Branch</th>
                <th>Batch</th>											
                <th>Semester</th>
                <th>Submitted date</th>
                <th>Comment</th>
                <th>Action</th>												                                            
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($submitedproject as $rowsub):
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $rowsub->pm_title; ?></td>
                    <td><?php echo $rowsub->std_first_name . '&nbsp' . $rowsub->std_last_name . ', '; ?></td>	
                    <td>
                        <?php
                        foreach ($degree as $deg) {
                            if ($deg->d_id == $rowsub->pm_degree) {
                                echo $deg->d_name;
                            }
                        }
                        ?>
                    </td>	
                    <td>
                        <?php
                        foreach ($course as $crs) {
                            if ($crs->course_id == $rowsub->pm_course) {
                                echo $crs->c_name;
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($batch as $bch) {
                            if ($bch->b_id == $rowsub->pm_batch) {
                                echo $bch->b_name;
                            }
                        }
                        ?>
                    </td>	
                    <td>
                        <?php
                        foreach ($semester as $sem) {
                            if ($sem->s_id == $rowsub->pm_semester) {
                                echo $sem->s_name;
                            }
                        }
                        ?>

                    </td>	
                    <td><?php echo date_formats($rowsub->dos); ?></td>	
                    <td><?php echo $rowsub->description; ?></td>
                    <td id="downloadedfile"> 
                        <?php
                        if (!empty($rowsub->document_file)) {
                            $all_files = explode(",", $rowsub->document_file);
                            foreach ($all_files as $p_file):
                                ?>                                                    
                                <a href="<?php echo base_url() . 'uploads/project_file/' . $p_file; ?>" download="" title="download"><i class="fa fa-download"></i></a>

                                <?php
                            endforeach;
                        }
                        ?>
                    </td>    
                </tr>
            <?php endforeach; ?>						
        </tbody>
    </table>


<script type="text/javascript">
    
<script type="text/javascript">  
    $(document).ready(function () {
        "use strict";
        $('#data-tabless').dataTable({"language": {"emptyTable": "No data available"}});
    });
</script>
<?php } ?>


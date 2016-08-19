<!-- Start .row -->
<!-- Start .row -->
<?php
$create = create_permission($permission, 'Project');
$read = read_permission($permission, 'Project');
$update = update_permisssion($permission, 'Project');
$delete = delete_permission($permission, 'Project');
 $this->load->model('classes/Class_model');
                                            $class = $this->Class_model->order_by_column('class_name');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <div class="tabs mb20">
                    <ul id="import-tab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#project-list" data-toggle="tab" aria-expanded="true">Project List</a>
                        </li>
                        <li class="">
                            <a href="#submitted-project-list" data-toggle="tab" aria-expanded="false">Submitted Project List</a>
                        </li>
                    </ul>
                    <div id="import-tab-content" class="tab-content">
                        <div class="tab-pane fade active in" id="project-list">
                            <?php if($create){ ?>
                            <a class="links"  onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/project_create/');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Project</a>
                            <?php } ?>
                            <div class="row filter-row">
                                <?php if($create || $read || $update || $delete){ ?>
                                <form action="#" method="post" id="searchform">
                                    <div class="form-group col-sm-3 validating">
                                        <label>Department</label>
                                        <select id="filterdegree" name="degree" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($degree as $row) { ?>
                                                <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2 validating">
                                        <label>Branch</label>
                                        <select id="filtercourse" name="course" class="form-control">
                                            <option value="">Select</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2 validating">
                                        <label>Batch</label>
                                        <select id="filterbatch" name="batch" class="form-control">
                                            <option value="">Select</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2 validating">
                                        <label> Semester</label>
                                        <select id="filtersemester" name="semester" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($semester as $row) { ?>
                                                <option value="<?php echo $row->s_id; ?>"
                                                        ><?php echo $row->s_name; ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label><?php echo ucwords("Class"); ?><span style="color:red"></span></label>
                                        <select class="form-control filter-rows" name="filterclass" id="filterclass" >
                                            <option value="">Select</option>
                                            <?php
                                           
                                            //$this->db->select('class_id,class_name');
                                             //$this->db->get('class')->result_array();
                                            
                                            foreach ($class as $c) {
                                                ?>
                                                <option value="<?php echo $c->class_id ?>"><?php echo $c->class_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <label>&nbsp;</label><br/>
                                        <button type="submit" id="btnsubmit" class="submit btn btn-info vd_bg-green">Go</button>
                                    </div>
                                </form>
                                <?php } ?>
                            </div>
                            <div id="getresponse">
                                <?php if($create || $read || $update || $delete){ ?>
                                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                                    <thead>
                                        <tr>
                                            <th>No</th>											
                                            <th>Project Title</th>
                                            <th>Student</th>											
                                            <th>Department</th>	
                                            <th>Branch</th>
                                            <th>Batch</th>											
                                            <th>Semester</th>
                                            <th>Class</th>
                                            <th>File</th>
                                            <th>Submission Date</th>
					   <th>Status</th>
                                            <?php if($update || $delete){ ?>
                                            <th>Action</th>	
                                            <?php } ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($project as $row):
                                            ?>
                                            <tr>
                                                <td></td>	
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
                                                        <a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/project_studentname/<?php echo $row->pm_id; ?>');" style="cursor:pointer; text-decoration: none;">Read More</a>
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
						<td>
                                                     <?php if ($row->pm_status == '1') { ?>
                                                         <span class="label label-primary mr6 mb6" >Active</span>
                                                     <?php } else { ?>	
                                                         <span class="label label-danger mr6 mb6" >InActive</span>
                                                     <?php } ?>
                                                 </td>
                                                   <?php if($update  || $delete){ ?>
                                                <td class="menu-action">
                                                    <?php if($update ){ ?>
                                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/project_edit/<?php echo $row->pm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                                    <?php } ?>
                                                    <?php if($delete){ ?>
                                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>project/delete/<?php echo $row->pm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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

                        <!-- tab content -->
                        <div class="tab-pane fade" id="submitted-project-list">
                            <div class="row filter-row">
                                <form action="#" method="post" id="searchform-submitted">
                                    <div class="form-group col-sm-3 validating">
                                        <label>Department</label>
                                        <select id="submit-course" name="degree" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($degree as $row) { ?>
                                                <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3 validating">
                                        <label>Branch</label>
                                        <select id="submit-branch" name="course" class="form-control">
                                            <option value="">Select</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2 validating">
                                        <label>Batch</label>
                                        <select id="submit-batch" name="batch" class="form-control">
                                            <option value="">Select</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2 validating">
                                        <label> Semester</label>
                                        <select id="submit-semester" name="semester" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($semester as $row) { ?>
                                                <option value="<?php echo $row->s_id; ?>"
                                                        ><?php echo $row->s_name; ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2" style="display: none;">
                                        <label><?php echo ucwords("Class"); ?><span style="color:red"></span></label>
                                        <select class="form-control filter-rows" name="filterclass" id="submit-class" >
                                            <option value="">Select</option>
                                            <?php
                                          
                                            foreach ($class as $c) {
                                                ?>
                                                <option value="<?php echo $c->class_id; ?>"><?php echo $c->class_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <label>&nbsp;</label><br/>
                                        <button type="submit" id="btnsubmitted" class="submit btn btn-info vd_bg-green">Go</button>
                                    </div>
                                </form>
                            </div>
                            <div id="getsubmit">
                                <table class="table table-striped table-bordered table-responsive" id="sub-tables">
                                    <thead>
                                        <tr>

                                            <th>No</th>												
                                            <th><?php echo ucwords("Project Title"); ?></th>
                                            <th><?php echo ucwords("Student Name"); ?></th>                                                											
                                            <th><?php echo ucwords("department"); ?></th>	
                                            <th><?php echo ucwords("Branch"); ?></th>
                                            <th><?php echo ucwords("Batch"); ?></th>											
                                            <th><?php echo ucwords("Semester"); ?></th>
                                            <th><?php echo ucwords("Submitted date"); ?></th>
                                            <th><?php echo ucwords("Comment"); ?></th>
                                            <th><?php echo ucwords("File"); ?></th>												                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($submitedproject->result() as $rowsub):
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
                            </div>
                        </div>

                    </div>

                </div>
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

    $("#searchform #btnsubmit").click(function () {
        var degree = $("#filterdegree").val();
        var course = $("#filtercourse").val();
        var batch = $("#filterbatch").val();
        var semester = $("#filtersemester").val();
        var divclass = $("#filterclass").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>project/getprojects/allproject",
            data: {'degree': degree, 'course': course, 'batch': batch, "semester": semester, "divclass": divclass},
            success: function (response)
            {
                $("#getresponse").html(response);
            }


        });
        return false;
    });
    $('#filterdegree').on('change', function () {
        var department_id = $(this).val();
        department_branch(department_id);
    });
    $('#filtercourse').on('change', function () {
        var branch_id = $(this).val();
        var department = $('#filterdegree').val();
        batch_form_department_branch(department, branch_id);
        semester_from_branch(branch_id);
    });

    function department_branch(department_id) {
        $('#filtercourse').find('option').remove().end();
        $('#filtercourse').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
            type: 'GET',
            success: function (content) {                
                var branch = jQuery.parseJSON(content);
                console.log(branch);
                $.each(branch, function (key, value) {
                    $('#filtercourse').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                });
            }
        });
    }

    function batch_form_department_branch(department, branch) {
        $('#filterbatch').find('option').remove().end();
        $('#filterbatch').append('<option value>Select</option>');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>batch/department_branch_batch/" + department + '/' + branch,
            success: function (response) {
                var branch = jQuery.parseJSON(response);
                $.each(branch, function (key, value) {
                    $('#filterbatch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                });
            }
        });
    }

    function semester_from_branch(branch) {
        $('#filtersemester').find('option').remove().end();
        $('#filtersemester').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
            type: 'GET',
            success: function (content) {
                var semester = jQuery.parseJSON(content);
                $.each(semester, function (key, value) {
                    $('#filtersemester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                });
            }
        });
    }
</script>

<script>


    $(document).ready(function () {

        $("#searchform-submitted #btnsubmitted").click(function () {
            var degree = $("#submit-course").val();
            var course = $("#submit-branch").val();
            var batch = $("#submit-batch").val();
            var semester = $("#submit-semester").val();
            var divclass = $("#submit-class").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>project/getprojects/submitted",
                data: {'degree': degree, 'course': course, 'batch': batch, "semester": semester, "divclass": divclass},
                success: function (response)
                {
                    $("#getsubmit").html(response);
                }


            });
            return false;
        });
        $('#submit-course').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });
        $('#submit-branch').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#submit-course').val();
            batch_form_department_branch(department, branch_id);
            semester_from_branch(branch_id);
        });

        function department_branch(department_id) {
            $('#submit-branch').find('option').remove().end();
            $('#submit-branch').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#submit-branch').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        }

        function batch_form_department_branch(department, branch) {
            $('#submit-batch').find('option').remove().end();
            $('#submit-batch').append('<option value>Select</option>');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>batch/department_branch_batch/" + department + '/' + branch,
                success: function (response) {
                    var branch = jQuery.parseJSON(response);
                    $.each(branch, function (key, value) {
                        $('#submit-batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            });
        }

        function semester_from_branch(branch) {
            $('#submit-semester').find('option').remove().end();
            $('#submit-semester').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
                type: 'GET',
                success: function (content) {
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#submit-semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    });
                }
            });
        }
        $('#project-data-tables').dataTable({"language": {"emptyTable": "No data available"}});
        $('#sub-tables').dataTable({"language": {"emptyTable": "No data available"}});

    });
</script>


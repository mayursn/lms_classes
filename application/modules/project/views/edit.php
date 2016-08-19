<?php

$this->load->model('project/Project_manager_model');
$this->load->model('student/Student_model');
$row = $this->Project_manager_model->get($param2);

    ?>

    <div class=row>
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle panelMove panelClose panelRefresh">
                <!-- Start .panel -->
                <!--            <div class=panel-heading>
                                    <h4 class=panel-title>  <?php echo ucwords("Update Project"); ?></h4>                
                                </div>                 -->
                <div class="panel-body">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content">  
                            <div class="">
                                <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                            </div>  
                            <?php echo form_open(base_url() . 'project/update/' . $row->pm_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmeditproject', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Project Title"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" id="title2"  value="<?php echo $row->pm_title; ?>"/>
                                </div>
                                <lable class="error" id="error_lable_exist" style="color:#f85d2c"></lable>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="degree" id="degree2" class="form-control">
                                        <option value="">Select department</option>
                                        <?php
                                        $this->load->model('department/Degree_model');
                                        $datadegree = $this->Degree_model->order_by_column('d_name');
                                        foreach ($datadegree as $rowdegree) {
                                            if ($rowdegree->d_id == $row->pm_degree) {
                                                ?>
                                                <option value="<?= $rowdegree->d_id ?>" selected><?= $rowdegree->d_name ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $rowdegree->d_id ?>"><?= $rowdegree->d_name ?></option>							
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="course" id="course2" class="form-control">
                                        <option value="">Select Branch</option>
                                        <?php
                                        $this->load->model('branch/Course_model');
                                        $course  = $this->Course_model->get_many_by( array('course_status' => 1, 'degree_id' => $row->pm_degree));                                        
                                        foreach ($course as $crs) {
                                            if ($crs->course_id == $row->pm_course) {
                                                ?>
                                                <option value="<?= $crs->course_id ?>" selected><?= $crs->c_name ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $crs->course_id ?>" ><?= $crs->c_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Batch"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="batch"  id="batch2" onchange="get_student(this.value);" class="form-control">
                                        <option value="">Select batch</option>
                                        <?php
                                        $pm_degree = $row->pm_degree;
                                        $pm_course = $row->pm_course;
                                        $this->load->model('batch/Batch_model');
                                        $databatch = $this->Batch_model->department_branch_batch($pm_degree,$pm_course);
                                        //$databatch = $this->db->query("SELECT * FROM batch WHERE b_status=1 AND FIND_IN_SET('" .  . "',degree_id) AND FIND_IN_SET('" .  . "',course_id)")->result();
                                        foreach ($databatch as $row1) {
                                            if ($row1->b_id == $row->pm_batch) {
                                                ?>
                                                <option value="<?= $row1->b_id ?>" selected><?= $row1->b_name ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $row1->b_id ?>" ><?= $row1->b_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>	
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="semester"  id="semester2" class="form-control"  >
                                        <option value="">Select semester</option>
                                        <?php
                                        $this->load->model('semester/Semester_model');
                                        $datasem = $this->Semester_model->get_all();
                                        
                                        foreach ($datasem as $rowsem) {
                                            if ($rowsem->s_id == $row->pm_semester) {
                                                ?>
                                                <option value="<?= $rowsem->s_id ?>" selected><?= $rowsem->s_name ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $rowsem->s_id ?>" ><?= $rowsem->s_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("class"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="class2" id="class2" onchange="get_students(this.value);" class="form-control">
                                        <option value="">Select class</option>
                                        <?php
                                        $this->load->model('classes/class_model');
                                        $class = $this->class_model->order_by_column('class_name');
                                        

                                        foreach ($class as $c) {
                                            if ($c->class_id == $row->class_id) {
                                                ?>
                                                <option selected value="<?php echo $c->class_id; ?>"><?php echo $c->class_name ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?php echo $c->class_id ?>"><?php echo $c->class_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">


                                <label class="col-sm-4 control-label"><?php echo ucwords("Student"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="checkbox" name="checkall" id="checkAll2"  >Check All<br>
                                    <div id="student2">
                                        <?php
                                        $stu = explode(',', $row->pm_student_id);

                                        $datastudent = $this->Student_model->get_many_by( array(
                                                    'std_degree' => $row->pm_degree,
                                                    'course_id' => $row->pm_course,
                                                    'std_batch' => $row->pm_batch,
                                                    'semester_id' => $row->pm_semester,
                                                    'class_id' => $row->class_id));

                                        foreach ($datastudent as $rowstu) {
                                            if (in_array($rowstu->std_id, $stu)) {
                                                ?>
                                                <div class="checkedstudent"> <input type="checkbox" name="student[]" value="<?php echo $rowstu->std_id; ?>" checked=""><?php echo $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name; ?> </div>                                               
                                            <?php } else { ?>
                                                <div class="checkedstudent"><input type="checkbox" name="student[]" value="<?php echo $rowstu->std_id; ?>" ><?php echo $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name; ?></div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <label class="error" id="error_std" for="student[]"></label>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Date of Submission"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="" class="form-control" name="dateofsubmission1" id="dateofsubmission1" value="<?php echo date_formats($row->pm_dos); ?>"/>
                                </div>
                            </div>
                          <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="description" id="description" ><?php echo $row->pm_desc; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("File Upload"); ?></label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="txtoldfile" id="txtoldfile" value="<?php echo $row->pm_filename; ?>" />
                                    <input type="file" class="form-control" multiple="" name="projectfile[]" id="projectfile" />
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("status");?></label>
                                <div class="col-sm-8">
                                    <select name="status"  class="form-control">
                                      <option value="1" <?php if($row->pm_status == '1'){ echo "selected"; } ?>>Active</option>
                                        <option value="0" <?php if($row->pm_status == '0'){ echo "selected"; } ?>>Inactive</option>	
                                    </select>
                                    <lable class="error" id="error_lable_exist" style="color:red"></lable>

                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" id="btnupd" class="submit btn btn-info vd_bg-green"><?php echo ucwords("Update"); ?></button>
                                </div>
                            </div>
                            </form>
                        </div> </div> </div>
            </div>
        </div>
    </div>

<script type="text/javascript">

    $("#btnupd").click(function (event) {
        if ($("#degree2").val() != null & $("#course2").val() != null & $("#batch2").val() != null & $("#semester2").val() != null & $("#title2").val() != null)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'project/checkprjectsedit/' . $param2; ?>",
                dataType: 'json',
                data:
                        {
                            'degree': $("#degree2").val(),
                            'course': $("#course2").val(),
                            'batch': $("#batch2").val(),
                            'semester': $("#semester2").val(),
                            'title': $("#title2").val(),
                        },
                success: function (response) {
                    if (response.length == 0) {
                        $("#error_lable_exist").html('');
                        $('#frmeditproject').attr('validated', true);
                        $('#frmeditproject').submit();
                    } else
                    {
                        $("#error_lable_exist").html('Project is already present in the system');
                        return false;
                    }
                }
            });
            return false;
        }
        event.preventDefault();
    });
    $("#checkAll2").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
    function get_student(batch, semester = '') {
        var batch = $("#batch2").val();
        var course = $("#course2").val();
        var degree = $("#degree2").val();
        var semester = $("#semester2").val();
        var param = '<?php echo $param2; ?>';
        $.ajax({
            url: '<?php echo base_url(); ?>project/batchwisestudentcheckbox/' + param,
            type: 'POST',
            data: {'batch': batch, 'sem': semester, 'course': course, 'degree': degree},
            success: function (content) {
                $("#student2").html(content);
            }
        });
    }

    function get_students(divclass)
    {

        var batch = $("#batch2").val();
        var course = $("#course2").val();
        var degree = $("#degree2").val();
        var sem = $("#semester2").val();
        var param = '<?php echo $param2; ?>';

        $.ajax({
            url: '<?php echo base_url(); ?>project/checkboxstudent/' + param,
            type: 'POST',
            data: {'batch': batch, 'sem': sem, 'course': course, 'degree': degree, 'divclass': divclass},
            success: function (content) {
                //alert(content);
                $("#student2").html(content);
            }
        });

    }


  $('#degree2').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
            
                $("#student2").html('');
                $('#course2').prop('selectedIndex', 0);
                $('#batch2').prop('selectedIndex', 0);
                $('#semester2').prop('selectedIndex', 0);
                $('#class2').prop('selectedIndex', 0);
        });
        $('#course2').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#degree2').val();
            batch_form_department_branch(department, branch_id);
            semester_from_branch(branch_id);
             $("#student2").html('');
                        $('#batch2').prop('selectedIndex', 0);
                        $('#semester2').prop('selectedIndex', 0);
                        $('#class2').prop('selectedIndex', 0);
        });
        
        function department_branch(department_id) {
            $('#course2').find('option').remove().end();
            $('#course2').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#course2').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        }

        function batch_form_department_branch(department, branch) {
            $('#batch2').find('option').remove().end();
            $('#batch2').append('<option value>Select</option>');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>batch/department_branch_batch/" + department + '/' + branch,
                success: function (response) {
                    var branch = jQuery.parseJSON(response);
                    $.each(branch, function (key, value) {
                        $('#batch2').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            });
        }

        function semester_from_branch(branch) {
            $('#semester2').find('option').remove().end();
            $('#semester2').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
                type: 'GET',
                success: function (content) {
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#semester2').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    });
                }
            });
        } 
   
    $('#batch2').change(function () {
        $('#semester2').prop('selectedIndex', 0);
        $('#class2').prop('selectedIndex', 0);
        $("#student2").html('');
    });
    $("#semester2").change(function () {
        $("#student2").html('');
        $('#class2').prop('selectedIndex', 0);
    });




    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        $("#dateofsubmission1").datepicker({
            format: js_date_format, startDate: new Date(),
            minDate: 0,
            autoclose: true,
        });
        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("url", function (value, element) {
            return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
        }, 'Please enter a valid URL.');

        $("#frmeditproject").validate({
            rules: {
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                class2: "required",
                'student[]': "required",
                dateofsubmission1: "required",
                pageurl:
                        {
                            required: true,
                            url: true,
                        },
                projectfile: {
                    extension: 'gif|jpg|png|pdf|xlsx|xls|doc|docx|ppt|pptx|pdf|txt|zip|rar',
                },
                title:
                        {
                            required: true,
                        },
            },
            messages: {
                degree: "Select department",
                course: "Select Branch",
                batch: "Select Batch",
                semester: "Select Semester",
                class2: "Select class",
                'student[]': "Select Student",
                dateofsubmission1: "Select date of submission",
                pageurl:
                        {
                            required: "Enter page url",
                        },
                projectfile: {
                    extension: 'Upload valid file!',
                },
                title:
                        {
                            required: "Enter title",
                        },
            }
        });
    });
</script>
<script type="text/javascript">function uncheck()
    {
        if ($('.checkbox1:checked').length == $('.checkbox1').length) {
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
    }</script>
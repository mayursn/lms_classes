<div class=row>
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>  <?php echo ucwords("Add Project"); ?></h4>                
                        </div>             -->
            <div class="panel-body"> 

                <div class="box-content">  

                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                      
                    <?php echo form_open(base_url() . 'project/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmproject', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Project Title"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" />
                            </div>
                            <lable class="error" id="error_lable_exist" style="color:#f85d2c"></lable>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="degree" id="degree" class="form-control" >
                                    <option value="">Select department</option>
                                    <?php
                                     $this->load->model('department/Degree_model');
                                    $datadegree = $this->Degree_model->order_by_column('d_name');
                                    foreach ($datadegree as $rowdegree) {
                                        ?>
                                        <option value="<?= $rowdegree->d_id ?>"><?= $rowdegree->d_name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="course" id="course" class="form-control" >
                                    <option value="">Select Branch</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Batch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="batch" id="batch" onchange="get_student2(this.value);" class="form-control"  >
                                    <option value="">Select batch</option>

                                </select>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="semester" id="semester"  class="form-control"  >
                                    <option value="">Select semester</option>
                                    <?php
                                    $datasem = $this->db->get_where('semester', array('s_status' => 1))->result();
                                    foreach ($datasem as $rowsem) {
                                        ?>
                                        <option value="<?= $rowsem->s_id ?>"><?= $rowsem->s_name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("class"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="class" id="class" onchange="get_students2(this.value);" class="form-control" >
                                    <option value="">Select class</option>
                                    <?php
                                    $class = $this->db->get('class')->result_array();

                                    foreach ($class as $c) {
                                        ?>
                                        <option value="<?php echo $c['class_id'] ?>"><?php echo $c['class_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Student"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="checkbox" name="checkall" id="select_all"  >Check All<br>
                                <div id="student"><input type="hidden" name="student[]" value=""  /></div>
                                <label class="error" id="error_std" for="student[]"></label>
                               <!--<select name="student[]" id="student" multiple="">
                                   <option value="">Select student</option>
                                                                                 </select>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Date of Submission"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text"  readonly="" class="form-control" name="dateofsubmission" id="dateofsubmission" />
                            </div>
                        </div>
                        <input type="hidden" class="form-control" name="pageurl" id="pageurl" />
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("File Upload"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" multiple="" name="projectfile[]" id="projectfile" />
                            </div>
                        </div>
			  <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                            <div class="col-sm-8">
                                <select name="status"  class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>	
                                </select>
                                <lable class="error" id="error_lable_exist" style="color:red"></lable>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" id="btnadd" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                            </div>
                        </div>

                    </div>     
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var js_date_format = '<?php echo js_dateformat(); ?>';
    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
    
    $("#batch").change(function () {
        $("#student").html('');
        $('#semester').prop('selectedIndex', 0);
        $('#class').prop('selectedIndex', 0);
        
    });
    $('#semester').change(function () {
        $("#student").html('');
        $('#class').prop('selectedIndex', 0);
    });
    
        $('#degree').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
            
                $("#student").html('');
                $('#course').prop('selectedIndex', 0);
                $('#batch').prop('selectedIndex', 0);
                $('#semester').prop('selectedIndex', 0);
                $('#class').prop('selectedIndex', 0);
        });
        $('#course').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#degree').val();
            batch_form_department_branch(department, branch_id);
            semester_from_branch(branch_id);
             $("#student").html('');
                        $('#batch').prop('selectedIndex', 0);
                        $('#semester').prop('selectedIndex', 0);
                        $('#class').prop('selectedIndex', 0);
        });
        
        function department_branch(department_id) {
            $('#course').find('option').remove().end();
            $('#course').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        }

        function batch_form_department_branch(department, branch) {
            $('#batch').find('option').remove().end();
            $('#batch').append('<option value>Select</option>');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>batch/department_branch_batch/" + department + '/' + branch,
                success: function (response) {
                    var branch = jQuery.parseJSON(response);
                    $.each(branch, function (key, value) {
                        $('#batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            });
        }

        function semester_from_branch(branch) {        
            $('#semester').find('option').remove().end();
            $('#semester').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
                type: 'GET',
                success: function (content) {
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    });
                }
            });
        } 
   

    
    function get_student2(batch, semester = '') {
        var batch = $("#batch").val();
        var course = $("#course").val();
        var degree = $("#degree").val();
        var semester = $("#semester").val();
        $.ajax({
            url: '<?php echo base_url(); ?>project/batchwisestudentcheckbox/',
            type: 'POST',
            data: {'batch': batch, 'sem': semester, 'course': course, 'degree': degree},
            success: function (content) {
                if (content != "")
                {
                    $("#student").html(content);
                }
            }
        });
    }

    function get_students2(divclass)
    {
        var batch = $("#batch").val();
        var course = $("#course").val();
        var degree = $("#degree").val();
        var sem = $("#semester").val();
        $.ajax({
            url: '<?php echo base_url(); ?>project/checkboxstudent/',
            type: 'POST',
            data: {'batch': batch, 'sem': sem, 'course': course, 'degree': degree, 'divclass': divclass},
            success: function (content) {
                //alert(content);
                $("#student").html(content);
            }
        });


    }
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#btnadd").click(function (event) {
        if ($("#degree").val() != null & $("#course").val() != null & $("#batch").val() != null & $("#semester").val() != null & $("#title").val() != null)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'project/checkprjects'; ?>",
                dataType: 'json',
                data:
                        {
                            'degree': $("#degree").val(),
                            'course': $("#course").val(),
                            'batch': $("#batch").val(),
                            'semester': $("#semester").val(),
                            'title': $("#title").val(),
                        },
                success: function (response) {
                    if (response.length == 0) {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . 'admin/checkprojectstd'; ?>",
                            data: {
                                'degree': $("#degree").val(),
                                'course': $("#course").val(),
                                'batch': $("#batch").val(),
                                'semester': $("#semester").val(),
                            },
                            success: function (getstudent)
                            {
                                if (getstudent == "false")
                                {
                                    $("#error_std").html("Select student");
                                    return false;
                                }
                            }

                        });
                        $("#error_lable_exist").html('');
                        $('#frmproject').attr('validated', true);
                        $('#frmproject').submit();
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
    $().ready(function () {
        $("#dateofsubmission").datepicker({
            format: js_date_format, startDate: new Date(),
            minDate: 0,
            autoclose: true,
        });
        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z ]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("url", function (value, element) {
            return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
        }, 'Please enter a valid URL.');

        $("#frmproject").validate({
            rules: {
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                class: "required",
                'student[]': "required",
                dateofsubmission: "required",
                pageurl:
                        {
                            required: true,
                            url: true,
                        },
                projectfile: {
                    required: true,
                    extension: 'gif|jpg|png|pdf|xlsx|xls|doc|docx|ppt|pptx|pdf|txt|zip|rar',
                },
                title:
                        {
                            required: true, },
            },
            messages: {
                degree: "Select department",
                course: "Select Branch",
                batch: "Select Batch",
                semester: "Select Semester",
                class: "Select class",
                'student[]': "Select Student",
                dateofsubmission: "Select date of submission",
                projectfile: {
                    required: "Upload file!",
                    extension: 'Upload valid file!',
                },
                title:
                        {
                            required: "Enter project name",
                        },
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#select_all').on('click', function () {
            if (this.checked) {
                $('.checkbox1').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkbox1').each(function () {
                    this.checked = false;
                });
            }
        });

    });

</script>
<script type="text/javascript">
    function uncheck()
    {
        if ($('.checkbox1:checked').length == $('.checkbox1').length) {
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
    }
</script>
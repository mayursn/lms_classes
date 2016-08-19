<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>  <?php echo ucwords("Add Assignment"); ?></h4>                
                        </div>    -->
            <div class="panel-body"> 

                <div class="box-content">  

                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                             
                    <?php echo form_open(base_url() . 'assignment/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmassignment', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Assignment"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" />
                            </div>
                            <lable class="error" id="error_lable_exist" style="color:#f85d2c"></lable>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="degree" id="degree" class="form-control">
                                    <option value="">Select department</option>
                                    <?php
                                    $this->load->model('department/Degree_model');
                                    $degree = $this->Degree_model->get_all();
                                    foreach ($degree as $dgr) {
                                        ?>
                                        <option value="<?= $dgr->d_id ?>"><?= $dgr->d_name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="course" id="course" class="form-control">
                                    <option value="">Select Branch</option>
                                </select>
                            </div>
                        </div>                     
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="semester" id="semester" class="form-control">
                                    <option value="">Select Semester</option>
                                    <?php
                                    $this->db->select('s_id,s_name,s_status');
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
                                <select name="class" id="class" class="form-control">
                                    <option value="">Select class</option>
                                    <?php
                                    $this->db->select('class_id,class_name');
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
                            <label class="col-sm-4 control-label"><?php echo ucwords("subject"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="subject" id="subject" class="form-control">
                                    <option value="">Select subject</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Submission Date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly="" name="submissiondate" id="submissiondate" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Instructions & guidance"); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="instruction" id="instruction"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("File Upload"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="assignmentfile" id="assignmentfile" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="button" id="btnadd" class="btn btn-info vd_bg-green"><?php echo ucwords("Add "); ?></button>
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
    $(document).ready(function(){
       
        $('#degree').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });
        $('#course').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#degree').val();            
            semester_from_branch(branch_id);
        });
         $('#semester').on('change', function () {
             var semester = $(this).val();
            var branch_id = $("#course").val();
            var department = $('#degree').val();    
            subject_list_from_department_branch_semester(department,branch_id,semester);
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
        
        function subject_list_from_department_branch_semester(department, branch, semester)
        {
              $('#subject').find('option').remove().end();
            $('#subject').append('<option value>Select</option>');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>subject/subject_department_branch_sem/" + department + '/' + branch + '/' + semester ,
                success: function (response) {
                    var subject = jQuery.parseJSON(response);
                    $.each(subject, function (key, value) {
                        $('#subject').append('<option value=' + value.sm_id + '>' + value.subject_name + '</option>');
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
    });
    $("#btnadd").click(function (event) {
  
        if ($("#title").val() != null & $("#degree").val() != null & $("#subject").val() != null & $("#semester").val() != null & $("#course").val() != null)
        {
           
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'assignment/checkassignments'; ?>",
                dataType: 'json',
                async: false,
                data:
                        {
                            'title': $("#title").val(),
                            'semester': $("#semester").val(),
                            'degree': $("#degree").val(),
                            'subject': $("#subject").val(),
                            'course': $("#course").val()
                        },
                success: function (response) {                
                    if (response.length == 0) {
                        $("#error_lable_exist").html('');
                        $('#frmassignment').attr('validated', true);
                        $('#frmassignment').submit();
                    } else
                    {
                        $("#error_lable_exist").html('Record is already present in the system');
                        return false;
                    }
                }
            });
            return false;
        }
        event.preventDefault();

    });

   

    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        $("#submissiondate").datepicker({
             format: js_date_format, startDate : new Date(),
            startDate: new Date(),
            autoclose:true,
        });

        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z ]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("url", function (value, element) {
            return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
        }, 'Please enter a valid URL.');

        $("#frmassignment").validate({
            rules: {
                title: {
                    required: true,
                },
                degree: "required",
                course: "required",
                batch: "required",
                semester: {
                    required: true,
                },
                subject:"required",
                submissiondate: "required",
                assignmentfile: {
                    required: true,
                    extension: 'gif|jpg|png|pdf|xlsx|xls|doc|docx|ppt|pptx|txt',
                },
            },
            messages: {
                title:
                        {
                            required: "Enter title",
                        },
                degree: "Select department",
                course: "Select Branch",
                batch: "Select Batch",
                semester: {
                    required: "Select semester",
                },
                subject:"Select Subject",
                submissiondate: "Select date of submission",
                assignmentfile: {
                    required: "Upload file",
                    extension: 'Upload valid file',
                },
            }
        });


    });
</script>
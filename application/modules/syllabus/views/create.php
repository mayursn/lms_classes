<?php
$this->load->model('department/Degree_model');
$degree = $this->Degree_model->get_all();
$this->load->Model('branch/Course_model');
$this->load->Model('semester/Semester_model');
$data['course'] = $this->Course_model->order_by_column('c_name');
$data['semester'] = $this->Semester_model->order_by_column('s_name');        
?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>  <?php echo ucwords("Add Syllabus"); ?></h4>                
                        </div>    -->
            <div class="panel-body"> 
                <div class="box-content">  
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                       
                    <?php echo form_open(base_url() . 'syllabus/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmsyllabus', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Syllabus Title"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" />
                            </div>
                            <lable class="error" id="error_lable_exist" style="color:#f85d2c"></lable>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="degree" class="form-control" id="degree">
                                    <option value="">Select Department</option>
                                    <?php
                                  
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
                                <select name="course" class="form-control" id="course">
                                    <option value="">Select Branch</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="semester" class="form-control" id="semester">
                                    <option value="">Select Semester</option>
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
                            <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("File Upload"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="syllabusfile" id="syllabusfile" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add "); ?></button>
                            </div>
                        </div>
                        </form>               
                    </div>                
                </div>

            </div>
        </div>
    </div>
</div>  <script type="text/javascript">
       $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
          var js_date_format = '<?php echo js_dateformat(); ?>';
        $("#submissiondate").datepicker({
            dateFormat: js_date_format,
            minDate: 0
        });

        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z ]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("url", function (value, element) {
            return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
        }, 'Please enter a valid URL.');

        $("#frmsyllabus").validate({
            rules: {
                degree: "required",
                course: "required",
                semester: "required",
                submissiondate: "required",
                syllabusfile: {
                    required: true,
                    extension: 'pdf|doc|docx|ppt|pptx',
                },
                title:
                        {
                            required: true,
                        },
            },
            messages: {
                degree: "Select department",
                course: "Select Branch",
                semester: "Select Semester",
                syllabusfile: {
                    required: "Upload file",
                    extension: 'Upload valid file',
                },
                title:
                        {
                            required: "Enter title",
                        },
            }
        });
    });
</script>



<script type="text/javascript">  
    $(document).ready(function(){
       
        $('#degree').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });
        $('#course').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#degree').val();
            batch_form_department_branch(department, branch_id);
            semester_from_branch(branch_id);
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
    });
   



</script>
<?php


$this->load->Model('branch/Branch_location_model');
$branch = $this->Branch_location_model->order_by_column('branch_name');
$this->load->Model('admission_plan/Admission_plan_model');
$this->load->Model('courses/Course_model');
$course = $this->Course_model->order_by_column('c_name');


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
                            <label class="col-sm-4 control-label"><?php echo ucwords("branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="branch" class="form-control" id="branch">
                                    <option value="">Select Branch</option>
                                    <?php
                                  
                                    foreach ($branch as $row_branch) {
                                        ?>
                                        <option value="<?php echo $row_branch->branch_id ?>"><?php echo $row_branch->branch_name.' - '.$row_branch->branch_location; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="course" class="form-control" id="course">
                                    <option value="">Select Course</option>
                                    <?php foreach ($course as $row_course): ?>
                                    <option value="<?php echo $row_course->course_id; ?>"><?php echo $row_course->c_name; ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="admission_plan" class="form-control" id="admission_plan">
                                <option value="">Select</option>
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
                branch: "required",
                course: "required",
                admission_plan: "required",               
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
                branch: "Select Branch",
                course: "Select Course",
                admission_plan: "Select Admission plan",
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
       
       
        
    $('#course').on('change', function () {
        var course_id = $(this).val();        
        get_admission_plan(course_id);        
    });
    function get_admission_plan(course_id)
    {
     $('#admission_plan').find('option').remove().end();
        $('#admission_plan').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);
                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                });
            }
        });
    }

    });
   



</script>
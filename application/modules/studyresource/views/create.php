
<div class="row">
    <div class="col-md-12">

        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class="panel-body"> 

                <div class="box-content">  

                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div> 
                    <?php echo form_open(base_url() . 'studyresource/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmstudyresource', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>

                    <div class="padded">											
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?> <span style="color:red">*</span></label>
                            <div class="col-sm-8">

                                <select name="branch" id="branch_id" class="form-control">
                                    <option value="">Select Branch</option>                                    
                                    <?php
                                    $branch = $this->db->get('branch_location')->result();
                                    foreach ($branch as $rowdegree) {
                                        ?>
                                        <option value="<?php echo  $rowdegree->branch_id ?>"><?php echo  $rowdegree->branch_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="course" id="course" class="form-control">

                                    <option value="">Select Course</option>
                                    
                                    <?php
                                    $course = $this->db->get_where('course')->result();
                                      foreach ($course as $crs) {
                                      ?>
                                        <option value="<?php echo  $crs->course_id; ?>"><?php echo  $crs->c_name ?></option>
                                      <?php
                                      } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">

                                <select name="admission_plan" id="admission_plan" onchange="get_student2(this.value);" class="form-control" >

                                    <option value="">Select </option>
                                </select>
                            </div>
                        </div>	
                     

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Title "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" />
                            </div>
                        </div>   
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("File Upload "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="resourcefile" id="resourcefile" />
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
                                <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                            </div>
                        </div>

                    </div>         
                    </form>               
                </div>
            </div>
        </div></div></div>
<script type="text/javascript">




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

    

    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
        $("#dateofsubmission").datepicker({
            dateFormat: ' MM dd, yy',
            minDate: 0
        });

        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("url", function (value, element) {
            return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
        }, 'Please enter a valid URL.');


        $("#frmstudyresource").validate({
            rules: {
                branch: "required",
                course: "required",
                admission_plan: "required",
                semester: "required",
                dateofsubmission: "required",
                pageurl:
                        {
                            required: true,
                            url: true,
                        },
                title:
                        {
                            required: true,
                        },
                resourcefile: {
                    required: true,
                    extension: 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|ppt|pptx|pdf|txt',
                    extension: 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|ppt|pptx|pdf|txt',
                },
            },
            messages: {
                branch: "Please select branch",
                course: "Please select course",
                admission_plan: "Please select Admission plan",
                semester: "Please select semester",
                pageurl:
                        {
                            required: "Please enter page url",
                        },
                title:
                        {
                            required: "Please enter title",
                        },
                resourcefile: {
                    required: 'please upload file',
                    extension: 'Please upload valid file',
                },
            }
        });
    });
</script>
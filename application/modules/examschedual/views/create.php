<?php 
 $this->load->model('branch/Branch_location_model');
 $this->load->model('courses/Course_model');        
 $this->load->model('admission_plan/Admission_plan_model');
        $course = $this->Course_model->order_by_column('c_name');
        $branch = $this->Branch_location_model->order_by_column('branch_name');
        
?>
<div class="row">
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php echo form_open(base_url() . 'examschedual/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'exam_time_table_form', 'target' => '_top')); ?>
                <br/>
                <div class="padded">
                    <?php
                    $validation_error = validation_errors();
                    if ($validation_error != '') {
                        ?>
                        <div class="alert alert-danger">
                            <button class="close" data-dismiss="alert">&times;</button>
                            <p><?php echo $validation_error; ?></p>
                        </div>                                            
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("branch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="branch" id="branch" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($branch as $row) { ?>
                                    <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="course" id="course" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($course as $crs): ?>
                                <option value="<?php echo $crs->course_id; ?>"><?php echo $crs->c_name; ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="admission_plan" id="admission_plan">
                                <option value="">Select</option>
                                
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Exam"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="exam" name="exam">

                            </select>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Subject"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="subject" name="subject">

                            </select>
                        </div>
                    </div> 
                    <div class="form-group">

                        <label class="col-sm-4 control-label"><?php echo ucwords("Date"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input readonly="" type="text" id="exam_date" class="form-control datepicker-normal" name="exam_date"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Start Time"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group bootstrap-timepicker">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input type="text" id="start_time" class="form-control timepicker" name="start_time"/>
                            </div>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("End Time"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group bootstrap-timepicker">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input type="text" id="end_time" class="form-control timepicker" name="end_time"/>
                            </div>
                        </div>	
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add "); ?></button>
                        </div>
                    </div>
                </div>
                <!-- End .panel -->
                <?php echo form_close(); ?> 
            </div>
            <!-- col-lg-12 end here -->
        </div>
    </div>
</div>
</div></div>

<script type="text/javascript">
    var js_date_format = '<?php echo js_dateformat(); ?>';
    $('#exam_date').datepicker({
        format:js_date_format,
        autoclose: true,
        startDate: new Date()
    });

</script>

<script type="text/javascript">

    $(document).ready(function () {
        $('#start_time').timepicker({
            upArrowStyle: 'fa fa-angle-up',
            downArrowStyle: 'fa fa-angle-down',
            minuteStep: 30
        });
        $('#end_time').timepicker({
            upArrowStyle: 'fa fa-angle-up',
            downArrowStyle: 'fa fa-angle-down',
            minuteStep: 30
        });
        $("#exam_time_table_form").validate({
            rules: {
                branch: "required",
                course: "required",
                admission_plan: "required",                
                exam: "required",
                subject: "required",
                exam_date: "required",
                start_time: "required",
                end_time: "required"
            },
            messages: {
                branch: "Please select branch",
                course: "Please select course",
                admission_plan: "Please select admission plan",             
                exam: "Please select exam",
                subject: "Please select subject",
                exam_date: "Please enter date",
                start_time: "Please enter start time",
                end_time: "Please enter end time"
            }
        });
    });
</script>
<script type="text/javascript">
 //   $('#exam_date').datepicker({format: js_date_format, autoclose: true});

</script>

<script type="text/javascript">

    $(document).ready(function () {
        $.validator.addMethod("greaterThan",
                function (value, element, param) {
                    var $min = $(param);
                    if (this.settings.onfocusout) {
                        $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
                            $(element).valid();
                        });
                    }
                    var stt = $min.val();
                    var edt = $("#end_time").val();
                    var start_time = new Date("November 13, 2013 " + stt);
                    stt = start_time.getTime();
                    var end_time = new Date("November 13, 2013 " + edt);
                    endt = end_time.getTime();

                    return parseInt(endt) > parseInt(stt);
                }, "End time must be greater than start time");
        $('#start_time').timepicker({
            upArrowStyle: 'fa fa-angle-up',
            downArrowStyle: 'fa fa-angle-down',
            minuteStep: 30
        });
        $('#end_time').timepicker({
            upArrowStyle: 'fa fa-angle-up',
            downArrowStyle: 'fa fa-angle-down',
            minuteStep: 30
        });
        $("#exam_time_table_form").validate({
            rules: {
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                exam: "required",
                subject: "required",
                exam_date: "required",
                start_time: "required",
                end_time: {
                    required: true,
                    greaterThan: '#start_time'
                }
            },
            messages: {
                degree: "Please select department",
                course: "Please select branch",
                batch: "Please select batch",
                semester: "Please select semester",
                exam: "Please select exam",
                subject: "Please select subject",
                exam_date: "Please enter date",
                start_time: "Please enter start time",
                end_time: {
                    required: "Please enter end time",
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
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
    
    $("#admission_plan").on('change',function(){
        var admission_plan = $(this).val();
        var course = $("#course").val();
        var branch = $("#branch").val();
        exam_list_from_degree_and_course(branch,course,admission_plan);
        subject_list(branch,course, admission_plan);
    });
    //exam list from degree and course
        function exam_list_from_degree_and_course(branch, course, admission_plan) {
            $('#exam').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>exam/exam_list_from_degree_and_course/' + branch + '/' + course + '/' + admission_plan +'/reguler',
                type: 'get',
                success: function (content) {
                    $('#exam').append('<option value="">Select</option>');
                    var exam_list = jQuery.parseJSON(content);
                    $.each(exam_list, function (key, value) {
                        $('#exam').append('<option value=' + value.em_id + '>' + value.em_name + '</option>');
                    })
                }
            })
        }
        // subject list from course and semester
        function subject_list(branch,course, admission_plan) {
            $('#subject').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>subject/subject_list_admission_plan/' + branch + '/' + course + '/' + admission_plan,
                type: 'get',
                success: function (content) {
                    $('#subject').append('<option value="">Select</option>');
                    var subject = jQuery.parseJSON(content);
                    $.each(subject, function (key, value) {
                        $('#subject').append('<option value=' + value.sm_id + '>' + value.subject_name + '</option>');
                    })
                }
            })
        }
    });
    
</script>
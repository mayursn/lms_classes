<?php 
 $this->load->model('department/Degree_model');
        $this->load->model('branch/Course_model');
        $this->load->model('batch/Batch_model');
        $this->load->model('semester/Semester_model');
        $course = $this->Course_model->order_by_column('c_name');
        $semester = $this->Semester_model->order_by_column('s_name');
        $batch = $this->Batch_model->order_by_column('b_name');
        $degree = $this->Degree_model->order_by_column('d_name');
        
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
                        <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="degree" id="degree" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($degree as $row) { ?>
                                    <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="course" id="course" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Batch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="batch" id="batch">

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="semester" name="semester">
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
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                exam: "required",
                subject: "required",
                exam_date: "required",
                start_time: "required",
                end_time: "required"
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
                end_time: "Please enter end time"
            }
        });
    });
</script>
<script type="text/javascript">
    $('#exam_date').datepicker({format: js_date_format, autoclose: true});

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
        //course by degree
        $('#degree').on('change', function () {
            var course_id = $('#course').val();
            var degree_id = $(this).val();
            var batch_id = $('#batch').val();
            var semester = $('#semester').val();

            //remove all present element
            $('#course').find('option').remove().end();
            $('#course').append('<option value="">Select</option>');
            var degree_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + degree_id,
                type: 'get',
                success: function (content) {
                    var course = jQuery.parseJSON(content);
                    $.each(course, function (key, value) {
                        $('#course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    })
                }
            })
            batch_from_degree_and_course(degree_id, course_id);
            exam_list_from_degree_and_course(degree_id, course_id, batch_id, semester);
            subject_list(course_id, semester);
        });

        //batch from course and degree
        $('#course').on('change', function () {
            var degree_id = $('#degree').val();
            var course_id = $(this).val();
            var batch_id = $('#batch').val();
            var semester = $('#semester').val();
            batch_from_degree_and_course(degree_id, course_id);
            exam_list_from_degree_and_course(degree_id, course_id, batch_id, semester);
            subject_list(course_id, semester);
            get_semester_from_branch(course_id);
        })

        //exam list from degree, course, batch, and sem
        $('#batch').on('change', function () {
            var degree = $('#degree').val();
            var course = $('#course').val();
            var batch = $(this).val();
            var semester = $('#semester').val();
            exam_list_from_degree_and_course(degree, course, batch, semester);
            subject_list(course, semester);
        })

        $('#semester').on('change', function () {
            var degree = $('#degree').val();
            var course = $('#course').val();
            var batch = $('#batch').val();
            var semester = $(this).val();
            exam_list_from_degree_and_course(degree, course, batch, semester);
            subject_list(course, semester);
        })

        //find batch from degree and course
        function batch_from_degree_and_course(degree_id, course_id) {
            //remove all element from batch
            $('#batch').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>batch/department_branch_batch/' + degree_id + '/' + course_id,
                type: 'get',
                success: function (content) {
                    $('#batch').append('<option value="">Select</option>');
                    var batch = jQuery.parseJSON(content);
                    console.log(batch);
                    $.each(batch, function (key, value) {
                        $('#batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    })
                }
            })
        }

        //exam list from degree and course
        function exam_list_from_degree_and_course(d_id, c_id, b_id, s_id) {
            $('#exam').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>exam/exam_list_from_degree_and_course/' + d_id + '/' + c_id + '/' + b_id + '/' + s_id + '/reguler',
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
        function subject_list(course, semester) {
            $('#subject').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>subject/subject_list_from_course_and_semester/' + course + '/' + semester,
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

        //get semester from brach
        function get_semester_from_branch(branch_id) {
            $('#semester').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch_id,
                type: 'get',
                success: function (content) {
                    $('#semester').append('<option value="">Select</option>');
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    })
                }
            })
        }
    })
</script>
<?php
$this->load->Model('exam/Exam_manager_model');
$this->load->model('branch/Branch_location_model');
$this->load->model('courses/Course_model');
$branch = $this->Branch_location_model->order_by_column('branch_name');
$course = $this->Course_model->order_by_column('c_name');
$exams = $this->Exam_manager_model->exam_details();
$exam_type = $this->Exam_manager_model->get_all_exam_type();
?>

<div class="row">
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh"></div>
        <div class=panel-body>
            <?php echo form_open(base_url() . 'exam/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'examform', 'target' => '_top')); ?>
            <div class="padded">
                <?php
                $validation_error = validation_errors();
                if ($validation_error != '') {
                    ?>
                    <div class="alert alert-danger">
                        <button class="close" data-dismiss="alert">&times;</button>
                        <?php echo $validation_error; ?>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $('#add_exam').click();
                        });
                    </script>
                <?php } ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Exam Name"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="exam_name" id="exam_name"
                               value="<?php echo set_value('exam_name'); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Exam Type"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="exam_type" id="exam_type">
                            <?php
                            $exam_type_id = set_value('exam_type');
                            ?>
                            <option value="">Select</option>
                            <?php foreach ($exam_type as $row) { ?>
                                <option value="<?php echo $row->exam_type_id; ?>"
                                        <?php if ($row->exam_type_id == $exam_type_id) echo 'selected'; ?>><?php echo $row->exam_type_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Total Marks"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="total_marks" id="total_marks"
                               value="<?php echo set_value('total_marks'); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Passing Marks"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="passing_marks" id="passing_marks"
                               value="<?php echo set_value('total_marks'); ?>"/>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Year"); ?></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="year" id="year">
                            <?php
                            $year = set_value('year');
                            ?>
                            <?php for ($i = 2016; $i >= 2010; $i--) { ?>
                                <option value="<?php echo $i; ?>"
                                        <?php if ($year == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="branch" id="branch">
                            <option value="">Select</option>
                            <?php foreach ($branch as $row) { ?>
                                <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name.' - '.$row->branch_location; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="course" id="course">
                            <option value="">Select</option>
                            <?php foreach($course as $crs): ?>
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
                    <label class="col-sm-4 control-label"><?php echo ucwords("Status"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="status" id="status">
                            <?php
                            $status_select_id = set_value('status');
                            ?>
                            <option value="">Select</option>
                            <option value="1" <?php if ($status_select_id == '1') echo 'selected'; ?>>Active</option>
                            <option value="0" <?php if ($status_select_id == '0') echo 'selected'; ?>>In-active</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Start Date"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="date" id="edit_start_date" class="form-control datepicker-normal"
                               value="<?php echo set_value('date'); ?>"/>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Start Date/Time"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input readonly="" type="text" name="start_date_time" id="start_date_time" class="form-control "
                               value="<?php echo set_value('start_date_time'); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("End Date"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input  type="text" name="end_date_time" id="edit_end_date_time" class="form-control datepicker-normal"
                                value="<?php echo set_value('end_date_time'); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("result type"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="resulttype" id="resulttype">
                            <option value="">Select</option>
                            <option value="grade" >Grade</option>
                            <option value="marks" >Marks</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("exam mode"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="exammode" id="exammode">
                            <option value="">Select</option>
                            <option value="written" >Written</option>
                            <option value="mcq" >MCQ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>  
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<script>
    var js_date_format = '<?php echo js_dateformat(); ?>';
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
        
        
        
        var date = '';
        var start_date = '';
        $('#edit_start_date').datepicker({
            format: js_date_format,
            //startDate: new Date(),
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#edit_end_date_time').datepicker('setStartDate', minDate);
        
    });
    $("#edit_end_date_time").datepicker({
                    format: js_date_format,
                    todayHighlight: true,              
                    autoclose: true,
     });


//        $('#edit_start_date').on('change', function () {
//            date = new Date($(this).val());
//            start_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
//            console.log(start_date);  
//            
//            setTimeout(function () {
//                $("#edit_end_date_time").datepicker({
//                    format: js_date_format,
//                    autoclose: true,
//                    startDate: start_date
//                });
//            }, 700);
//        });
    })
</script>

<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });
    $().ready(function () {
        $("#examform").validate({
            rules: {
                exam_name: "required",
                exam_type: "required",
                year: "required",
                branch: "required",
                course: "required",
                admission_plan: "required",                
                total_marks: "required",
                passing_marks: {
                    required: true
                },
                status: "required",
                date: "required",
                start_date_time: "required",
                end_date_time: "required",
                resulttype:"required",
                exammode:"required"
            },
            messages: {
                exam_name: "Please enter exam name",
                exam_type: "Please select exam type",
                year: "Please select year",
                branch: "Please select branch",
                course: "Please select course",
                admission_plan: "Please select admission plan",                
                total_marks: "Please enter total marks",
                passing_marks: {
                    required: "Please enter passing marks"
                },
                status: "Please select status",
                date: "Please enter date",
                start_date_time: "Please enter start date time",
                end_date_time: "Please enter end date",
                resulttype:"Select result type",
                exammode:"Select result mode"
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
       

    })
</script>


<script>
    $(document).ready(function () {
        $('#total_marks').on('blur', function () {
            var total_marks = $(this).val();
            $('#passing_marks').attr('max', total_marks);
            $('#passing_marks').attr('required', '');
        });
        $('#passing_marks').on('focus', function () {
            var total_marks = $('#total_marks').val();
            $(this).attr('max', total_marks);
        })
    })
</script>


<script>
    $(document).ready(function () {
        var date = '';
        var start_date = '';
       
        $("#date").datepicker({
            format: js_date_format,
          //  startDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });

        $('#date').on('change', function () {
            date = new Date($(this).val());
            start_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
            console.log(start_date);
            setTimeout(function () {
                $("#end_date_time").datepicker({
                    format: js_date_format,
                    todayHighlight: true,
               //     startDate: start_date,
                    autoclose: true,
                });
            }, 700);
        });
    })
</script>
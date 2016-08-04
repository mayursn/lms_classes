<?php
$this->load->Model('exam/Exam_manager_model');
$this->load->model('department/Degree_model');
$edit_data = $this->Exam_manager_model->get_exam_details($param2);
//echo "<prE>";
//print_r($edit_data);


$exam_type = $this->Exam_manager_model->get_all_exam_type();
$centerlist = $this->db->get('center_user')->result();

 $this->load->model('admission_plan/Admission_plan_model');
$this->load->model('classes/Class_model');
$this->load->model('courses/Course_model');
$course = $this->Course_model->order_by_column('c_name');
$admission_plan = $this->Admission_plan_model->order_by_column('admission_duration');
?>

<div class="row">
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php echo form_open(base_url() . 'exam/update/' . $edit_data->em_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'edit-exam-form', 'target' => '_top')); ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Exam Name"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="exam_name" id="exam_name"
                               value="<?php echo $edit_data->em_name; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Exam Type"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="exam_type" id="exam_type" required="">
                            <option value="">Select</option>
                            <?php foreach ($exam_type as $row) { ?>
                                <option value="<?php echo $row->exam_type_id; ?>"
                                        <?php if ($edit_data->em_type == $row->exam_type_id) echo 'selected'; ?>><?php echo $row->exam_type_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Total Marks"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required="" name="total_marks" id="edit_total_marks" value="<?php echo $edit_data->total_marks; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Passing Marks"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required="" name="passing_marks" id="edit_passing_marks" value="<?php echo $edit_data->passing_mark; ?>"/>
                    </div>
                </div>
                <div class="form-group" style="display: none">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Year"); ?></label>
                    <div class="col-sm-8">
                        <select class="form-control" required="" name="year" id="year">

                            <?php for ($i = 2016; $i >= 2010; $i--) { ?>
                                <option <?php echo $i; ?>
                                    <?php if ($edit_data->em_year == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                                <?php } ?>
                        </select>
                    </div>
                </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <?php $this->load->model('branch/Branch_location_model'); 
                            $branch = $this->Branch_location_model->order_by_column('branch_name');
                            ?>
                            <select name="branch" class="form-control" id="branch">
                                <option value="">Select</option>
                                <?php foreach ($branch as $rows) { ?>
                                    <option value="<?php echo $rows->branch_id; ?>" <?php if($edit_data->branch_id==$rows->branch_id){ echo "selected=selected"; } ?>><?php echo $rows->branch_name; ?></option>
                                <?php } ?>                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="course" class="form-control" id="course">
                                <option value="">Select</option>
                                <?php foreach($course as $rowcourse): ?>
                                <option value="<?php echo $rowcourse->course_id; ?>" <?php if($edit_data->course_id==$rowcourse->course_id){ echo "selected=selected"; } ?>><?php echo $rowcourse->c_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span> <?php echo $edit_data->admission_plan_id; ?></label>
                        <div class="col-sm-8">
                            <select name="admission_plan" class="form-control" id="admission_plan">
                                <option value="">Select</option>
                                <?php foreach ($admission_plan as $plan): ?>
                                <option value="<?php echo $plan->admission_plan_id; ?>" <?php if($edit_data->admission_plan_id==$plan->admission_plan_id){ echo "selected=selected"; } ?>><?php echo $plan->admission_duration; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>	

                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Status"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" required="" name="status" id="status">
                            <option value="">Select</option>
                            <option value="1"
                                    <?php if ($edit_data->em_status == 1) echo 'selected'; ?>>Active</option>
                            <option value="0"
                                    <?php if ($edit_data->em_status == 0) echo 'selected'; ?>>In-active</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Start Date"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input readonly="" type="text" id="start-date" name="date" class="form-control datepicker-normal-edit"
                               value="<?php echo date_formats($edit_data->em_date); ?>"/>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Start Date"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input readonly="" type="text" name="start_date_time" id="edit_start_date_time" class="form-control"
                               value="<?php echo date_formats($edit_data->em_start_time); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("End Date"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input readonly="" type="text"  name="end_date_time" id="end-date" class="form-control datepicker-normal-edit"
                               value="<?php echo date_formats($edit_data->em_end_time); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("result type"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="resulttype" id="resulttype">
                            <option value="">Select</option>
                            <option value="grade" <?php if ($edit_data->result_type == 'grade') {echo "selected";} ?>>Grade</option>
                            <option value="marks" <?php if ($edit_data->result_type == 'marks') {echo "selected";} ?> >Marks</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("exam mode"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="exammode" id="exammode">
                            <option value="">Select</option>
                            <option value="written" <?php if ($edit_data->exam_mode == 'written') {echo "selected";} ?>>Written</option>
                            <option value="mcq" <?php if ($edit_data->exam_mode == 'mcq') {echo "selected";} ?>>MCQ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="submit btn btn-info vd_bg-green"><?php echo ucwords("Update"); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div> 
        </div>
    </div>
    <!-- End .panel -->
</div>
<!-- col-lg-12 end here -->
</div></div>
<script>
    $(document).ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        var date = '';
        var start_date = '';
        $('#start-date').datepicker({
            format: js_date_format,
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#end-date').datepicker('setStartDate', minDate);
    });
        $("#end-date").datepicker({
            format: js_date_format,
            autoclose: true
        });

//        $('#start-date').on('change', function () {
//            date = new Date($(this).val());
//            start_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
//            console.log(start_date);
//
//            setTimeout(function () {
//                $("#end-date").datepicker({
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
        $("#edit-exam-form").validate({
            rules: {
                exam_name: "required",
                exam_type: "required",
                year: "required",
                branch: "required",
                course: "required",
                admission_plan: "required",                
                edit_total_marks: "required",
                edit_passing_marks: "required",
                status: "required",
                date: "required",
                start_date_time: "required",
                end_date_time: "required",
                resulttype:"required",
                exammode:"required"
            },
            messages: {
                exam_name: "Please enter Exam Name",
                exam_type: "Please select Exam type",
                year: "Please select year",
                branch: "Please select branch",
                course: "Please select course",
                admission_plan: "Please select admission plan",                
                edit_total_marks: "Please enter total marks",
                edit_passing_marks: "Please enter passing marks",
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
        $('#course').on('change', function () {
        var course_id = $(this).val();        
        get_admission_plan(course_id);
        
    });
    function get_admission_plan(course_id)
    {
     $('#admission_plan').find('option').remove().end();
        $('#admission_plan').append('<option value="">Select</option>');
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

<script>
    $(document).ready(function () {
        $('#edit_total_marks').on('blur', function () {
            var total_marks = $(this).val();
            $('#edit_passing_marks').attr('max', total_marks);
        });

        $('#edit_passing_marks').on('focus', function () {
            var total_marks = $('#edit_total_marks').val();
            $(this).attr('max', total_marks);
        })
    })
</script>

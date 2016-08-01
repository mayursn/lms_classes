<?php
$this->load->Model('exam/Exam_manager_model');
$this->load->model('department/Degree_model');
$exams = $this->Exam_manager_model->exam_details();
$exam_type = $this->Exam_manager_model->get_all_exam_type();
$degree = $this->Degree_model->order_by_column('d_name');
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
                    <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="degree" id="degree">
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
                        <select class="form-control" name="course" id="course">

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
                        <select class="form-control" name="semester" id="semester">

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
    $(document).ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        var date = '';
        var start_date = '';
        $('#edit_start_date').datepicker({
            format: js_date_format,
            startDate: new Date(),
            autoclose: true,
            todayHighlight: true,
        });

        $('#edit_start_date').on('change', function () {
            date = new Date($(this).val());
            start_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
            console.log(start_date);

            setTimeout(function () {
                $("#edit_end_date_time").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    startDate: start_date
                });
            }, 700);
        });
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
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                total_marks: "required",
                passing_marks: {
                    required: true
                },
                status: "required",
                date: "required",
                start_date_time: "required",
                end_date_time: "required"
            },
            messages: {
                exam_name: "Please enter exam name",
                exam_type: "Please select exam type",
                year: "Please select year",
                degree: "Please select department",
                course: "Please select branch",
                batch: "Please select batch",
                semester: "Please select semester",
                total_marks: "Please enter total marks",
                passing_marks: {
                    required: "Please enter passing marks"
                },
                status: "Please select status",
                date: "Please enter date",
                start_date_time: "Please enter start date time",
                end_date_time: "Please enter end date"
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
        });
        //batch from course and degree
        $('#course').on('change', function () {
            var degree_id = $('#degree').val();
            var course_id = $(this).val();
            batch_from_degree_and_course(degree_id, course_id);
            get_semester_from_branch(course_id);
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
            format: ' MM dd, yyyy',
            startDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });

        $('#date').on('change', function () {
            date = new Date($(this).val());
            start_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
            console.log(start_date);
            setTimeout(function () {
                $("#end_date_time").datepicker({
                    format: ' MM dd, yyyy',
                    todayHighlight: true,
                    startDate: start_date,
                    autoclose: true,
                });
            }, 700);
        });
    })
</script>
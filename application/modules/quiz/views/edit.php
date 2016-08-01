<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class=" panel-default">
            <div class=panel-body>
                <div class="tabs mb20">
                    <ul id="import-tab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#quiz-details" data-toggle="tab" aria-expanded="true">Quiz Details</a>
                        </li>
                        <li class="">
                            <a href="#quiz-questions" data-toggle="tab" aria-expanded="false">Quiz Questions</a>
                        </li>
                    </ul>
                    <div id="import-tab-content" class="tab-content">
                        <div class="tab-pane fade active in" id="quiz-details">
                            <div class="panel-default">
                                <div class="panel-body"> 

                                    <div class="box-content">  

                                        <?php echo form_open(base_url() . 'quiz/update/' . $quiz->quiz_id, array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'eventform', 'target' => '_top')); ?>
                                        <div class="padded">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("title"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="title" value="<?php echo $quiz->title; ?>"/>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("description"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <textarea name="description" class="form-control" rows="3"><?php echo $quiz->description; ?></textarea>									</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="department" id="department">
                                                        <option value="">Select</option>
                                                        <?php foreach ($department as $row) { ?>
                                                            <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("branch"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="branch" id="branch">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("batch"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="batch" id="batch">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("semester"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="semester" id="semester">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("validity type"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="validity_type" id="validity-type">
                                                        <option value="">Select</option>
                                                        <option value="Day">Day</option>
                                                        <option value="Attempt">Attempt</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("validity value"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="number" name="validity_value" id="validity-value" class="form-control" 
                                                           value="<?php echo $quiz->validity_value; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("total questions"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input id="total-questions" class="form-control" type="number" name="total_questions"
                                                           value="<?php echo $quiz->total_questions; ?>"/>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("total marks"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="number" name="total_marks" id="total-marks" class="form-control"
                                                           value="<?php echo $quiz->total_marks; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("nagative marks status"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select id="nagative-marks-status" class="form-control" name="nagative_marks_status">
                                                        <option value="">Select</option>
                                                        <option value="0">Off</option>
                                                        <option value="1">On</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide" id="nagative-mark-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("nagative marks"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input id="nagative-mark" class="form-control" name="nagative_marks"
                                                           value="<?php echo $quiz->nagative_mark; ?>"/>
                                                </div>
                                            </div>        
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("timer status"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select id="timer-status" class="form-control" name="timer_status">
                                                        <option value="">Select</option>
                                                        <option value="1">On</option>
                                                        <option value="0">Off</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide" id="timer-status-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("timer value"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input id="timer-value" class="form-control" type="number" name="timer_value" placeholder="In minute"
                                                           value="<?php echo $quiz->timer_value; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("difficulty level"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select id="difficulty-level" class="form-control" name="difficulty_level">
                                                        <option value="">Select</option>
                                                        <option value="Easy">Easy</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="High">High</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("status"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select id="status" class="form-control" name="status">
                                                        <option value="">Select</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Start Date<span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control datepicker" name="start_date" 
                                                           value="<?php echo date_formats($quiz->start_date); ?>"/>
                                                </div>
                                            </div>	
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">End Date<span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control datepicker" name="end_date" 
                                                           value="<?php echo date_formats($quiz->end_date); ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Result Date<span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control datepicker" name="result_date" 
                                                           value="<?php echo date_formats($quiz->result_date); ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-6">
                                                    <button type="submit" class="btn btn-info vd_bg-green">Edit</button>
                                                </div>
                                            </div>
                                        </div>    
                                        <?php echo form_close(); ?>  
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- tab content -->
                        <div class="tab-pane fade" id="quiz-questions">
                            <table id="quiz-question-list" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Question</th>
                                        <th>Question Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; ?>
                                    <?php foreach ($quiz_questions as $row) { ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td><?php echo $row->question; ?></td>
                                            <td><?php echo $row->question_type; ?></td>
                                            <td>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/quiz_questions/<?php echo $row->quiz_question_id; ?>');" data-toggle="modal"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>

                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>quiz/delete-question/<?php echo $quiz->quiz_id; ?>/<?php echo $row->quiz_question_id; ?>');" data-toggle="modal" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->

<script type="text/javascript">

    $(document).ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';

        $('#department').val('<?php echo $quiz->department_id; ?>');
        department_branch('<?php echo $quiz->department_id; ?>');

        $('#validity-type').val('<?php echo $quiz->validity_type; ?>');

        $('#nagative-marks-status').val('<?php echo $quiz->nagative_mark_status; ?>');
        nagative_marks_status('<?php echo $quiz->nagative_mark_status; ?>');

        $('#timer-status').val('<?php echo $quiz->nagative_mark_status; ?>');
        timer_status('<?php echo $quiz->timer_status; ?>');

        $('#difficulty-level').val('<?php echo $quiz->difficulty_level; ?>');

        $('#status').val('<?php echo $quiz->status; ?>');

        $('#department').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });
        $('#branch').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#department').val();
            batch_form_department_branch(department, branch_id);
            semester_from_branch(branch_id);
        });

        $('#nagative-marks-status').on('change', function () {
            var status = $(this).val();
            nagative_marks_status(status);
        });

        $('#timer-status').on('change', function () {
            var status = $(this).val();
            timer_status(status);
        });

        function timer_status(status) {
            if (status == '1') {
                $('#timer-status-group').removeClass('hide');
                $('#timer-value').attr('required', 'required');
            } else {
                $('#timer-status-group').addClass('hide');
                $('#timer-value').removeAttr('required');
                $('#timer-value').val('');
            }
        }

        function nagative_marks_status(status) {
            if (status == '1') {
                $('#nagative-mark-group').removeClass('hide');
                $('#nagative-mark').attr('required', 'required');
            } else {
                $('#nagative-mark-group').addClass('hide');
                $('#nagative-mark').val('');
                $('#nagative-mark').removeAttr('required');
            }
        }

        function department_branch(department_id) {
            $('#branch').find('option').remove().end();
            $('#branch').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#branch').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
            setTimeout(function () {
                $('#branch').val('<?php echo $quiz->branch_id; ?>');
                batch_form_department_branch('<?php echo $quiz->department_id; ?>', '<?php echo $quiz->branch_id; ?>');
                semester_from_branch('<?php echo $quiz->branch_id; ?>');
            }, 200);

            setTimeout(function () {
                $('#batch').val('<?php echo $quiz->batch_id; ?>');
            }, 500);

            setTimeout(function () {
                $('#semester').val('<?php echo $quiz->semester_id; ?>');
            }, 700);
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

        var js_date_format = '<?php echo js_dateformat(); ?>';
        $(".datepicker").datepicker({
            format: js_date_format,
            autoclose: true,
            todayHighlight: true
        });
        $("#eventform").validate({
            rules: {
                title: "required",
                description: "required",
                department: "required",
                branch: "required",
                batch: "required",
                semester: "required",
                validity_type: "required",
                validity_value: "required",
                total_marks: "required",
                nagative_marks_status: "required",
                total_questions: "required",
                difficulty_level: "required",
                status: "required",
                start_date: "required",
                end_date: "required",
                result_date: "required"
            },
            messages: {
                title: "Enter event name",
                description: "Enter event description",
                department: "Select department",
                branch: "Select branch",
                batch: "Select batch",
                semester: "Select semester",
                validity_type: "Select validity type",
                validity_value: "Enter validity value",
                total_marks: "Enter total marks",
                nagative_marks_status: "Select nagative marks status",
                total_questions: "Enter total number of questions",
                difficulty_level: "Select difficulty level",
                start_date: "Select start date",
                status: "Select status",
                end_date: "Select end date",
                result_date: "Select result date"
            }
        });
    });
</script>


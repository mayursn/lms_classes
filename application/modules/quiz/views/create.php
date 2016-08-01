<?php
$this->load->model('department/Degree_model');
$department = $this->Degree_model->order_by_column('d_name');
?>

<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body"> 

                <div class="box-content">  

                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                       
                    <?php echo form_open(base_url() . 'quiz/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'eventform', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("title"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" value=""/>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("description"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control" rows="3"></textarea>									</div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="department" id="department">
                                    <option value="">Select</option>
                                    <?php foreach ($department as $row) { ?>
                                        <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="branch" id="branch">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("batch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="batch" id="batch">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("semester"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="semester" id="semester">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("validity type"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="validity_type" id="validity-type">
                                    <option value="">Select</option>
                                    <option value="Day">Day</option>
                                    <option value="Attempt">Attempt</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("validity value"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="number" name="validity_value" id="validity-value" class="form-control" value="1"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("total questions"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input id="total-questions" class="form-control" type="number" name="total_questions"/>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("total marks"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="number" name="total_marks" id="total-marks" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("nagative marks status"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select id="nagative-marks-status" class="form-control" name="nagative_marks_status">
                                    <option value="">Select</option>
                                    <option value="0">Off</option>
                                    <option value="1">On</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group hide" id="nagative-mark-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("nagative marks"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input id="nagative-mark" class="form-control" name="nagative_marks"/>
                            </div>
                        </div>        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("timer status"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select id="timer-status" class="form-control" name="timer_status">
                                    <option value="">Select</option>
                                    <option value="1">On</option>
                                    <option value="0">Off</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group hide" id="timer-status-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("timer value"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input id="timer-value" class="form-control" type="number" name="timer_value" placeholder="In minute"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("difficulty level"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select id="difficulty-level" class="form-control" name="difficulty_level">
                                    <option value="">Select</option>
                                    <option value="Easy">Easy</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select id="status" class="form-control" name="status">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Start Date<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="start_date" value=""/>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label">End Date<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="end_date" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Result Date<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="result_date" value=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                            </div>
                        </div>
                    </div>    
                    <?php echo form_close(); ?>  
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function () {

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
                if (status == '1') {
                    $('#nagative-mark-group').removeClass('hide');
                    $('#nagative-mark').attr('required', 'required');
                } else {
                    $('#nagative-mark-group').addClass('hide');
                    $('#nagative-mark').val('');
                    $('#nagative-mark').removeAttr('required');
                }
            });

            $('#timer-status').on('change', function () {
                var timer_status = $(this).val();
                if(timer_status == '1') {
                    $('#timer-status-group').removeClass('hide');
                    $('#timer-value').attr('required', 'required');
                } else {
                    $('#timer-status-group').addClass('hide');
                    $('#timer-value').removeAttr('required');
                    $('#timer-value').val('');
                }
            });

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

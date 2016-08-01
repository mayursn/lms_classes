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
                                                        <option value="All" <?php
                                        if ($quiz->department_id == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>
                                                        <?php  foreach ($department as $rowdegree) {
                                                    if ($rowdegree->d_id == $quiz->department_id) {
                                                        ?>
                                                <option value="<?= $rowdegree->d_id ?>" selected><?= $rowdegree->d_name ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $rowdegree->d_id ?>"><?= $rowdegree->d_name ?></option>							
                                                <?php
                                            }
                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("branch"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="branch" id="branch">
                                                        <option value="">Select</option>
                                                         <option value="All" <?php
                                        if ($quiz->branch_id == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>
                                                         <?php
                                                         foreach ($branch as $crs) {
                                                    ?>
                                            <option value="<?php echo $crs->course_id ?>" <?php
                                            if ($crs->course_id == $quiz->branch_id) {
                                                echo "selected='selected'";
                                            }
                                            ?> ><?= $crs->c_name ?></option>
                                                    <?php
                                                } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("batch"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="batch" id="batch">
                                                        <option value="">Select</option>
                                                         <option value="All" <?php
                                        if ( $quiz->batch_id == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>
                                                         <?php
                                                         foreach ($batch as $row1) {
                                                    if ($row1->b_id == $quiz->batch_id) {
                                                        ?>
                                                <option value="<?= $row1->b_id ?>" selected><?= $row1->b_name ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $row1->b_id ?>" ><?= $row1->b_name ?></option>
                                                <?php
                                            }
                                        }
                                                         ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("semester"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="semester" id="semester">
                                                        <option value="">Select</option>
                                                       <option value="All" <?php
                                        if ($quiz->semester_id == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>  
                                                       <?php foreach ($semester as $rowsem) {
                                                    if ($rowsem->s_id == $quiz->semester_id) {
                                                        ?>
                                                <option value="<?= $rowsem->s_id ?>" selected><?= $rowsem->s_name ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $rowsem->s_id ?>" ><?= $rowsem->s_name ?></option>
                                                <?php
                                            }
                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php 
                                            $sem_id = $quiz->semester_id;
                                            $branch_id = $quiz->branch_id;
                                            $department_id = $quiz->department_id;
                                            $this->load->model('subject/Subject_manager_model');
                                           if($department_id!="All" && $branch_id!="All" || $sem_id!="All"){
                                            $subject = $this->Subject_manager_model->subject_from_dept_branch_sem($department_id,$branch_id,$sem_id);
                                           }
                                           
                                            ?>
                                            <div class="form-group subject <?php if($department_id=="All" && $branch_id=="All" || $sem_id=="All"){  echo "hidden"; } ?>">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("Subject"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="subject" id="subject">
                                                        <option value="">Select</option>
                                                        <option value="All"
                                                        <?php if ($quiz->sm_id == "All") {    echo "selected=selected"; } ?>>All</option>  
                                                        <?php foreach ($subject as $sub): ?>
                                                        <option value="<?php echo $sub->sm_id; ?>" <?php if ($quiz->sm_id == $sub->sm_id) {    echo "selected=selected"; } ?>><?php echo $sub->subject_name; ?></option>
                                                        <?php endforeach; ?>
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
                                                           value="<?php echo $quiz->validity_value; ?>" min="1"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo ucwords("total questions"); ?><span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input id="total-questions" class="form-control" type="number" name="total_questions"
                                                           value="<?php echo $quiz->total_questions; ?>" min="1"  />
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
                                            <div class="form-group hidden">
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
                                                    <input type="text" class="form-control datepicker" name="start_date" id="startdate"
                                                           value="<?php echo date_formats($quiz->start_date); ?>"/>
                                                </div>
                                            </div>	
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">End Date<span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control " id="enddate" name="end_date" 
                                                           value="<?php if($quiz->validity_type=="Day"){ echo date_formats($quiz->end_date); } ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-sm-3 control-label">Result Date<span style="color:red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control datepicker" name="result_date" 
                                                           value="<?php  echo date_formats($quiz->result_date);  ?>"/>
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
                            <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/quiz_createquestion/<?php echo $quiz->quiz_id; ?>');" data-toggle="modal"><i class="fa fa-plus"></i> Quiz</a>
                            
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
 $( "#enddate" ).focusin(function() {
         $(this).prop('readonly', true);
      });
      $( "#enddate" ).focusout(function() {
         $(this).prop('readonly', false);
      });
      
    $(document).ready(function () {
        
        $(window).load(function(){
            if($('#validity-type').val()=="Attempt")
            {
                 $("#enddate").datepicker({
                                format: js_date_format,
                                autoclose: true,
                                todayHighlight: true
                            });
            }
        });
        
        
        var js_date_format = '<?php echo js_dateformat(); ?>';

       // $('#department').val('<?php echo $quiz->department_id; ?>');
        //department_branch('<?php echo $quiz->department_id; ?>');

        $('#validity-type').val('<?php echo $quiz->validity_type; ?>');

        $('#nagative-marks-status').val('<?php echo $quiz->nagative_mark_status; ?>');
        nagative_marks_status('<?php echo $quiz->nagative_mark_status; ?>');

        $('#timer-status').val('<?php echo $quiz->nagative_mark_status; ?>');
        timer_status('<?php echo $quiz->timer_status; ?>');

        $('#difficulty-level').val('<?php echo $quiz->difficulty_level; ?>');

        $('#status').val('<?php echo $quiz->status; ?>');

        
//        $('#branch').on('change', function () {
//            var branch_id = $(this).val();
//            var department = $('#department').val();
//            batch_form_department_branch(department, branch_id);
//            semester_from_branch(branch_id);
//        });

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

        

        var js_date_format = '<?php echo js_dateformat(); ?>';
            
            function set_startdate(mindate)
            {
                
                $("#enddate").datepicker( {
                    format: js_date_format,
                    autoclose: true,
                     startDate: mindate,
                    todayHighlight: true
                });
            }
            
             $("#startdate").datepicker({
                 autoclose: true,
                 startDate: new Date(),
                  format: js_date_format,
             }).on('changeDate', function (selected) {
                $("#enddate").val('');
                 if($('#validity-type').val()=='Day')
                 {
                     var days = $('#validity-value').val();
                     var date_format = $("#startdate").val();
                     if(date_format!="")
                     {
                     var dataString = "getdate="+date_format+"&days="+days;
                     $.ajax({
                         type:"POST",
                         url:"<?php echo base_url() ?>quiz/change_dateformat",
                         data:dataString,
                         success:function(response){
                             $('#enddate').val(response);
                         }
                     });
                     }
                }
                else
                {
                 
                    var minDate = new Date(selected.date.valueOf());
                    $("#enddate").datepicker("remove");
                    set_startdate(minDate);
                }   
           });
            $('#validity-value').on('change', function () {
                if($('#validity-type').val()=='Day')
                 {
                    var days = $('#validity-value').val();
                     var date_format = $("#startdate").val();
                     if(date_format!="")
                     {
                     var dataString = "getdate="+date_format+"&days="+days;
                     $.ajax({
                         type:"POST",
                         url:"<?php echo base_url() ?>quiz/change_dateformat",
                         data:dataString,
                         success:function(response){
                             $('#enddate').val(response);
                         }
                     });
                     }
                 }
                
            });
             $('#validity-type').on('change', function () {
                if($(this).val()=='Day')
                 {
                     $("#enddate").datepicker("remove");
                     
                         var days = $('#validity-value').val();
                     var date_format = $("#startdate").val();
                     if(date_format!="")
                     {
                     var dataString = "getdate="+date_format+"&days="+days;
                     $.ajax({
                         type:"POST",
                         url:"<?php echo base_url() ?>quiz/change_dateformat",
                         data:dataString,
                         success:function(response){
                             $('#enddate').val(response);
                         }
                     });
                     }
                }
                else
                {
                   if($("#startdate").val()!="")
                   {
                            $("#enddate").datepicker("remove");
                        set_startdate(new Date($("#startdate").datepicker('getDate')));
                    }
                    else
                    {
                        var currentDate = new Date();                      
                        $("#enddate").datepicker("remove");
                        set_startdate(currentDate);
                    }
                }
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
                title: "Enter quiz name",
                description: "Enter  description",
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
        
        $("#department").change(function () {
        var degree = $(this).val();
        var dataString = "degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'digital/get_cource/'; ?>",
            data: dataString,
            success: function (response) {
                $('#branch').find('option').remove().end();
                $('#branch').append('<option value>Select</option>');
                $('#branch').append('<option value="All">All</option>');
                if (degree == "All")
                {
                    subject_hide();
                    $("#branch").val($("#branch option:eq(1)").val());
                    $("#batch").val($("#batch option:eq(1)").val());
                    $("#semester").val($("#semester option:eq(1)").val());
                } else {
                    subject_show();
                    var branch = jQuery.parseJSON(response);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#branch').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }

            }
        });
    });


    $("#batch").change(function () {
        var batches = $("#batch").val();
        if (batches == 'All')
        {
            $("#semester").val($("#semester option:eq(1)").val());
        }
    });
function subject_hide()
{
    $(".subject").addClass('hidden');
}
function subject_show()
{
    $(".subject").removeClass('hidden');
}

    $("#branch").change(function () {
        var course = $(this).val();        
        var degree = $("#department").val();
        var dataString = "course=" + course + "&degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'digital/get_batchs/'; ?>",
            data: dataString,
            success: function (response) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'digital/get_semesterall/'; ?>",
                    data: {'course': course},
                    success: function (response1) {
                        $('#semester').find('option').remove().end();
                        $('#semester').append('<option value>Select</option>');
                        $('#semester').append('<option value="All">All</option>');
                        if (course == "All")
                        {
                              subject_hide();
                            $("#semester").val($("#semester option:eq(1)").val());
                        } else {
                              subject_show();
                            var sem_value = jQuery.parseJSON(response1);
                            console.log(sem_value);
                            $.each(sem_value, function (key, value) {
                                $('#semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                            });
                        }
                    }
                });
                $('#batch').find('option').remove().end();
                $('#batch').append('<option value>Select</option>');
                $('#batch').append('<option value="All">All</option>');
                //$("#semester").val($("#semester option:eq(1)").val());
                if (course == "All")
                {
                    subject_hide();
                    $("#batch").val($("#batch option:eq(1)").val());
                    $("#semester").val($("#semester option:eq(1)").val());
                } else {
                    subject_show();
                    var batch_value = jQuery.parseJSON(response);
                    console.log(batch_value);
                    $.each(batch_value, function (key, value) {
                        $('#batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            }
        });
    });


    });
</script>


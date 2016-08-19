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
                                    <option value="All">All</option>
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
                                    <option value="All">All</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("batch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="batch" id="batch">
                                    <option value="">Select</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("semester"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="semester" id="semester">
                                    <option value="">Select</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group subject">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Subject"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="subject" id="subject">
                                    <option value="">Select</option>
                                    <option value="All">All</option>
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
                                <input type="number" name="validity_value" id="validity-value" class="form-control" value="1" min="1" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("total questions"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input id="total-questions" class="form-control" type="number" name="total_questions" min="1" />
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("total marks"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="number" name="total_marks" id="total-marks" min="1" class="form-control"/>
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
                                <input type="number" id="nagative-mark" class="form-control" name="nagative_marks" min="0"/>
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
                                <input id="timer-value" class="form-control" type="number" name="timer_value" min="1" placeholder="In minute"/>
                            </div>
                        </div>
                        <div class="form-group hidden">
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
                                <input type="text" class="form-control " id="startdate" name="start_date" value=""  />
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label">End Date<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="enddate" name="end_date" value=""/>
                            </div>
                        </div>
                        <div class="form-group hidden">
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

 $( "#enddate" ).focusin(function() {
         $(this).prop('readonly', true);
      });
      $( "#enddate" ).focusout(function() {
         $(this).prop('readonly', false);
      });

        $(document).ready(function () {

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
                else{
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
                    status: "required",
                    start_date: "required",
                    end_date: "required"
                    
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
                    start_date: "Select start date",
                    status: "Select status",
                    end_date: "Select end date"
                    
                }
            });
        });
    </script>
    
    <script>
        $(document).ready(function(){
            $("#department").change(function () {
        var degree = $(this).val();
        var dataString = "degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'participate/get_cource/'; ?>",
            data: dataString,
            success: function (response) {
                  $('#branch').find('option').remove().end();
                $('#branch').append('<option value>Select</option>');
                $('#branch').append('<option value="All">All</option>');
                if (degree == "All")
                {
                    subject_hide();
                    $("#batch").val($("#batch option:eq(1)").val());
                    $("#branch").val($("#branch option:eq(1)").val());
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
                        if(course=="All")
                        {
                            subject_hide();
                            $("#semester").val($("#semester option:eq(1)").val());
                        }
                        else{
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

$("#batch").change(function () {
        var batches = $("#batch").val();
        if (batches == 'All')
        {
            subject_hide();
            $("#semester").val($("#semester option:eq(1)").val());
        }
    }); 
    $("#semester").change(function(){
        var branch = $("#branch").val();
        var department = $("#department").val();
        var sem = $(this).val();
        subject_list_from_department_branch_semester(department,branch,sem);
    });
     function subject_list_from_department_branch_semester(department, branch, semester)
        {
              $('#subject').find('option').remove().end();
              $('#subject').append('<option value>Select</option>');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>subject/subject_department_branch_sem/" + department + '/' + branch + '/' + semester ,
                success: function (response) {
                    var subject = jQuery.parseJSON(response);
                    $.each(subject, function (key, value) {
                        $('#subject').append('<option value=' + value.sm_id + '>' + value.subject_name + '</option>');
                    });
                }
            });
        }
        });
        </script>

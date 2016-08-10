<?php
$this->load->model('subject/Subject_manager_model');
$edit_data = $this->db->select('exam_time_table.*,exam_time_table.branch_id as schedule_branch,exam_manager.*,subject_manager.*')
        ->from('exam_time_table')
        ->join('exam_manager', 'exam_manager.em_id = exam_time_table.exam_id')
        ->join('subject_manager', 'subject_manager.sm_id = exam_time_table.subject_id')
        ->join('course', 'course.course_id = exam_manager.course_id')
        ->join('admission_plan', 'admission_plan.admission_plan_id = exam_manager.admission_plan_id')
        ->where('exam_time_table.exam_time_table_id', $param2)
        ->get()
        ->row();


$course_id = $edit_data->course_id;
$branch_id = $edit_data->schedule_branch;
$admission_plan_id = $edit_data->admission_plan_id;
$this->load->model('admission_plan/Admission_plan_model');
$admission_plan = $this->Admission_plan_model->order_by_column('admission_duration');


$this->db->distinct('em_name');
$exam_list = $this->db->get_where('exam_manager', array('course_id' => $course_id,
            'admission_plan_id' => $admission_plan_id,
            'branch_id' => $branch_id) )->result();

$exam_type = $this->db->get('exam_type')->result();
$branch = $this->db->get('branch_location')->result();
$course = $this->db->get_where('course')->result();

$subjects = $this->Subject_manager_model->subject_list_admission_plan($branch_id,$course_id,$admission_plan_id);
       // $this->db->get_where('subject_manager',[
  //  'sm_course_id'  => $course_id,
   //'sm_sem_id' => $semester_id
//])->result();
?>
<div class="row">

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <!-- Start .panel -->           
            <div class=panel-body>
                <?php echo form_open(base_url() . 'examschedual/update/' . $edit_data->exam_time_table_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'edit-exam-time-table', 'target' => '_top')); ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Branch").$edit_data->branch_id; ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select name="branch" id="edit_branch" class="form-control" required="">
                            <option value="">Select</option>
                            <?php foreach ($branch as $d) { ?>
                                <option value="<?php echo $d->branch_id; ?>"
                                        <?php if ($d->branch_id == $edit_data->branch_id) echo 'selected'; ?>><?php echo $d->branch_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>                  
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select name="course" id="edit_course" class="form-control" required="">
                            <option value="">Select</option>
                            <?php foreach ($course as $c) { ?>
                                <option value="<?php echo $c->course_id; ?>"
                                        <?php if ($c->course_id == $edit_data->course_id) echo 'selected'; ?>><?php echo $c->c_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span> <?php echo $edit_data->admission_plan_id; ?></label>
                        <div class="col-sm-8">
                            <select name="admission_plan" class="form-control" id="edit_admission_plan">
                                <option value="">Select</option>
                                <?php foreach ($admission_plan as $plan): ?>
                                <option value="<?php echo $plan->admission_plan_id; ?>" <?php if($edit_data->admission_plan_id==$plan->admission_plan_id){ echo "selected=selected"; } ?>><?php echo $plan->admission_duration; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>            
                              
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Exam"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="edit_exam" name="exam" required="">
                            <option value="">Select</option>
                            <?php foreach ($exam_list as $exams) { ?>
                                <option value="<?php echo $exams->em_id; ?>" <?php
                                if ($exams->em_id == $edit_data->exam_id) {
                                    echo "selected=selected";
                                }
                                ?>><?php echo $exams->em_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Subject"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="edit_subject" name="subject" required="">
                            <option value="">Select</option>
                            <?php
                            foreach($subjects as $subject) { ?>
                            <option value="<?php echo $subject->sm_id; ?>"
                                    <?php if($edit_data->sm_id == $subject->sm_id) echo 'selected'; ?>><?php echo $subject->subject_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Date"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input readonly="" type="text" required=""  name="exam_date"  id="exam_date"  class="form-control datepicker-normal-edit"
                               value="<?php echo date_formats($edit_data->em_date); ?>"  />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Start Time"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                         <div class="input-group bootstrap-timepicker">
                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        <input type="text" id="start_time" class="form-control" name="start_time"
                               value="<?php echo $edit_data->exam_start_time; ?>" required=""/>
                         </div>
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("End Time"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                         <div class="input-group bootstrap-timepicker">
                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        <input type="text" id="end_time" class="form-control" name="end_time"
                               value="<?php echo $edit_data->exam_end_time; ?>" required=""/>
                         </div>
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
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>


<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

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
        $("#edit-exam-time-table").validate({
            rules: {
                branch: "required",
                course: "required",
                admission_plan: "required",                
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
                branch: "Please select branch",
                course: "Please select course",
                admission_plan: "Please select admission plan",                
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

<script type="text/javascript">
    $(function () {
 $( "#exam_date" ).focusin(function() {
         $(this).prop('readonly', true);
      });
      $( "#exam_date" ).focusout(function() {
         $(this).prop('readonly', false);
      });
      
  var js_date_format = '<?php echo js_dateformat(); ?>';
    $("#edit_exam").change(function(){
    var id= $(this).val();
    $('#exam_date').val('');
    if(id!="")
    {
        $.ajax({
              url: '<?php echo base_url(); ?>exam/getexam/'+id,
              type: 'post',
              dataType:'json',
              success: function (content) {
                  var startdate= new Date(content.em_date);
                  var enddate= new Date(content.em_end_time);
                    $("#exam_date").datepicker("remove");
                    
                  $('#exam_date').datepicker({
                        format:js_date_format,
                        autoclose: true,
                        startDate: startdate,
                        endDate:enddate,
                    });
              }
          })
    }
})

        $(".datepicker-normal-edit").datepicker({
            format: js_date_format, startDate : new Date(),
            changeMonth: true,
            changeYear: true,
            autoclose:true,

        });
    });
</script>

<script>
   
    $(document).ready(function () {
        $('#edit_course').on('change', function () {
        var course_id = $(this).val();
        
        get_admission_plan(course_id);        
    });
    function get_admission_plan(course_id)
    {
     $('#edit_admission_plan').find('option').remove().end();
        $('#edit_admission_plan').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);
                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#edit_admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                });
            }
        });
    }
    
    $("#edit_admission_plan").on('change',function(){
        var admission_plan = $(this).val();
        var course = $("#edit_course").val();
        var branch = $("#edit_branch").val();
        exam_list_from_degree_and_course(branch,course,admission_plan);
        subject_list(branch,course, admission_plan);
    });
    //exam list from degree and course
        function exam_list_from_degree_and_course(branch, course, admission_plan) {
            $('#edit_exam').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>exam/exam_list_from_degree_and_course/' + branch + '/' + course + '/' + admission_plan +'/reguler',
                type: 'get',
                success: function (content) {
                    $('#edit_exam').append('<option value="">Select</option>');
                    var exam_list = jQuery.parseJSON(content);
                    $.each(exam_list, function (key, value) {
                        $('#edit_exam').append('<option value=' + value.em_id + '>' + value.em_name + '</option>');
                    })
                }
            })
        }
        // subject list from course and semester
        function subject_list(branch,course, admission_plan) {
            $('#edit_subject').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>subject/subject_list_admission_plan/'+branch+ '/' + course + '/' + admission_plan,
                type: 'get',
                success: function (content) {
                    $('#edit_subject').append('<option value="">Select</option>');
                    var subject = jQuery.parseJSON(content);
                    $.each(subject, function (key, value) {
                        $('#edit_subject').append('<option value=' + value.sm_id + '>' + value.subject_name + '</option>');
                    })
                }
            })
        }
    });
</script>

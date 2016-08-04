<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title><?php echo $title; ?></h4>
                            <div class="panel-controls panel-controls-right">
                                <a class="panel-refresh" href="#"><i class="fa fa-refresh s12"></i></a>
                                <a class="toggle panel-minimize" href="#"><i class="fa fa-plus s12"></i></a>
                                <a class="panel-close" href="#"><i class="fa fa-times s12"></i></a>
                            </div>
                        </div>-->
            <div class=panel-body>
                <div class="row filter-row">
                    <form id="attendance-list-filter" action="<?php echo base_url(); ?>attendance/class_routine" method="post" class="form-groups-bordered form-horizontal validate">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Branch<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="branch" id="filter-branch" required="">
                                    <option value="">Select</option>
                                    <?php foreach ($branch as $row) { ?>
                                        <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Course<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="course" id="filter-course" required="">
                                    <option  value="">Select</option>
                                    <?php  foreach($course as $crs): ?>
                                    <option value="<?php echo $crs->course_id; ?>"><?php echo $crs->c_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Admission Plan<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="admission_plan" id="filter-admission_plan" required="">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Class<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="class" id="filter-class" required="">
                                    <option value="">Select</option>                
                                    <?php foreach($class as $cl): ?>
                                    <option value="<?php echo $cl->class_id; ?>"><?php echo $cl->class_id; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Subject<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="subject" id="filter-subject" required="">
                                    <option value="">Select</option>                                                    
                                </select>
                            </div>
                        </div>   
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date <span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="date" id="filter-date" required="">
                                    <option value="">Select</option>                                                    
                                </select>
                            </div>
                        </div>  
                        <div class="form-group">
                            <div class="col-sm-6 col-md-offset-2">
                                <input id="search-filter-attendance" type="submit" value="Search" class="btn btn-info vd_bg-green"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="student-attendance-list" >
                    <div class="col-md-12">          
                        <h4>Attendance Details
                        
                        </h4>
                        <table class="table table-condensed ex1">
                            <tr>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Branch</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $branch_name->branch_name; ?></td>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Course</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $course_name->c_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Admission Plan</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $admission_duration->admission_duration; ?></td>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Class</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $class_name->class_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Subject</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $subject_name->subject_name; ?></td>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Date</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo date('M d, Y', strtotime($date)); ?></td>
                            </tr>
                            <tr style="display: none;">
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Time</strong></td>
                                <td colspan="3" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <?php //echo date('h:i A', strtotime($start_time)) . ' - ' . date('h:i A', strtotime($end_time)); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        
                        <?php if (count($attendance)) { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4>Attendance List</h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table id="class-routine-list" class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <th>Student</th>
                                                <th>Status</th>
                                                <th>Branch</th>                                                
                                                <th>Course</th>
                                                <th>Admission Plan</th>                                                                                                                                                                                               
                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            foreach ($attendance as $routine) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $counter++; ?></td>
                                                    <td><?php echo $routine->std_first_name.' '.$routine->std_last_name; ?></td>
                                                      <td><?php if($routine->is_present=='1'){ echo "P"; }else{ echo "A"; } ?></td>
                                                    <td><?php echo $routine->branch_name; ?></td>
                                                    <td><?php echo $routine->c_name; ?></td>
                                                    <td><?php echo $routine->admission_duration; ?></td>                                                                                                                                                                                                         
                                                  
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } else { ?>
                            
                        <?php } ?>
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
        $('#class-routine-list').DataTable({});
        "use strict";

        $("#attendance-routine").validate({
            rules: {
                'department': "required",
                'branch': "required",
                'batch': "required",
                'semester': "required",
                'class': "required",
                'date': "required",
                'class_routine': "required",
            },
            messages: {
                'department': "Select department",
                'branch': "Select branch",
                'batch': "Select batch",
                'semester': "Select semester",
                'class': "Select class",
                'date': "Select date",
                'class_routine': "Select class routine"
            }
        });
  var js_format = '<?php echo js_dateformat(); ?>';
        $(".datepicker-normal").datepicker({
            format: js_format,
            todayHighlight: true,
            autoclose: true

        });
    });
    /**
     * Start Attendance filter
     * @param {string} param1
     * @param {int} param2
     */
    $("#filter-course").on('change',function(){
        var course_id = $(this).val();        
        get_admission_plan_filter(course_id);        
    });
    function get_admission_plan_filter(course_id)
    {
     $('#filter-admission_plan').find('option').remove().end();
        $('#filter-admission_plan').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);
                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#filter-admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                });
            }
        });
    }
    $("#filter-admission_plan").on('change',function(){
        var admission_plan = $(this).val();
        var course = $("#filter-course").val(); 
        var branch = $("#filter-branch").val(); 
        get_subject_list_filter(branch,course,admission_plan);        
    });
     function get_subject_list_filter(branch,course,admission_plan)
    {       
        $('#filter-subject').find('option').remove().end();
        $('#filter-subject').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>subject/subject_list_admission_plan/'+ branch + '/' + course + '/'+admission_plan,
            type: 'GET',
            success: function (content) {
                var subject = jQuery.parseJSON(content);                
                console.log(subject);
                $.each(subject, function (key, value) {
                    $('#filter-subject').append('<option value=' + value.sm_id + '>' + value.subject_name + '</option>');
                });
            }
        })
    }
    
    $("#filter-subject").on('change',function(){
        var admission_plan = $("#filter-admission_plan").val();
        var course = $("#filter-course").val(); 
        var subject = $(this).val(); 
        var branch = $("#filter-branch").val();
        var class_name = $("#filter-class").val();
        get_date_list(branch,course,admission_plan,subject,class_name);
    });
    
    function get_date_list(branch,course,admission_plan,subject,class_name)
    {
        
        $('#filter-date').find('option').remove().end();
        $('#filter-date').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>attendance/get_date_list/'+ branch + '/' + course + '/'+admission_plan+ '/'+subject+'/'+class_name,
            type: 'GET',
            success: function (content) {
                var dates = jQuery.parseJSON(content);                
                console.log(dates);
                $.each(dates, function (key, value) {
                    $('#filter-date').append('<option value=' + value.date_taken + '>' + value.date_taken + '</option>');
                });
            }
        })
    }
    
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
        get_subject_list(branch,course,admission_plan);        
    });
    
    function get_subject_list(branch,course,admission_plan)
    {       
        $('#subject').find('option').remove().end();
        $('#subject').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>subject/subject_list_admission_plan/'+ branch + '/' + course + '/'+admission_plan,
            type: 'GET',
            success: function (content) {
                var subject = jQuery.parseJSON(content);                
                console.log(subject);
                $.each(subject, function (key, value) {
                    $('#subject').append('<option value=' + value.sm_id + '>' + value.subject_name + '</option>');
                });
            }
        })
    }
</script>
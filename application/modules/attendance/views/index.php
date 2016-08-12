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
                    <div class=panel-heading>
                            <h4 class=panel-title><?php echo "Take Attendance"; ?></h4>                            
                    </div>
                    <form id="attendance-routine" action="#" method="post" class="form-groups-bordered form-horizontal validate">
                         <div class="form-group">
                            <label class="col-sm-2 control-label">Branch<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="branch" id="branch" >
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
                                <select class="form-control" name="course" id="course" >
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
                                <select class="form-control" name="admission_plan" id="admission_plan" >
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Class<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="class" id="create-class" >
                                    <option value="">Select</option>                
                                    <?php foreach($class as $cl): ?>
                                    <option value="<?php echo $cl->class_id; ?>"><?php echo $cl->class_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Subject<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="subject" id="subject" >
                                    <option value="">Select</option>                                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <input id="date" type="text" class="form-control datepicker-normal" name="date" placeholder="Select"
                                       value="<?php echo $date; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-md-offset-2">
                                <input id="search-exam-data" type="submit" value="Submit" class="btn btn-info vd_bg-green"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="student-attendance-list"  >
                    <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4>Search Attendance</h4>
                                    </div>
                                </div>
                    <div class="col-md-12">
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
                                <select class="form-control" name="course" id="filter-course" >
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
                                <select class="form-control" name="admission_plan" id="filter-admission_plan" >
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Class<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="class" id="filter-class" >
                                    <option value="">Select</option>                
                                    <?php foreach($class as $cl): ?>
                                    <option value="<?php echo $cl->class_id; ?>"><?php echo $cl->class_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Subject<span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="subject" id="filter-subject">
                                    <option value="">Select</option>                                                    
                                </select>
                            </div>
                        </div>   
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date <span style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="date" id="filter-date">
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
                        <?php if (@$professor_class_routine_list) { ?>
                        <div class="panel panel-default" style="display:none;" >
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4>Class Routine List</h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table id="class-routine-list" class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <th>Branch</th>
                                                <th>Course</th>
                                                <th>Admission Plan</th>                                                
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            foreach ($professor_class_routine_list as $routine) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $counter++; ?></td>
                                                    <td><?php echo $routine->branch_name; ?></td>
                                                    <td><?php echo $routine->c_name; ?></td>
                                                    <td><?php echo $routine->admission_duration; ?></td>                                                                                                     
                                                    <td><?php 
                                                        echo date('h:i A', strtotime($routine->Start)) . ' - ' .
                                                        date('h:i A', strtotime($routine->End));
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $this->load->model('attendance/Attendance_model');
                                                        $status = $this->Attendance_model->class_routine_status($routine->ClassRoutineId, date('Y-m-d', strtotime($date)));
                                                        ?>

                                                        <?php
                                                        if ($status) {
                                                            echo 'Done';
                                                        } else {
                                                            echo 'Pending';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>attendance/take_attedance/<?php echo $routine->ClassRoutineId; ?>/<?php echo date('Y-m-d', strtotime($date)) ?>">
                                                            <span class="label label-primary mr6 mb6">
                                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                Attendance
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } else { ?>
                        <div class="panel panel-default" style="display: none;">
                                <div class="panel-heading">
                                    <div class="panel-title">Class Routine List</div>
                                </div>
                                <div class="panel-body">
                                    <table id="class-routine-list" class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <th>Department</th>
                                                <th>Branch</th>
                                                <th>Semester</th>
                                                <th>Class</th>
                                                <th>Subject</th>
                                                <th>Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (count($student)) { ?>
                            <?php
                            $this->load->model('admin/Crud_model');
                            ?>
                            <br/>
                            <form method="post" action="<?php echo base_url(); ?>attendance/take_class_routine_attendance"
                                  class="form-groups-bordered">
                                <input type="hidden" name="department" value="<?php echo $department; ?>"/>
                                <input type="hidden" name="branch" value="<?php echo $branch; ?>"/>
                                <input type="hidden" name="batch" value="<?php echo $batch; ?>"/>
                                <input type="hidden" name="semester" value="<?php echo $semester; ?>"/>
                                <input type="hidden" name="class" value="<?php echo $class_name; ?>"/>
                                <input type="hidden" name="professor" value="<?php echo $professor; ?>"/>
                                <input type="hidden" name="class_routine" value="<?php echo $class_routine; ?>"/>
                                <input type="hidden" name="date" value="<?php echo $date; ?>"/>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4>Student List</h4>

                                        </div>
                                    </div>
                                    <div class="panel-body">                                        
                                        <table class="table table-striped table-bordered table-responsive" id="attendance-data-table-2">
                                            <thead>
                                            <th>No</th>
                                            <th>Roll No</th>
                                            <th>Student Name</th>
                                            <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $counter = 1;
                                                $date = date('Y-m-d', strtotime($date));
                                                foreach ($student as $row) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $counter++; ?></td>
                                                        <td><?php echo $row->std_roll; ?></td>
                                                        <td><?php echo $row->std_first_name . ' ' . $row->std_last_name; ?></td>
                                                        <?php
                                                        $status = $this->Crud_model->check_attendance_status($department, $branch, $batch, $semester, $class_name, $class_routine, $date, $row->std_id);
                                                        ?>
                                                        <td>
                                                            <?php if (isset($status)) { ?>
                                                                <input type="checkbox" name="student_<?php echo $row->std_id; ?>" 
                                                                       <?php if ($status->is_present == 1) echo 'checked=""'; ?>/>
                                                                   <?php } else { ?>
                                                                <input type="checkbox" name="student_<?php echo $row->std_id; ?>" checked=""/>
                                                            <?php }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <input type="submit" value="Submit" class="btn btn-info"/>
                            </form>
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
                'course': "required",
                'branch': "required",
                'admission_plan': "required",                
                'class': "required",
                'date': "required",
                'subject': "required",
            },
            messages: {
                'course': "Select course",
                'branch': "Select branch",
                'admission_plan': "Select admission plan",                
                'class': "Select class",
                'date': "Select date",
                'subject': "Select subject"
            }
        });
        $("#attendance-list-filter").validate({
            rules: {
                'course': "required",
                'branch': "required",
                'admission_plan': "required",                
                'class': "required",
                'date': "required",
                'subject': "required",
            },
            messages: {
                'course': "Select course",
                'branch': "Select branch",
                'admission_plan': "Select admission plan",                
                'class': "Select class",
                'date': "Select date",
                'subject': "Select subject"
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
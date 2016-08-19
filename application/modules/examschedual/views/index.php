<!-- Start .row -->
<!-- Start .row -->
<?php
$create = create_permission($permission, 'Exam_Schedual');
$read = read_permission($permission, 'Exam_Schedual');
$update = update_permisssion($permission, 'Exam_Schedual');
$delete = delete_permission($permission, 'Exam_Schedual');
?>
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
                <?php if($create){ ?>
              <a href="#" class="links"   onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/examschedual_create');" data-toggle="modal"><i class="fa fa-plus"></i> Exam Schedule</a>
                <?php } ?>
              <?php if($create || $read || $update || $delete){ ?>
              <form id="exam-schedule-search" action="#" class="form-groups-bordered validate">
                    
                <div class="row filter-row">
				
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("branch"); ?></label>
                        <select class="form-control" id="search-branch"name="branch">
                            <option value="">Select</option>
                            <?php foreach ($branch as $row) { ?>
                                <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("Course"); ?></label>
                        <select id="search-course" name="course" data-filter="4" class="form-control">
                            <option value="">Select</option>
                            <?php foreach ($course as $crs):  ?>
                            <option value="<?php echo $crs->course_id; ?>"><?php echo $crs->c_name; ?></option>
                            <?php endforeach;
?>
                        </select>
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("Admission Plan"); ?></label>
                        <select id="search-admission_plan" name="admission_plan" data-filter="5" class="form-control">
                            <option value="">Select</option>
                        </select>
                    </div>                                                   
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label> <?php echo ucwords("Exam"); ?></label>
                        <select id="search-exam" name="exam" data-filter="6" class="form-control">
                            <option value="">Select</option>

                        </select>
                    </div>
                    <div class="form-group col-lg-1 col-md-1 col-sm-2 col-xs-2">
                        <label>&nbsp;</label><br/>
                        <input id="search-exam-data" type="button" value="Go" class="btn btn-info vd_bg-green"/>
                    </div>
                    </div>
                </form>
              <div id="main_exam_class_schedule" >
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Branch</th>
                                <th>Course</th>
                                <th>Admission Plan</th>
                                <th>Exam</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Time</th>
                                <?php if($update || $delete){ ?>
                                <th width="10%">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($time_table as $row) { ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $row->branch_name; ?></td>
                                    <td><?php echo $row->c_name; ?></td>
                                    <td><?php echo $row->admission_duration; ?></td>                                    
                                    <td><?php echo $row->em_name; ?></td>
                                    <td><?php echo $row->subject_name; ?></td>
                                    <td><?php echo date_formats($row->exam_date); ?></td>
                                    <td><?php echo date('h:i A', strtotime(date('Y-m-d') . $row->exam_start_time)) . ' to ' . date('h:i A', strtotime(date('Y-m-d') . $row->exam_end_time)); ?></td>
                                       <?php if($update || $delete){ ?>
                                    <td class="menu-action">
                                           <?php if($update){ ?>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/examschedual_edit/<?php echo $row->exam_time_table_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                           <?php } ?>
                                           <?php if($delete){ ?>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>examschedual/delete/<?php echo $row->exam_time_table_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                           <?php } ?>
                                    </td>
                                       <?php } ?>
                                </tr>
                            <?php } ?>														
                        </tbody>
                    </table>
                </div>
              <?php } ?>
              <div id="search-result-exam-schedule"></div>
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


<script>
    $(document).ready(function () {

        var form = $('#exam-schedule-search');

        $('#search-exam-data').on('click', function () {
            $("#exam-schedule-search").validate({
                rules: {
                    branch: "required",
                    course: "required",
                    admission_plan: "required",                   
                    exam: "required",
                },
                messages: {
                    branch: "Select branch",
                    course: "Select course",
                    admission_plan: "Select admission plan",                    
                    exam: "Select exam"
                }
            });

            if (form.valid() == true)
            {
                $('#exam-schedule-result').hide();
                var branch = $("#search-branch").val();
                var course = $("#search-course").val();
                var admission_plan = $("#search-admission_plan").val();                
                var exam = $('#search-exam').val();
                $.ajax({
                    url: '<?php echo base_url(); ?>examschedual/get_exam_schedule_filter/' + branch + '/'
                            + course + '/' + admission_plan + '/' + exam,
                    type: 'get',
                    success: function (content) {
                        $('#main_exam_class_schedule').hide();
                        $("#search-result-exam-schedule").html(content);
                        
                        $('#search-data-tables').DataTable({"language": { "emptyTable": "No data available" }});
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        
     
    $(document).ready(function () {
        $('#search-course').on('change', function () {
        var course_id = $(this).val();
        
        get_admission_plan(course_id);        
    });
    function get_admission_plan(course_id)
    {
     $('#search-admission_plan').find('option').remove().end();
        $('#search-admission_plan').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);
                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#search-admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                });
            }
        });
    }
    
    $("#search-admission_plan").on('change',function(){
        var admission_plan = $(this).val();
        var course = $("#search-course").val();
        var branch = $("#search-branch").val();
        exam_list_from_degree_and_course(branch,course,admission_plan);
        
    });
    //exam list from degree and course
        function exam_list_from_degree_and_course(branch, course, admission_plan) {
            $('#search-exam').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>exam/exam_list_from_degree_and_course/' + branch + '/' + course + '/' + admission_plan +'/reguler',
                type: 'get',
                success: function (content) {
                    $('#search-exam').append('<option value="">Select</option>');
                    var exam_list = jQuery.parseJSON(content);
                    $.each(exam_list, function (key, value) {
                        $('#search-exam').append('<option value=' + value.em_id + '>' + value.em_name + '</option>');
                    })
                }
            })
        }
    });

    })
</script>

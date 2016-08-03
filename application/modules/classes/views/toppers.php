<?php
$create = create_permission($permission, 'Class');
$read = read_permission($permission, 'Class');
$update = update_permisssion($permission, 'Class');
$delete = delete_permission($permission, 'Class');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
               
                <?php if ($create || $read || $update || $delete) { ?>
                    <form id="exam-schedule-search" action="#" class="form-groups-bordered validate">
                    
                <div class="row filter-row">
				
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("branch"); ?></label>
                        <select class="form-control" id="search-branch"name="branch">
                            <option value="">Select</option>
                            <?php foreach ($branch as $row) { ?>
                                <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name.' - '.$row->branch_location; ?></option>
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
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label> <?php echo ucwords("Exam"); ?></label>
                        <select id="search-exam" name="exam" data-filter="6" class="form-control">
                            <option value="">Select</option>

                        </select>
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label> <?php echo ucwords("Class"); ?></label>
                        <select id="search-class" name="class" data-filter="6" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($classes as $class_array):?>
                            <option value="<?php echo $class_array->class_id; ?>"><?php echo $class_array->class_name; ?></option>  
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="form-group col-lg-1 col-md-1 col-sm-2 col-xs-2">
                        <label>&nbsp;</label><br/>
                        <input id="search-exam-data" type="button" value="Go" class="btn btn-info vd_bg-green"/>
                    </div>
                    </div>
                </form>
                    <div id="search-result-exam-schedule">
                        
                    </div>
                    
                <?php } ?>

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
                    class:"required",
                },
                messages: {
                    branch: "Select branch",
                    course: "Select course",
                    admission_plan: "Select admission plan",                    
                    exam: "Select exam",
                    class:"Select Class",
                }
            });

            if (form.valid() == true)
            {
                $('#exam-schedule-result').hide();
                var branch = $("#search-branch").val();
                var course = $("#search-course").val();
                var admission_plan = $("#search-admission_plan").val();                
                var exam = $('#search-exam').val();
                var class_name = $("#search-class").val();
                $.ajax({
                    url: '<?php echo base_url(); ?>classes/get_toppers/' + branch + '/'
                            + course + '/' + admission_plan + '/' + exam +'/'+class_name,
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

<?php
$this->load->Model('exam/Exam_manager_model');
$this->load->model('Branch/Course_model');
$exams = $this->Exam_manager_model->exam_details();
$exam_type = $this->Exam_manager_model->get_all_exam_type();
$branch = $this->Course_model->order_by_column('c_name');
?>

<div class="row">
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh"></div>
        <div class=panel-body>
            <?php echo form_open(base_url() . 'exam/internal_create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'examform', 'target' => '_top')); ?>
            <div class="padded"> 
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="course" id="course">
                            <?php foreach ($branch as $course): ?>
                            <option value="<?php echo $course->course_id; ?>"><?php echo $course->c_name; ?></option>
                            <?php endforeach; ?>
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
                    <label class="col-sm-4 control-label"><?php echo ucwords("Subejct"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="subject" id="subject">

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Title"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="exam_name" id="exam_name"
                               value="<?php echo set_value('exam_name'); ?>"/>
                    </div>
                </div>               
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Total Marks"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="total_marks" id="total_marks"
                               value="<?php echo set_value('total_marks'); ?>"/>
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
                course: "required",                
                semester: "required",
                subject:"required",
                exam_name:"required",
                total_marks: "required"               
            },
            messages: {                
                course: "Select branch",                
                semester: "Select semester",
                subject:"Select subject",
                exam_name:"Enter title",
                total_marks: "Enter total marks",
                
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
            var course_id = $(this).val();         
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
        
        function get_subject_from_branch_semester(course_id,semester_id)
        {
           $('#subject').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>subject/subejct_list_branch_sem/' + course_id +'/'+semester_id,
                type: 'get',
                success: function (content) {
                    $('#subject').append('<option value="">Select</option>');
                    var subject = jQuery.parseJSON(content);
                    $.each(subject, function (key, value) {
                        $('#subject').append('<option value=' + value.sm_id + '>' + value.subject_name + '</option>');
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
        $("#semester").change(function(){
        var course_id = $("#course").val();
        var semester_id = $(this).val();
        get_subject_from_branch_semester(course_id,semester_id);
        });

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
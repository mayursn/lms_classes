<!-- Start .row -->
<?php
$create = create_permission($permission, 'Exam_Marks');
$read = read_permission($permission, 'Exam_Marks');
$update = update_permisssion($permission, 'Exam_Marks');
$delete = delete_permission($permission, 'Exam_Marks');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
            <div class=panel-body>
                <?php if ($create || $read || $update || $delete) { ?>
                    <form class="form-groups-bordered validate">
                        <div class="col-md-12">
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
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label> <?php echo ucwords("Exam"); ?></label>
                        <select id="search-exam" name="exam" data-filter="6" class="form-control">
                            <option value="">Select</option>

                        </select>
                    </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12 validating">
                                <label><?php echo ucwords("Students"); ?></label>
                                <select id="student" name="student" class="form-control">
                                    <option value="">All</option>
                                    <?php foreach ($student_list as $exam_student) { ?>
                                        <option value="<?php echo $exam_student->std_id; ?>"
                                                <?php if ($student_id == $exam_student->std_id) echo 'selected'; ?>><?php echo $exam_student->std_first_name . ' ' . $exam_student->std_last_name; ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                <?php if ($create || $read || $update || $delete) { ?>
                    <?php
                    $show_exam_details = $this->db->select('exam_manager.*, exam_type.*, course.*, branch_location.*, admission_plan.* ')
                            ->from('exam_manager')
                            ->join('exam_type', 'exam_type.exam_type_id = exam_manager.em_type')
                            ->join('course', 'course.course_id = exam_manager.course_id')
                            ->join('admission_plan', 'admission_plan.admission_plan_id = exam_manager.admission_plan_id')
                            ->join('branch_location', 'branch_location.branch_id = exam_manager.branch_id')                            
                            ->where('exam_manager.em_id', $exam_id)
                            ->get()
                            ->row();
                    ?>

                    <?php if ($this->uri->total_segments() >= 6) { ?>
                        <?php if (count($show_exam_details)) {                             
                            ?>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">Exam Details</div>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th><?php echo ucwords("Exam Name"); ?></th>
                                                <th><?php echo ucwords("Branch"); ?></th>
                                                <th><?php echo ucwords("Course"); ?></th>
                                                <th><?php echo ucwords("Admission Plan"); ?></th>
                                                
                                            </tr>
                                            <tr>
                                                <td><?php echo $show_exam_details->em_name; ?></td>
                                                <td><?php echo $show_exam_details->branch_name.' - '.$show_exam_details->branch_location;; ?></td>
                                                <td><?php echo $show_exam_details->c_name; ?></td>
                                                <td><?php echo $show_exam_details->admission_duration; ?></td>
                                                
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div id="gridview" class="col-sm-12">
                                <div style="" id="entermarks" class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title" style="color:#000;"><?php echo ucwords("Enter Marks"); ?></h4>
                                    </div>
                                    <form class="form-horizontal" action="" method="post">
                                        <div class="table-responsive">                                    
                                            <table data-filter="#filter" id="marklist" class="table table-bordered table-striped table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" rowspan="2">#</th>
                                                        <th colspan="2" width="10%"><strong>Student Details</strong></th>                                                       
                                                        <th colspan="<?php echo count($subject_details); ?>" width="80%"><strong>Subjects</strong></th>
                                                        <th width="5%" rowspan="2"><?php echo ucwords("Remarks"); ?></th>
                                                    </tr>
                                                    <tr>                                                
                                                        <th>Roll No</th>
                                                        <th width="10%"><?php echo ucwords("Student Name"); ?></th>
                                                        <?php foreach ($subject_details as $subject) { ?>                                                    
                                                            <th><?php echo $subject->subject_name; ?></th>
                                                        <?php } ?>                                                
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <input type="hidden" name="total_student" value="<?php echo count($student_list); ?>"/>
                                                <?php
                                                if (count($subject_details)) {
                                                    $counter = 1;
                                                    ?>
                                                    <?php if (count($student_list)) { ?>
                                                        <?php
                                                        $student_count = 1;
                                                        foreach ($student_list as $student) {
                                                            if ($student_id != '') {
                                                                if ($student_id != $student->std_id) {
                                                                    continue;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $student_count++; ?></td>
                                                                <td><?php echo $student->std_roll; ?></td>
                                                                <td data-id="63"><?php echo $student->std_first_name . ' ' . $student->std_last_name; ?></td>

                                                                <?php foreach ($subject_details as $subject) { ?>
                                                                    <?php
                                                                    $where = array(
                                                                        'mm_std_id' => $student->std_id,
                                                                        'mm_subject_id' => $subject->sm_id,
                                                                        'mm_exam_id' => $exam_detail[0]->em_id,
                                                                    );
                                                                    $marks = $this->Crud_model->student_exam_mark($where);
                                                                    $this->db->select();
                                                                    $this->db->where("sm_id", $subject->sm_id);
                                                                    $this->db->where("course_id", $course_id);
                                                                    $this->db->where("sem_id", $semester_id);                                                                    
                                                                    $internal = $this->db->get("internal_exam")->result();
                                                                    
                                                                    //echo $this->db->last_query();
                                                                   
                                                                    ?>
                                                                    <?php //echo $total->total_marks; ?>
                                                                    <td><input type="number" class="form-control" placeholder="Obtained Marks / <?php echo $exam_detail[0]->total_marks; ?>"
                                                                               min="0" max="<?php echo $exam_detail[0]->total_marks; ?>"
                                                                               name="mark_<?php echo $counter; ?>_<?php echo $student->std_id; ?>_<?php echo $exam_detail[0]->em_id; ?>_<?php echo $subject->sm_id; ?>"
                                                                               value="<?php if (count($marks)) echo $marks->mark_obtained; ?>"/>
                                                                        <div class="">
                                                                       <?php foreach($internal as $intexam): ?>
                                                                            <?php 
                                                                       $int_where = array("sm_id"=>$subject->sm_id,
                                                                                        "course_id"=>$course_id,
                                                                                        "sem_id"=>$semester_id,
                                                                                        "internal_id"=>$intexam->internal_id,
                                                                                        "em_id"=>$exam_detail[0]->em_id,
                                                                                        "std_id"=>$student->std_id);
                                                                        $get_internal = $this->Internal_marks_model->get_student_internal_marks($int_where);?>
                                                                            <div> <span><?php echo $intexam->internal_title; ?> </span><input class="form-control" min="0" max="<?php echo $intexam->internal_marks; ?>" placeholder="Obtained Marks / <?php echo $intexam->internal_marks; ?>" type="number" name="internal_<?php echo $counter; ?>_<?php echo $student->std_id; ?>_<?php echo $exam_detail[0]->em_id; ?>_<?php echo $subject->sm_id; ?>_<?php echo $intexam->internal_id; ?>" value="<?php if(count($get_internal)){echo $get_internal->internal_obtained_marks; } ?>"></div><br>
                                                                        
                                                                        <?php endforeach; ?>
                                                                           </div>
                                                                    
                                                                    </td>
                                                                    <?php } ?>

                                                                <td><input type="text" class="form-control" 
                                                                           value="<?php if (count($marks)) echo $marks->mm_remarks; ?>"
                                                                           name="remark_<?php echo $counter; ?>_<?php echo $student->std_id; ?>_<?php echo $exam_detail[0]->em_id; ?>"/></td>
                                                            </tr>
                                                            <?php
                                                            $counter++;
                                                        }
                                                        ?>

                                                        <?php
                                                    } else {
                                                        ?>

                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td colspan="4" style="text-align: left">Exam schedule not found</td>
                                                    </tr>

                                                <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <br/>
                                        <?php if (count($student_list)) { ?>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form_sep">
                                                        &nbsp;<input type="submit" class="btn btn-primary" value="Submit"/> 
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </form>

                                    
                                </div>
                            </div>
                        </div>
                    <?php } ?>           
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
</div></di>
<!-- End #content -->

<script>
    function get_exam_list(branch_id, course_id, admission_plan_id,  exam_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>exam/get_exam_list/' + branch_id + '/' + course_id + '/' + admission_plan_id + '/' + exam_id,
            type: 'get',
            success: function (content) {
                $('#search-exam').html(content);
            }
        });
    }

    $(document).ready(function () {
        var branch_id = '<?php echo $branch_id; ?>';
        var course_id = '<?php echo $course_id; ?>';
        var admission_plan_id = '<?php echo $admission_plan_id; ?>';        
        var exam_id = '<?php echo $exam_id; ?>';
        get_exam_list(branch_id, course_id, admission_plan_id, exam_id);

//        $('#course').on('change', function () {
//            var degree_id = $('#degree').val();
//            var course_id = $(this).val();
//            var batch_id = $('#batch').val();
//            var semester_id = $('#semester').val();
//            var exam_id = $('#exam').val();
//            get_exam_list(degree_id, course_id, batch_id, semester_id, exam_id);
//            //subject_list(course_id, semester_id);
//        })

        

       
    })
</script>

<script>
    $(document).ready(function () {
        //course by degree
                
    $('#search-exam').on('change', function () {
            var branch_id = $('#search-branch').val();
            var course_id = $('#search-course').val();
            var admission_plan_id = $('#search-admission_plan').val();            
            var exam_id = $(this).val();
            if (branch_id && course_id && admission_plan_id && exam_id)
                location.href = '<?php echo base_url(); ?>marks/index/' + branch_id + '/' + course_id + '/' + admission_plan_id + '/' + exam_id
        })

        //batch from course and degree
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
        
       var branch_id = '<?php echo $branch_id; ?>';
        var course_id = '<?php echo $course_id; ?>';
        var admission_plan_id = '<?php echo $admission_plan_id; ?>';        
        var exam_id = '<?php echo $exam_id; ?>';

        if (branch_id && course_id && admission_plan_id && exam_id) {
            $('select#search-branch').val(branch_id);
            $('#search-course').find('option').remove().end();
            $('#search-course').append('<option value="">Select</option>');
            //brach from degree
            $.ajax({
                url: '<?php echo base_url(); ?>courses/get_all_courses/',
                type: 'get',
                success: function (content) {
               
                    var course = jQuery.parseJSON(content);
                    $.each(course, function (key, value) {
                        $('#search-course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                    $('select#search-course').val(course_id);
                }
            });

            //batch from degree and course
            $('#search-admission_plan').find('option').remove().end();
            $('select#search-admission_plan').append('<option value="">Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
                type: 'get',
                success: function (content) {                    
                    var admission_plan = jQuery.parseJSON(content);                    
                    $.each(admission_plan, function (key, value) {
                        $('#search-admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                    });
                    $('select#search-admission_plan').val(admission_plan_id);
                }
            })


            

            //get exam 
            var branch_id = '<?php echo $branch_id; ?>';
            var course_id = '<?php echo $course_id; ?>';
            var admission_plan_id = '<?php echo $admission_plan_id; ?>';            
            var exam_id = '<?php echo $exam_id; ?>';
            get_exam_list(branch_id, course_id, admission_plan_id, exam_id);
            $('select#search-exam').val(exam_id);

            //single student marks
            $('#student').on('change', function () {
                var student_id = $(this).val();
                var branch = '<?php echo $this->uri->segment(3); ?>';
                var course = '<?php echo $this->uri->segment(4); ?>';
                var admission_plan = '<?php echo $this->uri->segment(5); ?>';                
                var exam = '<?php echo $this->uri->segment(6); ?>';


                if (student_id != '') {
                    location.href = '<?php echo base_url(); ?>marks/index/' + branch + '/'
                            + course + '/' + admission_plan + '/'  + exam + '/' + student_id;
                } else {
                    //all students
                    location.href = '<?php echo base_url(); ?>marks/index/' + branch + '/'
                            + course + '/' + admission_plan + '/' + exam;
                }
            });
        }
       

       
       

    });
</script>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class=" panel-default">
            <div class=panel-body>
                <div class="tabs mb20">
                    <ul id="import-tab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#import-data" data-toggle="tab" aria-expanded="true">Import Data</a>
                        </li>
                        <li class="">
                            <a href="#download-sample-sheet" data-toggle="tab" aria-expanded="false">Download Sample Sheet</a>
                        </li>
                    </ul>
                    <div id="import-tab-content" class="tab-content">
                        <div class="tab-pane fade active in" id="import-data">
                            <div class="">
                                <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                            </div>
                            <form id="importform" class="myimportform form-horizontal form-groups-bordered validate" role="form" method="post" action="" 
                                  enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Module"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <select class="form-control" id="module" name="module">
                                            <option value="">Select</option>
                                            <option value="admission_type">Admission Type</option>
                                            <option value="batch">Batch</option>
                                            <option value="course">Branch</option>
                                            <option value="degree">Department</option>
                                            <option value="exam_manager">Exam Manager</option>
                                            <option value="exam_marks">Exam Marks</option>
                                            <option value="exam_time_table">Exam Time Table</option>
                                            <option value="event_manager">Event Manager</option>
                                            <option value="fees_structure">Fee Structure</option>
                                            <option value="student">Student</option>
                                            <option value="subject">Subject</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="degree_main" style="display: none;">
                                    <label class="col-sm-4 control-label">Department</label>                                            
                                    <div class="col-sm-5">
                                        <select id="degree" name="degree" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($degree as $row) { ?>
                                                <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group" id="course_main" style="display: none;">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?></label>

                                    <div class="col-sm-5">
                                        <select id="course" name="course" class="form-control">

                                        </select>
                                    </div>

                                </div>
                                <div class="form-group" id="batch_main" style="display: none;">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Batch"); ?></label>

                                    <div class="col-sm-5">
                                        <select id="batch" name="batch" class="form-control">

                                        </select>
                                    </div>

                                </div>
                                <div class="form-group" id="semester_main" style="display: none;">
                                    <label class="col-sm-4 control-label">Semester</label>
                                    <?php
                                    $semester = $this->db->get('semester')->result();
                                    ?>
                                    <div class="col-sm-5">
                                        <select id="semester" name="course" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($semester as $row) { ?>
                                                <option value="<?php echo $row->s_id; ?>"><?php echo $row->s_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group" id="exam_main" style="display: none;">
                                    <label class="col-sm-4 control-label">Exam</label>

                                    <div class="col-sm-5">
                                        <select id="exam" name="exam" class="form-control">

                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("File"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="file" class="form-control" name="userfile" id="userfile"/>
                                        <label id="userfile-error" class="error" for="userfile"></label>
                                    </div>
                                </div>
                                <input id="exam_post_details" type="hidden" name="exam_detail"/>
                                <input id="sem_post_details" type="hidden" name="sem_detail"/>
                                <input id="course_post_details" type="hidden" name="course_detail"/>

                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-5">
                                        <a style="display: none;" id="show_download" class="btn btn-warning">Download Sample File</a>
                                        <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("upload"); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- tab content -->
                        <div class="tab-pane fade" id="download-sample-sheet">
                            
                            <ul>
                                <li><a href="<?php echo base_url('import-export/download-import/admission_type'); ?>">Admission Type</a></li>
                                <li><a href="<?php echo base_url('import-export/download-import/batch'); ?>">Batch</a></li>
                                <li><a href="<?php echo base_url('import-export/download-import/course'); ?>">Branch</a></li>
                                <li><a href="<?php echo base_url('import-export/download-import/degree'); ?>">Department</a></li>
                                <li><a href="<?php echo base_url('import-export/download-import/exam_manager'); ?>">Exam Manager</a></li>
                                <li><a href="<?php echo base_url('import-export/download-import/exam_time_table'); ?>">Exam Time Table</a></li>
                                <li><a href="<?php echo base_url('import-export/download-import/event_manager'); ?>">Event Manager</a></li>
                                <li><a href="<?php echo base_url('import-export/download-import/fees_structure'); ?>">Fee Structure</a></li>
                                <li><a href="<?php echo base_url('import-export/download-import/student') ?>">Student</a></li>
                                <li><a href="<?php echo base_url('import-export/download-import/subject'); ?>">Subject</a></li>
                                
                            </ul>
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
 
    $().ready(function () {
        $("#importform").validate({
            rules: {
                userfile: "required",
                module: "required"
            },
            messages: {
                userfile: "Please select file",
                module: "Please select module"
            }
        });
    });
</script>
<script>
    function get_exam_list(course_id, semester_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>import-export/all_exam_list/' + course_id + '/' + semester_id,
            type: 'get',
            success: function (content) {
                console.log(content);
                $('#exam').html(content);
            }
        });
    }
    $(document).ready(function () {
        $('#module').on('change', function () {
            var import_type = $(this).val();
            if (import_type == 'exam_marks' || import_type == 'exam_time_table') {
                $('#degree_main').css('display', 'block');
                $('#course_main').css('display', 'block');
                $('#batch_main').css('display', 'block');
                $('#semester_main').css('display', 'block');
                $('#exam_main').css('display', 'block');

            } else {
                $('#degree_main').css('display', 'none');
                $('#course_main').css('display', 'none');
                $('#batch_main').css('display', 'none');
                $('#semester_main').css('display', 'none');
                $('#exam_main').css('display', 'none');
                //$('#show_download').css('display', 'none');
            }
        });

        $('#course').on('change', function () {
            var course_id = $(this).val();
            var semester_id = $('#semester').val();
            get_exam_list(course_id, semester_id);
            $('#course_post_details').val(course_id);
        })
        $('#semester').on('change', function () {
            var semester_id = $(this).val();
            var course_id = $('#course').val();
            get_exam_list(course_id, semester_id);
            $('#sem_post_details').val(semester_id);
        });

        $('#exam').on('change', function () {
            var exam_id = $(this).val();
            if (exam_id > 0)
                $('#show_download').css('display', 'inline');
            else
                $('#show_download').css('display', 'none');

            var module_name = $('#module').val();
            if (module_name == 'exam_time_table') {
                $('#show_download').css('display', 'none');
            }
            $('#exam_post_details').val(exam_id);
        });

        $('#show_download').on('click', function () {
            var exam_id = $('#exam').val();
            var exam_type = '';
            //exam details
            $.ajax({
                url: '<?php echo base_url(); ?>import-export/exam_details/' + exam_id,
                type: 'get',
                success: function (content) {
                    var exam_data = jQuery.parseJSON(content);
                    exam_type = exam_data[0].exam_ref_name;
                    if (exam_type == 'remedial') {
                        location.href = '<?php echo base_url(); ?>import-export/remedial_exam_csv_sample/' + exam_id;
                    } else {
                        location.href = '<?php echo base_url(); ?>import-export/download_marks_csv_sample/' + exam_id;
                    }
                }
            });

        })
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
                url: '<?php echo base_url(); ?>import-export/course_list_from_degree/' + degree_id,
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
            var degree_id = $('#degree').val();
            var course_id = $(this).val();
            batch_from_degree_and_course(degree_id, course_id);
        })

        //find batch from degree and course
        function batch_from_degree_and_course(degree_id, course_id) {
            //remove all element from batch
            $('#batch').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>import-export/batch_list_from_degree_and_course/' + degree_id + '/' + course_id,
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

    })
</script>
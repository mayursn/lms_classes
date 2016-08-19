
<script language="javascript" type="text/javascript">

    $(document).ready(function ($) {
        images = new Array();
        $(document).on('change', '.coverimage2', function () {
            files = this.files;

            $.each(files, function () {
                file = $(this)[0];
                if (!!file.type.match(/image.*/)) {
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onloadend = function (e) {
                        img_src = e.target.result;
                        html = "<img class='img-thumbnail' style='width:300px;margin:20px;' src='" + img_src + "'>";
                        $('#image_container1').html(html);
                    };
                }
            });
        });
    });
</script>
<?php
$edit_data = $this->db->select()
        ->from('graduates')
        ->join('student', 'student.std_id = graduates.student_id')
        ->join('degree', 'degree.d_id = graduates.degree_id')
        ->join('course', 'course.course_id = graduates.course_id')
        ->join('semester', 'semester.s_id = graduates.semester_id')
        ->where('graduates_id', $param2)
        ->get()
        ->row();
$degree = $this->db->get('degree')->result();
$query = "SELECT * FROM batch ";
$query .= "WHERE FIND_IN_SET($edit_data->degree_id, degree_id) ";
$query .= "AND FIND_IN_SET($edit_data->course_id, course_id)";
$batch = $this->db->query($query)->result();
$course = $this->db->get_where('course', array(
            'degree_id' => $edit_data->degree_id
        ))->result();
$semester = explode(',', $edit_data->semester_id);
$this->db->where_in('s_id', $semester);
$semester = $this->db->get('semester')->result();

$students = $this->db->get_where('student', array(
            'std_batch' => $edit_data->batch_id,
            'semester_id' => $edit_data->s_id,
            'std_degree' => $edit_data->degree_id,
            'course_id' => $edit_data->course_id
        ))->result();
?>

<div class="row">

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>Update Graduate</h4>
                        </div>-->
            <div class=panel-body>
                <?php echo form_open(base_url() . 'graduate/update/' . $edit_data->graduates_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'editgraduatesform', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>

                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("course"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="edit_degree" name="degree">
                            <option value="">Select</option>
                            <?php foreach ($degree as $row) { ?>
                                <option value="<?php echo $row->d_id; ?>"
                                        <?php if ($row->d_id == $edit_data->degree_id) echo 'selected'; ?>><?php echo $row->d_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>	
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="course" id="edit_course">
                            <option value="">Select</option>
                            <?php foreach ($course as $c) { ?>
                                <option value="<?php echo $c->course_id; ?>"
                                        <?php if ($c->course_id == $edit_data->course_id) echo 'selected'; ?>><?php echo $c->c_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Batch"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="batch" id="edit_batch">
                            <option value="">Select</option>
                            <?php foreach ($batch as $b) { ?>
                                <option value="<?php echo $b->b_id; ?>"
                                        <?php if ($b->b_id == $edit_data->batch_id) echo 'selected'; ?>><?php echo $b->b_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="semester" id="edit_semester">
                            <option value="">Select</option>
                            <?php foreach ($semester as $s) { ?>
                                <option value="<?php echo $s->s_id; ?>"
                                        <?php if ($s->s_id == $edit_data->s_id) echo 'selected'; ?>><?php echo $s->s_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Student"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="student" id="edit_student">
                            <option value="">Select</option>
                            <?php foreach ($students as $student) { ?>
                                <option value="<?php echo $student->std_id; ?>" 
                                        <?php if ($student->std_id == $edit_data->student_id) echo 'selected'; ?>><?php echo $student->std_first_name . ' ' . $student->std_last_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Student Image <span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="main_img" class="coverimage2" type="file" name="main_img" />
                    </div>
                    <div id="image_container1" class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><img class='img-thumbnail' src='<?php echo base_url() . "uploads/student_image/" . $edit_data->student_img; ?>' ></div>
                </div>   

                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("graduation year"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="year" id="year" class="form-control" value="<?php echo $edit_data->graduate_year; ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("description"); ?></label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="description" id="description"><?php echo $edit_data->description; ?></textarea>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="submit btn btn-info vd_bg-green"><?php echo ucwords("Update"); ?></button>
                    </div>
                </div>
                </form>
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

        $("#editgraduatesform").validate({
            rules: {
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                student: "required",
                main_img: {
                    extension: 'gif|jpg|png|jpeg',
                },
                year: "required"

            },
            messages: {
                degree: "Select course",
                course: "Select branch",
                batch: "Select batch",
                semester: "Select semester",
                student: "Select student",
                main_img: {
                    extension: "Only gif,jpg,png file is allowed!"
                },
                year: "Enter graduation year"

            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        //course by degree
        $('#edit_degree').on('change', function () {
            var course_id = $('#edit_course').val();
            var degree_id = $(this).val();

            //remove all present element
            $('#edit_course').find('option').remove().end();
            $('#edit_course').append('<option value="">Select</option>');
            var degree_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + degree_id,
                type: 'get',
                success: function (content) {
                    var course = jQuery.parseJSON(content);
                    $.each(course, function (key, value) {
                        $('#edit_course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    })
                }
            })
            batch_from_degree_and_course(degree_id, course_id);
        });

        //batch from course and degree
        $('#edit_course').on('change', function () {
            var degree_id = $('#edit_degree').val();
            var course_id = $(this).val();
            batch_from_degree_and_course(degree_id, course_id);
            get_semester_from_branch(course_id);
        });

        $('#edit_semester').on('change', function () {
            var degree = $('#edit_degree').val();
            var course = $('#edit_course').val();
            var batch = $('#edit_batch').val();
            var semester = $('#edit_semester').val();
            student_list_from_degree_course_batch_semester(degree, course, batch, semester);
        });

        //find batch from degree and course
        function batch_from_degree_and_course(degree_id, course_id) {
            //remove all element from batch
            $('#edit_batch').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>batch/department_branch_batch/' + degree_id + '/' + course_id,
                type: 'get',
                success: function (content) {
                    $('#edit_batch').append('<option value="">Select</option>');
                    var batch = jQuery.parseJSON(content);
                    console.log(batch);
                    $.each(batch, function (key, value) {
                        $('#edit_batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    })
                }
            })
        }

        //get semester from brach
        function get_semester_from_branch(branch_id) {
            $('#edit_semester').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch_id,
                type: 'get',
                success: function (content) {
                    $('#edit_semester').append('<option value="">Select</option>');
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#edit_semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    })
                }
            })
        }

        //student list from degree, course, batch and semester
        function student_list_from_degree_course_batch_semester(degree, courese, batch, semester) {
            $('#edit_student').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>student/student_list_from_degree_course_batch_semester/' + degree + '/'
                        + courese + '/' + batch + '/' + semester,
                type: 'get',
                success: function (content) {
                    $('#edit_student').append('<option value="">Select</option>');
                    var student = jQuery.parseJSON(content);
                    $.each(student, function (key, value) {
                        $('#edit_student').append('<option value=' + value.std_id + '>' + value.std_first_name + ' ' + value.std_last_name + '</option>');
                    });
                }
            });
        }

    })
</script>
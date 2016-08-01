<?php
$degree = $this->db->order_by('d_name', 'ASC')->get('degree')->result_array();
$courses = $this->db->get('course')->result_array();
$semesters = $this->db->get('semester')->result_array();
$professor = $this->db->get('professor')->result_array();
?>

<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
          <div class="panel-body"> 

                <div class="box-content"> 
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                    
                    <?php echo form_open(base_url() . 'subject/subject_detail_create/'.$this->uri->segment(4), array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmsubjectdetail', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select id="degree" class="form-control" name="degree">
                                    <option value="">Select</option>
                                    <?php foreach ($degree as $row) { ?>
                                        <option value="<?php echo $row['d_id']; ?>"><?php echo $row['d_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="course" class="form-control"  id="course">
                                    <option value="">Select</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="semester" class="form-control" id="semester">
                                    <option value="">Select</option>

                                </select>
                                <lable class="error" id="error_lable_exist" style="color:red"></lable>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("professor"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="professor[]" class="form-control" id="professor" multiple=""> 
                                    <option value="">Select Professor</option>
                                    <?php foreach ($professor as $prof) : ?>
                                        <option value="<?php echo $prof['user_id']; ?>"><?php echo $prof['name']; ?></option>
                                    <?php endforeach; ?>

                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" id="addsubject" class="btn btn-info vd_bg-green"><?php echo ucwords("Add "); ?></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

        $('#degree').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });
        $('#course').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#degree').val();
            semester_from_branch(branch_id);
        });
        
         function semester_from_branch(branch) {
            $('#semester').find('option').remove().end();
            $('#semester').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
                type: 'GET',
                success: function (content) {
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    });
                }
            });
        } 
         function department_branch(department_id) {
            $('#course').find('option').remove().end();
            $('#course').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        }
        
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
          $("#subname").change(function () {
            $('#semester').val($("#semester option:eq(0)").val());
        });
        $("#course").change(function () {
            $('#semester').val($("#semester option:eq(0)").val());
        });
        $("#subcode").change(function () {
            $('#semester').val($("#semester option:eq(0)").val());
        });

        $("#frmsubjectdetail").validate({
            rules: {
                degree: "required",
                course: 
                        {
                            required:true,
                            remote: {
                                        url: "<?php echo base_url(); ?>subject/checksubjects",
                                        type: "post",
                                        data: {
                                            degree: function () {
                                                return $("#degree").val();
                                            },
                                            course: function () {
                                                return $("#course").val();
                                            },
                                            subjectid: function () {
                                                return <?php echo $this->uri->segment(4);?>
                                            }
                                        }
                                    }
                },
                semester: "required",
                'professor[]':
                        {
                            required: true,
                        },
            },
            messages: {
                degree: "Select department",
                course: 
                {
                    required:"Select branch",
                    remote:"Subject already exists for this branch",
                },
                semester: "Select semester",
                'professor[]':
                        {
                            required: "Select Professor",
                        },
            }
        });
    });
</script>
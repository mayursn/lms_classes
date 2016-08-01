<?php
$this->load->model('syllabus/Smart_syllabus_model');
$this->load->model('branch/Course_model');
$this->load->model('department/Degree_model');
$row = $this->Smart_syllabus_model->get($param2);

    ?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                                <h4 class=panel-title>  <?php echo ucwords("Update Syllabus"); ?></h4>                
                            </div>    -->
                <div class="panel-body">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content">  
                            <div class="">
                                    <span style="color:red">* <?php echo "is ".ucwords("mandatory field");?></span> 
                                </div>   
                            <?php echo form_open(base_url() . 'syllabus/update/' . $row->syllabus_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmeditsyllabus', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Syllabus title");?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" id="title" value="<?php echo $row->syllabus_title; ?>" />
                                </div>
                            </div>
                             <div class="form-group">
                                            <label class="col-sm-4 control-label"><?php echo ucwords("department");?><span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <select name="degree" class="form-control"  id="degree2">
                                                    <option value="">Select department</option>
                                                    <?php
                                                  $degree =  $this->Degree_model->get_all();
                                                    foreach ($degree as $dgr) {
                                                        ?>
                                                    <option value="<?= $dgr->d_id ?>" <?php if($row->syllabus_degree==$dgr->d_id){  echo "selected=selected"; } ?>><?= $dgr->d_name ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Branch");?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="course" class="form-control"  id="course2">
                                        <option value="">Select Branch</option>
                                        <?php
                                        $course = $this->Course_model->get_all();
                                        foreach ($course as $crs) {
                                            if ($crs->course_id == $row->syllabus_course) {
                                                ?>
                                                <option value="<?= $crs->course_id ?>" selected><?= $crs->c_name ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $crs->course_id ?>" ><?= $crs->c_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Semester");?><span style="color:red">*</span></label>
                                <div class="col-sm-8"> 
                                    <select name="semester" class="form-control"  id="semester1">
                                        <option value="">Select semester</option>
                                        <?php
                                        $this->load->model('semester/Semester_model');
                                        $datasem = $this->Semester_model->get_all();
                                        foreach ($datasem as $rowsem) {
                                            if ($rowsem->s_id == $row->syllabus_sem) {
                                                ?>
                                                <option value="<?= $rowsem->s_id ?>" selected><?= $rowsem->s_name ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                <option value="<?= $rowsem->s_id ?>" ><?= $rowsem->s_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
           
                           
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Description");?></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="description" id="description"><?php echo $row->syllabus_desc; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("File Upload");?></label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="txtoldfile" id="txtoldfile" value="<?php echo $row->syllabus_filename; ?>" />
                                    <input type="file" class="form-control" name="syllabusfile" id="syllabusfile" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="submit btn btn-info vd_bg-green"><?php echo ucwords("Update");?></button>
                                </div>
                            </div>
                            </form>
                        </div> </div> </div>
            </div>
        </div>
    </div>


<script type="text/javascript">  
    $(document).ready(function(){
       
        $('#degree2').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });
        $('#course2').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#degree2').val();
            batch_form_department_branch(department, branch_id);
            semester_from_branch(branch_id);
        });
        
        function department_branch(department_id) {
            $('#course2').find('option').remove().end();
            $('#course2').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#course2').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        }

        function batch_form_department_branch(department, branch) {
            $('#batch2').find('option').remove().end();
            $('#batch2').append('<option value>Select</option>');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>batch/department_branch_batch/" + department + '/' + branch,
                success: function (response) {
                    var branch = jQuery.parseJSON(response);
                    $.each(branch, function (key, value) {
                        $('#batch2').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            });
        }

        function semester_from_branch(branch) {
            $('#semester2').find('option').remove().end();
            $('#semester2').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
                type: 'GET',
                success: function (content) {
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#semester2').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    });
                }
            });
        } 
    });
   



</script>
<script type="text/javascript">
    
    
    
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
        $("#submissiondate1").datepicker({
            dateFormat: ' MM dd, yy',
            minDate: 0
        });

        $("#frmeditsyllabus").validate({
            rules: {
                degree:"required",
                course: "required",               
                semester: "required",                
                title:
                        {
                            required: true,
                           
                        },
                syllabusfile: {
                    
                    extension:'pdf|doc|docx|ppt|pptx',                                                                              
                },
            },
            messages: {
                degree:"Select department",
                course: "Select Branch",               
                semester: "Select Semester",
                submissiondate: "Select date of submission",
                title:
                        {
                            required: "Enter title",                            
                        },
                syllabusfile: 
                        {
                            extension:'Upload valid file',  
                        },
            }
        });
    });
</script>

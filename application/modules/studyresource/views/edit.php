<?php
$this->load->model("studyresource/Study_resources_model");
$row = $this->Study_resources_model->get($param2);
?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                                <h4 class=panel-title>  <?php echo ucwords("Update Study Resources"); ?></h4>                
                            </div>       -->
            <div class="panel-body">
                <div class="tab-pane box" id="add" style="padding: 5px">
                    <div class="box-content">  
                        <div class="">
                            <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                        </div>   
                        <?php echo form_open(base_url() . 'studyresource/update/' . $row->study_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmeditstudyresource', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"> <?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="degree" id="degree2" class="form-control">
                                    <option value="">Select department</option>

                                    <option value="All" <?php
                                    if ($row->study_degree == "All") {
                                        echo "selected=selected";
                                    }
                                    ?> >All</option>
                                            <?php
                                            $this->load->model('department/Degree_model');
                                            $datadegree = $this->Degree_model->get_many_by(array('d_status' => 1));
                                            foreach ($datadegree as $rowdegree) {
                                                if ($rowdegree->d_id == $row->study_degree) {
                                                    ?>
                                            <option value="<?= $rowdegree->d_id ?>" selected><?= $rowdegree->d_name ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?= $rowdegree->d_id ?>"><?= $rowdegree->d_name ?></option>							
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"> <?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">

                                <select name="course" id="course2" class="form-control">
                                    <option value="">Select Branch</option>
                                    <option value="All" <?php
                                    if ($row->study_course == "All") {
                                        echo "selected=selected";
                                    }
                                    ?> >All</option>
                                            <?php
                                            $this->load->model('branch/Course_model');
                                            $course = $this->Course_model->get_many_by(array('course_status' => 1));
                                            foreach ($course as $crs) {
                                                ?>
                                        <option value="<?php echo $crs->course_id; ?>" <?php
                                        if ($crs->course_id == $row->study_course) {
                                            echo "selected='selected'";
                                        }
                                        ?> ><?= $crs->c_name ?></option>
                                                <?php
                                            }
                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Batch "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="batch" id="batch2" class="form-control">
                                    <option value="">Select batch</option>
                                    <option value="All" <?php
                                    if ($row->study_batch == "All") {
                                        echo "selected=selected";
                                    }
                                    ?> >All</option>
                                            <?php
                                            $this->load->model('batch/Batch_model');
                                            $databatch = $this->Batch_model->get_many_by(array('b_status' => 1));
                                            foreach ($databatch as $row1) {
                                                if ($row1->b_id == $row->study_batch) {
                                                    ?>
                                            <option value="<?= $row1->b_id ?>" selected><?= $row1->b_name ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?= $row1->b_id ?>" ><?= $row1->b_name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>	
                        <div class="form-group"> 
                            <label class="col-sm-4 control-label"><?php echo ucwords("Semester "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="semester" id="semester2" class="form-control">
                                    <option value="">Select semester</option>
                                    <option value="All" <?php
                                    if ($row->study_sem == "All") {
                                        echo "selected=selected";
                                    }
                                    ?> >All</option>
                                            <?php
                                            $this->load->model('semester/Semester_model');
                                            $datasem = $this->Semester_model->get_many_by(array('s_status' => 1));
                                            foreach ($datasem as $rowsem) {
                                                if ($rowsem->s_id == $row->study_sem) {
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
                        <div class="form-group" >
                            <label class="col-sm-4 control-label"><?php echo ucwords("Title "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title"  value="<?php echo $row->study_title; ?>"/>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" name="pageurl" id="pageurl" value="<?php echo $row->study_url; ?>" />
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("File Upload "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="hidden" name="txtoldfile" id="txtoldfile" value="<?php echo $row->study_filename; ?>" />
                                <input type="file" class="form-control" name="resourcefile" id="resourcefile" />
                            </div>
                        </div>   
			<div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status");?></label>
                            <div class="col-sm-8">
                                <select name="status"  class="form-control">
                                  <option value="1" <?php if($row->study_status == '1'){ echo "selected"; } ?>>Active</option>
                                    <option value="0" <?php if($row->study_status == '0'){ echo "selected"; } ?>>Inactive</option>	
                                </select>
                                <lable class="error" id="error_lable_exist" style="color:red"></lable>

                            </div>

                        </div>                     

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="submit btn btn-info vd_bg-green"><?php echo ucwords("Update"); ?></button>
                            </div>
                        </div>
                        </form>
                    </div> </div> </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $("#degree2").change(function () {
        var degree = $(this).val();
        var dataString = "degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'studyresource/get_courcestudy/'; ?>",
            data: dataString,
            success: function (response) {
                $('#course2').find('option').remove().end();
                $('#course2').append('<option value>Select</option>');
                $('#course2').append('<option value="All">All</option>');
                //  $("#course2").html(response);
                if (degree == 'All')
                {
                    $("#batch2").val($("#batch2 option:eq(1)").val());
                    $("#course2").val($("#course2 option:eq(1)").val());
                    $("#semester2").val($("#semester2 option:eq(1)").val());
                } else {
                    var branch = jQuery.parseJSON(response);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#course2').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });

                }
            }
        });
    });

    $("#batch2").change(function () {
        var batch = $(this).val();
        if (batch == "All")
        {
            $("#semester2").val($("#semester2 option:eq(1)").val());
        }

    });
    $("#course2").change(function () {
        var course = $(this).val();
        var degree = $("#degree2").val();
        var dataString = "course=" + course + "&degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'studyresource/get_batchs/'; ?>",
            data: dataString,
            success: function (response) {
                //  $("#batch2").html(response);
                $('#batch2').find('option').remove().end();
                $('#batch2').append('<option value>Select</option>');
                $('#batch2').append('<option value="All">All</option>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'studyresource/get_semesterall/all'; ?>",
                    data: {'course': course},
                    success: function (response) {

                        $("#semester2").html(response);
                        $("#semester2").val($("#semester2 option:eq(1)").val());
                    }
                });
                if (course == 'All')
                {
                    $("#batch2").val($("#batch2 option:eq(1)").val());

                } else {
                    var batch = jQuery.parseJSON(response);
                    console.log(batch);
                    $.each(batch, function (key, value) {
                        $('#batch2').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            }
        });
    });


    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';

        $("#dateofsubmission1").datepicker({
            dateFormat: js_date_format,
            startDate: new Date()
        });
        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("url", function (value, element) {
            return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
        }, 'Please enter a valid URL.');

        $("#frmeditstudyresource").validate({
            rules: {
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                dateofsubmission1: "required",
                title:
                        {
                            required: true,
                        },
                resourcefile: {
                    extension: 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|ppt|pptx|pdf|txt',
                },
            },
            messages: {
                degree: "Select department",
                course: "Select branch",
                batch: "Select batch",
                semester: "Select semester",
                dateofsubmission1: "Select date",
                title:
                        {
                            required: "Enter title",
                        },
                resourcefile: {
                    extension: 'Upload valid file',
                },
            }
        });
    });
</script>

<?php
$edit_data = $this->db->get_where('fees_structure', array('fees_structure_id' => $param2))->row();

?>
<div class="row">
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>Update Fee Structure</h4>
                        </div>-->
            <div class=panel-body>
                <?php echo form_open(base_url() . 'fees/update/' . $edit_data->fees_structure_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'editfeesstructure', 'target' => '_top')); ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Title"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" id="edit_title" name="title" class="form-control"
                               value="<?php echo $edit_data->title; ?>" required=""/>
                    </div>
                </div>                  
                  <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="degree" id="degree2" class="form-control">
                                        <option value="">Select department</option>
                                        <option value="All" <?php
                                        if ($edit_data->degree_id == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>
                                                <?php
                                                $this->load->model('department/Degree_model');
                                                $datadegree = $this->Degree_model->get_many_by( array('d_status' => 1));                                                 
                                                foreach ($datadegree as $rowdegree) {
                                                    if ($rowdegree->d_id == $edit_data->degree_id) {
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
                                <label class="col-sm-4 control-label"><?php echo ucwords("Branch "); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="course" id="course2" class="form-control">
                                        <option value="">Select Branch</option>
                                        <option value="All" <?php
                                        if ($edit_data->course_id == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>
                                                <?php
                                                $this->load->model('branch/Course_model');
                                                $course = $this->Course_model->get_many_by(array('course_status' => 1));                                                
                                                foreach ($course as $crs) {
                                                    ?>
                                            <option value="<?php echo $crs->course_id ?>" <?php
                                            if ($crs->course_id == $edit_data->course_id) {
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
                                    <select name="edit_batch" id="batch2" onchange="get_student(this.value);" class="form-control"  >
                                        <option value="">Select batch</option>
                                        <option value="All" <?php
                                        if ($edit_data->batch_id == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>
                                                <?php
                                                $this->load->model('batch/Batch_model');
                                                $databatch = $this->Batch_model->get_many_by(array('b_status' => 1));
                                                foreach ($databatch as $row1) {
                                                    if ($row1->b_id == $edit_data->batch_id) {
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
                                    <select name="semester" id="semester2" onchange="get_students(this.value);" class="form-control">
                                        <option value="">Select semester</option>
                                        <option value="All" <?php
                                        if ($edit_data->sem_id == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>   
                                                <?php
                                                $this->load->model('semester/Semester_model');
                                                $datasem = $this->Semester_model->get_many_by(array('s_status' => 1));
                                                
                                                foreach ($datasem as $rowsem) {
                                                    if ($rowsem->s_id == $edit_data->sem_id) {
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
                    <label class="col-sm-4 control-label"><?php echo ucwords("Fee"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">                                        
                        <input type="text" id="edit_fees" class="form-control" name="fees" required=""
                               value="<?php echo $edit_data->total_fee; ?>"/>                                               
                    </div>
                </div>	
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Start Date"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" id="edit_start_date" class="form-control datepicker" name="start_date"
                               value="<?php echo date_formats($edit_data->fee_start_date); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("End Date"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" id="edit_end_date" class="form-control datepicker" name="end_date"
                               value="<?php echo date_formats($edit_data->fee_end_date); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Expiry Date"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" id="edit_expiry_date" class="form-control datepicker" name="expiry_date"
                               value="<?php echo date_formats($edit_data->fee_expiry_date); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Penalty"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" id="edit_penalty" class="form-control" name="penalty"
                               value="<?php echo $edit_data->penalty; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                    <div class="col-sm-8">
                        <textarea id="description" name="description" class="form-control"><?php echo $edit_data->description; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="submit btn btn-info vd_bg-green"><?php echo ucwords("update"); ?></button>
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
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {
        $("#editfeesstructure").validate({
            rules: {
                edit_title: "required",
                degree: "required",
                course: "required",
                edit_batch: "required",
                semester: "required",
                edit_fees: "required",
                start_date: "required",
                end_date: "required",
                expiry_date: "required",
                penalty: "required"
            },
            messages: {
                edit_title: "Please enter title",
                degree: "Please select department",
                course: "Please select branch",
                edit_batch: "Please select batch",
                semester: "Please select semester",
                edit_fees: "Please enter fee",
                start_date: "Please enter start date",
                end_date: "Please enter end date",
                expiry_date: "Please enter expiry date",
                penalty: "Please enter penalty"
            }
        });
    });
</script>

<script>
   
    $("#degree2").change(function () {
        var degree = $(this).val();
        var dataString = "degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'fees/get_cource/'; ?>",
            data: dataString,
            success: function (response) {
                $('#course2').find('option').remove().end();
                $('#course2').append('<option value>Select</option>');
                $('#course2').append('<option value="All">All</option>');
                if (degree == "All")
                {
                    $("#course2").val($("#course2 option:eq(1)").val());
                    $("#batch2").val($("#batch2 option:eq(1)").val());
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
        var batches = $("#batch2").val();
        if (batches == 'All')
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
            url: "<?php echo base_url() . 'fees/get_batchs/'; ?>",
            data: dataString,
            success: function (response) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'fees/get_semesterall/'; ?>",
                    data: {'course': course},
                    success: function (response1) {
                        $('#semester2').find('option').remove().end();
                        $('#semester2').append('<option value>Select</option>');
                        $('#semester2').append('<option value="All">All</option>');
                        if (course == "All")
                        {
                            $("#semester2").val($("#semester2 option:eq(1)").val());
                        } else {
                            var sem_value = jQuery.parseJSON(response1);
                            console.log(sem_value);
                            $.each(sem_value, function (key, value) {
                                $('#semester2').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                            });
                        }



                    }
                });
                $('#batch2').find('option').remove().end();
                $('#batch2').append('<option value>Select</option>');
                $('#batch2').append('<option value="All">All</option>');
                //$("#semester").val($("#semester option:eq(1)").val());
                if (course == "All")
                {
                    $("#batch2").val($("#batch2 option:eq(1)").val());
                    $("#semester2").val($("#semester2 option:eq(1)").val());
                } else {

                    var batch_value = jQuery.parseJSON(response);
                    console.log(batch_value);
                    $.each(batch_value, function (key, value) {
                        $('#batch2').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            }
        });
    });


</script>

<script>
    $(document).ready(function () {  
         var js_date_format = '<?php echo js_dateformat(); ?>';
         $("#edit_start_date").datepicker({
            format: js_date_format,
            todayHighlight: true,
            autoclose: true,
            startDate: new Date()
        });
        $('#edit_start_date').on('change', function () {
            
            date = new Date($(this).val());
            start_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
            console.log(start_date);
            
            setTimeout(function () {
                $("#edit_end_date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    todayHighlight: true,
                    startDate: start_date
                }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#edit_expiry_date').datepicker('setStartDate', minDate);
        });
            }, 200);
        });
          
           $("#edit_expiry_date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    todayHighlight: true
                });

    })
    //minDate: new Date(),

</script>
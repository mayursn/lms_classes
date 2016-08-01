
<div class=row>
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>  <?php echo ucwords("Add Library"); ?></h4>                
                        </div>      -->
            <div class="panel-body"> 

                <div class="box-content">  

                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                  
                    <?php echo form_open(base_url() . 'digital/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmlibrary', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">											
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?> <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="degree" id="degree" class="form-control">
                                    <option value="">Select department</option>
                                    <option value="All">All</option>
                                    <?php
                                    $datadegree = $this->db->get_where('degree', array('d_status' => 1))->result();
                                    foreach ($datadegree as $rowdegree) {
                                        ?>
                                        <option value="<?= $rowdegree->d_id ?>"><?= $rowdegree->d_name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="course" id="course" class="form-control">
                                    <option value="">Select Branch</option>
                                    <option value="All">All</option>
                                    <?php
                                    /*
                                     * $course = $this->db->get_where('course', array('course_status' => 1))->result();
                                      foreach ($course as $crs) {
                                      ?>
                                      <!--  <option value="<?= $crs->course_id ?>"><?= $crs->c_name ?></option>-->
                                      <?php
                                      } */
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Batch "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="batch" id="batch" onchange="get_student2(this.value);" class="form-control" >
                                    <option value="">Select batch</option>
                                    <option value="All">All</option>
                                    <?php
                                    /* $databatch = $this->db->get_where('batch', array('b_status' => 1))->result();
                                      foreach ($databatch as $row) {
                                      ?>
                                      <option value="<?= $row->b_id ?>"><?= $row->b_name ?></option>
                                      <?php
                                      } */
                                    ?>
                                </select>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Semester "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="semester" id="semester" onchange="get_students2(this.value);" class="form-control">
                                    <option value="">Select Semester</option>
                                    <option value="All">All</option>
                                    <?php
                                    $datasem = $this->db->get_where('semester', array('s_status' => 1))->result();
                                    foreach ($datasem as $rowsem) {
                                        ?>
                                        <option value="<?= $rowsem->s_id ?>"><?= $rowsem->s_name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Library Name "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" />
                            </div>
                        </div>                                        

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("File Upload "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="libraryfile" id="libraryfile" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                            <div class="col-sm-8">
                                <select name="status"  class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>	
                                </select>
                                <lable class="error" id="error_lable_exist" style="color:red"></lable>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
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


    $("#degree").change(function () {
        var degree = $(this).val();

        var dataString = "degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'digital/get_cource/'; ?>",
            data: dataString,
            success: function (response) {                
                $('#course').find('option').remove().end();
                $('#course').append('<option value>Select</option>');
                $('#course').append('<option value="All">All</option>');
                if (degree == "All")
                {
                    $("#batch").val($("#batch option:eq(1)").val());
                    $("#course").val($("#course option:eq(1)").val());
                    $("#semester").val($("#semester option:eq(1)").val());
                } else {
                    var branch = jQuery.parseJSON(response);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            }
        });
    });


$("#batch").change(function () {
        var batches = $("#batch").val();
        if (batches == 'All')
        {
            $("#semester").val($("#semester option:eq(1)").val());
        }
    });



    $("#course").change(function () {
        var course = $(this).val();
        var degree = $("#degree").val();
        var dataString = "course=" + course + "&degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'digital/get_batchs/'; ?>",
            data: dataString,
            success: function (response) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'digital/get_semesterall/'; ?>",
                    data: {'course': course},
                    success: function (response1) {
                        $('#semester').find('option').remove().end();
                        $('#semester').append('<option value>Select</option>');
                        $('#semester').append('<option value="All">All</option>');
                        if(course=="All")
                        {
                            $("#semester").val($("#semester option:eq(1)").val());
                        }
                        else{
                            var sem_value = jQuery.parseJSON(response1);
                            console.log(sem_value);
                            $.each(sem_value, function (key, value) {
                                $('#semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                            });
                        }
                         
                        
                        
                    }
                });
                $('#batch').find('option').remove().end();
                $('#batch').append('<option value>Select</option>');
                $('#batch').append('<option value="All">All</option>');
                //$("#semester").val($("#semester option:eq(1)").val());
               if (course == "All")
                {
                    $("#batch").val($("#batch option:eq(1)").val());
                    $("#semester").val($("#semester option:eq(1)").val());
                } else {

                    var batch_value = jQuery.parseJSON(response);
                    console.log(batch_value);
                    $.each(batch_value, function (key, value) {
                        $('#batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            }
        });
    });


    function get_student2(batch, semester = '') {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/batchwisestudent/',
            type: 'POST',
            data: {'batch': batch},
            success: function (content) {
                $("#student").html(content);
            }
        });
    }

    function get_students2(sem)
    {
        var batch = $("#batch").val();
        var course = $("#course").val();
        var degree = $("#degree").val();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/semwisestudent/',
            type: 'POST',
            data: {'batch': batch, 'sem': sem, 'course': course, 'degree': degree},
            success: function (content) {
                //alert(content);
                $("#student").html(content);
            }
        });


    }



    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
    var js_date_format = '<?php echo js_dateformat(); ?>';
        $("#dateofsubmission").datepicker({
            dateFormat: js_date_format,
            maxDate: 0,
            autoclose: true,
        });
        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("url", function (value, element) {
            return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
        }, 'Please enter a valid URL.');

        $("#frmlibrary").validate({
            rules: {
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                student: "required",
                dateofsubmission: "required",
                title:
                        {
                            required: true,
                        },
                libraryfile: {
                    required: true,
                    extension: 'gif|jpg|png|pdf|xlsx|xls|doc|docx|ppt|pptx|pdf|txt|jpeg|mkv|webm|flv|mp4|avi',
                }
            },
            messages: {
                degree: "Select department",
                course: "Select Branch",
                batch: "Select Batch",
                semester: "Select Semester",
                student: "Select Student",
                dateofsubmission: "Select date",
                libraryfile: {
                    required: "Upload file",
                    extension: 'Upload valid file',
                },
                title:
                        {
                            required: "Enter title",
                        },
            }
        });
    });

</script>

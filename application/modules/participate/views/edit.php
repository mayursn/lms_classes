<?php
$this->load->Model('participate/participate_manager_model');
$row = $this->participate_manager_model->get($param2);



    ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle panelMove panelClose panelRefresh">
                <!-- Start .panel -->
                <!--                <div class=panel-heading>
                                        <h4 class=panel-title>                         
                    <?php echo ucwords("Update Participate"); ?>
                                        </h4>                
                                    </div>                -->
                <div class="panel-body">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content">  
                            <div class="">
                                <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                            </div>  
                            <?php echo form_open(base_url() . 'participate/update/' . $row->pp_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmeditparticipate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("department "); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="degree" id="degree2" class="form-control" >
                                        <option value="">Select department</option>
                                        <option value="All" <?php
                                        if ($row->pp_degree == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>
                                                <?php
                                                $this->load->model('department/Degree_model');
                                                $datadegree =$this->Degree_model->get_many_by(array('d_status' => 1));                                                
                                                foreach ($datadegree as $rowdegree) {
                                                    if ($rowdegree->d_id == $row->pp_degree) {
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
                                    <select name="course" id="course2" class="form-control" >
                                        <option value="">Select Branch</option>
                                        <option value="All" <?php
                                        if ($row->pp_course == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>
                                                <?php
                                                $this->load->model("branch/Course_model");
                                                $course = $this->Course_model->get_many_by(array('course_status' => 1));                                                
                                                foreach ($course as $crs) {
                                                    if ($crs->course_id == $row->pp_course) {
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
                                <label class="col-sm-4 control-label"><?php echo ucwords("Batch "); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="batch" id="batch2" onchange="get_sem(this.value);" class="form-control" >
                                        <option value="">Select batch</option>
                                        <option value="All" <?php
                                        if ($row->pp_batch == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>
                                                <?php
                                                $this->load->model('batch/Batch_model');
                                                $databatch =$this->Batch_model->get_many_by(array('b_status' => 1));
                                                // $this->db->get_where('batch', )->result();
                                                foreach ($databatch as $row1) {
                                                    if ($row1->b_id == $row->pp_batch) {
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
                                    <select name="semester" id="semester2"  onchange="get_students(this.value);" class="form-control" >   
                                        <option value="" >Select Semester</option> 
                                        <option value="All" <?php
                                        if ($row->pp_semester == "All") {
                                            echo "selected=selected";
                                        }
                                        ?>>All</option>   
                                                <?php
                                                $this->load->model('semester/Semester_model');
                                                $datasem = $this->Semester_model->get_many_by(array('s_status' => 1));
                                                foreach ($datasem as $rowsem) {
                                                    if ($rowsem->s_id == $row->pp_semester) {
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
                                <label class="col-sm-4 control-label"><?php echo ucwords("Activity Title "); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" id="title"  value="<?php echo $row->pp_title; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Date  "); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" readonly="" class="form-control" name="dateofsubmission1" id="dateofsubmission1" value="<?php echo date_formats($row->pp_dos); ?>"/>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="description" id="description" ><?php echo $row->pp_desc; ?></textarea>
                                </div>
                            </div>
                             <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status");?></label>
                            <div class="col-sm-8">
                                <select name="status"  class="form-control">
                                  <option value="1" <?php if($row->pp_status == '1'){ echo "selected"; } ?>>Active</option>
                                    <option value="0" <?php if($row->pp_status == '0'){ echo "selected"; } ?>>Inactive</option>	
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
            url: "<?php echo base_url() . 'participate/get_cource/'; ?>",
            data: dataString,
            success: function (response) {
                  $('#course2').find('option').remove().end();
                $('#course2').append('<option value>Select</option>');
                $('#course2').append('<option value="All">All</option>');
                if (degree == "All")
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

    $("#course2").change(function () {
        var course = $(this).val();
        var degree = $("#degree2").val();
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
                        $('#semester2').find('option').remove().end();
                        $('#semester2').append('<option value>Select</option>');
                        $('#semester2').append('<option value="All">All</option>');
                        if(course=="All")
                        {
                            $("#semester2").val($("#semester2 option:eq(1)").val());
                        }
                        else{
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

$("#batch2").change(function () {
        var batches = $("#batch2").val();
        if (batches == 'All')
        {
            $("#semester2").val($("#semester2 option:eq(1)").val());
        }
    });
    function get_student(batch, semester = '') {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/batchwisestudent/',
            type: 'POST',
            data: {'batch': batch},
            success: function (content) {
                $("#student2").html(content);
            }
        });
    }

    function get_students(sem)
    {
        /*  var batch = $("#batch2").val();
         $.ajax({
         url: '<?php echo base_url(); ?>index.php?admin/semwisestudent/',
         type: 'POST',
         data: {'batch':batch,'sem':sem},
         success: function(content){
         //alert(content);
         $("#student2").html(content);
         }
         });
         */
        var batch = $("#batch2").val();
        var course = $("#course2").val();
        var degree = $("#degree2").val();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/semwisestudent/',
            type: 'POST',
            data: {'batch': batch, 'sem': sem, 'course': course, 'degree': degree},
            success: function (content) {
                //alert(content);
                $("#student2").html(content);
            }
        });

    }

    function participatefile(myfile)
    {
        alert(myfile);
        var val = $(myfile).val();
        var ext = val.substring(val.lastIndexOf('.') + 1).toLowerCase();
    }
    /* $("#participatefile").change(function() {
     alert('123');
     var val = $(this).val();
     
     switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
     case 'gif': case 'jpg': case 'png':
     $("#fileerror").val("");
     
     break;
     default:
     $(this).val('');
     // error message here
     $("#fileerror").val("Please Upload valid Image!");
     break;
     }
     });*/
//    $(document).ready(function(){
//        
//        $('#batch').on('change', function() {
//            alert(1);
//        });
//    });


    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });





    $().ready(function () {
var js_date_format = '<?php echo js_dateformat(); ?>';
        $("#dateofsubmission1").datepicker({
            format: js_date_format, startDate : new Date(),
            autoclose:true,
            minDate: 0
        });
        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("url", function (value, element) {
            return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
        }, 'Please enter a valid URL.');

        $("#frmeditparticipate").validate({
            rules: {
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                student: "required",
                dateofsubmission1: "required",
                title:
                        {
                            required: true,
                        },
                participatefile: {
                    extension: 'gif|jpg|png|pdf|xlsx|xls|doc|docx|ppt|pptx|pdf|txt|jpeg',
                },
            },
            messages: {
                degree: "Select department",
                course: "Select branch",
                batch: "Select batch",
                semester: "Select semester",
                student: "Select student",
                dateofsubmission1: "Select date of submission",
                title:
                        {
                            required: "Enter title",
                        },
                participatefile: {
                    extension: 'Upload valid file',
                }
            },
        });
    });
</script>

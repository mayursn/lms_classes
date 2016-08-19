<?php 

$this->load->model('admission_type/Admission_type_model');
$this->load->model('classes/Class_model');
$this->load->model('branch/Branch_location_model');
$this->load->model('courses/Course_model');
$branch = $this->Branch_location_model->order_by_column('branch_name');
$course = $this->Course_model->order_by_column('c_name');
$class = $this->Class_model->order_by_column('class_name');
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
                    <?php echo form_open(base_url() . 'subject/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmsubject', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Subject Name"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="subname" id="subname" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Subject Code"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="subcode" id="subcode" />
                            </div>
                        </div>
                       
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="course" class="form-control" id="create-course">
                                <option value="">Select</option>
                                <?php foreach($course as $rowcourse): ?>
                                <option value="<?php echo $rowcourse->course_id; ?>"><?php echo $rowcourse->c_name; ?></option>
                                <?php endforeach; ?>
                            </select>
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

   $('#create-course').on('change', function () {
        var course_id = $(this).val();
        
        get_admission_plan(course_id);
        
    });
    function get_admission_plan(course_id)
    {
     $('#create-admission_plan').find('option').remove().end();
        $('#create-admission_plan').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);
                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#create-admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                });
            }
        });
    }

    $(document).ready(function () {
        $("#subname").change(function () {
            $('#semester').val($("#semester option:eq(0)").val());
        });
        $("#course").change(function () {
            $('#semester').val($("#semester option:eq(0)").val());
        });
        $("#subcode").change(function () {
            $('#semester').val($("#semester option:eq(0)").val());
        });
        
        $('#degree').on('change', function(){
            var degree_id = $(this).val();
            branch_from_department(degree_id);
        });

        function branch_from_department(department_id) {
            $('#course').find('option').remove().end();
            $('#course').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/course_list_from_degree/' + department_id,
                type: 'get',
                success: function (content) {
                    var course = jQuery.parseJSON(content);
                    $.each(course, function (key, value) {
                        $('#course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    })
                }
            })
        }
    });
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

 $('#subname').on('change', function(){
         $("#subcode").val('');
        });

    $().ready(function () {
          
        $("#frmsubject").validate({
            rules: {
                subname: "required",
                subcode: 
                        {
                            required:true,
                            remote: {
                                        url: "<?php echo base_url(); ?>subject/checksubject",
                                        type: "post",
                                        data: {
                                            subname: function () {
                                                return $("#subname").val();
                                            },
                                            subcode: function () {
                                                return $("#subcode").val();
                                            }
                                        }
                                    }
                },
            },
            messages: {
                subname: "Enter subject name",
                subcode: 
                    {
                      required:"Enter subject code",
                      remote:"Subject already exits",
                    },
            }
        });
    });
</script>
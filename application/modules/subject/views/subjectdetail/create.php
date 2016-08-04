<?php
$this->load->model('branch/Branch_location_model');
$this->load->model('courses/Course_model');
$this->load->model('admission_plan/Admission_plan_model');

$branch = $this->Branch_location_model->order_by_column('branch_name');
$courses = $this->Course_model->order_by_column('c_name');
$admission_plan = $this->Admission_plan_model->order_by_column('admission_duration');

$professor = $this->db->get('professor p')->result();
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
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select id="branch" class="form-control" name="branch">
                                    <option value="">Select</option>
                                    <?php foreach ($branch as $row) { ?>
                                        <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="admission_plan" class="form-control" id="admission_plan">
                                <option value="">Select</option>
                                <?php foreach ($admission_plan as $plan): ?>
                                <option value="<?php echo $plan->admission_plan_id; ?>"><?php echo $plan->admission_duration; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("professor"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="professor" class="form-control" id="professor"> 
                                    <?php foreach ($professor as $prof) : ?>
                                        <option value="<?php echo $prof->user_id; ?>"><?php echo $prof->name; ?></option>
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

        $('#course').on('change', function () {
            var course_id = $(this).val();
            
            get_admission_plan(course_id);
        });
        
        function get_admission_plan(course_id)
    {
     $('#admission_plan').find('option').remove().end();
        $('#admission_plan').append('<option value="">Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
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
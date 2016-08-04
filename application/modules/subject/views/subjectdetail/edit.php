<?php
$edit_data = $this->db->get_where('subject_association', array('sa_id' => $param2))->result_array();
$this->load->model('branch/Branch_location_model');
$this->load->model('admission_plan/Admission_plan_model');
$admission_plan = $this->Admission_plan_model->get_all();
$branch = $this->Branch_location_model->get_all();
$professor = $this->db->get('professor')->result_array();
foreach ($edit_data as $row):

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
                    <?php echo form_open(base_url() . 'subject/subject_detail_update/'.$this->uri->segment(4), array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmsubjectdetail', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">
                        <input type="hidden" name="smid" value="<?php echo $this->uri->segment(5); ?>">
                      <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select id="branch" class="form-control" name="branch">
                                    <option value="">Select</option>
                                    <?php foreach ($branch as $rows) { ?>
                                        <option value="<?php echo $rows->branch_id; ?>" <?php if($row['branch_id']==$rows->branch_id){ echo "selected=selected"; } ?>><?php echo $rows->branch_name.' - '.$rows->branch_location; ?></option>
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
                                <option value="<?php echo $plan->admission_plan_id; ?>" <?php if($row['admission_plan_id']==$plan->admission_plan_id){ echo "selected=selected"; } ?>><?php echo $plan->admission_duration; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("professor"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="professor" class="form-control" id="professor" > 
                                    <?php foreach ($professor as $prof) : ?>
                                         <option value="<?php echo $prof['user_id'];?>" <?php if($row['professor_id']==$prof['user_id']) { echo "selected"; } ?>><?php echo $prof['name']; ?></option>
                                    <?php endforeach; ?>

                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" id="addsubject" class="btn btn-info vd_bg-green"><?php echo ucwords("update "); ?></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>



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
                               url: "<?php echo base_url(); ?>subject/checksubjects/edit",
                               type: "post",
                               data: {
                                   degree: function () {
                                       return $("#degree").val();
                                   },
                                   course: function () {
                                       return $("#course").val();
                                   },
                                   subjectid: function () {
                                       return <?php echo $this->uri->segment(5);?>;
                                   },
                                    editid: function () {
                                         return <?php echo $this->uri->segment(4);?>;
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

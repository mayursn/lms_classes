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
                            <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?> <span style="color:red">*</span></label>
                            <div class="col-sm-8">

                                <select name="branch" id="branch_id" class="form-control">
                                    <option value="">Select department</option>                                    
                                    <?php
                                    $branch = $this->db->get('branch_location')->result();
                                    foreach ($branch as $rowdegree) {
                                        ?>
                                        <option value="<?php echo  $rowdegree->branch_id ?>" <?php  if($row->branch_id==$rowdegree->branch_id){ echo "selected=selected"; }?>><?php echo  $rowdegree->branch_name.' - '.$rowdegree->branch_location; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="course" id="edit-course" class="form-control">

                                    <option value="">Select Branch</option>
                                    
                                    <?php
                                    $course = $this->db->get_where('course')->result();
                                      foreach ($course as $crs) {
                                      ?>
                                        <option value="<?php echo  $crs->course_id; ?>" <?php if($row->course_id==$crs->course_id){ echo "selected=selected"; } ?> ><?php echo  $crs->c_name ?></option>
                                      <?php
                                      } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan "); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <?php $this->load->model('admission_plan/Admission_plan_model');
                                $plan=$this->Admission_plan_model->order_by_column('admission_duration');
                                ?>
                                <select name="admission_plan" id="edit-admission_plan" onchange="get_student2(this.value);" class="form-control" >
                                    <option value="">Select </option>
                                    <?php foreach($plan as $pl): ?>
                                    <option value="<?php echo $pl->admission_plan_id; ?>" <?php if($row->admission_plan_id==$pl->admission_plan_id){ echo "selected=selected"; } ?>><?php echo $pl->admission_duration; ?></option>
                                    <?php endforeach; ?>                                    
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
  $('#edit-course').on('change', function () {
        var course_id = $(this).val();
        
        get_admission_plan(course_id);        
    });
    function get_admission_plan(course_id)
    {
     $('#edit-admission_plan').find('option').remove().end();
        $('#edit-admission_plan').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);
                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#edit-admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
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

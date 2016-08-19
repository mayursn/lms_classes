<?php
$edit_data = $this->db->get_where('fees_structure', array('fees_structure_id' => $param2))->row();
    $this->load->model('admission_plan/Admission_plan_model');
$this->load->model('classes/Class_model');
$this->load->model('courses/Course_model');
$course = $this->Course_model->order_by_column('c_name');
$class = $this->Class_model->order_by_column('class_name');
$admission_plan = $this->Admission_plan_model->order_by_column('admission_duration');
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
                        <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <?php $this->load->model('branch/Branch_location_model'); 
                            $branch = $this->Branch_location_model->order_by_column('branch_name');
                            ?>
                            <select name="branch" class="form-control" id="branch">
                                <option value="">Select</option>
                                <?php foreach ($branch as $rows) { ?>
                                    <option value="<?php echo $rows->branch_id; ?>" <?php if($edit_data->branch_id==$rows->branch_id){ echo "selected=selected"; } ?>><?php echo $rows->branch_name; ?></option>
                                <?php } ?>                                
                            </select>
                        </div>
                    </div>	
                         <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="course" class="form-control" id="course">
                                <option value="">Select</option>
                                <?php foreach($course as $rowcourse): ?>
                                <option value="<?php echo $rowcourse->course_id; ?>" <?php if($edit_data->course_id==$rowcourse->course_id){ echo "selected=selected"; } ?>><?php echo $rowcourse->c_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="admission_plan" class="form-control" id="admission_plan">
                                <option value="">Select</option>
                                <?php foreach ($admission_plan as $plan): ?>
                                <option value="<?php echo $plan->admission_plan_id; ?>" <?php if($edit_data->admission_plan_id==$plan->admission_plan_id){ echo "selected=selected"; } ?>><?php echo $plan->admission_duration; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>	
                <div class="form-group">                        
                      <label class="col-sm-4 control-label"><?php echo ucwords("class"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="class" class="form-control" id="class1">
                                            <option value="">Select class</option>
                                            <?php
                                            foreach ($class as $c) {
                                                if ($c->class_id == $edit_data->class_id) {
                                                    ?>
                                                    <option selected value="<?php echo $c->class_id; ?>"><?php echo $c->class_name; ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $c->class_id; ?>"><?php echo $c->class_name; ?></option>
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
                branch: "required",
                course: "required",
                class: "required",
                admission_plan: "required",
                edit_fees:{
                    required: true,
                    currency: ['$', false]
                },
                start_date: "required",
                end_date: "required",
                expiry_date: "required",
                penalty: {
                    required: true,
                    currency: ['$', false]
                },
            },
            messages: {
                edit_title: "Please enter title",
                branch: "Please select branch",
                course: "Please select course",
                admission_plan: "Please select admission plan",
                class: "Please select class",
                edit_fees: {
                    required: "Please Enter  Fee",
                    currency: "Please Enter Valid Amount"
                },
                start_date: "Please enter start date",
                end_date: "Please enter end date",
                expiry_date: "Please enter expiry date",
                penalty: {
                    required: "Enter  penalty",
                    currency: "Enter Valid Amount"
                },
            }
        });
    });
</script>

<script>
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


</script>

<script>    
     $(document).ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        $("#edit_start_date").datepicker({
            format: js_date_format,
            todayHighlight: true,
            autoclose: true,
            startDate: new Date(),
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
        $('#edit_end_date').datepicker('setStartDate', minDate);
        });
        $("#edit_end_date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    todayHighlight: true                  
                }).on('changeDate', function (selected) {
                        var minDate = new Date(selected.date.valueOf());
                    $('#edit_expiry_date').datepicker('setStartDate', minDate);
        });
                  
           $("#edit_expiry_date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    todayHighlight: true
                });
        
    });
    //minDate: new Date(),

</script>
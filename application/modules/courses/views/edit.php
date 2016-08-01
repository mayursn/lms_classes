<?php
$edit_data = $this->db->get_where('course', array('course_id' => $param2))->result_array();
foreach ($edit_data as $row): ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default">
                <div class="panel-body">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content"> 
                            <div class="">
                                <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?> </span> 
                            </div>
                            <?php echo form_open(base_url() . 'courses/update/' . $row['course_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmcourseedit', 'target' => '_top')); ?>
                           
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("course name"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="c_name" id="c_name" value="<?php echo $row['c_name']; ?>" />
                                </div>
                            </div>                   
                            <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="admission_plan[]" id="admission_plan" class="form-control" multiple="" >                               
                                <?php
                                $this->load->model('admission_plan/Admission_plan_model');
                                $plan = $this->Admission_plan_model->order_by_column('admission_duration');
                                $plan_id = explode(",",$row['admission_plan_id']);
                                foreach ($plan as $rows) {
                                    ?>
                                    <option value="<?php echo $rows->admission_plan_id; ?>" <?php if(in_array($rows->admission_plan_id,$plan_id)){ echo "selected=selected"; }   ?>><?php echo $rows->admission_duration; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                                <div class="col-sm-8">
                                    <select name="course_status" class="form-control">
                                        <option value="1" <?php
                                        if ($row['course_status'] == '1') {
                                            echo "selected";
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if ($row['course_status'] == '0') {
                                            echo "selected";
                                        }
                                        ?>>Inactive</option>	
                                    </select>
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
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {
        $("#frmcourseedit").validate({
            rules: {
                c_name: "required",
                'admission_plan[]': "required",
            },
            messages: {
                c_name: "Enter branch name",
                'admission_plan[]': "Select Admission plan",
            }
        });
    });
</script>
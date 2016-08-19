<?php ?>

<!-- Start .row -->
<div class=row>     
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body">
                <div class="">
                    <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                </div>                                    
                <?php echo form_open(base_url() . 'courses/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'courseform', 'target' => '_top')); ?>
                <div class="padded">

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Course name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="c_name" id="c_name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="admission_plan[]" id="admission_plan" class="form-control" multiple="" >                               
                                <?php
                                $this->load->model('admission_plan/Admission_plan_model');
                                $plan = $this->Admission_plan_model->order_by_column('admission_duration');
                                foreach ($plan as $row) {
                                    ?>
                                    <option value="<?php echo $row->admission_plan_id; ?>"><?php echo $row->admission_duration; ?></option>
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
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>

                            </select>
                        </div>	
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("add"); ?></button>
                        </div>
                    </div>            
                </div>  
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        $("#courseform").validate({
            rules: {
                c_name:
                        {
                            required: true,
                            remote: {
                                url: "<?php echo base_url() . 'courses/check_course'; ?>",
                                type: "post",
                                data: {
                                    course: function () {
                                        return $("#c_name").val();
                                    },
                                }
                            }
                        },
                'admission_plan[]': "required",
            },
            messages: {
                c_name:
                        {
                            required: "Enter course name",
                            remote: "Record is already present in the system",
                        },
                'admission_plan[]': "Select Admission plan",
            },
        });

    });
</script>

<?php
$edit_data = $this->db->get_where('admission_plan', array('admission_plan_id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default">
                <!-- Start .panel -->
                <div class="panel-body"> 
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>
                    <?php echo form_open(base_url() . 'admission_plan/update/' . $row['admission_plan_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmadmissiontypeedit', 'target' => '_top')); ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="admission_plan" id="admission_plan" value="<?php echo $row['admission_duration']; ?>"/>
                        </div>
                    </div>          
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Status</label>
                        <div class="col-sm-8">
                            <select name="at_status" class="form-control">
                                <option value="1" <?php
                                if ($row['admission_plan_status'] == '1') {
                                    echo "selected";
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if ($row['admission_plan_status'] == '0') {
                                    echo "selected";
                                }
                                ?>>Inactive</option>		
                            </select>														
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="submit btn btn-info"><?php echo ucwords("Update"); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
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
        $("#frmadmissiontypeedit").validate({
            rules: {
                admission_plan: "required",
                at_status: "required",
            },
            messages: {
                admission_plan: "Please enter admission plan",
                at_status: "Please slect admission status",
            }
        });
    });
</script>

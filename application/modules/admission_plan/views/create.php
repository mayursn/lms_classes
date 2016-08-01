<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body">  
                <div class="">
                    <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                </div>                                                                    
                <?php echo form_open(base_url() . 'admission_plan/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmadmission_type', 'target' => '_top')); ?>
                <div class="padded">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Admission Plan <span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="admission_plan" id="admission_plan" />
                        </div>
                    </div>												
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Status</label>
                        <div class="col-sm-8">
                            <select name="at_status" class="form-control" >
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>		
                            </select>	

                        </div>	
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-info vd_bg-green">Add</button>
                        </div>
                    </div>             
                </div> 
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">

    $().ready(function () {
        $("#frmadmission_type").validate({
            rules: {               
                admission_plan:
                        {
                            required: true,
                            remote: {
                                url: "<?php echo base_url() . 'admission_plan/check_admission_plan'; ?>",
                                type: "post",
                                data: {
                                    admission_plan: function () {
                                        return $("#at_name").val();
                                    },
                                }
                            }
                        },
                at_status: "required",
            },
            messages: {
                admission_plan:
                        {
                            required: "Enter Admission Plan",
                            remote: "Record is already present in the system",
                        },
                at_status: "Please slect admission status",
            }
        });
    });
</script>

<div class=row>     
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body"> 
                <div class="">
                    <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                </div>                                    
                <?php echo form_open(base_url() . 'semester/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmsemester', 'target' => '_top')); ?>
                <div class="padded">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Semester Name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="s_name" id="s_name" />
                        </div>
                    </div>												
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Status"); ?></label>
                        <div class="col-sm-8">
                            <select name="semester_status" class="form-control">
                                <option value="1" >Active</option>
                                <option value="0" >Inactive</option>		
                            </select>

                        </div>	
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                        </div>
                    </div>              
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
        $("#frmsemester").validate({
            rules: {
                s_name:
                        {
                            required: true,
                            remote: {
                                url: "<?php echo base_url() . 'semester/check_semester'; ?>",
                                type: "post",
                                data: {
                                    semester: function () {
                                        return $("#s_name").val();
                                    },
                                }
                            }
                        },
                semester_status: "required",
            },
            messages: {
                s_name:
                        {
                            required: "Enter semester name",
                            remote: "Record is already present in the system",
                        },
                semester_status: "Slect semester status",
            }
        });
    });
</script>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body"> 

                <div class="box-content">     
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                    
                    <?php echo form_open(base_url() . 'user/role/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'role-form', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Role Name<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="role_name" id="role_name"/>
                            </div>
                        </div>												
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                            <div class="col-sm-8">
                                <select name="status"  class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>		
                                </select>	
                            </div>	
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green" ><?php echo ucwords("add"); ?></button>
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
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });


    $().ready(function () {

        $("#role-form").validate({
            rules: {
                role_name: "required",
                status: "required",
            },
            messages: {
                role_name: "Enter role name",
                status: "Select status",
            }
        });
    });
</script>
<?php
$edit_data = $this->db->get_where('role', [
            'role_id' => $param2
        ])->row();
?>
<div class = row>
    <div class = col-lg-12>
        <!--col-lg-12 start here -->
        <div class = "panel-default toggle panelMove panelClose panelRefresh">
            <div class = "panel-body">
                <div class = "tab-pane box" id = "add" style = "padding: 5px">
                    <div class = "box-content">
                        <div class = "form-group">
                            <span style = "color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                        </div>
                        <?php echo form_open(base_url() . 'user/role/update/' . $edit_data->role_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'role-edit', 'target' => '_top')); ?>

                        <div class="padded">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Role Name<span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="role_name" id="role_name"
                                           value="<?php echo $edit_data->role_name; ?>"/>
                                </div>
                            </div>												
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                                <div class="col-sm-8">
                                    <select name="status"  class="form-control">
                                        <option value="1"
                                                <?php if ($edit_data->is_active == 1) echo 'selected'; ?>>Active</option>
                                        <option value="0"
                                                <?php if ($edit_data->is_active == 0) echo 'selected'; ?>>Inactive</option>		
                                    </select>	
                                </div>	
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-info vd_bg-green" >Update</button>
                                </div>
                            </div>            
                        </div>  
                        <?php echo form_close(); ?>
                    </div> 
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

        $("#role-edit").validate({
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

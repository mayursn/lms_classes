<!-- Start .row -->
<div class=row>     
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class="panel-body"> 

                <div class="box-content">     
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                    
                    <?php echo form_open(base_url() . 'department/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'degreeform', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("department name"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="d_name" id="d_name"/>
                            </div>
                        </div>												
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                            <div class="col-sm-8">
                                <select name="degree_status"  class="form-control">
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
                        </form>               
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

        $("#degreeform").validate({
            rules: {
                d_name:
                        {
                            required: true,
                            remote: {
                                url: "<?php echo base_url() . 'department/check_degree'; ?>",
                                type: "post",
                                data: {
                                    course: function () {
                                        return $("#d_name").val();
                                    },
                                }
                            }
                        },
                degree_status: "required",
            },
            messages: {
                d_name:
                        {
                            required: "Enter department name",
                            remote: "Record is already present in the system",
                        },
                degree_status: "Select status",
            }
        });
    });
</script>
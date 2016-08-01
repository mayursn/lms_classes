<?php
$this->load->model('branch/Branch_location_model');

?>

<!-- Start .row -->
<div class=row>     
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body">
                <div class="">
                    <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                </div>                                    
                <?php echo form_open(base_url() . 'branch/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'courseform', 'target' => '_top')); ?>
                <div class="padded">
                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("branch name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="c_name" id="c_name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Location"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="branch_location" id="branch_location"/>
                        </div>
                    </div>                   
                   

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                        <div class="col-sm-8">
                            <select name="branch_status" class="form-control">
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
                                url: "<?php echo base_url() . 'branch/check_branch'; ?>",
                                type: "post",
                                data: {
                                    course: function () {
                                        return $("#c_name").val();
                                    },
                                    branch_location: function () {
                                        return $("#branch_location").val();
                                    },
                                }
                            }
                        },               
                branch_location: "required",
            },
            messages: {                
                c_name:
                        {
                            required: "Enter branch name",
                            remote: "Record is already present in the system",
                        },
              
                branch_location: "Enter branch location",
            },
        });

    });
</script>

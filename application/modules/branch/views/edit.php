<?php
$row = $this->db->get_where('branch_location', array('branch_id' => $param2))->row();?>

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
                            <?php echo form_open(base_url() . 'branch/update/' . $row->branch_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmcourseedit', 'target' => '_top')); ?>
                            <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("branch name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="c_name" id="c_name" value="<?php echo $row->branch_name;   ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Location"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="branch_location" id="branch_location" value="<?php echo $row->branch_location; ?>" />
                        </div>
                    </div>                                
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                                <div class="col-sm-8">
                                    <select name="branch_status" class="form-control">
                                        <option value="1" <?php
                                        if ($row->branch_status == '1') {
                                            echo "selected";
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if ($row->branch_status == '0') {
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
                branch_location: "required",               
            },
            messages: {
                c_name: "Enter branch name",
                branch_location: "Enter branch location",
                
            }
        });
    });
</script>
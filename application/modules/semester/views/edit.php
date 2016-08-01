<?php
$edit_data = $this->db->get_where('semester', array('s_id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle">
                <div class="panel-body"> 
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>
                    <?php echo form_open(base_url() . 'semester/update/' . $row['s_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'editsem', 'target' => '_top')); ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Semester Name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="s_name" id="s_name" value="<?php echo $row['s_name']; ?>"   />
                        </div>
                    </div>                  
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Status"); ?></label>
                        <div class="col-sm-8">
                            <select name="semester_status" class="form-control">
                                <option value="1" <?php
                                if ($row['s_status'] == '1') {
                                    echo "selected";
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if ($row['s_status'] == '0') {
                                    echo "selected";
                                }
                                ?>>Inactive</option>		
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="submit btn btn-info vd_bg-green"><?php echo ucwords("Update"); ?></button>
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

    $().ready(function () {
        $("#editsem").validate({
            rules: {
                s_name: "required",
            },
            messages: {
                s_name: "Enter semester name",
            }
        });
    });
</script>
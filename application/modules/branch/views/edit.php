<?php
$edit_data = $this->db->get_where('course', array('course_id' => $param2))->result_array();
foreach ($edit_data as $row): ?>
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
                            <?php echo form_open(base_url() . 'branch/update/' . $row['course_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmcourseedit', 'target' => '_top')); ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select id="degree" name="degree" class="form-control">
                                        <option value="">--- Select Course ---</option>
                                        <?php
                                        $sem = $this->db->get_where('degree')->result_array();
                                        foreach ($sem as $srow) {
                                            ?>
                                            <option value="<?php echo $srow['d_id']; ?>" <?php
                                            if ($srow['d_id'] == $row['degree_id']) {
                                                echo "selected=selected";
                                            }
                                            ?> ><?php echo $srow['d_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>	
                            </div>  
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("branch name"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="c_name" id="c_name" value="<?php echo $row['c_name']; ?>" />
                                </div>
                            </div>                   
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("ID"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="course_alias_id" name="course_alias_id" value="<?php echo $row['course_alias_id']; ?>"/>
                                </div>	
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("semester"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select id="semester" name="semester[]" class="form-control" multiple>

                                        <?php
                                        $semexplode = explode(',', $row['semester_id']);
                                        $semesters = $this->db->get('semester')->result_array();
                                        foreach ($semesters as $srow) {
                                            ?>
                                            <option value="<?php echo $srow['s_id']; ?>" <?php
                                            if (in_array($srow['s_id'], $semexplode)) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $srow['s_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>	
                            </div>          
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("description"); ?></label>
                                <div class="col-sm-8">
                                    <textarea name="c_description" id="c_description" rows="5" class="form-control"><?php echo $row['c_description']; ?></textarea>
                                </div>	
                            </div>                    
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                                <div class="col-sm-8">
                                    <select name="course_status" class="form-control">
                                        <option value="1" <?php
                                        if ($row['course_status'] == '1') {
                                            echo "selected";
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if ($row['course_status'] == '0') {
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
<?php endforeach; ?>
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
                course_alias_id: "required",
                degree: "required",
                'semester[]': "required",
            },
            messages: {
                c_name: "Enter branch name",
                course_alias_id: "Enter branch id",
                degree: "Select department",
                'semester[]': "Select semester",
            }
        });
    });
</script>
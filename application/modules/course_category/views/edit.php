<?php
$edit_data = $this->db->get_where('course_category', array('category_id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default">
                <div class="panel-body"> 
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>

                    <?php echo form_open(base_url() . 'course-category/update/' . $row['category_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmeditclass', 'target' => '_top')); ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("class name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo $row['category_name']; ?>"   />
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("category Description"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="category_desc"><?php echo $row['category_desc']; ?></textarea>
                        </div>

                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Status"); ?></label>
                        <div class="col-sm-8">
                            <select name="category_status" class="form-control">
                                <option value="1" <?php
                                if ($row['category_status'] == '1') {
                                    echo "selected=selected";
                                }
                                ?>>Active</option>
                                <option value="0"  <?php
                                if ($row['category_status'] == '0') {
                                    echo "selected=selected";
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

<?php endforeach; ?>
<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
        $("#frmeditclass").validate({
            rules: {
                category_name: "required",
                category_desc: "required",
                category_status: "required",
            },
            messages: {
                category_name: "Enter class name",
                category_desc: "Enter Description",
                category_status: "Select Status",
            }

        });
    });
</script>


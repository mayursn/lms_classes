<?php
$edit_data = $this->db->get_where('cms_manager', array('c_id' => $param2))->result_array();
foreach ($edit_data as $row) {
    
}
?>

<div class=col-lg-12>
    <!-- col-lg-12 start here -->
    <div class="panel-default toggle panelMove panelClose panelRefresh">
        <div class=panel-body>
            <?php echo form_open(base_url() . 'cms/update/' . $row['c_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'editcmsform', 'target' => '_top')); ?>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo ucwords("Page Title"); ?><span style="color:red">*</span></label>
                <div class="col-sm-8 controls">
                    <input type="text" class="form-control" name="c_title" value="<?php echo $row['c_title']; ?>" id="c_title"/>
                </div>
            </div>                   
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo ucwords("Page Slug"); ?><span style="color:red">*</span></label>
                <div class="col-sm-8 controls">
                    <input type="text" class="form-control" name="c_slug" value="<?php echo $row['c_slug']; ?>" id="c_slug"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo ucwords("Status"); ?></label>
                <div class="col-sm-8">
                    <select name="c_status" class="form-control">
                        <option value="1" <?php
                        if ($row['c_status'] == '1') {
                            echo "selected";
                        }
                        ?>>Active</option>
                        <option value="0" <?php
                        if ($row['c_status'] == '0') {
                            echo "selected";
                        }
                        ?>>Inactive</option>        
                    </select>	
                </div>
            </div>	
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo ucwords("Page Content"); ?><span style="color:red">*</span></label>
                <div class="col-sm-8 controls">
                    <textarea name="edit_content_data"  class="form-control summernote" rows="3" ><?php echo $row['c_description']; ?></textarea>
                </div>
            </div>             
            <div class="form-group form-actions">
                <div class="col-sm-4"> </div>
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Update</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <!-- End .panel -->
</div>
<!-- col-lg-12 end here -->

    <script type="text/javascript">
        $.validator.setDefaults({
            submitHandler: function (form) {
                form.submit();
            }
        });
        $().ready(function () {
            $("#editcmsform").validate({
                //ignore: [],
                rules: {
                    c_title: "required",
                    c_slug: "required",
                    edit_content_data: "required",
                },
                messages: {
                    c_title: "Enter title",
                    c_slug: "Select slug",
                    edit_content_data: "Enter page content",
                }
            });
        });        
        $('.summernote').summernote({
            height: 200
        });
    </script>
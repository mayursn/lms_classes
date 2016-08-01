<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">

            <div class="panel-body"> 

                <div class="box-content">     
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                    
                    <?php echo form_open(base_url() . 'course-category/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmcategory', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("category name"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="category_name" id="category_name" value="" />
                            </div>
                            <lable class="error" id="error_lable_exist" style="color:#f85d2c"></lable>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("category Description"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <textarea name="category_desc" class="form-control"></textarea>
                            </div>
                            <lable class="error" id="error_lable_exist" style="color:#f85d2c"></lable>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Status"); ?></label>
                            <div class="col-sm-8">
                                <select name="category_status" class="form-control" > 
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>		
                                </select>
                            </div>	
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" id="btnadd"  class="btn btn-info vd_bg-green" ><?php echo ucwords("add"); ?></button>
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


</script>

<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });


    $().ready(function () {

        $("#frmcategory").validate({
            rules: {
                category_name:
                        {
                            required: true,
                        },
                category_desc: "required",
                category_status: "required",
            },
            messages: {
                category_name:
                        {
                            required: "Enter category name",
                        },
                category_desc: "Enter Description",
                category_status: "Select Status",
            }
        });
    });

</script>
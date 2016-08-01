<div class="row">

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>Add CMS Page</h4>
                        </div>-->
            <div class=panel-body>
                <?php echo form_open(base_url() . 'cms/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'cmsform', 'target' => '_top')); ?>
                <div class="padded">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Page Name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="c_title" id="c_title" required="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Page Slug"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required="" name="c_slug" id="c_slug"/>
                        </div>
                    </div>
                    <div class="form-group">					
                        <label class="col-sm-4 control-label"><?php echo ucwords("Page Content"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">		
                            <textarea name="c_description" required="" class="form-control summernote" rows="3" required></textarea>
                        </div>														
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Status"); ?></label>
                        <div class="col-sm-8">
                            <select name="c_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>		
                            </select>
                        </div>	
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>   
                </div>
            </div>
            <!-- End .panel -->
        </div>
        <!-- col-lg-12 end here -->
    </div>

    <script type="text/javascript">
        $.validator.setDefaults({
            submitHandler: function (form) {
                form.submit();
            }
        });
        $().ready(function () {
            $("#cmsform").validate({
                //ignore: [],
                rules: {
                    c_title: "required",
                    c_slug: "required",
                    c_description: "required",
                },
                messages: {
                    c_title: "Enter title",
                    c_slug: "Select slug",
                    c_description: "Enter page content",
                }
            });
        });        
        $('.summernote').summernote({
            height: 200
        });
    </script>
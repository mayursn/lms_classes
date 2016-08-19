<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>Submit Project</h4>
                        </div>-->
            <div class=panel-body>
                <?php echo form_open(base_url() . 'project/submit_project/', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'edit_exam_center', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                <div class="padded">
                    <input type="hidden" name="project_id" id="project_id" value="<?php echo $param2; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Project File</label>
                        <div class="col-sm-5">
                            <input type="file" name="document_file[]" multiple="" id="document_file" >
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-5">
                            <textarea class="form-control" id="comment" name="comment" ></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </div>  
                <?php echo form_close(); ?>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->

<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });


    $(document).ready(function () {
        
        $("#edit_exam_center").validate({
            rules: {
                comment: "required",
               document_file: {
                    required: true,
                    extension: 'gif|jpg|png|pdf|xlsx|xls|doc|docx|ppt|pptx|txt|zip|rar',
                }
            },
            messages: {
               comment: "Enter Comment",
                document_file: {
                    required: "Upload file",
                    extension: 'Upload valid file',
                }
            }
        });
    });
</script>	

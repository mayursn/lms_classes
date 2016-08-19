<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title><?php echo $title; ?></h4>
                            <div class="panel-controls panel-controls-right">
                                <a class="panel-refresh" href="#"><i class="fa fa-refresh s12"></i></a>
                                <a class="toggle panel-minimize" href="#"><i class="fa fa-plus s12"></i></a>
                                <a class="panel-close" href="#"><i class="fa fa-times s12"></i></a>
                            </div>
                        </div>-->
            <div class=panel-body>
                <?php echo form_open(base_url() . 'participate/upload/', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmproject', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                <div class="padded">	
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Title <span style="color:red">* </span> </label>
                        <div class="col-sm-5">
                            <input type="text" name="title" value="" class="form-control" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Description <span style="color:red">* </span> </label>
                        <div class="col-sm-5">
                            <textarea name="description" class="form-control" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Upload <span style="color:red">* </span> </label>
                        <div class="col-sm-5">
                            <input type="file" name="fileupload" />
                        </div>
                        <label id="filestyle-0-error" class="error" for="filestyle-0" style="display:none;">Please browse file.</label>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-primary">Upload File</button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <div class="tab-content">
                    <!----TABLE LISTING STARTS-->
                    <div class="tab-pane box active" id="list">		


                        <div class="panel-body table-responsive" id="getresponse">                                                                     
                            <table id="upload-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                                <thead>
                                    <tr>
                                        <th>No</th>	
                                        <th><?php echo ucwords("title"); ?></th>
                                        <th><?php echo ucwords("Description"); ?></th>
                                        <th><?php echo ucwords("File"); ?></th>                                            
                                        <th><?php echo ucwords("Uploaded Time"); ?></th>                                            

                                    </tr>
                                </thead>
                                <tbody>                                           
                                    <?php
                                    $count = 1;
                                    foreach (@$upload_data as $row):
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>	
                                            <td><?php echo $row->upload_title; ?></td>	
                                            <td><?php echo $row->upload_desc; ?></td>	
                                            <td id="downloadedfile"><a href="<?php echo base_url() . 'uploads/project_file/' . $row->upload_file_name; ?>" download="" title=""><i class="fa fa-download"></i></a></td>	                                                  
                                            <td><?php echo date_duration($row->created_date); ?></td>

                                        </tr>
                                    <?php endforeach; ?>						
                                </tbody>
                            </table>
                        </div>    
                    </div>


                    <!----TABLE LISTING ENDS--->

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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {

        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z]+$/.test(value);
        }, 'Please enter a valid character');

        $("#frmproject").validate({
            rules: {
                title:"required",
                description:"required",
                fileupload: {required: true,
                    extension: "gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|ppt|pptx|pdf|txt",
                }
            },
            messages: {
                title:"Enter title",
                description:"Enter description",
                fileupload: {
                    required: "Please browse file.",
                    extension: "Please upload valid file"

                }
            }
        });
    });
</script>

<script>
$(document).ready(function(){
    $('#upload-datatable-list').DataTable({"language": { "emptyTable": "No data available" }});
});
</script>

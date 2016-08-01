<?php
$edit_data = $this->db->get_where('forum', array('forum_id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle panelMove panelClose panelRefresh">
                <!-- Start .panel -->
                <!--                <div class=panel-heading>
                                    <h4 class=panel-title>  <?php echo ucwords("Update Forum"); ?></h4>                
                                </div>-->
                <div class="panel-body">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content">  

                            <div class="">
                                <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                            </div>
                            <?php echo form_open(base_url() . 'forum/update/' . $param2, array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmadmissiontypeedit', 'target' => '_top')); ?>
                            <div class="padded">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Title<span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="forum_title" id="forum_title" value="<?php echo $row['forum_title']; ?>" />
                                    </div>
                                </div>												
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Status <span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="forum_status" class="form-control" >
                                            <option value="1" <?php
                                            if ($row['forum_status'] == "1") {
                                                echo "selected=selected";
                                            }
                                            ?>>Active</option>
                                            <option value="0"  <?php
                                            if ($row['forum_status'] == "0") {
                                                echo "selected=selected";
                                            }
                                            ?>>Inactive</option>		
                                        </select>
                                    </div>	
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <button type="submit" class="btn btn-info vd_bg-green">Update forum</button>
                                    </div>
                                </div>
                                </form>   
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
            $("#frmadmissiontypeedit").validate({
                rules: {
                    forum_title: "required",
                    forum_status: "required",
                },
                messages: {
                    forum_title: "Please enter title",
                    forum_status: "Please select status",
                }
            });
        });
    </script>

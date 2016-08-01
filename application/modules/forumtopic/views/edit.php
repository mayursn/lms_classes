<?php
$this->load->model('forumtopic/Forum_topics_model');
$this->load->model('forum/Forum_model');
$row = $this->Forum_topics_model->get($param2);
$forum = $this->Forum_model->get_all();
?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                                <h4 class=panel-title>  <?php echo ucwords("Update Forum topic"); ?></h4>                
                            </div>               -->
            <div class="panel-body">
                <div class="tab-pane box" id="add" style="padding: 5px">
                    <div class="box-content">  
                        <div class="">
                            <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                        </div>
                        <?php echo form_open(base_url() . 'forumtopic/update/' . $param2, array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'edit-forum-topic', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                        <div class="padded">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Forum <span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="forum_id" id="forum_id" class="form-control">
                                        <option value="">Select Forum</option>
                                        <?php
                                        foreach ($forum as $form):
                                            if ($row->forum_id == $form->forum_id) {
                                                ?>
                                                <option value="<?php echo $form->forum_id; ?>" selected=""><?php echo $form->forum_title; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $form->forum_id; ?>"><?php echo $form->forum_title; ?></option>
                                            <?php } ?>

                                        <?php endforeach; ?>                                                    
                                    </select>	

                                </div>	
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Topic Title<span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="topic_title" value="<?php echo $row->forum_topic_title; ?>" id="topic_title" />
                                </div>
                            </div>		
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="description" id="description"><?php echo $row->forum_topic_desc; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("File"); ?></label>
                                <div class="col-sm-8">
                                    <input type="file" name="topicfile"  >
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Status <span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="topic_status" class="form-control">
                                        <option value="1" <?php
                                        if ($row->forum_topic_status == "1") {
                                            echo "selected=selected";
                                        }
                                        ?>>Active</option>
                                        <option value="0"  <?php
                                        if ($row->forum_topic_status == "0") {
                                            echo "selected=selected";
                                        }
                                        ?>>Inactive</option>		
                                    </select>	

                                </div>	
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-info vd_bg-green">Update Forum Topic</button>
                                </div>
                            </div>
                            </form>   

                        </div> </div> </div>
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
            $("#edit-forum-topic").validate({
                rules: {
                    forum_id: "required",
                    topic_title: "required",
                    topic_status: "required",
                    topicfile: {
                        extension: 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|ppt|pptx|txt'
                    },
                },
                messages: {
                    forum_id: "Please select forum",
                    topic_title: "Please enter topic title",
                    topic_status: "Please select status",
                    topicfile: {
                        extension: "Upload valid file",
                    },
                }
            });
        });
    </script>

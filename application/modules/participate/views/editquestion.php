<?php
$edit_data = $this->db->get_where('survey_question', array('sq_id' => $param2))->result_array();

    ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle panelMove panelClose panelRefresh">
                <!-- Start .panel -->
                <!--                <div class=panel-heading>
                                    <h4 class=panel-title>                         
                <?php echo ucwords("Update Question"); ?>
                                    </h4>                
                                </div>-->
                <div class="panel-body">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content">  
                              <div class="">
                                    <span style="color:red">* <?php echo "is ".ucwords("mandatory field");?></span> 
                                </div>  
                            <?php echo form_open(base_url() . 'participate/update_question/' . $edit_data[0]['sq_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmeditquestion', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                            <div class="form-group">
                                            <label class="col-sm-4 control-label"><?php echo ucwords("Question");?> <span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="question" value="<?php echo $edit_data[0]['question']; ?>" id="question" />
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"><?php echo ucwords("Short Description ");?><span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="description" id="description"><?php echo $edit_data[0]['question_description']; ?></textarea>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-4 control-label"><?php echo ucwords("Status ");?><span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="radio" id="status" name="status" value="1" <?php if($edit_data[0]['question_status']=="1"){ echo "checked=checked"; } ?> >Active
                                                 <input type="radio" id="status" name="status" value="0" <?php if($edit_data[0]['question_status']=="0"){ echo "checked=checked"; } ?> > Deactive
                                                   <label for="status" class="error"></label>
                                            </div>
                                        </div>

                                        
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-8">
                                                <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Update");?></button>
                                            </div>
                                        </div>
                            
                            </form>
                        </div> </div> </div>
            </div>
        </div>
    </div>

    <?php

?>
<script type="text/javascript">
    
    
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });
    
   



    $().ready(function () {

        $("#dateofsubmission1").datepicker({
            minDate:0
        });
        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("url", function (value, element) {
            return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/.test(value);
        }, 'Please enter a valid URL.');

                                                          $("#frmeditquestion").validate({
                                                                    rules: {
                                                                        question:"required",
                                                                        description:"required",
                                                                        status:"required"
                                                                    },
                                                                    messages: {
                                                                        question:"enter question",
                                                                        description:"enter description",
                                                                        status:"select status"
                                                                    },
                                                                });
    });
</script>

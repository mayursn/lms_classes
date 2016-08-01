<?php
    $branch = $this->db->get('course')->result_array();
             $subject = $this->db->get('subject_manager')->result_array();
?>
<div class="row">

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title> <?php echo ucwords("Add Courseware"); ?></h4>
                        </div>-->
            <div class="panel-body"> 

                <div class="box-content">     
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                    
                    <?php echo form_open(base_url() . 'courseware/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmcourseware', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">

                                <select name="branch" id="branch" class="form-control">
                                    <option value="">Select Branch</option>                                    
                                    <?php
                                    foreach ($branch as $b) {
                                        ?>
                                        <option value="<?php echo $b['course_id'] ?>"><?php echo $b['c_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("subject"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select name="subject" id="subject" class="form-control">
                                    <option value="">Select Subject</option>                                    
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("chapter name"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="chapter" id="chapter"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("topic"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="topic" id="topic"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("attachment"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="attachment" id="attachment"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>	
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green" ><?php echo ucwords("add"); ?></button>
                            </div>
                        </div>
                        </form>               
                    </div>                
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });
    $("#subject").change(function(){
        
        $("#chapter").val('');
        $("#topic").val('');
    });
    $("#chapter").change(function(){
        $("#topic").val('');
    });
$("#branch").change(function(){
    var id=$(this).val();
    $.ajax({
        type:"POST",
        dataType:'json',
        url:"<?php echo base_url(); ?>subject/branch_subject/"+id,
        success:function(response)
        {
            var option;
            option="<option value=''>Select Subject</option>";
            for(var i=0;i<response.length; i++)
            {
                option +="<option value="+response[i].sm_id+" >"+response[i].subject_name+"</option>";
            }
             $('#subject').html('');
            $("#subject").append(option);
        }
    });  
});

    $().ready(function () {

        $("#frmcourseware").validate({
            rules: {
                branch:
                        {
                            required: true,
                        },
                subject:
                      {
                          required: true,
                      },
                chapter:
                    {
                        required: true,
                    },      
                topic:
                        {
                            required: true,
                            remote: {
                                url: "<?php echo base_url(); ?>courseware/getcourseware",
                                type: "post",
                                data: {
                                    branch: function () {
                                        return $("#branch").val();
                                    },
                                    subject: function () {
                                        return $("#subject").val();
                                    },
                                    chapter: function () {
                                        return $("#chapter").val();
                                    },
                                    topic: function () {
                                        return $("#topic").val();
                                    }
                                }
                            }
                        },
                attachment:
                        {
                            required: true,
                        },
            },
            messages: {
                branch:
                        {
                            required: "Select branch",
                        },
                subject:
                        {
                            required: "Select subject",
                        },
                chapter:
                        {
                            required: "Enter chapter name",
                        },        
                topic:
                        {
                            required: "Enter topic ",
                            remote:"Topic already exists",
                        },
                attachment:
                        {
                            required: "Select attachment",
                        },
            }
        });
    });
</script>
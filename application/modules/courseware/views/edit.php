
<?php

    $branch = $this->db->get('course')->result_array();    
    
$edit_data = $this->db->get_where('courseware', array('courseware_id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>

    <div class="row">

        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle panelMove panelClose panelRefresh">
                <!-- Start .panel -->
                <!--                <div class=panel-heading>
                                            <h4 class=panel-title> <?php echo ucwords("Update Courseware"); ?></h4>
                                        </div>-->
                <div class="panel-body">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content"> 
                            <div class="">
                                <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?> </span> 
                            </div>
                            <?php echo form_open(base_url() . 'courseware/update/' . $row['courseware_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmcoursewareedit', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="editid" id="editid" value="<?php echo $param2; ?>">
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <select name="branch" id="branch" class="form-control" >
                                        <option value="">Select Branch</option>                                    
                                        <?php
                                        foreach ($branch as $b) {
                                            if ($b['course_id'] == $row['branch_id']) {
                                                ?>
                                                <option selected value="<?php echo $b['course_id'] ?>"><?php echo $b['c_name'] ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?php echo $b['course_id'] ?>"><?php echo $b['c_name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("subject"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <?php                              
                                    $this->db->where('sa.course_id',$row['branch_id']);
                                    $this->db->join('subject_association sa','s.sm_id=sa.sm_id');
                                    $subject = $this->db->get('subject_manager s')->result_array();                                   
                                    ?>
                                    <select name="subject" id="subject" class="form-control" >
                                        <option value="">Select Subject</option>                                    
                                        <?php
                                        foreach ($subject as $sub) {
                                           ?>
                                                <option value="<?php echo $sub['sm_id'] ?>" <?php if($sub['sm_id']==$row['subject_id']){ echo "selected=selected"; } ?> ><?php echo $sub['subject_name'] ?></option>                                           
                                            <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("chapter name"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="chapter" id="chapter" value="<?php echo $row['chapter']?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("topic"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="topic" id="topic" value="<?php echo $row['topic'] ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("attachment"); ?><span style="color:red"></span></label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" name="attachment" id="attachment"/>
                                    <input type="hidden" class="form-control" name="oldfile" id="oldfile" value="<?php echo $row['attachment'] ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="description" id="description"> <?php echo $row['description'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                                <div class="col-sm-8">
                                    <select name="status" class="form-control" >
                                        <option value="1" <?php
                                        if ($row['status'] == '1') {
                                            echo "selected";
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if ($row['status'] == '0') {
                                            echo "selected";
                                        }
                                        ?>>Inactive</option>	
                                    </select>
                                </div>	
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button id="btnsubmit" type="submit" class="btn btn-info vd_bg-green" ><?php echo ucwords("update"); ?></button>
                                </div>
                            </div>
                            </form>                            


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
endforeach;
?>
<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

//$("#subject").change(function(){
//        
//       // $("#chapter").val('');
//        $("#topic").val('');
//    });
//    $("#chapter").change(function(){
//        $("#topic").val('');
//    });

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

        $("#frmcoursewareedit").validate({
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
                                url: "<?php echo base_url(); ?>courseware/getcoursewareedit",
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
                                    },
                                    editid: function () {
                                        return $("#editid").val();
                                    }
                                }
                            }
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
            }
        });
    $('#btnsubmit').click(function () {
    $("#frmcoursewareedit").validate({
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
                                url: "<?php echo base_url(); ?>professor/getcourseware/edit",
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
                                    },
                                    editid: function () {
                                        return $("#editid").val();
                                    }
                                }
                            }
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
            }
        });
            
    });
    });
       
  
</script>

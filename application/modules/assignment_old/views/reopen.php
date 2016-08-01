<?php
$this->load->model('assignment/Assignment_submission_model');
$this->db->select('d.d_id,b.b_id,c.course_id,s.s_id,a.assign_id,cl.class_id');
$this->db->join("degree d","d.d_id=a.assign_degree");
$this->db->join("course c","c.course_id=a.course_id");
$this->db->join("batch b","b.b_id=a.assign_batch");
$this->db->join("semester s","s.s_id=a.assign_sem");
$this->db->join("class cl","cl.class_id=a.class_id");
$edit_data = $this->db->get_where('assignment_manager a', array('assign_id' => $param2))->result();
$this->db->select('std_id,std_first_name,std_last_name');
$student_list= $this->db->get_where("student",array("std_degree"=>$edit_data[0]->d_id,"course_id"=>$edit_data[0]->course_id,"std_batch"=>$edit_data[0]->b_id,"semester_id"=>$edit_data[0]->s_id,"class_id"=>$edit_data[0]->class_id))->result();
$reopen_student = $this->Assignment_submission_model->get_student_reopen($param2);

 ?>
<?php
                                           $existing = '';
                                           if(!empty($reopen_student)){
                                              $existing = explode(",",$reopen_student[0]->student_id);
                                               
                                           }
                                ?>

<div class=row>
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content">  
                            <div class="">
                                    <span style="color:red">* <?php echo "is ".ucwords("mandatory field");?></span> 
                                </div>  
                            <?php echo form_open(base_url() . 'assignment/reopen/' . $param2, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmeditproject', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                          
                              <div class="form-group">
                              
                                
                                <label class="col-sm-4 control-label"><?php echo ucwords("Student");?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="checkbox" name="checkall" id="checkAll2">Check All<br>
                                   <div id="student2" class="col-sm-8">
                                        <?php 
                                        foreach ($student_list as $rowstu) {
                                           $exists =  $this->Crud_model->get_submitted_student($param2,$rowstu->std_id);
                                           
                                            if(empty($exists[0]->student))
                                            {
                                            ?>
                                       <div class="checkedstudent">
                                           
                                           <input type="checkbox" <?php if(!empty($existing)){ if(in_array($rowstu->std_id,$existing )) { echo "checked=checked";  } } ?> name="student[]" value="<?php echo $rowstu->std_id; ?>" class="checkbox1" onclick="uncheck();" ><?php echo $rowstu->std_first_name.' '.$rowstu->std_last_name; ?>
                                       </div>
                                            <?php } ?>
                                    <?php            }    ?>
                                   </div>
                                    <label class="error" id="error_std" for="student[]"></label>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" id="btnupd" class="submit btn btn-info vd_bg-green"><?php echo ucwords("Update");?></button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div> </div> </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
     

      $("#checkAll2").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});
    
    
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

$(document).ready(function () {
        $("#frmeditproject").validate({
            rules: {               
               'student[]': "required",
            },
            messages: {
               'student[]':"Select Student",
            }
        });
    });
   
</script>
<script type="text/javascript">
    function uncheck()
    {
         if($('.checkbox1:checked').length == $('.checkbox1').length){             
            $('#checkAll2').prop('checked',true);
        }else{
            $('#checkAll2').prop('checked',false);
        }
    }
</script>
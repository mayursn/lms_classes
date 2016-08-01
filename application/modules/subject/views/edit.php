<?php
$degree = $this->db->order_by('d_name', 'ASC')->get('degree')->result_array();
$edit_data = $this->db->get_where('subject_manager', array('sm_id' => $param2))->result_array();
$branch = $this->db->order_by('course_id', 'ASC')->get_where('course', [
    'course_id' => $edit_data[0]['sm_course_id']
])->row();
foreach ($edit_data as $row):
    ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle panelMove panelClose panelRefresh">
              
                <div class="panel-body">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content">  
                            <div class="">
                                <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                            </div>
                            <?php echo form_open(base_url() . 'subject/update/' . $row['sm_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmeditsubject', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="editid" id="editid" value="<?php echo $param2; ?>">
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Subject Name"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="subname" id="subname" value="<?php echo $row['subject_name']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("Subject Code"); ?><span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="subcode" id="subcode" value="<?php echo $row['subject_code']; ?>" />
                                </div>
                            </div>
 				<div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("status");?></label>
                                <div class="col-sm-8">
                                    <select name="status"  class="form-control">
                                        <option value="1" <?php if($row['sm_status'] == '1'){ echo "selected"; } ?>>Active</option>
                                        <option value="0" <?php if($row['sm_status'] == '0'){ echo "selected"; } ?>>Inactive</option>	
                                    </select>
                                    <lable class="error" id="error_lable_exist" style="color:red"></lable>

                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="submit btn btn-info vd_bg-green"><?php echo ucwords("Update"); ?></button>
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
   
    $("#course1").change(function () {
        var course = $(this).val();
        var degree = $("#degree").val();
        var dataString = "course=" + course;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'admin/get_semester'; ?>",
            data: dataString,
            success: function (response) {
                $("#semester1").html(response);
            }
        });
    });
    
 $('#subname').on('change', function(){
         $("#subcode").val('');
        });
    $().ready(function () {
        $("#frmeditsubject").validate({
            rules: {
                subname: "required",
                subcode: 
                        {
                            required:true,
                            remote: {
                                        url: "<?php echo base_url(); ?>subject/checksubject/edit",
                                        type: "post",
                                        async:true,
                                        data: {
                                            subname: function () {
                                                return $("#subname").val();
                                            },
                                            subcode: function () {
                                                return $("#subcode").val();
                                            },
                                             editid: function () {
                                                return $("#editid").val();
                                            }
                                        }
                                    }
                },
            },
            messages: {
                subname: "Enter subject name",
                subcode: 
                    {
                      required:"Enter subject code",
                      remote:"Subject already exits",
                    },
            }
        });
        
        $('#edit_degree').on('change', function(){
            var degree_id = $(this).val();
            branch_from_department(degree_id);
        });

        function branch_from_department(department_id) {
            $('#course1').find('option').remove().end();
            $('#course1').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/course_list_from_degree/' + department_id,
                type: 'get',
                success: function (content) {
                    var course = jQuery.parseJSON(content);
                    $.each(course, function (key, value) {
                        $('#course1').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    })
                }
            })
        }
    });
</script>

<?php
$this->load->model('department/Degree_model');
$degree = $this->Degree_model->order_by_column('d_name');
$courses = $this->db->get('course')->result_array();
$semesters = $this->db->get('semester')->result_array();
?>

<!-- Start .row -->
<div class=row>     
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body">
                <div class="">
                    <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                </div>                                    
                <?php echo form_open(base_url() . 'branch/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'courseform', 'target' => '_top')); ?>
                <div class="padded">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select id="degree" name="degree" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($degree as $srow) { ?>
                                    <option value="<?php echo $srow->d_id; ?>"><?php echo $srow->d_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("branch name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="c_name" id="c_name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("ID"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="course_alias_id" id="course_alias_id"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("semester"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select id="semester" name="semester[]" class="form-control" multiple>

                                <?php foreach ($semesters as $srow) { ?>
                                    <option value="<?php echo $srow['s_id']; ?>"><?php echo $srow['s_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("description"); ?></label>
                        <div class="col-sm-8">	
                            <div class="chat-message-box">
                                <textarea name="c_description" id="c_description" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                        <div class="col-sm-8">
                            <select name="course_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>

                            </select>
                        </div>	
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("add"); ?></button>
                        </div>
                    </div>            
                </div>  
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        $("#courseform").validate({
            rules: {
                degree: "required",
                c_name:
                        {
                            required: true,
                            remote: {
                                url: "<?php echo base_url() . 'branch/check_course'; ?>",
                                type: "post",
                                data: {
                                    course: function () {
                                        return $("#c_name").val();
                                    },
                                    degree: function () {
                                        return $("#degree").val();
                                    },
                                }
                            }
                        },
                'semester[]': "required",
                course_alias_id: "required",
            },
            messages: {
                degree: "Select department",
                c_name:
                        {
                            required: "Enter branch name",
                            remote: "Record is already present in the system",
                        },
                'semester[]': "Select semester",
                course_alias_id: "Enter branch id",
            },
        });

    });
</script>

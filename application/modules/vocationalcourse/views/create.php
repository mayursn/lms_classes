<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>  <?php echo ucwords("Add vocational course"); ?></h4>                
                        </div>    -->
            <div class="panel-body"> 
                <div class="box-content"> 
                    <div class="">
                        <span style="color:red">*<?php echo "is " . ucwords("mandatory field"); ?> </span> 
                    </div>
                    <?php echo form_open(base_url() . 'vocationalcourse/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmvocationalcourse', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("course name"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="" name="course_name" id="course_name"/>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("start date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="" name="startdate" id="startdate"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("end date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  value="" name="enddate" id="enddate"/>
                            </div>	
                        </div>
                         <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Course Category"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <?php
                                $category = $this->db->get('course_category')->result_array();
                                ?>
                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php foreach ($category as $crow) { ?>
                                        <option value="<?php echo $crow['category_id']; ?>"><?php echo $crow['category_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("course fee"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="" name="fee" id="fee"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Professor"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <?php
                                $professor = $this->db->get('professor')->result_array();
                                ?>
                                <select id="professor" name="professor" class="form-control">
                                    <option value="">Select professor</option>
                                    <?php foreach ($professor as $srow) { ?>
                                        <option value="<?php echo $srow['user_id']; ?>"><?php echo $srow['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                            <div class="col-sm-8">
                                <select name="course_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>	
                                </select>
                                <lable class="error" id="error_lable_exist" style="color:red"></lable>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("add"); ?></button>
                            </div>
                        </div>
                        </form>               
                    </div>                
                </div>

            </div>
        </div>
    </div>
</div> 

<script>
    $(document).ready(function () {
          $( "#startdate" ).focusin(function() {
         $(this).prop('readonly', true);
      });
      $( "#startdate" ).focusout(function() {
         $(this).prop('readonly', false);
      });
       $( "#enddate" ).focusin(function() {
         $(this).prop('readonly', true);
      });
      $( "#enddate" ).focusout(function() {
         $(this).prop('readonly', false);
      });
        
        $("#startdate").datepicker({
             format: ' MM d, yyyy', startDate : new Date(),
            startDate:'0',
            changeMonth: true,
            changeYear: true,
            autoclose:true,
            onClose: function (selectedDate) {
                
                $("#enddate").datepicker("option", "startDate", selectedDate);
            }
        });
        var start = $("#startdate").val();
        

        $("#enddate").datepicker({
             format: ' MM d, yyyy', startDate : new Date(),
            changeMonth: true,
            changeYear: true,
            autoclose:true,
            startDate:new Date(),
            onClose: function (selectedDate) {
                $("#startdate").datepicker("option", "endDate", selectedDate);
            }
        });

        $("#frmvocationalcourse").validate({
            rules: {
                course_name: "required",
                professor: "required",
                category_id:"required",
                fee: {
                        required: true,
                        currency: ['$', false]
                    },
                course_status: "required",
                startdate: "required",
                enddate: "required",
            },
            messages: {
                course_name: "Enter course name",
                professor: "Select professor",
                category_id:"Select Category",
                fee: {
                        required: "Enter fee",
                        currency: "Enter valid amount"
                    },
                course_status: "Select status",
                startdate: "Select start date",
                enddate: "Select end date",
            }
        });
    });
</script>

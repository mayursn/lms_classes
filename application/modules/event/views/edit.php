<?php
$edit_data = $this->db->get_where('event_manager', array('event_id' => $param2))->result_array();
?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>  <?php echo ucwords("Update Event"); ?></h4>                
                        </div>       -->
            <div class="panel-body">
                <div class="tab-pane box" id="edit">
                    <div class="box-content">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                        <?php
                        foreach ($edit_data as $row) {
                            
                        }
                        ?>
                        <?php echo form_open(base_url() . 'event/update/' . $row['event_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'editevent', 'target' => '_top', 'role' => 'form')); ?>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Event Name"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="event_name" id="event_name" value="<?php echo $row['event_name']; ?>"/>
                            </div>
                        </div>    
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Event Location"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="event_location" class="form-control" name="event_location" 
                                       value="<?php echo $row['event_location']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <textarea name="event_desc" class="form-control" rows="4"><?php echo $row['event_desc']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Start Date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="edit-datepicker-date" class="form-control" name="event_date" value="<?php echo date_formats($row['event_date']); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("End Date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="edit-datepicker-end-date" class="form-control" name="event_end_date" value="<?php echo date_formats($row['event_end_date']); ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Event Time"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group bootstrap-timepicker">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    <input type="text" id="event_time" class="form-control" name="event_time" 
                                           value="<?php echo date('h:i A', strtotime($row['event_date'])); ?>" readonly="" />
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Group"); ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="group">
                                    <?php
                                    $group = $this->Crud_model->get_all_group();
                                    ?>
                                    <option value="">Select</option>
                                    <?php foreach ($group as $gp) { ?>
                                        <option value="<?php echo $gp->g_id; ?>"
                                                <?php if ($gp->g_id == $row['group_id']) echo 'selected'; ?>><?php echo ucfirst($gp->group_name); ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status");?></label>
                            <div class="col-sm-8">
                                <select name="status"  class="form-control">
                                  <option value="1" <?php if($row['status'] == '1'){ echo "selected"; } ?>>Active</option>
                                    <option value="0" <?php if($row['status'] == '0'){ echo "selected"; } ?>>Inactive</option>	
                                </select>
                                <lable class="error" id="error_lable_exist" style="color:red"></lable>

                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Update"); ?></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var js_date_format = '<?php echo js_dateformat(); ?>';
            $.validator.setDefaults({
                submitHandler: function () {
                    document.getElementById("editevent").submit();
                }
            });

            $().ready(function () {
                $('#event_time').timepicker({
                    upArrowStyle: 'fa fa-angle-up',
                    downArrowStyle: 'fa fa-angle-down',
                    minuteStep: 30
                });
                $("#edit-datepicker-date").datepicker({
                    format: js_date_format, 
                    autoclose: true,
                    changeMonth: true,
                    changeYear: true,
                    startDate: new Date()
                }).on('changeDate', function (selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#edit-datepicker-end-date').datepicker('setStartDate', minDate);
                });
                $("#edit-datepicker-end-date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    changeMonth: true,
                    changeYear: true,
                    startDate: new Date()
                });
                $("#editevent").validate({
                    rules: {
                        event_name: "required",
                        event_desc: "required",
                        event_date: "required",
                        event_location: "required",
                        event_time: "required"
                    },
                    messages: {
                        event_name: "Enter Event Name",
                        event_desc: "Enter Event Description",
                        event_date: "Select Event Date",
                        event_location: "Enter event location",
                        event_time: "Enter event time"
                    }
                });
            });
        </script>

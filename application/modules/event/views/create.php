<?php $group =   $this->Crud_model->get_all_group();   ?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default"></div>
        <div class="panel-body"> 

            <div class="box-content">  

                <div class="">
                    <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                </div>                                       
                <?php echo form_open(base_url() . 'event/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'eventform', 'target' => '_top')); ?>
                <div class="padded">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Event Name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="event_name" value=""/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Event Location"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" id="event_location" class="form-control" name="event_location" value=""/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <textarea name="event_desc" class="form-control" rows="3"></textarea>									</div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Start Date"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" id="datepicker-date" class="form-control" name="event_date" value=""/>
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("End Date"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" id="datepicker-end-date" class="form-control" name="event_end_date" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Event Time"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group bootstrap-timepicker">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input type="text" id="event_time" class="form-control" name="event_time" value="" readonly="" />
                            </div>
                        </div>
                    </div>                       
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Group"); ?></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="group">
                                <option value="">Select</option>
                                <?php foreach ($group as $row) { ?>
                                    <option value="<?php echo $row->g_id; ?>"><?php echo ucfirst($row->group_name); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                        <div class="col-sm-8">
                            <select name="status"  class="form-control">                               
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>	
                            </select>
                            <lable class="error" id="error_lable_exist" style="color:red"></lable>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                        </div>
                    </div>
                </div>    
                </form>         
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        var date = '';
        var start_date = '';
        $('#event_time').timepicker({
            upArrowStyle: 'fa fa-angle-up',
            downArrowStyle: 'fa fa-angle-down',
            minuteStep: 30
        });

        $("#datepicker-date").datepicker({
            format: js_date_format,
            startDate: new Date(),
            todayHighlight: true,
            autoclose: true
        }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#datepicker-end-date').datepicker('setStartDate', minDate);
    });
     $("#datepicker-end-date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    todayHighlight: true
                });
    

//        $('#datepicker-date').on('change', function () {
//            date = new Date($(this).val());
//            start_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
//            console.log(start_date);
//
//            setTimeout(function () {
//                $("#datepicker-end-date").datepicker({
//                    format: js_date_format,
//                    autoclose: true,
//                    todayHighlight: true,
//                    startDate: start_date
//                });
//            }, 700);
//        });

        $("#eventform").validate({
            rules: {
                event_name: "required",
                event_desc: "required",
                event_date: "required",
                event_end_date: "required",
                event_location: "required",
                event_time: "required"
            },
            messages: {
                event_name: "Enter event name",
                event_desc: "Enter event description",
                event_date: "Select event date",
                event_end_date: "Select event end date",
                event_location: "Enter event location",
                event_time: "Enter event time"
            }
        });
    });
</script>

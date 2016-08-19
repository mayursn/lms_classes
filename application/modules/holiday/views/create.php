<?php
$degree = $this->db->get('degree')->result_array();
$courses = $this->db->get('course')->result_array();
$semesters = $this->db->get('semester')->result_array();
?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
          <div class="panel-body"> 
                <div class="box-content"> 
                    <div class="">
                        <span style="color:red">*<?php echo "is " . ucwords("mandatory field"); ?> </span> 
                    </div>
                    <?php echo form_open(base_url() . 'holiday/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'holidayform', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("holiday name"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="holiday_name" id="holiday_name"/>
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("start date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="holiday_startdate" id="holiday_startdate"/>

                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("end date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                  <input type="text" class="form-control" name="holiday_enddate" id="holiday_enddate"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                            <div class="col-sm-8">
                                <select name="holiday_status"  class="form-control">
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
                    </div> 
                    </form>
                </div>

            </div>
        </div>
    </div>
</div> 

<script>

    $(document).ready(function () {
        var date = '';
        var start_date = '';
        var js_format = '<?php echo js_dateformat(); ?>';
        $("#holiday_startdate").datepicker({
            format: js_format,
            startDate: new Date(),
            todayHighlight: true,
            autoclose: true
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
        $('#holiday_enddate').datepicker('setStartDate', minDate);
        });
          $("#holiday_enddate").datepicker({
                    format: js_format,
                    todayHighlight: true,
                    startDate: start_date,
                    autoclose: true,
                });

//        $('#holiday_startdate').on('change', function () {
//            date = new Date($(this).val());
//            start_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
//            console.log(start_date);
//            setTimeout(function () {
//                $("#holiday_enddate").datepicker({
//                    format: ' MM dd, yyyy',
//                    todayHighlight: true,
//                    startDate: start_date,
//                    autoclose: true,
//                });
//            }, 700);            
//        });

        $("#holidayform").validate({
            rules: {
                holiday_name: "required",
                holiday_status: "required",
                holiday_startdate: "required",
                holiday_enddate: "required",
            },
            messages: {
                holiday_name: "Enter holiday name",
                holiday_status: "Select status",
                holiday_startdate: "Select date",
                holiday_enddate: "Select date",
            }
        });


    });
</script>
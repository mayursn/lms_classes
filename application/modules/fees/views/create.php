<?php $this->load->model('courses/Course_model'); 
$this->load->model('branch/Branch_location_model'); 
$this->load->model('classes/Class_model'); 
$branch  = $this->Branch_location_model->order_by_column('branch_name');
$course =$this->Course_model->order_by_column('c_name');
$class = $this->Class_model->order_by_column('class_name');
?>
<div class="row">
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>Add Fee Structure</h4>
                        </div>-->
            <div class=panel-body>
                <form class="form-horizontal form-groups-bordered validate" id="feesstructure" 
                      action="<?php echo base_url('fees/create'); ?>" method="post" role="form">
                    <br/>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Title"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="title" name="title" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" id="branch" name="branch">
                                    <option value="">Select</option>                                     
                                    <?php foreach ($branch as $row) { ?>
                                        <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" id="course" name="course">
                                     <option value="">Select</option>                                     
                                     <?php foreach($course as $crs): ?>
                                      <option value="<?php echo $crs->course_id; ?>"><?php echo $crs->c_name; ?></option>
                                     <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" id="admission_plan" name="admission_plan">
                                     <option value="">Select</option>
                                     

                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("class"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="class" class="form-control" id="class">
                                <option value="">Select</option>
                                <?php foreach ($class as $row) { ?>
                                    <option value="<?php echo $row->class_id; ?>"><?php echo $row->class_name; ?></option>
                                <?php } ?>                                
                            </select>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Fee"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="fees" class="form-control" name="fees" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Start Date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="start_date" class="form-control datepicker" name="start_date"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("End Date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="end_date" class="form-control datepicker" name="end_date"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Expiry Date"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="expiry_date" class="form-control " name="expiry_date"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Penalty"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="penalty" class="form-control" name="penalty"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                            <div class="col-sm-8">
                                <textarea id="description" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                            </div>
                        </div>
                </form>  
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>

<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {
        $("#feesstructure").validate({
            rules: {
                branch: "required",
                course: "required",
                admission_plan: "required",
                class: "required",
                fees: {
                    required: true,
                    currency: ['$', false]
                },
                title: "required",
                start_date: "required",
                end_date: "required",
                expiry_date: "required",
                penalty: "required"
            },
            messages: {
                branch: "Please select branch",
                course: "Please select course",
                admission_plan: "Please select admission plan",
                class: "Please select class",
                fees: {
                    required: "Please Enter  Fee",
                    currency: "Please Enter Valid Amount"
                },
                title: "Please enter title",
                start_date: "Please enter start date",
                end_date: "Please enter end date",
                expiry_date: "Please enter expiry date",
                penalty: "Please enter penalty"
            }
        });
    });
</script>
<script type="text/javascript">

    
  $('#course').on('change', function () {
        var course_id = $(this).val();
        
        get_admission_plan(course_id);        
    });
    function get_admission_plan(course_id)
    {
     $('#admission_plan').find('option').remove().end();
        $('#admission_plan').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);
                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                });
            }
        });
    }
</script>

<script>
    $(document).ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        $("#start_date").datepicker({
            format: js_date_format,
            todayHighlight: true,
            autoclose: true,
            startDate: new Date(),
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
        $('#end_date').datepicker('setStartDate', minDate);
        });
        $("#end_date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    todayHighlight: true                  
                }).on('changeDate', function (selected) {
                        var minDate = new Date(selected.date.valueOf());
                    $('#expiry_date').datepicker('setStartDate', minDate);
        });
        
          
           $("#expiry_date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    todayHighlight: true
                });
        
    })
    //minDate: new Date(),

</script>
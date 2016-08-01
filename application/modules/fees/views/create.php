<?php $this->load->model('department/Degree_model'); 
$degree =$this->Degree_model->order_by_column('d_name');
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
                            <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" id="degree" name="degree">
                                    <option value="">Select</option>
                                     <option value="All">All</option>
                                    <?php foreach ($degree as $row) { ?>
                                        <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" id="course" name="course">
                                     <option value="">Select</option>
                                     <option value="All">All</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Batch"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" id="batch" name="batch">
                                     <option value="">Select</option>
                                     <option value="All">All</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" id="semester" name="semester">
                                    <option value="">Select</option>   
                                    
                                     <option value="All">All</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Fee"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="fees" class="form-control" name="fees"/>
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
                degree: "required",
                course: "required",
                semester: "required",
                batch: "required",
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
                degree: "Please select department",
                course: "Please select branch",
                semester: "Please select semester",
                batch: "Please select batch",
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

    $("#degree").change(function () {
        var degree = $(this).val();

        var dataString = "degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'fees/get_cource/'; ?>",
            data: dataString,
            success: function (response) {                
                $('#course').find('option').remove().end();
                $('#course').append('<option value>Select</option>');
                $('#course').append('<option value="All">All</option>');
                if (degree == "All")
                {
                    $("#batch").val($("#batch option:eq(1)").val());
                    $("#course").val($("#course option:eq(1)").val());
                    $("#semester").val($("#semester option:eq(1)").val());
                } else {
                    var branch = jQuery.parseJSON(response);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            }
        });
    });


$("#batch").change(function () {
        var batches = $("#batch").val();
        if (batches == 'All')
        {
            $("#semester").val($("#semester option:eq(1)").val());
        }
    });



    $("#course").change(function () {
        var course = $(this).val();
        var degree = $("#degree").val();
        var dataString = "course=" + course + "&degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'fees/get_batchs/'; ?>",
            data: dataString,
            success: function (response) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'fees/get_semesterall/'; ?>",
                    data: {'course': course},
                    success: function (response1) {
                        $('#semester').find('option').remove().end();
                        $('#semester').append('<option value>Select</option>');
                        $('#semester').append('<option value="All">All</option>');
                        if(course=="All")
                        {
                            $("#semester").val($("#semester option:eq(1)").val());
                        }
                        else{
                            var sem_value = jQuery.parseJSON(response1);
                            console.log(sem_value);
                            $.each(sem_value, function (key, value) {
                                $('#semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                            });
                        }
                         
                        
                        
                    }
                });
                $('#batch').find('option').remove().end();
                $('#batch').append('<option value>Select</option>');
                $('#batch').append('<option value="All">All</option>');
                //$("#semester").val($("#semester option:eq(1)").val());
               if (course == "All")
                {
                    $("#batch").val($("#batch option:eq(1)").val());
                    $("#semester").val($("#semester option:eq(1)").val());
                } else {

                    var batch_value = jQuery.parseJSON(response);
                    console.log(batch_value);
                    $.each(batch_value, function (key, value) {
                        $('#batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        $("#start_date").datepicker({
            format: js_date_format,
            todayHighlight: true,
            autoclose: true,
            startDate: new Date()
        });
        $('#start_date').on('change', function () {
            
            date = new Date($(this).val());
            start_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
            console.log(start_date);
            
            setTimeout(function () {
                $("#end_date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    todayHighlight: true,
                    startDate: start_date
                }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#expiry_date').datepicker('setStartDate', minDate);
        });
            }, 200);
        });
          
           $("#expiry_date").datepicker({
                    format: js_date_format,
                    autoclose: true,
                    todayHighlight: true
                });
        
    })
    //minDate: new Date(),

</script>
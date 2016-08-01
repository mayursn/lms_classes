<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title><?php echo $title; ?></h4>
                            <div class="panel-controls panel-controls-right">
                                <a class="panel-refresh" href="#"><i class="fa fa-refresh s12"></i></a>
                                <a class="toggle panel-minimize" href="#"><i class="fa fa-plus s12"></i></a>
                                <a class="panel-close" href="#"><i class="fa fa-times s12"></i></a>
                            </div>
                        </div>-->
            <div class=panel-body>
                <form class="form-horizontal form-groups-bordered validate" 
                      action="<?php echo base_url('payment/pay_online'); ?>" id="student_fees" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title">Invoice Information</div>
                                </div>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="<?php echo $student_detail->std_first_name . ' ' . $student_detail->std_last_name; ?>" name="title" disabled/>
                                        </div>
                                    </div>

                                    <div class="form-group hide">
                                        <label class="col-sm-3 control-label">Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="title"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Remarks</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="10" name="description"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Date</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <?php $date = date('d-m-Y'); ?>
                                                <input value="<?php echo date_formats($date); ?>" type="text" id="datepicker-normal" name="date" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title">Payment Information</div>
                                </div>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Semester</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="semester" name="semester">
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($semester as $row) {
                                                    if ($student_detail->semester_id < $row->s_id) {
                                                        break;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $row->s_id; ?>"><?php echo $row->s_name; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Type of Fees</label>
                                        <div class="col-sm-9">
                                            <select id="fees_structure" class="form-control" name="fees_structure">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Total Fees</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly="" id="total_fees" name="total_fees" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Due Fees</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly="" id="due_fees" name="due_fees" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Amount</label>
                                        <div class="col-sm-9">
                                            <input type="text" required="" pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,2}))?)" id="amount" class="form-control" name="amount"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Payment Method</label>
                                        <div class="col-sm-9">
                                            <select name="method" class="form-control">
                                                <option value="">Select</option>
                                                <option value="authorize.net">Authorize.net</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div
                            <div class="form-group">
                                <label class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary">Pay Online</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->


<script>
    $(document).ready(function () {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        $('#semester').on('change', function () {
            var semester_id = $(this).val();
            var course_id = '<?php echo $student_detail->course_id; ?>';
            $.ajax({
                url: '<?php echo base_url(); ?>fees/fees_structure_details_student/' + course_id + '/' + semester_id,
                type: 'get',
                success: function (content) {
                    $('#fees_structure').find('option').remove().end();
                    $('#fees_structure').append("<option value=''>Select</option>");
                    var fees = jQuery.parseJSON(content);
                    $.each(fees, function (key) {
                        $('#fees_structure').append("<option value=" + fees[key].fees_structure_id + ">" + fees[key].title + "</option>");
                    });
                }
            })
            $('#total_fees').val('');
            $('#due_fees').val('');
        });

        $('#fees_structure').on('change', function () {
            var total_fee = 0;
            var due_fee = 0;
            $('#total_fees').val('');
            $('#due_fees').val('');
            var student_id = "<?php echo $student_detail->std_id; ?>";
            var semester_id = "<?php echo $student_detail->semester_id; ?>";
            var course_id = "<?php echo $student_detail->course_id; ?>";
            var fees_structure_id = $(this).val();

            setTimeout(function () {
                $.ajax({
                    url: '<?php echo base_url(); ?>fees/student_fees_structure_details/' + fees_structure_id,
                    type: 'get',
                    success: function (content) {
                        var fees_structure = jQuery.parseJSON(content);
                        console.log(fees_structure);
                        $('#total_fees').val(fees_structure.total_fee);
                        total_fee = fees_structure.total_fee;
                    }
                });

                $.ajax({
                    url: '<?php echo base_url(); ?>fees/course_semester_paid_fee/' + fees_structure_id,
                    type: 'get',
                    success: function (content) {
                        var total_paid_amount = jQuery.parseJSON(content);
                        var due_amount = Number($('#total_fees').val());
                        if (total_paid_amount > 0) {
                            due_amount = Number($('#total_fees').val()) - total_paid_amount;
                        }
                        $('#due_fees').val(Math.abs(total_fee));
                        due_fee = due_amount;
                    }
                });
            }, 1500);

            setTimeout(function () {
                $('#amount').attr('min', Math.abs(total_fee));
                $('#amount').attr('max', Math.abs(total_fee));
            }, 2000);

        })
    })
</script>


<!-- Start validation -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/'; ?>jquery.validate.min.js"></script>
<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });
    $().ready(function () {
        $("#student_fees").validate({
            rules: {
                //title:{required: true},
                date: "required",
                semester: "required",
                fees_structure: "required",
                amount: {
                    required: true,
                    number: true,
                    //max: $('#due_fees').val()
                },
                method: "required",
            },
            messages: {
                //title: "Title is required",
                date: "Date is required",
                semester: "Semester is required",
                fees_structure: "Fees structure is required",
                amount: {
                    required: "Amount is required",
                    number: "Only enter number",
                    //max: "Enter amount which is less than or due amount"
                },
                method: "Method is required",
            }
        });
    });
</script>

<!-- End validation -->
<script type="text/javascript">
    $(window).load(function ()
    {
        var js_date_format = '<?php echo js_dateformat(); ?>';
        
        "use strict";
        $("#datepicker-normal").datepicker({
            format: js_date_format,
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            startDate : new Date(),
        });
    });
</script>

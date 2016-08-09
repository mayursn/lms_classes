<?php 
$this->load->model('branch/Branch_location_model');
$this->load->model('courses/Course_model');
$this->load->model('classes/Class_model');
$this->load->model('admission_plan/Admission_plan_model');
$branch = $this->Branch_location_model->order_by_column('branch_name');
$course = $this->Course_model->order_by_column('c_name');
$class = $this->Class_model->order_by_column('class_name');
$plan = $this->Admission_plan_model->order_by_column('admission_duration');

?>
<div class="row">
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>Add Payment</h4>
                        </div>-->
            <div class=panel-body>
                <form id="makepayment" class="form-horizontal form-groups-bordered validate" 
                      action="<?php echo base_url(); ?>payment/create" method="post" role="form">
                    <br/>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Branch<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="branch" id="branch" required="">
                                    <option value="">Select</option>
                                    <?php foreach ($branch as $row) { ?>
                                        <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Course<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="course" id="course" required="">
                                    <option  value="">Select</option>
                                    <?php  foreach($course as $crs): ?>
                                    <option value="<?php echo $crs->course_id; ?>"><?php echo $crs->c_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Admission Plan<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="admission_plan" id="admission_plan" required="">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Class<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="class" id="create-class" required="">
                                    <option value="">Select</option>                
                                    <?php foreach($class as $cl): ?>
                                    <option value="<?php echo $cl->class_id; ?>"><?php echo $cl->class_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Student <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select style="width: 100%;" class="student form-control" id="student" name="student" required="">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Fees Structure<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" id="fees_structure" name="fees_structure" required="">

                                </select>
                            </div>
                        </div>
                        <div id="main_total_fees" class="form-group" style="display: none;">
                            <label class="col-sm-4 control-label">Total Fees<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="total_fees" id="total_fees" class="form-control" readonly=""/>
                            </div>
                        </div>
                        <div id="main_total_amount" class="form-group" style="display: none;">
                            <label class="col-sm-4 control-label">Total Paid Amount</label>
                            <div class="col-sm-8">
                                <input type="text" name="total_fees_amount" id="total_fees_amount" class="form-control" readonly=""/>
                            </div>
                        </div>
                        <div id="main_due_amount" class="form-group" style="display: none;">
                            <label class="col-sm-4 control-label">Due Amount<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="due_amount" id="due_amount" class="form-control" readonly=""/>
                            </div>
                        </div>
                        <div id="fees_main" class="form-group">
                            <label class="col-sm-4 control-label">Amount<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="fees" id="fees" class="form-control" placeholder="In dollar" required=""/>
                            </div>
                        </div>
                        <div id="fees_main" class="form-group">
                            <label class="col-sm-4 control-label">Cheque Number<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="cheque_number" id="cheque_number" class="form-control" required=""/>
                            </div>
                        </div>
                        <div id="fees_main" class="form-group">
                            <label class="col-sm-4 control-label">Bank Name<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="bank_name" id="bank_name" class="form-control" required=""/>
                            </div>
                        </div>
                        <div id="fees_main" class="form-group">
                            <label class="col-sm-4 control-label">A/C Holder Name<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ac_holder_name" id="ac_holder_name" class="form-control" required=""/>
                            </div>
                        </div>
                        <div id="fees_main" class="form-group">
                            <label class="col-sm-4 control-label">Date<span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="date" id="date" class="form-control datepicker" required=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="c_description" id="c_description" rows="5" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button id="submit-form" type="submit" class="btn btn-info">Add</button>
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

<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {
         var js_date_format = '<?php echo js_dateformat(); ?>';
        $('.datepicker').datepicker({
            format: js_date_format,
            startDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });
        $("#makepayment").validate({
            rules: {
                branch:"required",
                course: "required",
                admission_plan: "required",
                class: "required",
                student: "required",
                fees: {
                    required: true,
                    number: true,
                },
                semester: "required",
                fees_structure: "required",
                cheque_number: "required",
                bank_name: "required",
                ac_holder_name: "required"
            },
            messages: {
                branch:"Please select branch",
                course: "Please select course",
                admission_plan: "Please select admission plan",
                class: "Please select class",
                student: "Please select student",
                fees: {
                    required: "Please enter fee amount"
                },
                semester: "Please select semester",
                fees_structure: "Please select fees structure",
                cheque_number: "Please enter cheque number",
                bank_name: "Please enter bank name",
                ac_holder_name: "Please enter a/c holder name"
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
      
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
    
    $("#admission_plan").change(function(){
        var admission_plan = $(this).val();
        var branch = $("#branch").val();
        var course = $("#course").val();
        var class_name = $("#create-class").val();
        
        get_fee_structure(branch,course,admission_plan,class_name);
    });
    $("#create-class").change(function(){
        var class_name = $(this).val();
        var admission_plan = $("#admission_plan").val();
        var branch = $("#branch").val();
        var course = $("#course").val();
        
        get_class_student(branch,course,admission_plan,class_name);
    });
    function get_class_student(branch,course,admission_plan,class_name)
    {
       var dataString = 'branch='+branch+"&course="+course+"&admission_plan="+admission_plan+"&class="+class_name;
       $.ajax({
           url:"<?php echo base_url(); ?>student/get_student_list",
           type:"GET",
           data:dataString,
           success:function(content){
                var students = jQuery.parseJSON(content);
                console.log(students);
                $('#student').find('option').remove();
                $('#student').append("<option value=''>Select</option>");
                $.each(students, function (key, value) {
                    $('#student').append('<option value=' + value.std_id + '>' + value.std_first_name + ' ' + value.std_last_name + '</option>');
                });
                  
           }
           
       })
    }
    
//    {
//        $.ajax({
//                url: '<?php echo base_url(); ?>student/get_class_student/' + branch + '/' + course + '/' + admission_plan+'/'+class_name,
//                type: 'get',
//                success: function (content) {
//                    var students = jQuery.parseJSON(content);
//                    $('#student').find('option').remove();
//                    $('#student').append("<option value=''>Select</option>");
//                    $.each(students, function (key) {
//                        $('#student').append("<option value=" + students[key].std_id + ">" + students[key].std_first_name +' '+students[key].std_last_name "</option>");
//                    })
//                    //console.log(fees_struture);
//                }
//            })
//    }
    
        function get_fee_structure(branch,course,admission_plan,class_name)
        {
             $.ajax({
                url: '<?php echo base_url(); ?>payment/get_fees_structure/' + branch + '/' + course + '/' + admission_plan,
                type: 'get',
                success: function (content) {
                    var fees_struture = jQuery.parseJSON(content);
                    $('#fees_structure').find('option').remove();
                    $('#fees_structure').append("<option value=''>Select</option>");
                    $.each(fees_struture, function (key) {
                        $('#fees_structure').append("<option value=" + fees_struture[key].fees_structure_id + ">" + fees_struture[key].title + "</option>");
                    })
                    //console.log(fees_struture);
                }
            })
        }
    
        $('#semester').on('change', function () {
            var semester_id = $(this).val();
            var course_id = $('#course').val();
            $.ajax({
                url: '<?php echo base_url(); ?>payment/course_semester_fees_structure/' + course_id + '/' + semester_id,
                type: 'get',
                success: function (content) {
                    var fees_struture = jQuery.parseJSON(content);
                    $('#fees_structure').find('option').remove();
                    $('#fees_structure').append("<option value=''>Select</option>");
                    $.each(fees_struture, function (key) {
                        $('#fees_structure').append("<option value=" + fees_struture[key].fees_structure_id + ">" + fees_struture[key].title + "</option>");
                    })
                    //console.log(fees_struture);
                }
            })
            $('#main_total_fees').css('display', 'none');
            $('#main_total_amount').css('display', 'none');
            $('#main_due_amount').css('display', 'none');
        });

        $('#fees_structure').on('change', function () {
            var fees_structure_id = $(this).val();
            var student_id = $('#student').val();
            fees_structure(fees_structure_id, student_id);
        });

        $('#fees_structure').on('blur', function () {
            var fees_structure_id = $(this).val();
            var student_id = $('#student').val();
            fees_structure(fees_structure_id, student_id);
        });

        $('#fees_structure').on('focus', function () {
            var fees_structure_id = $(this).val();
            var student_id = $('#student').val();
            fees_structure(fees_structure_id, student_id);
        });

        $('#student').on('change', function () {
            var student_id = $(this).val();
            var fees_structure_id = $('#fees_structure').val();
            fees_structure(fees_structure_id, student_id);
        })

        function fees_structure(fees_structure_id, student_id) {
            clear_amount();
            console.log('fee' + fees_structure_id);
            console.log(student_id);
            $.ajax({
                url: '<?php echo base_url(); ?>payment/student_paid_fees/' + fees_structure_id + '/' + student_id,
                type: 'get',
                success: function (content) {
                    var amount = jQuery.parseJSON(content);
                    $('#total_fees').val(amount.total_fees);
                    $('#total_fees_amount').val(amount.total_paid);
                    $('#due_amount').val(amount.due_amount);
                    var remaining_amount = amount.total_paid - amount.due_amount;
                    $('#fees').attr('min', '0');
                    $('#fees').attr('max', amount.due_amount);

                    if (amount.total_fees == amount.total_paid) {
                        $('#fees_main').css('display', 'none');
                        $('#submit-form').attr('disabled', '');
                    } else {
                        $('#fees_main').css('display', 'block');
                        $('#submit-form').removeAttr('disabled');
                    }
                }
            })
            $('#main_total_fees').css('display', 'block');
            $('#main_total_amount').css('display', 'block');
            $('#main_due_amount').css('display', 'block');
        }

        function clear_amount() {
            $('#total_fees').val('');
            $('#total_fees_amount').val('');
            $('#due_amount').val('');
        }
    })
</script>


<script>
    
</script>
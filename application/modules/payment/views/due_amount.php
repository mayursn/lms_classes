<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <form id="due_amount-search" method="post" action="#" class="form-groups-bordered validate">
                    <div class="form-group col-sm-2">
                            <label ><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <select class="form-control filter-rows" name="branch" id="filter-branch">
                                <option value="">Select</option>
                                <?php foreach ($branch as $rows) { ?>
                                    <option value="<?php echo $rows->branch_id; ?>"><?php echo $rows->branch_name; ?></option>                                    
                                <?php } ?>
                            </select>
                        </div>	
                        <div class="form-group col-sm-2">
                            <label ><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                            <select class="form-control filter-rows" name="course" id="filter-course" >
                                <option value="">Select</option>
                                <?php foreach($course as $row_course): ?>
                                <option  value="<?php echo $row_course->course_id; ?>"><?php echo $row_course->c_name; ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                            <select name="admission_plan" id="filter-admission_plan" class="form-control">
                                <option value="">Select</option>

                            </select>
                        </div>	                        
                        <div class="form-group col-sm-2">
                            <label><?php echo ucwords("Class"); ?><span style="color:red">*</span></label>
                            <select class="form-control filter-rows" name="class" id="filter-class" >
                                <option value="">Select</option>
                                <?php
                                $class = $this->db->get('class')->result_array();
                                foreach ($class as $c) {
                                    ?>
                                    <option value="<?php echo $c['class_id'] ?>"><?php echo $c['class_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>    
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label> <?php echo ucwords("fee structure"); ?></label>
                            <select id="search-fee-structure" name="fee_structure" data-filter="6" class="form-control">
                                <option value="">Select</option>

                            </select>
                        </div>
                    <div class="form-group col-lg-1 col-md-1 col-sm-2 col-xs-2">
                        <label>&nbsp;</label><br/>
                        <input id="search-due_amount-data" type="submit" value="Go" class="btn btn-info vd_bg-green"/>
                    </div>
                </form>

                <?php if (isset($students)) { ?>
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Roll No</th>
                                <th>Student Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Due Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->load->model('Student/Student_model');
                            $this->load->model('feerecord/Student_fees_model');
                            $counter = 1;
                            foreach ($students as $student) {
                                ?>
                                <?php
                                $paid_fees = $this->Student_fees_model->student_paid_fees($fee_structure, $student->std_id);
                                $total_paid = 0;
                                if (count($paid_fees)) {
                                    foreach ($paid_fees as $paid) {
                                        $total_paid += $paid->paid_amount;
                                    }
                                }
                                $due_amount = $fee_structure_info->total_fee - $total_paid;
                                if ($due_amount <= 0)
                                    continue;
                                ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo str_replace('-', '', $student->std_roll); ?></td>
                                    <td><?php echo ucwords($student->std_first_name . ' ' . $student->std_last_name); ?></td>
                                    <td><?php echo $student->std_mobile; ?></td>
                                    <td><?php echo $student->email; ?></td>

                                    <td><?php echo $this->data['currency'] . $due_amount; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?> 

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
        var form = $('#due_amount-search');
        $('#search-due_amount-data').on('click', function () {
            $("#due_amount-search").validate({
                rules: {
                    branch: "required",
                    course: "required",
                    admission_plan: "required",
                    class: "required",
                    fee_structure: "required"
                },
                messages: {
                    branch: "Select branch",
                    course: "Select course",
                    admission_plan: "Select admission plan",
                    class: "Select class",
                    fee_structure: "Selest fee structure"
                }
            });

            if (form.valid() == true)
            {
                $('#all-due_amount-result').hide();
                var degree = $("#search-degree").val();
                var course = $("#search-course").val();
                var batch = $("#search-batch").val();
                var semester = $("#search-semester").val();
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/due_amount_student_list/' + degree + '/'
                            + course + '/' + batch + '/' + semester,
                    type: 'get',
                    success: function (content) {
                        $("#due_amount-filter-result").html(content);
                        $('#all-due_amount-result').hide();
                        $('#due_amount-data-tables').DataTable({"language": {"emptyTable": "No data available"}});
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
     
      $('#filter-course').on('change', function () {       
        var course_id = $(this).val();
        
        get_admission_plan(course_id);
        
    });
    function get_admission_plan(course_id)
    {
     $('#filter-admission_plan').find('option').remove().end();
        $('#filter-admission_plan').append('<option value="">Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#filter-admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                });
            }
        });
    }
    $("#filter-class").change(function(){
        fee_structure();
    });
     function fee_structure() {
            $('#search-fee-structure').find('option').remove().end();
            $('#search-fee-structure').append('<option value="">Select</option>');
            var branch = $('#filter-branch').val();
            var course = $('#filter-course').val();
            var admission_plan = $('#filter-admission_plan').val();
            var class_name = $('#filter-class').val();
            $.ajax({
                url: '<?php echo base_url(); ?>payment/student_fee_structure/' + branch + '/' + course + '/' +
                        admission_plan + '/' + class_name,
                type: 'get',
                success: function (content) {
                    var fee_structure = jQuery.parseJSON(content);
                    $.each(fee_structure, function (key, value) {
                        $('#search-fee-structure').append('<option value=' + value.fees_structure_id + '>' + value.title + '</option>');
                    });
                }
            });
        }
    })
</script>
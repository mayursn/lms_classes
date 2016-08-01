<!-- Start .row -->
<?php
$create = create_permission($permission, 'Payment');
$read = read_permission($permission, 'Payment');
$update = update_permisssion($permission, 'Payment');
$delete = delete_permission($permission, 'Payment');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/payment_create');" data-toggle="modal"><i class="fa fa-plus"></i> Make Payment</a>
                <?php } ?>
                <div class="col-md-12">
                    <?php if($create || $read || $update || $delete){ ?>
                    <form id="make_payment-search" method="post" action="#" class="form-groups-bordered validate">
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label><?php echo ucwords("department"); ?></label>
                            <select class="form-control" id="search-degree"name="degree">
                                <option value="">Select</option>
                                <?php foreach ($degree as $row) { ?>
                                    <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label><?php echo ucwords("Branch"); ?></label>
                            <select id="search-course" name="course" data-filter="4" class="form-control">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label><?php echo ucwords("Batch"); ?></label>
                            <select id="search-batch" name="batch" data-filter="5" class="form-control">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label> <?php echo ucwords("Semester"); ?></label>
                            <select id="search-semester" name="semester" data-filter="6" class="form-control">
                                <option value="">Select</option>

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
                            <input id="search-make_payment-data" type="button" value="Go" name="make_payment_search" class="btn btn-primary"/>
                        </div>
                    </form>
                    <?php } ?>
                </div>

                <div class="col-md-12" id="all-student-payment-records">
                    <?php if($create || $read || $update || $delete){ ?>
                    <table id="fee-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Roll No</th>
                                <th>Student Name</th>
                                <th>Department</th>
                                <th>Branch</th>
                                <th>Batch</th>
                                <th>Semester</th>
                                <th>Paid Amount</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $counter = 1; ?>
                            <?php foreach ($student_fees as $row) { ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo str_replace('-', '', $row->std_roll); ?></td>
                                    <td><?php echo $row->std_first_name . ' ' . $row->std_last_name; ?></td>
                                    <td><?php echo $row->d_name; ?></td>
                                    <td><?php echo $row->c_name; ?></td>
                                    <td><?php echo $row->b_name; ?></td>
                                    <td><?php echo $row->s_name; ?></td>
                                    <td><?php echo $this->data['currency'] . $row->paid_amount; ?></td>
                                    <td><?php echo date_formats($row->paid_created_at); ?></td>

                                    <td class="menu-action">

                                        <a href="<?php echo base_url('feerecord/invoice/' . $row->student_fees_id); ?>" target="_blank"><span class="label label-primary mr6 mb6">
                                                <i class="fa fa-desktop"></i>View</span></a>
                                        <?php } ?>

                                        <a target="_blank" href="<?php echo base_url('feerecord/invoice_print/' . $row->student_fees_id); ?>"><span class="label label-danger mr6 mb6">
                                                <i class="fa fa-download"></i>Download</span></a>

                                    </td>

                                </tr>
                    
                        </tbody>
                    </table>
                            <?php } ?>														
                </div>                
                
                <div class="col-md-12" id="filtered-student-payment-records"></div>
                
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
        $('#fee-datatable-list').DataTable({"language": { "emptyTable": "No data available" }});
    });
</script>


<script>
    $(document).ready(function () {
        var form = $('#make_payment-search');
        $('#search-make_payment-data').on('click', function () {
            $("#make_payment-search").validate({
                rules: {
                    degree: "required",
                    course: "required",
                    batch: "required",
                    semester: "required",
                    fee_structure: "required"
                },
                messages: {
                    degree: "Select department",
                    course: "Select branch",
                    batch: "Select batch",
                    semester: "Select semester",
                    fee_structure: "Selest fee structure"
                }
            });

            if (form.valid() == true)
            {
                $('#all-make_payment-result').hide();
                var degree = $("#search-degree").val();
                var course = $("#search-course").val();
                var batch = $("#search-batch").val();
                var semester = $("#search-semester").val();
                var fee_structure = $('#search-fee-structure').val();
                $.ajax({
                    url: '<?php echo base_url(); ?>payment/make_payment_student_list/' + degree + '/'
                            + course + '/' + batch + '/' + semester + '/' + fee_structure,
                    type: 'get',
                    success: function (content) {
                        $("#filtered-student-payment-records").html(content);
                        $('#all-student-payment-records').hide();
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        //course by degree
        var degree_id = '<?php echo $department; ?>';
        $('#search-degree').val(degree_id);
        course_from_degree(degree_id);

        var course_id = '<?php echo $branch; ?>';
        setTimeout(function () {
            $('#search-course').val(course_id)
        }, 500);

        setTimeout(function () {
            batch_from_degree_and_course(degree_id, course_id);
            get_semester_from_branch(course_id);
        }, 500);

        setTimeout(function () {
            var batch_id = '<?php echo $batch; ?>';
            $('#search-batch').val(batch_id);
            $('#search-semester').val('<?php echo $semester_list; ?>');
        }, 700);

        setTimeout(function () {
            var fee_id = '<?php echo $fee_structure; ?>';
            $('#search-fee-structure').val(fee_id);
            fee_structure(degree_id, course_id);
        }, 700);

        setTimeout(function () {
            $('#search-fee-structure').val('<?php echo $fee_structure; ?>');
        }, 1000);

        $('#search-degree').on('change', function () {
            course_id = $('#search-course').val();
            degree_id = $(this).val();
            //remove all present element
            $('#search-course').find('option').remove().end();
            $('#search-course').append('<option value="">Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + degree_id,
                type: 'get',
                success: function (content) {
                    var course = jQuery.parseJSON(content);
                    $.each(course, function (key, value) {
                        $('#search-course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    })
                }
            })
            batch_from_degree_and_course(degree_id, course_id);
        });
        //batch from course and degree
        $('#search-course').on('change', function () {
            degree_id = $('#search-degree').val();
            course_id = $(this).val();
            batch_from_degree_and_course(degree_id, course_id);
            get_semester_from_branch(course_id);
        });

        $('#search-semester').on('change', function () {
            var degree_id = $('#search-degree').val();
            var course_id = $('#search-course').val();
            fee_structure(degree_id, course_id);
        });

        function fee_structure(degree_id, course_id) {
            $('#search-fee-structure').find('option').remove().end();
            $('#search-fee-structure').append('<option value="">Select</option>');
            var batch_id = $('#search-batch').val();
            var semester_id = $('#search-semester').val();
            $.ajax({
                url: '<?php echo base_url(); ?>payment/student_fee_structure/' + degree_id + '/' + course_id + '/' +
                        batch_id + '/' + semester_id,
                type: 'get',
                success: function (content) {
                    var fee_structure = jQuery.parseJSON(content);
                    $.each(fee_structure, function (key, value) {
                        $('#search-fee-structure').append('<option value=' + value.fees_structure_id + '>' + value.title + '</option>');
                    });
                }
            });
        }

        function course_from_degree(degree_id) {
            $('#search-course').find('option').remove().end();
            $('#search-course').append('<option value="">Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + degree_id,
                type: 'get',
                success: function (content) {
                    var course = jQuery.parseJSON(content);
                    $.each(course, function (key, value) {
                        $('#search-course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    })
                }
            })
        }

        //find batch from degree and course
        function batch_from_degree_and_course(degree_id, course_id) {
            //remove all element from batch
            $('#search-batch').find('option').remove().end();
            $('#search-batch').append('<option value="">Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>batch/department_branch_batch/' + degree_id + '/' + course_id,
                type: 'get',
                success: function (content) {
                    var batch = jQuery.parseJSON(content);
                    console.log(batch);
                    $.each(batch, function (key, value) {
                        $('#search-batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    })
                }
            })
        }

        //get semester from brach
        function get_semester_from_branch(branch_id) {
            $('#search-semester').find('option').remove().end();
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch_id,
                type: 'get',
                success: function (content) {
                    $('#search-semester').append('<option value="">Select</option>');
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#search-semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    })
                }
            })
        }

    })
</script>
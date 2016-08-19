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
                            <input id="search-make_payment-data" type="button" value="Go" name="make_payment_search" class="btn btn-primary"/>
                        </div>
                    </form>
                    <?php } ?>
                </div>

            
                    <?php if($create || $read || $update || $delete){ ?>
                <div class="col-md-12" id="filtered-student-payment-records">
                    <table id="fee-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Roll No</th>
                                <th>Student Name</th>
                                <th>Branch</th>
                                <th>Course</th>
                                <th>Admission Plan</th>
                                <th>Class</th>
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
                                    <td><?php echo $row->branch_name; ?></td>
                                    <td><?php echo $row->c_name; ?></td>
                                    <td><?php echo $row->admission_duration; ?></td>
                                    <td><?php echo $row->class_name; ?></td>
                                    <td><?php echo $this->data['currency'] . $row->paid_amount; ?></td>
                                    <td><?php echo date_formats($row->paid_created_at); ?></td>

                                    <td class="menu-action">

                                        <a href="<?php echo base_url('feerecord/invoice/' . $row->student_fees_id); ?>" target="_blank"><span class="label label-primary mr6 mb6">
                                                <i class="fa fa-desktop"></i>View</span></a>
                                        

                                        <a target="_blank" href="<?php echo base_url('feerecord/invoice_print/' . $row->student_fees_id); ?>"><span class="label label-danger mr6 mb6">
                                                <i class="fa fa-download"></i>Download</span></a>

                                    </td>

                                </tr>
                    <?php } ?>
                        </tbody>
                    </table>
                     </div>
                    <?php } ?>														
                               
                
               
                
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
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
                $('#all-make_payment-result').hide();
                var branch = $("#filter-branch").val();
                var course = $("#filter-course").val();
                var admission_plan = $("#filter-admission_plan").val();
                var class_name = $("#filter-class").val();
                var fee_structure = $('#search-fee-structure').val();
                $.ajax({
                    url: '<?php echo base_url(); ?>payment/make_payment_student_list/' + branch + '/'
                            + course + '/' + admission_plan + '/' + class_name + '/' + fee_structure,
                    type: 'get',
                    success: function (content) {
                        $("#filtered-student-payment-records").html(content);
                        $('#all-student-payment-records').hide();
                    }
                });
            }
        });
    });
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
</script>
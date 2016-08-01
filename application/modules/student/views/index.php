<?php
$create = create_permission($permission, 'Student');    
$read = read_permission($permission, 'Student');
$update = update_permisssion($permission, 'Student');
$delete = delete_permission($permission, 'Student');

?>

<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                 <?php if ($create) { ?>
                     <a class="links"  onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/student_create');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Student </a>
                <?php } ?>
                     
                <div class="row filter-row">
                    <form id="frmstudentlist" name="frmfilterlist" action="#" enctype="multipart/form-data" class="form-vertical form-groups-bordered validate">
                        <div class="form-group col-sm-2">
                            <label ><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                            <select class="form-control filter-rows" name="filterdegree" id="filterdegree">
                                <option value="">Select</option>
                                <?php foreach ($department as $row) { ?>
                                    <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>                                    
                                <?php } ?>
                            </select>
                        </div>	
                        <div class="form-group col-sm-2">
                            <label ><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <select class="form-control filter-rows" name="filtercourse" id="filtercourse" >
                                <option value="">Select</option>

                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label><?php echo ucwords("Batch"); ?><span style="color:red">*</span></label>
                            <select name="filterbatch" id="filterbatch" class="form-control">
                                <option value="">Select</option>

                            </select>
                        </div>	
                        <div class="form-group col-sm-2">
                            <label><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                            <select class="form-control filter-rows" name="filtersemester" id="filtersemester" >
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label><?php echo ucwords("Class"); ?><span style="color:red">*</span></label>
                            <select class="form-control filter-rows" name="filterclass" id="filterclass" >
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
                        <div class="form-group col-sm-2">
                            <label>&nbsp;</label><br/>
                            <input id="btnsubmit" type="button" value="Go" class="btn btn-info"/>
                        </div>
                    </form>
                </div>
                <div class="table-responsive" >
                    <div id="filterdata" >

                    </div>

                </div>
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

        var form = $("#frmstudentlist");
        $("form#frmstudentlist #btnsubmit").click(function () {
            $("form#frmstudentlist").validate({
                rules: {
                    filterdegree: "required",
                    filtercourse: "required",
                    filterbatch: "required",
                    filtersemester: "required",
                    filterclass: "required",
                },
                messages: {
                    filterdegree: "Select department",
                    filtercourse: "Select branch",
                    filterbatch: "Select batch",
                    filtersemester: "Select semester",
                    filterclass: "Select class",
                }
            });
            if (form.valid() == true)
            {
                filtered_student();

            }
        });
        $('#filterdegree').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });
        $('#filtercourse').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#filterdegree').val();
            batch_form_department_branch(department, branch_id);
            semester_from_branch(branch_id);
        });
        
        function department_branch(department_id) {
            $('#filtercourse').find('option').remove().end();
            $('#filtercourse').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#filtercourse').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        }

        function batch_form_department_branch(department, branch) {
            $('#filterbatch').find('option').remove().end();
            $('#filterbatch').append('<option value>Select</option>');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>batch/department_branch_batch/" + department + '/' + branch,
                success: function (response) {
                    var branch = jQuery.parseJSON(response);
                    $.each(branch, function (key, value) {
                        $('#filterbatch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            });
        }

        function semester_from_branch(branch) {
            $('#filtersemester').find('option').remove().end();
            $('#filtersemester').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
                type: 'GET',
                success: function (content) {
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#filtersemester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    });
                }
            });
        }

        function filtered_student() {
            var degree = $("form#frmstudentlist #filterdegree").val();
            var course = $("form#frmstudentlist #filtercourse").val();
            var batch = $("form#frmstudentlist #filterbatch").val();
            var sem = $("form#frmstudentlist #filtersemester").val();
            var divclass = $("form#frmstudentlist #filterclass").val();
            $.ajax({
                url: '<?php echo base_url(); ?>student/filtered_student',
                type: 'POST',
                data: {'batch': batch, 'sem': sem, 'course': course, 'degree': degree, 'divclass': divclass},
                success: function (content) {
                    $("#filterdata").html(content);
                    // $("#dtbl").hide();
                    $('#datatable-list').DataTable({
                        aoColumnDefs: [
                            {
                                bSortable: false,
                                aTargets: [-1]
                            }
                        ]
                    });
                }
            });
        }
    });
</script>
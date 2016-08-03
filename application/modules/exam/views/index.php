<?php
$create = create_permission($permission, 'Exam');
$read = read_permission($permission, 'Exam');
$update = update_permisssion($permission, 'Exam');
$delete = delete_permission($permission, 'Exam');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/exam_create');" data-toggle="modal"><i class="fa fa-plus"></i> Exam</a>
                <?php } ?>
                <?php if($create || $read || $update || $delete){ ?>
                <div class="row filter-row">
                    <form id="due_amount-search" action="#" class="form-groups-bordered validate">
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label><?php echo ucwords("Branch"); ?></label>
                            <select class="form-control" id="search-branch"name="branch">
                                <option value="">Select</option>
                                <?php foreach ($branch as $row) { ?>
                                    <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name.' - '.$row->branch_location; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label><?php echo ucwords("course"); ?></label>
                            <select id="search-course" name="course" data-filter="4" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($course as $crs): ?>
                                <option value="<?php echo $crs->course_id; ?>"><?php echo $crs->c_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label><?php echo ucwords("Admission plan"); ?></label>
                            <select id="search-admission_plan" name="admission_plan" data-filter="5" class="form-control">
                                <option value="">Select</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-1 col-md-1 col-sm-2 col-xs-2">
                            <label>&nbsp;</label><br/>
                            <input id="search-due_amount-data" type="button" value="Go" class="btn btn-info vd_bg-green"/>
                        </div>
                    </form>

                </div>

                <div id="all-due_amount-result">
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>

                        <th>No</th>
                        <th>Exam Name</th>
                        <th>Branch</th>
                        <th width="14%">Course</th>
                        <th>Admission Plan</th>                        
                        <th width="10%">Date</th>
                        <th>Exam Mode</th>
                        <?php if($update || $delete){ ?>
                        <th>Action</th>
                        <?php } ?>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($exams as $row) {
                                $cenlist = array();
                                ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $row->em_name; ?></td>
                                    <td><?php echo $row->branch_name; ?></td>
                                    <td><?php echo $row->c_name; ?></td>
                                    <td><?php echo $row->admission_duration; ?></td>                                    
                                    <td><?php echo date_formats($row->em_date); ?></td>
                                    <td>
                                    <?php
                                    if($row->exam_mode=="mcq")
                                    {
                                        ?>
                                    <a href="#"><span class="label label-primary mr6 mb6">
                                            <i class="fa fa-pencil"></i>MCQ</span></a>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                    <a href="#"><span class="label label-primary mr6 mb6">
                                            <i class="fa fa-pencil"></i>Written</span></a>
                                    <?php
                                    }
                                    ?>
                                </td>
                                    <?php if($update || $delete){ ?>
                                    <td class="menu-action">
                                        <?php if($update){ ?>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/exam_edit/<?php echo $row->em_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                        <?php } ?>
                                        <?php if($delete){ ?>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>exam/delete/<?php echo $row->em_id; ?>');" data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                        <?php } ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
                <div id="due_amount-filter-result"></div>

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
                   
                },
                messages: {
                    branch: "Select branch",
                    course: "Select course",
                    admission_plan: "Select admission plan",
                   
                }
            });

            if (form.valid() == true)
            {
                $('#all-due_amount-result').hide();
                var branch = $("#search-branch").val();
                var course = $("#search-course").val();
                var admission_plan = $("#search-admission_plan").val();
                
                $.ajax({
                    url: '<?php echo base_url(); ?>exam/get_exam_filter/' + branch + '/'
                            + course + '/' + admission_plan,
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
        $('#search-course').on('change', function () {
        var course_id = $(this).val();
        
        get_admission_plan(course_id);        
    });
    function get_admission_plan(course_id)
    {
     $('#search-admission_plan').find('option').remove().end();
        $('#search-admission_plan').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#search-admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                });
            }
        });
    }
    })
</script>
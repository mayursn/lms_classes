<!-- Start .row -->
<?php
$create = create_permission($permission, 'Study_Resource');
$read = read_permission($permission, 'Study_Resource');
$update = update_permisssion($permission, 'Study_Resource');
$delete = delete_permission($permission, 'Study_Resource');
$this->load->model('branch/Branch_location_model');
$this->load->model('courses/Course_model');
$this->load->model('admission_plan/Admission_plan_model');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php if ($create) { ?>
                    <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/studyresource_create');" data-toggle="modal"><i class="fa fa-plus"></i> Study Resource</a>
                <?php } ?>
                <div class="row filter-row">
                    <?php if ($create || $read || $update || $delete) { ?>
                        <form action="#" method="post" id="searchform">
                            <div class="form-group col-sm-3 validating">
                                <label>Branch</label>
                                <select id="search-branch" name="branch" class="form-control">
                                    <option value="">Select Branch</option>
                                    <?php $branch =  $this->Branch_location_model->order_by_column('branch_name'); ?>
                                    <?php foreach ($branch as $row) { ?>
                                        <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-3 validating">
                                <label>Course</label>
                                <select id="search-course" name="course" class="form-control">
                                    <option value="">Select Course</option>
                                    <?php  foreach ($course as $row_crs): ?>
                                    <option value="<?php echo $row_crs->course_id; ?>"><?php echo $row_crs->c_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-3 validating">
                                <label>Admission Plan</label>
                                <select id="search-admission_plan" name="admission_plan" class="form-control">
                                    <option value="">Select Admission Plan</option>
                                
                                </select>
                            </div>                            
                            <div class="form-group col-sm-1">
                                <label>&nbsp;</label><br/>
                                <button type="submit" id="btnsubmit" class="submit btn btn-info vd_bg-green">Go</button>
                            </div>

                        </form>
                    <?php } ?>
                </div>
                <div id="getresponse">
                    <?php if ($create || $read || $update || $delete) { ?>
                        <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                            <thead>
                                <tr>
                                    <th>No</th>											
                                    <th>Title</th>											                                    
                                    <th>Branch</th>
                                    <th>Course</th>											
                                    <th>Admission Plan</th>											                                                                                               
                                    <th>File</th>
				    <th>Status</th>
                                    <?php if ($update || $delete) { ?>
                                        <th>Action</th>											
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                
                                foreach ($studyresource as $row):
                                    ?>
                                    <tr>
                                        <td></td>	
                                        <td><?php echo $row->study_title; ?></td>	
                                        <td>
                                            <?php
                                           $branch = $this->Branch_location_model->get($row->branch_id);
                                           echo $branch->branch_name;
                                            ?>
                                        </td>	
                                        <td>
                                            <?php
                                            $course_array = $this->Course_model->get($row->course_id);
                                            echo $course_array->c_name;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                           $plan = $this->Admission_plan_model->get($row->admission_plan_id);
                                           echo $plan->admission_duration;
                                            ?>
                                        </td>	                                  

                                        <td id="downloadedfile"><a href="<?php echo base_url() . 'uploads/project_file/' . $row->study_filename; ?>" download=""  title="download"><i class="fa fa-download"></i></a></td>	
					<td>
                                            <?php if ($row->study_status == '1') { ?>
                                                <span class="label label-primary mr6 mb6" >Active</span>
                                            <?php } else { ?>	
                                                <span class="label label-danger mr6 mb6" >InActive</span>
                                            <?php } ?>
                                        </td>
                                        <?php if ($update || $delete) { ?>
                                            <td class="menu-action">
                                                <?php if ($update) { ?>
                                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/studyresource_edit/<?php echo $row->study_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                                <?php } ?>
                                                <?php if ($delete) { ?>
                                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>studyresource/delete/<?php echo $row->study_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php endforeach; ?>																			
                            </tbody>
                        </table>

                    <?php } ?>
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

<script type="text/javascript">
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
        $("#searchform #btnsubmit").click(function () {
            var branch = $("#search-branch").val();
            var course = $("#search-course").val();
            var admission_plan = $("#search-admission_plan").val();            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>studyresource/getstudyresource/",
                data: {'branch': branch, 'course': course, 'admission_plan': admission_plan},
                success: function (response)
                {
                    $("#getresponse").html(response);
                }


            });
            return false;
        });
       
    });
    $(document).ready(function () {
        $('#studyresource-tables').dataTable({"language": {"emptyTable": "No data available"}});

    });
</script>
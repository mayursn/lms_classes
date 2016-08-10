<!-- Start .row -->
<?php
$create = create_permission($permission, 'Syllabus');
$read = read_permission($permission, 'Syllabus');
$update = update_permisssion($permission, 'Syllabus');
$delete = delete_permission($permission, 'Syllabus');
 $this->load->model('branch/Branch_location_model');
 $this->load->model('admission_plan/Admission_plan_model');
$this->load->model('courses/Course_model');
$branches = $this->Branch_location_model->order_by_column('branch_name');
$courses = $this->Course_model->order_by_column('c_name');
?>
<div class=row>                      

    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">                 
            <div class="panel-body">
                <?php if($create){ ?>
                <a class="links"  onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/syllabus_create/');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Syllabus</a>
                <?php } ?>
                <?php if( $create || $update || $delete){ ?>
               <div class="row filter-row">
                <form action="#" method="post" id="searchform">
                    <div class="form-group col-sm-3 validating">
                        <label>Branch</label>
                        
                        <select id="search-branch" name="branch" class="form-control">
                            <option value="">Select</option>
                            <?php foreach ($branches as $row) { ?>
                                <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3 validating">
                        <label>Course</label>
                        <select id="search-course" name="course" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($courses as $course_row): ?>
                            <option value="<?php echo $course_row->course_id; ?>"><?php echo $course_row->c_name; ?></option>                                
                            <?php endforeach; ?>
                        </select>
                    </div>                   
                    <div class="form-group col-sm-3 validating">
                        <label> Admission Plan</label>
                        <select id="search-admission_plan" name="admission_plan" class="form-control">
                            <option value="">Select</option>
                            <?php foreach ($admission_plan as $plan) { ?>
                                <option value="<?php echo $row->admission_plan_id; ?>"
                                        ><?php echo $row->admission_duration; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                   <div class="form-group col-sm-2">
                        <label>&nbsp;</label><br/>
                        <input id="btnsubmit" type="button" value="Go" class="btn btn-info"/>
                    </div>
                </form>
               </div>
                <?php } ?>
                <?php if($read || $create || $update || $delete){ ?>
                <div id="getresponse">
                    
                    <table class="table table-striped table-bordered table-responsive" cellspacing=0 width=100% id="datatable-list">
                        <thead>
                            <tr>
                                <th>No</th>												
                                <th><?php echo ucwords("Syllabus Title"); ?></th>                                
                                <th><?php echo ucwords("Branch"); ?></th>												                                                
                                <th><?php echo ucwords("Course"); ?></th>                                
                                <th><?php echo ucwords("Admission Plan"); ?></th>
                                <th><?php echo ucwords("Description"); ?></th>            
                                <th><?php echo ucwords("File"); ?></th>            
                                  <?php if($update || $delete){ ?>
                                <th><?php echo ucwords("Action"); ?></th>											
                                  <?php } ?>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           
                            $count = 1;
                            foreach (@$syllabus as $row):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>	

                                    <td><?php echo $row->syllabus_title; ?></td>	
                                    <td> <?php $branch =  $this->Branch_location_model->get($row->branch_id); 
                                    echo $branch->branch_name;
                                    ?></td>
                                    <td>
                                        <?php
                                        foreach ($course as $crs) {
                                            if ($crs->course_id == $row->syllabus_course) {
                                                echo $crs->c_name;
                                            }
                                        }
                                        ?>
                                    </td>

                                    <td> <?php $plan =  $this->Admission_plan_model->get($row->admission_plan_id); 
                                    if($plan)
                                    {
                                        echo $plan->admission_duration;
                                    }
                                    ?></td>	
                                    <td><?php echo wordwrap($row->syllabus_desc, 30, "<br>\n"); ?></td>
                                    <td id="downloadedfile"><a href="<?php echo base_url() . 'uploads/syllabus/' . $row->syllabus_filename; ?>" download="" title="download"><i class="fa fa-download"></i></a></td>	                                                  
                                    <?php if($update || $delete){ ?>
                                    <td class="menu-action">
                                        <?php if($update){ ?>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/syllabus_edit/<?php echo $row->syllabus_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                        <?php } ?>
                                        <?php if($delete){ ?>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>syllabus/delete/<?php echo $row->syllabus_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>	
                                        <?php  } ?>
                                    </td>	
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>						
                        </tbody>
                    </table>
                    <?php } ?>
                 </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
    </div>
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
<script type="text/javascript">
    $(document).ready(function () {
        "use strict";
        $('#data-tabless').DataTable({
            "language": { "emptyTable": "No data available" },
            aoColumnDefs: [
                {
                    bSortable: false,
                    aTargets: [-1]
                }
            ]
       });


        $("#searchform #btnsubmit").click(function () {
            var branch = $("#search-branch").val();
            var course = $("#search-course").val();
            var admission_plan = $("#search-admission_plan").val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>syllabus/getsyllabus/",
                data: {'branch': branch, 'course': course, "admission_plan": admission_plan},
                success: function (response)
                {
                    $("#getresponse").html(response);
                }


            });
            return false;
        });

  $('#search-course').on('change', function () {       
        var course_id = $(this).val();
        
        get_admission_plan(course_id);
        
    });
    function get_admission_plan(course_id)
    {
     $('#search-admission_plan').find('option').remove().end();
        $('#search-admission_plan').append('<option value="">Select</option>');
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


    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        "use strict";
        $('#assignment-list').dataTable({
            "order": [[7, "desc"]],
            "dom": "<'row'<'col-sm-6'><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'l><'col-sm-4'i><'col-sm-4'p>>",
        });
        $('.filter-rows').on('change', function () {
            var filter_id = $(this).attr('data-filter');
            filter_column(filter_id);
        });

        function filter_column(filter_id) {
            $('#assignment-list').DataTable().column(filter_id).search(
                    $('#filter' + filter_id).val()
                    ).draw();
        }
    });
</script>

<style>
    #assignment-list_filter{
        margin-top: -50px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        "use strict";
        $('#sub-tables').dataTable({
            "order": [[7, "desc"]],
            "dom": "<'row'<'col-sm-6'><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'l><'col-sm-4'i><'col-sm-4'p>>",
                    "language": { "emptyTable": "No data available" } 
        });
        $('.sfilter-rows').on('change', function () {
            var filter_id = $(this).attr('data-filter');
            filter_column(filter_id);
        });

        function filter_column(filter_id) {
            $('#sub-tables').DataTable().column(filter_id).search(
                    $('#sfilter' + filter_id).val()
                    ).draw();
        }
    });
</script>

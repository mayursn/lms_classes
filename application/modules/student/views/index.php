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
                            <label ><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                            <select class="form-control filter-rows" name="branch" id="filter-branch">
                                <option value="">Select</option>
                                <?php foreach ($branch as $rows) { ?>
                                    <option value="<?php echo $rows->branch_id; ?>"><?php echo $rows->branch_name.' - '.$rows->branch_location; ?></option>                                    
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
                        <div class="form-group col-sm-2">
                            <label>&nbsp;</label><br/>
                            <input id="btnsubmit" type="button" value="Go" class="btn btn-info"/>
                        </div>
                    </form>
                </div>
                <div class="table-responsive" >
                    <div id="filterdata" >

                   
 <?php if ($create || $read || $update || $delete) { ?>
<table id="datatable-list2" class="table table-striped table-bordered table-responsive text-center" cellspacing=0 width=100%>
    <thead>
        <tr>
            <th>No</th>	
            <th>Image</th>
            <th>Roll No</th>
            <th>Student Name</th>												
            <th>Email</th>												
            <th>Mobile</th>	
            <th>Address</th>
            <th>Status</th>
            <th>Action</th>	
        </tr>
    </thead>

    <tbody>
        <?php foreach ($student as $row): ?>
            <tr>
                <td></td>
                <td>
                    <?php if ($row->profile_pic != '') { ?>
                        <img src="<?= base_url() ?>uploads/system_image/<?php echo $row->profile_pic; ?>" height="70px" width="70px"/>
                        <?php
                    } else {
                        ?>
                        <img src="<?= base_url('assets/img/avatar.jpg') ?>" height="70px" width="70px"/>
                    <?php  
                    }
                    ?>
                </td>		
                <td><?php echo $row->std_roll; ?></td>
                <td><?php echo $row->first_name . " " . $row->last_name; ?></td>					
                <td><?php echo $row->email; ?></td>											
                <td><?php echo $row->mobile; ?></td>                
                <td><?php echo $row->address; ?></td>
                <td>
                    <?php if ($row->is_active == '1') { ?>
                        <span class="label label-primary mr6 mb6" >Active</span>
                    <?php } else { ?>	
                        <span class="label label-danger mr6 mb6" >InActive</span>
                    <?php } ?>
                </td>
                <td class="menu-action">
                    <?php 
                           if($update) { ?>
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/student_edit/<?php echo $row->user_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                   <?php } ?>
                    
                    <a href="<?php echo base_url()?>student/student_profile/<?php echo $row->std_id; ?>" data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Student Profile</span></a>
                </td>											
            </tr>
        <?php endforeach; ?>																			
    </tbody>
</table>
                         </div>
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
<script>
    $(document).ready(function () {

        var form = $("#frmstudentlist");
        $("form#frmstudentlist #btnsubmit").click(function () {
            $("form#frmstudentlist").validate({
                rules: {
                    branch: "required",
                    course: "required",
                    admission_plan: "required",
                    class: "required",                    
                },
                messages: {
                    branch: "Select branch",
                    course: "Select branch",
                    admission_plan: "Select batch",
                    class: "Select semester",
                    
                }
            });
            if (form.valid() == true)
            {
                filtered_student();

            }
        });
         function filtered_student() {
           
            var branch = $("form#frmstudentlist #filter-branch").val();
            var course = $("form#frmstudentlist #filter-course").val();
            var admission_plan = $("form#frmstudentlist #filter-admission_plan").val();
            var classes = $("form#frmstudentlist #filter-class").val();
            
            $.ajax({
                url: '<?php echo base_url(); ?>student/filtered_student',
                type: 'POST',
                data: {'branch': branch, 'course': course, 'admission_plan': admission_plan, 'class': classes},
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

       
    });
</script>

<script>
    

   

</script>
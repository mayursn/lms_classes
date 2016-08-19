<!-- Start .row -->
<!-- Start .row -->
<?php
$create = create_permission($permission, 'Fee');
$read = read_permission($permission, 'Fee');
$update = update_permisssion($permission, 'Fee');
$delete = delete_permission($permission, 'Fee');
$this->load->model('courses/Course_model'); 
$this->load->model('branch/Branch_location_model'); 
$this->load->model('classes/Class_model'); 
$this->load->model('admission_plan/Admission_plan_model'); 
$branch  = $this->Branch_location_model->order_by_column('branch_name');
$course =$this->Course_model->order_by_column('c_name');
$class = $this->Class_model->order_by_column('class_name');
$plan = $this->Admission_plan_model->order_by_column('admission_duration');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
       
            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links"   onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/fees_create');" data-toggle="modal"><i class="fa fa-plus"></i> Fee Structure</a>				
                <?php } ?>
                <div class="row filter-row">
               <?php if($create || $update || $delete && $read ){ ?>     
                <form id="fee-structure-search" action="#" class="form-groups-bordered validate">
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("Branch"); ?></label>
                        <select class="form-control" id="search-branch"name="branch">
                            <option value="">Select</option>                            
                            <?php foreach ($branch as $row) { ?>
                                <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("Course"); ?></label>
                        <select id="search-course" name="course" data-filter="4" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($course as $crs ): ?>
                            <option value="<?php echo $crs->course_id; ?>"><?php echo $crs->c_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("Admission Plan"); ?></label>
                        <select id="search-admission_plan" name="admission_plan" data-filter="5" class="form-control">
                            <option value="">Select</option>
                        
                        </select>
                    </div>                                
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label> <?php echo ucwords("Class"); ?></label>
                        <select id="search-class" name="class" data-filter="6" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($class as $cl):?>
                            <option value="<?php echo $cl->class_id; ?>"><?php echo $cl->class_name; ?></option>   
                        <?php    endforeach; ?>

                        </select>
                    </div>
                    <div class="form-group col-lg-1 col-md-1 col-sm-2 col-xs-2">
                        <label>&nbsp;</label><br/>
                        <input id="search-fee-structure-data" type="button" value="Go" class="btn btn-info vd_bg-green"/>
                    </div>
                </form>
               <?php  } ?>
                </div>
                <?php if($create || $read || $update || $delete){ ?>
                <div id="main-fee-structure">
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Branch</th>
                                <th>Course</th>                                
                                <th>Admission Plan</th>
                                <th>Class</th>
                                <th>Fee</th>
                                <?php if($update || $delete){ ?>
                                <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($fees_structure as $row) { ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $row->title; ?></td>
                                    <td><?php 
                                   echo $row->branch_name;
                                   
                                   
                                   
                                    ?></td>
                                    <td><?php 
                                    
                                   
                                        echo $row->c_name;
                                   
                                    ?></td>
                                    <td><?php
                                   
                                    echo $row->admission_duration;
                                    
                                    ?></td>
                                    <td><?php 
                                    $class_array = $this->Class_model->get($row->class_id);
                                    echo $class_array->class_name;                                    
                                    ?></td>
                                    <td><?php echo $this->data['currency'] . $row->total_fee; ?></td>
                                    <?php if($update || $delete){ ?>
                                    <td class="menu-action">
                                        <?php if($update){ ?>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/fees_edit/<?php echo $row->fees_structure_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                        <?php } ?>
                                        <?php if($delete){ ?>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>fees/delete/<?php echo $row->fees_structure_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                        <?php } ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>														
                        </tbody>
                    </table>
                <?php } ?>
                </div>                

                <div id="filtered-fee-structure"></div>
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

        var form = $('#fee-structure-search');

        $('#search-fee-structure-data').on('click', function () {
            
            $("#fee-structure-search").validate({
                rules: {
                    branch: "required",
                    course: "required",
                    admission_plan: "required",
                    class: "required"
                },
                messages: {
                    branch: "Select branch",
                    course: "Select course",
                    admission_plan: "Select admission plan",
                    class: "Select class"
                }
            });

            if (form.valid() == true)
            {
                $('#all-fee-structure').hide();
                var branch = $("#search-branch").val();
                var course = $("#search-course").val();
                var admission_plan = $("#search-admission_plan").val();
                var class_name = $("#search-class").val();
                var exam = $('#search-exam').val();
                $.ajax({
                    url: '<?php echo base_url(); ?>fees/fee_structure_filter/' + branch + '/'
                            + course + '/' + admission_plan + '/' + class_name,
                    type: 'get',
                    success: function (content) {
                        $("#filtered-fee-structure").html(content);
                        $('#main-fee-structure').hide();
                        $('#fee-structure-data-tables').DataTable({"language": { "emptyTable": "No data available" }});
                    }
                });
            }
        });
    });
</script>

<script>
    
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
    </script>
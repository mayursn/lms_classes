<!-- Start .row -->
<!-- Start .row -->
<?php
$create = create_permission($permission, 'Fee');
$read = read_permission($permission, 'Fee');
$update = update_permisssion($permission, 'Fee');
$delete = delete_permission($permission, 'Fee');
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
               <?php if($create || $read || $update || $delete){ ?>     
                <form id="fee-structure-search" action="#" class="form-groups-bordered validate">
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("department"); ?></label>
                        <select class="form-control" id="search-degree"name="degree">
                            <option value="">Select</option>
                            <option value="All">All</option>
                            <?php foreach ($degree as $row) { ?>
                                <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("Branch"); ?></label>
                        <select id="search-course" name="course" data-filter="4" class="form-control">
                            <option value="">Select</option>
                            <option value="All">All</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label><?php echo ucwords("Batch"); ?></label>
                        <select id="search-batch" name="batch" data-filter="5" class="form-control">
                            <option value="">Select</option>
                            <option value="All">All</option>
                        </select>
                    </div>                                
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label> <?php echo ucwords("Semester"); ?></label>
                        <select id="search-semester" name="semester" data-filter="6" class="form-control">
                            <option value="">Select</option>
                            <option value="All">All</option>

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
                                <th>Department</th>
                                <th>Branch</th>
                                <th>Batch</th>
                                <th>Semester</th>
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
                                    if($row->degree_id!="All")
                                    {
                                    $degree = $this->Degree_model->get($row->degree_id);
                                            echo $degree->d_name;
                                    }
                                    else{
                                        echo "All";
                                    }
                                    ?></td>
                                    <td><?php 
                                    if($row->course_id!="All")
                                    {
                                   $branch =  $this->Course_model->get($row->course_id);
                                    echo $branch->c_name; 
                                    }else{
                                        echo "All";
                                    }
                                    ?></td>
                                    <td><?php
                                    if($row->batch_id!="All")
                                    {
                                    $batch = $this->Batch_model->get($row->batch_id);
                                    echo $batch->b_name; 
                                    }else{
                                        echo "All";
                                    }
                                    ?></td>
                                    <td><?php 
                                    if($row->sem_id!="All")
                                    {
                                    $semester = $this->Semester_model->get($row->sem_id);
                                    
                                    echo $semester->s_name;
                                    }  else {
                                        echo "All";
                                    }
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
                    degree: "required",
                    course: "required",
                    batch: "required",
                    semester: "required"
                },
                messages: {
                    degree: "Select department",
                    course: "Select branch",
                    batch: "Select batch",
                    semester: "Select semester"
                }
            });

            if (form.valid() == true)
            {
                $('#all-fee-structure').hide();
                var degree = $("#search-degree").val();
                var course = $("#search-course").val();
                var batch = $("#search-batch").val();
                var semester = $("#search-semester").val();
                var exam = $('#search-exam').val();
                $.ajax({
                    url: '<?php echo base_url(); ?>fees/fee_structure_filter/' + degree + '/'
                            + course + '/' + batch + '/' + semester,
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
    
    
    $("#search-degree").change(function () {
        var degree = $(this).val();

        var dataString = "degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'digital/get_cource/'; ?>",
            data: dataString,
            success: function (response) {                
                $('#search-course').find('option').remove().end();
                $('#search-course').append('<option value>Select</option>');
                $('#search-course').append('<option value="All">All</option>');
                if (degree == "All")
                {
                    $("#search-batch").val($("#search-batch option:eq(1)").val());
                    $("#search-course").val($("#search-course option:eq(1)").val());
                    $("#search-semester").val($("#search-semester option:eq(1)").val());
                } else {
                    var branch = jQuery.parseJSON(response);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#search-course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            }
        });
    });


$("#search-batch").change(function () {
        var batches = $("#search-batch").val();
        if (batches == 'All')
        {
            $("#search-semester").val($("#search-semester option:eq(1)").val());
        }
    });



    $("#search-course").change(function () {
        var course = $(this).val();
        var degree = $("#search-degree").val();
        var dataString = "course=" + course + "&degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'digital/get_batchs/'; ?>",
            data: dataString,
            success: function (response) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'digital/get_semesterall/'; ?>",
                    data: {'course': course},
                    success: function (response1) {
                        $('#search-semester').find('option').remove().end();
                        $('#search-semester').append('<option value>Select</option>');
                        $('#search-semester').append('<option value="All">All</option>');
                        if(course=="All")
                        {
                            $("#search-semester").val($("#search-semester option:eq(1)").val());
                        }
                        else{
                            var sem_value = jQuery.parseJSON(response1);
                            console.log(sem_value);
                            $.each(sem_value, function (key, value) {
                                $('#search-semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                            });
                        }
                         
                        
                        
                    }
                });
                $('#search-batch').find('option').remove().end();
                $('#search-batch').append('<option value>Select</option>');
                $('#search-batch').append('<option value="All">All</option>');
                //$("#semester").val($("#semester option:eq(1)").val());
               if (course == "All")
                {
                    $("#search-batch").val($("#search-batch option:eq(1)").val());
                    $("#search-semester").val($("#search-semester option:eq(1)").val());
                } else {

                    var batch_value = jQuery.parseJSON(response);
                    console.log(batch_value);
                    $.each(batch_value, function (key, value) {
                        $('#search-batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            }
        });
    });

    
    </script>
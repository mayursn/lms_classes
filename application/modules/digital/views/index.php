<!-- Start .row -->
<?php
$create = create_permission($permission, 'Library');
$read = read_permission($permission, 'Library');
$update = update_permisssion($permission, 'Library');
$delete = delete_permission($permission, 'Library');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php if ($create) { ?>
                <a class="links"  onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/digital_create/');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Library</a>
                <?php } ?>
                <?php if ($create || $read || $update || $delete) { ?>
                <div class="row filter-row">
                <form action="#" method="post" id="searchform">
                    <div class="form-group col-sm-3 validating">
                        <label><?php echo ucwords("department"); ?></label>
                        <select id="courses" name="degree" class="form-control">
                            <option value="">Select department</option>
                            <option value="All">All</option>

                            <?php foreach ($degree as $row) { ?>
                                <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3 validating">
                        <label>Branch</label>
                        <select id="branches" name="course" class="form-control">
                            <option value="">Select Branch</option>
                            <option value="All">All</option>

                        </select>
                    </div>
                    <div class="form-group col-sm-3 validating">
                        <label>Batch</label>
                        <select id="batches" name="batch" class="form-control">
                            <option value="">Select Batch</option>
                            <option value="All">All</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-2 validating">
                        <label>Select Semester</label>
                        <select id="semesters" name="semester" class="form-control">
                            <option value="">Select Semester</option>
                            <option value="All">All</option>

                            <?php foreach ($semester as $row) { ?>
                                <option value="<?php echo $row->s_id; ?>"
                                        ><?php echo $row->s_name; ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-1">                                    
                        <label>&nbsp;</label><br/>                                
                        <button type="submit" id="btnsubmit" class="submit btn btn-info vd_bg-green">Go</button>                                    
                    </div>
                </form>
                </div>
                <?php } ?>
                <div id="getresponse">
                    <?php if ($create || $read || $update || $delete) { ?>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>											
                            <th>Library Name</th>											
                            <th>Department</th>											
                            <th>Branch</th>											
                            <th>Batch</th>											
                            <th>Semester</th>											
                            <th>File</th>
                            <th>Status</th>
                            <?php if ( $update || $delete) { ?>
                            <th>Action</th>	
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($library as $row):
                            ?>
                            <tr>
                                <td></td>	
                                <td><?php echo $row->lm_title; ?></td>	
                                <td>
                                    <?php
                                    if ($row->lm_degree == "All") {
                                        echo "All";
                                    } else {
                                        foreach ($degree as $deg) {

                                            if ($deg->d_id == $row->lm_degree) {
                                                echo $deg->d_name;
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row->lm_course == "All") {
                                        echo "All";
                                    } else {
                                        foreach ($course as $crs) {

                                            if ($crs->course_id == $row->lm_course) {
                                                echo $crs->c_name;
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row->lm_batch == "All") {
                                        echo "All";
                                    } else {
                                        foreach ($batch as $bch) {
                                            if ($bch->b_id == $row->lm_batch) {
                                                echo $bch->b_name;
                                            }
                                        }
                                    }
                                    ?>
                                </td>	
                                <td>
                                    <?php
                                    if ($row->lm_semester == "All") {
                                        echo "All";
                                    } else {
                                        foreach ($semester as $sem) {
                                            if ($sem->s_id == $row->lm_semester) {
                                                echo $sem->s_name;
                                            }
                                        }
                                    }
                                    ?>

                                </td>	
                                <td id="downloadedfile"><a href="<?php echo $row->lm_url; ?>" download="" target="_blank" title="download"><i class="fa fa-download"></i></a></td>	
                                <td>
                                    <?php if ($row->lm_status == '1') { ?>
                                        <span class="label label-primary mr6 mb6" >Active</span>
                                    <?php } else { ?>	
                                        <span class="label label-danger mr6 mb6" >InActive</span>
                                    <?php } ?>
                                </td>
                                <?php if($update || $delete){ ?>
                                <td class="menu-action">
                                    <?php if ($update) { ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/digital_edit/<?php echo $row->lm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                    <?php if ($delete) { ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>digital/delete/<?php echo $row->lm_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
    
   $("#searchform #btnsubmit").click(function(){
           var degree =  $("#courses").val();
           var course =  $("#branches").val();
           var batch =  $("#batches").val();
            var semester = $("#semesters").val();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url(); ?>digital/getlibrary/",
                data:{'degree':degree,'course':course,'batch':batch,"semester":semester},
                success:function(response)
                {
                    $("#getresponse").html(response);
                }
                
                
            });
             return false;
         });
        $("#courses").change(function(){
                var degree = $(this).val();
                
                var dataString = "degree="+degree;
                $.ajax({
                    type:"POST",
                    url:"<?php echo base_url().'digital/get_cource_all/'; ?>",
                    data:dataString,                   
                    success:function(response){ 
                        $('#branches').find('option').remove().end();
                        $('#branches').append('<option value>Select</option>');
                         $('#branches').append('<option value="All">All</option>');
                        if(degree=='All')
                        {                             
                          //  $("#branches").html(response);
                             $("#batches").val($("#batches option:eq(1)").val());
                             $("#branches").val($("#branches option:eq(1)").val());
                             $("#semesters").val($("#semesters option:eq(1)").val());
                            
                        }
                        else{
                                var branch = jQuery.parseJSON(response);                            
                                console.log(branch);
                                $.each(branch, function (key, value) {
                                    $('#branches').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                                });
                                              
                        }
                    }
                });
        });
        $("#batches").change(function(){
            var batches = $("#batches").val();
            if(batches=='All')
            {
                $("#semesters").val($("#semesters option:eq(1)").val());
            }
        });
         $("#branches").change(function(){
                //var course = $(this).val();
                // var degree = $("#degree").val();
                var degree = $("#courses").val();
                var course = $("#branches").val();
                var dataString = "course="+course+"&degree="+degree;
                $.ajax({
                    type:"POST",
                    url:"<?php echo base_url().'digital/get_batchs_all/'; ?>",
                    data:dataString,                   
                    success:function(response){
                          $('#batches').find('option').remove().end();
                        $('#batches').append('<option value>Select</option>');
                         $('#batches').append('<option value="All">All</option>');
                         if(course=='All')
                        {                           
                             //$("#batches").html(response);
                             $("#batches").val($("#batches option:eq(1)").val());                            
                             $("#semesters").val($("#semesters option:eq(1)").val());
                           
                        }
                        else{
                          var batch = jQuery.parseJSON(response);                            
                                console.log(batch);
                                $.each(batch, function (key, value) {
                                    $('#batches').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                                });                      
                        }
                        
                    }
                });
        });

        $(document).ready(function () {
            "use strict";
            $('#library-data').dataTable({"language": { "emptyTable": "No data available" }});
        });
    </script>
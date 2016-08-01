<?php
$create = create_permission($permission, 'Subject');
$read = read_permission($permission, 'Subject');
$update = update_permisssion($permission, 'Subject');
$delete = delete_permission($permission, 'Subject');
?>
<!-- Middle Content Start -->    
<!-- Start .row -->
<div class=row>                      

    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
            <div class="panel-body">
                <?php if ($create) { ?>
                <a class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_create/');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Subject</a>
                 <?php } ?>
                <div class="row filter-row">
                <form id="frmsearch" name="frmsearch" action="#" enctype="multipart/form-data" class="form-vertical form-groups-bordered validate">
                    <div class="form-group col-sm-4">
                        <label ><?php echo ucwords("department"); ?></label>
                        <select class="form-control filter-rows" name="filterdegree" id="filterdegree" >
                            <option value="">Select department</option>
                            <?php
                            $datadegree = $this->db->get_where('degree', array('d_status' => 1))->result();
                            foreach ($datadegree as $rowdegree) {
                                ?>
                                <option value="<?= $rowdegree->d_id ?>"><?= $rowdegree->d_name ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label ><?php echo ucwords("Branch"); ?></label>
                        <select class="form-control filter-rows" name="filtercourse" id="filtercourse" >
                            <option value="">Select Branch</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>&nbsp;</label><br/>
                        <input id="btnsubmit" type="button" value="Go" class="btn btn-info"/>
                    </div>
                </form>
                </div>
                <div id="getresponse">
                    
                <?php if ($create || $read || $update || $delete) { ?>
                <table class="table table-striped table-responsive table-bordered" id="datatable-list" >
                    <thead>
                        <tr>
                            <th>No</th>											
                            <th><?php echo ucwords("Subject Name"); ?></th>											
                            <th><?php echo ucwords("Subject Code"); ?></th>	
                             <?php if ($update || $delete) { ?>
                                    <th>Actions</th>
                                <?php } ?> 										
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($subject as $row):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>	
                                <td><?php echo $row->subject_name; ?></td>												
                                <td><?php echo $row->subject_code; ?></td>						                                             
                                <td class="menu-action">
                                      <?php 
                                            if($update) { ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_edit/<?php echo $row->sm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                            
                                <?php
                                if($delete) { ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>subject/delete/<?php echo $row->sm_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                   <?php } ?>   
                                    <a href="<?php echo base_url(); ?>subject/subject_detail/<?php echo $row->sm_id; ?>" data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6">Subject Detail</span></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>						
                    </tbody>
                 </table>
                     <?php } ?>
                </div>
            </div>
        </div>
        <!----TABLE LISTING ENDS--->

    </div>
</div>
</div></div>

<script>
$(document).ready(function(){
   
   $("#frmsearch #btnsubmit").click(function(){           
           var degree =  $("#filterdegree").val();
           var course =  $("#filtercourse").val();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url(); ?>admin/getsubject/",
                data:{'degree':degree,'course':course},
                success:function(response)
                {
                    $("#getresponse").html(response);
                    
                }
            });
             return false;
         });
   
});

 $("#filterdegree").change(function () {
        var degree = $(this).val();

        var dataString = "degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'admin/get_course/'; ?>",
            data: dataString,
            success: function (response) {
                $("#filtercourse").html(response);
            }
        });
    });
</script>
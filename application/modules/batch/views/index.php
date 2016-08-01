<?php
$create = create_permission($permission, 'Batch');
$read = read_permission($permission, 'Batch');
$update = update_permisssion($permission, 'Batch');
$delete = delete_permission($permission, 'Batch');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php if($create){ ?>
                     <a href="#" class="links"   onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/batch_create');" data-toggle="modal"><i class="fa fa-plus"></i> Batch</a>
                <?php } 
                
                if($read || $create || $update || $delete){ ?>
                     
                <table id="datatable-list" class="table table-striped table-bordered table-responsive batch-details" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Batch</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Status</th>
                             <?php if($update || $delete){ ?>
                                    <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($batches as $row):
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $row['b_name']; ?></td>    
                               <td hidden> <?php
                                    $explodedegree = explode(',', $row['degree_id']);
                                    foreach ($degree as $deg) {
                                        if (in_array($deg['d_id'], $explodedegree)) {
                                            echo "<span>" . $deg['d_name'] . "</span>";
                                        }
                                    }
                                    ?></td>
                                <td> <?php
                                    $count=0;
                                    $explodedegree = explode(',', $row['degree_id']);
                                    foreach ($degree as $deg) {
                                        if (in_array($deg['d_id'], $explodedegree)) {
                                             $count++;
                                             if($count<3)
                                             {
                                                echo "<span>" . $deg['d_name'] . "</span>";
                                             }
                                        }
                                    }
                                    if($count>2)
                                    {
                                        echo "<a href='#' onclick="."showAjaxModal('".base_url()."modal/popup/batch_detail/".$row['b_id']."/department');".">read more</a>";
                                    }
                                    ?></td>
                                <td hidden>                                                    
                                    <?php
                                    $explodecourse = explode(',', $row['course_id']);
                                    foreach ($course as $crs) {
                                        if (in_array($crs->course_id, $explodecourse)) {
                                            echo "<span>" . $crs->c_name . "</span>";
                                        }
                                    }
                                    ?>
                                </td>
                                 <td>                                                    
                                    <?php
                                    $count1=0;
                                    $explodecourse = explode(',', $row['course_id']);
                                    foreach ($course as $crs) {
                                        if (in_array($crs->course_id, $explodecourse)) {
                                            $count1++;
                                            if($count1<3)
                                            {
                                                 echo "<span>" . $crs->c_name . "</span>";
                                            }
                                        }
                                    }
                                    if($count1>2)
                                    {
                                       echo "<a href='#' onclick="."showAjaxModal('".base_url()."modal/popup/batch_detail/".$row['b_id']."/branch');".">read more</a>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($row['b_status'] == '1') { ?>
                                        <span>Active</span>
                                    <?php } else { ?>	
                                        <span>InActive</span>
                                    <?php } ?>
                                </td>
                                <?php if($update || $delete){ ?>
                                <td class="menu-action">
                                    <?php if($update){ ?>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/batch_edit/<?php echo $row['b_id'];?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                     <?php } 
                                     
                                     if($delete){ ?>
                                         <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>batch/delete/<?php echo $row['b_id']; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->

<style>
    .table td, .table th {
    text-align: justify;
}
</style>
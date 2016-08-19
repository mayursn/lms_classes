<?php 

$create = create_permission($permission, 'Forum_Comments');
$read = read_permission($permission, 'Forum_Comments');
$update = update_permisssion($permission, 'Forum_Comments');
$delete = delete_permission($permission, 'Forum_Comments');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class=" panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->           
            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/comments_create/<?php echo $param; ?>');" data-toggle="modal"><i class="fa fa-plus"></i> Forum Comment</a>
                <?php } ?>
                <?php if($create || $read || $update || $delete){ ?>

                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Forum Comments</th>
                            <th>User Roll</th>
                            <th>Comment By</th>
                            <th>Duration</th>
                            <th>File</th>
                            <th>Status</th>
                            <?php if($update || $delete){ ?>
                            <th>Action</th>              
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($forum_comment as $row):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row->forum_comments; ?></td>                         


                                <td><?php echo $row->user_role; ?></td> 
                                <td><?php echo roleuserdatatopic($row->user_role, $row->user_role_id); ?></td>                                                                             
                                <td><?php
                                    $date = date_duration($row->created_date);
                                    if ($date == "") {
                                        echo "Now";
                                    } else {
                                        echo $date;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if (!empty($row->topic_file)) { ?>
                                        <a href="<?php echo base_url() . 'uploads/forum_file/' . $row->topic_file; ?>" download=""><i class="fa fa-download"></i></a>
                                    <?php } ?>

                                </td>
                                <td>
                                    <?php if ($row->forum_comment_status == '1') { ?>
                                        <span class="label label-primary mr6 mb6" >Active</span>
                                    <?php } else { ?>	
                                        <span class="label label-danger mr6 mb6" >InActive</span>
                                    <?php } ?>
                                </td>                               
                                <?php if($update || $delete){ ?>
                                <td class="menu-action">                                                            
                                    <?php if($update){ ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/comments_edit/<?php echo $row->forum_comment_id; ?>/<?php echo $row->forum_topic_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                    <?php if($delete){ ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>comments/delete/<?php echo $row->forum_comment_id; ?>/<?php echo $row->forum_topic_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
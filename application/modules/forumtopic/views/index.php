<!-- Start .row -->
<?php
$create = create_permission($permission, 'Forum_Topics');
$read = read_permission($permission, 'Forum_Topics');
$update = update_permisssion($permission, 'Forum_Topics');
$delete = delete_permission($permission, 'Forum_Topics');


$create_comment = create_permission($permission, 'Forum_Comments');
$read_comment = read_permission($permission, 'Forum_Comments');
$update_comment = update_permisssion($permission, 'Forum_Comments');
$delete_comment = delete_permission($permission, 'Forum_Comments');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/forumtopic_create');" data-toggle="modal"><i class="fa fa-plus"></i> Forum Topic</a>
                <?php } ?>
                <?php if($create || $read || $update || $delete){ ?>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Forum Topics Title</th>
                            <th>User Role</th>
                            <th>Started By</th>
                            <th>Status</th>
                            <th>Date</th>                        
                            <th>File</th>                            
                            <?php if($create_comment || $read_comment || $update_comment || $delete_comment){ ?>
                            <th>View Comments</th>                            
                            <?php } ?>
                            <?php if($create_comment) {?>
                            <th>Add Comment</th>  
                            <?php } ?>
                            <?php if( $update || $delete){ ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($forum_topic as $row):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row->forum_topic_title; ?></td>
                                <td><?php echo $row->user_role; ?></td> 
                                <td><?php echo roleuserdatatopic($row->user_role, $row->user_role_id); ?></td>                         
                                <td>
                                    <?php if ($row->forum_topic_status == '1') { ?>
                                        <span>Active</span>
                                    <?php } else { ?>	
                                        <span>InActive</span>
                                    <?php } ?>

                                </td>
                                <td><?php echo date_formats($row->created_date); ?></td>
                                <td>
                                    <?php if(!empty($row->topic_file)) {?>
                                    <a href="<?php echo base_url().'uploads/forum_file/'.$row->topic_file; ?>" download=""><i class="fa fa-download"></i></a>
                                    <?php } ?>
                                    
                                </td>
                                <?php if($create_comment || $read_comment || $update_comment || $delete_comment){ ?>
                                <td><a href="<?php echo base_url() . 'comments/viewcomments/' . $row->forum_topic_id; ?>"  data-toggle="tooltip" data-placement="top" class="icon_link"><i class="fa fa-file-o"></i></a>                                   
                                    <span class="notification2"><?php echo countcommenttopic($row->forum_topic_id); ?></span>
                                </td>
                                <?php } ?>
                                <?php if($create_comment) {?>
                                <td>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/comments_create/<?php echo $row->forum_topic_id; ?>');" data-toggle="modal">
                                    <span class="label label-primary mr6 mb6"><i aria-hidden="true" class="fa fa-plus"></i>Add</span></a></td>
                                <?php } ?>
                                <?php if($update || $delete){ ?>
                                <td>
                                <?php if( $update){ ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/forumtopic_edit/<?php echo $row->forum_topic_id; ?>');"  data-toggle="tooltip" data-placement="middle"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                <?php }
                                if( $delete){ ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>forumtopic/delete/<?php echo $row->forum_topic_id; ?>');"  data-toggle="tooltip" data-placement="middle"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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

<!-- Start .row -->
<?php
$create = create_permission($permission, 'CMS_Page');
$read = read_permission($permission, 'CMS_Page');
$update = update_permisssion($permission, 'CMS_Page');
$delete = delete_permission($permission, 'CMS_Page');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links"   onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/cms_create');" data-toggle="modal"><i class="fa fa-plus"></i> CMS Page</a>
                <?php } ?>
                <?php if($create || $read || $update || $delete){ ?>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Page Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <?php if($update || $delete){ ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cms as $row): ?>
                            <tr>
                                <td></td>
                                <td><?php echo $row->c_title; ?></td>
                                <td><?php echo $row->c_slug; ?></td>
                                <td>
                                    <?php if ($row->c_status == '1') { ?>
                                        <span>Active</span>
                                    <?php } else { ?>	
                                        <span>InActive</span>
                                    <?php } ?>
                                </td>
                               <?php if($update || $delete){ ?>
                                <td class="menu-action">
                                    <?php if($update){ ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/cms_edit/<?php echo $row->c_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                    <?php if($delete){ ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>cms/delete/<?php echo $row->c_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
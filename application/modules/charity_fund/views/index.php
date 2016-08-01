<!-- Start .row -->
<?php
$create = create_permission($permission, 'Charity_Fund');
$read = read_permission($permission, 'Charity_Fund');
$update = update_permisssion($permission, 'Charity_Fund');
$delete = delete_permission($permission, 'Charity_Fund');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">

            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links"   onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/charity_fund_create');" data-toggle="modal"><i class="fa fa-plus"></i> Charity Fund</a>
                <?php } ?>
                <?php if($create || $read || $delete || $update){ ?>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Donation</th>
                            <th>Description</th>
                            <?php if($update || $delete){ ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($charity_fund as $row) { ?>
                            <tr>
                                <td></td>
                                <td><?php echo $row->donor_name; ?></td>
                                <td><?php echo $row->donor_mobile; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td><?php echo system_info('currency') . $row->amount; ?></td>
                                <td><?php echo $row->description; ?></td>
                                <?php if($update || $delete){ ?>
                                <td class="menu-action">
                                    <?php if($update){ ?>
                                    <?php //if($row->donation_type!="authorize"){ ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/charity_fund_edit/<?php echo $row->charity_fund_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php //} ?>
                                    <?php } ?>
                                    <?php if($delete){ ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>charity_fund/delete/<?php echo $row->charity_fund_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
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
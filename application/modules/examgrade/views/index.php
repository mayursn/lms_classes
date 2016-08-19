<!-- Start .row -->
<?php
$create = create_permission($permission, 'Exam_Grade');
$read = read_permission($permission, 'Exam_Grade');
$update = update_permisssion($permission, 'Exam_Grade');
$delete = delete_permission($permission, 'Exam_Grade');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title><?php echo $title; ?></h4>
                            <div class="panel-controls panel-controls-right">
                                <a class="panel-refresh" href="#"><i class="fa fa-refresh s12"></i></a>
                                <a class="toggle panel-minimize" href="#"><i class="fa fa-plus s12"></i></a>
                                <a class="panel-close" href="#"><i class="fa fa-times s12"></i></a>
                            </div>
                        </div>-->
            <div class=panel-body>
                <?php if($create){ ?>
                <a href="#" class="links"   onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/examgrade_create');" data-toggle="modal"><i class="fa fa-plus"></i> Exam Grade</a>
                <?php } ?>
                <?php if($create || $read || $update || $delete){ ?>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Grade</th>
                            <th>Percentage From</th>
                            <th>Percentage To</th>
                            <th>Description</th>
                            <?php if($update || $delete){ ?>
                            <th>Act1ion</th>
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($grade as $row): ?>
                            <tr>
                                <td></td>
                                <td><?php echo $row->grade_name; ?></td>
                                <td><?php echo $row->from_marks; ?></td>     
                                <td><?php echo $row->to_marks; ?></td>
                                <td><?php echo $row->comment; ?></td>
                                <?php if($update || $delete){ ?>
                                <td class="menu-action">
                                    <?php if($update){ ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/examgrade_edit/<?php echo $row->grade_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <?php } ?>
                                    <?php if($delete){ ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>examgrade/delete/<?php echo $row->grade_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
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
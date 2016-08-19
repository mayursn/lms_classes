<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">       
            <div class=panel-body>
                <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Exam Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //$exam_listing = sort($exam_listing);
                        foreach ($exam_listing as $exam) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $exam->em_name; ?></td>
                                <td><?php echo date_formats($exam->em_date); ?></td>
                                <td><?php echo date_formats($exam->em_end_time); ?></td>
                                <td>
                                    <a href="<?php echo base_url('exam/exam_schedule/' . $exam->em_id); ?>"><span class="label label-primary mr6 mb6">
                                            <i class="fa fa-pencil"></i>Schedule</span></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
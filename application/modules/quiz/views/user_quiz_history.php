
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>

                <table id="quiz-history-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>                            
                            <th>Total Attempts</th>
                            <th>Best Score</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($quiz_history as $row) { ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo $row->title; ?></td>
                                <td><?php echo $row->description; ?></td>
                                <td><?php echo datetime_formats($row->created_at); ?></td>
                                <td><?php echo $row->TotalAttempts; ?></td>
                                <td><?php echo $row->BestResult; ?>/<?php echo $row->total_marks; ?></td>                            
                                <td>
                                    <a target="_blank" href="<?php echo base_url(); ?>quiz/view-history/<?php echo $row->quiz_id; ?>/<?php echo $row->user_id; ?>">
                                        <span class="label label-primary mr6 mb6">
                                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                            View
                                        </span>
                                    </a>
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

<script>
    $(document).ready(function () {
        $('#quiz-datatable-list').DataTable({});
    })
</script>
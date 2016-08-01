<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <table id="report" class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Class Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; 
                          $this->load->model('student/Student_model');
                        ?>
                        <?php foreach ($report as $row) { ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row->date_taken)); ?></td>
                                <td>
                                    <?php echo date('h:i A', strtotime($row->Start)) . ' - ' . date('h:i A', strtotime($row->End)); ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row->is_present)
                                        echo 'P';
                                    else
                                        echo 'A';
                                    ?>
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
        $('#report').DataTable({});
    });
</script>
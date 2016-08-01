<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Exam Name</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Marks</th>
                                    <th>Passing Marks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($exam_listing as $exam) { ?>
                                <tr>
                                    <td><?php echo $exam->em_id; ?></td>
                                    <td><?php echo $exam->em_name; ?></td>
                                    <td><?php echo $exam->exam_type_name; ?></td>
                                    <td><?php echo date_formats($exam->em_start_time); ?></td>
                                    <td><?php echo date_formats($exam->em_end_time); ?></td>
                                    <td><?php echo $exam->total_marks; ?></td>
                                    <td><?php echo $exam->passing_mark; ?></td>
                                    <td>
                                        <a title="view" href="<?php echo base_url('student/exam_marks/' . $exam->em_id); ?>">
                                            Exam Marks
                                        </a>
                                        &nbsp;<a href="<?php echo base_url('marks/download_statement_marks/' . $exam->em_id) ?>" title="download report">
                                           Download
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
            </div>
        </div>

    </div>
</div>
</div>
</div>
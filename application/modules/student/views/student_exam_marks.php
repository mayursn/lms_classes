
 <?php if (count($student_marks)) { ?>
        <div class="box box-primary">    
            <div class="box-body">
                <div class="box box-warning box-solid">
                    <div class="box-body">
                        <div class="box box-info box-solid">
                            <div class="box-body no-padding table-responsive">
                                <table class="table table-bordered table-striped" id="data-table">
                                    <tbody>
                                        <tr>
                                            <th>SI NO.</th>
                                            <th>Subject Code</th>
                                            <th>Subject Name</th>
                                            <th>Total Marks</th>
                                            <th>Passing Marks</th>
                                            <th>Obtained Marks</th>
                                            <th>Grade</th>
                                            <th>Results</th>

                                        </tr>
                                        <?php
                                        $counter = 1;
                                        $total_marks = 0;
                                        $obtained_marks = 0;
                                        $is_failed = FALSE;
                                        foreach ($student_marks as $row) {
                                            $is_number = is_numeric($row->mark_obtained);
                                            $current_marks = 0;
                                            ?>
                                            <tr>
                                                <td><?php echo $counter++; ?></td>
                                                <td><?php echo $row->subject_code; ?></td>
                                                <td><?php echo $row->subject_name; ?></td>
                                                <td><?php echo $exam_details->total_marks; ?></td>
                                                <?php $total_marks += $exam_details->total_marks; ?>
                                                <td><?php echo $exam_details->passing_mark; ?></td>
                                                <td><?php echo $current_marks += $row->mark_obtained; ?></td>
                                                <?php if ($row->mark_obtained < $exam_details->passing_mark) $is_failed = TRUE; ?>
                                                <?php $obtained_marks += $row->mark_obtained; ?>
                                                <?php
                                                $percentage = ($row->mark_obtained * 100) / $exam_details->total_marks;
                                                ?>
                                                <td>
                                                    <?php
                                                    $grade = $percentage;
                                                    $grade = (int) (100 * $row->mark_obtained) / $exam_details->total_marks;
                                                    $grade_data = $this->db->select()
                                                            ->from('grade')
                                                            ->where('from_marks <= ', $grade)
                                                            ->order_by('from_marks', 'DESC')
                                                            ->limit(1)
                                                            ->get()
                                                            ->row();
                                                    $is_pass = TRUE;

                                                    if ($row->mark_obtained < $exam_details->passing_mark) {
                                                        echo 'F';
                                                        $is_pass = FALSE;
                                                    } else {
                                                        echo $grade_data->grade_name;
                                                        $is_pass = TRUE;
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                    if ($is_pass)
                                                        echo 'Pass';
                                                    else
                                                        echo 'Fail';
                                                    ?></td>


                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div><!--/box-body-->
                            <div class="box-footer">
                                <fieldset>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="disabledTextInput">Total Marks :</label>
                                            <?php echo $total_marks; ?>
                                        </div>                                                    
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="disabledTextInput">Total Obtained Marks :</label>
                                            <?php echo $obtained_marks; ?>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="disabledTextInput">Total Percentages Marks :</label>
                                            <?php echo number_format((($obtained_marks * 100) / $total_marks), 2, '.', ''); ?>%
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="disabledTextInput">Results :</label>
                                            <?php if (!$is_failed) { ?>
                                                <span class="label label-success">Pass</span>    
                                            <?php } else { ?>
                                                <span class="label label-danger">Failed</span>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label>Remarks :</label>
                                            <?php echo $row->mm_remarks; ?>
                                        </div>
                                    </div>
                                </fieldset>  
                            </div>
                        </div><!--/box-footer-->
                    </div><!--/box-->

                </div><!--/box-body-->
            </div><!--/box-->
        </div><!--/box-body-->
<?php } else { ?> 
    <br/>
    <div class="well well-sm">
        <h4 class="page-header edusec-border-bottom-warning">
            <i class="fa fa-info-circle"></i> Exam result
        </h4>
          <h3>Exam result has not been declared yet.</h3>
    </div><!--/well-->
  
<?php } ?>

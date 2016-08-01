<?php $this->load->model('subject/Subject_manager_model'); ?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                 <?php $i=1; ?>
                    <?php if ($quiz_history->timer_status) { ?>
                    <p><?php echo $i++; ?>. Total of <strong><?php echo $quiz_history->timer_value; ?> minutes</strong> duration will be given to attempt all the questions.</p>
                    <?php } else { ?>
                        
                    <?php } ?>
                    
                    <?php if($quiz_history->nagative_mark_status) { ?>
                    <p><?php echo $i++; ?>. A quiz need to be setup for which <strong><?php echo number_format(($quiz_history->total_marks / $quiz_history->total_questions), 2) ?> marks</strong> for each right answer but <strong><?php echo number_format((($quiz_history->total_marks / $quiz_history->total_questions) * $quiz_history->nagative_mark), 2); ?> marks</strong> deducted for each incorrect answer.</p>
                    <?php } else { ?>
                    <?php echo $i++; ?>. A quiz need to be setup for which <strong><?php echo number_format(($quiz_history->total_marks / $quiz_history->total_questions), 2) ?> marks</strong> for each right answer.</p>
                    <?php } ?>                   
                    <p>&nbsp;</p>
                    <h4>Quiz Name : <?php echo $quiz_history->title; ?></h4>
                    <hr>
                    <h5><span style="float: left">Total Marks : <?php echo $quiz_history->total_marks; ?></span><span style="float: right">Date : <?php echo $quiz_history->start_date; ?></span></h5><br>
                    <p><strong>Total Question : <?php echo $quiz_history->total_questions; ?></strong> </p>
                    <p><strong>Description : </strong> <?php echo $quiz_history->description; ?></p>
                    <p> 
                        <?php if(!empty($quiz_history->sm_id)){ ?>
                        <strong>Subject : </strong>
                        <?php 
                        $subject = $this->Subject_manager_model->get($quiz_history->sm_id);
                        echo $subject->subject_name;
                        
                        } ?></p>
                <table id="quiz-history-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>                            
                            
                            <th>Best Score</th>
                         <!--   <th>Action</th>-->
                        </tr>
                    </thead>

                    <tbody>
                        <?php $counter = 1; ?>
                       
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo $quiz_history->title; ?></td>
                                <td><?php echo $quiz_history->description; ?></td>
                                <td><?php echo datetime_formats($quiz_history->created_at); ?></td>                                
                                <td><?php echo $quiz_history->BestResult; ?>/<?php echo $quiz_history->total_marks; ?></td>                            
                       
                            </tr>
                       
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
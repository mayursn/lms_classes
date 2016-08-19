<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <form method="post" action="">
                    <input type="hidden" name="quiz_id" value="<?php echo hash('sha1', $quiz->quiz_id); ?>"/>
                    <i><strong>Please read the following instructions carefully</strong></i>
                    <h5>GENERAL INSTRUCTIONS:</h5>
                    <?php $i=1; ?>
                    <?php if ($quiz->timer_status) { ?>
                    <p><?php echo $i++; ?>. Total of <strong><?php echo $quiz->timer_value; ?> minutes</strong> duration will be given to attempt all the questions.</p>
                    <?php } else { ?>
                        <p><?php echo $i++; ?>. There will be no time limit to attempt all the questions.</p>
                    <?php } ?>
                    <p><?php echo $i++; ?>. The clock has been set at the server and the countdown timer at the top right corner of your screen will display the time remaining for you to complete the exam. When the clock runs out the exam ends by default - you are not required to end or submit your exam.</p>
                    <?php if($quiz->nagative_mark_status) { ?>
                    <p><?php echo $i++; ?>. A quiz need to be setup for which <strong><?php echo number_format(($quiz->total_marks / $quiz->total_questions), 2) ?> marks</strong> for each right answer but <strong><?php echo number_format((($quiz->total_marks / $quiz->total_questions) * $quiz->nagative_mark), 2); ?> marks</strong> deducted for each incorrect answer.</p>
                    <?php } else { ?>
                    <?php echo $i++; ?>. A quiz need to be setup for which <strong><?php echo number_format(($quiz->total_marks / $quiz->total_questions), 2) ?> marks</strong> for each right answer.</p>
                    <?php } ?>
                    <p><?php echo $i++; ?>. The question palette at the right of screen shows one of the following statuses of each of the questions numbered: </p>
                    <p><span class="btn btn-primary" style="margin-right: 30px;">&nbsp;&nbsp;</span> You have not visited the question yet.</p>
                    <p><span class="btn btn-danger" style="margin-right: 30px;">&nbsp;&nbsp;</span> You have not answered the question.</p>
                    <p><span class="btn btn-success" style="margin-right: 30px;">&nbsp;&nbsp;</span> You have answered the question.</p>
                    <p><span class="btn btn-warning" style="margin-right: 30px;">&nbsp;&nbsp;</span> Current question.</p>
                    <br/>
                    <p><strong><input type="checkbox" required="" name="start"/> The computer provided to me is in proper working condition. I have read and understood the instructions given above.</strong></p>
                    <br/>
                    <input type="submit" class="btn btn-success" value="Start Quiz"/>
                </form>
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

<style>
    .checkbox-custom{
        display: inline-block;
    }
</style>
<script>
localStorage.clear();
</script>
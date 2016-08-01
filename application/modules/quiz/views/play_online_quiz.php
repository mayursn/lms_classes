<?php
$this->load->model('quiz/Quiz_question_options_model');
$this->load->model('quiz/Quiz_questions_model');
$this->load->model('department/Degree_model');
$this->load->model('branch/Course_model');
$this->load->model('semester/Semester_model');
$this->load->model('batch/Batch_model');
$this->load->model('subject/Subject_manager_model');
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-heading">
                <div class="panel-title">Quiz Details</div>
            </div>
            <div class=panel-body>               
                <table class="table table-bordered">
                    <tr>
                        <td><strong>Title</strong></td>
                        <td><?php echo $quiz->title; ?></td>
                        <td><strong>Description</strong></td>
                        <td><?php echo $quiz->description; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Department</strong></td>
                        <td><?php if($quiz->department_id!="All"){
                        $name = $this->Degree_model->get($quiz->department_id);
                            echo $name->d_name;
                            
                        }else{ echo "All"; } ?></td>
                        <td><strong>Branch</strong></td>
                        <td><?php if($quiz->branch_id!="All")
                        { 
                            $course = $this->Course_model->get($quiz->branch_id);
                            echo $course->c_name;
                        }else{
                            echo "All";
                        }    
                        
                            ?></td>
                    </tr>
                    <tr>
                        <td><strong>Batch</strong></td>
                        <td><?php if($quiz->batch_id!="All"){
                            $batch = $this->Batch_model->get($quiz->batch_id);
                           echo $batch->b_name;
                        }else{
                            echo "All"; 
                        }
                            ?></td>
                        
                        <td><strong>Semester</strong></td>
                        <td><?php if($quiz->semester_id!="All")
                            {
                            $semester = $this->Semester_model->get($quiz->semester_id);
                            echo $semester->s_name;
                            }
                            else{
                                echo "All";
                            }
                            ?></td>
                        <td><strong>Subject</strong></td>
                         <td><?php
                         if($quiz->sm_id!="")
                         {
                         if($quiz->sm_id!="All")
                            {
                            $subject = $this->Subject_manager_model->get($quiz->sm_id);
                            echo $subject->subject_name;
                            }
                            else{
                                echo "All";
                            }
                         }
                            ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
    <form id="play-online-quiz" class="form-horizontal form-groups-bordered validate" 
          method="post">
        <input type="hidden" name="user_quiz_id" id="user_quiz_id" value="<?php echo hash('sha1', $quiz->quiz_id); ?>"/>
        <input type="hidden" name="user_quiz_id1" id="user_quiz_id1" value="<?php echo  $quiz->quiz_id; ?>"/>
       
       <input type="hidden" id="quiz_result_id" name="quiz_result_id" value="<?php echo $quiz_result_id;?>">
        
        <div class="col-lg-12">
            <div class="col-lg-8">
                <div class="panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Questions</div>
                    </div>

                    <?php
                    $all_quiz_questions = $this->Quiz_questions_model->get_many_by(array(
                        'quiz_id' => $quiz->quiz_id
                    ));
                    $quiz_counter = 1;
                    ?>

                    <div class="panel-body">
                        <?php for ($i = 1; $i <= $quiz->total_questions; $i++) { ?>
                       
                            <div id="panel<?php echo $i; ?>" class="question inactive"
                                 question_no="<?php echo $i; ?>">
                                 <input type="hidden" name="quiz_exam_id_<?php echo $i; ?>" id="quiz_exam_id_<?php echo $i; ?>" value="<?php echo $quiz_exam_id[$i-1]?>" />
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><strong><?php echo ucwords("question $i:"); ?></strong></label>
                                    <div class="col-sm-9">
                                        <?php
                                        $quiz_question = $this->Quiz_questions_model->get($all_quiz_questions[$i - 1]->quiz_question_id);
                                        echo "<p class=question-margin><strong>" . $quiz_question->question . "</strong></p>";
                                        ?>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><strong><?php echo ucwords("options"); ?></strong></label>
                                    <div class="col-sm-9">
                                        <?php
                                        $question_options = $this->Quiz_question_options_model->get_many_by(array(
                                            'quiz_question_id' => $quiz_question->quiz_question_id,
                                            'question_option !=' => ''
                                        ));
                                        ?>
                                        <?php if ($quiz_question->question_type == 'SingleAnswer') { ?>

                                            <?php foreach ($question_options as $row) { ?>
                                                <input type="radio" 
                                                       name="question_<?php echo $quiz_question->quiz_question_id; ?>[]" 
                                                       value="<?php echo $row->option_no; ?>"
                                                       class="question_<?php echo $quiz_counter; ?>"/>
                                                       <?php echo htmlspecialchars($row->question_option); ?>
                                                <br/>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php foreach ($question_options as $row) { ?>
                                                <input type="checkbox" 
                                                       name="question_<?php echo $quiz_question->quiz_question_id; ?>[]" 
                                                       value="<?php echo $row->option_no; ?>"
                                                       class="question_<?php echo $quiz_counter; ?>"/>
                                                       <?php echo htmlspecialchars($row->question_option); ?>
                                                <br/>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div> 

                            </div>
                            <?php
                            $quiz_counter++;
                        }
                        ?>
                        <style>
                            .btn_box{width: 100%; display: block; text-align: center;}
                            .btn_box a.btn{display: inline-block;}
                            .fl{float: left;}
                            .fr{float: right;}

                        </style>
                        <div class="next-prev btn_box">
                            <a id="prev"  class="btn fl btn-primary prev_btn">Prev</a>
                            <a id="clear" class="btn btn-info clear_btn">Clear Answer</a>
                            <a id="next"  class="btn fr btn-primary next_btn">Next</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Timer</div>
                    </div>
                    <div>
                        <div class="panel-body">
                            <div>
                                <img style="width: 18%" src="<?php echo base_url(); ?>assets/img/timer.png"/>
                                <span style="margin-left: 10px;">
                                    <strong style="font-size: 20px;" id="time">
                                        <?php if ($quiz->timer_value == '') { ?>
                                            --:--
                                        <?php } ?>
                                    </strong>
                                </span>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <br/>
            <div class="col-lg-4">
                <div class="panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Question No</div>
                    </div>
                    <div>
                        <div class="panel-body">
                            <?php for ($i = 1; $i <= $quiz->total_questions; $i++) { ?>
                                <div class="col-lg-1 number-margin">
                                    <a id="anchor-number-<?php echo $i; ?>" class="btn btn-primary page-number"
                                       data-id="<?php echo $i; ?>"><?php echo $i; ?></a>
                                </div>
                            <?php } ?>                        
                        </div>
                        <div class="col-lg-4">
                            <input id="submit-quiz" type="button" class="btn btn-success" value="Submit"/>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="col-lg-4 col-lg-offset-8">
                <br/>
                <div class="panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Legend</div>
                    </div>
                    <div>
                        <div class="panel-body">
                            <p><span class="btn btn-primary" style="margin-right: 30px;">&nbsp;&nbsp;</span> You have not visited the question yet.</p>
                            <p><span class="btn btn-danger" style="margin-right: 30px;">&nbsp;&nbsp;</span> You have not answered the question.</p>
                            <p><span class="btn btn-success" style="margin-right: 30px;">&nbsp;&nbsp;</span> You have answered the question.</p>
                            <p><span class="btn btn-warning" style="margin-right: 30px;">&nbsp;&nbsp;</span> Current question.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->

<style>
    .number-margin{
        margin-right: 30px; margin-bottom: 5px;
    }

    .page-number{
        width: 50px;
    }

    .inactive {
        display: none;
    }

    .question-margin{
        margin-top: 8px;
    }

    .checkbox-custom{
        display: inline-block;
    }
</style>

<script>
    $(document).ready(function () {
        var counter = 1;
        var max = <?php echo $quiz->total_questions; ?>;
        var min = 0;
        var prev_counter = 1;

        $('#panel1').removeClass('inactive');

        $('#anchor-number-1').addClass('btn-warning');

        $("#next").click(function () {
            next();
        });

        function next() {
            if (max > counter)
                counter++;
            if (counter <= max) {
                $('.question').addClass('inactive');
                $('#panel' + counter).removeClass('inactive');
                $('#panel' + counter + ' input').focus();
                $('.inactive').css('display', 'none');
                $('#panel' + counter).show('slide', {
                    direction: 'right'
                }, 1000);
                $('#anchor-number-' + counter).removeClass('btn-danger');
                $('#anchor-number-' + counter).addClass('.btn-warning');
                current_active_question_number(counter);
                visited_question(counter);
                check_for_skip(counter);

            }
        }

        function check_for_skip(prev_counter) {
            prev_counter--;
            if (!$('.question_' + prev_counter).is(':checked')) {
                $('#anchor-number-' + prev_counter).removeClass('btn-info');
                $('#anchor-number-' + prev_counter).removeClass('btn-success');
                $('#anchor-number-' + prev_counter).removeClass('btn-warning');
                $('#anchor-number-' + prev_counter).addClass('btn-danger');
            } else {
                $('#anchor-number-' + prev_counter).removeClass('btn-danger');
            }
            var current_counter = prev_counter + 1;
            $('#anchor-number-' + current_counter).addClass('btn-warning');
        }

        function prev() {
            if (counter > 1)
                counter--;
            if (counter > 0) {
                $('.question').addClass('inactive');
                $('#panel' + counter).removeClass('inactive');
                hide_all();
                $('#panel' + counter + ' > input').focus();
                $('#panel' + counter).show('slide', {
                    direction: 'left'
                }, 1000);
                $('#anchor-number-' + counter).removeClass('btn-danger');
                $('#anchor-number-' + counter).addClass('.btn-warning');
                visited_question(counter + 2);
                check_for_skip(counter + 2);
                current_active_question_number(counter);

                return true;
            }
        }

        function skip_status(id) {
            if (!$('.question_' + id).is(':checked')) {
                $('#anchor-number-' + id).removeClass('btn-info');
                $('#anchor-number-' + id).removeClass('btn-success');
                $('#anchor-number-' + id).removeClass('btn-warning');
                $('#anchor-number-' + id).addClass('btn-danger');
            } else {
                $('#anchor-number-' + id).removeClass('btn-danger');
                $('#anchor-number-' + id).addClass('btn-success');
            }
        }

        function visited_question(id) {
            id--;
            $('#anchor-number-' + id).addClass('btn-success');
            $('#anchor-number-' + id).removeClass('btn-danger')
        }

        function current_active_question_number(id) {
            var prev_id = id - 1;
            $('.page-number').removeClass('btn-warning');
            //$('.page-number').removeClass('btn-danger');
            $('#anchor-number-' + id).addClass('btn-warning');
        }

        $('#prev').click(function () {
            prev();
        });

        $('#clear').on('click', function () {
            $('.question_' + counter).removeAttr('checked');
        });

        $('.page-number').click(function () {
            //visited_question(prev_counter);
            skip_status(prev_counter);
            var data_id = $(this).attr('data-id');
            var effect = 'right';
            $('#anchor-number-' + data_id).removeClass('btn-danger');
            $('#anchor-number-' + data_id).removeClass('btn-success');
            $('.question').addClass('inactive');
            $('#panel' + data_id).removeClass('inactive');
            hide_all();
            if (data_id < counter) {
                effect = 'left';
            }
            prev_counter = counter = data_id;
            current_active_question_number(data_id);
            $('#panel' + data_id).show('slide', {
                direction: effect
            }, 1000);
            //visited_question(counter);
            //check_for_skip(counter);

            return true;
        });

        function hide_all() {
            $('.inactive').css('display', 'none');
        }

        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10)
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    //submit the quiz form
                    alert('Quiz time is finished!');
                    window.onbeforeunload = null;
                    $('#play-online-quiz').submit();
                    //location.reload();
                }
                console.log(quiz_timer--);
                localStorage.quiz_timer = quiz_timer;
            }, 1000);
        }

        window.onload = function () {
            var timer_value = '<?php echo $quiz->timer_value; ?>';
            if (timer_value != '') {
                var Minutes = 60 * timer_value,
                        display = document.querySelector('#time');
                quiz_timer = localStorage.quiz_timer ? localStorage.quiz_timer : Minutes;
                setTimeout(function () {
                    $('#time').html(quiz_timer);
                }, 1000);

                startTimer(quiz_timer, display);
            }

        };

        $('#submit-quiz').on('click', function () {
            var is_confirm = confirm('Are you sure to submit your exam?');
            if (is_confirm == true) {
                window.onbeforeunload = null;
                $('#play-online-quiz').submit();
            }
        });

            function closeWindow(){
                
                       var quiz_id = $("#user_quiz_id1").val();
                      // $("#play-online-quiz").submit();
               var Data = $.ajax({
                   type : "POST",
                   url : "<?php echo base_url(); ?>quiz/insertquizunload/"+quiz_id,  //loading a simple text file for sample.
                   data:$("#play-online-quiz").serialize(),
                   success : function(data) {
//                       alert(data);
//                       return data;
                   }

               });
               return "Are you sure you want to leave the page? You still have items in your quiz history";
           }

        window.onbeforeunload = closeWindow;
        
//        window.onbeforeunload = function (e) {
//            e = e || window.event;
//            // For IE and Firefox prior to version 4
//            if (e) {
//                e.returnValue = 'Are you sure want to quit the exam?';
//                console.log(e);
//            }
//            //alert(1);
//            // For Safari
//            return 'Are you sure want to quit the exam?';
//        };

        function show_submit() {
            $('#submit-quiz').removeClass('hide');
        }

        $('input').change(function () {
            show_submit();
        });

    });

</script>
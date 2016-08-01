<?php
$this->load->model('quiz/Quiz_questions_model');
$this->load->model('quiz/Quiz_question_options_model');

$question = $this->Quiz_questions_model->get($param2);
$question_option = $this->Quiz_question_options_model->get_many_by(array(
    'quiz_question_id' => $question->quiz_question_id
        ));
?>

<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body"> 
                <div class="box-content">  

                    <?php echo form_open(base_url() . 'quiz/update-question/' . $param2, array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'quiz-question-option', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Question<span style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <textarea name="question" class="form-control" rows="3"><?php echo $question->question; ?></textarea>									</div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo ucwords("question type"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <select id="question-type" class="form-control" name="question_type">
                                    <option value="">Select</option>
                                    <option value="SingleAnswer">Single Answer</option>
                                    <option value="MultiAnswer">Multiple Answer</option>
                                </select>
                            </div>
                        </div>

                        <?php $counter = 1; ?>
                        <?php foreach ($question_option as $row) { ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Option <?php echo $counter; ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="option_<?php echo $counter; ?>"
                                           value="<?php echo $row->question_option; ?>"/>
                                </div>
                            </div>
                            <?php
                            $counter++;
                        }
                        ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Currect Answer<span style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="currect_answer" 
                                       value="<?php echo $question->currect_answer; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <button type="submit" class="btn btn-info">Edit</button>
                            </div>
                        </div>
                    </div>    
                    <?php echo form_close(); ?>  
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#question-type').val('<?php echo $question->question_type; ?>');
            
            $("#quiz-question-option").validate({
                rules: {
                    question: "required",
                    currect_answer: "required",
                },
                messages: {
                    question: "Enter question",
                    currect_answer: "Enter currect answer",
                }
            });

        });
    </script>

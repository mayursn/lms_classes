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
                        <input type="hidden" name="quiz_id" value="<?php echo $question->quiz_id; ?>" />
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo ucwords("question type"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <select id="question_type" class="form-control" name="question_type">
                                    <option value="">Select</option>
                                    <option value="SingleAnswer" <?php if($question->question_type=="SingleAnswer"){echo "selected";} ?>>Single Answer</option>
                                    <option value="MultiAnswer" <?php if($question->question_type=="MultiAnswer"){echo "selected";} ?> >Multiple Answer</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Option 1</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="question_option_1"
                                       value="<?php echo $question_option[0]->question_option; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Option 2</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="question_option_2"
                                       value="<?php echo $question_option[1]->question_option; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Option 3</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="question_option_3"
                                       value="<?php echo $question_option[2]->question_option; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Option 4</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="question_option_4"
                                       value="<?php echo $question_option[3]->question_option; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Option 5</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="question_option_5"
                                       value="<?php echo $question_option[4]->question_option; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Option 6</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="question_option_6"
                                       value="<?php echo $question_option[5]->question_option; ?>"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo ucwords("answer"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="question_answer" id="question_answer"
                                       value="<?php echo $question->currect_answer; ?>"/>
                                <span style="font-size: 10px;"> <strong style="color:red">Note :</strong> If you choose question type is Multiple Answer then answer enter like 1,2,3 </span>
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
            
            $.validator.addMethod("length", function(value, element) {
                    return this.optional(element) || /^[1-6]{1}$/i.test(value);
                }, "Username must contain only letters, numbers, or dashes.");
    
            $.validator.addMethod("multipleanslength", function(value, element) {
                    return this.optional(element) || /^[1-6](,[1-6])*$/i.test(value);
                }, "Username must contain only letters, numbers, or dashes.");
                
            $("#quiz-question-option").validate({
                rules: {
                    question: "required",
                    question_type: "required",
                    currect_answer: "required",
                    question_answer: {
                        required:true,
                        multipleanslength:
                                {
                                    depends: function(element){
                                        return $("#question_type").val()=="MultiAnswer"
                                    }
                                },
                        length:
                                {
                                   depends: function(element){
                                        return $("#question_type").val()=="SingleAnswer"
                                    } 
                                },
                        number:{
                               depends: function(element){
                                        return $("#question_type").val()=="SingleAnswer"
                                    }
                        }    
                    },
                },
                messages: {
                    question: "Enter question",
                    question_type: "Select question type",
                    currect_answer: "Enter currect answer",
                     question_answer:
                        {
                            required:"Enter currect answer",
                            multipleanslength:"Enter valid multiple answer",
                            length:"Enter valid answer number",
                            number:"Enter valid answer option",
                        },
                }
            });

        });
    </script>

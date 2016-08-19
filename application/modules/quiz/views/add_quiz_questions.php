<?php $this->load->model('department/Degree_model');
 $this->load->model('branch/Course_model');
  $this->load->model('batch/Batch_model');
   $this->load->model('semester/Semester_model');
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
    <form class="form-horizontal form-groups-bordered validate" method="post" id="quiz-question-option">
        <div class="col-lg-12">
            <div class="col-lg-8">
                <div class="panel-default">
                    <?php if($this->session->userdata('error_message')){ ?>
                    <div class="panel-heading">
                        <div class="danger" style="color:red"><?php echo $this->session->userdata('error_message'); ?></div>
                    </div>
                    <?php } ?>
                    <div class="panel-heading">
                        <div class="panel-title">Questions</div>
                    </div>

                    <div class="panel-body">
                        <?php for ($i = 1; $i <= $quiz->total_questions; $i++) { ?>
                            <div id="panel<?php echo $i; ?>" class="question inactive"  question_no="<?php echo $i; ?>">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("question"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>" id="question_<?php echo $i; ?>" class="question_number" value="" />
                                        <label id="error_question_<?php echo $i; ?>" style="text-align: center"></label>
                                    </div>
                                    
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("question type"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="question_type_<?php echo $i; ?>" id="question_type_<?php echo $i; ?>" id="question_type_<?php echo $i; ?>" > 
                                            <option value="SingleAnswer">Single Answer</option>
                                            <option value="MultiAnswer">Multiple Answer</option>
                                        </select>
                                        <label id="error_question_type_<?php echo $i; ?>" style="text-align: center"></label>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option1"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>_option_1" id="question_<?php echo $i; ?>_option_1" value="" />
                                        <label id="error_question_<?php echo $i; ?>_option_1" style="text-align: center"></label>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option2"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>_option_2" value=""/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option3"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>_option_3" value=""/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option4"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>_option_4" value=""/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option5"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>_option_5" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option6"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>_option_6" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("answer"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control answervalidation" name="question_<?php echo $i; ?>_answer" value=""
                                               placeholder="Only enter option number" id="question_<?php echo $i; ?>_answer"  />
                                        <span style="font-size: 10px;"> <strong style="color:red">Note :</strong> If you choose question type is Multiple Answer then answer enter like 1,2,3 </span>
                                         <label id="error_question_<?php echo $i; ?>_answer" style="text-align: center"></label>
                                    </div>
                                </div> 
                                
                            </div>
                        <?php } ?>
                        <div class="next-prev">
                            <a id="prev" style="float: left" class="btn btn-primary">Prev</a>
                            <a id="next" style="float: right" class="btn btn-primary">Next</a>
                        </div>
                    </div>
                </div>
            </div>
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
                            <input type="submit" class="btn btn-success" id="submit" value="Submit"/>
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
</style>
<script>
    $(document).ready(function () {        
        var counter = 1;
        var max = <?php echo $quiz->total_questions; ?>;
        var min = 0;

        $('#panel1').removeClass('inactive');

        $('#anchor-number-1').addClass('btn-info');

        $("#next").click(function () {            
            if (counter <= max) {
                var minus = 1;
                var mycounter = counter;
                var question = $("#question_"+mycounter).val();                
                var question_type_value = $("#question_type_"+mycounter).val();                     
               var question_option = $("#question_"+mycounter+"_option_1").val();
              var question_answer = $("#question_"+mycounter+"_answer").val();
                if(question=="")
                {
                  
                    $("#question_"+mycounter).css({'border-color':'red'});
                    $("#error_question_"+mycounter).html('Enter Question');
                    $("#error_question_"+mycounter).css({'color':'red'});
                    return false;
                }
                else{
                    $("#question_"+mycounter).css({'border-color':'green'});
                    $("#error_question_"+mycounter).html('');                    
                }
                if(question_type_value=="")
                {
                  
                    $("#question_type_"+mycounter).css({'border-color':'red'});
                    $("#error_question_type_"+mycounter).html('Enter Question Type');
                    $("#error_question_type_"+mycounter).css({'color':'red'});
                    return false;
                }
                else{
                    $("#question_type_"+mycounter).css({'border-color':'green'});
                    $("#error_question_type_"+mycounter).html('');                    
                }
                 if(question_option=="")
                {
                  
                    $("#question_"+mycounter+"_option_1").css({'border-color':'red'});
                    $("#error_question_"+mycounter+"_option_1").html('Enter Answer Option');
                    $("#error_question_"+mycounter+"_option_1").css({'color':'red'});
                    return false;
                }
                else{
                    $("#question_"+mycounter+"_option_1").css({'border-color':'green'});
                     $("#error_question_"+mycounter+"_option_1").html('');
                    $("#error_question_"+mycounter+"_option_1").css({'color':'green'});
                }
                if(question_answer=="")
                {                  
                    $("#question_"+mycounter+"_answer").css({'border-color':'red'});
                    $("#error_question_"+mycounter+"_answer").html('Enter Answer');
                    $("#error_question_"+mycounter+"_answer").css({'color':'red'});
                    return false;
                }
                else{
                    
                    if(question_type_value=="SingleAnswer")
                    {
                    if(isNaN(question_answer))
                    {
                             $("#question_"+mycounter+"_answer").css({'border-color':'red'});
                                $("#error_question_"+mycounter+"_answer").html('Enter  Only Numeric value');
                                $("#error_question_"+mycounter+"_answer").css({'color':'red'});
                                return false;
                    }                    
                    else{
                    $("#question_"+mycounter+"_answer").css({'border-color':'green'});
                    $("#error_question_"+mycounter+"_answer").html('');                    
                
                  }
                  }else{
                    $("#question_"+mycounter+"_answer").css({'border-color':'green'});
                    $("#error_question_"+mycounter+"_answer").html('');                    
                
                  }
                }
            }            
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
                current_active_question_number(counter);
            }            
           
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
                current_active_question_number(counter);

                return true;
            }
        }

        function current_active_question_number(id) {
            $('.page-number').removeClass('btn-info');
            $('#anchor-number-' + id).addClass('btn-info');
        }

        $('#prev').click(function () {
              var minus = 1;
                var mycounter = counter;
                var question = $("#question_"+mycounter).val();                
                var question_type_value = $("#question_type_"+mycounter).val();                
               var question_option = $("#question_"+mycounter+"_option_1").val();
                var question_answer = $("#question_"+mycounter+"_answer").val();
                 if(question=="")
                {
                  
                    $("#question_"+mycounter).css({'border-color':'red'});
                    $("#error_question_"+mycounter).html('Enter Question');
                    $("#error_question_"+mycounter).css({'color':'red'});
                    return false;
                }
                else{
                    $("#question_"+mycounter).css({'border-color':'green'});
                    $("#error_question_"+mycounter).html('');                    
                }
                if(question_type_value=="")
                {
                  
                    $("#question_type_"+mycounter).css({'border-color':'red'});
                    $("#error_question_type_"+mycounter).html('Enter Question Type');
                    $("#error_question_type_"+mycounter).css({'color':'red'});
                    return false;
                }
                else{
                    $("#question_type_"+mycounter).css({'border-color':'green'});
                    $("#error_question_type_"+mycounter).html('');                    
                }
                 if(question_option=="")
                {
                  
                    $("#question_"+mycounter+"_option_1").css({'border-color':'red'});
                    $("#error_question_"+mycounter+"_option_1").html('Enter Answer Option');
                    $("#error_question_"+mycounter+"_option_1").css({'color':'red'});
                    return false;
                }
                else{
                    $("#question_"+mycounter+"_option_1").css({'border-color':'green'});
                     $("#error_question_"+mycounter+"_option_1").html('');
                    $("#error_question_"+mycounter+"_option_1").css({'color':'green'});
                }
                if(question_answer=="")
                {                  
                    $("#question_"+mycounter+"_answer").css({'border-color':'red'});
                    $("#error_question_"+mycounter+"_answer").html('Enter Answer');
                    $("#error_question_"+mycounter+"_answer").css({'color':'red'});
                    return false;
                }
                else{
                    
                    if(question_type_value=="SingleAnswer")
                    {
                    if(isNaN(question_answer))
                    {
                             $("#question_"+mycounter+"_answer").css({'border-color':'red'});
                                $("#error_question_"+mycounter+"_answer").html('Enter  Only Numeric value');
                                $("#error_question_"+mycounter+"_answer").css({'color':'red'});
                                return false;
                    }                    
                    else{
                    $("#question_"+mycounter+"_answer").css({'border-color':'green'});
                    $("#error_question_"+mycounter+"_answer").html('');                    
                
                  }
                  }else{
                    $("#question_"+mycounter+"_answer").css({'border-color':'green'});
                    $("#error_question_"+mycounter+"_answer").html('');                    
                
                  }
                }
            prev();
        });

        $('.page-number').click(function () {
            var data_id = $(this).attr('data-id');
            var effect = 'right';
            $('.question').addClass('inactive');
            $('#panel' + data_id).removeClass('inactive');
            hide_all();
            if (data_id < counter) {
                effect = 'left';
                prev();
            }
            counter = data_id;
            current_active_question_number(data_id);
            $('#panel' + data_id).show('slide', {
                direction: effect
            }, 1000);

            return true;
        });

        function hide_all() {
            $('.inactive').css('display', 'none');
        }
    });
    
    function check_question_option(question_option,mycounter)
    {
                if(question_option=="")
                {
                  
                    $("#question_"+mycounter+"_option_1").css({'border-color':'red'});
                    $("#error_question_"+mycounter+"_option_1").html('Enter Answer Option');
                    $("#error_question_"+mycounter+"_option_1").css({'color':'red'});
                    return false;
                }
                else{
                    $("#question_"+mycounter+"_option_1").css({'border-color':'green'});
                     $("#error_question_"+mycounter+"_option_1").html('');
                    $("#error_question_"+mycounter+"_option_1").css({'color':'green'});
                }
                
                
    }
    
    function check_answer(question_answer,mycounter)
    {
        
                if(question_answer=="")
                {                  
                    $("#question_"+mycounter+"_answer").css({'border-color':'red'});
                    $("#error_question_"+mycounter+"_answer").html('Enter Answer');
                    $("#error_question_"+mycounter+"_answer").css({'color':'red'});
                    return false;
                }
                else{
                    if(isNaN(question_answer))
                    {
                             $("#question_"+mycounter+"_answer").css({'border-color':'red'});
                                $("#error_question_"+mycounter+"_answer").html('Enter  Only Numeric value');
                                $("#error_question_"+mycounter+"_answer").css({'color':'red'});
                                return false;
                    }
                    else{
                    $("#question_"+mycounter+"_answer").css({'border-color':'green'});
                    $("#error_question_"+mycounter+"_answer").html('');                    
                  }
                }
    }

</script>

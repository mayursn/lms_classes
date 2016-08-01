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
    <form class="form-horizontal form-groups-bordered validate" method="post">
        <div class="col-lg-12">
            <div class="col-lg-8">
                <div class="panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Questions</div>
                    </div>

                    <div class="panel-body">
                        <?php 
                        for ($i = 0; $i <= count($quiz_question)-1; $i++) { 
                            
                            ?>
                            <div id="panel<?php echo $i+1; ?>" class="question inactive"
                                 question_no="<?php echo $i+1; ?>">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("question"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i+1; ?>" value="<?php echo $quiz_question[$i]->question; ?>"/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("question type"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <select id="" class="form-control" name="question_type_<?php echo $i+1; ?>">
                                            <option value="SingleAnswer" <?php if($quiz_question[$i]->question_type=="SingleAnswer"){ echo "selected=selected"; } ?>>Single Answer</option>
                                            <option value="MultiAnswer" <?php if($quiz_question[$i]->question_type=="MultiAnswer"){ echo "selected=selected"; } ?>>Multiple Answer</option>
                                        </select>
                                    </div>
                                </div> 
                                <?php
                                $this->db->where('quiz_question_id',$quiz_question[$i]->quiz_question_id);
                                $option = $this->db->get('quiz_question_options')->result(); 
                                foreach($option as $opt):
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option1"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i+1; ?>_option_<?php echo $opt->option_no; ?>" value="<?php echo $opt->question_option; ?>"/>
                                    </div>
                                </div> 
                                <?php endforeach; ?>
<!--                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option2"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i+1; ?>_option_2" value=""/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option3"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i+1; ?>_option_3" value=""/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option4"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i+1; ?>_option_4" value=""/>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("answer"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i+1; ?>_answer" value="<?php echo $quiz_question[$i]->currect_answer; ?>"
                                               placeholder="Only enter option number"/>
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
                            <?php for ($i = 0; $i <= count($quiz_question)-1; $i++) { ?>
                                <div class="col-lg-1 number-margin">
                                    <a id="anchor-number-<?php echo $i+1; ?>" class="btn btn-primary page-number"
                                       data-id="<?php echo $i+1; ?>"><?php echo $i+1; ?></a>
                                </div>
                            <?php } ?>                        
                        </div>
                        <div class="col-lg-4">
                            <input type="submit" class="btn btn-success" value="Submit"/>
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
</style>

<script>
    $(document).ready(function () {
        var counter = 1;
        var max = <?php echo count($quiz_question); ?>;
        var min = 0;

        $('#panel1').removeClass('inactive');

        $('#anchor-number-1').addClass('btn-info');

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

</script>

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
                        <td><?php echo $quiz->d_name; ?></td>
                        <td><strong>Branch</strong></td>
                        <td><?php echo $quiz->c_name; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Batch</strong></td>
                        <td><?php echo $quiz->b_name; ?></td>
                        <td><strong>Semester</strong></td>
                        <td><?php echo $quiz->s_name; ?></td>
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
                        <?php for ($i = 1; $i <= $quiz->total_questions; $i++) { ?>
                            <div id="panel<?php echo $i; ?>" class="question inactive"
                                 question_no="<?php echo $i; ?>">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("question"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>" value=""/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("question type"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <select id="" class="form-control" name="question_type_<?php echo $i; ?>">
                                            <option value="SingleAnswer">Single Answer</option>
                                            <option value="MultiAnswer">Multiple Answer</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("option1"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>_option_1" value=""/>
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
                                    <label class="col-sm-4 control-label"><?php echo ucwords("answer"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="question_<?php echo $i; ?>_answer" value=""
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
                            <?php for ($i = 1; $i <= $quiz->total_questions; $i++) { ?>
                                <div class="col-lg-1 number-margin">
                                    <a id="anchor-number-<?php echo $i; ?>" class="btn btn-primary page-number"
                                       data-id="<?php echo $i; ?>"><?php echo $i; ?></a>
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
        var max = <?php echo $quiz->total_questions; ?>;
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
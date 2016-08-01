
<div class="row">
    <!-- .row -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo base_url(); ?>class_routine" class="stats-btn mb20 lead-stats color_green">
                    <span data-to="568" data-from="0" class="stats-number dolar">Class Routine</span>
                    <span class="stats-icon"><i class="fa fa-book color-green"></i></span>
                    <h5>Daily class routine</h5>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo base_url(); ?>exam" class="stats-btn mb20 lead-stats news_icon">
                    <span data-to="568" data-from="0" class="stats-number dolar">Exam</span>
                    <span class="stats-icon"><i class="fa fa-newspaper-o news-icon"></i></span>
                    <h5>Exam and it's schedule</h5>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo base_url(); ?>assignment/submission" class="stats-btn mb20 lead-stats attendant_green">
                    <span data-to="568" data-from="0" class="stats-number dolar">Assignment</span>
                    <span class="stats-icon"><i class="fa fa-file attendant-color"></i></span>
                    <h5>Daily assignments</h5>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo base_url(); ?>fee_record" class="stats-btn mb20 lead-stats admissions_color">
                    <span data-to="568" data-from="0" class="stats-number dolar">Fee Records</span>
                    <span class="stats-icon"><i class="fa fa-universal-access admissions-color"></i></span>
                    <h5>Recent fee records</h5>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- / .row -->
<div class="row">
    <!-- .row -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block">
                    <div class="xe-upper">
                        <div class="xe-icon"> 
                            <i class="icomoon-icon-books"></i> 
                        </div>
                        <div class="xe-label"> 
                            <strong class="num">STUDY RESOURCES</strong>   
                        </div>
                    </div>
                    <div class="border"></div>                          
                    <div class="xe-lower scroll-bar-box">  
                        <ul class="clearfix links-gaz">                                              
                            <?php
                            foreach ($studyresource as $row):
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>uploads/project_file/<?php echo $row->study_filename; ?>"  title="<?php echo $row->study_desc; ?>" download="" target="_newtab" ><?php echo $row->study_title; ?></a>
                                </li>
                            <?php endforeach; ?>                                      
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-purple">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class="icomoon-icon-book" aria-hidden="true"></i> </div>
                        <div class="xe-label"> <strong class="num">DIGITAL LIBRARY</strong> <span>Daily Visits</span> </div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz">
                            <?php
                            foreach ($library as $lbr):
                                ?>
                                <li>
                                    <a  download=""  href="<?php echo base_url(); ?>uploads/project_file/<?php echo $lbr->lm_filename; ?>" target="_blank" ><?php echo $lbr->lm_title; ?></a>                                
                                </li>                            
                            <?php endforeach; ?>   
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block  xe-counter-block-blue">
                    <div class="xe-upper">
                        <div class="xe-icon"> 
                            <i class="icomoon-icon-file" aria-hidden="true"></i> 
                        </div>                        
                        <div class="xe-label"> 
                            <span>All the best</span> 
                            <strong class="num">EXAMINATIONS</strong> 
                        </div>
                    </div>
                    <div class="border"></div>            
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz">
                            <?php foreach ($exam_listing as $row) { ?> 
                                <li>
                                    <a href="<?php echo base_url('examschedual/schedule/' . $row->em_id); ?>" target="_blank"><?php echo $row->em_name; ?></a>                  
                                </li>
                            <?php } ?>                                                                                                                                 
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-orange">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class=" icomoon-icon-file-upload" aria-hidden="true"></i> </div>
                        <div class="xe-label"> <strong class="num">PARTICIPATE</strong></div>                        
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <li>
                                <a href="<?php echo base_url(); ?>participate/volunteer" target="_blank">Volunteer</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>participate/survey" target="_blank"> <div class="menu-icon"></div> <div class="menu-text">Survey</div> </a>                                
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>participate/upload" target="_blank"> <div class="menu-icon"></div> <div class="menu-text">Upload</div> </a>                                
                            </li>        
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-progress-counter xe-progress-counter-turquoise">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class="fa fa-legal" aria-hidden="true"></i> </div>
                        <div class="xe-label"><strong class="num">RESULTS</strong> </div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <li>
                                <a href="<?php echo base_url('student/exam_marks'); ?>" target="_blank">Exam Marks</a>

                            </li>
                            <li>
                                <a href="<?php echo base_url('student/statement_of_marks'); ?>" target="_blank">Statement of Marks</a>                                 
                            </li>
                        </ul>                     
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-red">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class="icomoon-icon-camera-5" aria-hidden="true"></i> </div>
                        <div class="xe-label"> <strong class="num">VIDEO CONFERENCING</strong> </div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <?php foreach ($live_streaming as $video) { ?>
                                <li>
                                    <a target="_blank" href="<?php echo base_url('video_streaming#' . $video->url_link); ?>">
                                        <div class="menu-icon">
                                            <i class=" icon-trophy"></i>
                                        </div>
                                        <div class="menu-text">
                                            <?php echo $video->title; ?>                                        
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php foreach ($all as $video) { ?>
                                <li>
                                    <a target="_blank" href="<?php echo base_url('video_streaming#' . $video->url_link); ?>">
                                        <div class="menu-icon">
                                            <i class=" icon-trophy"></i>
                                        </div>
                                        <div class="menu-text"><?php echo $video->title; ?></div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php
                            if(!count($live_streaming) && !count($all)) { ?>
                                <h5>No live streaming available.</h5>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Admission Volunteer start div-->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-red attendance-box" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i aria-hidden="true" class=" icomoon-icon-notebook"></i> </div>
                        <div class="xe-label"> <strong class="num">Admission</strong></div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <li>
                                <a href="<?php echo base_url('student/profile'); ?>" target="_blank"> 
                                    <div class="menu-text">Profile</div> 
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('student/fee_record'); ?>" target="_blank"> 
                                    <div class="menu-text"> Student Payment Record</div> 
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('student/student_fees'); ?>" target="_blank">                                 
                                    <div class="menu-text">Pay Online 

                                    </div> </a> 
                            </li>

                            <?php foreach ($cms_pages as $page) { ?>
                                <li>
                                    <a href="<?php echo base_url('student/cms_page/' . $page->am_id); ?>" target="_blank">
                                        <div><?php echo $page->am_title; ?></div>
                                    </a>
                                </li> 
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Admission Volunteer end div-->

            <!-- Project List start div-->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-black">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class="fa fa-paperclip" aria-hidden="true"></i> </div>
                        <div class="xe-label"> <strong class="num">PROJECT</strong> </div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <li>                                
                                <a href="<?php echo base_url(); ?>student/project/submission" target="_blank"> <div class="menu-icon"></div> <div class="menu-text">Main Project List
                                </a>
                            </li>
                        </ul>    
                    </div>
                </div>
            </div>
            <!-- Project List end div-->

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- calendar start here -->        
                <div class="panel panel-default toggle">
                    <!-- Start .panel -->
                    <div class=panel-heading>
                        <h4 class=panel-title>Event Calendar</h4>
                        <div class="panel-controls panel-controls-right"> 
                            <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                        </div>
                    </div>
                    <div class=panel-body>
                        <div id="eventCalendarHumanDate"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<div class="row">
    <!-- .row start -->
    <!-- To do list Start div-->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-default toggle">
            <!-- Start .panel -->
            <div class=panel-heading>
                <h4 class=panel-title>
                    To Do
                </h4>
                <div class="panel-controls panel-controls-right"> <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                </div>
            </div>
            <div class=panel-body>
                <div class=todo-widget>
                    <!-- .todo-widget -->
                    <div class=todo-header>
                        <div id="updateformhtml"></div>
                        <div class="todo-addform" id="todo-addform">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class=todo-period>Add New ToDo</h4>
                                    <form id="frmtodo" class="form-horizontal form-groups-bordered validate">
                                        <div class=form-group>
                                            <label class="control-label col-lg-4">Task Title</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="todo_title" class="form-control" name="todo_title" >
                                            </div>
                                        </div>
                                        <div class=form-group>
                                            <label class="control-label col-lg-4">Task Date</label>
                                            <div class="col-sm-8">
                                                <input id="basic-datepicker" type="text" name="tado_date" class="form-control" >
                                            </div>
                                        </div>
                                        <div class=form-group>
                                            <label class="control-label col-lg-4">Task Time</label>
                                            <div class="col-sm-8">
                                                <div class="input-group bootstrap-timepicker">
                                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                    <input id="minute-step-timepicker" name="todo_time" type="text" class="form-control col-lg-8" >
                                                </div>
                                                <label id="minute-step-timepicker-error" style="display:none;" class="error" for="minute-step-timepicker">Select time</label>
                                            </div>
                                        </div>
                                        <div class=form-group>
                                            <div class="col-sm-offset-4 col-sm-8">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Add New Task" id="addbutton">

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class=todo-search>
                            <form>
                                <input class=form-control name=search placeholder="Search for todo ...">
                            </form>
                        </div>
                        <div class=todo-add>
                            <a href=# class="btn btn-primary tip" id="addnewtodo" title="Add new todo"><i class="icomoon-icon-plus mr0"></i></a>
                        </div>
                    </div>
                    <h4 class=todo-period>To Do List</h4>
                    <div id="wait" class="loading_img">
                        <img src='<?php echo base_url() . 'assets/img/preloader.gif' ?>' width="64" height="64" style="position:relative; z-index:99999;" /><br>Loading...
                    </div>
                    <ul class="todo-list" id="today">
                        <?php foreach ($todolist as $todo) { ?>  
                            <li class="todo-task-item <?php
                            if ($todo->todo_status == "0") {
                                echo "task-done";
                            }
                            ?>" id="todo-task-item-id<?php echo $todo->todo_id; ?>">
                                <div class=checkbox-custom><input type="checkbox" <?php
                                    if ($todo->todo_status == "0") {
                                        echo "checked=''";
                                    }
                                    ?> value="<?php echo $todo->todo_id ?>" id="checkbox<?php echo $todo->todo_id ?>" class="taskstatus"><label for=checkbox1></label></div>
                                <div class=todo-task-text><?php echo $todo->todo_title; ?></div>
                                <div class="todo-category"> <i aria-hidden="true" class="mar4top fa fa-calendar"></i> <?php echo date_duration($todo->todo_datetime); ?></div>
                                <div class="updateclick_box">
                                    <button type="button" class="updateclick" value="<?php echo $todo->todo_id; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                </div>
                                <div class="todo-close_box">
                                    <button type=button class="close-todo-old todo-close1" value="<?php echo $todo->todo_id; ?>"><i aria-hidden="true" class="fa fa-trash-o"></i></button>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!-- End .todo-widget -->
        </div>
    </div>
    <!-- To do list End div-->   

    <!-- Growth Start div-->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <!-- col-md-6 start here  -->
        <div class="panel panel-default toggle">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title"> Growth</h4>
                <div class="panel-controls panel-controls-right"> <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="vital-stats">
                    <!-- Vital stats -->
                    <ul class="list-unstyled growth-list">
                       <?php  foreach($growth as $row_mark):    
                        $total = ($row_mark->total*100/$row_mark->totalmarks);
                        $total_percentage = number_format($total, 2, '.', ',');
                        $total_percentage." %";
                        $round_percentage = round($total_percentage);
                                                ?>
                         <?php
                                 $progress_class = '';
                                 $color_class = '';
                              if($round_percentage >= 50 || $round_percentage <= 60  )
                                {
                                    $progress_class = "progress-bar-warning";
                                    $color_class = "fa-caret-down color-red";
                                }
                                if($round_percentage <= 50)
                                {
                                    $progress_class = "progress-bar-danger";
                                    $color_class= "fa-caret-down color-red";
                                }
                                if($round_percentage >= 70)
                                {
                                    $progress_class = "progress-bar-success";
                                    $color_class= "fa-caret-up color-green";
                                }
                                 ?>
                                               
                        <li>
                            <i class="fa s24 <?php echo $color_class; ?>" aria-hidden="true"></i>
                             <?php echo $row_mark->s_name; ?>
                            <span class="pull-right strong"><?php //echo $row_mark->total; ?></span>
                            <div class="progress progress-striped animated-bar mt0">
                               
                                <div data-transitiongoal="<?php echo $round_percentage; ?>" role="progressbar" class="progress-bar <?php echo $progress_class; ?>" style="width: <?php echo $round_percentage; ?>%;" aria-valuenow="<?php echo $round_percentage; ?>">
                                   <?php echo $total_percentage; ?>%
                                </div>
                            </div>
                        </li>
                                 <?php endforeach;?>                        
                    </ul>
                    <!-- / Vital stats -->
                </div>
            </div>
        </div>
        <!-- End .panel --><!-- / .panel -->
    </div>
    <!-- Growth end div-->



</div>

<!-- Timeline Start div-->
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default toggle">
            <div class=panel-heading>
                <h4 class="panel-title marginzero">
                    Timeline
                </h4>
                <div class="panel-controls panel-controls-right"> <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                </div>
            </div>
            <div class=panel-body>
                <div id="demo">
                    <section id="examples">
                        <!-- content -->
                        <div id="content-1">
                            <div class="timeline-box timeline-horizontal">
                                <?php
                                $i = 1;
                                $eventdate = array();
                                $tododate = array();

                                foreach ($timline_event as $event1) {
                                    $eventdate[] = date('Y-m-d', strtotime($event1->event_date));
                                }

                                foreach ($timline_todolist as $time_line1) {
                                    $tododate [] = date('Y-m-d', strtotime($time_line1->todo_datetime));
                                }
                                foreach ($timelinecount as $c) {
                                    if (!empty($tododate) || !empty($eventdate)) {
                                        if (in_array($c, $tododate) || in_array($c, $eventdate)) {
                                            $i++;
                                            $j = 0;
                                            ?>
                                            <div class="tl-row <?php echo $i; ?>">
                                                <div class="tl-item <?php if ($i % 2) { ?> float-right <?php } ?>">
                                                    <div class="tl-bullet bg-blue"></div>
                                                    <div class="tl-panel"><?php echo $c; ?></div>
                                                    <div class="popover <?php if ($i % 2) { ?> bottom <?php } else { ?> top <?php } ?>">
                                                        <div class="arrow"></div>
                                                        <?php
                                                        if (!empty($eventdate)) {
                                                            if (in_array($c, $eventdate)) {
                                                                ?>
                                                                <div class="popover-content">
                                                                    <h3 class="tl-title">Event</h3>
                                                                    <?php
                                                                    foreach ($timline_event as $event) {
                                                                        if (date('Y-m-d', strtotime($event->event_date)) == $c) {
                                                                            $j++;
                                                                            if ($j <= 3) {
                                                                                ?>
                                                                                <p class=""><?php echo $event->event_name; ?></p>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                        if (!empty($tododate)) {
                                                            if (in_array($c, $tododate)) {
                                                                if ($j < 3) {
                                                                    ?>
                                                                    <div class="popover-content">
                                                                        <h3 class="tl-title">Todolist</h3>
                                                                        <?php
                                                                        foreach ($timline_todolist as $time_line) {
                                                                            if (date('Y-m-d', strtotime($time_line->todo_datetime)) == $c) {
                                                                                $j++;
                                                                                if ($j <= 3) {
                                                                                    ?>
                                                                                    <p class=""><?php echo $time_line->todo_title; ?></p>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>   
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?> 
                                                        <div class="tl-time"><i aria-hidden="true" class="fa fa-clock-o"></i><?php echo date_duration($c); ?></div>
                                                        <a href="#" class="readmore_link" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_eventlist/<?php echo $c; ?>');" data-toggle="modal"> Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <script>
                                    var total_timeline_boxes = '<?php echo --$i; ?>';

                                    $(document).ready(function () {
                                        setTimeout(function () {
                                            var box_width = '<?php echo 260 * $i; ?>';
                                            $('.tl-row').css('width', '260');
                                            $('.timeline-box.timeline-horizontal').css('width', box_width);

                                        }, 500);
                                    });
                                </script>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
<!-- To do list js -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script>
var js_date_format = '<?php echo js_dateformat(); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/todo-student.js"></script>
<!--  end to do list -->
<!-- jQuery Scrollbar Js start -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>

                                    (function ($) {

                                        $(window).load(function () {

                                            $(".xe-widget.xe-counter-block .xe-lower.scroll-bar-box").mCustomScrollbar({
                                                theme: "inset-2-dark",
                                                axis: "yx",
                                                advanced: {
                                                    autoExpandHorizontalScroll: true
                                                },
                                                /* change mouse-wheel axis on-the-fly */
                                                callbacks: {
                                                    // onOverflowY:function(){
                                                    //  var opt=$(this).data("mCS").opt;
                                                    //  if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
                                                    // },
                                                    onOverflowX: function () {
                                                        var opt = $(this).data("mCS").opt;
                                                        if (opt.mouseWheel.axis !== "x")
                                                            opt.mouseWheel.axis = "x";
                                                    },
                                                }
                                            });
                                            $(".eventCalendar-list-content").mCustomScrollbar({
                                                theme: "inset-2-dark",
                                                axis: "yx",
                                                advanced: {
                                                    autoExpandHorizontalScroll: true
                                                },
                                                /* change mouse-wheel axis on-the-fly */
                                                callbacks: {
                                                    onOverflowY: function () {
                                                        var opt = $(this).data("mCS").opt;
                                                        if (opt.mouseWheel.axis !== "y")
                                                            opt.mouseWheel.axis = "y";
                                                    },
                                                    // onOverflowX: function() {
                                                    // var opt = $(this).data("mCS").opt;
                                                    // if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
                                                    // },
                                                }
                                            });
                                        });
                                        $("#content-1").mCustomScrollbar({
                                            theme: "inset-2-dark",
                                            axis: "yx",
                                            advanced: {
                                                autoExpandHorizontalScroll: true
                                            },
                                            /* change mouse-wheel axis on-the-fly */
                                            callbacks: {
                                                onOverflowY: function () {
                                                    var opt = $(this).data("mCS").opt;
                                                    if (opt.mouseWheel.axis !== "y")
                                                        opt.mouseWheel.axis = "y";
                                                },
                                                onOverflowX: function () {
                                                    var opt = $(this).data("mCS").opt;
                                                    if (opt.mouseWheel.axis !== "x")
                                                        opt.mouseWheel.axis = "x";
                                                },
                                            }
                                        });

                                        $(".panel-body .todo-widget .todo-list1").mCustomScrollbar({
                                            theme: "inset-2-dark",
                                            axis: "yx",
                                            advanced: {
                                                autoExpandHorizontalScroll: true
                                            },
                                            /* change mouse-wheel axis on-the-fly */
                                            callbacks: {
                                                onOverflowY: function () {
                                                    var opt = $(this).data("mCS").opt;
                                                    if (opt.mouseWheel.axis !== "y")
                                                        opt.mouseWheel.axis = "y";
                                                },
                                                // onOverflowX: function() {
                                                //     var opt = $(this).data("mCS").opt;
                                                //     if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
                                                // },
                                            }
                                        });
                                        $(".panel-body .vital-stats .growth-list").mCustomScrollbar({
                                            theme: "inset-2-dark",
                                            axis: "yx",
                                            advanced: {
                                                autoExpandHorizontalScroll: true
                                            },
                                            /* change mouse-wheel axis on-the-fly */
                                            callbacks: {
                                                onOverflowY: function () {
                                                    var opt = $(this).data("mCS").opt;
                                                    if (opt.mouseWheel.axis !== "y")
                                                        opt.mouseWheel.axis = "y";
                                                },
                                                // onOverflowX: function() {
                                                //     var opt = $(this).data("mCS").opt;
                                                //     if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
                                                // },
                                            }
                                        });
                                    })(jQuery);
</script>
<!-- Scrollbar Js end -->


<!-- Event Calendar Js start -->
<script>
    $(document).ready(function () {

        show_event_detail_on_load();
        //show_first_event_details();

        $('.eventCalendar-arrow').on('click', function () {
            $('.eventCalendar-monthTitle').on('click', function () {
                $('.eventCalendar-list li:first-child').each(function (index) {
                    console.log($(this).text());
                    show_event_detail_on_load();
                });
            });
            $('.eventCalendar-day').on('click', function () {
                show_event_detail_on_load();
            });
            //show_event_detail_on_load();
            setTimeout(function () {
                $('.eventCalendar-list li:first-child').each(function (index) {
                    console.log($(this).text());
                    $('div.eventCalendar-hidden', this).removeClass('eventCalendar-hidden');
                });
            }, 1000);
        });
        $('.eventCalendar-monthTitle').on('click', function () {
            show_event_detail_on_load();
        });
        $('.eventCalendar-day').on('click', function () {
            show_event_detail_on_load();
        });
        function show_first_event_details() {
            $('.eventCalendar-day').on('click', function () {
                $('.eventCalendar-eventDesc').css('display', 'block');
                setTimeout(function () {
                    $('.eventCalendar-hidden').removeClass('eventCalendar-hidden');
                }, 1000);
            });
        }

        function show_event_detail_on_load() {
            setTimeout(function () {
                $('.eventCalendar-list li:first-child').each(function (index) {
                    console.log($(this).text());
                    $('div.eventCalendar-hidden', this).removeClass('eventCalendar-hidden');
                });
            }, 1000);
        }
    });
</script>
<!-- Event Calendar Js end -->

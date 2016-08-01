<!DOCTYPE html>
<html class=no-js>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?> | <?php echo system_name(); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Import google fonts - Heading first/ text second -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel=stylesheet type=text/css>
        <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel=stylesheet type=text/css>
        <!-- Css files -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/event_calendar/eventCalendar.css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/event_calendar/eventCalendar_theme_responsive.css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.mCustomScrollbar.min.css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.min.css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/plugins.css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css"/>

        <!-- JS Files -->
        <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>

        <!-- Fav and touch icons -->
        <link rel=apple-touch-icon-precomposed sizes=144x144 href=<?php echo base_url(); ?>assets/img/ico/apple-touch-icon-144-precomposed.png>
        <link rel=apple-touch-icon-precomposed sizes=114x114 href=<?php echo base_url(); ?>assets/img/ico/apple-touch-icon-114-precomposed.png>
        <link rel=apple-touch-icon-precomposed sizes=72x72 href=<?php echo base_url(); ?>assets/img/ico/apple-touch-icon-72-precomposed.png>
        <link rel=apple-touch-icon-precomposed href=<?php echo base_url(); ?>assets/img/ico/apple-touch-icon-57-precomposed.png>
        <link rel=icon href=<?php echo base_url(); ?>assets/img/ico/favicon.ico type=image/png>
        <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
        <meta name=msapplication-TileColor content="#3399cc">
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>
        <style>                
            .notification2 {
                background: #ed7a53 none repeat scroll 0 0;
                border-radius: 2px;
                box-shadow: 0 1px 0 0 rgba(0, 0, 0, 0.2);
                color: #fff;
                font-family: Tahoma;
                font-size: 12px;
                font-weight: 700;
                padding: 0 7px;
                position: relative;
                right: 10px;
                text-shadow: none;
                top: 11px;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="<?php echo $this->router->fetch_method(); ?>" style="min-height: 100%">
        <!--[if lt IE 9]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]--><!-- .#header -->
        <div id="header">
            <nav class="navbar navbar-default" role=navigation>
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo base_url(); ?>admin">
                        <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="logo">
                    </a>
                </div>
                <div id="navbar-no-collapse" class="navbar-no-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <!--Sidebar collapse button-->
                            <a href=# class="collapseBtn leftbar"><i class="fa fa-bars" aria-hidden="true"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="<?php echo base_url(); ?>email_inbox">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span class=txt>Messages</span>
                            </a>

                        </li>
                    </ul>
                    <ul class="nav navbar-right usernav">
                        <li class="dropdown">
                            <a href=# class="dropdown-toggle" data-toggle=dropdown>
                                <i class="fa fa-globe" aria-hidden="true"></i>
                                <?php  if($this->session->userdata('notifications')['total_notification'] > 0){ ?>   <span class="notification"><?php echo $this->session->userdata('notifications')['total_notification']; ?></span><?php } ?>
                            </a>
                            <ul class="dropdown-menu right">
                                <li class=menu>
                                     <ul class=notif>
                                            <li class=header><strong>Notifications</strong> (<?php echo $this->session->userdata('notifications')['total_notification']; ?>) items</li>
                                            <?php if (isset($this->session->userdata('notifications')['fees_structure'])) { ?>
                                                <li><a href="<?php echo base_url('student/student_fees'); ?>"><span class=icon>
                                                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                                                        </span> <span class=event> New fee structure was added.</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (isset($this->session->userdata('notifications')['exam_manager']) || isset($this->session->userdata('notifications')['exam_time_table'])) { ?>
                                                <li><a href="<?php echo base_url('student/exam_listing'); ?>"><span class=icon><i class="s16 fa fa-commenting"></i></span> <span class=event>New Exam or Exam schedule was added.</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (isset($this->session->userdata('notifications')['assignment_manager'])) { ?>
                                                <li><a href="<?php echo base_url('assignment/submission'); ?>"><span class=icon><i class="s16 fa fa-newspaper-o"></i></span> <span class=event>New Assignment was added.</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (isset($this->session->userdata('notifications')['project_manager'])) { ?>
                                                <li><a href="<?php echo base_url('project/submission'); ?>"><span class=icon><i class="s16 fa fa-newspaper-o"></i></span> <span class=event>New Project was added.</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (isset($this->session->userdata('notifications')['marks_manager'])) { ?>
                                                <li><a href="<?php echo base_url('student/exam_marks'); ?>"><span class=icon><i class="s16 fa fa-newspaper-o"></i></span> <span class=event>Exam marks was added.</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (isset($this->session->userdata('notifications')['participate_manager'])) { ?>
                                                <li><a href="<?php echo base_url('participate/volunteer'); ?>"><span class=icon><i class="s16 fa fa-newspaper-o"></i></span> <span class=event>New Participate was added.</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (isset($this->session->userdata('notifications')['study_resources'])) { ?>
                                                <li><a href="<?php echo base_url('student/studyresources'); ?>"><span class=icon><i class="s16 fa fa-newspaper-o"></i></span> <span class=event>New Study Resources was added.</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (isset($this->session->userdata('notifications')['library_manager'])) { ?>
                                                <li><a href="<?php echo base_url('student/digitallibrary'); ?>"><span class=icon><i class="s16 fa fa-newspaper-o"></i></span> <span class=event>New Digital Library was added.</span></a>
                                                </li>
                                            <?php } ?>
                               
                                        </ul>
                                </li>
                            </ul>
                        </li>
                        <li class=dropdown>
                            <?php $this->load->model('user/User_model');
                            $user_id = $this->session->userdata('user_id');
                            $user = $this->User_model->get($user_id);
                            ?>
                            <a href=# class="dropdown-toggle avatar" data-toggle=dropdown><img src=<?php echo base_url().'system_image/'.$user->profile_pic; ?> alt="" class="image"> 
                                <span class=txt><?php echo $user->first_name.' '.$user->last_name; ?></span> <b class=caret></b>
                            </a>
                            <ul class="dropdown-menu right">
                                <li class=menu>
                                    <ul>
                                        <li>
                                            <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard" aria-hidden="true"></i>Home</a>
                                        </li>
<<<<<<< HEAD
                                        <li><a href="<?php echo base_url(); ?>manage_profile">
=======
                                        <li><a href="<?php echo base_url(); ?>profile">
>>>>>>> a54931c7c290e228035a431bb36cb115c8e192c3
                                                <i class="fa fa-user" aria-hidden="true"></i>Edit profile</a>
                                        </li>
                                        <li><a href="<?php echo base_url(); ?>user/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url(); ?>user/logout">
                                <i class="fa fa-sign-out" aria-hidden="true"></i><span class=txt>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.nav-collapse -->
            </nav>
            <!-- /navbar -->
        </div>
        <!-- / #header -->
        <div id=wrapper>
            <!-- #wrapper --><!--Sidebar background-->
            <div id=sidebarbg class="hidden-lg hidden-md hidden-sm hidden-xs"></div>
            <!--Sidebar content-->
            <div id="sidebar" class="page-sidebar hidden-lg hidden-md hidden-sm hidden-xs">
                <div class=shortcuts>
                    <ul>
                        <li><a href="<?php echo base_url(); ?>system_settings" title="System Settings" class=tip>
                                <i class="fa fa-life-ring" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li><a href="<?php echo base_url(); ?>backup" title="Database backup" class=tip>
                                <i class="fa fa-database" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li><a href="<?php echo base_url(); ?>report_chart" title="Reports" class=tip>
                                <i class="fa fa-pie-chart" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li><a href="<?php echo base_url(); ?>manage_profile" title="Profile" class=tip>
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End search -->
                <!-- Start .sidebar-inner -->
                <div class=sidebar-inner>
                    <!-- Start .sidebar-scrollarea -->
                    <div class=sidebar-scrollarea>
                        <div class=sidenav>
                            <div class="sidebar-widget mb0">
                                <h6 class="title mb0">Navigation</h6>
                            </div>
                            <!-- End .sidenav-widget -->
                            <div class=mainnav>
                                <ul>
                                    <li>
                                        <a <?php echo active_single_menu('dashboard', $page); ?> href="<?php echo base_url(); ?>student/dashboard">
                                            <i class="s16 fa fa-dashboard"></i>
                                            <span class="txt">Dashboard</span>
                                            <span class="indicator"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo active_single_menu('class_routine', $page); ?> href="<?php echo base_url(); ?>student/class_routine">
                                            <i class="fa fa-list" aria-hidden="true"></i>
                                            <span class=txt>Class Routine</span>
                                        </a>
                                    </li>
                                    <li>
                                            <a <?php echo active_single_menu('attendance_report', $page); ?> href="<?php echo base_url(); ?>student/attendance_report">
                                                <i class="fa fa-bars" aria-hidden="true"></i>
                                                <span class=txt>Attendance Report</span>
                                            </a>
                                    </li>
                                    <li>
                                            <a <?php echo active_single_menu('syllabus', $page); ?> href="<?php echo base_url(); ?>syllabus">
                                                <i class="fa fa-code" aria-hidden="true"></i>
                                                <span class=txt>Syllabus</span>
                                            </a>
                                    </li>
                                    <li>
                                            <a <?php echo active_single_menu('assignment', $page); ?> href="<?php echo base_url(); ?>assignment/submission"><i class="s16 fa fa-table"></i><span class="txt">Assignments </span>
                                            </a>
                                        </li>
                                    <li>
                                            <a <?php echo active_single_menu('project', $page); ?> href="<?php echo base_url(); ?>project/submission/"><i class="s16 icomoon-icon-cube"></i><span class="txt">Projects </span>
                                            </a>
                                    </li>
                                    <li>
                                            <a <?php echo active_single_menu('video_streaming', $page); ?> href="<?php echo base_url(); ?>video_streaming"><i class="s16 fa fa-video-camera"></i><span class=txt>Video Streaming </span>
                                            </a>
                                    </li>
                                    <li>
                                            <a <?php echo active_single_menu('exam', $page); ?> href="<?php echo base_url(); ?>exam"><i class="s16 fa fa-picture-o"></i>
                                                <span class=txt>Exam</span>
                                            </a>
                                        </li>
                                    <li>
                                        <a <?php echo active_single_menu('exam_marks', $page); ?> href="<?php echo base_url(); ?>student/exam_marks">
                                                <i class="s16 fa fa-clock-o"></i>
                                              <span class=txt>Exam Marks</span>
                                        </a>
                                    </li> 
                                    <li>
                                        <a <?php echo active_single_menu('student_fees', $page); ?> href="<?php echo base_url(); ?>payment/student_fees"><i class="s16 fa fa-money"></i>
                                                <span class=txt>Pay Online </span>
                                        </a>
                                    </li> 
                                    <li>
                                            <a <?php echo active_single_menu('fees_record', $page); ?> href="<?php echo base_url(); ?>feerecord"><i class="s16 fa fa-newspaper-o"></i><span class=txt>Fee Record </span>
                                            </a>
                                        </li>                                        
                                        <li>
<<<<<<< HEAD
                                            <a <?php echo active_single_menu('holiday', $page); ?> href="<?php echo base_url(); ?>student/holiday">
=======
                                            <a <?php echo active_single_menu('holiday', $page); ?> href="<?php echo base_url(); ?>/holiday">
>>>>>>> a54931c7c290e228035a431bb36cb115c8e192c3
                                                <i class="s16 fa fa-calendar"></i>
                                                <span class=txt>Holiday </span>
                                            </a>
                                        </li>                                           
                                        <li>
                                            <a <?php echo active_single_menu('courseware', $page); ?> href="<?php echo base_url(); ?>courseware">
                                                <i class="s16 fa fa-file-o"></i>
                                                <span class=txt>Courseware</span>
                                            </a>
                                        </li>
                                        <li>
<<<<<<< HEAD
                                            <a <?php echo active_single_menu('vocational_course', $page); ?> href="<?php echo base_url(); ?>student/vocationalcourse">
=======
                                            <a <?php echo active_single_menu('vocational_course', $page); ?> href="<?php echo base_url(); ?>vocationalcourse">
>>>>>>> a54931c7c290e228035a431bb36cb115c8e192c3
                                                <i class="s16 fa fa-spinner"></i>
                                                <span class=txt>Vocational Course</span>
                                            </a>
                                        </li>
                                        <li>
<<<<<<< HEAD
                                            <a <?php echo active_single_menu('gallery', $page); ?> href="<?php echo base_url(); ?>student/gallery"><i class="s16 fa fa-picture-o"></i>
                                                <span class=txt>Gallery </span>
                                            </a>
                                        </li>  
=======
                                            <a <?php echo active_single_menu('gallery', $page); ?> href="<?php echo base_url(); ?>media/photo_gallery"><i class="s16 fa fa-picture-o"></i>
                                                <span class=txt>Gallery </span>
                                            </a>
                                        </li> 
                                        <?php
                                    $pages = [
                                        'quiz', 'questions', 'result', 'quiz_history'
                                    ];
                                    ?>

                                    <li class="hasSub<?php echo highlight_menu($page, $pages); ?>">
                                        <a href="#" class="<?php echo exapnd_not_expand_menu($page, $pages); ?>"><i class="icomoon-icon-arrow-down-2 s16 hasDrop"></i><i class="s16 fa fa-book"></i>
                                            <span class="txt">Quiz</span></a>
                                        <ul <?php echo navigation_show_hide_ul($page, $pages); ?>>
                                            <li>
                                                <a id="link-role" href="<?php echo base_url(); ?>quiz">
                                                    <i class="s16 fa fa-list"></i>
                                                    <span class="menu-text">Quiz</span>  
                                                </a>
                                            </li>
                                            <li >
                                                <a id="link-user" href="<?php echo base_url(); ?>quiz/user-quiz-history">
                                                    <i class="s16 fa fa-desktop"></i>
                                                    <span class="menu-text">Quiz History</span>  
                                                </a>
                                            </li>  
                                        </ul>
                                    </li>
     
>>>>>>> a54931c7c290e228035a431bb36cb115c8e192c3
                                        <?php
                                        $news_conent = $this->db->get_where('cms_manager', array('c_status' => 1))->result_array();
                                        foreach ($news_conent as $row) {
                                            ?>
                                            <li>
                                                <a <?php echo active_single_menu($row['c_slug'], $page); ?> href="<?php echo base_url(); ?>pages/<?php echo @$row['c_slug']; ?>">
                                                    <i class="s16 fa fa-universal-access"></i>
                                                    <span class=txt><?php echo @$row['c_title']; ?> </span>
                                                </a>
                                            </li>
                                        <?php } ?>
                            </div>
                        </div>
                        <!-- End sidenav -->

                        <!-- End .sidenav-widget -->
                    </div>
                    <!-- End .sidebar-scrollarea -->
                </div>
                <!-- End .sidebar-inner -->
            </div>
            <!-- End #sidebar --><!--Sidebar background-->


            <!-- End #right-sidebar --><!--Body content-->
            <div id=content class="page-content clearfix">
                <div class=contentwrapper>
                    <!--Content wrapper-->
                    <div class=heading>
                        <!--  .heading-->
                        <h3><?php echo $title; ?></h3>
                        <div class=resBtnSearch><a href=#><span class="s16 icomoon-icon-search-3"></span></a></div>
                        <div class="search_box">
                            <!-- .search -->
                            <form id=searchform class=form-horizontal method="post" action="<?php echo base_url(); ?>search">
                                <input name="search" class="top-search from-control" placeholder="Search here ..."
                                       value="<?php echo isset($search_string) ? $search_string : ''; ?>"> 
                                <input type=submit class=search-btn>
                                <div class="category">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
                                        Category                                     
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li class="menu">
                                            <ul>
                                                <li>
                                                    <label>
                                                        <input type="checkbox" value="student" name="student"
                                                               <?php if (isset($from['student'])) echo 'checked'; ?>>
                                                        <span>Student</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label>
                                                        <input type="checkbox" value="course" name="course"
                                                               <?php if (isset($from['course'])) echo 'checked'; ?>>
                                                        <span>Branch</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label>
                                                        <input type="checkbox" value="exam" name="exam"
                                                               <?php if (isset($from['exam'])) echo 'checked'; ?>>
                                                        <span>Exam</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label>
                                                        <input type="checkbox" value="event" name="event"
                                                               <?php if (isset($from['event'])) echo 'checked'; ?>>
                                                        <span>Event</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label>
                                                        <input type="checkbox" value="assignment" name="assignment"
                                                               <?php if (isset($from['assignment'])) echo 'checked'; ?>>
                                                        <span>Assignment</span>
                                                    </label>
                                                </li>
                                            </ul>                                           
                                        </li>
                                    </ul> 
                                </div>
                            </form>
                        </div>                           
                        <!--  /search -->     

                        <?php echo create_breadcrumb(); ?>
                        <?php echo set_active_menu($page); ?>
                    </div>
                    <!-- End  / heading-->
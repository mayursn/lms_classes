<!DOCTYPE html>
<!--[if lt IE 8]><html class="no-js lt-ie8"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=no-js>
    <!--<![endif]-->
    <html class=no-js>

        <head>
            <meta charset=utf-8>
            <title><?php echo $title; ?></title>
            <!-- Mobile specific metas -->
            <meta name=viewport content="width=device-width,initial-scale=1,maximum-scale=1">
            <!-- Force IE9 to render in normal mode -->
            <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
            <meta name=author content="">
            <meta name=description content="">
            <meta name=keywords content="">
            <meta name=application-name content="">
            <!-- Import google fonts - Heading first/ text second -->
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel=stylesheet type=text/css>
            <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel=stylesheet type=text/css>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
            <!-- Css files -->
            <link rel=stylesheet href="<?php echo base_url(); ?>assets/css/main.min.css">
            <!-- Fav and touch icons -->
            <link rel=apple-touch-icon-precomposed sizes=144x144 href=<?php echo base_url(); ?>assets/img/ico/apple-touch-icon-144-precomposed.png>
            <link rel=apple-touch-icon-precomposed sizes=114x114 href=<?php echo base_url(); ?>assets/img/ico/apple-touch-icon-114-precomposed.png>
            <link rel=apple-touch-icon-precomposed sizes=72x72 href=<?php echo base_url(); ?>assets/img/ico/apple-touch-icon-72-precomposed.png>
            <link rel=apple-touch-icon-precomposed href=<?php echo base_url(); ?>assets/img/ico/apple-touch-icon-57-precomposed.png>
            <link rel=icon href=<?php echo base_url(); ?>assets/img/ico/favicon.ico type=image/png>
            <meta name=msapplication-TileColor content="#3399cc">
        </head>

        <body class="login-page user_login">
            <div id=header class="animated fadeInDown">
                <div class=row>
                    <div class=navbar>
                        <div class="container text-center">
                            <a class=navbar-brand href="#">
                                <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="logo">
                            </a>
                        </div>
                    </div>
                    <!-- /navbar -->
                </div>
                <!-- End .row -->
            </div>
            <!-- End #header -->
            <!-- Start login container -->

            <div class="container login-container">

                <div class="login-panel panel panel-default plain animated bounceIn">

                    <!-- Start .panel -->

                    <div class=panel-body>
                        <h3><center>Reset Password</center></h3><br/>
                        <form class="form-horizontal mt0" action="" 
                              id="login-form" role="form" method="post">

                            <div class="form-group">
                                <div class="col-md-12">
                                    <!-- col-md-12 start here -->
                                    <label for="">Password:</label>
                                </div>
                                <!-- col-md-12 end here -->
                                <div class="col-md-12">
                                    <div class="input-group input-icon">
                                        <input type="password" name="password" id="password" class=form-control placeholder="" required=""> 
                                        <span class=input-group-addon>
                                            <i class="fa fa-lock s16"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <!-- col-md-12 start here -->
                                    <label for="">Confirm Password:</label>
                                </div>
                                <!-- col-md-12 end here -->
                                <div class="col-md-12">
                                    <div class="input-group input-icon">
                                        <input type="password" name="confirm_password" id="confirm-password" class=form-control placeholder="" required=""> 
                                        <span class=input-group-addon>
                                            <i class="fa fa-lock s16"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb0">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                                   
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4 mb25">
                                    <button class="btn btn-primary pull-right" type="submit" value="login">Reset Password</button>
                                </div>
                            </div>
                        </form>
                        <div class="seperator"><strong>or</strong><hr></div>
                        <div class="social-buttons text-center mt5 mb5">
                            <a href="<?php echo base_url('user/login'); ?>">Back to Login</a>   
                        </div>

                        <?php
                        $flash_message = $this->session->flashdata('message');
                        $type = $this->session->flashdata('type');
                        if ($type && $flash_message) {
                            ?>
                            <div class="alert alert-<?php echo $type; ?>">
                                <button class="close" data-dismiss="alert">&times;</button>
                                <p><?php echo $flash_message; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- End .panel -->
            </div>
            <!-- End login container -->
            <div class=container>
                <div class=footer>
                    <p class=text-center>Copyrights &copy; 2016 <a href="#" class="color-blue strong" target=_blank>Lore Brain</a>. All rights reserved.</p>
                </div>
            </div>

            <!-- Javascripts -->
            <!-- Load pace first -->
            <script src=<?php echo base_url(); ?>assets/plugins/core/pace/pace.min.js></script>
            <!-- Important javascript libs(put in all pages) -->
            <script src=<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js></script>
            <script>
                window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/libs/jquery-2.1.1.min.js">\x3C/script>')
            </script>
            <script src=<?php echo base_url(); ?>assets/js/jquery-ui.js></script>
            <script>
                window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/libs/jquery-ui-1.10.4.min.js">\x3C/script>')
            </script>
            <script src=<?php echo base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js></script>
            <script>
                window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/libs/jquery-migrate-1.2.1.min.js">\x3C/script>')
            </script>
            <!--[if lt IE 9]>
      <script type="text/javascript" src="assets/js/libs/excanvas.min.js"></script>
      <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <script type="text/javascript" src="assets/js/libs/respond.min.js"></script>
    <![endif]-->
            <script src=<?php echo base_url(); ?>assets/js/pages/dashboard.js></script>

            <!-- Modal -->
            <div id="forgot-password" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Forgot Password</h4>
                        </div>
                        <form class="form-horizontal" action="<?php echo base_url(); ?>site/forgot_password" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-8">
                                        <input required="" type="email" class="form-control" name="email" />
                                    </div>
                                </div>	
                            </div>
                            <div class="modal-footer">
                                <input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </body>
    </html>

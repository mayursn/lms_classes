
<!DOCTYPE html>
<!--[if lt IE 8]>
<html class="no-js lt-ie8">
   <![endif]--><!--[if gt IE 8]><!-->
<html class=no-js>
    <!--<![endif]-->
    <html class=no-js>
        <head>
            <meta charset=utf-8>
            <title><?php echo $title; ?> | Learning Management System</title>
            <!-- Mobile specific metas -->
            <meta name=viewport content="width=device-width,initial-scale=1,maximum-scale=1">
            <!-- Force IE9 to render in normal mode --><!--[if IE]>
            <meta http-equiv="x-ua-compatible" content="IE=9" />
            <![endif]-->
            <meta name=author content="">
            <meta name=description content="">
            <meta name=keywords content="">
            <meta name=application-name content="">
            <!-- Import google fonts - Heading first/ text second -->
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel=stylesheet type=text/css>
            <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel=stylesheet type=text/css>
            <!-- Css files -->
            <link rel=stylesheet href=<?php echo base_url(); ?>assets/css/main.min.css>

            <!-- jQuery -->
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
        </head>
        <body>

            <div class=col-md-12>
                <!-- col-md-12 start here -->
                <div class="panel panel-default invoice">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left"><span>Invoice Details</span></h4>
                        <div class=print><a href=# class=tip title="Print invoice"><i class="s24 icomoon-icon-print"></i></a></div>
                        <div class=invoice-info>
                            <span class=number>Invoice <strong class=color-red>#<?php echo 'INV-' . date('dmYhis', strtotime($invoice->paid_created_at)); ?></strong></span> <span class="data color-gray"><?php echo date('M d, Y'); ?></span>
                            <div class=clearfix></div>
                        </div>
                    </div>
                    <div class=panel-body>
                        <div class=you>
                            <ul class=list-unstyled>
                                <li>
                                    <h3>Lore Brain</h3>
                                </li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Address:</strong> 207, campus corner 2 , Opp. Prahladnagar Garden, <br/><span style="margin-left: 25px;"></span>Anandnagar road, Prahladnagar, Ahmedabad 380015</li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>City: </strong>Ahmedabad</li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Region/State: </strong>Gujarat</li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Zip/Postal Code: </strong>380015</li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Phone:</strong> <strong class=color-red>+919909978808</strong></li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Email: </strong> <strong class=color-red>sales@searchnative.in</strong></li>
                            </ul>
                        </div>
                        <div class=client>
                            <ul class=list-unstyled>
                                <li>
                                    <h3>Student Details</h3>
                                </li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Student Name:</strong> <?php echo $invoice->std_first_name . ' ' . $invoice->std_last_name; ?></li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Email: </strong><?php echo $invoice->email; ?><br></li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Mobile: </strong><?php echo $invoice->std_mobile; ?></li>
                                <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Outstanding Amount: </strong><?php echo system_info('currency') . $due_amount; ?></li>
                            </ul>
                        </div>
                        <div class=clearfix></div>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:20px;">SR</th>
                                    <th>TITLE</th>
                                    <th>MODE OF PAYMENT</th>
                                    <th class="text-right" style="width:120px;">AMOUNT</th>
                                    <th class="text-right" style="width:120px;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>                                               
                                <tr>
                                    <td class="text-center">1</td>
                                    <td><?php echo $invoice->title; ?></td>
                                    <td>
                                        <?php
                                        if ($invoice->payment_type == 'cheque')
                                            echo 'Cheque';
                                        else
                                            echo 'Online Banking';
                                        ?>
                                    </td>
                                    <td class="text-left"><?php echo system_info('currency') . $invoice->paid_amount; ?></td>
                                    <td class="text-right"><?php echo system_info('currency') . $invoice->paid_amount; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class=payment>

                        </div>
                        <div class=total>
                            <h4>Total amount:<span class=color-red> <?php echo system_info('currency') . $invoice->paid_amount; ?></span></h4>
                        </div>
                        <div class=clearfix></div>
                        <div class=invoice-footer style="visibility: hidden">
                            <p>Thank you for your order, you will receive <strong class=color-green>5%</strong> discount in next order.</p>
                        </div>
                    </div>
                </div>
                <!-- End .panel -->
            </div>
            <!-- col-md-12 end here -->

            <script src=<?php echo base_url(); ?>assets/plugins/core/pace/pace.min.js></script>

            <!-- Important javascript libs(put in all pages) -->
            <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
            <!--[if lt IE 9]>
                <script type="text/javascript" src="js/libs/excanvas.min.js"></script>
                <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <script type="text/javascript" src="js/libs/respond.min.js"></script>
                <![endif]-->

            <script src="<?php echo base_url(); ?>assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js"></script>

            <script src="<?php echo base_url(); ?>assets/plugins/forms/bootstrap-timepicker/bootstrap-timepicker.js"></script>
            <script src="<?php echo base_url(); ?>assets/plugins/forms/select2/select2.js"></script>
            <script src="<?php echo base_url(); ?>assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js"></script>
            <script src="<?php echo base_url(); ?>assets/plugins/forms/summernote/summernote.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/pages/forms-validation.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/pages/tables-data.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
        </body>
    </html>
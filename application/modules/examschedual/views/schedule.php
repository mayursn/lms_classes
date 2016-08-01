<style>    
    .tab_Det_left tr td, .tab_Det_left tr th{text-align: left !important;}
</style>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title><?php echo $title; ?></h4>
                            <div class="panel-controls panel-controls-right">
                                <a class="panel-refresh" href="#"><i class="fa fa-refresh s12"></i></a>
                                <a class="toggle panel-minimize" href="#"><i class="fa fa-plus s12"></i></a>
                                <a class="panel-close" href="#"><i class="fa fa-times s12"></i></a>
                            </div>
                        </div>-->
            <div class=panel-body>
                <table class="table table-condensed ex1">
                    <thead>
                        <tr>
                            <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Exam Name: </strong></td>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo @$exam_details->em_name; ?></td>
                            <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Year: </strong></td>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo @$exam_details->em_year; ?></td>
                        </tr>
                        <tr>
                            <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Semester: </strong></td>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo @$exam_details->admission_duration; ?></td>
                            <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Course Name: </strong></td>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo @$exam_details->c_name; ?></td>
                        </tr> 
                        <tr>
                            <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Total Marks: </strong></td>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo @$exam_details->total_marks; ?></td>
                            <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Passing Marks: </strong></td>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo @$exam_details->passing_mark; ?></td>
                        </tr>
                        <tr>
                            <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Seat No: </strong></td>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo @$exam_details->seat_no; ?></td>
                            <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4">&nbsp;</td>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                        </tr>
                    </thead>                            
                </table>

                <table class="table table-bordered table-striped tab_Det_left" style="">
                    <tr>
                        <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            No
                        </th>
                        <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            Subject
                        </th>
                        <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            Date
                        </th>
                        <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            Time
                        </th>
                    </tr>
                    <?php            
                    $counter = 1;
                    foreach ($time_table as $row) { ?>
                    
                    <tr>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <?php echo $counter++; ?>
                        </td>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <?php echo $row->subject_name; ?>
                        </td>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <?php echo date_formats($row->exam_date); ?>
                        </td>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                           <?php echo date('h:i A', strtotime(date('Y-m-d') . $row->exam_start_time)) ?>
                        </td>
                    </tr>                    
                    
                    <?php } ?>
                    
                </table>
                
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
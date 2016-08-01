<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">           
            <div class=panel-body>                
                <div id="student-attendance-list">
                    <div class="col-md-12">          
                        <h4>Class Routine Details</h4>
                        <table class="table table-condensed ex1">
                            <tr>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Branch</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $branch_name->branch_name; ?></td>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Course</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $course_name->c_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Admission Plan</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $admission_duration->admission_duration; ?></td>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Class</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $class_name->class_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Subject</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo $subject_name->subject_name; ?></td>
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Date</strong></td>
                                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php echo date('M d, Y', strtotime($date)); ?></td>
                            </tr>
                            <tr style="display: none;">
                                <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Time</strong></td>
                                <td colspan="3" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <?php //echo date('h:i A', strtotime($start_time)) . ' - ' . date('h:i A', strtotime($end_time)); ?>
                                </td>
                            </tr>
                        </table>
                        <?php if (count($student)) { ?>
                            <?php
                            $this->load->model('admin/Crud_model');
                            ?>
                            <br/>
                            <form method="post" action="<?php echo base_url(); ?>attendance/take_class_routine_attendance"
                                  class="form-groups-bordered">
                                <input type="hidden" name="branch" value="<?php echo $branch_name->branch_id; ?>"/>
                                <input type="hidden" name="course" value="<?php echo $course_name->course_id; ?>"/>
                                <input type="hidden" name="admission_plan" value="<?php echo $admission_duration->admission_plan_id; ?>"/>
                                <input type="hidden" name="class" value="<?php echo $class_name->class_id; ?>"/>                                                                                                
                                <input type="hidden" name="date" value="<?php echo $date; ?>"/>
                                <input type="hidden" name="subject" value="<?php echo $subject_name->sm_id; ?>"/>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4>Student List</h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">                                        
                                        <table class="table table-striped table-bordered table-responsive" id="attendance-data-table-2">
                                            <thead>
                                            <th>No</th>
                                            <th>Roll No</th>
                                            <th>Student Name</th>
                                            <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $counter = 1;
                                                $date = date('Y-m-d', strtotime($date));
                                                foreach ($student as $row) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $counter++; ?></td>
                                                        <td><?php echo $row->std_roll; ?></td>
                                                        <td><?php echo $row->std_first_name . ' ' . $row->std_last_name; ?></td>
                                                        <?php
                                                        $status = $this->Crud_model->check_attendance_status($branch_name->branch_id, $course_name->course_id, $admission_duration->admission_plan_id, $class_name->class_id, $date, $row->std_id);
                                                        ?>
                                                        <td>
                                                            <?php if (isset($status)) { ?>
                                                                <input type="checkbox" name="student_<?php echo $row->std_id; ?>" 
                                                                       <?php if ($status->is_present == 1) echo 'checked=""'; ?>/>
                                                                   <?php } else { ?>
                                                                <input type="checkbox" name="student_<?php echo $row->std_id; ?>" checked=""/>
                                                            <?php }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                            <div class="form-group">
                                <input type="submit" value="Submit" class="btn btn-info"/>
                                </div>
                                        </table>
                                    </div>
                                </div>
                                
                            </form>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
<!-- End contentwrapper -->
</div>
<!-- End #content -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var js_format = '<?php echo js_dateformat(); ?>';
        $('#class-routine-list').DataTable({});
        "use strict";       

        $("#attendance-routine").validate({
            rules: {
                'department': "required",
                'branch': "required",
                'batch': "required",
                'semester': "required",
                'class': "required",
                'date': "required",
                'class_routine': "required",
            },
            messages: {
                'department': "Select department",
                'branch': "Select branch",
                'batch': "Select batch",
                'semester': "Select semester",
                'class': "Select class",
                'date': "Select date",
                'class_routine': "Select class routine"
            }
        });
        
        $(".datepicker-normal").datepicker({
            format: js_format,
            todayHighlight: true,
            autoclose: true

        });
    });
</script>
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
                <div class="row filter-row">
                    <form id="attendance-routine" action="#" method="post" class="form-groups-bordered form-horizontal validate">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date<span style="color:red">*</span></label>
                            <div class="col-sm-6">
                                <input id="date" type="text" class="form-control datepicker-normal" name="date" placeholder="Select"
                                       value="<?php echo $date; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-md-offset-2">
                                <input id="search-exam-data" type="submit" value="Submit" class="btn btn-info vd_bg-green"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="student-attendance-list">
                    <div class="col-md-12">
                        <?php if (count($professor_class_routine_list)) { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4>Class Routine List</h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table id="class-routine-list" class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <th>Department</th>
                                                <th>Branch</th>
                                                <th>Semester</th>
                                                <th>Class</th>
                                                <th>Subject</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            foreach ($professor_class_routine_list as $routine) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $counter++; ?></td>
                                                    <td><?php echo $routine->d_name; ?></td>
                                                    <td><?php echo $routine->c_name; ?></td>
                                                    <td><?php echo $routine->s_name; ?></td>
                                                    <td><?php echo $routine->class_name; ?></td>
                                                    <td><?php echo $routine->subject_name; ?></td>                                                    
                                                    <td><?php 
                                                        echo date('h:i A', strtotime($routine->Start)) . ' - ' .
                                                        date('h:i A', strtotime($routine->End));
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $this->load->model('attendance/Attendance_model');
                                                        $status = $this->Attendance_model->class_routine_status($routine->ClassRoutineId, date('Y-m-d', strtotime($date)));
                                                        ?>

                                                        <?php
                                                        if ($status) {
                                                            echo 'Done';
                                                        } else {
                                                            echo 'Pending';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>attendance/take_attedance/<?php echo $routine->ClassRoutineId; ?>/<?php echo date('Y-m-d', strtotime($date)) ?>">
                                                            <span class="label label-primary mr6 mb6">
                                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                Attendance
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">Class Routine List</div>
                                </div>
                                <div class="panel-body">
                                    <table id="class-routine-list" class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <th>Department</th>
                                                <th>Branch</th>
                                                <th>Semester</th>
                                                <th>Class</th>
                                                <th>Subject</th>
                                                <th>Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (count($student)) { ?>
                            <?php
                            $this->load->model('admin/Crud_model');
                            ?>
                            <br/>
                            <form method="post" action="<?php echo base_url(); ?>attendance/take_class_routine_attendance"
                                  class="form-groups-bordered">
                                <input type="hidden" name="department" value="<?php echo $department; ?>"/>
                                <input type="hidden" name="branch" value="<?php echo $branch; ?>"/>
                                <input type="hidden" name="batch" value="<?php echo $batch; ?>"/>
                                <input type="hidden" name="semester" value="<?php echo $semester; ?>"/>
                                <input type="hidden" name="class" value="<?php echo $class_name; ?>"/>
                                <input type="hidden" name="professor" value="<?php echo $professor; ?>"/>
                                <input type="hidden" name="class_routine" value="<?php echo $class_routine; ?>"/>
                                <input type="hidden" name="date" value="<?php echo $date; ?>"/>
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
                                                        $status = $this->Crud_model->check_attendance_status($department, $branch, $batch, $semester, $class_name, $class_routine, $date, $row->std_id);
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
                                        </table>
                                    </div>
                                </div>
                                <input type="submit" value="Submit" class="btn btn-info"/>
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
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
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
  var js_format = '<?php echo js_dateformat(); ?>';
        $(".datepicker-normal").datepicker({
            format: js_format,
            todayHighlight: true,
            autoclose: true

        });
    });
</script>
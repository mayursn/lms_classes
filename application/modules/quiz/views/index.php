<?php
$this->load->model('department/Degree_model');
$this->load->model('branch/Course_model');
$this->load->model('batch/Batch_model');
$this->load->model('semester/Semester_model');
$this->load->model('subject/Subject_manager_model');
?>
<?php
$create = create_permission($permission, 'Quiz');
$read = read_permission($permission, 'Quiz');
$update = update_permisssion($permission, 'Quiz');
$delete = delete_permission($permission, 'Quiz');

function createDateRange($startDate, $endDate, $format = "Y-m-d") {
    $begin = new DateTime($startDate);
    $end = new DateTime($endDate);
    $end = $end->modify('+1 day');
    $interval = new DateInterval('P1D'); // 1 Day
    $dateRange = new DatePeriod($begin, $interval, $end);
    $range = [];
    foreach ($dateRange as $date) {
        $range[] = $date->format($format);
    }

    return $range;
}
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <?php
            if ($this->session->userdata('quiznotification')) {
                ?>
                <div class=panel-heading style="color:red " ><i class="fa fa-exclamation-triangle" style="color:red " aria-hidden="true"></i><?php echo $this->session->userdata('quiznotification'); ?>
                </div>
                <br>
                <?php
            }
            $this->session->unset_userdata('quiznotification');
            ?>

            <div class=panel-body>
                <?php if ($create) { ?>
                    <a href="#" class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/quiz_create');" data-toggle="modal"><i class="fa fa-plus"></i> Quiz</a>
                <?php } ?>
                <?php if ($create || $read || $update || $delete) { ?>
                    <table id="quiz-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Department</th>                            
                                <th>Branch</th>
                                <th>Batch</th>
                                <th>Semester</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <?php if ($update || $delete || $this->session->userdata('std_id')) { ?>
                                    <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $counter = 0; ?>
                            <?php
                            foreach (@$quiz as $row) {
                                $date = array();
                                $date = createDateRange($row->start_date, $row->end_date);
                                ?>
                                <tr>
                                    <td><?php echo ++$counter; ?></td>
                                    <td><?php echo $row->title; ?></td>
                                    <td><?php echo $row->description; ?></td>
                                    <td><?php
                                        if ($row->department_id != "All") {
                                            $name = $this->db->get_where('degree', array("d_id" => $row->department_id))->row()->d_name;
                                            echo $name;
                                        } else {
                                            echo "All";
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        if ($row->branch_id != "All") {
                                            $course = $this->db->get_where('course',array("course_id"=>$row->branch_id))->row()->c_name;
                                            echo $course;
                                        } else {
                                            echo "All";
                                        }
                                        ?></td>
                                    <td><?php
                                        if ($row->batch_id != "All") {
                                            $batch = $this->db->get_where('batch',array("b_id"=>$row->batch_id))->row()->b_name;
                                            echo $batch;
                                        } else {
                                            echo "All";
                                        }
                                        ?></td>
                                    <td><?php
                                        if ($row->semester_id != "All") {
                                            $semester = $this->db->get_where('semester',array("s_id",$row->semester_id))->row()->s_name;
                                            echo $semester;
                                        } else {
                                            echo "All";
                                        }
                                        ?></td>
                                    <td><?php echo $row->start_date; ?></td>
                                    <td><?php echo $row->end_date; ?></td>
                                    <?php if ($update || $delete || $this->session->userdata('std_id')) { ?>
                                        <td>
                                            <?php if (!$this->session->userdata('std_id')) { ?>
                                                <a href="<?php echo base_url(); ?>quiz/quiz_history/<?php echo $row->quiz_id; ?>"><span class="label label-primary mr6 mb6">
                                                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                                        View History
                                                    </span></a>
                                            <?php } ?>

                                            <?php if ($update) { ?>
                                                <a href="<?php echo base_url(); ?>quiz/edit/<?php echo $row->quiz_id; ?>">
                                                    <span class="label label-success mr6 mb6">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                                        Edit
                                                    </span>
                                                </a>
                                            <?php } ?>
                                            <?php
                                            if ($this->session->userdata('std_id')) {
                                                $count = 0;
                                                foreach ($date as $d) {
                                                    if ($d == date('Y-m-d')) {
                                                        $count = 1;
                                                    }
                                                }
                                                if ($count == 1) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>quiz/instruction/<?php echo $row->quiz_id; ?>">
                                                        <span class="label label-info mr6 mb6">
                                                            <i class="fa fa-play " aria-hidden="true"></i>
                                                            Quiz
                                                        </span>
                                                    </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a >
                                                        <span class="label label-info mr6 mb6">
                                                            <i class="fa fa-stop" aria-hidden="true"></i>
                                                            Quiz
                                                        </span>
                                                    </a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php if ($delete) { ?>                                    
                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>quiz/delete/<?php echo $row->quiz_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>	
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>

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

<script>
    $(document).ready(function () {
        $('#quiz-datatable-list').DataTable({});
    })
</script>
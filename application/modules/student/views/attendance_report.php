<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <table id="datatable-list" class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Subject Name</th>
                            <th>Total Class</th>
                            <th>Present Class</th>
                            <th>Attendance in %</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $this->load->model('student/Student_model');
                        foreach ($subjects as $row) { ?>
                            <tr>
                                <td></td>
                                <td><?php echo $row->subject_name; ?></td>
                                <td>
                                    <?php                                   
                                    $total_class = $this->Student_model->total_class_of_subject($row->sm_id,
                                            $this->session->userdata('std_id')); 
                                    echo $total_class;
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    
                                    $total_present = $this->Student_model->total_present_class_of_subject($row->sm_id,
                                            $this->session->userdata('std_id')); 
                                    echo $total_present;
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    $percentage = @number_format((($total_present * 100) / $total_class), 2); 
                                    if(is_numeric($percentage))
                                        echo $percentage;
                                    else
                                        echo '0';
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url(); ?>student/attendance_report_detail/<?php echo $row->sm_id; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i>Details</a>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
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

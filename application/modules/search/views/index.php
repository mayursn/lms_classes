<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <div class=panel-heading>
                <h4 class=panel-title>
                    Search Result for <i>"<?php echo isset($search_string) ? $search_string : ''; ?>"</i>
                </h4>
            </div>
            <div class=panel-body>
                <?php
                if (isset($search_result)) {
                    if (isset($search_result['student']) && count($search_result['student'])) {
                        ?>
                        <table class="table table-bordered table-responsive">
                            <tr>
                                <td colspan="11"><strong>Student Details</strong></td>
                            </tr>
                            <tr>
                                <th>No</th>                                
                                <th>Name</th>
                                <th>Roll No</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Mobile</th>
                                <th>City</th>
                                <th>Birth date</th>
                                <th>Course</th>
                                <th>Admission plan</th>
                               
                            </tr>
                            <?php
                            $isseter = 1;
                            foreach ($search_result['student'] as $student) {
                                ?>
                                <tr>
                                    <td><?php echo $isseter; ?></td>                                    
                                    <td><?php echo $student->std_first_name . ' ' . $student->std_last_name; ?></td>
                                    <td><?php echo $student->std_roll; ?></td>
                                    <td><?php echo $student->email; ?></td>
                                    <td><?php echo $student->std_gender; ?></td>
                                    <td><?php echo $student->std_mobile; ?></td>
                                    <td><?php echo $student->city; ?></td>
                                    <td><?php echo $student->std_birthdate; ?></td>
                                    <td><?php echo $student->c_name; ?></td>
                                    <td><?php echo $student->admission_duration; ?></td>
                                </tr>
                                <?php
                                $isseter++;
                            }
                            ?>
                        </table>
                        <br/>
                        <?php
                    }
                    if (isset($search_result['exam']) && count($search_result['exam'])) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="9"><strong>Exam Details</strong></td>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Exam Name</th>
                                <th>Branch</th>
                                <th>Course</th>
                                <th>Admission Plan</th>                                
                                <th>Exam Type</th>
                                <th>Total Marks</th>
                                <th>Passing Marks</th>
                            </tr>                                
                            <?php
                            $isseter = 1;
                            foreach ($search_result['exam'] as $exam) {
                                ?>
                                <tr>
                                    <td><?php echo $isseter; ?></td>
                                    <td><?php echo $exam->em_name; ?></td>
                                    <td><?php echo $exam->branch_name; ?></td>
                                    <td><?php echo $exam->c_name; ?></td>
                                    <td><?php echo $exam->admission_duration; ?></td>                                    
                                    <td><?php echo $exam->exam_type_name; ?></td>
                                    <td><?php echo $exam->total_marks; ?></td>
                                    <td><?php echo $exam->passing_mark; ?></td>
                                </tr>
                                <?php
                                $isseter++;
                            }
                            ?>
                        </table>
                        <br/>
                        <?php
                    }
                    if (isset($search_result['course']) && count($search_result['course'])) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="5"><strong>Course Details</strong></td>
                            </tr>
                            <tr>
                                <th>No</th>                                
                                <th>Course Name</th>                                                               
                            </tr>
                            <?php
                            $isseter = 1;
                            foreach ($search_result['course'] as $course) {
                                ?>
                                <tr>
                                    <td><?php echo $isseter; ?></td>                                    
                                    <td><?php echo $course->c_name; ?></td>                                                                                                                  
                                </tr>
                                <?php
                                $isseter++;
                            }
                            ?>
                        </table>
                        <br/>
                        <?php
                    }
                    if (isset($search_result['batch']) && count($search_result['batch'])) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4"><strong>Batch Details</strong></td>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Department</th>
                                <th>Batch Name</th>                                        
                            </tr>
                            <?php
                            $isseter = 1;
                            foreach ($search_result['batch'] as $batch) {
                                ?>
                                <tr>
                                    <td><?php echo $isseter; ?></td>
                                    <td><?php echo $batch->d_name; ?></td>
                                    <td><?php echo $batch->b_name; ?></td>                                            
                                </tr>
                                <?php
                                $isseter++;
                            }
                            ?>
                        </table>
                        <br/>
                        <?php
                    }
                    if (isset($search_result['assignment']) && count($search_result['assignment'])) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="9"><strong>Assignment Details</strong></td>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Department</th>
                                <th>Branch</th>
                               <th>Subject</th>
                                <th>Semester</th>
                                <th>Date</th>
                                <th>File</th>
                            </tr>
                            <?php
                            $counter = 1;
                            foreach ($search_result['assignment'] as $assignment) {
                                ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $assignment->assign_title; ?></td>
                                    <td><?php echo $assignment->assign_desc; ?></td>
                                    <td><?php echo $assignment->d_name; ?></td>
                                    <td><?php echo $assignment->c_name; ?></td>
                                    <td><?php echo $assignment->subject_name; ?></td>
                                    <td><?php echo $assignment->s_name; ?></td>
                                    <td><?php echo $assignment->assign_dos; ?></td>
                                    <td><a download="" href="<?php echo base_url('uploads/project_file/' . $assignment->assign_filename); ?>"><i class="fa fa-download"></i></a></td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>
                        </table>
                        <br/>
                        <?php
                    }
                    if (isset($search_result['participate']) && count($search_result['participate'])) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="9"><strong>Participate Details</strong></td>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Student Name</th>
                                <th>Department</th>
                                <th>Branch</th>
                                <th>Batch</th>
                                <th>Semester</th>
                                <th>File</th>
                            </tr>
                            <?php
                            $counter = 1;
                            foreach ($search_result['participate'] as $participate) {
                                ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $participate->pp_title; ?></td>
                                    <td><?php echo $participate->pp_desc; ?></td>
                                    <td><?php echo $participate->std_first_name . ' ' . $participate->std_last_name; ?></td>
                                    <td><?php echo $participate->d_name; ?></td>
                                    <td><?php echo $participate->b_name; ?></td>
                                    <td><?php echo $participate->c_name; ?></td>
                                    <td><?php echo $participate->s_name; ?></td>
                                    <td><?php echo $participate->pp_filename; ?></td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>
                        </table>
                        <br/>
                        <?php
                    }
                    if (isset($search_result['degree']) && count($search_result['degree'])) {
                        ?>
                        <table class="table table-responsive table-bordered">
                            <tr>
                                <th colspan="2">Department Details</th>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Department</th>
                            </tr>
                            <?php
                            $counter = 1;
                            foreach ($search_result['degree'] as $de) {
                                ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $de->d_name; ?></td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>
                        </table>
                        <br/>
                        <?php
                    }
                    if (isset($search_result['event']) && count($search_result['event'])) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="4"></th>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th width="20%">Event Name</th>
                                <th>Event Description</th>
                                <th width="15%">Event Date</th>
                            </tr>
                            <?php
                            $counter = 1;
                            foreach ($search_result['event'] as $event) {
                                ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $event->event_name; ?></td>
                                    <td><?php echo $event->event_desc; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($event->event_date)); ?></td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>
                        </table>
                        <br/>
                        <?php
                    }
                    if (isset($search_result['center']) && count($search_result['center'])) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="8">
                                    Exam Center Details
                                </th>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Center Name</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>City</th>
                                <th>Zip</th>
                                <th>Address</th>
                            </tr>
                            <?php
                            $counter = 1;
                            foreach ($search_result['center'] as $center) {
                                ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $center->center_name; ?></td>
                                    <td><?php echo $center->name; ?></td>
                                    <td><?php echo $center->emailid; ?></td>
                                    <td><?php echo $center->contactno; ?></td>
                                    <td><?php echo $center->city; ?></td>
                                    <td><?php echo $center->zipcode; ?></td>
                                    <td><?php echo $center->address; ?></td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>
                        </table>
                        <?php
                    }
                    if(isset($search_result['professor']) && count($search_result['professor'])) { ?>
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="5">
                                    Professor Details
                                </th>
                            </tr>
                            <tr>
                                <td>No</td>
                                <td>Professor Name</td>
                                <td>Mobile</td>
                                <td>Email</td>
                                <td>Department</td>
                            </tr>
                            <?php
                            $counter = 0;
                            foreach($search_result['professor'] as $professor) { ?>
                            <tr>
                                <td><?php echo ++$counter; ?></td>
                                <td><?php echo $professor->name; ?></td>
                                <td><?php echo $professor->mobile; ?></td>
                                <td><?php echo $professor->email; ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php } ?>
                        </table>
                    <?php }
                }
                if (!array_filter($search_result)) {
                    ?>
                    <h3>No data found!</h3>
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
</div>
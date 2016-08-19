<style>
    td{
        text-align: left !important;
    }
</style>
<!-- Start .row -->
<div class=row>                      

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="margin-top: 10px;">Select Exam</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="exam" name="exam">
                                    <option value="">Select</option>
                                    <?php foreach ($exam_listing as $row) { ?>
                                        <option value="<?php echo $row->em_id; ?>"
                                                <?php if ($exam_id == $row->em_id) echo 'selected'; ?>><?php echo $row->admission_duration . ' -- ' . $row->em_name; ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><br>

                <?php if ($this->uri->segment(3) != '') { ?>
                    <?php if (count($student_marks)) { ?>
                        <div class="box box-primary">                            

                            <table class="table table-condensed ex1"> 
                                <tr>
                                    <td class="col-lg-2 col-md-2 col-sm-4 col-xs-4"><strong>Student Name: </strong></td>
                                    <td><?php echo $student_detail->std_first_name . ' ' . $student_detail->std_last_name; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Roll No: </strong></td>
                                    <td><?php echo $student_detail->std_roll; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Branch :</strong></td>
                                    <td><?php echo $branch->branch_name; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Course: </strong></td>
                                    <td><?php echo $course->c_name; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Admission Plan: </strong></td>
                                    <td><?php echo $exam_details->admission_duration; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Exam Name: </strong></td>
                                    <td><?php echo $exam_details->em_name; ?></td>
                                </tr>
                            </table>
                            <div class="box-body">
                                <div class="box box-warning box-solid">
                                    <div class="box-body">
                                        <div class="box box-info box-solid">
                                            <div class="box-body no-padding table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>SI NO.</th>
                                                            <th>Subject Code</th>
                                                            <th>Subject Name</th>
                                                            <th>Total Marks</th>
                                                            <th>Passing Marks</th>
                                                             <th>Obtained Marks</th>                                      
                                                                <?php 
                                                            if($exam_details->result_type=='grade')
                                                            {   ?>                                                            
                                                          
                                                            <th>Grade</th>
                                                            <?php } ?>
                                                            <th>Results</th>
                                                            
                                                        </tr>
                                                        <?php
                                                        $counter = 1;
                                                        $total_marks = 0;
                                                        $obtained_marks = 0;
                                                        $is_failed = FALSE;
                                                        foreach ($student_marks as $row) {
                                                            $is_number = is_numeric($row->mark_obtained);
                                                            $current_marks = 0;
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $counter++; ?></td>
                                                                <td><?php echo $row->subject_code; ?></td>
                                                                <td><?php echo $row->subject_name; ?></td>
                                                                <td><?php echo $exam_details->total_marks; ?></td>
                                                                <?php $total_marks += $exam_details->total_marks; ?>
                                                                <td><?php echo $exam_details->passing_mark; ?></td>
                                                                <?php
                                                                if($exam_details->result_type=="grade")
                                                                {
                                                                ?>
                                                                <td><?php echo $current_marks += $row->mark_obtained; ?></td>
                                                                <?php if ($row->mark_obtained < $exam_details->passing_mark) 
                                                                    $is_failed = TRUE; ?>
                                                                <?php $obtained_marks += $row->mark_obtained; ?>
                                                                <?php
                                                                $percentage = ($row->mark_obtained * 100) / $exam_details->total_marks;
                                                                
                                                                ?>
                                                                <td >
                                                                    <?php
                                                                    $grade = $percentage;
                                                                    $grade = (int) (100 * $row->mark_obtained) / $exam_details->total_marks;
                                                                    $grade_data = $this->db->select()
                                                                            ->from('grade')
                                                                            ->where('from_marks <= ', $grade)
                                                                            ->order_by('from_marks', 'DESC')
                                                                            ->limit(1)
                                                                            ->get()
                                                                            ->row();
                                                                    $is_pass = TRUE;

                                                                    if ($row->mark_obtained < $exam_details->passing_mark) {
                                                                        echo 'F';
                                                                        $is_pass = FALSE;
                                                                    } else {
                                                                        echo $grade_data->grade_name;
                                                                        $is_pass = TRUE;
                                                                    }
                                                                    ?>
                                                                </td>
                                                               <?php
                                                                }
                                                                else
                                                                {
                                                                    
                                                                    ?>
                                                                 <?php if ($row->mark_obtained < $exam_details->passing_mark) $is_failed = TRUE; ?>
                                                                <?php $obtained_marks += $row->mark_obtained; ?>
                                                                <?php
                                                                $percentage = ($row->mark_obtained * 100) / $exam_details->total_marks;
                                                                
                                                                ?>
                                                                 <?php
                                                                    $grade = $percentage;
                                                                    $grade = (int) (100 * $row->mark_obtained) / $exam_details->total_marks;
                                                                    $grade_data = $this->db->select()
                                                                            ->from('grade')
                                                                            ->where('from_marks <= ', $grade)
                                                                            ->order_by('from_marks', 'DESC')
                                                                            ->limit(1)
                                                                            ->get()
                                                                            ->row();
                                                                    $is_pass = TRUE;

                                                                    if ($row->mark_obtained < $exam_details->passing_mark) {
                                                                        echo 'F';
                                                                        $is_pass = FALSE;
                                                                    } else {
                                                                        echo $grade_data->grade_name;
                                                                        $is_pass = TRUE;
                                                                    }
                                                                    ?>
                                                                <td >
                                                                   <?php echo $current_marks += $row->mark_obtained; ?>
                                                                </td>
                                                                <?php
                                                                }
                                                               ?>
                                                                <td><?php
                                                                    if ($is_pass)
                                                                        echo 'Pass';
                                                                    else
                                                                        echo 'Fail';
                                                                    ?></td>
                                                             

                                                            </tr>
                                                        <?php } ?>

                                                    </tbody>
                                                </table>
                                               
                                            </div><!--/box-body-->
                                            <div class="box-footer">
                                                <fieldset>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="disabledTextInput">Total Marks :</label>
                                                            <?php echo $total_marks; ?>
                                                        </div>                                                    
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="disabledTextInput">Total Obtained Marks :</label>
                                                            <?php echo $obtained_marks; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="disabledTextInput">Total Percentages Marks :</label>
                                                            <?php echo number_format((($obtained_marks * 100) / $total_marks), 2, '.', ''); ?>%
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="disabledTextInput">Results :</label>
                                                            <?php if (!$is_failed) { ?>
                                                                <span class="label label-success">Pass</span>    
                                                            <?php } else { ?>
                                                                <span class="label label-danger">Failed</span>
                                                            <?php }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label>Remarks :</label>
                                                            <?php echo $row->mm_remarks; ?>
                                                        </div>
                                                    </div>
                                                </fieldset> 
                                            </div>
                                             <?php
                                                $exam_id = $this->uri->segment(3);
                                                $std_id = $this->session->userdata('std_id');
                                                $this->db->where('im.em_id',$exam_id);                                                
                                                $this->db->where('im.std_id',$std_id);                                                
                                                $this->db->join('exam_manager em','em.em_id=im.em_id');                                                
                                                $this->db->join('internal_exam ie','ie.internal_id=im.internal_id');
                                                $this->db->join('subject_manager sm','sm.sm_id=im.sm_id');
                                                $result = $this->db->get('internal_marks im')->result();                                                
                                                ?>
                                            <table class="table table-bordered table-striped" style="display:none;">
                                                    <tbody>
                                                        <tr>
                                                            <th>SI NO.</th>                                                            
                                                            <th>Internal Exam</th>
                                                            <th>Subject Name</th>
                                                            
                                                            <th>Total Marks</th>                                                            
                                                            <th>Obtained Marks</th>                                                                                                                                                             
                                                            
                                                        </tr>
                                                        
                                                        <?php
                                                        $count = 1;
                                                        foreach($result as $res): ?>
                                                        <tr>
                                                            <td><?php echo $count++; ?></td>
                                                            <td><?php echo $res->internal_title; ?></td>
                                                            
                                                            <td><?php echo $res->subject_name; ?></td>
                                                            <td><?php echo $res->internal_marks; ?></td>                                                            
                                                            <td><?php echo $res->internal_obtained_marks; ?></td>                                                            
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                 </table>
                                        </div><!--/box-footer-->
                                    </div><!--/box-->

                                </div><!--/box-body-->
                            </div><!--/box-->
                        </div><!--/box-body-->
                    
                <?php } else { ?> 
                    <br/>
                    <div class="well well-sm">
                        <h4 class="page-header edusec-border-bottom-warning">
                            <i class="fa fa-info-circle"></i> Exam result
                        </h4>
                    </div><!--/well-->
                    <h3>Exam result has not been declared yet.</h3>
                <?php } ?>
            <?php } ?>

            </div><!--/box-->
        </div>
    </div>
    <!-- End .panel -->
</div>
<!-- End .row -->

<!-- End #content -->


<script>
    $(document).ready(function () {
        $('#exam').on('change', function () {
            var exam_id = $(this).val();
            if (exam_id != '')
                location.href = "<?php echo base_url(); ?>student/exam_marks/" + exam_id;
        })
    })
</script>
</div>
<!-- End contentwrapper -->
</div>
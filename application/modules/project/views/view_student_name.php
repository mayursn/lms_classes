<?php
$student = $this->db->select('std_id, std_first_name, std_last_name')->from('student')->get()->result();
$edit_data = $this->db->get_where('project_manager', array('pm_id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>


    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle panelMove panelClose panelRefresh">

                <h4 class=panel-title><?php echo ucwords("Student list"); ?></h4>
                <!-- Start .panel -->
                <div class="panel-body"> 
                    <ul>


                        <?php
                        $stu = explode(',', $row['pm_student_id']);

                        $datastudent = $this->db->get_where('student', array('std_degree' => $row['pm_degree'],
                                    'course_id' => $row['pm_course'],
                                    'std_batch' => $row['pm_batch'],
                                    'semester_id' => $row['pm_semester'], 'class_id' => $row['class_id']))->result();

                        foreach ($datastudent as $rowstu) {
                            if (in_array($rowstu->std_id, $stu)) {
                                
                            }
                            ?>
                            <li> <?php echo $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name; ?></li>
                        <?php } ?>


                    </ul>

                </div>
            </div>
        </div>
    </div>



<?php endforeach; ?>

<?php
$this->load->model('student/Student_model');
$student = $this->Student_model->get_student_optimize();
$this->load->model('project/Project_manager_model');
$row = $this->Project_manager_model->get($param2);



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
                        $stu = explode(',', $row->pm_student_id);

                        $datastudent = $this->Student_model->get_many_by(array('std_degree' => $row->pm_degree,
                                    'course_id' => $row->pm_course,
                                    'std_batch' => $row->pm_batch,
                                    'semester_id' => $row->pm_semester, 'class_id' => $row->class_id));

                        foreach ($datastudent as $rowstu) {
                            if (in_array($rowstu->std_id, $stu)) {
                                ?>
                                     <li> <?php echo $rowstu->std_first_name . '&nbsp' . $rowstu->std_last_name; ?></li>
                                    <?php 
                            }
                            ?>
                           
                        <?php } ?>


                    </ul>

                </div>
            </div>
        </div>
    </div>


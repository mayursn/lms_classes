<?php
    $this->db->select('s.*,u.*');
    $this->db->where('s.std_id',$param2);
    $this->db->from('student s');
    $this->db->join('user u','u.user_id=s.user_id');
   $student= $this->db->get()->row();
  //$student=  $this->db->get_where("student", array('std_id' => $param2))->result();
  
$branch = $this->db->get_where("branch_location", array("branch_id" => $student->branch_id))->row()->branch_name;
$course = $this->db->get_where("course", array("course_id" => $student->course_id))->row()->c_name;
$admission_plan = $this->db->get_where("admission_plan", array("admission_plan_id" => $student->admission_plan_id))->row()->admission_duration;
$class = $this->db->get_where("class", array("class_id" => $student->class_id))->row()->class_name;

?>


<div class="row">

    <div class=col-lg-12>
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <table class="table table-striped table-bordered table-responsive" id="data-tables">
                     <tbody>
                        <tr>
                            <td><strong>Image</strong></td>
                            <td><?php if ($student->profile_pic != "") { ?> 
                                    <img src="<?php echo base_url() . 'uploads/system_image/' . $student->profile_pic; ?>" height="100" width="100" />
                                <?php } else { ?>
                                    <img src="<?= base_url() ?>/uploads/no-image.jpg" height="100px" width="100px"/>
                                <?php } ?></td>
                        </tr>

                        <tr>		
                            <th>Student Name</th> <td><?php echo $student->first_name . ' ' . $student->last_name; ?></td>						
                        </tr>
                        <tr>		
                            <th>Branch </th><td><?php echo $branch; ?></td>
                        </tr>
                        <tr>
                            <th>Course </th>  <td><?php echo $course; ?></td>
                        </tr>
                        <tr>
                            <th>Admission Plan </th> <td><?php echo $admission_plan; ?></td>
                        </tr>
                        <tr>
                            <th>Class </th>  <td><?php echo $class; ?></td>                  			
                        </tr>
                        <tr>
                            <th>Roll No </th>  <td><?php echo $student->std_roll; ?></td>                  			
                        </tr>
                        <tr>
                            <th>Email </th>  <td><?php echo $student->email; ?></td>                  			
                        </tr>

                        <tr>
                            <th>Gender </th>  <td><?php echo $student->gender; ?></td>                  			
                        </tr>
                        <tr>
                            <th>Mobile No </th>  <td><?php echo $student->mobile; ?></td>                  			
                        </tr>
                        <tr>
                            <th>Student Birthdate </th>  <td><?php echo date("F d, Y",strtotime($student->std_birthdate)); ?></td>                  			
                        </tr>
                    </tbody>
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
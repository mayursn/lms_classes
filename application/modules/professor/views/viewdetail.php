<?php
$this->load->model('professor/Professor_model');
$professor = $this->db->get_where("professor", array("professor_id" => $param2))->row();
if (count($professor))
    $degree = $this->db->get_where("degree", array("d_id" => $professor->department))->row();
$course = $this->db->get_where("course", array("course_id" => $professor->branch))->row();
?>


<div class="row">

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->            
            <div class=panel-body>
                <table class="table table-striped table-bordered table-responsive" id="data-tables">

                    <tbody>
                        <tr>
                            <td><strong>Image</strong></td>
                            <td><?php if ($professor->image_path != "") { ?> 
                                    <img src="<?php echo base_url() . 'uploads/professor/' . $professor->image_path; ?>" height="100" width="100" />
                                <?php } else { ?>
                                    <img src="<?= base_url() ?>/uploads/no-image.jpg" height="100px" width="100px"/>
                                <?php } ?></td>
                        </tr>

                        <tr>		
                            <th>Professor Name</th> <td><?php echo $professor->name; ?></td>						
                        </tr>
                        <tr>		
                            <th>Department </th><td><?php echo $degree->d_name; ?></td>
                        </tr>
                        <tr>
                            <th>Branch </th>  <td><?php echo $course->c_name; ?></td>
                        </tr>


                        <tr>
                            <th>Email </th>  <td><?php echo $professor->email; ?></td>                  			
                        </tr>

                        <tr>
                            <th>Address </th>  <td><?php echo $professor->address; ?></td>                  			
                        </tr>
                        <tr>
                            <th>Mobile No </th>  <td><?php echo $professor->mobile; ?></td>                  			
                        </tr>
                        <tr>
                            <th>Birthdate </th>  <td><?php echo date_formats($professor->dob); ?></td>                  			

                        </tr>
                        <tr>
                            <th>City </th>  <td><?php echo $professor->city; ?></td>                  			
                        </tr>

                        <tr>
                            <th>Occupation </th>  <td><?php echo $professor->occupation; ?></td>                  			
                        </tr>

                        <tr>
                            <th>Designation </th>  <td><?php echo $professor->designation; ?></td>                  			
                        </tr>

                        <tr>
                            <th>About </th>  <td><?php echo $professor->about; ?></td>                  			
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
<?php
$this->db->select('s.*,sl.*,sq.*');
$this->db->join('student s', 's.std_id=sl.student_id');
$this->db->join('survey_question sq', 'sq.sq_id=sl.sq_id');
$edit_data = $this->db->get_where('survey sl', array('sl.student_id' => $param2))->result();

$this->load->helper("date_format");
?>
<style>
    .table-striped .highlight, .table-striped .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
    .table-striped ul{margin:0;padding:0;}
   .table-striped li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel-primary" data-collapsed="0">            

            <div class="panel-body">
                <div class="tab-pane box" id="add" style="padding: 5px">
                    <div class="box-content">  
                        <div class="panel-body table-responsive">
                            <table class="table table-striped" id="data-tables">
                             
                                <thead>
                                    <tr>
                                        <th><?php echo ucwords("Student Name"); ?></th>
                                        <th><?php echo ucwords("Degree "); ?></th>
                                        <th><?php echo ucwords("Course "); ?></th>
                                        <th><?php echo ucwords("Batch "); ?></th>
                                        <th><?php echo ucwords("Semester "); ?></th>
                                    </tr>
                                </thead>
                                <?php
                                $degree = $this->db->get_where("degree", array("d_id" => $edit_data[0]->std_degree))->result();
                                $course = $this->db->get_where("course", array("course_id" => $edit_data[0]->course_id))->result();
                                $batch = $this->db->get_where("batch", array("b_id" => $edit_data[0]->std_batch))->result();
                                $semester = $this->db->get_where("semester", array("s_id" => $edit_data[0]->semester_id))->result();
                                ?>
                                <tbody>
                                <td><?php echo $edit_data[0]->std_first_name . ' ' . $edit_data[0]->std_last_name; ?></td>
                                <td><?php
                                    if (!empty($degree)) {
                                        echo $degree[0]->d_name;
                                    }
                                    ?></td>
                                <td><?php echo $course[0]->c_name; ?></td>
                                <td><?php echo $batch[0]->b_name; ?></td>
                                <td><?php echo $semester[0]->s_name; ?></td>

                                </tbody>
                            </table>
                            <table class="table table-striped" id="data-tables">
                                <thead>
                                    <tr>
                                        <th><?php echo ucwords("Question"); ?></th>
                                        <th width="30%"><?php echo ucwords("Answer"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($edit_data as $row){ ?>
                                    <tr>
                                        <td><?php  echo $row->question; ?></td>
                                        <td>                                        
                              <ul>
                              <?php
                               $selected=" ";
                                 for ($i = 1; $i <= 5; $i++) {
                                     if(!empty($row->std_rating) && $i<=$row->std_rating) {
                                            $selected = "selected";
                                    }
                                    
                                     ?>
                              <li class='<?php echo $selected; ?>' >&#9733;</li>
                              <?php
                              $selected = '';
                              } ?>
                              <ul>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</div>


<?php
//    $this->db->select('sa.*,sm.*,b.branch_name,c.c_name,a.admission_duration');
//    $this->db->where("FIND_IN_SET('".$param2."',sa.professor_id) !=",0);
//    $this->db->from('subject_association sa');
//    $this->db->join('subject_manager sm','sm.sm_id=sa.sm_id');
//    $this->db->join('branch_location b','b.branch_id=sa.branch_id');
//    $this->db->join('course c','c.course_id=sm.course_id');
//    $this->db->join('admission_plan a','a.admission_plan_id=a.admission_plan_id');
//    $subject=$this->db->get()->result();

$this->db->join('branch_location b','b.branch_id=sa.branch_id');
$this->db->join('subject_manager sm','sm.sm_id=sa.sm_id');
$this->db->join('course c','c.course_id=sm.course_id');
$this->db->join('admission_plan a','a.admission_plan_id=sa.admission_plan_id');
$this->db->where('professor_id',$param2);
$subject = $this->db->get('subject_association sa')->result();

    
  
  
?>

<div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle panelMove panelClose panelRefresh">
                <!-- Start .panel -->
                <div class="panel-body"> 
                   <table id="datatable-list_subject" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>											
                            <th>Subject Name</th>											
                            <th>Subject Code</th>											
                            <th>Branch</th>											
                            <th>Course</th>											
                            <th>Admission Plan</th>		
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $i=0;
                        foreach ($subject as $row):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>	
                                <td><?php echo $row->subject_name; ?></td>												
                                <td><?php echo $row->subject_code; ?></td>
                                <td><?php echo $row->branch_name; ?> </td>
                                <td><?php echo $row->c_name; ?> </td>
                                <td><?php echo $row->admission_duration; ?> </td>
                            </tr>
                        <?php endforeach; ?>																						
                    </tbody>
                </table>
                   
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    $('#datatable-list_subject').DataTable();
    });
</script>
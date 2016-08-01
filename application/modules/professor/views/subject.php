<?php
 $this->db->select('sa.*,sm.*,d.d_name,c.c_name,s.s_name');
    $this->db->where("FIND_IN_SET('".$param2."',sa.professor_id) !=",0);
    $this->db->from('subject_association sa');
    $this->db->join('subject_manager sm','sm.sm_id=sa.sm_id');
    $this->db->join('degree d','d.d_id=sa.degree_id');
    $this->db->join('course c','c.course_id=sa.course_id');
    $this->db->join('semester s','s.s_id=sa.sem_id');
  $subject=$this->db->get()->result();
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
                            <th>Department</th>											
                            <th>Branch</th>											
                            <th>Semester</th>		
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
                                <td><?php echo $row->d_name; ?> </td>
                                <td><?php echo $row->c_name; ?> </td>
                                <td><?php echo $row->s_name; ?> </td>
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
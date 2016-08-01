<?php
if($param3=="department")
{
    $data=$this->db->select('degree_id')->where('b_id',$param2)->from('batch')->get()->result_array();
    $degree=explode(',',$data[0]['degree_id']);
        $query="select d_name from degree where ";
        foreach ($degree as $d) {
                $query .="d_id=".$d." or ";
            }
            $query = rtrim($query, ' or');
             $degreedata = $this->db->query($query)->result_array();
             ?>
             <h4 class=panel-title><?php echo ucwords("departments"); ?></h4>
              <div class="panel-body"> 
                    <ul>
                        <?php
                        
                            foreach ($degreedata as $row){
                             ?>
                            <li><?php echo $row['d_name']; ?></li>
                            <?php
                             }
                        
                        ?>
                        
                    </ul>
                   
                </div>
<?php
}
else
{
    $data=$this->db->select('course_id')->where('b_id',$param2)->from('batch')->get()->result_array();
    $course=explode(',',$data[0]['course_id']);
        $query="select c_name from course where ";
        foreach ($course as $c) {
                $query .="course_id=".$c." or ";
            }
            $query = rtrim($query, ' or');
             $coursedata = $this->db->query($query)->result_array();
             ?>
                <h4 class=panel-title><?php echo ucwords("branches"); ?></h4>
              <div class="panel-body"> 
                    <ul>
                        <?php
                        
                            foreach ($coursedata as $row){
                             ?>
                            <li><?php echo $row['c_name']; ?></li>
                            <?php   
                             }
                        
                        ?>
                        
                    </ul>
                   
                </div>
<?php
}
?>
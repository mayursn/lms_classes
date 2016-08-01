<!-- Start .row -->
<?php
$create = create_permission($permission, 'Assignment');
$read = read_permission($permission, 'Assignment');
$update = update_permisssion($permission, 'Assignment');
$delete = delete_permission($permission, 'Assignment');
$read_assessment = read_permission($permission, 'Assessment');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <div class="tabs mb20">
                    <ul id="import-tab" class="nav nav-tabs">
                        <?php if($read){ ?>
                        <li class="active">
                            <a href="#assignment-list" data-toggle="tab" aria-expanded="true">Assignment List</a>
                        </li>
                          <?php } ?>
                        <?php if($read){ ?>
                        <li class="">
                            <a href="#submitted-assignment" data-toggle="tab" aria-expanded="false">Submitted Assignment</a>
                        </li>
                          <?php } ?>
                        <?php if($read_assessment){ ?>
                        <li class="<?php if(!$read){ ?> active <?php } ?>">
                            <a href="#assessment" data-toggle="tab" aria-expanded="false">Assessment</a>
                        </li>
                        <?php } ?>
                    </ul>
                    <div id="import-tab-content" class="tab-content">
                        
                        <div class="tab-pane fade active in" id="assignment-list">
                            <?php if($read){ ?>
                            <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Assignment</th>											
                                        <th>Date of submission</th>
                                        <th>File</th>                                              
                                        <th>Instruction</th>                                                                                      
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($assignment as $row):
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $row->assign_title; ?></td>	                                                    	                                                   
                                            <td><?php echo date_formats($row->assign_dos); ?></td>		                                           
                                            <td> <a href="<?php echo base_url(); ?>uploads/project_file/<?php echo $row->assign_filename; ?>" download="" title="download"><i class="fa fa-download"></i></a></td>                                          
                                            <td><?php echo wordwrap($row->assignment_instruction, 30, "<br>\n"); ?></td>
                                            <td> 
                                                <?php
                                                $current = date("Y-m-d");
                                                $dos = nice_date($row->assign_dos,"Y-m-d");
                                                $student_id = $this->session->userdata("std_id");
                                                $assignment = $this->Assignment_submission_model->getchecksubmitted($row->assign_id, $student_id);
                                                //echo $dos;
                                                //echo "<br>";
                                                //echo $current;
                                                if ( $dos >= $current  && $assignment < 1) {
                                                  //  echo "yes";
                                                    ?>
                                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/assignment_submit/<?php echo $row->assign_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="icomoon-icon-plus mr0"></i> Add</span></a>
                                                    <?php
                                                } else {
                                                    if ($assignment < 1) {
                                                        $res = $this->Assignment_submission_model->get_student_reopen_assignment($row->assign_id, $student_id);
                                                        if ($res > 0) {
                                                            ?>
                                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/assignment_submit/<?php echo $row->assign_id; ?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="icomoon-icon-plus mr0"></i> Add</span></a>
                                                            <?php
                                                        } else {
                                                            echo '<span class="label label-danger mr6 mb6"><i class="fa fa-minus-square-o" ></i>Not Submitted</span>';
                                                        }
                                                    } else {
                                                        echo '<span class="label label-primary mr6 mb6"><i class="fa fa-check-square-o"></i>Submitted</span>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>							
                                </tbody>
                            </table>
                             <?php } ?>
                        </div>
                        
                        <!-- tab content -->
                        <div class="tab-pane fade" id="submitted-assignment">
                             <?php if($read){ ?>
                            <table id="submitted-assignment-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Assignment</th>												
                                        <th>Submitted-Date</th>												
                                        <th>Document</th>	
                                        <th>File</th>                                                               
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($submitassignment->result() as $srow):
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $srow->assign_title; ?></td>	
                                            <td><?php echo date_formats($srow->submited_date); ?></td>	
                                            <td><?php echo $srow->document_file; ?></td>
                                            <td > 
                                                <a href="<?php echo base_url() ?>uploads/project_file/<?php echo $srow->assign_filename; ?>" download=""  data-toggle="tooltip" data-placement="top" title="download" ><i class="fa fa-download"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>						
                                </tbody>
                            </table>
                             <?php } ?>
                        </div>

                        <div class="tab-pane fade <?php if(!$read){ ?> active in <?php }else{ ?> out <?php } ?>" id="assessment">
                             <?php if($read_assessment){ ?>
                            <table class="table table-striped table-bordered table-responsive" cellspacing=0 width=100% id="datatable-list2">
                                <thead>
                                    <tr>
                                        <th>No</th>		
                                        <th>Assignment</th>
                                        <th>Submitted-File</th>                                                       
                                        <th>Professor Name</th>
                                        <th>Feedback</th>                                                
                                        <th>Grade</th>	
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($assessment->result_array() as $row):
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>	
                                            <td><?php echo $row['assign_title']; ?></td>                                                               
                                            <td id="downloadedfile"><a href="<?php echo base_url() . 'uploads/project_file/' . $row['document_file']; ?>" title="download" download=""><i class="fa fa-download"></i></a></td>	                                                              
                                            <td><?php echo roleuserdatatopic($row['user_role'],$row['user_role_id']); ?></td>
                                            <td><?php echo wordwrap($row['feedback'], 30, "<br>\n"); ?></td>                                                   
                                            <td><?php echo $row['grade']; ?></td>                                                   
                                        </tr>
                                    <?php endforeach; ?>																									
                                </tbody>
                            </table>
                             <?php } ?>
                        </div>
                       
                    </div>

                </div>
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

<script>
    $(document).ready(function () {
        $('#submitted-assignment-datatable-list').DataTable({"language": { "emptyTable": "No data available" }});
        $('#data-tables1').dataTable({"language": { "emptyTable": "No data available" }});
        $("#datatable-list2").dataTable({"language": { "emptyTable": "No data available" }});
    });
</script>

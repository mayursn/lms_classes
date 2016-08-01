
<?php
$create = create_permission($permission, 'Subject');

$read = read_permission($permission, 'Subject');
$update = update_permisssion($permission, 'Subject');
$delete = delete_permission($permission, 'Subject');
$this->load->model('admission_plan/Admission_plan_model');
?>

<div class=row>                      

    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
             <?php if ($create) { ?>
              <a class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_subjectdetail_create/<?php echo $param?>');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i>Subject Association</a>
              <?php } ?>
              <div class=panel-heading>
                <h4 class=panel-title>Subject details</h4>
            </div>
            <div class="panel-body">
              <div id="getresponse">
                    <table class="table table-striped table-responsive table-bordered" id="subject-datatable-list" >
                    <thead>
                        <tr>
                            <th>No</th>											
                            <th><?php echo ucwords("Subject Name"); ?></th>											
                            <th><?php echo ucwords("Subject Code"); ?></th>										
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                        $count = 1;
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>	
                                <td><?php echo $subject->subject_name; ?></td>												
                                <td><?php echo $subject->subject_code; ?></td>
                            </tr>					
                    </tbody>
                 </table>
                  
              </div>
              </div>
              <div class=panel-heading>
                <h4 class=panel-title>Subject Association Detail</h4>
             </div>
               <div class="panel-body">
              <div id="getresponse">  
              <?php if ($create || $read || $update || $delete) { ?>
                <table class="table table-striped table-responsive table-bordered" id="datatable-list" >
                    <thead>
                        <tr>
                            <th>No</th>												
                            <th><?php echo ucwords("Professor"); ?></th>											                            
                            <th><?php echo ucwords("Branch"); ?></th>											                            
                            <th><?php echo ucwords("Admission Plan"); ?></th>											                            
                            <?php if ($update || $delete) { ?>
                            <th><?php echo ucwords("Action"); ?></th>	
                             <?php } ?> 
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                        $count = 1;
                        foreach ($subjectdetail as $row):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td>
                                    <?php 
                                    $proid=explode(',',$row->professor_id);
                                    foreach($user as $u)
                                    {
                                        if(in_array($u->user_id,$proid))
                                        {
                                                echo $u->first_name."<br>";
                                        }
                                    }
                                    ?></td>
                                <td><?php echo $row->branch_name.' - '.$row->branch_location; ?></td>												                                                                             
                                <td><?php $plan = $this->Admission_plan_model->get($row->admission_plan_id); 
                                echo $plan->admission_duration;
                                ?></td>
                                
                                 <?php if ($update || $delete) { ?>
                                <td>
                                    <?php 
                                            if($update) { ?>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_subjectdetail_edit/<?php echo $row->sa_id; ?>/<?php echo $param;?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                  <?php } ?>
                                            
                                <?php
                                if($delete) { ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>subject/subject_detail_delete/<?php echo $row->sa_id; ?>/<?php echo $param;?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                <?php } ?>   
                                </td>
                               <?php } ?>
                            </tr>
                        <?php endforeach; ?>					
                    </tbody>
                 </table>
                  <?php } ?>
                </div>
            </div>
        </div>
        <!----TABLE LISTING ENDS--->

    </div>
</div>
</div>
</div>
<script>
$(document).ready(function(){ 
    $("#subject-datatable-list").dataTable();
});
</script>
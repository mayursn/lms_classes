<div class=row>                      

    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
            <div class="panel-body">
                <a class="links" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_subjectdetail_create/<?php echo $param?>');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Subject</a>
                 
                <div id="getresponse">
                <table class="table table-striped table-responsive table-bordered" id="datatable-list" >
                    <thead>
                        <tr>
                            <th>No</th>											
                            <th><?php echo ucwords("Subject Name"); ?></th>											
                            <th><?php echo ucwords("Subject Code"); ?></th>											
                            <th><?php echo ucwords("Professor"); ?></th>											
                            <th><?php echo ucwords("Department"); ?></th>											
                            <th><?php echo ucwords("Branch"); ?></th>											
                            <th><?php echo ucwords("Semester"); ?></th>									
                            <th><?php echo ucwords("Action"); ?></th>											
                        </tr>
                    </thead>
                    <tbody>
                         <?php
                        $count = 1;
                        foreach ($subjectdetail as $row):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>	
                                <td><?php echo $row->subject_name; ?></td>												
                                <td><?php echo $row->subject_code; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->d_name; ?></td>												                                             
                                <td><?php echo $row->c_name; ?></td>												                                             
                                <td><?php echo $row->s_name; ?></td>
                                <td>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/subject_subjectdetail_edit/<?php echo $row->sa_id; ?>/<?php echo $param;?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>subject/subject_detail_delete/<?php echo $row->sa_id; ?>/<?php echo $param;?>');"  data-toggle="tooltip" data-placement="top" ><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                </td>
                               
                            </tr>
                        <?php endforeach; ?>					
                    </tbody>
                 </table>
                </div>
            </div>
        </div>
        <!----TABLE LISTING ENDS--->

    </div>
</div>
</div></div>
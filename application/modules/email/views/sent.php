<?php $this->load->model('user/User_model'); ?>
<div class=row>                     

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggletoggle">
            <div class="panel-body">

                <table class="table table-striped table-responsive table-bordered" id="datatable-list" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?php echo ucwords("Email"); ?></th>
                            <th><?php echo ucwords("Subject"); ?></th>
                            <th><?php echo ucwords("Date"); ?></th>
                            <th><?php echo ucwords("Action"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                        
                        $counter = 0; // row counter
                        if (count($sent_mail)) {
                            foreach ($sent_mail as $row) {
                                $counter++;
                                ?> 

                                <tr>
                                    <td><?php echo $counter; ?></td>

                                    <td>
                                        <?php
                                        $user_ids = explode(',', $row->email_to);                                        
                                        if(count($user_ids) > 1) {
                                            
                                            $user = $this->User_model->get($user_ids[0]);
                                            echo $user->first_name . ' ' . $user->last_name . '...';
                                        } else {
                                            $user = $this->User_model->get($row->email_to);
                                            echo $user->first_name . ' ' . $user->last_name . ' (' . $user->email . ')';
                                        }
                                        ?>                                        
                                    </td>
                                    <td>
                                        <?php echo $row->subject; ?>
                                    </td>
                                    <td><?php echo date('F d, Y h:i A', strtotime($row->created_at)); ?>
                                    </td>
                                    <td class="menu-action">
                                        <a href="<?php echo base_url('email/view_sent/' . $row->email_id); ?>"><span class="label label-primary mr6 mb6"><i class="fa fa-desktop" ></i>View</span></a>
                                        <a href="<?php echo base_url('email/sentdelete/' . $row->email_id) ?>" onclick="return confirm('Are you sure to delete this email?');"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                    </td>
                                </tr>

                                <?php }
                        }
                        ?>                                
                    </tbody>
                 </table>
                <!--Pagination-->
            </div>
            <!-- panel-body  -->

        </div>
        <!-- panel --> 

    </div>
    <!-- .vd_content-section --> 

</div>
</div></div>
<!-- Middle Content End --> 
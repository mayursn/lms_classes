<!-- Start .row -->
<?php 
$this->load->model('user/User_model'); 
$this->load->model('email/Email_model');
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>

                <table id="inbox-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?php echo ucwords("From"); ?></th>
                            <th><?php echo ucwords("Subject"); ?></th>
                            <th><?php echo ucwords("Date"); ?></th>
                            <th><?php echo ucwords("Action"); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $counter = 0;
                        $user_id = $this->session->userdata('user_id');
                        if (count($inbox)) {

                            foreach ($inbox as $row) {
                                $counter++;
                                ?>
                                <tr class="<?php if(!$this->Email_model->is_email_read_by_user($row->email_id, $user_id)) echo 'info'; ?>">
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo ucwords($row->first_name . ' ' . $row->last_name) . ' (' . $row->email . ')'; ?></td>
                                    <td>
                                        <?php echo $row->subject; ?>
                                    </td>
                                    <td><?php echo datetime_formats($row->EmailDate); ?></td>
                                    <td class="menu-action">
                                        <a href="<?php echo base_url('email/view_inbox/' . $row->email_id); ?>"><span class="label label-primary mr6 mb6"><i class="fa fa-desktop" ></i>View</span></a>
                                        <a href="<?php echo base_url('email/delete/' . $row->email_id); ?>"
                                           onclick="return confirm('Are you sure to delete this email?');"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } ?>                                  
                    </tbody>
                </table>
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
$(document).ready(function(){
    $('#inbox-datatable-list').dataTable({"language": { "emptyTable": "No data available" }});
});
</script>
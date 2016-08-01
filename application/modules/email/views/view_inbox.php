<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <a href="<?php echo base_url(); ?>email/reply/<?php echo $email->email_id; ?>" class="btn btn-primary">
                <span class="fa fa-reply"></span>Reply
            </a>
            <div class=panel-body>
                <form class="form-horizontal" role="form" action="#" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">From:</label>
                        <div class="col-sm-9">                            
                            <div class="email_data">
                                <p style="text-align: justify"><?php echo $email->first_name . ' ' . $email->last_name . ' (' . $email->email . ')'; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Subject:</label>
                        <div class="col-sm-9">
                            <div class="email_data"><?php echo $email->subject; ?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">External Email:</label>
                        <div class="col-sm-9">
                            <div class="email_data"><?php echo $email->external_email; ?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Message:</label>
                        <div class="col-sm-9">
                            <div class="email_data"><?php echo $email->message; ?></div>
                        </div>
                    </div>

                    <?php if ($email->attachments != '') { ?> 
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Attachments:</label>
                            <div class="col-sm-9">
                                <?php
                                $file_names = explode(',', $email->attachments);
                                foreach ($file_names as $file) {
                                    ?>
                                <div class="email_data">
                                    <a target="_blank" download href="<?php echo base_url('uploads/emails/' . $file); ?>" style="margin-left: 15px;"><?php echo $file; ?></a><br/>
                                </div>
                                    
                                <?php } ?>
                                
                            </div>

                        </div>
                </div>
            <?php } ?>


            </form>
        </div>
    </div>
    <!-- End .panel -->
</div>
<!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>

<style>
    .email_data{
        margin-top: 7px;
    }
</style>
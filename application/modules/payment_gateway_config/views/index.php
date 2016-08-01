<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body">
                <div class="">
                    <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?> </span> 
                </div>
                <form id="authorizenetconfig" class="form-horizontal form-groups-bordered validate" method="post" action="<?php echo base_url(); ?>payment_gateway_config/update" role="form">
                    <?php
                    foreach ($authorize_net as $config) {
                        
                    }
                    ?>
                    <input type="hidden" name="config_id" value="<?php if (isset($config)) echo $config->id; ?>" />
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label"><?php echo ucwords("Login ID"); ?><span style="color:red">*</span></label>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <input type="text" id="login_id" class="form-control" name="login_id"
                                   value="<?php if (isset($config)) echo $config->login_id; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label" for="example-email"><?php echo ucwords("Trasaction Key"); ?><span style="color:red">*</span></label>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <input type="text" id="transaction_key" name="transaction_key" class="form-control"
                                   value="<?php if (isset($config)) echo $config->transaction_key; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label" for="example-email"><?php echo ucwords("Success Url"); ?><span style="color:red">*</span></label>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <input type="text" id="success_url" name="success_url" class="form-control"
                                   value="<?php if (isset($config)) echo $config->success_url; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label" for="example-email"><?php echo ucwords("Failure Url"); ?><span style="color:red">*</span></label>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <input type="text" id="failure_url" name="failure_url" class="form-control"
                                   value="<?php if (isset($config)) echo $config->failure_url; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label" for="example-email"><?php echo ucwords("Cancel Url"); ?><span style="color:red">*</span></label>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <input type="text" id="cancel_url" name="cancel_url" class="form-control"
                                   value="<?php if (isset($config)) echo $config->cancel_url; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label" for="example-email"><?php echo ucwords("Status"); ?></label>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                            <?php
                            if (isset($config))
                                $status = $config->status;
                            else
                                $status = 0;
                            ?>
                            <select class="form-control" name="status">
                                <option value="1"
                                        <?php if ($status == 1) echo 'selected'; ?>>Enable</option>
                                <option value="0"
                                        <?php if ($status == 0) echo 'selected'; ?>>Disable</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("submit"); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!----TABLE LISTING ENDS--->

    </div>
</div>              
</div>
<!-- row --> 
</div>
</div>
<script type="text/javascript">
     $(document).ready(function () {
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

   
        $("#authorizenetconfig").validate({
            rules: {
                login_id: "required",
                transaction_key: "required",
                success_url: "required",
                failure_url: "required",
                cancel_url: "required",
            },
            messages: {
                login_id: "Please enter login id",
                transaction_key: "Please enter transaction key",
                success_url: "Please enter success url",
                failure_url: "Please enter failure url",
                cancel_url: "Please enter cancel url",
            }
        });
    });
</script>
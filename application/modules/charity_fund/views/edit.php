<?php
$this->load->model('charity_fund/Charity_fund_model');
$edit =$this->Charity_fund_model->get($param2);
?>
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel panel-default toggle panelMove panelClose panelRefresh">

            <div class="panel-body">
                <div class="">
                    <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                </div>
                <?php echo form_open(base_url() . 'charity_fund/update/' . $edit->charity_fund_id, array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'chartiyfund', 'target' => '_top')); ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("donor name"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="donor_name" id="donor_name"
                               value="<?php echo $edit->donor_name; ?>"/>
                    </div>
                </div>												
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("donor mobile"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="donor_mobile" value="<?php echo $edit->donor_mobile; ?>"/>
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("donor email"); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="donor_email" value="<?php echo $edit->email; ?>"/>
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("amount"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="amount" value="<?php echo $edit->amount; ?>"/>
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("donation method"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="donation_type" id="donation_type">
                            <option value="">Select</option>
                            <option value="cheque"
                                    <?php if ($edit->donation_type == 'cheque') echo 'selected'; ?>>Cheque</option>
                            <option value="dd"
                                    <?php if ($edit->donation_type == 'dd') echo 'selected'; ?>>DD</option>
                        </select>
                    </div>	
                </div>
                <div class="form-group cheque-details hidden">
                    <label class="col-sm-4 control-label"><?php echo ucwords("cheque nomber"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control cheque-details-fields" name="cheque_cheque_number"
                               value="<?php echo $edit->cheque_number; ?>"/>
                    </div>	
                </div>                                        
                <div class="form-group cheque-details hidden">
                    <label class="col-sm-4 control-label"><?php echo ucwords("account number"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control cheque-details-fields" name="cheque_account_number"
                               value="<?php echo $edit->account_number; ?>"/>
                    </div>	
                </div>
                <div class="form-group cheque-details hidden">
                    <label class="col-sm-4 control-label"><?php echo ucwords("account holder name"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control cheque-details-fields" name="cheque_account_holder_name"
                               value="<?php echo $edit->account_holder_name; ?>"/>
                    </div>	
                </div>
                <div class="form-group cheque-details hidden">
                    <label class="col-sm-4 control-label"><?php echo ucwords("branch code"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control cheque-details-fields" name="cheque_branch_code"
                               value="<?php echo $edit->branch_code; ?>"/>
                    </div>	
                </div>
                <div class="form-group cheque-details hidden">
                    <label class="col-sm-4 control-label"><?php echo ucwords("bank name"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control cheque-details-fields" name="cheque_bank_name"
                               value="<?php echo $edit->bank_name; ?>"/>
                    </div>	
                </div>
                <div class="form-group dd-details hidden">
                    <label class="col-sm-4 control-label"><?php echo ucwords("account number"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control dd-details-fields" name="dd_account_number"
                               value="<?php echo $edit->account_number; ?>"/>
                    </div>	
                </div>
                <div class="form-group dd-details hidden">
                    <label class="col-sm-4 control-label"><?php echo ucwords("account holder name"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control dd-details-fields" name="dd_account_holder_name"
                               value="<?php echo $edit->account_holder_name; ?>"/>
                    </div>	
                </div>
                <div class="form-group dd-details hidden">
                    <label class="col-sm-4 control-label"><?php echo ucwords("branch code"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control dd-details-fields" name="dd_branch_code"
                               value="<?php echo $edit->branch_code; ?>"/>
                    </div>	
                </div>
                <div class="form-group dd-details hidden">
                    <label class="col-sm-4 control-label"><?php echo ucwords("bank name"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input class="form-control dd-details-fields" name="dd_bank_name"
                               value="<?php echo $edit->bank_name; ?>"/>
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("date"); ?></label>
                    <div class="col-sm-8">
                        <input class="form-control datepicker-normal" readonly="" required="" type="text" name="date"
                               value="<?php echo date_formats($edit->donation_date); ?>"/>
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("description"); ?></label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="description" id="description"><?php echo $edit->description; ?></textarea>
                    </div>	
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-primary" ><?php echo ucwords("update"); ?></button>
                    </div>
                </div>
                <?php echo form_open(); ?>   
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {

        $("#chartiyfund").validate({
            rules: {
                donor_name: "required",
                amount: "required",
                donation_type: "required",
                donor_mobile: "required"
            },
            messages: {
                donor_name: "Please enter donor name",
                amount: "Please enter amount",
                donation_type: "Please select donation type",
                donor_mobile: "Please enter mobile number"
            }
        });
    });
</script>

<script>
    $(document).ready(function () {

        var donation_type = $('#donation_type').val();
        if (donation_type) {
            show_hide_information(donation_type);
        } else {
            hide_cheque_details();
            hide_dd_details();
        }

        $('#donation_type').on('change', function () {
            var donation_type = $(this).val();
            if (donation_type) {
                show_hide_information(donation_type);
            } else {
                hide_cheque_details();
                hide_dd_details();
            }
        });

        function show_hide_information(donation_type) {
            if (donation_type == 'cheque') {
                hide_dd_details();
                show_cheque_details();
            } else if (donation_type == 'dd') {
                hide_cheque_details();
                show_dd_details();

            }
        }

        function show_cheque_details() {
            $('.cheque-details').attr('class', 'form-group cheque-details');
            $('.cheque-details-fields').attr('required', 'required');
        }

        function hide_cheque_details() {
            $('.cheque-details').attr('class', 'form-group cheque-details hidden');
            $('.cheque-details-fields').removeAttr('required');
        }

        function show_dd_details() {
            $('.dd-details').attr('class', 'form-group dd-details');
            $('.dd-details-fields').attr('required', 'required');
        }

        function hide_dd_details() {
            $('.dd-details').attr('class', 'form-group dd-details hidden');
            $('.dd-details-fields').removeAttr('required');
        }
    });
   var js_date_format = '<?php echo js_dateformat(); ?>';
    $(document).ready(function () {
        $('.datepicker-normal').datepicker({
            format: js_date_format, 
            changeMonth: true,
            changeYear: true,
            minDate: new Date(),
        });
    })
</script>

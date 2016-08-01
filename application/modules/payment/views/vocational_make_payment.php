<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title><?php echo $title; ?></h4>
                            <div class="panel-controls panel-controls-right">
                                <a class="panel-refresh" href="#"><i class="fa fa-refresh s12"></i></a>
                                <a class="toggle panel-minimize" href="#"><i class="fa fa-plus s12"></i></a>
                                <a class="panel-close" href="#"><i class="fa fa-times s12"></i></a>
                            </div>
                        </div>-->
            <div class="panel-body">
                <div class="panel-heading">
                    <h4 class="panel-title">Authorize.net Process Payment</h4>
                </div>

                <form id="process_payment" class="form-horizontal form-groups-bordered validate" role="form" method="post" action="<?php echo base_url('payment/vocational_authorize_net_make_payment'); ?>">


                    <div class="form-group">
                        <label class="col-md-3 control-label">Card Number</label>
                        <div class="col-md-4">
                            <input type="text" id="card_number" class="form-control" name="card_number" required="">
                            <p id="card_status_details" class="hidden-md hidden-sm hidden-xs hidden-lg"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Card Holder Name</label>
                        <div class="col-md-4">
                            <input type="text" id="card_holder_name" name="card_holder_name" class="form-control" parsley-trigger="change" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-email">Expiry Date</label>
                        <div class="col-md-2">
                            <select id="month" name="month" class="form-control" parsley-trigger="change" required>
                                <option value="">Select month</option>
                                <?php
                                for ($i = 1; $i < 13; $i++)
                                    print("<option value=" . date('m', strtotime('01.' . $i . '.2001')) . ">" . date('M', strtotime('01.' . $i . '.2001')) . "(" . date('m', strtotime('01.' . $i . '.2001')) . ")</option>");
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="year" name="year" class="form-control" parsley-trigger="change" required>
                                <option value="">Select Year</option>
                                <?php
                                $cur_year = date('Y');
                                ?>
                                <?php
                                for ($i = $cur_year; $i <= 2050; $i++)
                                    print("<option val=" . $i . ">" . $i . "</option>");
                                ?>
                            </select>
                        </div>	                                                
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-email">CVV</label>
                        <div class="col-md-4">
                            <input type="password" id="cvv" name="cvv" class="form-control" parsley-trigger="change" required>
                        </div>
                    </div>
                    <div class="form-group">	 
                        <label class="col-md-3 control-label"></label>                                               
                        <div class="col-md-4">
                            <input class="btn btn-success" value="Submit" type="submit"></input>
                        </div>
                    </div>	                           
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Panel Widget --> 
</div>
<!-- col-sm-12--> 
</div>
<!-- row --> 
</div>

<script type="text/javascript">
   

    $().ready(function () {
        $("#process_payment").validate({
            rules: {
                card_number: "required",
                card_holder_name: "required",
                cvv: {
                    required:true,
                    number:true,
                   maxlength: 3,
                    minlength: 3
                },                        
                month: "required",
                year: "required"
            },
            messages: {
                card_number: "Enter card number",
                card_holder_name: "Enter card holder name",
                cvv: {
                    required:"Enter cvv",
                    number:"Enter only number",
                    maxlength:"Enter 3 digit code",
                    minlength:"Enter 3 digit code"
                },                     
                month: "Select month",
                year: "Select year"
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#card_number').on('blur', function () {
            var card_number = $(this).val();
            if (card_number == '') {
                $('#card_status_details').attr('class', 'hidden-xs hidden-sm hidden-md hidden-lg');
            }
            $.ajax({
                url: '<?php echo base_url(); ?>payment/verify_card_detail/' + card_number,
                type: 'post',
                success: function (content) {
                    var card_details = jQuery.parseJSON(content);
                    console.log(card_details.card_type);
                    if (card_details.status == 'false') {
                        $('#card_status_details').attr('class', 'visible-xs visible-sm	visible-md visible-lg error');
                        $('#card_status_details').html('Card: ' + card_details.card_type + '<br/>Invalid card number or details.');
                    } else if (card_details.status == 'true') {
                        $('#card_status_details').attr('class', 'visible-xs visible-sm	visible-md visible-lg warning');
                        $('#card_status_details').html('Card: ' + card_details.card_type);
                    }
                    //$('#card_status_details').attr('class', 'visible-xs visible-sm	visible-md visible-lg');
                    //$('#card_status_details').html('Card: ' + card_details.card_type);        				
                }
            })
        })
    })
</script>

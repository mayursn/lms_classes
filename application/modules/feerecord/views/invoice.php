<!-- Start .row -->
<div class="row printable">
    <div class=col-md-12>
        <!-- col-md-12 start here -->
        <div class="panel-default">
            <div class="panel-heading clearfix">
                <div class="panel-title">
                    <p style="float: right">#<?php echo 'INV-' . date('dmYhis', strtotime($invoice->paid_created_at)); ?></p>
                </div>
            </div>
            <div class=panel-body>
                <div class=you>
                    <ul class=list-unstyled>
                        <li>
                            <h3>Lore Brain</h3>
                        </li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Address:</strong> 207, campus corner 2 , Opp. Prahladnagar Garden, <br/><span style="margin-left: 25px;"></span>Anandnagar road, Prahladnagar, Ahmedabad 380015</li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>City: </strong>Ahmedabad</li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Region/State: </strong>Gujarat</li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Zip/Postal Code: </strong>380015</li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Phone:</strong> <strong class=color-red>+919909978808</strong></li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Email: </strong> <strong class=color-red>sales@searchnative.in</strong></li>
                    </ul>
                </div>
                <div class=client>
                    <ul class=list-unstyled>
                        <li>
                            <h3>Student Details</h3>
                        </li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Student Name:</strong> <?php echo $invoice->std_first_name . ' ' . $invoice->std_last_name; ?></li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Email: </strong><?php echo $invoice->email; ?><br></li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Mobile: </strong><?php echo $invoice->std_mobile; ?></li>
                        <li><i class="s16 icomoon-icon-arrow-right-3"></i><strong>Outstanding Amount: </strong><?php echo system_info('currency') . $due_amount; ?></li>
                    </ul>
                </div>
                <div class=clearfix></div>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:20px;">SR</th>
                            <th>TITLE</th>
                            <th>MODE OF PAYMENT</th>
                            <th class="text-right" style="width:120px;">AMOUNT</th>
                            <th class="text-right" style="width:120px;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>                                               
                        <tr>
                            <td class="text-center">1</td>
                            <td><?php echo $invoice->title; ?></td>
                            <td>
                                <?php
                                if($invoice->payment_type == 'cheque')
                                    echo 'Cheque';
                                else
                                    echo 'Online Banking';
                                ?>
                            </td>
                            <td class="text-left"><?php echo system_info('currency') . $invoice->paid_amount; ?></td>
                            <td class="text-right"><?php echo system_info('currency') . $invoice->paid_amount; ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class=payment>
                    
                </div>
                <div class=total>
                    <h4>Total amount:<span class=color-red> <?php echo system_info('currency') . $invoice->paid_amount; ?></span></h4>
                </div>
                <div class=clearfix></div>
                <div class=invoice-footer style="visibility: hidden">
                    <p>Thank you for your order, you will receive <strong class=color-green>5%</strong> discount in next order.</p>
                </div>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-md-12 end here -->
</div>
</div>
</div>
<!-- End .row -->

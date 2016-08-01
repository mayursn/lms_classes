<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">

            <div class=panel-body>
                <div class="tabs mb20">
                    <ul id="import-tab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#list" data-toggle="tab" aria-expanded="true"><?php echo ucwords("Academic Year"); ?></a>
                        </li>
                        <li class="">
                            <a href="#add" data-toggle="tab" aria-expanded="true"><?php echo ucwords("Add Academic Year"); ?></a>
                        </li>
                        <li class="">
                            <a href="#add2" data-toggle="tab" aria-expanded="true"><?php echo ucwords(" Set Academic Year"); ?></a>
                            
                        </li>

                    </ul>
                    <div id="import-tab-content" class="tab-content">
                        <h4 style="padding: 5px; margin: 5px;"><?php if($this->session->flashdata('flash_message')){ echo $this->session->flashdata('flash_message'); } ?></h4>
                        <div class="tab-pane fade active in" id="list">                  
                            <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                                <thead>
                                    <tr>
                                        <th><div>#</div></th>
                                        <th><div>Start Year</div></th>
                                        <th><div>End Year</div></th>  
                                        <th ><div>Start Date</div></th>                   		
                                        <th><div>End Date</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                   foreach ($academy as $row):
                                        ?>
                                   <?php    if($row->current_year_status=="active")
                                        {
                                            $css_class="border:red solid";
                                        }
                                        else
                                        {
                                            $css_class="";
                                        }
                                        ?>
                                        <tr style="<?php echo $css_class;?>">
                                            <td><?php echo $count++; ?></td>							
                                            <td><?php echo $row->start_year; ?></td>
                                            <td><?php echo $row->end_year; ?></td>
                                            <td><?php echo date("F d, Y", strtotime($row->start_date)); ?></td>
                                            <td><?php echo date("F d, Y", strtotime($row->end_date)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="add">
                            <form action="<?php echo base_url() . 'academic_year/create'; ?>" method="post" class="form-horizontal form-groups-bordered validate" id="academic_submit">
                                <div class="padded">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Start Date</label> 
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="text" placeholder="From Date" name="from_date" id="from_date" class="form-control " data-validate="required" data-message-required="" />
                                                <span style="color:#F00;" id="error_from_date" for="from_date"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">End Date</label> 
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="text" placeholder="To Date" name="to_date" id="to_date" class="form-control " data-validate="required" data-message-required="" />  
                                                <span style="color:#F00;" id="error_to_date" for="to_date"></span>
                                            </div>
                                        </div>                                
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-offset-3 col-sm-5">
                                                <button type="submit" class="btn btn-info" id="addacademi">Submit</button>
                                            </div>
                                        </div>                          	
                                    </div> 

                                </div>
                            </form>                
                        </div>
                            
                        <div class="tab-pane fade" id="add2">
                          <form action="<?php echo base_url() . 'academic_year/update_academic_year/'; ?>" method="post" class="form-horizontal form-groups-bordered validate" id="academic_submit">
                        <div class="padded">
                         <div class="form-group">
                                <label class="col-sm-2 control-label">Academic Year</label>
                                <div class="col-sm-5">
                                    <select name="set_academic_year" class="form-control" style="width:100%;" data-validate="required">
                                        <option value="">Select year </option>
                                        <?php 
                                        $academic_year = $this->db->get('academic_year')->result_array();
                                        foreach($academic_year as $row):
                                        ?>
                                            <option value="<?php echo $row['academic_id'];?>" <?php if($row['current_year_status']=="active"){echo "selected";} ?>>
                                            <?php echo date("d-M-Y",strtotime($row['start_date'])) ." TO ".date("d-M-Y",strtotime($row['end_date']));?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-5">
                                <button type="submit" class="btn btn-info" id="addacademi">Set</button>
                            </div>
                          </div> 
                            
                          </div>
                    </form>      
                            </div>
                        
                        
                    </div>
                </div>
            </div>
            <!-- End .panel -->
        </div>
        <!-- col-lg-12 end here -->
    </div>
    <!-- End .row -->
</div></div></div>
<!-- End contentwrapper -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    var js_format = '<?php echo js_dateformat(); ?>';
    jQuery(document).ready(function ($) {
        var start_date = $('#from_date').val();
        $('#from_date').datepicker({
            format: js_format,
            startDate: new Date(),
            autoclose: true

        });
        $('#to_date').datepicker({
            format: js_format,
            startDate: new Date(),
            autoclose: true
        });




  
    });
    var form = $("#academic_submit").val();
      $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {

        $("#academic_submit").validate({
            rules: {              
                from_date: "required",  
                end_date :"required",
                
            },
            messages: {                
                from_date: "Enter Start Date.",  
                end_date :"Enter End Date",
            }
        });


    });

</script>
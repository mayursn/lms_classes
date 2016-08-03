<!-- Start .row -->
<div class=row>
     <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="col-lg-5 col-md-5 col-xs-5">
        <!-- col-lg-4 start here -->
        <div class="panel panel-default toggle">
            <!-- Start .panel -->
            <div class=panel-heading>
                <h4 class=panel-title>Profile details</h4>
            </div>
            <div class=panel-body>
                <div class="row profile">
                    <!-- Start .row -->
                    <div class=col-md-4>
                        <div class=profile-avatar>
                            <?php if ($profile->profile_photo != "") { ?>    
                            <img alt="" src="<?php echo base_url('uploads/system_image/' . $profile->profile_pic); ?>" width="128" height="128" id="manage_profile">
                            <?php } else { ?>
                                <img alt="example image" style="width: 128px; height: 128px" src="<?php echo base_url('assets/img/avatar.jpg'); ?>" id="manage_profile">
                            <?php } ?>
                        </div>
                    </div>
                    <div class=col-md-8>
                        <div class=profile-name>
                            <h4><?php echo $profile->std_first_name . ' ' . $profile->std_last_name; ?></h4>
                            <p class="job-title mb0"><i class="fa fa-building"></i> <?php echo $profile->branch_location; ?></p>
                            <br/><p><i class="fa fa-envelope"></i> <?php echo $profile->email; ?></p>
                            <br/><p><i class="fa fa-phone"></i><?php echo $profile->std_mobile; ?></p>
                        </div>
                    </div>
                </div>

                <div class=col-md-12>
                    <br/>
                    <div class="contact-info ">
                        <div class=row>
                            <!-- Start .row -->
                            <div class=col-md-6>
                                <dl class=mt20>
                                    <input type='hidden' name="stdid" id="stdid" value="<?php echo $profile->std_id;?>" />
                                    <dt class=text-muted>First Name
                                    <dd><?php echo $profile->first_name; ?>
                                    <dt class=text-muted>Roll No
                                    <dd><?php echo $profile->std_roll; ?>
                                    <dt class=text-muted>Mobile
                                    <dd><?php echo $profile->mobile; ?>
                                    <dt class=text-muted>Branch
                                    <dd><?php echo $profile->branch_name.' - '.$profile->branch_location; ?>
                                    <dt class=text-muted>Course
                                    <dd><?php echo $profile->c_name; ?>
                                    <dt class=text-muted>Admission Plan
                                    <dd><?php echo $profile->admission_duration; ?>    
                                </dl>
                            </div>
                            <div class=col-md-6>
                                <dl class=mt20>
                                    <dt class=text-muted>Last Name
                                    <dd><?php echo $profile->last_name; ?>
                                    <dt class=text-muted>Gender
                                    <dd><?php echo $profile->gender; ?>
                                    <dt class=text-muted>Email
                                    <dd><?php echo $profile->email; ?>
                                </dl>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
            </div>
            <!-- End .row -->
        </div>
    </div>

    <div class="col-lg-7 col-md-7 col-xs-7">
        <!-- col-lg-4 start here -->
        <div class="panel panel-default toggle">
            <!-- Start .panel -->
            <div class=panel-heading>
                <h4 class=panel-title>Exam Mark Detail</h4>
            </div>  
            <div class=panel-body>
                 <label class="col-sm-3 control-label" style="margin-top: 10px;">Select Exam</label>
                <div class=col-md-6>
                    <select class="form-control" id="exam" name="exam">
                          <option value="">Select</option>
                          <?php foreach ($exam_listing as $row) { ?>
                            <option value="<?php echo $row->em_id; ?>"><?php echo $row->em_name; ?></option>
                                <?php } ?>
                    </select>
                </div>
                 <div class="">
                    <div id="marksdetail" class=col-md-12>

                   </div>
                </div>
            </div>
          
            <!-- End .row -->
        </div>
    </div>

    

</div>
</div>

</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
</div>
<script>
    $(document).ready(function () {
        $('#exam').on('change', function () {
             var exam_id = $(this).val();
             var student_id = $("#stdid").val();
             if(exam_id !='')
             {
                    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>student/student_exam_marks",
                    data: 
                    {
                        exam_id:exam_id,
                        student_id:student_id,
                    },
                    success: function (response) {
                        $("#marksdetail").html('');
                        $("#marksdetail").html(response);
                            $('#data-table').DataTable({"language": { "emptyTable": "No data available" }});
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#submitted-assignment-datatable-list').DataTable({"language": { "emptyTable": "No data available" }});
      });
</script>
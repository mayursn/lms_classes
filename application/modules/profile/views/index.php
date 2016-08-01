<!-- Start .row -->
<div class=row>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <!-- col-lg-4 start here -->
        <div class="panel panel-default">
            <!-- Start .panel -->
            <div class=panel-heading>
                <h4 class=panel-title>Profile details</h4>
            </div>
            <div class=panel-body>
                <div class="row profile">
                    <!-- Start .row -->
                    <div class=col-md-4>
                        <div class=profile-avatar>
                            <?php if ($profile[0]->profile_pic != "") { 
                               
                                ?>
                                    <img alt="" src="<?php echo base_url('uploads/system_image/'.$profile[0]->profile_pic); ?>" width="128" height="128" id="manage_profile">
                                <?php
                                }
                                else { ?>
                                <img alt="example image" style="width: 128px; height: 128px" src="<?php echo base_url('assets/img/avatar.jpg'); ?>" id="manage_profile">
                            <?php } ?>
                        </div>
                    </div>
                    <div class=col-md-8>
                        <div class=profile-name>
                            <h4><?php echo $profile[0]->first_name . ' ' . $profile[0]->last_name; ?></h4>
                            <p class="job-title mb0"><i class="fa fa-building"></i> <?php echo $profile[0]->role_name; ?></p>
                            <br/><p><i class="fa fa-envelope"></i> <?php echo $profile[0]->email; ?></p>
                            <br/><p><i class="fa fa-phone"></i><?php echo $profile[0]->mobile; ?></p>
                        </div>
                    </div>
                </div>

                <div class=col-md-12>
                    <br/>
                    <div class="contact-info ">
                        <div class=row>
                            <!-- Start .row -->
                            <div class=col-md-4>
                                <dl class=mt20>
                                    <dt class=text-muted>First Name
                                    <dd><?php echo $profile[0]->first_name; ?>
                                    <dt class=text-muted>Mobile
                                    <dd><?php echo $profile[0]->mobile; ?>
                                    <dt class=text-muted>Role
                                    <dd><?php echo $profile[0]->role_name; ?>
                                    <dt class=text-muted>City
                                    <dd><?php echo $profile[0]->city; ?>
                                </dl>
                            </div>
                            <div class=col-md-8>
                                <dl class=mt20>
                                    <dt class=text-muted>Last Name
                                    <dd><?php echo $profile[0]->last_name; ?>
                                    <dt class=text-muted>Email
                                    <dd><?php echo $profile[0]->email; ?>
                                    <dt class=text-muted>Gender
                                    <dd><?php echo $profile[0]->gender; ?>
                                    <dt class=text-muted>Zip Code
                                    <dd><?php echo $profile[0]->zip_code; ?>
                                    
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

    <div class="col-lg-6 col-md-6 col-sm-12">
        <!-- col-lg-4 start here -->
        <div class="tabs mb20">
            <ul id=profileTab class="nav nav-tabs">
                <li class="active"><a href="#change-password" data-toggle=tab>Change Password</a></li>
               <?php 
               if($this->session->userdata('role_name')!="Student")
               {
               ?> <li><a href="#editprofile" data-toggle=tab>Edit Profile</a></li>
                <?php
               }
if($this->session->userdata('role_name')=='Student')
               {
                   ?>
                <li><a href="#studentprofile" data-toggle=tab>Edit Profile</a></li>
                <?php
               }
                ?>
            </ul>
            <div id="mytab" class=tab-content style="overflow-y: scroll;height:400px">
                <div class="tab-pane fade active in" id="change-password">
                    <?php
                    $message = $this->session->flashdata('message');
                    if ($message != '') {
                        ?>
                        <div class="alert alert-success">
                            <button class="close" data-dismiss="alert">&times;</button>
                            <p><?php echo $message; ?></p>
                        </div>    
                    <?php } ?>

                    <?php if (isset($error) && $error != '') { ?>
                        <div class="alert alert-danger">
                            <button class="close" data-dismiss="alert">&times;</button>
                            <p><?php echo $error; ?></p>
                        </div> 
                    <?php } ?>  
                    <form class="form-horizontal group-border stripped" role=form action="<?php echo base_url() . 'profile/change_password'?>"
                          method="post" enctype="multipart/form-data" name="frmchangepassword" id="frmchangepassword" >
                        <div class=form-group>
                            <label class="col-lg-3 control-label" for="">Current Password<span style="color:red">*</span></label>
                            <div class=col-lg-9>
                                <input class="form-control" type="hidden" name="oldpassword" id="oldpassword" value="<?php echo $profile[0]->password?>">
                                <input class="form-control"  type="password" name="password" id="password" value="" placeholder="">
                            </div>
                        </div>
                        <!-- End .form-group  -->
                        <div class=form-group>
                            <label class="col-lg-3 control-label" for="">New Password<span style="color:red">*</span></label>
                            <div class=col-lg-9>
                                <input class="form-control"  type="password" name="new_password" id="new_password" value="" placeholder="">
                            </div>
                        </div>
                        <!-- End .form-group  -->
                        <div class=form-group>
                            <label class="col-lg-3 control-label" for="">Confirm Password<span style="color:red">*</span></label>
                            <div class=col-lg-9>
                                <input class="form-control" type="password" name="confirm_password" id="confirm_password" value="" placeholder="">
                            </div>
                        </div>
                        <!-- End .form-group  -->

                        <div class=form-group>
                            <div class="col-lg-9 col-lg-offset-3">
                                <input type="submit" value="Change Password" class="btn btn-primary"/>
                            </div>
                        </div>
                        <!-- End .form-group  -->
                    </form>
                </div>
                 <div id="editprofile" class="tab-pane fade out">
                     <form class="form-horizontal group-border stripped" role=form action="<?php echo base_url() . 'profile/change_profile'?>"
                          method="post" enctype="multipart/form-data" name="frmchangeprofile" id="frmchangeprofile" >
                        <div class=form-group>
                            <label class="col-sm-3 control-label">First Name<span style="color:red">*</span></label> 
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="<?php echo $profile[0]->first_name; ?>" name="fname" id="fname" placeholder="first name">
                             </div>
                        </div>
                        <!-- End .form-group  -->
                        <div class=form-group>
                            <label class="col-sm-3 control-label">Last Name<span style="color:red">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" value="<?php echo $profile[0]->last_name; ?>" name="lname" id="lname" placeholder="last name">
                            </div>
                        </div>
                        <!-- End .form-group  -->
                        <div class=form-group>
                            <label class="col-sm-3 control-label">Email<span style="color:red">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" readonly="" type="email" value="<?php echo $profile[0]->email; ?>" name="email" id="email" placeholder="email@yourcompany.com">
                            </div>
                        </div>
                        <!-- End .form-group  -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Gender</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="gender" id="gender">
                                    <option value="Male"
                                            <?php if($profile[0]->gender == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female"
                                            <?php if($profile[0]->gender == 'Female') echo 'selected'; ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mobile Phone<span style="color:red">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" name="mobile" id="mobile" value="<?php echo $profile[0]->mobile; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City<span style="color:red">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" name="city" id="city" value="<?php echo $profile[0]->city; ?>"/>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Zip Code<span style="color:red">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" name="zip" id="zip" value="<?php echo $profile[0]->zip_code; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Profile Photo"); ?></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="userfile" id="userfile"/>
                                <span id="imgerror" style="color:red;"></span>
                            </div>
                        </div>
                        <div class=form-group>
                            <div class="col-lg-9 col-lg-offset-3">
                                <input type="submit" value="Update" class="btn btn-primary"/>
                            </div>
                        </div>
                        <!-- End .form-group  -->
                    </form>
                </div>
                <?php
                 if($this->session->userdata('role_name')=='Student')
                     {
                   ?>
                <div id="studentprofile" class="tab-pane fade out">
                     <form class="form-horizontal group-border stripped" role=form action="<?php echo base_url() . 'profile/student_change_profile'?>"
                          method="post" enctype="multipart/form-data" name="frmstudentprofile" id="frmstudentprofile" >
                       <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Parent Name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="parentname" id="parentname" value="<?php echo $studentprofile->parent_name?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Parent Contact No"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="parentcontact" id="parentcontact" value="<?php echo $studentprofile->parent_contact?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Parent Email Id"); ?><span style="color:red"></span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="parent_email_id" id="parent_email_id" value="<?php echo $studentprofile->parent_email?>"/>
                            <span id="emailerror" style="color: red"></span>
                        </div>
                    </div>
                         <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Facebook URL"); ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo $studentprofile->std_fb?>"/>
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Twitter URL"); ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="twitter" id="twitter" value="<?php echo $studentprofile->std_twitter?>"/>
                        </div>
                    </div>	
                        <div class=form-group>
                            <div class="col-lg-9 col-lg-offset-3">
                                <input type="submit" value="Update" class="btn btn-primary"/>
                            </div>
                        </div>
                        <!-- End .form-group  -->
                    </form>
                </div>
                <?php
                     }
                   ?>
            </div>
           
        </div>
        
        <!-- End .tabs -->
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
      
        $("#frmchangepassword").validate({
            rules: {
                password: 
                        {
                            required:true,
                            remote:
                                    {
                                        url: "<?php echo base_url(); ?>profile/checkpassword",
                                       type: "post",
                                       data: {
                                           currentpassword: function () {
                                               return $("#password").val();
                                           },
                                           oldpassword: function () {
                                               return $("#oldpassword").val();
                                           }
                                       }
                                    }
                            
                        },
                new_password: "required",
                confirm_password: 
                        {
                            required:true,
                             equalTo: "#new_password"
                        },
            },
            messages: {
                password: 
                    {
                        required:"Enter current password",
                        remote:"Current password is worng",
                    },
                new_password: "Enter new password",
                confirm_password: 
                    {
                        required:"Enter confirm password",
                        equalTo:"Enter valid confirm password"
                    },
            }
        });
         $("#frmchangeprofile").validate({
            rules: {
                fname: "required",
                lname: "required",
                email: "required",
                gender: "required",
                mobile: "required",
                city: "required",
                zip: "required",
            },
            messages: {
                fname: "Enter first name",
                lname: "Enter last name",
                email: "Enter email",
                gender: "Select gender",
                mobile: "Enter mobile no",
                city: "Enter city",
                zip: "Enter zip",
            }
        });
         $("#frmstudentprofile").validate({
            rules: {
                parentname: "required",
                parentcontact: "required",
//                parent_email_id: "required",
//                facebook: "required",
//                twitter: "required",
            },
            messages: {
                parentname: "Enter first name",
                parentcontact: "Enter last name",
//                parent_email_id: "Enter email",
//                facebook: "Select gender",
//                twitter: "Enter mobile no",
            }
        });
    });
    
</script>
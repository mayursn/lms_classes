<?php
$degree = $this->db->get('degree')->result_array();
$courses = $this->db->get('course')->result_array();
$semesters = $this->db->get('semester')->result_array();
?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class="panel-body"> 

                <div class="box-content">
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div >                                    
                    <?php echo form_open(base_url() . 'chancellor/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmchancellor', 'target' => '_top', "enctype" => "multipart/form-data")); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Name"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" />
                            </div>
                        </div>												

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Email Id"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email_id" id="email_id"  />
                                <span id="emailerror" style="color: red"></span>
                            </div>
                        </div>                            
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("speciality"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="designation" id="designation" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Mobile No"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="mobileno" id="mobileno" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Facebook URL"); ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="facebook" id="facebook" />
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Twitter URL"); ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="twitter" id="twitter" />
                            </div>
                        </div>	

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("google plus link"); ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="googleplus" id="googleplus" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Profile Photo"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="profilefile" id="profilefile"  />
                                <span id="imgerror" style="color:red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description" ></textarea>
                            </div>
                        </div>	
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                            </div>
                        </div>
                        </form>               
                    </div>                
                </div>
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

        $("#birthdate").datepicker({
             format: ' MM d, yyyy', startDate : new Date(),
            maxDate: 0,
            autoclose:true
        });

        jQuery.validator.addMethod("mobile_no", function (value, element) {
            return this.optional(element) || /^[0-9-+]+$/.test(value);
        }, 'Please enter a valid contact no.');
        jQuery.validator.addMethod("email_id", function (value, element) {
            return this.optional(element) || /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(value);
        }, 'Please enter a valid email address.');

        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z ]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("zip_code", function (value, element) {
            return this.optional(element) || /^[0-9]+$/.test(value);
        }, 'Please enter a valid zip code.');

        $("#frmchancellor").validate({
            rules: {
                name:
                        {
                            required: true,
                            character: true,
                        },
                email_id:
                        {
                            required: true,
                            email_id: true,
                        },
                mobileno:
                        {
                            required: true,
                            maxlength: 11,
                            mobile_no: true,
                            minlength: 10,
                        },
                facebook:
                        {
                            url2: true,
                        },
                twitter:
                        {
                            url2: true,
                        },
                googleplus:
                        {
                            url2: true,
                        },
                admissiontype: "required",
                designation: "required",
                profilefile: {
                    required: true,
                    extension: 'gif|png|jpg|jpeg',
                }
            },
            messages: {
                name:
                        {
                            required: "Enter name",
                            character: "Enter valid name",
                        },
                email_id: {
                    required: "Enter email id",
                    email_id: "Enter valid email id",
                },
                mobileno:
                        {
                            required: "Enter mobile no",
                            maxlength: "Enter maximum 10 digit number",
                            mobile_no: "Enter valid mobile number",
                            minlength: "Enter minimum 10 digit number",
                        },
                designation: "Enter designation",
                profilefile: {
                    required: "Upload image",
                    extension: "Upload valid file",
                }
            }
        });
    });
</script>
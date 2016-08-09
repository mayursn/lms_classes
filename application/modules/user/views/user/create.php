<?php
$roles = $this->db->where_not_in('role_name', array('Student', 'Professor'))->order_by('role_name', 'ASC')->get('role')->result();
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body"> 

                <div class="box-content">     
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                    
                    <?php echo form_open(base_url() . 'user/user/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'user-create-form', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">First Name <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="first_name" id="first_name"/>
                            </div>
                        </div>												
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Middle Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="middle_name" id="middle_name"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Last Name <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="last_name" id="last_name"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" 
                                       autocomplete="off" id="email" value=""/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" value="12345" readonly="" name="password" id="password"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Gender</label>
                            <div class="col-sm-8">
                                <select id="gender" name="gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Mobile <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="number" maxlength="10" class="form-control" name="mobile" id="mobile"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Phone <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input  type="number" maxlength="10" class="form-control" name="phone" id="phone"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">City</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="city" id="city"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Zip Code <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="number" maxlength="6" class="form-control" name="zip_code" id="zip_code"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address</label>
                            <div class="col-sm-8">
                                <textarea id="address" class="form-control" name="address"></textarea>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Role <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <select id="role" class="form-control" name="role">
                                    <option value="">Select</option>
                                    <?php foreach ($roles as $role) { ?>
                                        <option value="<?php echo $role->role_id; ?>"><?php echo $role->role_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>	
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green" ><?php echo ucwords("add"); ?></button>
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


    $().ready(function () {

        $("#user-create-form").validate({
            rules: {
                first_name: "required",
                last_name: "required",
                email: {
                            required: true,
                            email: true,
                            remote: {
                                url: "<?php echo base_url(); ?>user/check_user_email",
                                type: "post",
                                data: {
                                     email: function () {
                                        return $("#email").val();
                                    },
                                }
                            }
                        },
                'mobile': {
                        required:true,
                        phoneUS: true,
                },
                'phone': {
                        required:true,
                        phoneUS: true,
                },
                city: "required",
                zip_code: "required",
                role: "required",
            },
            messages: {
                 first_name: "Enter first name",
                last_name: "Enter last name",
                email: {
                    required: "Enter email id",
                    email: "Enter valid email id",
                    remote: "Email id already exists",
                },
                'mobile': {
                        required:"Enter mobile no",
                        phoneUS: "Enter valid mobile no",                       
                },
                'phone':{
                        required:"Enter phone no",
                        phoneUS: "Enter valid phone no",                       
                },
                city: "Enter city",
                zip_code: "Enter zip code",
                role: "Select role",
            }
        });
    });
</script>
<?php
$roles = $this->db->where_not_in('role_name', array('Student', 'Professor'))->order_by('role_name', 'ASC')->get('role')->result();
$this->load->model('user/User_model');
$this->load->model('user/Role_model');
$user = $this->User_model->with('role')->get($param2);
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
                    <?php echo form_open(base_url() . 'user/user/update/' . $user->user_id, array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'user-create-form', 'target' => '_top')); ?>
                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">First Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                       value="<?php echo $user->first_name; ?>"/>
                            </div>
                        </div>												
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Middle Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="middle_name" id="middle_name"
                                       value="<?php echo $user->middle_name; ?>"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Last Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                       value="<?php echo $user->last_name; ?>"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" 
                                       autocomplete="off" id="email" value="<?php echo $user->email ?>" readonly=""/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" value="<?php echo $user->password ?>" name="password" id="password"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Gender</label>
                            <div class="col-sm-8">
                                <select id="gender" name="gender" class="form-control">
                                    <option value="Male"
                                            <?php if($user->gender == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female"
                                            <?php if($user->gender == 'Female') echo 'selected'; ?>>Female</option>
                                </select>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Mobile</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="mobile" id="mobile"
                                       value="<?php echo $user->mobile; ?>"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Phone</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="phone" id="phone"
                                       value="<?php echo $user->phone; ?>"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">City</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="city" id="city"
                                       value="<?php echo $user->city; ?>"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Zip Code</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="zip_code" id="zip_code"
                                       value="<?php echo $user->zip_code; ?>"/>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address</label>
                            <div class="col-sm-8">
                                <textarea id="address" class="form-control" name="address"><?php echo $user->address; ?></textarea>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Role</label>
                            <div class="col-sm-8">
                                <select id="role" class="form-control" name="role">
                                    <option value="">Select</option>
                                    <?php foreach ($roles as $role) { ?>
                                        <option value="<?php echo $role->role_id; ?>"
                                                <?php if($user->role_id == $role->role_id) echo 'selected'; ?>><?php echo $role->role_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>	
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Status</label>
                            <div class="col-sm-8">
                                <select id="role" class="form-control" name="status">
                                    <option value="">Select</option>
                                    <option value="1"
                                            <?php if($user->is_active == 1) echo 'selected'; ?>>Active</option>
                                    <option value="0"
                                            <?php if($user->is_active == 0) echo 'selected'; ?>>Inactive</option>
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
                role_name: "required",
                status: "required",
            },
            messages: {
                role_name: "Enter role name",
                status: "Select status",
            }
        });
    });
</script>
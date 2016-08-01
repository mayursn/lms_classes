<?php
$this->load->model('department/Degree_model');
$this->load->model('admission_type/Admission_type_model');
$this->load->model('classes/Class_model');

$department = $this->Degree_model->order_by_column('d_name');
$admission_type = $this->Admission_type_model->order_by_column('at_name');
$class = $this->Class_model->order_by_column('class_name');
?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class="panel-body"> 
                <div class="">
                    <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                </div>   

                <?php echo form_open(base_url() . 'student/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmstudent', 'target' => '_top', "enctype" => "multipart/form-data")); ?>
                <div class="padded">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("First Name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="f_name" id="f_name" />
                        </div>
                    </div>												
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Last Name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="l_name" id="l_name" />
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
                        <label class="col-sm-4 control-label"><?php echo ucwords("Password"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="password" value="12345"/>
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Gender"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="radio" name="gen" value="male" >Male
                            <input type="radio" name="gen" value="female" >Female
                        </div>
                        <div class="col-sm-5">
                            <label for="gen" class="error"></label></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Parent Name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="parentname" id="parentname"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Parent Contact No"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="parentcontact" id="parentcontact"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Parent Email Id"); ?><span style="color:red"></span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="parent_email_id" id="parent_email_id"  />
                            <span id="emailerror" style="color: red"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Address"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="address" id="address" ></textarea>
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("City"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="city" id="city" />
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Zip"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="zip" id="zip" />
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Birth Date"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control datepicker-normal" name="birthdate"/>
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Marital Status"); ?></label>
                        <div class="col-sm-8">
                            <select name="maritalstatus" class="form-control" id="maritalstatus">
                                <option value="">Select</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="separated">Separated</option>
                                <option value="widowed">Widowed</option>
                            </select>
                        </div>
                    </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("department"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="degree" class="form-control" id="degree">
                                <option value="">Select</option>
                                <?php foreach ($department as $row) { ?>
                                    <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                <?php } ?>                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="course" class="form-control" id="course">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Batch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="batch" class="form-control" id="batch">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>	

                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Semester"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="semester" class="form-control" id="semester">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("class"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="class" class="form-control" id="class">
                                <option value="">Select</option>
                                <?php foreach ($class as $row) { ?>
                                    <option value="<?php echo $row->class_id; ?>"><?php echo $row->class_name; ?></option>
                                <?php } ?>                                
                            </select>
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
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Type"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="admissiontype" class="form-control" id="admissiontype">
                                <option value="">Select</option>
                                <?php foreach ($admission_type as $row) { ?>
                                    <option value="<?php echo $row->at_id; ?>"><?php echo $row->at_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Profile Photo"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="profilefile" id="profilefile" />
                            <span id="imgerror" style="color:red;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="std_about" id="std_about" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                        <div class="col-sm-8">
                            <select name="status"  class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>	
                            </select>
                            <lable class="error" id="error_lable_exist" style="color:red"></lable>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("Add"); ?></button>
                        </div>
                    </div>            
                </div>   
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#degree').on('change', function () {
        var department_id = $(this).val();
        department_branch(department_id);
    });
    $('#course').on('change', function () {
        var branch_id = $(this).val();
        var department = $('#degree').val();
        batch_from_department_branch(department, branch_id);
        semester_from_branch(branch_id);
    });

    function department_branch(department_id) {
        $('#course').find('option').remove().end();
        $('#course').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
            type: 'GET',
            success: function (content) {
                var branch = jQuery.parseJSON(content);
                console.log(branch);
                $.each(branch, function (key, value) {
                    $('#course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                });
            }
        });
    }

    function batch_from_department_branch(department, branch) {
        $('#batch').find('option').remove().end();
        $('#batch').append('<option value>Select</option>');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>batch/department_branch_batch/" + department + '/' + branch,
            success: function (response) {
                var branch = jQuery.parseJSON(response);
                $.each(branch, function (key, value) {
                    $('#batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                });
            }
        });
    }

    function semester_from_branch(branch) {
        $('#semester').find('option').remove().end();
        $('#semester').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
            type: 'GET',
            success: function (content) {
                var semester = jQuery.parseJSON(content);
                $.each(semester, function (key, value) {
                    $('#semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                });
            }
        });
    }

    $.validator.setDefaults({
        submitHandler: function (form) {

            //  filecheck(img);
            form.submit();

        }
    });

    $(".basic-datepicker").datepicker({format: 'MM d, yyyy', autoclose: true});
    $(document).ready(function () {
        $(".datepicker-normal").datepicker({
            format: 'MM d, yyyy',
            endDate: new Date(),
            autoclose: true,
            changeMonth: true,
            changeYear: true,
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

        $("#frmstudent").validate({
            rules: {
                name:
                        {
                            required: true,
                            character: true,
                        },
                f_name:
                        {
                            required: true,
                            character: true,
                        },
                l_name:
                        {
                            required: true,
                            character: true,
                        },
                email_id:
                        {
                            required: true,
                            email: true,
                            remote: {
                                url: "<?php echo base_url(); ?>user/check_user_email",
                                type: "post",
                                data: {
                                     email: function () {
                                        return $("#email_id").val();
                                    },
                                }
                            }
                        },
                password: "required",
                gen: "required",
                birthdate: "required",
                mobileno:
                        {
                            required: true,
                            maxlength: 11,
                            mobile_no: true,
                            minlength: 10,
                        },
                parentname: {
                    required: true,
                    character: true,
                },
                parentcontact: {
                    required: true,
                    maxlength: 11,
                    mobile_no: true,
                    minlength: 10,
                },
                parent_email_id: {
                    email_id: true,
                },
                city:
                        {
                            required: true,
                            character: true,
                        },
                zip:
                        {
                            required: true,
                            zip_code: true,
                        },
                address: "required",
                degree: "required",
                course: "required",
                batch: "required",
                semester: "required",
                class: "required",
                facebook:
                        {
                            url2: true,
                        },
                twitter:
                        {
                            url2: true,
                        },
                admissiontype: "required",
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
                f_name:
                        {
                            required: "Enter first name",
                            character: "Enter valid name",
                        },
                l_name:
                        {
                            required: "Enter last name",
                            character: "Enter valid name",
                        },
                email_id: {
                    required: "Enter email id",
                    email_id: "Enter valid email id",
                    remote: "Email id already exists",
                },
                password: "Enter password",
                gen: "Slect gender",
                birthdate: "Select birthdate",
                mobileno:
                        {
                            required: "Enter mobile no",
                            maxlength: "Enter maximum 10 digit number",
                            mobile_no: "Enter valid mobile number",
                            minlength: "Enter minimum 10 digit number",
                        },
                parentname: {
                    required: "Enter parent name",
                    character: "Enter valid name",
                },
                parentcontact: {
                    required: "Enter mobile no",
                    maxlength: "Enter maximum 10 digit number",
                    mobile_no: "Enter valid mobile number",
                    minlength: "Enter minimum 10 digit number",
                },
                parent_email_id: {
                    email_id: "Enter valid email id",
                },
                city:
                        {
                            required: "Enter city",
                            character: "Enter valid city name",
                        },
                address: "Enter address",
                zip:
                        {
                            required: "Enter zip code",
                        },
                degree: "Select department",
                course: "Select branch",
                batch: "Select batch",
                semester: "Select semester",
                class: "Select class",
                admissiontype: "Select admission type",
                profilefile: {
                    required: "Upload image",
                    extension: "Upload valid file",
                }
            }
        });
    });
</script>

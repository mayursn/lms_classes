<?php
$this->load->model('department/Degree_model');
$this->load->model('admission_type/Admission_type_model');
$this->load->model('classes/Class_model');
$this->load->model('branch/Branch_location_model');
$this->load->model('courses/Course_model');

$branch = $this->Branch_location_model->order_by_column('branch_name');
$course = $this->Course_model->order_by_column('c_name');
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
                        <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="branch" class="form-control" id="create-branch">
                                <option value="">Select</option>
                                <?php foreach ($branch as $row) { ?>
                                    <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                <?php } ?>                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="course" class="form-control" id="create-course">
                                <option value="">Select</option>
                                <?php foreach($course as $rowcourse): ?>
                                <option value="<?php echo $rowcourse->course_id; ?>"><?php echo $rowcourse->c_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="admission_plan" class="form-control" id="create-admission_plan">
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
    $('#branch').on('change', function () {
        var branch_id = $(this).val();
       // get_branch(department_id);
    });
    $('#create-course').on('change', function () {
        var course_id = $(this).val();
        
        get_admission_plan(course_id);
        
    });
    function get_admission_plan(course_id)
    {
     $('#create-admission_plan').find('option').remove().end();
        $('#create-admission_plan').append('<option value>Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);
                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#create-admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
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

         jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, ""); 
                    return this.optional(element) || phone_number.length > 9 &&
                            phone_number.match(/^[0-9]{3}[0-9]{3}[0-9]{4}$/);
            }, "Enter valid mobile number");

        jQuery.validator.addMethod("email_id", function (value, element) {
            return this.optional(element) || /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(value);
        }, 'Please enter a valid email address.');

        jQuery.validator.addMethod("character", function (value, element) {
            return this.optional(element) || /^[A-z ]+$/.test(value);
        }, 'Please enter a valid character.');

        jQuery.validator.addMethod("zip_code", function (value, element) {
            return this.optional(element) || /^\d{6}(?:-\d{4})?$/.test(value);
        }, 'Enter valid zip code');

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
                           phoneUS: true,
                        },
                parentname: {
                    required: true,
                    character: true,
                },
                parentcontact: {
                    required: true,
                    phoneUS: true,
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
                branch: "required",
                course: "required",
                admission_plan: "required",                
                class: "required",
                facebook:
                        {
                            url2: true,
                        },
                twitter:
                        {
                            url2: true,
                        },                
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
                        },
                parentname: {
                    required: "Enter parent name",
                    character: "Enter valid name",
                },
                parentcontact: {
                    required: "Enter mobile no",
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
                branch: "Select department",
                course: "Select branch",
                admission_plan: "Select batch",                
                class: "Select class",                
                profilefile: {
                    required: "Upload image",
                    extension: "Upload valid file",
                }
            }
        });
    });
</script>

<?php
    $this->db->select('s.*,u.*');
    $this->db->where('s.user_id',$param2);
    $this->db->from('student s');
    $this->db->join('user u','u.user_id=s.user_id');
    $edit_data= $this->db->get()->result_array();
    $this->load->model('admission_plan/Admission_plan_model');
$this->load->model('classes/Class_model');
$this->load->model('courses/Course_model');
$course = $this->Course_model->order_by_column('c_name');
$admission_plan = $this->Admission_plan_model->order_by_column('admission_duration');
foreach ($edit_data as $row):
    ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default toggle panelMove panelClose panelRefresh">
                <div class="panel-body">
                    <div class="tab-pane box" id="add" style="padding: 5px">
                        <div class="box-content">  
                            <div class="">
                                <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                            </div>
                            <form name="frmstudentedit" id="frmstudentedit" method="post" action="<?= base_url() ?>student/update/<?php echo $row['user_id'] ?>" enctype="multipart/form-data" class="form-horizontal form-groups-bordered validate"> 
                                <input type="hidden" name="txtuserid" id="txtuserid" value="<?php echo $row['user_id'];?>">
                                <input type="hidden" name="studentid" id="studentid" value="<?php echo $row['std_id']?>">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("First Name"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                            <input type="text" class="form-control" name="f_name" id="f_name" value="<?php echo $row['first_name']; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Last Name"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="l_name" id="l_name" value="<?php echo $row['last_name'] ?>"/>
                                    </div>
                                </div>												
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Email Id"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="email_id" id="email_id" value="<?php echo $row['email'] ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Password"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" readonly name="password" id="password"  value="12345" />
                                    </div>
                                </div>	
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Gender"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <?php
                                        $male = "";
                                        $female = "";
                                        if ($row['gender'] == 'Male') {
                                            $male = 'checked';
                                        } else {
                                            $female = 'checked';
                                        }
                                        ?>
                                        <input type="radio" name="gen" value="male" <?php echo $male; ?> >Male
                                        <input type="radio" name="gen" value="female" <?php echo $female; ?>>Female
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Address"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="address" id="address"><?php echo $row['address'] ?></textarea>
                                    </div>
                                </div>	
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("City"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="city" id="city" value="<?php echo $row['city'] ?>"/>
                                    </div>
                                </div>	
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Zip"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="zip" id="zip" value="<?php echo $row['zip_code'] ?>"/>
                                    </div>
                                </div>	
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Birth Date"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="birthdate" id="basic-datepicker" value="<?php echo date("F d, Y",strtotime($row['std_birthdate'])); ?>" />
                                    </div>
                                </div>	
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <?php $this->load->model('branch/Branch_location_model'); 
                            $branch = $this->Branch_location_model->order_by_column('branch_name');
                            ?>
                            <select name="branch" class="form-control" id="branch">
                                <option value="">Select</option>
                                <?php foreach ($branch as $rows) { ?>
                                    <option value="<?php echo $rows->branch_id; ?>" <?php if($row['branch_id']==$rows->branch_id){ echo "selected=selected"; } ?>><?php echo $rows->branch_name; ?></option>
                                <?php } ?>                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="course" class="form-control" id="course">
                                <option value="">Select</option>
                                <?php foreach($course as $rowcourse): ?>
                                <option value="<?php echo $rowcourse->course_id; ?>" <?php if($row['course_id']==$rowcourse->course_id){ echo "selected=selected"; } ?>><?php echo $rowcourse->c_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Admission Plan"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select name="admission_plan" class="form-control" id="admission_plan">
                                <option value="">Select</option>
                                <?php foreach ($admission_plan as $plan): ?>
                                <option value="<?php echo $plan->admission_plan_id; ?>" <?php if($row['admission_plan_id']==$plan->admission_plan_id){ echo "selected=selected"; } ?>><?php echo $plan->admission_duration; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>	

                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("class"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="class" class="form-control" id="class1">
                                            <option value="">Select class</option>
                                            <?php
                                            $class = $this->db->get('class')->result_array();

                                            foreach ($class as $c) {
                                                if ($c['class_id'] == $row['class_id']) {
                                                    ?>
                                                    <option selected value="<?php echo $c['class_id'] ?>"><?php echo $c['class_name'] ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $c['class_id'] ?>"><?php echo $c['class_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Mobile No"); ?><span style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="mobileno" id="mobileno"  value="<?php echo $row['std_mobile'] ?>"/>
                                    </div>
                                </div>	
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("File Upload"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="txtoldfile" id="txtoldfile" value="<?php echo $row['profile_pic']; ?>" />
                                        <input type="file" class="form-control" name="profilefile" id="profilefile" />

                                        <img src="<?= base_url() ?>/uploads/system_image/<?= $row['profile_pic']; ?>" height="100px" width="100px" id="blah"  />

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("Description"); ?></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="std_about" id="std_about" ><?php echo $row['std_about'] ?></textarea>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo ucwords("status");?></label>
                                    <div class="col-sm-8">
                                        <select name="status"  class="form-control">
                                          <option value="1" <?php if($row['is_active'] == '1'){ echo "selected"; } ?>>Active</option>
                                            <option value="0" <?php if($row['is_active'] == '0'){ echo "selected"; } ?>>Inactive</option>	
                                        </select>
                                        <lable class="error" id="error_lable_exist" style="color:red"></lable>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <button type="submit" class="submit btn btn-info vd_bg-green"><?php echo ucwords("Update"); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div> </div> </div>
            </div>
        </div>
    </div>

    <?php
endforeach;
?>
<script type="text/javascript">

    $("#degree2").change(function () {
        var degree = $(this).val();
        var dataString = "degree=" + degree;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'admin/get_cource/student'; ?>",
            data: dataString,
            success: function (response) {
                $("#course2").html(response);
            }
        });
    });

   $('#course').on('change', function () {
        var course_id = $(this).val();
        
        get_admission_plan(course_id);
        
    });
    function get_admission_plan(course_id)
    {
     $('#admission_plan').find('option').remove().end();
        $('#admission_plan').append('<option value="">Select</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>courses/get_admission_plan/' + course_id,
            type: 'GET',
            success: function (content) {
                var admission_plan = jQuery.parseJSON(content);                
                console.log(admission_plan);
                $.each(admission_plan, function (key, value) {
                    $('#admission_plan').append('<option value=' + value.admission_plan_id + '>' + value.admission_duration + '</option>');
                });
            }
        });
    }

    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {
        $("#birthdate1").datepicker({
        });
        $("#basic-datepicker").datepicker({
            endDate: new Date(),
            format: "MM d, yyyy",
            autoclose: true});

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

        $("#frmstudentedit").validate({
            rules: {
                name: {
                    required: true,
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
                                url: "<?php echo base_url(); ?>user/check_user_email/edit",
                                type: "post",
                                data: {
                                    email: function () {
                                        return $("#email_id").val();
                                    },
                                    userid: function () {
                                          return $("#txtuserid").val();
                                    },
                                }
                            }
                        },
                password: "required",
                gen: "required",
                birthdate1: "required",
                address: "required",
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
                profilefile:
                        {
                            extension: 'gif|jpg|png|jpeg',
                        },
                
            },
            messages: {
                name: {
                    required: "Enter name",
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
                    remote:"This email is already present in system",
                },
                password: "Enter password",
                gen: "Slect gender",
                birthdate1: "Select birthdate",
                address: "Enter address",
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
                zip:
                        {
                            required: "Enter zip code",
                        },
                
                branch: "Select branch",
                course: "Select course",
                admission_plan: "Select admission plan",
                class: "Select class",
                profilefile:
                        {
                            extension: 'Upload valid file',
                        },              
            }
        });
    });
</script>

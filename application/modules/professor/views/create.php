<?php
$this->load->model('branch/Branch_location_model');
$this->load->model('courses/Course_model');
$branch = $this->Branch_location_model->order_by_column('branch_name');
$course = $this->Course_model->order_by_column('c_name');
?>
<div class="row">
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
            <div class=panel-body>
                <?php echo form_open(base_url() . 'professor/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'professor-form', 'enctype' => 'multipart/form-data', 'target' => '_top')); ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("professor name"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="professor-name" class="form-control" type="text" name="professor_name" />
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("email"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="email" class="form-control" type="email" name="email" autocomplete="off"/>
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("password"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="password" class="form-control" type="password" name="password" />
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("mobile"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="mobile" class="form-control" type="text" name="mobile" />
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("address"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <textarea id="address" class="form-control" name="address" ></textarea>
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("city"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="city" class="form-control" type="text" name="city" />
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("zip code"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="zip-code" class="form-control" type="text" name="zip_code" />
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("date of birth"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="date-of-birth" class="form-control datepicker-normal" type="text" name="dob" />
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("occupation"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="occupation" class="form-control" type="text" name="occupation" />
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("designation"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <input id="designation" class="form-control" type="text" name="designation" />
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("branch"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select id="branch" name="branch" class="form-control" >
                            <option value="">Select</option>
                            <?php foreach ($branch as $row) { ?>
                                <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>	
                </div>                        
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("course"); ?><span style="color:red">*</span></label>
                    <div class="col-sm-8">
                        <select id="course" name="course" class="form-control" >
                            <option value="">Select</option>                                   
                            <?php foreach ($course as $crs): ?>
                            <option value="<?php echo $crs->course_id; ?>"><?php echo $crs->c_name; ?></option>
                            <?php endforeach; ?>                            
                        </select>
                    </div>	
                </div>
               
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("photo"); ?></label>
                    <div class="col-sm-8">
                        <input id="photo" class="form-control coverimage" type="file" name="userfile" accept="image/*"/>
                    </div>	
                    <div id="image_container"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ucwords("about"); ?></label>
                    <div class="col-sm-8">
                        <textarea id="about" class="form-control" name="about"></textarea>
                    </div>	
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("add"); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>

<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function () {
            document.getElementById("editevent").submit();
        }
    });

    $(document).ready(function () {

        jQuery.validator.addMethod("zip_code", function (value, element) {
            return this.optional(element) || /^\d{6}(?:-\d{4})?$/.test(value);
        }, 'Enter valid zip code');
        
         jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, ""); 
                    return this.optional(element) || phone_number.length > 9 &&
                            phone_number.match(/^[0-9]{3}[0-9]{3}[0-9]{4}$/);
            }, "Enter valid mobile number");
        
        $("#professor-form").validate({
            rules: {
                professor_name: "required",
                email:
                        {
                            required: true,
                            remote: {
                                url: "<?php echo base_url() . 'user/check_user_email'; ?>",
                                type: "post",
                                data: {
                                    email: function () {
                                        return $("#email").val();
                                    },
                                }
                            }
                        },
                password: "required",
                mobile: {
                            required: true,
                           phoneUS: true,
                        },
                address: "required",
                city: "required",
                zip_code: {
                            required: true,
                            zip_code: true,
                        },
                dob: "required",
                occupation: "required",
                designation: "required",                
                branch: "required",
                course: "required",
                userfile: {
                    extension: 'gif|jpg|png|jpeg',
                },
            },
            messages: {
                professor_name: "Enter professor name",
                email: {
                    required: "Enter Email",
                    remote: "Email id already exists",
                },
                password: "Enter password",
                mobile:  {
                            required: "Enter mobile no",
                        },
                address: "Enter address",
                city: "Enter city",
                zip_code:  {
                            required: "Enter zip code",
                        },
                dob: "Select date of birth",
                occupation: "Enter occupation",
                designation: "Enter designation",                
                branch: "Select branch",
                course: "Select course",
                userfile: {
                    extension: 'Only gif,jpg,png file is allowed!',
                },
            }
        });
    });
</script>

<script type="text/javascript">

    $(document).ready(function () {

        $(".datepicker-normal").datepicker({
            format: 'MM dd, yyyy',
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            endDate: new Date()
        });

        //get branch from courses
        $('#degree').on('change', function () {
            $('#branch').find('option').remove().end();
            $('#branch').append('<option>Select</option>');
            var degree_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + degree_id,
                type: 'get',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    $.each(branch, function (key, value) {
                        $('#branch').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        });
//
//        $('#branch').on('change', function () {
//            $('#subjects').find('option').remove().end();
//            var branch_id = $(this).val();
//            $.ajax({
//                url: '<?php echo base_url(); ?>subject/branch_subject/' + branch_id,
//                type: 'get',
//                success: function (content) {
//                    var branch = jQuery.parseJSON(content);
//                    $.each(branch, function (key, value) {
//                        $('#subjects').append('<option value=' + value.sm_id + '>' + value.subject_name + '</option>');
//                    });
//                }
//            });
//        });

    });
</script>

<script language="javascript" type="text/javascript">

    $(document).ready(function ($) {
        images = new Array();
        $(document).on('change', '.coverimage', function () {
            files = this.files;
            $.each(files, function () {
                file = $(this)[0];
                if (!!file.type.match(/image.*/)) {
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onloadend = function (e) {
                        img_src = e.target.result;
                        html = "<img class='img-thumbnail' style='width:300px;margin:20px;' src='" + img_src + "'>";
                        $('#image_container').html(html);
                    };
                }
            });
        });
    });
</script> 

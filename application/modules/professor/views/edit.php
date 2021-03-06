<?php
    $this->db->select();
    $this->db->where('professor_id',$param2);
    $this->db->from('professor p');
    $this->db->join('user u','u.user_id=p.user_id');
    $professor=$this->db->get()->row();
//$professor = $this->db->get_where('professor', ['professor_id' => $param2])->row();
$branch = $this->db->get('branch_location')->result();
$course = $this->db->get('course')->result();
?>

<div class=col-lg-12>
    <!-- col-lg-12 start here -->
    <div class="panel-default toggle panelMove panelClose panelRefresh">
        <div class=panel-body>
            <?php echo form_open(base_url() . 'professor/update/' . $professor->professor_id, array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'professor-form', 'enctype' => 'multipart/form-data', 'target' => '_top')); ?>
            <input type="hidden" name="txtuserid" id="txtuserid" value="<?php echo $professor->user_id;?>">
                <div class="padded">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("professor name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input id="professor-name" class="form-control" type="text" name="professor_name" required=""
                                   value="<?php echo $professor->first_name; ?>"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("email"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input id="email" class="form-control" type="email" name="email" required=""
                                   value="<?php echo $professor->email; ?>"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("password"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input id="password" class="form-control" type="password" name="password" readonly
                                   value="12345"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("mobile"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input id="mobile" class="form-control" type="text" name="mobile" required=""
                                   value="<?php echo $professor->mobile; ?>"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("address"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <textarea id="address" class="form-control" name="address" required=""><?php echo $professor->address; ?></textarea>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("city"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input id="city" class="form-control" type="text" name="city" required=""
                                   value="<?php echo $professor->city; ?>"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("zip code"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input id="zip-code" class="form-control" type="text" name="zip_code" required=""
                                   value="<?php echo $professor->zip; ?>"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("date of birth"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input id="date-of-birth" class="form-control datepicker-normal" type="text" name="dob" required=""
                                   value="<?php echo date('F d, Y', strtotime($professor->dob)); ?>"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("occupation"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input id="occupation" class="form-control" type="text" name="occupation" required=""
                                   value="<?php echo $professor->occupation; ?>"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("designation"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input id="designation" class="form-control" type="text" name="designation" required=""
                                   value="<?php echo $professor->designation; ?>"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Branch"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select id="branch" name="branch" class="form-control" required="">
                                <option value="">Select</option>
                                <?php foreach ($branch as $degree) { ?>
                                    <option value="<?php echo $degree->branch_id; ?>" ><?php echo $degree->branch_name; ?></option>
                                        <?php } ?>
                            </select>
                        </div>	
                    </div>                        
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("Course"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <select id="course" name="course" class="form-control" required="">
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
                            <input type="hidden"name="txtoldfile" id="txtoldfile" value="<?php echo $professor->profile_pic; ?>" />
                            <input id="photo" class="coverimage2" type="file" name="userfile" accept="image/*"/>
                        </div>	
                        <div id="image_container1" class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><img class='img-thumbnail' src='<?php echo base_url('uploads/system_image/' . $professor->profile_pic) ?>' ></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("about"); ?></label>
                        <div class="col-sm-8">
                            <textarea id="about" class="form-control" name="about"><?php echo $professor->about; ?></textarea>
                        </div>	
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("update"); ?></button>
                        </div>
                    </div>                
                </div>
            <?php echo form_close(); ?>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
    <script type="text/javascript">
        $("#course").val('<?php echo $professor->course_id; ?>');
        $("#branch").val('<?php echo $professor->branch_id; ?>');
        $(".datepicker-normal").datepicker({
            format: 'MM d, yyyy',
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            endDate: new Date()
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
                email: {
                    required: true,
                    remote: {
                        url: "<?php echo base_url() . 'user/check_user_email/edit' ?>",
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
                degree: "required",
                branch: "required",
                userfile: {
                    extension: 'gif|jpg|png|jpeg',
                },
            },
            messages: {
                professor_name: "Enter professor name",
                email: {
                    required: "Enter email",
                    remote: "Email id already exists",
                },
                password: "Enter password",
                mobile:{
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
                degree: "Select department",
                branch: "Select branch",
                userfile: {
                    extension: 'Only gif,jpg,png file is allowed!',
                },
            }
        });

    });

      
    </script>

    <script language="javascript" type="text/javascript">

        $(document).ready(function ($) {
            images = new Array();
            $(document).on('change', '.coverimage2', function () {
                files = this.files;

                $.each(files, function () {
                    file = $(this)[0];
                    if (!!file.type.match(/image.*/)) {
                        var reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onloadend = function (e) {
                            img_src = e.target.result;
                            html = "<img class='img-thumbnail' style='width:300px;margin:20px;' src='" + img_src + "'>";
                            $('#image_container1').html(html);
                        };
                    }
                });
            });
        });
    </script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.min.css"/>
<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/js/select2.full.min.js"></script>
<style>
    .select2-container-multi .select2-choices .select2-search-field input{
        padding: 0px;
    }
    .error{
        color: #ed7a53;
        font-weight: 700;
    }
</style><!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default">
        <div class="panel-body">                              
            <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>email/compose" method="post" 
                  enctype="multipart/form-data" onsubmit="return replyvalid();">                               
                <div class="form-group email_box">
                    <label class="col-sm-2 control-label"><?php echo ucwords("user"); ?></label>
                    <div class="col-sm-5">
                        <input type="hidden" readonly="" name="email[]" class="form-control hide" value="<?php echo $sender->user_id; ?>"/>
                        <input type="text" class="form-control" value="<?php echo $sender->first_name . ' ' . $sender->last_name .' ('. $sender->email .')'; ?>"/>
                    </div>
                </div>                

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ucwords("Subject"); ?></label>
                    <div class="col-sm-5">
                        <textarea class="form-control" name="subject" id="subject"><?php echo $email->subject; ?></textarea>
                        <span class="subject-error error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ucwords("external email"); ?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="cc" id="cc-email" />
                        <span class="cc-email-error error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ucwords("Message"); ?></label>
                    <div class="col-sm-9">
                        <textarea id="cke_editor2" name="message" class="width-100 form-control"  rows="15" placeholder="Write your message here"></textarea>                                              
                        <span class="message-error error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ucwords("Attachment"); ?></label>
                    <div class="col-sm-5">
                        <input type="file" class="form-control" name="userfile[]" multiple/>
                    </div>
                </div>

                <div class="form-group form-actions">
                    <div class="col-sm-12 col-md-offset-2">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope append-icon"></i> <?php echo ucwords("Send"); ?></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- panel-body  --> 

    </div>
    <!-- panel --> 
</div>

</div>
<!-- row --> 

</div>
<!-- .vd_content-section --> 

</div>
<!-- .vd_content --> 
</div>
<!-- .vd_container --> 
</div>
<!-- .vd_content-wrapper --> 

<!-- Middle Content End --> 

<style>
    .checkbox-custom{
        display: inline-block;
    }
</style>

<script type="text/javascript">
    
    function replyvalid()
    {
        var subject = $("#subject").val();
        var cc_email = $("#cc-email").val();
        
        if(subject=='')
                {
                      $(".subject-error").html('Please enter subject');
                      return false;
                }
                else
                {
                      $(".subject-error").html('');
                }
                 if(cc_email!='')
                {
                    var x = cc_email;
                    var atpos = x.indexOf("@");
                    var dotpos = x.lastIndexOf(".");
                    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
                        $(".cc-email-error").html('Please enter valid email');
                        return false;
                    }
                    else{
                        $(".cc-email-error").html('');
                    }
                }
                else
                {
                      $(".cc-email-error").html('');
                }
                 var messageLength = CKEDITOR.instances['cke_editor2'].getData().replace(/<[^>]*>/gi, '').length;
                if( !messageLength ) {
                    
                    $(".message-error").html('Please enter a message');
                    return false;
                }
                else{
                    $(".message-error").html('');
                }
    }
    
    $(".email_select2").select2();
    $("#check_all_user").click(function () {
        if ($("#check_all_user").is(':checked')) {
            $(".email_select2 > option").prop("selected", "selected");
            $(".email_select2").trigger("change");
        } else {
            $(".email_select2 > option").removeAttr("selected");
            $(".email_select2").trigger("change");
        }
    });
</script>
<script>
    CKEDITOR.replace('message');
    $(document).ready(function () {

        $('#user_type').on('change', function () {
            var role_id = $(this).val();
            var role_name = $('option:selected', this).text();

            if (role_name == 'Student') {
                //show department branch and sem    
                show_student_user();
                show_email_box();
            } else if (role_name == 'All') {
                //show email box
                hide_email_box();
                hide_student_user();
            } else {
                show_email_box();
                hide_student_user();
                users_list_by_role(role_id);
            }
        });

        $('#department').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });

        $('#branch').on('change', function () {
            var department_id = $('#department').val();
            var branch_id = $(this).val();
            batch_from_department_branch(department_id, branch_id);
            semester_from_branch(branch_id);
        });

        $('#semester').on('change', function () {
            var department = $('#department').val();
            var branch = $('#branch').val();
            var batch = $('#batch').val();
            var semester = $('#semester').val();
            student_list(department, branch, batch, semester);
        });

        function student_list(department, branch, batch, semester) {
            $('#email').find('option').remove().end();
            $('.select2-search-choice').remove();
            $.ajax({
                url: '<?php echo base_url(); ?>student/student_list/' + department + '/' + branch + '/' + batch + '/' + semester,
                type: 'GET',
                success: function (content) {
                    var students = jQuery.parseJSON(content);
                    $.each(students, function (key, value) {
                        $('#email').append('<option value=' + value.user_id + '>' + value.std_first_name + ' ' + value.std_last_name + '</option>');
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

        function department_branch(department_id) {
            $('#branch').find('option').remove().end();
            $('#branch').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#branch').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        }

        function users_list_by_role(role_id) {
            $('#email').find('option').remove().end();
            $('.select2-search-choice').remove();
            $.ajax({
                url: '<?php echo base_url(); ?>user/users_with_role/' + role_id,
                type: 'GET',
                success: function (content) {
                    var users = jQuery.parseJSON(content);
                    $.each(users, function (key, value) {
                        $('#email').append('<option value=' + value.user_id + '>' + value.first_name + ' ' + value.last_name + '</option>');
                    });
                }
            });
            
        }

        function show_email_box() {
            $('.email_box').removeClass('hide');
        }

        function hide_email_box() {
            $('.email_box').addClass('hide');
        }

        function show_student_user() {
            $('.student_user').removeClass('hide');
        }

        function hide_student_user() {
            $('.student_user').addClass('hide');
        }

    });
</script>

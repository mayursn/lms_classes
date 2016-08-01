<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class="panel-body"> 

                <div class="box-content"> 
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                    
                    <?php echo form_open(base_url() . 'subject/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmsubject', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">	
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Subject Name"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="subname" id="subname" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo ucwords("Subject Code"); ?><span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="subcode" id="subcode" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" id="addsubject" class="btn btn-info vd_bg-green"><?php echo ucwords("Add "); ?></button>
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

    $("#course").change(function () {
        var course = $(this).val();
        var degree = $("#degree").val();
        var dataString = "course=" + course;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'admin/get_semester'; ?>",
            data: dataString,
            success: function (response) {
                $("#semester").html(response);
            }
        });
    });

    $(document).ready(function () {
        $("#subname").change(function () {
            $('#semester').val($("#semester option:eq(0)").val());
        });
        $("#course").change(function () {
            $('#semester').val($("#semester option:eq(0)").val());
        });
        $("#subcode").change(function () {
            $('#semester').val($("#semester option:eq(0)").val());
        });
        
        $('#degree').on('change', function(){
            var degree_id = $(this).val();
            branch_from_department(degree_id);
        });

        function branch_from_department(department_id) {
            $('#course').find('option').remove().end();
            $('#course').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/course_list_from_degree/' + department_id,
                type: 'get',
                success: function (content) {
                    var course = jQuery.parseJSON(content);
                    $.each(course, function (key, value) {
                        $('#course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    })
                }
            })
        }
    });
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

 $('#subname').on('change', function(){
         $("#subcode").val('');
        });

    $().ready(function () {
          
        $("#frmsubject").validate({
            rules: {
                subname: "required",
                subcode: 
                        {
                            required:true,
                            remote: {
                                        url: "<?php echo base_url(); ?>subject/checksubject",
                                        type: "post",
                                        data: {
                                            subname: function () {
                                                return $("#subname").val();
                                            },
                                            subcode: function () {
                                                return $("#subcode").val();
                                            }
                                        }
                                    }
                },
            },
            messages: {
                subname: "Enter subject name",
                subcode: 
                    {
                      required:"Enter subject code",
                      remote:"Subject already exits",
                    },
            }
        });
    });
</script>
<?php
$res = $this->Participate_student_model->get_not_participate_list();

?>
<!-- Start .row -->
<div class=row>
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <?php
                if ($this->session->flashdata('flash_message')) {
                    echo $this->session->flashdata('flash_message');
                }
                ?>
                <?php echo form_open(base_url() . 'participate/volunteer/create', array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmproject', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Activity Title <span style="color:red">*</span>
                    </label>
                    <div class="col-sm-5">
                        <select class="form-control" id="pp_id" name="pp_id">
                            <option value="<?php ?>"> Select </option>
                                <?php foreach ($res as $rs): ?>
                                <option value="<?php echo $rs['pp_id']; ?>">
                            <?php echo $rs['pp_title']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="std_id" value="<?php echo $this->session->userdata('std_id'); ?>" />
                </div>
                <div class="form-group" id="description"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Date of Activity</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="dos" readonly="" value="" id="dos" />
                    </div>


                </div>
                <input type="hidden" name="p_status" value="1" checked="">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Comment</label>
                    <div class="col-sm-5">
                        <textarea class="form-control" name="comment" id="std_about"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-primary">Volunteer</button>
                    </div>
                </div>
<?php echo form_close(); ?>
            </div>
            <!-- col-lg-12 end here -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End contentwrapper -->
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<!-- End #content -->
<script type="text/javascript">
    $("#pp_id").change(function () {
        var pp_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>participate/get_desc",
            data: {
                'pp_id': pp_id
            },
            success: function (response) {
                obj = JSON.parse(response);
                var display_desc = '<label class="col-sm-3 control-label">Description : </label><div class="col-sm-5" >' + obj.pp_desc + '</div>';
                $("#description").html(display_desc);
                $("#dos").val(obj.pp_dos);
            }

        });
    });
    $.validator.setDefaults({
        submitHandler: function (form) {

            //  filecheck(img);
            form.submit();

        }
    });

    $().ready(function () {
        $("#frmproject").validate({
            rules: {
                pp_id: "required",
                p_status: "required",
            },
            messages: {
                pp_id: "Please select participation",
                p_status: "Please select your interest",
            }
        });
    });
</script>
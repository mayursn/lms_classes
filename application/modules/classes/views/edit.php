<?php
$edit_data = $this->db->get_where('class', array('class_id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>
    <div class=row>                      
        <div class=col-lg-12>
            <!-- col-lg-12 start here -->
            <div class="panel-default">
                <div class="panel-body"> 
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>
                    <?php echo form_open(base_url() . 'classes/update/' . $row['class_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'frmeditclass', 'target' => '_top')); ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo ucwords("class name"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="class_name" id="class_name" value="<?php echo $row['class_name']; ?>"   />
                        </div>
                    </div>                   
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="submit btn btn-info vd_bg-green"><?php echo ucwords("update"); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php
endforeach;
?>
<script type="text/javascript">
    $.validator.setDefaults({
        submitHandler: function (form) {
            form.submit();
        }
    });

    $().ready(function () {
        $("#frmeditclass").validate({
            rules: {
                class_name: "required",
            },
            messages: {
                class_name: "Enter class name",
            }
        });
    });
</script>


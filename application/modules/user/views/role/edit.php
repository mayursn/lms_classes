<?php
$edit_data = $this->db->get_where('role', [
            'role_id' => $param2
        ])->row();
$this->db->where('is_active','1');
$this->db->order_by('module_name','asc');
$modules=$this->db->get('modules')->result();
 $mods=  explode(',', $edit_data->assigned_module);
 $count=0;
 foreach($modules as $m)
 {
     if(in_array($m->module_id, $mods))
     {
         $count++;
     }
     
 }
 
?>
<div class = row>
    <div class = col-lg-12>
        <!--col-lg-12 start here -->
        <div class = "panel-default toggle panelMove panelClose panelRefresh">
            <div class = "panel-body">
                <div class = "tab-pane box" id = "add" style = "padding: 5px">
                    <div class = "box-content">
                        <div class = "form-group">
                            <span style = "color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                        </div>
                        <?php echo form_open(base_url() . 'user/role/update/' . $edit_data->role_id, array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'role-edit', 'target' => '_top')); ?>

                        <div class="padded">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Role Name<span style="color:red">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="role_name" id="role_name"
                                           value="<?php echo $edit_data->role_name; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Modules<span style="color:red">*</span></label>
                                <input type="checkbox" name="modulecheckall" id="modulecheckall"  onclick="create_check_all();"  <?php if($count==count($modules)){echo "checked"; } ?>/>Check All
                                    <?php 
                                    $i=0;
                                    foreach($modules as $m)
                                    {
                                        $i++;
                                        ?>
                                      <div class="col-sm-8">
                                          <input class="check" onclick="uncheck_all();" type="checkbox" name="module[]" id="module_<?php echo $i; ?>" value="<?php echo $m->module_id; ?>" <?php if(in_array($m->module_id, $mods)) { echo "checked"; }  ?>/><?php echo $m->module_name; ?>
                                      </div>
                                        <?php
                                    }
                                    ?>
                            </div>
                             <label id="module[]-error" class="error" for="module[]"></label>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo ucwords("status"); ?></label>
                                <div class="col-sm-8">
                                    <select name="status"  class="form-control">
                                        <option value="1"
                                                <?php if ($edit_data->is_active == 1) echo 'selected'; ?>>Active</option>
                                        <option value="0"
                                                <?php if ($edit_data->is_active == 0) echo 'selected'; ?>>Inactive</option>		
                                    </select>	
                                </div>	
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-info vd_bg-green" >Update</button>
                                </div>
                            </div>            
                        </div>  
                        <?php echo form_close(); ?>
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

        $("#role-edit").validate({
            rules: {
                role_name: "required",
               'module[]':
                        {
                            required:true,
                        },
                status: "required",
            },
            messages: {
                role_name: "Enter role name",
               'module[]':
                        {
                            required:'Select module',
                        },
                status: "Select status",
            }
        });
    });
     function create_check_all()
    {
        if($("#modulecheckall").is(":checked"))
        {
             $('.check').prop('checked', true);
        }
        else
        {
             $('.check').prop('checked', false);
        }
    }
    function uncheck_all()
    {
        if($('.check:checked').length==$('.check').length)
        {
            $('#modulecheckall').prop('checked', true);
        }
        else
        {
            $('#modulecheckall').prop('checked', false);
        }
    }
</script>

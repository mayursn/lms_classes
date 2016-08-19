<?php
$this->load->model('media/Gallery_folder_model');
?>
<script language="javascript" type="text/javascript">
    $(function () {
        $("#fileupload").change(function () {
            if (typeof (FileReader) != "undefined") {
                var dvPreview = $("#dvPreview");
                dvPreview.html("");
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                $($(this)[0].files).each(function () {
                    var file = $(this);
                    if (regex.test(file[0].name.toLowerCase())) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = $("<img />");
                            img.attr("style", "height:100px;width: 100px");
                            img.attr("src", e.target.result);
                            img.attr("class",'img-photogallery');
                            dvPreview.append(img);
                        }
                        reader.readAsDataURL(file[0]);
                    } else {
                        alert(file[0].name + " is not a valid image file.");
                        dvPreview.html("");
                        return false;
                    }
                });
            } else {
                alert("This browser does not support HTML5 FileReader.");
            }
        });
    });
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
<div class=row>
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <!--            <div class=panel-heading>
                            <h4 class=panel-title>  <?php echo ucwords("Add Photo Gallery"); ?></h4>                
                        </div> -->
            <div class="panel-body"> 
                <div class="box-content">  
                    <div class="">
                        <span style="color:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                    </div>                                      
                    <?php echo form_open(base_url() . 'media/photo_gallery/folder_create/'.$param2, array('class' => 'form-horizontal form-groups-bordered validate', 'role' => 'form', 'id' => 'frmgallery', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                    <div class="padded">											

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Folder Name <span style="color:red">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="folder_name" id="folder_name" />
                            </div>
                        </div>

                        
                      <div class="form-group">
                            <label class="col-sm-4 control-label">Parent Folder <span style="color:red"> *</span></label>
                            <div class="col-sm-8">
                                <?php $folder_name =  $this->Gallery_folder_model->get_all_folder_view(); ?>
                                <select name="parent_id" class="form-control">
                                    <option value="">Select</option>
                              <?php foreach($folder_name as $folder): ?>
                                    <option value="<?php echo $folder->folder_id; ?>"><?php echo $folder->folder_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Status <span style="color:red"> *</span></label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info vd_bg-green">Add Folder</button>
                            </div>
                        </div>
                        </form>               
                    </div> 
                    <div id="dvPreview">
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

        $("#frmgallery").validate({
            rules: {
               folder_name: "required",               
                status: "required",
               
            },
            messages: {
                folder_name: "Enter folder name",
                status: "Select Status",
            },
        });
    });
</script>

<!-- Start .row -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/lightbox/css/lightbox.min.css">
  <link href="<?php echo base_url(); ?>assets/contextmenu/dist/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<?php 

$create = create_permission($permission, 'Media');
$read = read_permission($permission, 'Media');
$update = update_permisssion($permission, 'Media');
$delete = delete_permission($permission, 'Media');
?>
 <style>
        .gallery_img {
            float: left;
            margin: 15px 0 0 15px;
            position: relative;
        }
        #remove_gallery_img {
            float: right;
            position: absolute;
            right: -2px;
            top: -2px;
        }
        #remove_gallery_img i:hover{color:#fff; font-size: 20px;}
        .example-image{ height: 150px; width: 200px;}

    </style>
    <script type="text/javascript">
        function removeimg(image, id, img)
        {
            var datastring = "image=" + image + "&id=" + id;           
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'media/photo_gallery/removeimg'; ?>",
                data: datastring,
                success: function (response)
                {
                    //alert("#"+img);
                    $("#" + img).css({'display': 'none'});
                }
            });
            return false;
        }
    </script>
<div class=row>                      

    <div class=col-lg-12 col-md-12 col-xs-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <?php $folder_name = $this->Photo_gallery_model->get_folder_name($folder_id); ?>
            <a class="links" href="<?php  $referred_from = $this->session->userdata('referred_from');
                 echo $referred_from; ?>">Go Back To <?php echo $folder_name; ?></a>
             <?php if ($create) { ?>
            <a class="links"  onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/media_photogallery_create/<?php echo $folder_id; ?>');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Folder</a>
            <a class="links"  onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/media_photogallery_createphoto/<?php echo $folder_id; ?>');" href="#" id="navfixed" data-toggle="tab"><i class="fa fa-plus"></i> Add Photos</a>
             <?php } ?>
            <div class=panel-body>
                
                
                <?php foreach($child_folder as $fold): ?>
                <div class="col-md-2 context-menu-one  remove-folder<?php echo $fold->folder_id; ?>"  id="<?php echo $fold->folder_id; ?>" >
                    <a href="<?php echo base_url(); ?>media/photo_gallery/gallery_view/<?php echo $fold->folder_id; ?>"><img src="<?php echo base_url(); ?>uploads/folder.png" height="100" width="100" /></a><br>
                    <h6 class="col-md-12 rename-area" id="rename-text<?php echo $fold->folder_id; ?>" style="left: -18px; top: -17px;text-align: center;" ><?php echo $fold->folder_name; ?></h6>
                </div>
                <?php endforeach; ?>
                <div class="col-lg-12">
                <?php foreach ($folder_photo as $row): ?>               
                        <?php
                        if (!empty($row->gallery_img)) {
                            $images = explode(",", $row->gallery_img);
                            for ($i = 0; $i < count($images); $i++) {
                                $img = explode(".", $images[$i]);
                                ?>           
                                <div class="gallery_img" id="<?php echo $img[0]; ?>">
                                    <a href="#" id="remove_gallery_img" data-toggle="tooltip" data-placement="top" class="removeimgbtn" onclick="removeimg('<?php echo $images[$i]; ?>', '<?php echo $row->gallery_id; ?>', '<?php echo $img[0]; ?>')"  data-original-title="Remove Image"  ><i class="icomoon-icon-cancel-circle"></i></a>
                                    <a class="example-image-link" href="<?php echo base_url(); ?>uploads/photogallery/<?php echo $images[$i]; ?>" data-lightbox="example-set" >
                                    <img class="example-image" src="<?php echo base_url(); ?>uploads/photogallery/<?php echo $images[$i]; ?>" alt=""/>
                                    </a>
                                 </div>
                            <?php } ?>
                            <?php } ?>
                
                    <?php endforeach; ?>
                        </div>                               
              
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>

<!-- End #content -->
<script src="<?php echo base_url(); ?>assets/lightbox/js/lightbox-plus-jquery.min.js"></script>
<script>
    $(function() {
        $.contextMenu({
            selector: '.context-menu-one', 
            callback: function(key, options) {              
                var m = "clicked: " + key;
                   var id = $(this).attr('id');
                     <?php if($delete) { ?>
                 if(key=="delete")
                 {
                      var txt;
                    var r = confirm("Are you sure you want to permanently delete Folder sub folder and files?  If you delete an item, it will be permanently lost.");
                    if (r == true) {
                          $.ajax({
                                         url:"<?php echo base_url(); ?>media/photo_gallery/removefolder/"+id,
                                         success:function(response){
                                             $(".remove-folder"+id).hide();
                                         }
                                  });

                    } else {

                    }
    
                  
                  }
                     <?php  } ?>
             <?php if ($update) { ?>
                  if(key=="edit")
                  {
                    var text = $("#rename-text"+id).html();
                    //alert(text);
                    $("#rename-text"+id).html('<input type="text" name="renamefolder" id="rename-folder'+id+'" value="'+text+'">');
                    $("#rename-folder"+id).focus();
                    $("#rename-folder"+id).blur(function(){
                        var rename = $("#rename-folder"+id).val();
                        if(rename!="")
                        {
                        var dataString = "folder_name="+rename;
                        $.ajax({
                            type:"POST",
                             url:"<?php echo base_url(); ?>media/photo_gallery/renamefolder/"+id,
                             data:dataString,
                             success:function(response){
                                             $("#rename-text"+id).text(response);
                                         }
                        });
                        }else{
                         $("#rename-text"+id).text(text);
                        }
                    });     
                    $("#rename-text"+id).keypress(function (e) {
                        if (e.which == 13) {
                         
                         var rename = $("#rename-folder"+id).val();
                        if(rename!="")
                        {
                        var dataString = "folder_name="+rename;
                        $.ajax({
                            type:"POST",
                             url:"<?php echo base_url(); ?>media/photo_gallery/renamefolder/"+id,
                             data:dataString,
                             success:function(response){
                                             $("#rename-text"+id).text(response);
                                         }
                        });
                        }else{
                         $("#rename-text"+id).text(text);
                        }
                        }
                      });
                  }
                    <?php } ?>
                 
                 
                //window.console && console.log(m) || alert(m); 
            },
            items: {
                "edit": {name: "Rename", icon: "edit"},                
                "delete": {name: "Delete", icon: "delete",},
                "sep1": "---------"
            }
        });

        $('.context-menu-one').on('click', function(e){          
        })    
    });
</script>
  <script src="<?php echo base_url(); ?>assets/contextmenu/dist/jquery.contextMenu.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/contextmenu/dist/jquery.ui.position.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/contextmenu/main.js" type="text/javascript"></script>
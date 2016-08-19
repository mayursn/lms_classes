<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
             <div class="vd_content-section clearfix">
                <div class="row">
                    <div class="col-sm-12">
                      <!--  <div class="">
                           <!--  <span style="c <!-- olor:red">* <?php echo "is " . ucwords("mandatory field"); ?></span> 
                        </div> --> 
                      <br>
                         <form id="restoreform" class="form-horizontal form-groups-bordered validate" role="form" action="" method="post" 
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo ucwords("File"); ?><span style="color:red">*</span></label>
                        <div class="col-sm-5">
                            <input type="file" class="form-control" name="userfile" id="userfile"/>
                            <label id="userfile-error" class="error" for="userfile"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info vd_bg-green"><?php echo ucwords("restore"); ?></button>
                        </div>
                    </div>
                    <b>Note: Please take backup before system restore</b>
                    <br/><a href="<?php echo base_url('backup'); ?>">Click here to backup</a>
                </form>
               </div>
            </div>
        </div>


    </div>

    <!-- row --> 

</div>

<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
</div>
<script type="text/javascript">
 

    $().ready(function () {
        $("#restoreform").validate({
            rules: {
                userfile: "required"
            },
            messages: {
                userfile: "Select system backup file"
            }
        });
    });
</script>
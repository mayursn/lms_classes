
<script>

    jQuery(window).resize(function () {

        $('#modal_ajax').on('shown', function () {
            var offset = 0;
            $(this).find('.modal-body').attr('style', 'max-height:' + ($(window).height() - offset) + 'px !important;');
        });
        $('modal.fade.in').on('shown', function () {
            var offset = 0;
            $(this).find('.modal-body').attr('style', 'max-height:' + ($(window).height() - offset) + 'px !important;');
        });
    });
</script>

<script type="text/javascript">
    function showAjaxModal(url)
    {
        if(url.indexOf("edit_") >= 0) {
            $('#myModalLabel2').html('<?php echo @$edit_title; ?>');
        } else if(url.indexOf("add") >= 0) {
            $('#myModalLabel2').html('<?php echo @$add_title; ?>');
        } else {
            $('#myModalLabel2').html('<?php echo $title ?>');
        }
        
        if(url.indexOf("edit_participate") >= 0) {
            $('#myModalLabel2').html('Update Participate');
        } else if(url.indexOf('edit_question') >= 0) {
            $('#myModalLabel2').html('Update Question');
        } else if(url.indexOf("addcomments") >= 0) {
               $('#myModalLabel2').html('Add Comment');
        } else if(url.indexOf("modal_view_profile") >= 0) {
               $('#myModalLabel2').html('Professor Details');
        } else if(url.indexOf("modal_survey_detal") >= 0) {
               $('#myModalLabel2').html('Survey Detail');
        }
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url(); ?>assets/img/preloader.gif" /></div>');

        // LOADING THE AJAX MODAL
        jQuery('#modal_ajax').modal('show', {backdrop: 'true'});

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function (response)
            {
                jQuery('#modal_ajax .modal-body').html(response);
            }
        });
    }
</script>
<style type="text/css">
    .modal-dialog.modal-dialog-center {
  margin-top: -300px !important;
}
</style>
<div class="modal fade modal-style2" id="modal_ajax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

<!-- <div aria-hidden="true" role="dialog" tabindex="-1" id="modal_ajax" class="modal fade"> -->
    <div class=modal-dialog>
        <div class=modal-content>
            <div class=modal-header>
                <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 id="myModalLabel2" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                
            </div>

            <div class="modal-footer"><button data-dismiss="modal" class="btn btn-default" type="button">Close</button></div>
        </div>
    </div>
</div>
<!-- (Ajax Modal)-->
<div class="modal fade" id="modal_ajax">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Learning Management System</h4>
            </div>

            <div class="modal-body" style=" overflow:auto;">



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    function confirm_modal(delete_url)
    {
        jQuery('#modal-4').modal('show', {backdrop: 'static'});
        document.getElementById('delete_link').setAttribute('href', delete_url);
    }
</script>

<!-- (Normal Modal)-->
<div class="modal fade" id="modal-4">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Are you sure to remove this information ?</h4>
            </div>


            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="" class="btn btn-danger" id="delete_link">Remove</a>
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
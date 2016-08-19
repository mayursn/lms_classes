<div id=footer class="clearfix sidebar-page right-sidebar-page">
    <!-- Start #footer  -->
    <p class=pull-left>Copyrights &copy; <?php echo date('Y'); ?> <a href="http://searchnative.in/" class="color-blue strong" target=_blank><?php echo system_name(); ?></a>. All rights reserved.</p>    

</div>
<!-- End #footer  -->
</div>
<!-- / #wrapper --><!-- Back to top -->
<div id=back-to-top><a href=#>Back to Top</a></div>
<style type="text/css">
    .panel.panel-default.toggle.panelMove.panelClose.panelRefresh {overflow: hidden;}
</style>
<!-- Javascripts -->
<script src="<?php echo base_url(); ?>assets/js/plugins/pace.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/forms-validation.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/tables-data.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.toaster.js"></script>
<script src="<?php echo base_url(); ?>assets/js/multiselect.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/summernote.js"></script>
<!--[if lt IE 9]>
    <script type="text/javascript" src="js/libs/excanvas.min.js"></script>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script type="text/javascript" src="js/libs/respond.min.js"></script>
    <![endif]-->
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/select2.js"></script>
<script>
<?php
$message = $this->session->flashdata('flash_message');
if ($message != '') {
    ?>
        $.toaster({
            priority: 'success',
            title: 'Success! ',
            message: '<?php echo $message; ?>',
            timeOut: 5000
        });
<?php } ?>
$(".toaster").css({'top':"62px"});
</script> 
<?php include 'modal.php'; ?>
</body>
</html>


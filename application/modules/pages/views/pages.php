<?php
if ($this->session->userdata('role_name') == 'Student') {
    $page = $news[0]['c_slug'];
} else {
    redirect(base_url('user/login'));
}
?>
<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh"></div>
        <div class=panel-body>
            <?php
            echo @$news[0]['c_description'];
            ?>
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
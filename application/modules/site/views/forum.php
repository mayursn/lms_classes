<style type="text/css">
    .links_forum{
        text-transform: capitalize;
    }
    .links_forum:hover, .links_forum:active, .links_forum:focus{
        text-transform: uppercase;
    }
</style>
<!-- Sub Header Start -->
<div class="page-section" style="background:#ebebeb; padding:50px 0 35px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="cs-page-title">
                    <h1>Forum</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sub Header End --> 
<!-- Main Start -->
<div class="main-section">
    <div class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="cs-event-detail-holder">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-striped table-bordered table-responsive dataTable no-footer table-hover">
                                    <?php foreach(@$forums as $forum): ?>
                                    <tr>
                                        <th class="text-center">
                                        <div class="cs-event-detail-description">
                                            <div class="cs-post-title">                                                
                                                <i class="icon-uniF119"></i>
                                            </div>
                                        </div>
                                        </th>
                                        <th>
                                             <div class="cs-post-title">                                               
                                               <a class="links_forum" href="<?php echo base_url().'site/topics/'.$forum->forum_id; ?>"><?php echo $forum->forum_title; ?></a>
                                            </div>
                                        </th>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Main End --> 
   
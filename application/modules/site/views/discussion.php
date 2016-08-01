<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>plugins/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/ckeditor/toolbarconfigurator/lib/codemirror/neo.css">
<style type="text/css">
    h3.topic_title {
        font-size: 26px !important;
        font-weight: 300 !important;
    }
    .img_box_forum, .content_discu{float: left; display: inline-block;}
    .img_box_forum{width: 12%; text-align: center; margin-top: 10px;}
    .img_box_forum img{border: 3px solid #ccc; padding: 5px; text-align: center; display: inline-block;}
    .content_discu{width: 88%}

</style>
<!-- Sub Header Start -->
<div class="page-section" style="background:#ebebeb; padding:50px 0 35px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="cs-page-title">
                    <h1>Forum Topic</h1>
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
                    <div class="row">                        
                        <?php foreach (@$topics as $topic): ?>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">                                                               
                                <div class="cs-event-detail-description">
                                    <div class="cs-post-title">
                                        <h3 class="cs-color topic_title"><?php echo $topic->forum_topic_title; ?></h3>
                                        <label>Description :</label> <p style="text-indent:100px;"><?php echo $topic->forum_topic_desc; ?></p>
                                    </div>
                                </div>

                                <?php foreach (@$comments as $comment): ?>
                                    <div class="cs-event-detail-description">
                                        <div class="cs-post-title">                                        
                                            <?php $path = roleimgpath($comment->user_role, $comment->user_role_id); ?>
                                            <div class="img_box_forum">                       
                                                <img class="img-responsive mCS_img_loaded" src="<?php echo base_url() . $path; ?>" height="50" width="50" />
                                            </div>  
                                            <div class="content_discu">
                                                <?php if (!empty($comment->topic_file)) { ?>
                                                    <a href="<?php echo base_url() . 'uploads/forum_file/' . $comment->topic_file; ?>" download=""><img src="<?php echo base_url(); ?>uploads/file-download.png" height="32" width="32" /></a>
                                                <?php } ?>
                                                <p>

                                                    <?php
                                                    echo "  " . $comment->forum_comments;
                                                    echo "<br>";
                                                    echo roleuserdatatopic($comment->user_role, $comment->user_role_id) . ' ' . date_duration($comment->created_date);
                                                    echo "<br>";
                                                    ?>

                                                    <?php if ($this->session->userdata('role_name') == $comment->user_role && $this->session->userdata('user_id') == $comment->user_role_id) { ?>
                                                        <a style="color:red" href="<?php echo base_url(); ?>site/delete_comment/<?php echo $comment->forum_comment_id; ?>/<?php echo $param; ?>" onclick="return myFunction();">Delete</a>
                                                    <?php } ?>

                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>

                            <div class="cs-listing-filters col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <?php
                                $message = $this->session->flashdata('message');
                                if ($message != '') {
                                    ?>
                                    <div class="alert alert-success">
                                        <button class="close" data-dismiss="alert">&times;</button>
                                        <p><?php echo $message; ?></p>
                                    </div>
                                <?php } ?>
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">                                
                                        <div id="collapseOne" class="panel-collapse collapse in fade" role="tabpanel" aria-labelledby="headingOne">

                                            <?php if ($this->session->userdata('user_id')) { ?>
                                                <div class="cs-contact-form">
                                                    <div class="form-holder">
                                                        <div class="row">
                                                            <form action="<?php echo base_url(); ?>site/comment/create" method="post" id="commentform" enctype="multipart/form-data">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="row">
                                                                        <input type="hidden" name="forum_topic_id" value="<?php echo $param; ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="cs-form-holder">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="input-holder"> 
                                                                            <textarea name="discussion" id="editor1"   placeholder="Join the discussion"></textarea>
                                                                            <label for="editor1" generated="true" class="error"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="cs-form-holder">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                        <input type="file" name="topicfile"  >

                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-md-12">
                                                                    <div class="cs-field">
                                                                        <div class="cs-btn-submit"> 
                                                                            <input class="cs-bgcolor" type="submit" value="Post Comment" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>

                                                Please login to join the discussion forums. 

                                                <ul class="clearfix">
                                                    <?php
                                                    $this->session->set_userdata('referred_from', current_url());
                                                    ?>
                                                    <li><a style="color:#3488bf;" href="<?php echo base_url(); ?>user/login"><i class="icon-login"></i>Login</a></li>
                                                </ul>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>


                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Main End --> 
<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
</script>

<script>
function myFunction() {    
    var r = confirm("Are you sure want to delete this Comment?");
    if (r == true) {
      return true;
    } else {
        
        return false;
    }
    
}
</script>
<script type="text/javascript">

    $(document).ready(function () {
        $("#commentform").validate({
            rules: {
                discussion: "required",
                topicfile: {
                    accept: 'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|ppt|pptx|txt'
                },
            },
            messages: {
                discussion: "Enter Comment",
                topicfile: {
                    accept: "Select valid file",
                },
            }
        });
    });
</script>

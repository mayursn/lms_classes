<script src="<?php echo base_url(); ?>plugins/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/ckeditor/toolbarconfigurator/lib/codemirror/neo.css">
<style type="text/css">
    .links_forum{
        text-transform: capitalize;
    }
    .links_forum:hover, .links_forum:active, .links_forum:focus{
        text-transform: uppercase;
    }

    .cs-contact-form .cs-btn-submit input[type="submit"] {
        border: 0 none;
        border-radius: 3px;
        color: #fff !important;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        height: 45px;
        letter-spacing: 1.5px;
        line-height: 16px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        transition: all 0.3s ease 0s;
        width: 168px;
    }
    a.links {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        background-color: #e0e0e0;
        background-image: linear-gradient(to bottom, #fafafa 0px, #dcdcdc 100%);
        background-repeat: repeat-x;
        border-color: #ccc #ccc #aaa;
        border-image: none;
        border-radius: 2px;
        border-style: solid;
        border-width: 1px;
        box-shadow: 0 0 1px #fff inset;
        color: #555;
        display: inline-block;
        float: none;
        font-size: 14px;
        font-weight: 600;
        line-height: 20px;
        margin-bottom: 10px;
        padding: 6px 8px;
        position: relative;
        text-shadow: 0 1px 0 #fff;
        transition: all 0.4s ease 0s;
    }
    a.links:hover, a.links:focus, a.links:active {
        background-image: linear-gradient(to bottom, #e8e8e8 0px, #f9f9f9 100%);
        background-repeat: repeat-x;
        border-color: #aaa #aaa #999;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.25), 0 0 3px #fff inset;
        color: #3f3f3f;
        text-decoration: none;
    }
</style>
<!-- Sub Header Start -->
<div class="page-section" style="background:#ebebeb; padding:50px 0 35px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="cs-page-title">
                    <h1>Forum Topics</h1>
                    <h2><?php echo @$forum[0]->forum_title; ?></h2>
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="cs-listing-filters">
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
                                    <div class="panel panel-default row">
                                        <div class="col-lg-3 col-md-3">
                                            <div class="panel-heading" role="tab" id="headingOne">

                                                <a class="links" role="button" data-toggle="collapse"  href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Start New Topic
                                                </a>

                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9">  
                                            <div id="collapseOne" class="panel-collapse collapse out fade" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="">
                                                    <div class="cs-contact-form">

                                                        <div class="form-holder">
                                                            <div class="row">

                                                                <?php if ($this->session->userdata('user_id')) { ?>
                                                                    <div class="cs-section-title">
                                                                        <h2>Create Topics</h2>
                                                                    </div>
                                                                <form action="<?php echo base_url(); ?>site/crudtopic" method="post" id="topicform" enctype="multipart/form-data">
                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                            <div class="row">
                                                                                <input type="hidden" name="forum_id" value="<?php echo $param; ?>" />
                                                                                <div class="cs-form-holder">

                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="input-holder"> <i class="icon-user"></i>
                                                                                            <input name="subject"  type="text" placeholder="Subject">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="cs-form-holder">


                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                <div class="input-holder"> 
                                                                                    <textarea name="discussion" id="editor1" placeholder="Start the discussion here"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-md-12">
                                                                            <div class="cs-field">
                                                                                <div class="cs-btn-submit"> 
                                                                                    <input type="file" name="topicfile"  >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-md-12">
                                                                            <div class="cs-field">
                                                                                <div class="cs-btn-submit"> 
                                                                                    <input class="cs-bgcolor" type="submit" value="Post topic now" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                <?php } else { ?>
                                                                    Please login to join the discussion forums.   
                                                                    <?php
                                                                    $this->session->set_userdata('referred_from', current_url());
                                                                    ?>                                              
                                                                    <ul>
                                                                        <li><a style="color:#3488bf;" href="<?php echo base_url(); ?>user/login"><i class="icon-login"></i>Login</a></li>
                                                                    </ul>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php foreach (@$topics as $topic): ?>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-striped table-bordered table-responsive dataTable no-footer table-hover">
                                    <tr>
                                        <td width="50%" class="text-left">
                                              <?php if(!empty($topic->topic_file)) {?>
                                                    <a href="<?php echo base_url().'uploads/forum_file/'.$topic->topic_file; ?>" download=""><img src="<?php echo base_url(); ?>assets/images/pdf-icon.jpg" height="32" width="32" /></a>
                                    <?php } ?>
                                            <a class="links_forum" href="<?php echo base_url() . 'site/viewtopic/' . $topic->forum_topic_id; ?>"><?php echo $topic->forum_topic_title; ?>         
                                            </a><span class="error"><?php echo countcommenttopic($topic->forum_topic_id); ?></span>                                        
                                            </th>
                                        <td width="50%" class="text-right">
                                            <small> <?php echo "Created By " . roleuserdatatopic($topic->user_role, $topic->user_role_id); ?> <span><?php echo date_duration($topic->created_date); ?></span> 
                                            </small>                                                
                                        </td>
                                    </tr>
                                </table>                                                           
                            </div>

                          
                        <?php endforeach; ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Main End --> 
 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
    <script type="text/javascript">

        $(document).ready(function () {
           
            $("#topicform").validate({
                rules: {
                    subject: "required",
                    discussion: "required",  
                    topicfile:{                       
                        extension:'gif|jpg|png|jpeg|pdf|xlsx|xls|doc|docx|ppt|pptx|txt'
                    },
                },
                messages: {
                    subject: "Enter subject name",
                    discussion: "Enter topic discussion description",
                    topicfile:{                       
                        extension:"Upload valid file",
                    },
                },
                  submitHandler: function (form) {
                    //  filecheck(img);
                    form.submit();

                }
            });
        });
    </script>

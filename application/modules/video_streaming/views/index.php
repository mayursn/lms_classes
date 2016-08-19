<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class=" panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>
                <!-- scripts used for broadcasting -->
                <script src="//cdn.webrtc-experiment.com/firebase.js">
                </script>
                <script src="//cdn.webrtc-experiment.com/RTCMultiConnection.js">
                </script>

                <article>

<!-- just copy this <section> and next script -->
                    <section class="experiment">
                        <?php // if()
                        $create = create_permission($permission, 'Video_Streaming');
                            $read = read_permission($permission, 'Video_Streaming');
                            $update = update_permisssion($permission, 'Video_Streaming');
                            $delete = delete_permission($permission, 'Video_Streaming');
                           
                        ?>
                        <div class="form-horizontal <?php if(!$create){ ?> hidden <?php } ?>">  
                            <div class="">
                                <span style="color:red">* is mandatory field</span> 
                            </div>  
                            <div class="form-group" id="private-broadcast-degree">
                                <label class="col-sm-3 control-label">Department<span style="color:red">*</span></label>
                                <div class="col-sm-5">
                                    <select id="degree" class="form-control" name="private-broadcast-degree">
                                        <option value="">Select</option>
                                        <?php foreach ($degree as $row) { ?>
                                            <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <label style="display:none; color: red" id="degree_error"></label>
                                </div>
                            </div>
                            <div class="form-group" id="private-broadcast-course">
                                <label class="col-sm-3 control-label">Branch<span style="color:red">*</span></label>
                                <div class="col-sm-5">
                                    <select id="course" class="form-control" name="private-broadcast-course">
                                        <option value="">Select</option>
                                    </select>
                                    <label style="display:none; color: red" id="course_error"></label>
                                </div>
                            </div>
                            <div class="form-group" id="private-broadcast-batch">
                                <label class="col-sm-3 control-label">Batch<span style="color:red">*</span></label>
                                <div class="col-sm-5">
                                    <select id="batch" class="form-control" name="private-broadcast-batch">
                                        <option value="">Select</option>
                                    </select>
                                    <label style="display:none; color: red" id="batch_error"></label>
                                </div>
                            </div>
                            <div class="form-group" id="private-broadcast-semester">
                                <label class="col-sm-3 control-label">Semester<span style="color:red">*</span></label>
                                <div class="col-sm-5">
                                    <select id="semester" class="form-control" name="private-broadcast-course">
                                        <option value="">Select</option>
                                    </select>
                                    <label style="display:none; color: red" id="sem_error"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Live Broadcast<span style="color:red">*</span></label>
                                <div class="col-sm-5">
                                    <input id="broadcast-name" type="text" class="form-control" placeholder="live streaming for all department and branch" name="title"/>
                                    <label style="display:none; color: red" id="name_error"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <button id="setup-new-broadcast" class="btn btn-primary">Setup New Broadcast</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <section class="col-md-5 col-md-offset-3">
                                    <span>
                                        Private ??
                                        <a href="" class="multicast-live-streaming" target="_blank" title="Open this link in new tab. Then your room will be private!">
                                            Click Here <code style="display:none;">
                                                <strong id="unique-token">#123456789</strong>
                                            </code>
                                        </a>
                                    </span>                                                
                                </section>
                            </div>
                        </div>
                          
                     <?php if($read){ ?>
                        <!-- list of all available broadcasting rooms -->
                        <h4>All Broadcast</h4>
                        <table style="width: 100%;" id="rooms-list" class="table table-bordered table-responsive"></table>

                        <!-- local/remote videos container -->
                        <div id="videos-container" style="margin-right: 5px;"></div>
                        <br/>
                        <h4 class="multicast">All Multicast</h4>
                        <?php
                        $date = date('Y-m-d');

                        $multicast = $this->db->select()
                                ->from('broadcast_and_streaming')
                                ->join('course', 'course.course_id = broadcast_and_streaming.course')
                                ->join('semester', 'semester.s_id = broadcast_and_streaming.semester')
                                ->like('created_at', $date)
                                ->where('url_link !=', '')
                                ->get()
                                ->result();
                        if (count($multicast)) {
                            ?>
                            <table class="table table-responsive table-bordered multicast">
                                <tr>
                                    <th>Title</th>
                                    <th>Course</th>
                                    <th>Semester</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                foreach ($multicast as $mul) {
                                    ?>
                                    <tr>
                                        <td><?php echo $mul->title; ?></td>
                                        <td><?php echo $mul->c_name; ?></td>
                                        <td><?php echo $mul->s_name; ?></td>
                                        <td>
                                            <button class="btn btn-primary" onclick="window.open('<?php echo base_url(); ?>video_streaming#<?php echo $mul->url_link; ?>')">View Streaming</button>

                                        </td>
                                    </tr>                                                    
                                <?php } ?>
                            </table>
                        <?php }
                        
                     }
                        ?>
                        
                    </section>
                    <script>
                        var connection = new RTCMultiConnection();
                        connection.session = {
                            audio: true,
                            video: true,
                            oneway: true
                        };

                        connection.onstream = function (e) {

                            e.mediaElement.width = 600;
                            videosContainer.insertBefore(e.mediaElement, videosContainer.firstChild);
                            //videosContainer.insertBefore(title, videosContainer.firstChild);
                            rotateVideo(e.mediaElement);
                            scaleVideos();
                        };

                        function rotateVideo(mediaElement) {
                            mediaElement.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
                            setTimeout(function () {
                                mediaElement.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
                            }, 1000);
                        }

                        connection.onstreamended = function (e) {
                            e.mediaElement.style.opacity = 0;
                            rotateVideo(e.mediaElement);
                            setTimeout(function () {
                                if (e.mediaElement.parentNode) {
                                    e.mediaElement.parentNode.removeChild(e.mediaElement);
                                }
                                scaleVideos();
                            }, 1000);
                        };

                        var sessions = {};
                        connection.onNewSession = function (session) {
                            if (sessions[session.sessionid])
                                return;
                            sessions[session.sessionid] = session;

                            var tr = document.createElement('tr');
                            tr.innerHTML = '<td align="left"><strong>' + session.sessionid + '</strong> is sharing his webcam in one-way direction!</td>' +
                                    '<td><button class="join btn btn-primary" style="margin-right: 20px;">View</button></td>' +
                                    '<td><button class="btn btn-success startstop" session_id=' + session.sessionid + ' style="margin-left: -100px">Start</button></td>';
                            roomsList.insertBefore(tr, roomsList.firstChild);

                            var joinRoomButton = tr.querySelector('.join');
                            var startStopButton = tr.querySelector('.startstop');
                            startStopButton.setAttribute('id', session.sessionid + 'btn');
                            joinRoomButton.setAttribute('data-sessionid', session.sessionid);
                            joinRoomButton.onclick = function () {
                                this.disabled = true;
                                $('#' + session.sessionid + 'btn').html('Stop');

                                var sessionid = this.getAttribute('data-sessionid');
                                //$('<p>Hello</p>').insertBefore('video');
                                $('<label class="stream_title" style="margin-left: 110px;">' + sessionid + '</label>').insertBefore('#videos-container');
                                session = sessions[sessionid];

                                if (!session)
                                    throw 'No such session exists.';

                                connection.join(session);
                                //console.log('My Object: '+session);
                            };

                            $('.startstop').on('click', function () {
                                var session_clicked = $(this).attr('session_id');
                                var streaming_status = $(this).html();
                                $.ajax({
                                    url: '<?php echo base_url(); ?>video_streaming/start_stop_streaming/' + session_clicked + '/' + streaming_status,
                                    type: 'get',
                                    success: function () {
                                        alert('Streaming is successfully ' + streaming_status);
                                    }
                                })
                            })

                            //multicast start stop
                            $('.multicaststartstop').on('click', function () {
                                var session_clicked = $(this).attr('session_id');
                                var streaming_status = $(this).html();
                                if (streaming_status == 'Start') {
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>video_streaming/start_stop_streaming/' + session_clicked + '/' + streaming_status,
                                        type: 'get',
                                        success: function () {

                                        }
                                    });
                                    $(this).html('Stop');
                                    alert('Streaming is started');
                                } else {
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>video_streaming/start_stop_streaming/' + session_clicked + '/' + streaming_status,
                                        type: 'get',
                                        success: function () {

                                        }
                                    });
                                    $(this).html('Start');
                                    alert('Streaming is stopped');
                                }

                            })

                            $('.multicaststartstop_tab').on('click', function () {
                                var current_multicast_session = $(this).attr('session_id');
                                var current_milticast_status = $(this).html();
                                if (current_milticast_status == 'Start') {
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>admin/start_stop_streaming/' + current_multicast_session + '/' + current_milticast_status,
                                        type: 'get',
                                        success: function () {

                                        }
                                    });
                                    $(this).html('Stop');
                                    alert('Streaming is started');
                                } else {
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>admin/start_stop_streaming/' + current_multicast_session + '/' + current_milticast_status,
                                        type: 'get',
                                        success: function () {

                                        }
                                    });
                                    $(this).html('Start');
                                    alert('Streaming is stopped');
                                }
                            })

                            // start and stop

                            var start_stop_status = 'stop';
                            startStopButton.setAttribute('data-sessionid', session.sessionid);

                            startStopButton.onclick = function () {
                                $('#streamname').val(session.sessionid);
                                startStopButton.setAttribute('status', start_stop_status);
                                var current_status = $(this).attr('status');
                                var video_session_id = $(this).attr('data-sessionid');

                                if (current_status == 'stop') {
                                    start_stop_status = 'start';
                                    $(this).html('Stop');
                                    // update streaming to 1

                                } else if (current_status == 'start') {
                                    start_stop_status = 'stop';

                                    $.ajax({
                                        url: '<?php echo base_url(); ?>video_streaming/in_active_streaming/' + video_session_id,
                                        type: 'post',
                                        success: function () {
                                            //alert('Video stream is stopped.');
                                        }
                                    })
                                    $(this).html('Start');
                                    // update streaming to 0
                                    //$('#myModal').modal('hide');
                                }
                                //this.disabled = true;

                                /*var sessionid = this.getAttribute('data-sessionid');
                                 session = sessions[sessionid];
                                 
                                 if (!session)
                                 throw 'No such session exists.';
                                 
                                 connection.join(session);*/
                            };
                        };

                        var videosContainer = document.getElementById('videos-container') || document.body;
                        var roomsList = document.getElementById('rooms-list');

                        document.getElementById('setup-new-broadcast').onclick = function () {
                            //broadcast
                            var current_url = window.location.href;
                            var result = current_url.split("#");

                            if (result.length == 2) {
                                //multicast
                                if (!multicast_validation()) {
                                    return false;
                                }
                            } else {
                                if (!validate_streaming()) {
                                    return false;
                                }
                            }


                            this.disabled = true;

                            connection.open(document.getElementById('broadcast-name').value || 'Anonymous');
                        };

                        // setup signaling to search existing sessions
                        connection.connect();

                        (function () {
                            var uniqueToken = document.getElementById('unique-token');
                            if (uniqueToken)
                                if (location.hash.length > 2)
                                    uniqueToken.parentNode.parentNode.parentNode.innerHTML = '';
                                else
                                    uniqueToken.innerHTML = uniqueToken.parentNode.parentNode.href = '#' + (Math.random() * new Date().getTime()).toString(36).toUpperCase().replace(/\./g, '-');
                        })();

                        function scaleVideos() {
                            var videos = document.querySelectorAll('video'),
                                    length = videos.length,
                                    video;

                            var minus = 130;
                            var windowHeight = 700;
                            var windowWidth = 600;
                            var windowAspectRatio = windowWidth / windowHeight;
                            var videoAspectRatio = 4 / 3;
                            var blockAspectRatio;
                            var tempVideoWidth = 0;
                            var maxVideoWidth = 0;

                            for (var i = length; i > 0; i--) {
                                blockAspectRatio = i * videoAspectRatio / Math.ceil(length / i);
                                if (blockAspectRatio <= windowAspectRatio) {
                                    tempVideoWidth = videoAspectRatio * windowHeight / Math.ceil(length / i);
                                } else {
                                    tempVideoWidth = windowWidth / i;
                                }
                                if (tempVideoWidth > maxVideoWidth)
                                    maxVideoWidth = tempVideoWidth;
                            }
                            for (var i = 0; i < length; i++) {
                                video = videos[i];
                                if (video)
                                    video.width = maxVideoWidth - minus;
                            }
                        }


                        window.onresize = scaleVideos;
                    </script>

                </article>
                <!-- commits.js is useless for you! -->
                <script src="//cdn.webrtc-experiment.com/commits.js" async>
                </script>
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

</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Live Streaming Setup</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group" id="private-broadcast-course">
                        <label class="col-sm-3 control-label">Stream Name</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="streamname" name="streamname" readonly=""/>
                        </div>
                    </div>

                    <div class="form-group" id="private-broadcast-course">
                        <label class="col-sm-3 control-label">Course</label>
                        <div class="col-sm-5">
                            <select id="course" class="form-control" name="private-broadcast-course">
                                <option value="all">All Course</option>
                                <?php foreach ($course as $row) { ?>
                                    <option value="<?php echo $row->course_id; ?>"><?php echo $row->c_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="private-broadcast-semester">
                        <label class="col-sm-3 control-label">Semester</label>
                        <div class="col-sm-5">
                            <select id="semester" class="form-control" name="private-broadcast-course">
                                <option value="all">All Semester</option>
                                <?php foreach ($semester as $row) { ?>
                                    <option value="<?php echo $row->s_id; ?>"><?php echo $row->s_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-5">
                            <select id="stream_status" name="stream_status" class="form-control">
                                <option value="1">Start</option>
                                <option value="0">Stop</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button id="start_new_broadcast" class="btn btn-success">Setup New Broadcast</button>
                        </div>
                    </div>                        
                </div>
            </div>
            <div class="modal-footer">
                <button id="close_model" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // start multicast
    $(document).ready(function () {
        $('.multicast-live-streaming').on('click', function () {
            var multicast_id = $(this).attr('href');
            var url = $(location).attr('href');
            window.open(url + multicast_id);
        });

        $('.startmulticast').on('click', function () {
            var session_id = $(this).attr('session_id');
            $('#streamname').val(session_id);
        });
    })
</script>

<script>
    // assign broadcast
    $(document).ready(function () {
        // modal on load
        $('#myModal').on('load', function () {
            var stream_name = $('#streamname').val();
            var stream_status = $('#' + stream_name + 'btn').html();
            if (stream_status == 'Start') {
                $('#myModal').modal('hide');
                $('#close_model').click();
            }
        })
        $('#start_new_broadcast').on('click', function () {
            $('#myModal').modal('hide');
            var stream_name = $('#streamname').val();
            //var stream_status = $('#stream_status').val();
            //alert(stream_name);
            // form data
            var formdata = {
                title: $('#streamname').val(),
                course: $('#course').val(),
                semester: $('#semester').val(),
                is_active: $('#stream_status').val()
            };
            $.ajax({
                url: '<?php echo base_url(); ?>video_streaming/assign_live_stream',
                type: 'post',
                data: formdata,
                success: function () {
                    alert('Live stream is successfully updated.');
                    //
                }
            })
            //var stream_status = $('#stream_status').val();               

        })

        $('#close_model').on('click', function () {
            var stream_name = $('#streamname').val();
            $('#' + stream_name + 'btn').html('Start');
        })
    });
</script>

<script>
    $(document).ready(function () {
        var current_url = window.location.href;
        var result = current_url.split("#");

        if (result.length != 2) {
            // show course                
            $('#private-broadcast-course').css('display', 'none');
            $('#private-broadcast-semester').css('display', 'none');
            $('#private-broadcast-degree').css('display', 'none');
            $('#private-broadcast-batch').css('display', 'none');

        } else {
            $('.multicast').css('display', 'none');
        }
        $('#setup-new-broadcast').on('click', function () {

            if (result.length == 2) {
                if (!multicast_validation())
                    return false;
                // private
                // insert via ajax
                var form_data = {
                    title: $('#broadcast-name').val(),
                    degree: $('#degree').val(),
                    course: $('#course').val(),
                    batch: $('#batch').val(),
                    semester: $('#semester').val(),
                    url_link: result[1]
                };
                $.ajax({
                    url: '<?php echo base_url(); ?>video_streaming/create_private_broadcast',
                    type: 'post',
                    data: form_data,
                    success: function () {
                        console.log(form_data);
                        alert('live streaming is created');
                    }
                })
            } else {
                if (!validate_streaming())
                    return false;
                // broadcast
                var form_data = {
                    title: $('#broadcast-name').val(),
                    degree: 'all',
                    course: 'all',
                    batch: 'all',
                    semester: 'all',
                    url_link: result[1]
                };
                console.log(form_data);
                $.ajax({
                    url: '<?php echo base_url(); ?>video_streaming/create_private_broadcast',
                    type: 'post',
                    data: form_data,
                    success: function () {
                        alert('live streaming is created');
                    }
                })
            }
        })

    })
</script>

<script>
    $(document).ready(function () {
        function department_branch(department_id) {
            $('#course').find('option').remove().end();
            $('#course').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#course').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        }

        function batch_from_department_branch(department, branch) {
            $('#batch').find('option').remove().end();
            $('#batch').append('<option value>Select</option>');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>batch/department_branch_batch/" + department + '/' + branch,
                success: function (response) {
                    var branch = jQuery.parseJSON(response);
                    $.each(branch, function (key, value) {
                        $('#batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            });
        }

        function semester_from_branch(branch) {
            $('#semester').find('option').remove().end();
            $('#semester').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
                type: 'GET',
                success: function (content) {
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    });
                }
            });
        }

        //course by degree
        $('#degree').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });

        //batch from course and degree
        $('#course').on('change', function () {
            var degree_id = $('#degree').val();
            var course_id = $(this).val();
            batch_from_department_branch(degree_id, course_id);
            semester_from_branch(course_id);
        })        
    })
</script>

<script>
    function validate_streaming() {
        var name = $('#broadcast-name').val();
        if (name == '') {
            $('#name_error').css('display', 'inline');
            $('#name_error').text('Please enter broadcast name');
            return false;
        } else {
            $('#name_error').css('display', 'none');
            $('#name_error').text('');
            return true;
        }
    }

    function multicast_validation() {
        var name = $('#broadcast-name').val();
        var degree = $('#degree').val();
        var course = $('#course').val();
        var batch = $('#batch').val();
        var sem = $('#semester').val();

        if (degree == '') {
            $('#degree_error').css('display', 'inline');
            $('#degree_error').text('Please select course');
            return false;
        } else {
            $('#degree_error').css('display', 'none');
            $('#degree_error').text('');
            //return true;
        }

        if (course == '') {
            $('#course_error').css('display', 'inline');
            $('#course_error').text('Please select branch');
            return false;
        } else {
            $('#course_error').css('display', 'none');
            $('#course_error').text('');
            //return true;
        }

        if (batch == '') {
            $('#batch_error').css('display', 'inline');
            $('#batch_error').text('Please select batch');
            return false;
        } else {
            $('#batch_error').css('display', 'none');
            $('#batch_error').text('');
            //return true;
        }

        if (sem == '') {
            $('#sem_error').css('display', 'inline');
            $('#sem_error').text('Please select semester');
            return false;
        } else {
            $('#sem_error').css('display', 'none');
            $('#sem_error').text('');
            //return true;
        }

        if (name == '') {
            $('#name_error').css('display', 'inline');
            $('#name_error').text('Please enter broadcast name');
            return false;
        } else {
            $('#name_error').css('display', 'none');
            $('#name_error').text('');
            return true;
        }
    }
</script>

<script>
    window.onbeforeunload = function (e) {
        e = e || window.event;

        // For IE and Firefox prior to version 4
        if (e) {
            e.returnValue = 'Are you sure to unload or close the video streaming?';
            console.log(e);
        }

        // For Safari
        return 'Are you sure to unload or close the video streaming?';
    };
</script>
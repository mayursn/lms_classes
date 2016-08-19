<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">

            <div class=panel-body>
                <div class="tabs mb20">
                    <ul id="import-tab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#list" data-toggle="tab" aria-expanded="true"><?php echo ucwords("Assessment List"); ?></a>
                        </li>
                        <li class="">
                            <a href="#submittedlist" data-toggle="tab" aria-expanded="false"><?php echo ucwords("submitted assignment list"); ?></a>
                        </li>
                    </ul>
                    <div id="import-tab-content" class="tab-content">

                        <div class="tab-pane fade active in" id="list">                  
                            <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                                <thead>
                                    <tr>
                                        <th >No</th>		
                                        <th >Assignment</th>
                                        <th >Student</th>
                                        <th >Image</th>
                                        <th >Assignment-File</th>
                                        <th >Submitted-File</th>
                                        <th >Department</th>
                                        <th >Branch</th>											                                        
                                        <th >Semester</th>
                                        <th>Subject</th>
                                        <th>Professor Name</th>
                                        <th >Instruction</th>
                                        <th >Feedback</th>                                                
                                        <th >Grade</th>	
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($assessment->result_array() as $row):
                                        ?>
                                        <tr>
                                            <td ><?php echo $count++; ?></td>	
                                            <td ><?php echo $row['assign_title']; ?></td>   
                                            <td ><?php echo $row['name']; ?></td>
                                            <td ><img src="<?php echo base_url().'uploads/system_image/'.$row['profile_pic']; ?>" height="50" width="50" ></td>
                                            <td  id="downloadedfile"><a href="<?php echo base_url() . 'uploads/project_file/' . $row['assign_filename']; ?>" download="" title="download"><i class="fa fa-download"></i></a></td>	
                                            <td  id="downloadedfile"><a href="<?php echo base_url() . 'uploads/project_file/' . $row['document_file']; ?>" download="" title="download"><i class="fa fa-download"></i></a></td>	
                                            <td ><?php
                                                    foreach ($degree as $dgr):
                                                        if ($dgr->d_id == $row['std_degree']):

                                                            echo $dgr->d_name;
                                                        endif;


                                                    endforeach;
                                        ?></td>
                                            <td >
                                                <?php
                                                foreach ($course as $crs) {
                                                    if ($crs->course_id == $row['course_id']) {
                                                        echo $crs->c_name;
                                                    }
                                                }
                                                ?>
                                            </td>
                                             
                                            <td >
                                                <?php
                                                foreach ($semester as $sem) {
                                                    if ($sem->s_id == $row['semester_id']) {
                                                        echo $sem->s_name;
                                                    }
                                                }
                                                ?>													
                                            </td>
                                            <td><?php   echo $row['subject_name'];
                                                    ?></td>
                                            <td><?php echo roleuserdatatopic($row['user_role'],$row['user_id']); ?></td>
                                            <td ><?php echo $row['assignment_instruction']; ?></td>	
                                            <td ><?php echo wordwrap($row['feedback'], 30, "<br>\n"); ?></td>
                                            <td ><?php echo $row['grade']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>																									
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="submittedlist">
                            <div class="row filter-row">
                                <form id="submitted-filter" action="#" class="form-groups-bordered validate">
                                    <div class="form-group col-sm-3">
                                        <label><?php echo ucwords("department"); ?></label>
                                        <select class="form-control" id="submit-course" name="degree_search">
                                            <option value="">Select</option>
                                            <?php foreach ($degree as $row) { ?>
                                                <option value="<?php echo $row->d_id; ?>"><?php echo $row->d_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label><?php echo ucwords("Branch"); ?></label>
                                        <select id="submit-branch" name="course_search" data-filter="4" class="form-control">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                                                   
                                    <div class="form-group col-sm-2">
                                        <label> <?php echo ucwords("Semester"); ?></label>
                                        <select id="submit-semester" name="semester_search" data-filter="6" class="form-control">
                                            <option value="">Select</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label><?php echo ucwords("Subject"); ?></label>
                                        <select id="submit-subject" name="subject_search" data-filter="5" class="form-control">
                                            <option value="">Select</option>
                                        </select>
                                    </div> 
                                    <div class="form-group col-sm-1" style="display: none;">
                                        <label><?php echo ucwords("Class"); ?><span style="color:red"></span></label>
                                        <select class="form-control filter-rows" name="divclass" id="sfilterclass" >
                                            <option value="">Select</option>
                                            <?php
                                            $class = $this->db->get('class')->result_array();
                                            foreach ($class as $c) {
                                                ?>
                                                <option value="<?php echo $c['class_id'] ?>"><?php echo $c['class_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="form-group col-sm-2">
                                        <label>&nbsp;</label><br/>
                                        <input id="submitted" type="button" value="Go" class="btn btn-info"/>
                                    </div>
                                </form>
                            </div>
                            <div class="panel-body table-responsive" id="getsubmit">
                                <table class="table table-striped table-bordered table-responsive" cellspacing=0 width=100% id="sub-tables">
                                    <thead>
                                        <tr>
                                            <th >No</th>												
                                            <th ><?php echo ucwords("Assignment"); ?></th>
                                            <th ><?php echo ucwords("Student"); ?></th>
                                            <th ><?php echo ucwords("Department"); ?></th>
                                            <th ><?php echo ucwords("Branch"); ?></th>												                                         
                                            <th ><?php echo ucwords("Semester"); ?></th>	
                                            <th><?php echo ucwords("Subject"); ?></th>
                                            <th ><?php echo ucwords("Submission date"); ?></th>	
                                            <th ><?php echo ucwords("Submitted-date"); ?></th>	
                                            <th ><?php echo ucwords("Comment"); ?></th>
                                            <th ><?php echo ucwords("File"); ?></th>	
                                            <th ><?php echo ucwords("Action"); ?></th>	
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($submitedassignment->result() as $rowsub):
                                            ?>
                                            <tr>
                                                <td ><?php echo $count++; ?></td>
                                                <td ><?php echo $rowsub->assign_title; ?></td>
                                                <td ><?php echo $rowsub->name; ?></td>
                                                <td ><?php
                                        foreach ($degree as $dgr):
                                            if ($dgr->d_id == $rowsub->assign_degree):

                                                echo $dgr->d_name;
                                            endif;


                                        endforeach;
                                            ?></td>
                                                <td >
                                                    <?php
                                                    foreach ($course as $crs) {
                                                        if ($crs->course_id == $rowsub->course_id) {
                                                            echo $crs->c_name;
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    foreach ($semester as $sem) {
                                                        if ($sem->s_id == $rowsub->assign_sem) {
                                                            echo $sem->s_name;
                                                        }
                                                    }
                                                    ?>													
                                                </td>	
                                                 <td>
                                                    <?php
                                                    $this->load->model('subject/Subject_manager_model');
                                                    $name = $this->Subject_manager_model->get_subject_name($rowsub->sm_id);
                                                    echo $name;
                                                    ?>
                                                </td>
                                                <td ><?php echo date_formats($rowsub->assign_dos); ?></td>	
                                                <td ><?php echo date_formats($rowsub->submited_date); ?></td>	
                                                <td ><?php echo $rowsub->comment; ?></td>
                                                <td id="downloadedfile"><a href="<?php echo base_url(); ?>uploads/project_file/<?php echo $rowsub->document_file; ?>" download="" title="download"><i class="fa fa-download"></i></a></td>                      	
                                                <td  class="menu-action">
                                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/assessments_create/<?php echo $rowsub->assignment_submit_id; ?>');" data-toggle="modal"><span class="label label-primary mr6 mb6">Assessment</span></a>

                                                </td>	
                                            </tr>
                                        <?php endforeach; ?>						
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End .panel -->
        </div>
        <!-- col-lg-12 end here -->
    </div>
    <!-- End .row -->
</div></div></div>
<!-- End contentwrapper -->

<!-- End #content -->

<script>
    
    
    $(document).ready(function () {
        $('#submit-course').on('change', function () {
            var department_id = $(this).val();
            department_branch(department_id);
        });
        $('#submit-branch').on('change', function () {
            var branch_id = $(this).val();
            var department = $('#submit-course').val();
            batch_form_department_branch(department, branch_id);
            semester_from_branch(branch_id);
        });
        $('#submit-semester').on('change', function () {
            var sem =  $(this).val();
            var branch_id = $('#submit-branch').val();
            var department = $('#submit-course').val();
           subject_get_submitted(department,branch_id,sem);
        });
        
        function subject_get_submitted(department,branch_id,sem)
        {
             $('#submit-subject').find('option').remove().end();
            $('#submit-subject').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>subject/subject_department_branch_sem/' + department + '/' + branch_id + '/'+sem,
                type: 'GET',
                success: function (content) {
                    var subject = jQuery.parseJSON(content);
                    console.log(subject);
                    $.each(subject, function (key, value) {
                        $('#submit-subject').append('<option value=' + value.sm_id + '>' + value.subject_name + '</option>');
                    });
                }
            });
        }
        function department_branch(department_id) {
            $('#submit-branch').find('option').remove().end();
            $('#submit-branch').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>branch/department_branch/' + department_id,
                type: 'GET',
                success: function (content) {
                    var branch = jQuery.parseJSON(content);
                    console.log(branch);
                    $.each(branch, function (key, value) {
                        $('#submit-branch').append('<option value=' + value.course_id + '>' + value.c_name + '</option>');
                    });
                }
            });
        }

        function batch_form_department_branch(department, branch) {
            $('#submit-batch').find('option').remove().end();
            $('#submit-batch').append('<option value>Select</option>');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>batch/department_branch_batch/" + department + '/' + branch,
                success: function (response) {
                    var branch = jQuery.parseJSON(response);
                    $.each(branch, function (key, value) {
                        $('#submit-batch').append('<option value=' + value.b_id + '>' + value.b_name + '</option>');
                    });
                }
            });
        }

        function semester_from_branch(branch) {
            $('#submit-semester').find('option').remove().end();
            $('#submit-semester').append('<option value>Select</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>semester/semester_branch/' + branch,
                type: 'GET',
                success: function (content) {
                    var semester = jQuery.parseJSON(content);
                    $.each(semester, function (key, value) {
                        $('#submit-semester').append('<option value=' + value.s_id + '>' + value.s_name + '</option>');
                    });
                }
            });
        }
        
         var forms = $('#submitted-filter');
          $('#submitted').on('click', function () {
                $("#submitted").validate({
                    rules: {
                        degree_search: "required",
                        course_search: "required",
                        batch_search: "required",
                        semester_search: "required"
                    },
                    messages: {
                        degree_search: "Select department",
                        course_search: "Select branch",
                        batch_search: "Select batch",
                        semester_search: "Select semester"
                    }
                });

                if (forms.valid() == true)
                {

                    var degree = $("#submit-course").val();
                    var course = $("#submit-branch").val();
                    var subject = $("#submit-subject").val();
                    var semester = $("#submit-semester").val();
                    var divclass = $("#submit-class").val();
                  
                    $.ajax({
                        url: '<?php echo base_url(); ?>assignment/getassignment/assessments',
                        type: 'post',
                        data: {'degree': degree, "course": course, "subject": subject, "semester": semester},
                        success: function (content) {                        
                            $("#getsubmit").html(content);
                            // $("#dtbl").hide();
                        }
                    });
                }
            });
    });
</script>
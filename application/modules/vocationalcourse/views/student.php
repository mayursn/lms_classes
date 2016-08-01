<!-- Start .row -->
<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <div class=panel-body>                
                <table id="datatable-list1" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student Name</th>
                            <th>Degree</th>
                            <th>Course</th>
                            <th>Semester</th>
                            <th>Course Name</th>
                            <th>Course Category</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($student as $row):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>                                                                
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->d_name; ?></td>
                                <td><?php echo $row->c_name; ?></td>
                                <td><?php echo $row->s_name; ?></td>
                                <td><?php echo $row->course_name; ?></td>                                                                
                                <td><?php echo $row->category_name; ?></td>                
                            </tr>
                        <?php endforeach; ?>											
                    </tbody>
                </table>
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
<script>
$(document).ready(function () {
        $('#datatable-list1').DataTable({"language": { "emptyTable": "No data available" }});
    });
</script>
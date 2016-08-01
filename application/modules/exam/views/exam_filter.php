<table class="table table-striped table-bordered table-responsive" id="exam-data-tables">
    <thead>
        <tr>
            <th>No</th>
            <th>Exam Name</th>
            <th>Department</th>
            <th>Branch</th>
            <th>Batch</th>
            <th>Semester</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = 0;
        foreach ($exams as $row) {
            $counter++;
            $cenlist = array();
            ?>
            <tr>
                <td><?php echo $counter; ?></td>
                <td><?php echo $row->em_name; ?></td>
                <td><?php echo $row->d_name; ?></td>
                <td><?php echo $row->c_name; ?></td>
                <td><?php echo $row->b_name; ?></td>
                <td><?php echo $row->s_name; ?></td>
                <td><?php echo date_formats($row->em_date); ?></td>
                <td class="menu-action">
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/exam_edit/<?php echo $row->em_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-primary mr6 mb6"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span></a>
                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>exam/delete/<?php echo $row->em_id; ?>');"  data-toggle="tooltip" data-placement="top"><span class="label label-danger mr6 mb6"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        "use strict";
        $('#exam-data-tables').dataTable({
            "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'l><'col-sm-4'i><'col-sm-4'p>>",
                    "language": { "emptyTable": "No data available" }
        });
        $('.filter-rows').on('change', function () {
            var filter_id = $(this).attr('data-filter');
            filter_column(filter_id);
        });

        function filter_column(filter_id) {
            $('#exam-data-tables').DataTable().column(filter_id).search(
                    $('#filter' + filter_id).val()
                    ).draw();
        }
    });
</script>
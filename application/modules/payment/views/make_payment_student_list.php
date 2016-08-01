<table id="make-payment-student-datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
    <thead>
        <tr>
            <th>No</th>
            <th>Student Name</th>
            <th>Department</th>
            <th>Branch</th>
            <th>Batch</th>
            <th>Semester</th>
            <th>Paid Amount</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($student_fees as $row) { ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo $row->std_first_name . ' ' . $row->std_last_name; ?></td>
                <td><?php echo $row->d_name; ?></td>
                <td><?php echo $row->c_name; ?></td>
                <td><?php echo $row->b_name; ?></td>
                <td><?php echo $row->s_name; ?></td>
                <td>$<?php echo $row->paid_amount; ?></td>
                <td><?php echo date_formats($row->paid_created_at); ?></td>
                <td class="menu-action">
                    <a href="<?php echo base_url('feerecord/invoice/' . $row->student_fees_id); ?>" target="_blank"><span class="label label-primary mr6 mb6">View</span></a>
                    <a target="_blank" href="<?php echo base_url('feerecord/invoice_print/'.$row->student_fees_id); ?>"><span class="label label-danger mr6 mb6">Download</span></a>
                </td>
            </tr>
        <?php } ?>														
    </tbody>
</table>

<script>
$(document).ready(function(){
   $('#make-payment-student-datatable-list').DataTable({"language": { "emptyTable": "No data available" }}); 
});
</script>
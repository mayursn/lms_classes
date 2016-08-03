<?php
$create = create_permission($permission, 'Class');
$read = read_permission($permission, 'Class');
$update = update_permisssion($permission, 'Class');
$delete = delete_permission($permission, 'Class');
?>
              
                <?php if ($create || $read || $update || $delete) { ?>
                    
                    <table id="datatable-list" class="table table-striped table-bordered table-responsive" cellspacing=0 width=100%>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Exam </th>
                                <th>Student </th>
                                <th>Obtained Marks </th>
                                <th>Out of Marks </th>
                                <th>Percentage </th>
                                
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i=1;
                            foreach ($toppers as $row): ?>
                            <?php 
                            $total = ($row->total*100/$row->outmark);
			   $total = number_format($total, 2, '.', ',');
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row->em_name; ?></td> 
                                    <td><?php echo $row->std_first_name.' '.$row->std_last_name; ?></td> 
                                    <td><?php echo $row->total; ?></td> 
                                    <td><?php echo $row->outmark; ?></td> 
                                    <td><?php echo $total.' %'; ?></td> 
                                </tr>
                            <?php endforeach; ?>																				
                        </tbody>
                    </table>
                <?php } ?>

<?php
$this->db->select('event_id,event_name,event_date');
$dataevent = $this->db->get_where('event_manager', array('date(event_date)' => $param2))->result_array();
$this->db->select('todo_id,todo_title,todo_datetime');
$datatodo = $this->db->get_where('todo_list', array('date(todo_datetime)' => $param2, 'todo_role' => 'student', 'todo_role_id' => $this->session->userdata('std_id')))->result_array();
?>
<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <?php
            if (!empty($dataevent)) {
                ?>
                <h4 class=panel-title><?php echo ucwords("event list"); ?></h4>
                <!-- Start .panel -->
                <div class="panel-body"> 
                    <ul>
                        <?php
                        foreach ($dataevent as $row) {
                            ?>
                            <li><?php echo $row['event_name']; ?></li>
                            <?php
                        }
                        ?>

                    </ul>

                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>


<div class=row>                      
    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle panelMove panelClose panelRefresh">
            <?php
            if (!empty($datatodo)) {
                ?>
                <h4 class=panel-title><?php echo ucwords("todo list"); ?></h4>
                <!-- Start .panel -->
                <div class="panel-body"> 
                    <ul>
                        <?php
                        foreach ($datatodo as $row) {
                            ?>
                            <li><?php echo $row['todo_title']; ?></li>
                            <?php
                        }
                        ?>

                    </ul>

                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

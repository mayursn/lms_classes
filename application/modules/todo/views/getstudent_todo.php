<?php foreach ($todolist as $todo) { ?>  
    <li class="todo-task-item <?php
    if ($todo->todo_status == "0") {
        echo "task-done";
    }
    ?>" id="todo-task-item-id<?php echo $todo->todo_id; ?>">
        <div class=checkbox-custom><input type="checkbox"  <?php
            if ($todo->todo_status == "0") {
                echo "checked=''";
            }
            ?> value="<?php echo $todo->todo_id ?>" id="checkbox<?php echo $todo->todo_id ?>" class="taskstatus"><label for=checkbox1></label></div>               
        <div class=todo-task-text><?php echo $todo->todo_title; ?></div>
        <div class="todo-category"><i class="mar4top fa fa-calendar" aria-hidden="true"></i><?php echo date_duration($todo->todo_datetime); ?></div>
        
        <div class="updateclick_box <?php if($todo->todo_status=='0') { ?> hidden <?php } ?>" id="getupdatecheck<?php echo $todo->todo_id; ?>">
            <button type=button class="updateclick" value="<?php echo $todo->todo_id; ?>"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button>
        </div>
        
        <div class="todo-close_box">
            <button type=button class="close-todo-old todo-close1" value="<?php echo $todo->todo_id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </div>
    </li>
<?php } ?>

<script type="text/javascript">    
    $(".todo-list").css({'overflow':'auto'});
    $(".taskstatus").click(function () {
        if ($(this).is(':checked'))
        {

            $(this).closest('li.todo-task-item').addClass('task-done');
            var id = $(this).val(); // todo id
            var dataString = "id=" + id + "&status=0";
            $('#getupdatecheck'+id).addClass('hidden');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>todo/changestatus",
                data: dataString,
                success: function () {

                }
            });

        } else {
            $(this).closest('li.todo-task-item').removeClass('task-done');

            var id = $(this).val(); // todo id
            var dataString = "id=" + id + "&status=1";
            $('#getupdatecheck'+id).removeClass('hidden');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>todo/changestatus",
                data: dataString,
                success: function () {

                }
            });

        }

    });


    $(".todo-close1").click(function () {
    
        var r = confirm("Are sure want to delete?");
        if (r == true) {

        } else {
            return false
        }  
        var id = $(this).val();
        var dataString = "id=" + id;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>todo/removetodolist",
            data: dataString,
            success: function () {
                $('li#todo-task-item-id' + id).hide();
            }

        });


    });
    $(".updateclick").click(function () {

        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>todo/student_todoupdateform/" + id,
            success: function (response)
            {
                $("#updateformhtml").html(response);
                $("#todo-addform").hide();
                $('.todo-close_box').css('pointer-events', 'none');
            }
        });
    });
    
</script>
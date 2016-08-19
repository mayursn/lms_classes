$(document).ready(function () {
    $(".todo-list").css({'overflow':'auto'});
    $("#minute-step-timepicker").val("");
    $("#todo-addform").hide();
    $("#basic-datepicker").datepicker({
        autoclose: true,
         startDate: new Date(),

        format:'MM d, yyyy',
    });
    //task-done

    $('#minute-step-timepicker').timepicker({
        upArrowStyle: 'fa fa-angle-up',
        downArrowStyle: 'fa fa-angle-down',
        minuteStep: 1
    });
    $(document).ajaxStart(function () {
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function () {
        $("#wait").css("display", "none");
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
            url: base_url + "admin/removetodolist",
            data: dataString,
            success: function () {            
                $("#todo-task-item-id"+id).hide();
            }

        });
    });
    jQuery('#addnewtodo').live('click', function (event) {
        $("#updateformhtml").html('');
        $("#todo-addform").toggle('show');
        $("i", this).toggleClass("icomoon-icon-plus icomoon-icon-minus");
        $('#addbutton').val('Add New to do');
        $('#closeform').val('Close');
        $("#minute-step-timepicker").val("");
        $('#frmtodo #todo_title').val('');
        $('#frmtodo #basic-datepicker').val('');
    });
    $("#frmtodo").validate({
            rules: {
                todo_title: "required",
                tado_date: "required",
                todo_time:"required",                
            },
            messages: {
                todo_title: "Enter title",
                tado_date: "Select date",
                todo_time:"Select time",
            },
            
            submitHandler: function() {              
                var title = $("#todo_title").val();
                var todo_date = $("#basic-datepicker").val();   
                var todo_time = $("#minute-step-timepicker").val();
                if(todo_date=="")
                {
                     $("#basic-datepicker").css({'border-color':'red'});
                     return false;
                }
                var dataString = "title=" + encodeURIComponent(title) + "&todo_date=" + todo_date + "&todo_time=" + todo_time;                                
                        $.post(base_url+"admin/add_to_do", dataString,                        
                        function(data){                            
                          $(".todo-list").html(data);
                          $('#frmtodo #todo_title').val('');
                          $('#frmtodo #basic-datepicker').val('');
                        });
                    }
        });
    $(".taskstatus").click(function () {
        if ($(this).is(':checked'))
        {

            $(this).closest('li.todo-task-item').addClass('task-done');
            var id = $(this).val(); // todo id
            var dataString = "id=" + id + "&status=0";
            $.ajax({
                type: "POST",
                url: base_url + "admin/changestatus",
                data: dataString,
                success: function () {

                }
            });
        } else {
            $(this).closest('li.todo-task-item').removeClass('task-done');
            var id = $(this).val(); // todo id
            var dataString = "id=" + id + "&status=1";
            $.ajax({
                type: "POST",
                url: base_url + "admin/changestatus",
                data: dataString,
                success: function () {

                }
            });
        }

    });
    /**
     * Update ajax request
     */
    $(".updateclick").click(function () {

        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: base_url + "admin/todoupdateform/" + id,
            success: function (response)
            {
                $("#todo-addform").hide();
                $("#updateformhtml").html(response);
                $('.todo-close_box').css('pointer-events', 'none');
            }
        });
    });
    $("#closeform").click(function () {
        $("#todo-addform").hide(500);
    });
});
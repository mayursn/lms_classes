 <div class="todo-addform todo-search" id="todo-updateform">
    <div class="row">
        <div class="col-lg-12">
        <h4 class="todo-period">Update ToDo</h4>
                    <form id="frmtodoedit" class="form-horizontal form-groups-bordered validate">

                        <div class=form-group>
                            <label class="control-label col-lg-4">Task Title</label>
                            <div class="col-sm-8">
                                <input type="text" id="todo_titleedit" class=form-control name="todo_title" value="<?php echo $todolist->todo_title; ?>"  >
                            <input type="hidden" value="<?php echo $todolist->todo_id; ?>" id="todo_id">
                            </div>                            
                        </div>

                        <div class=form-group>
                            <label class="control-label col-lg-4">Task Date</label>
                             <div class="col-sm-8">
                                 <input id="basic-datepickeredit" type="text" name="tado_date" class="form-control"  value="<?php echo date_formats($todolist->todo_datetime); ?>">
                            </div>           
                            
                        </div>

                        <div class=form-group>
                            <label class="control-label col-lg-4">Task Time</label>
                            <div class="col-sm-8">
                                <div class="input-group bootstrap-timepicker">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    <input id="minute-step-timepickeredit" name="todo_time" type="text" class="form-control" value="<?php echo date("h:i A",  strtotime($todolist->todo_datetime)); ?>"  >
                                </div>
                                 <label id="minute-step-timepickeredit-error" style="display:none;" class="error" for="minute-step-timepickeredit">Select time</label>
                            </div>
                        </div>

                        <div class=form-group>
                            <div class="col-sm-offset-4 col-sm-8">
                                <input type="submit" class="btn btn-primary" name="submit" value="Update Task" id="updatebutton" >                                
                                <input type="button" class="btn btn-primary" name="submit" value="Close" id="updatecloseform">
                            </div>
                        </div>

                    </form>            
        </div>
    </div>
     

</div>

<script type="text/javascript">      
  
        
        $(document).ajaxStart(function () {
            $("#wait").css("display", "block");
        });
        $(document).ajaxComplete(function () {
            $("#wait").css("display", "none");
        });
         var js_date_format = '<?php echo js_dateformat(); ?>';
        $("#basic-datepickeredit").datepicker({
            format: js_date_format,
           startDate: new Date(),
            autoclose: true,
        });
        $("#updatecloseform").click(function () {
    $("#todo-updateform").hide(500);
    $('.todo-close_box').css('pointer-events', '');
    });

        $('#minute-step-timepickeredit').timepicker({
            upArrowStyle: 'fa fa-angle-up',
            downArrowStyle: 'fa fa-angle-down',
            minuteStep: 1,
            autoclose: true,
        });

        $("#frmtodoedit").validate({
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
               var title = $("#todo_titleedit").val();
                var todo_date = $("#basic-datepickeredit").val();
                var todo_time = $("#minute-step-timepickeredit").val();
                if(todo_date=="")
                {
                     $("#basic-datepicker").css({'border-color':'red'});
                     return false;
                }
                var todo_id = $("#todo_id").val();
                var dataString = "title=" + encodeURIComponent(title) +"&todo_date="+todo_date+"&todo_time="+todo_time+"&todo_id="+todo_id;                
                        $.post("<?php echo base_url(); ?>todo/student_updatetodolist", dataString
                         ,                        
                        function(data){                         
                          $(".todo-list").html(data);                        
                        $("#updateformhtml").html('');
                        });
                    }
        });


</script>
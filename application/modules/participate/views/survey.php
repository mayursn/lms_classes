<!-- Start .row -->
<!--
// .demo-table th {background: #999;padding: 5px;text-align: left;color:#FFF;}
  // .demo-table td {border-bottom: #f0f0f0 1px solid;background-color: #ffffff;padding: 5px;}
-->
<style>
   .demo-table {width: 100%;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}  
   .demo-table td div.feed_title{text-decoration: none;color:#00d4ff;font-weight:bold;}
   .demo-table ul{margin:0;padding:0;}
   .demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
   .demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
</style>
<script>function highlightStar(obj,id) {
   removeHighlight(id);   
   $('.demo-table #tutorial-'+id+' li').each(function(index) {
    $(this).addClass('highlight');
    if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
      return false; 
    }
   });
   }
   
   function removeHighlight(id) {
   $('.demo-table #tutorial-'+id+' li').removeClass('selected');
   $('.demo-table #tutorial-'+id+' li').removeClass('highlight');
   }
   
   function addRating(obj,id) {
   $('.demo-table #tutorial-'+id+' li').each(function(index) {
    $(this).addClass('selected');
    $('#tutorial-'+id+' #rating').val((index+1));
    if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
      return false; 
    }
   });
    var rate = $('#tutorial-'+id+' #rating').val();       
    var rated = $("#rating-"+id).val(rate);
//   $.ajax({
//   url: "<?php echo base_url(); ?>student/addrating",
//   data:'id='+id+'&rating='+rate,
//   type: "POST",
//          success:function(){
//             // $("#question-"+id).hide();
//          }
//   });
   }
   
   function resetRating(id) {
   if($('#tutorial-'+id+' #rating').val() != 0) {
    $('.demo-table #tutorial-'+id+' li').each(function(index) {
      $(this).addClass('selected');
      if((index+1) == $('#tutorial-'+id+' #rating').val()) {
        return false; 
      }
    });
   }
   } 
</script>
<div class=row>
   <div class=col-lg-12>
      <!-- col-lg-12 start here -->
      <div class="panel-default toggle panelMove panelClose panelRefresh">
         <!-- Start .panel -->
         <!--            <div class=panel-heading>
            <h4 class=panel-title><?php echo $title; ?></h4>
            <div class="panel-controls panel-controls-right">
                <a class="panel-refresh" href="#"><i class="fa fa-refresh s12"></i></a>
                <a class="toggle panel-minimize" href="#"><i class="fa fa-plus s12"></i></a>
                <a class="panel-close" href="#"><i class="fa fa-times s12"></i></a>
            </div>
            </div>-->
         <div class=panel-body>
              <?php if(count($survey) > 0 ){ ?>
            <form id="frmsurvey" name="frmsurvey" class=" demo-table form-horizontal form-groups-bordered validate" accept-charset="UTF-8" enctype="multipart/form-data" method="post" novalidate="" action="<?php echo base_url(); ?>participate/survey">
               <table class="table table-striped" id="" >
                  <!--   <caption id="title1">As a student here: Please rate each of the following during your attendance, using a 1-5 scale where (1) means "Very dissatisfied" and (5) is "Very satisfied":</caption>-->
                  <thead>
                     <tr>
                    
                        <th>Question</th>
                        <th>Rate</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php  foreach ($survey as $rows):        ?>
                     <tr id="question-<?php echo $rows->sq_id; ?>">                    
                        <th><label><?php echo $rows->question; ?> <span style="color:red">*</span></label>
                        <th>
                            <?php $res = '';
                            ?>  
                           <div id="tutorial-<?php echo $rows->sq_id; ?>">
                              <input type="hidden" name="rating" id="rating" value="<?php echo '0'; ?>" />
                              <input type="hidden" name="question_id<?php echo $rows->sq_id; ?>" id="rating-<?php echo $rows->sq_id; ?>" value="">
                            
                              <ul <?php if(!isset($res->std_rating)){ ?> onMouseOut="resetRating(<?php echo $rows->sq_id; ?>);" <?php } ?>>
                              <?php
                                 for ($i = 1; $i <= 5; $i++) {
                                     if(isset($res->std_rating) && $i <= $res->std_rating)
                                    {
                                     $selected = "selected";
                                    }
                                    else{
                                        $selected = "";
                                    }
                                     ?>
                              <li class='<?php echo $selected; ?>' <?php if(!isset($res->std_rating)){ ?> onmouseover="highlightStar(this,<?php echo $rows->sq_id; ?>);" onmouseout="removeHighlight(<?php echo $rows->sq_id; ?>);" onClick="addRating(this,<?php echo $rows->sq_id; ?>);" <?php } ?>>&#9733;</li>
                              <?php } ?>
                              </ul>
                           </div>
                        </th>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>      
                <?php if(count($survey) > 0 ){ ?>
              <div class="col-sm-offset-10 col-sm-5">
                                <button type="submit" class="btn btn-info vd_bg-green">Submit</button>
                            </div>
                <?php } ?>
            </form>
              <?php }else{
                  echo '<h4> You have already submitted survey feedback. </h4>';
              } ?>
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
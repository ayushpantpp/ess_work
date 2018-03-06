<!--<div class="users form">   



 <?php 
//    if(isset($a))
//    {
//      echo "<h2>".$a."</h2>";  
//    }
    ?>
<?php //echo $this->Form->create("tasks",['method'=>'post','action'=>'/tasklist']) ?>
<?php //echo $this->Form->input('Task Name') ?>
<?php //echo $this->Form->input('Project Name') ?>
<?php //echo $this->Form->submit('submit') ?>
<?php //echo $this->Form->end() ?>*/
</div>-->

    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Create Group</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Add New Group</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
                
                <?php
                echo $this->form->create('Taskassign', array('url' => '','name'=>'Form1','action'=>'add','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));
                ?>

                <?php //$auth=$this->Session->read('Auth');?>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Group Name:<span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?php echo $this->form->input('user_name', array('label'=>false, 'type' => 'select', 'value' => '','class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name')); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Task ID: <span class="required">*</span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <?php echo $this->form->input('task_name', array('class' => "form-control s-form-item s-form-all", 'label'=>false,'type' => 'text', 'options' => array_map('strtoupper', $task_name), 'default' => '', 'id' =>'task_name')); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Assign Date(d/m/y)<span class="required">*</span></label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->form->input('dt_start_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",'type' => 'text', 'id' => 'startdate','readonly'=>true)); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Task Name:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                     <?php echo $this->form->input('user_name', array('label'=>false, 'type' => 'text', 'value' => '','class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name')); ?>   
                    </div>

                    <div class="col-md-3 col-sm-3 row col-xs-12">
                    <?php echo $this->form->input('ch_st_dayhalf', array('class' => "form-control s-form-item s-form-all", 'label'=>false,'type' => 'select', 'options' => array('F'=>"FIRST HALF",'S'=>"SECOND HALF"), 'default' => 'F', 'id' =>'st_half_type_div','style'=>'display:none;')); ?>

                    </div>
                  </div>
                
                <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Target Date(d/m/y)<span class="required">*</span></label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->form->input('dt_end_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12",'type' => 'text', 'id' => 'enddate','readonly'=>true)); ?>
                    </div>
                  </div>
                
                <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Project Name:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <?php echo $this->form->input('user_name', array('label'=>false, 'type' => 'select', 'value' => '','class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name')); ?>
                    </div>
                    <div class="col-md-3 col-sm-3 row col-xs-12">
                    <?php echo $this->form->input('ch_ed_dayhalf', array('class' => "form-control s-form-item s-form-all", 'label'=>false,'type' => 'select', 'options' => array('F'=>"FIRST HALF",'S'=>"SECOND HALF"), 'default' => 'F', 'id' =>'ed_half_type_div','style'=>'display:none;')); ?>

                    </div>

  
                  </div>
                  
                
                
                           
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Remark<span></span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    
                      <?php echo $this->form->textarea('vc_leave_reason', array('label'=>false,'class'=>"form-control", 'maxlength' => "145",'style'=>"width: 310px; height: 63px;")); ?>
                    </div>
                  </div>
                  
                <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Module Name :<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <?php echo $this->form->input('user_name', array('label'=>false, 'type' => 'select', 'value' => '','class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name')); ?>
                    </div>
                    <div class="col-md-3 col-sm-3 row col-xs-12">
                    <?php echo $this->form->input('ch_ed_dayhalf', array('class' => "form-control s-form-item s-form-all", 'label'=>false,'type' => 'select', 'options' => array('F'=>"FIRST HALF",'S'=>"SECOND HALF"), 'default' => 'F', 'id' =>'ed_half_type_div','style'=>'display:none;')); ?>

                    </div>

  
                  </div> 
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Task Priority:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <?php echo $this->form->input('user_name', array('label'=>false, 'type' => 'select', 'value' => '','class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name')); ?>
                    </div>
                    <div class="col-md-3 col-sm-3 row col-xs-12">
                    <?php echo $this->form->input('ch_ed_dayhalf', array('class' => "form-control s-form-item s-form-all", 'label'=>false,'type' => 'select', 'options' => array('F'=>"FIRST HALF",'S'=>"SECOND HALF"), 'default' => 'F', 'id' =>'ed_half_type_div','style'=>'display:none;')); ?>

                    </div>

  
                  </div> 
                  
                  
                  
                  
                  
                  
                <div class="x_content">
              
               

              </div>
                
                  <div class="ln_solid"></div>
                  
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="submit" class="btn btn-success" value="Save As Draft" onclick="return CheckLeaveCount(); ">  
                      <input type="submit" class="btn btn-danger" value="Send" name='post_leave' onclick="post(); ">
                    </div>
                  </div>
                 
                </form>
              </div>
            </div>
          </div>
        </div>
 <script type="text/javascript" >
   function post()
   {
    document.Form1.action = "postLeaves";
    document.Form1.submit();             // Submit the page
     return true;
     }
     jQuery(document).ready(function() {
        jQuery("#startdate").datepicker({
                //inline: true,
                changeMonth: true,
                autoclose:true,
                //changeYear: true,
                format: 'dd-mm-yy',
                onSelect: function(selected) {
                    jQuery("#enddate").datepicker("option","minDate", selected);
                     var diff = dateDiff(jQuery('#startdate').datepicker("getDate"));
                     jQuery('#enddate').datepicker("getDate");
                     if(jQuery('#enddate').val() != ""){
                                var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                                jQuery('#enddate').datepicker("getDate"));
                        }
                }
        });
        jQuery("#enddate").datepicker({
                inline: true,
                changeMonth: true,
                autoclose:true,
                orientation: "right bottom",
                format: 'dd-mm-yy',
                onSelect: function(selected) {
                    jQuery("#startdate").datepicker("option","maxDate", selected);
                     var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                     jQuery('#enddate').datepicker("getDate"));
                }                  
        });

        jQuery('#enddate').change(function() {
            var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                    jQuery('#enddate').datepicker("getDate"));
            var medical =  jQuery('#leave').val();
            var tot = $('#total_leave').val();
             if(medical === 'PAR0000065' && tot > 2 ){
            jQuery('#leave_image,#image').show();
            
            }

        });
 


        jQuery('#startdate').change(function() {
            if (jQuery('#enddate') != "") {
                var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                        jQuery('#enddate').datepicker("getDate"));
            }

        });
        jQuery('input[name=ch_st_daylength]').change(function(){dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))});
        jQuery('input[name=ch_ed_daylength]').change(function(){dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))});

       /* function calculateDate() {
            dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));
            if (jQuery("#startdate").val() != '' && jQuery("#enddate").val() != '') {
                var ed_date = jQuery('input[name=ch_ed_daylength]:checked').val();
                var st_date = jQuery('input[name=ch_st_daylength]:checked').val();
                if (ed_date == 'H' && st_date != 'H') {
                    jQuery('#total_leave').val(jQuery('#total_leave').val() - 0.5);
                }
                if (st_date == 'H' && ed_date != 'H') {
                    jQuery('#total_leave').val(jQuery('#total_leave').val() - 0.5);
                }
                if (st_date == 'H' && ed_date == 'H') {
                    jQuery('#total_leave').val(jQuery('#total_leave').val() - 1.0);
                }
            }
        }*/

    });
</script>
<script>
    function dateDiff(startDate, endDate) {
  var difdate = 0;
        var difdate1 = 0;
  if (jQuery("#startdate").val() == '' && jQuery("#enddate").val() == '') {
    alert('Please select start date and end date');
    jQuery('#total_leave').val('');
    return false;
  }
        if (endDate && startDate) //make sure we don't call .getTime() on a null
            difdate = (endDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24);
        

        if (jQuery('#enddate').val() != ""){
          difdate1 = difdate + 1;
        }
            
  var ed_date = jQuery("input[name='ch_ed_daylength']:checked").val();
        var st_date = jQuery("input[name='ch_st_daylength']:checked").val();
        if (ed_date == 'H' && st_date != 'H') {
            difdate1 = difdate1 - 0.5;
        }
        if (st_date == 'H' && ed_date != 'H') {
            difdate1 = difdate1 - 0.5;
        }
        if (st_date == 'H' && ed_date == 'H') {
            difdate1 = difdate1 - 1.0;
        }
        jQuery('#vc_date_diff').val(difdate1);
  //alert(difdate1);
        if (difdate < 0) {
            alert('Total Days cannot be less than 0! ');
            jQuery('#total_leave').val('');
            return false;
        } else {
            jQuery('#total_leave').val(difdate1);

        }

        //substract leaves on the basis of holidays
        var all_dates = getDates(startDate, endDate);
        jQuery(all_dates).each(function(e,v) {
          //check holidays
          var holidays = <?php echo json_encode($holidays);?>;
          var dt = v.getFullYear()+'-'+("0" + (v.getMonth() + 1)).slice(-2)+'-'+("0" + v.getDate()).slice(-2);
          var hol = Object.keys(holidays).map(function(k) { return holidays[k] });
          console.log(hol);
          if(jQuery.inArray(dt,hol) !== -1){
            jQuery('#total_leave').val(jQuery('#total_leave').val()-1);
          }
          //check week holidays
          var week_holidays = <?php echo json_encode($week_holidays);?>;
          var dtw = v.getFullYear()+'-'+("0" + (v.getMonth() + 1)).slice(-2)+'-'+("0" + v.getDate()).slice(-2);
          var holw = Object.keys(week_holidays).map(function(k) { return week_holidays[k] });
          console.log(holw);
          if(jQuery.inArray(dtw,holw) !== -1){
            jQuery('#total_leave').val(jQuery('#total_leave').val()-1);
          }
          

        });
    }
    function CheckLeaveCount() 
{  
  var leave_id=jQuery('#leave').val();
  //var leave_id=parseInt(leave);
  //alert(leave_id);
  jQuery("#bal_leave_"+leave_id).text().trim();
  jQuery('#total_leave').val();
  if (jQuery('#total_leave').val() == '') {
            alert("Please Enter Leave Date.!");
            return false;
        } else if (jQuery('#total_leave').val() == 0){
            alert("Please Enter Leave greater then 0.!");
            return false;
        } else if (parseInt(jQuery('#total_leave').val().trim()) > (parseInt(jQuery("#bal_leave_"+leave_id).text().trim())-parseInt(jQuery("#pending_leave_"+leave_id).text().trim()))){
            alert("You can't apply "+ jQuery('#total_leave').val()+" leaves in "+ jQuery('#bal_leave_'+leave_id).text().trim()+" Balance Leaves and "+ jQuery('#pending_leave_'+leave_id).text().trim()+" Pending Leaves.");
            return false;
        } 
    }
</script>
      </div>


          
<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" href="#">×</a>
    <div class="HRcontent"> 
      <div id="container" style="width: 600px; height: 400px; margin: 0 auto"></div>
    </div>    
  </div>
</div>

    <script type="text/javascript">

    </script>
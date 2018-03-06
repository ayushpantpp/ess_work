
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
            <h3>Task Assigning Form</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Task Form</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
              <?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'ftaskassign','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));
                ?>
 
                <?php //$auth=$this->Session->read('Auth');?>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Task ID:<span class="required">*</span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <?php echo $this->form->input('tid', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'value'=>$asd,'type' => 'text', 'id' =>'tid', 'required'=>true, 'readonly'=>TRUE)); ?>
                    </div>
                  </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Task Name:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                     <?php echo $this->form->input('tname', array('label'=>false, 'type' => 'text', 'class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'tname')); ?>   
                    </div>
                 </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Task Priority:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <?php echo $this->form->input('tpriority', array('label'=>false, 'type' => 'select', 'value' => '',
                        'options' => array('' => 'Select Priority', '0' => 'Very High','1' => 'High','2' => 'Medium','3' => 'Low'),
                        'class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'tpriority')); ?>
                    </div>
                 </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Project Name:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?php echo $this->form->input('pname', array('label'=>false, 'type' => 'select',
                        'options' => array('' => 'Select Project',$ar),
                        'value' => '','class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'pname', 'onChange'=>'getmodule(this.value)')); ?>
                        
                    </div>
                 </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Assign Date(d/m/y)<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                     <?php echo $this->form->input('dt_start_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",
                                   'type' => 'text', 'id' => 'startdate','placeholder'=>'Click here to Select Assign Date','readonly'=>true, 'required'=>true)); ?>
                    </div>
                  </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Employee Name <span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <select multiple class="form-control tickerWidth" name="ticker[]" id="ticker" style="width: 190px" required="true" >
                            
                    <?php foreach($employee_name as $k=>$val){ ?>
                    <option  value='<?php echo $k ?>'> <?php foreach($employee_name as $t=>$value){if($value == $k ) echo 'selected';} ?> <?php echo $val ?></option>
                    <?php } ?>
                   </select>
                    </div>
                  </div>
                  
                  <div class="clearfix"></div>
                  
                  
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12"  >
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Target Date(d/m/y)<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <?php echo $this->form->input('dt_end_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12",
                                       'type' => 'text', 'id' => 'enddate','placeholder'=>'Click here to Select Target Date', 'readonly'=>true, 'required'=>true)); ?>
                    </div>
                  </div>
                 
                  
                  
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Remark<span></span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    
                      <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"form-control", 'style'=>"width: 186px; height: 50px;")); ?>
                    </div>
                  </div>
                  <div class="clearfix"></div>
<!--                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Employee:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <?php //echo $this->form->input('tpriority', array('label'=>false, 'type' => 'select', 'value' => '',
                        //'options' => array('' => 'Select Employee', '0' => 'Raj','1' => 'Anuj','2' => 'Sandeep','3' => 'Sonu'),
                        //'class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'tpriority')); ?>
                    </div>
                 </div>-->
                                  
                 <div class="ln_solid"></div>
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12">
<!--                        <input type="button" class="btn btn-success" value="Save As Draft" >  -->
                        <input type="submit" class="btn btn-success" value="Send" name='b1' id="b1" onclick= " return post1();" />
                    <input type="hidden" id="h1" name="h1"/>
                    <input type="hidden" id="h2" name="h2"/>
                    <input type="hidden" id="h3" name="h3"/>
                    </div>
                  </div>
                  
                 
                 <?php echo $this->form->end(); ?>
              </div>
            </div>
          </div>
        </div>
<script>
      
function getmodule(val) {
    //alert("--PROJECT ID--"+val);
    $.ajax({
    type: "POST",
    url: '<?php echo $this->webroot ?>tasks/module/'+val,
        
    //data:'project_id='+val,
    success: function(data){
                 //alert(data);
        $("#mname").html(data);
    }
    });
}
</script>
        
        
<script type="text/javascript" >
   
  function post1()
   {
         
       if(document.getElementById("startdate").value== '')
       {
          document.getElementById("startdate").focus();
          return false;
       }
       if(document.getElementById("enddate").value== '')
       {
          document.getElementById("enddate").focus();
          return false;
       }
       var tp = document.getElementById("tpriority");
        var tpval = tp.options[tp.selectedIndex].text;
        document.getElementById("h1").value= tpval;
        
        
        var prname = document.getElementById("pname");
        var prnameval = prname.options[prname.selectedIndex].text;
        document.getElementById("h2").value= prnameval;
        
        var mdname = document.getElementById("mname");
        var mdnameval = mdname.options[mdname.selectedIndex].text;
        document.getElementById("h3").value= mdnameval;
        
        
        document.forms["task"].submit();
      
   }
    
      
</script>
<script type="text/javascript" >
   function post()
   {
  //  document.Form1.action = "postLeaves";
   // document.Form1.submit();             // Submit the page
   //  return true;
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
    
</script>
 
 
      </div>
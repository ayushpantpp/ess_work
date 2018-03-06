<?php

App::import('Model', 'General');
$General = new General ;
App::import('Component', 'Functions');
// We need to load the class
 $Function = new FunctionsComponent();
?>

<script type="text/javascript">


function saveTimesheet(index){
	var data=ajaxObjects[index].response;

	if(data=='1'){
		document.getElementById('add_button').disabled=true;
		document.getElementById('remove_button').disabled=true;
		document.getElementById('SaveTS').disabled=true;
		document.lveForm.method="POST";
		document.lveForm.action="save-info.php";
		document.lveForm.submit();
	}else{
		
		document.getElementById('error_div').style.color = 'red';
		document.getElementById('error_div').innerHTML=data;
		return false;
	}
}

	      function CheckLeave(val,rowid){
   
        if(val=='Y'){
              if (jQuery('#stTime'+rowid).attr("disabled") == true){
                        jQuery('#stDate'+rowid).removeAttr('readonly');
                        jQuery('#stTime'+rowid).removeAttr('disabled');
                        jQuery('#edTime'+rowid).removeAttr('disabled');
                        jQuery('#hrs'+rowid).removeAttr('disabled');
                        jQuery('#module'+rowid).removeAttr('disabled');
                        jQuery('#remarks'+rowid).removeAttr('disabled');
                        jQuery('#pname'+rowid).removeAttr('disabled');
                        jQuery('#fr'+rowid).removeAttr('disabled');
              }else{
                         jQuery('#stDate'+rowid).attr('readonly', 'true')
                         jQuery('#stTime'+rowid).attr('disabled', 'true');
                         jQuery('#edTime'+rowid).attr('disabled', 'true');
                         jQuery('#hrs'+rowid).attr('disabled', 'true');
                         jQuery('#module'+rowid).attr('disabled', 'true');
                         jQuery('#remarks'+rowid).attr('disabled', 'true');
                         jQuery('#pname'+rowid).attr('disabled', 'true');
                         jQuery('#fr'+rowid).attr('disabled', 'true');

                         var hrs =jQuery('#hrs'+rowid).val();
                         hrs=Convert(hrs , false);
                         var tothrs=jQuery('#tothr').val();
                         tothrs=Convert(tothrs , false);
                         
                          var diff=parseFloat(tothrs-hrs);

                          var totHour =Convert(diff , true);
                        var tothrs=jQuery('#tothr').val(totHour);
                         jQuery('#edTime'+rowid).val('00:00')
                         jQuery('#stTime'+rowid).val('00:00');
                         jQuery('#hrs'+rowid).val('00:00');

             }
      }
         
     }

</script>
<script type='text/javascript'>
window.onload = function()
{
  taInit();
}
// initialize all textareas
function taInit()
{
    var ta1=document.documentElement. getElementsByTagName("*")['diw'];
    var i;
    var ta = document.getElementsByTagName('textarea');
 //   alert(ta.length);
          for (i = 0; i < ta.length; ++i)
          { 
            ta[i]._ta_default_rows_ = ta[i].rows;
            ta[i]._ta_default_cols_ = ta[i].cols;
            ta[i].onkeyup = taExpand;
            ta[i].onmouseover = taExpand;
            ta[i].onmouseout = taRestore;
            ta[i].onfocus = taOnFocus;
            ta[i].onblur = taOnBlur;
          }
}
function taOnFocus(e)
{
  this._ta_is_focused_ = true;
  this.onmouseover();
}
function taOnBlur()
{
  this._ta_is_focused_ = false;
  this.onmouseout();
}
// set to default size if not focused
function taRestore()
{
  if (!this._ta_is_focused_)
  {
    this.rows = this._ta_default_rows_;
 
    this.cols = this._ta_default_cols_;
  }
}
// adjust rows and cols to fit text
function taExpand()
{
  var a, i, c = 0;
  a = this.value.split('\n');
  for (i = 0; i < a.length; i++) {
    if (a[i].length > c) c = a[i].length;
  }
  this.cols = 30;
  this.rows = 10;
}
</script>

<script type='text/javascript'>
function SetDate(url){
        jQuery.ajax({
        url: '<?php echo $this->webroot."Timesheet/functions"?>',
        data: url,
        success: function(data){
        var DateSetter=data.split(';;');
        jQuery('#wstDate').val(DateSetter[0]);
	jQuery('#wedDate').val(DateSetter[1]);
        var arrDateSetter =DateSetter[2].split('||');
        for(i=1;i<=document.lveForm.tot_ctrl.value;i++){
	    jQuery('#weekCombo'+i).html(arrDateSetter[i-1]);
	}
        }
    });
}
function SetYearDate(url){
        jQuery.ajax({
        url: '<?php echo $this->webroot."Timesheet/functions"?>',
        data: url,
        success: function(data){
	var DateSetter=data.split(';;');
        jQuery('#YearWeeks').html(DateSetter[0]);
	jQuery('#wstDate').val(DateSetter[1]);
	jQuery('#wedDate').val(DateSetter[2]);
        for(i=1;i<=document.lveForm.tot_ctrl.value;i++){
	    jQuery('#weekCombo'+i).html(DateSetter[3]);
	}
        }
    });
}

function getTimesheetForm(div){
         var totaldirector=document.getElementById("addtimesheetrow").value;
	
	 var totalrowfound=parseInt(totaldirector)+parseInt(1);
         document.getElementById("addnewrow").value=totaldirector;
	 var url = '<?php echo $this->webroot; ?>Timesheet/timesheetrow/'+totalrowfound;
	  jQuery.get(url, function(data) {
          jQuery("#"+div).append(data);

        });

  }


function CheckPreviousRow(obj,divid,customer_code){
      var id = (obj.tot_ctrl.value-1);
      var totalrow=jQuery("#addtimesheetrow").val();
      var userEndTime=Convert(document.getElementById('edTime'+id).value , false);
      var stdEndTime =Convert('17:30' , false);
      if(userEndTime !="0"){
		if(userEndTime < stdEndTime){
			NextStartTime = document.getElementById('edTime'+id).value;
			NextEndTime = '17:30';
			Flag=0;
		}else{
			NextStartTime = '00:00';
			NextEndTime = '00:00';
			Flag=1;
		}
	}else{
		NextStartTime = '00:00';
		NextEndTime = '00:00';
		Flag=1;
	}
	var RowTotTime =parseFloat(Convert(NextEndTime , false) - Convert(NextStartTime , false));
        RowTotTime = Convert(RowTotTime , true);
 	NextDate =document.getElementById('stDate'+id).value;
	AddControl(obj,NextStartTime,NextEndTime,NextDate,Flag,RowTotTime,divid,totalrow,customer_code,id);
	//TS(obj , NextStartTime , NextEndTime , NextDate , Flag , RowTotTime);
}


function AddControl(obj,NextStartTime,NextEndTime,NextDate,Flag,RowTotTime,divid,totalrow,customer_code,id){
       var str='';
  	var Max_Control=150;
	var tot_ctrl = obj.tot_ctrl.value;
       if(tot_ctrl < Max_Control){
	   var i=parseInt(tot_ctrl);
	   var j=(i+1);
                var weekNumber=document.lveForm.sDate.value.split('-');
                var totalrowfound= parseInt(totalrow) + parseInt(1);
                document.getElementById("addtimesheetrow").value=totalrowfound;
	        var url = 'timesheetrow/'+totalrowfound;
                document.getElementById("add_button").disabled=true;
	        jQuery.get(url, function(data) {
                jQuery("#"+divid).append(data);
			obj.tot_ctrl.value = parseInt(obj.tot_ctrl.value) + 1 ;
			if(obj.tot_ctrl.value==Max_Control){
				document.getElementById("add_button").disabled=true;
				document.getElementById("remove_button").disabled=false;
			}else{
				document.getElementById("remove_button").disabled=false;
			}
                        //alert(weekNumber[1]);
                        SetCustomer(customer_code,j);
                         if(weekNumber[1]!=''){
                            SetRowCombo(weekNumber[1],i,NextDate,Flag);
                        }
                        // TotalTimeCalulate();
                        //calculated remain hours;
                        var add=parseInt(id+1);
 
                    if(RowTotTime!='00:00'){
                        document.getElementById("stTime"+add).value=NextStartTime;
                        document.getElementById("edTime"+add).value=NextEndTime;
                        document.getElementById("hrs"+add).value=RowTotTime;
                       CheckTime(document.getElementById("hrs"+add).value , '0' ,"hrs"+add)

                    }

                        document.getElementById("add_button").disabled=false;
                        taInit();
              });

                        //if(tot_ctrl <= Max_Control)

			//TotalTimeCalulate();
	}
}
function SetCustomer(cust_id,row_id){
	if(cust_id !=''){
        		var Control_Number = document.lveForm.tot_ctrl.value;
                var url='task=SetCust&cust_id='+cust_id+'&Control_Number='+row_id;
                 jQuery.ajax({
                 url: '<?php echo $this->webroot."Timesheet/functions"?>',
                 data: url,
                 success: function(data){
                         jQuery('#M'+row_id+" select[name^=milestone]").html(data);
             	}
           });
        }
}

function SetRowCombo(val,Control_Number,NextDate,Flag){
var Control_Number = document.lveForm.tot_ctrl.value;
var url='task=WeekCombo&WeekNumber='+val+'&Control_Number='+Control_Number+'&previousSet='+NextDate+'&Flag='+Flag;
                 jQuery.ajax({
                 url: '<?php echo $this->webroot."Timesheet/functions"?>',
                 data: url,
                 success: function(data){
                          jQuery('#weekCombo'+Control_Number).html(data);
             	}

        });
}
</script>


<!-- Center Content Starts -->
<?php //echo $customer_code; ?>
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>

              <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
              <li><?php echo $html->link(' Timesheet', $html->url('/selfservices/#timesheet', true)); ?> </li>
              <li>Weekly TimeSheet </li>



        </ul>
    </div>
</div>

<h2 class="demoheaders">Normal Form </h2>
<form name="lveForm" autocomplete="off">
    <div class="travel-voucher">
 <div class="input-boxs">
 
 <table width="100%" border="0" cellspacing="5" cellpadding="5">
     <tr>
			<td colspan='10' align='center' nowrap="nowrap" id='error_div'></td>
    </tr>
  <tr>
    <th scope="row">Region :</th>
    <td><?php echo $region;?>
    <input type="hidden" name ="region" value="<?php echo $region_code?>"></td>
		
    </tr>
    <th scope="row">Customer :</th>
    <td><?php echo $customer;?></td>
    <input type="hidden" name ="customer_id" value="<?php echo $customer_code;?>">
     <th scope="row">Employee Name :</th>
    <td><?php echo $rsEmp[0][0]['vc_emp_name']; ?>
    <input type="hidden" name ="customer_name" value="<?php echo $customer?>">
    </td>
     <th scope="row">Employee ID :</th>
     <?php $employ_id=$rsEmp[0][0]['vc_emp_id']; ?>
    <td><?php echo $rsEmp[0][0]['vc_emp_id']; ?></td>
     <input type="hidden" name ="empid" value="<?php echo $employ_id;?>">
  </tr>

 <?php
         $con=$Function->connRet();
         $arrWeek=$Function->SQLYearWeek($con);
        $currentWeekStart =$arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_DMY']; 
        $currentWeekEnd=$arrWeek['CUR_YEAR_CUR_WEEK_END_DATE_DMY'];
  ?>
 <!-- hidden for start date -->
 <tr>
    <th scope="row">Year :</th> 
    <td><?php $sel_year=$Function->YearSelectList(); $sel_year ?></td>
    <th scope="row" >Week Start Date :</th>
    <td id="YearWeeks"><?php echo $Function->YearWeeksCombo($arrWeek['YEAR_FIRST_WK_START_DATE_RRRR'] ,$arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_RRRR'] );	?>
    </td>
    <th scope="row">Week End Date :</th>
    <input name="wstDate" type="hidden" id="wstDate"  value="<?php echo $currentWeekStart?>" size="10" maxlength="20"  readonly>
    <td><input class='textBox' name="wedDate" type="text" id="wedDate" value="<?php echo $currentWeekEnd?>" size="10" maxlength="20"  readonly></td>
    <th scope="row"></th>
  </tr>
</table>
</div>
</div>
<div style="text-align:right;">* Under Pilot: not mandatory</div>
<div class="travel-voucher1">
<div class="input-boxs-timesheet">
<div>
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
  <tr class="head">
    <th scope="row" width="15%">Activity/Milestone</th>
    <th scope="row">TMS ID*</th>
    <th width="12%">Date</th>
	<th>Leave</th>
    <th>Start Time</th>
    <th>End Time</th>
    <th>Hours</th>
    <th>Module</th>
    <th>Remarks</th>
    <th>Program Name</th>
    <th>Forms/Reports</th>
    <th>MMPID*</th>
  </tr>


        <input type="hidden" name ="tot_ctrl" value="1" id="Control_Number">
        <input type="hidden" name ="posted" value="1" id="posted">
        <input type="hidden" name ="task" value="Add TimeSheet" id="addTS">
        <input type="hidden" name ="addtimesheetrow" id="addtimesheetrow" value="1">
        <input type="hidden" name ="addnewrow" id="addnewrow" value="">
        <input type="hidden" name ="employee" value="<?php echo $employ_id;?>">


  <tr class="cont1">
        <td valign="top"  id='M1'> 
          
           <?php $projects=$Function->TSMilestone($customer_code, 'name="milestone0" style="width:120px;"');
                  echo $projects; 
            ?></td >
        <?php //echo strtotime($arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_RRRR']); die;?>
	<td><input type="text" style="width:70px;" name="subproject0" id="subproject0"   class="textBox" /></td>
        <td  id='weekCombo1'><?php  $weekdate=$Function->WeeklySingleCombo(strtotime($arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_RRRR']),'1');
                 echo $weekdate; 
        ?></td>
		    <td><input type="checkbox" style="width:20px;" name="leave0" id="leave0"   class="textBox" value="Y" onClick="CheckLeave(this.value,'0')" /></td>

        <td><input type="text" style="width:50px;" name="stTime0" id="stTime0" value="00:00" maxlength="5" class="textBox" onBlur="IsValidTime(this.value , this.id);"/></td>
        <td><input type="text" style="width:50px;" name="edTime0" id="edTime0" value="00:00" maxlength="5" onBlur="CheckTime(this.value , '0' ,this.id)"/></td>
        <td><input type="text" style="width:50px;" name="hrs0"  id="hrs0"  value="00:00" readonly/></td>
           <td><input type="text" style="width:40px;" name="module0"  id="module0" /></td>
       
        <td><textarea rows='0' cols='10' name="remarks0" id="remarks0"></textarea></td>
        <td><textarea cols="10" name="pname0" id="pname0"> </textarea></td>
        <td><input type="text" style="width:50px;" name="fr0" type="text" id="fr0"/></td>
       <td><input type="text" style="width:50px;" name="mmpid0" type="text" id="mmpid0"/></td>
</tr>

<tr>
    <td colspan="12" style="padding:0px;">
   <div id="add_ctrl"></div>
    </td>
</tr>
</table>
</div>
</div>
</div>
	  <div class="submit">
                <input type="button" id="add_button" name="Add2" value="Add More" onClick="CheckPreviousRow(this.form,'add_ctrl',<?php echo $customer_code; ?>);" style="margin-right:5px;" />
                <input type="button" value="Save" id="SaveTS" style="margin-right:5px;" name="sheet_status" onClick="check(this.form, this.name , <?php echo $this->webroot;?>, <?php echo $employ_id; ?> );"/>
                <input type="button" value="Remove" style="margin-right:5px;" id="remove_button" onClick="RemoveControl(this.form)" disabled="disabled"/>
          </div>
    
	
	<div class="travel-voucher">

<div class="input-boxs">

<table width="100%" cellspacing="5" cellpadding="5" border="0">
  <tbody><tr>
    <td colspan="6" align="left"><div class="weekly-heading">Weekly Summary :</div></td>
   </tr>
  <tr>
    <th scope="row"><strong>Total Hours:</strong>  :</th>
    <td><input type="text" style="width:50px;"  name="tothr" type="text" id="tothr" readonly value="00:00" /></td>
    <th scope="row"><strong>Total Forms</strong>  :</th>
    <td><input type="text" style="width:50px;"  name="totfr" type="text" id="totfr" value="0"/> </td>
     <th scope="row"><strong>Total Reports</strong>  :</th>
    <td><input type="text" style="width:50px;"  name="totrep" type="text" id="totrep" value="0"/></td>
  
  </tr>
    
</tbody></table> 

          </div>
       </div>
    
</form>
<!-- Center Content Ends -->

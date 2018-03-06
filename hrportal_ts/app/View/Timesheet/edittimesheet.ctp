<?php
App::import('Model', 'General');
$General = new General;
App::import('Component', 'Functions');
// We need to load the class
$Function = new FunctionsComponent();
?>

<script type="text/javascript">
    $(function(){

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            modal:true,
            buttons: {
                "Ok": function() {
                    var cmnt=$('#cmnt').val();

                    if(cmnt==' ')
                    {     $('#errdis').show('slow', function() {
                            	 var cmnt=$('#cmnt').val();

                                                        if(cmnt==' ')
                                                       {
                                                             $('#errdis').show('medium', function() {
                                                               // Animation complete.
                                                              });
                                                            return false;
				                    }else{
         		                          	     $(this).dialog("close");
                                                            document.trvoucher.submit();
                                                          }
                            // Animation complete.
                        });
                        return false;

                    }else{
                        $(this).dialog("close");
                        document.getElementById("rej").value='Reject';
                          document.lveForm.action='<?php echo $this->webroot; ?>Timesheet/rejecttimesheet';
                          document.lveForm.submit();
                    }

                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });


    });

</script>

<script type='text/javascript'>
    //end
    window.onload = function()
    {
        taInit();
    }
    // initialize all textareas
    function taInit()
    {   var ta1=document.documentElement. getElementsByTagName("*")['diw'];
        var i, ta = document.getElementsByTagName('textarea');
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
<?php //a.length ?>
<script type='text/javascript'>
    function SetDate(url){
        jQuery.ajax({
            url: '<?php echo $this->webroot . "Timesheet/functions" ?>',
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
            url: '<?php echo $this->webroot . "Timesheet/functions" ?>',
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

    function CheckPreviousRow1(obj,divid,customer_code){
        var id = parseInt(obj.tot_ctrl.value)-1;
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
        AddControl(obj,NextStartTime,NextEndTime,NextDate,Flag,RowTotTime,divid,totalrow,customer_code);
        //TS(obj , NextStartTime , NextEndTime , NextDate , Flag , RowTotTime);
    }


    function AddControl(obj,NextStartTime,NextEndTime,NextDate,Flag,RowTotTime,divid,totalrow,customer_code){
        var str='';
        var Max_Control=150;
        var tot_ctrl = obj.tot_ctrl.value;
        if(tot_ctrl < Max_Control){
            var i=parseInt(tot_ctrl);
            var j=(i+1);

            var weekNumber=document.lveForm.sDate.value.split('-');
            var totalrowfound= parseInt(totalrow) + parseInt(1);
         
            document.getElementById("addtimesheetrow").value=totalrowfound;
            var url = '<?php echo $this->webroot; ?>/Timesheet/timesheetrow/'+totalrowfound;
            jQuery.get(url, function(data) {
                jQuery("#"+divid).append(data);
                obj.tot_ctrl.value = parseInt(obj.tot_ctrl.value) + 1 ;
                if(obj.tot_ctrl.value==Max_Control){
                    document.getElementById("add_button").disabled=true;
                    document.getElementById("remove_button").disabled=false;
                }else{
                    document.getElementById("remove_button").disabled=false;
                }
       
                SetCustomer(<?php echo $customer_id;?>,j);
            
                if(weekNumber!=''){
                    SetRowCombo(weekNumber, i , NextDate, Flag);
                }
                 document.getElementById("add_button").disabled=false;
            });
            if(tot_ctrl <= Max_Control)

            TotalTimeCalulate();
    }
}
function SetCustomer(cust_id,row_id){



    if(cust_id !=''){
        var Control_Number = document.lveForm.tot_ctrl.value;
        var url='task=SetCust&cust_id='+cust_id+'&Control_Number='+row_id;
        jQuery.ajax({
            url: '<?php echo $this->webroot . "Timesheet/functions" ?>',
            data: url,
            success: function(data){
                   jQuery('#M'+row_id+" select[name^=milestone]").html(data);
            }
        });
    }
}



function SetRowCombo(val, Control_Number, NextDate, Flag){
     
    var Control_Number = document.lveForm.tot_ctrl.value;
    var url='task=WeekCombo&WeekNumber='+val+'&Control_Number='+Control_Number+'&previousSet='+NextDate+'&Flag='+Flag;
    jQuery.ajax({
        url: '<?php echo $this->webroot . "Timesheet/functions" ?>',
        data: url,
        success: function(data){
            jQuery('#weekCombo'+Control_Number).html(data);
        }

    });
}


  function CheckLeave(val,rowid){
      if(val=='Y'){
         disablebox(val,rowid);
      }else {
          disablebox(val,rowid);
      }

     }

     function disablebox(val,rowid){
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
</script>

<!-- Center Content Starts -->
<?php $read0nly = ($empdetail[4] == "milestone") ? 'readonly="readonly"' : ''; ?>
<?php $weekNumber = strtotime($rows['START_DATE_RRRR'][0]);
?>

<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li> <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a> </li>
          <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li><?php echo $html->link(' Timesheet', $html->url('/selfservices/#timesheet', true)); ?> </li>
            <li>Weekly TimeSheet </li>
        </ul>
    </div>
</div>

<h2 class="demoheaders">Edit Normal Form </h2>
<form name="lveForm" action="" method="post" autocomplete="off">

         <div class="travel-voucher">
            <div class="input-boxs">
                <input type="hidden" name ="tot_ctrl" value="<?php echo $numTsRec ?>" id="Control_Number">
                <input type="hidden" name ="posted" value="1" id="posted">
                <input type="hidden" name ="task" value="Update TimeSheet" id="updateTS">
                <input type="hidden" name ="customer" value="<?php // echo $rows['CUSTOMER'][0];   ?>">
                <input type="hidden" name ="addtimesheetrow" id="addtimesheetrow" value="<?php if ($numTsRec != '') {
                 echo $numTsRec;
} else {
    echo '1';
} ?>">

                <input type="hidden" name ="flag" value="<?php echo $flag; ?>">

                <table width="100%" border="0" cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan='10' align='center' nowrap="nowrap" id='error_div'></td>
                    </tr>
                    <tr>
                        <th scope="row">Region :</th>
                        <td><?php echo $rows['REGION'][0] ?>
                            <input type="hidden" name ="region" value="<?php echo $rows['RCODE'][0] ?>">
                            <input type="hidden" name ="sno" value="<?php echo $rows['SNO'][0] ?>">
                            <input type="hidden" name ="is_manager" id="is_manager" value="0">
                             <input type="hidden" id="rejectres" name="rejectreson" value=""/>
                             <input type="hidden" id="rej" name="rej" value=""/>
                        </td>
                        <th scope="row">Customer :</th>
                        <td><?php echo $customer_name; ?>
                            <input type="hidden" name ="customer_id" value="<?php echo $customer_id;   ?>">
                         <input type="hidden" name ="customer_name" value="<?php echo $customer_name;   ?>">
                        </td>

                        <th scope="row">Employee Name :</th>
                        <td><?php echo $rows['EMP_NAME']['0'] ?>
                            <input type="hidden" name ="employee" value="<?php echo $empdetail[1]; ?>">
                        </td>
                        <th scope="row">Employee ID :</th>
<?php //pr($empdetail);   ?>
                        <td><?php echo $empdetail[1]; ?><input name="empid" type="hidden" id="empid" value="<?php echo $empdetail[1]; ?>"size="4"></td>

                    </tr>

                    <?php
                    $con = $Function->connRet();
                    $arrWeek = $Function->SQLYearWeek($con);
                    $currentWeekStart = $arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_DMY'];
                    $currentWeekEnd = $arrWeek['CUR_YEAR_CUR_WEEK_END_DATE_DMY'];
                    ?>
                    <!-- hidden for start date -->

                    <tr>
                        <th scope="row" >Week Start Date :</th>
                        <td id="YearWeeks"><?php echo $rows['START_DATE'][0] ?><input name="sDate" type="hidden" id="sDate"  value="<?php echo $weekNumber ?>" size="10" maxlength="20"  readonly>
                        </td>
                        <th scope="row">Week End Date :</th>
                        <td> <?php echo $rows['END_DATE'][0] ?><input name="wstDate" type="hidden" id="wstDate"  value="<?php echo $rows['START_DATE'][0] ?>" size="10" maxlength="20"  readonly>&nbsp;
                            <input name="wedDate" type="hidden" id="wedDate"   value="<?php echo $rows['END_DATE'][0] ?>" size="10" maxlength="20"  readonly></td>
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
			    <th scope="row" width="15%">TMS ID*</th>
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

<?php for ($x = 0; $x < $numTsRec; $x++) { ?>
                        <tr class="cont1">
                
                            <td   id='M<?php echo $x; ?>'>
                            <?php echo $Function->TSMilestone($rwTsRec['NU_CUSTOMER_NO'][$x], 'name="milestone'.($x).'" $read0nly style="width:120px;"' , $rwTsRec['VC_MILESTONE_ID'][$x]); ?></td >
			    <td>
				<!--<input type="text" style="width:70px;" name="subproject<?php echo $x; ?>" value="<?php echo $rwTsRec['VC_SUBPROJECT'][$x] ?>" id="subproject<?php echo $fieldid; ?>"   class="textBox" />-->
				<input type="text" style="width:70px;" name="subproject<?php echo $x; ?>" value="<?php echo $rwTsRec['VC_SUBPROJECT'][$x] ?>" id="subproject<?php echo $x; ?>"   class="textBox" />
				</td>
                               <td width="12%" valign="top" id='customer<?php echo $x ?>'><?php echo $Function->WeeklySingleCombo($weekNumber, $x + 1, $rwTsRec['WK_DATE'][$x]); ?>

                                
								 <td><input type="checkbox" name="leave<?php echo $x ?>" id="leave<?php echo $x ?>" value="Y"<?php if(!empty($rwTsRec['VC_LEAVE'][$x])){ echo "CHECKED";  } ?> <?php echo $read0nly ?>"  class="textBox"  onClick="CheckLeave(this.value,<?php echo $x;?>)"><br/>                             </td>
								
								<td><input type="text" name="stTime<?php echo $x ?>" id="stTime<?php echo $x ?>" value="<?php echo $rwTsRec['VC_STRT_TIME'][$x] ?>" size="5" maxlength="5" <?php echo $read0nly ?>  class="textBox" onBlur="IsValidTime(this.value , this.id);"><br</td>

                                <td><input class="textBox"type="text" name="edTime<?php echo $x ?>" id="edTime<?php echo $x ?>" value="<?php echo $rwTsRec['VC_END_TIME'][$x] ?>" size="5" <?php echo $read0nly ?>  maxlength="5" onBlur="CheckTime(this.value , '<?php echo $x ?>' ,this.id)"></td>
                                <td><input class="textBox" name="hrs<?php echo $x ?>" type="text" id="hrs<?php echo $x ?>"  value="<?php echo $rwTsRec['VC_HRS'][$x] ?>" size="5"  readonly></td>
                                <td><input type="text" style="width:40px;" name="module<?php echo $x ?>"  id="module<?php echo $x ?>" <?php echo $read0nly ?> value="<?php echo $rwTsRec['VC_MODULE'][$x] ?>"/></td>

                                <td><textarea rows='0' cols='10' name="remarks<?php echo $x ?>" id="remarks<?php echo $x ?>" <?php echo $read0nly ?>><?php echo $rwTsRec['VC_REMARKS'][$x] ?></textarea></td>
                                <td><textarea cols="10" name="pname<?php echo $x ?>" id="pname<?php echo $x ?>" <?php echo $read0nly ?>><?php echo $rwTsRec['VC_FILE_NAME'][$x] ?> </textarea></td>
                                <td><input <?php echo $read0nly ?>  class="textBox" name="fr<?php echo $x ?>" type="text" id="fr<?php echo $x ?>" size="10" value="<?php echo $rwTsRec['VC_F_R'][$x] ?>"  style="width:50px;"></td>
                                <td><input <?php echo $read0nly ?>  class="textBox" name="mmpid<?php echo $x ?>" type="text" id="fr<?php echo $x ?>" size="10" value="<?php echo $rwTsRec['VC_MMPID'][$x] ?>"  style="width:50px;"></td>
									
			   	<?php if(!empty($rwTsRec['VC_LEAVE'][$x])){?>
								  <script type="text/javascript" >
									jQuery('#stDate'+<?php echo $x ?>).attr('readonly', 'true')
									 jQuery('#stTime'+<?php echo $x ?>).attr('disabled', 'true');
									 jQuery('#edTime'+<?php echo $x ?>).attr('disabled', 'true');
									 jQuery('#hrs'+<?php echo $x ?>).attr('disabled', 'true');
									 jQuery('#module'+<?php echo $x ?>).attr('disabled', 'true');
									 jQuery('#remarks'+<?php echo $x ?>).attr('disabled', 'true');
									 jQuery('#pname'+<?php echo $x ?>).attr('disabled', 'true');
									 jQuery('#fr'+<?php echo $x ?>).attr('disabled', 'true');
									 jQuery('#edTime'+<?php echo $x ?>).val('00:00')
									 jQuery('#stTime'+<?php echo $x ?>).val('00:00');
									 jQuery('#hrs'+<?php echo $x ?>).val('00:00');
									 </script>

		<?php } ?>

                             <?php if($manager == 'manager'){?>
								  <script type="text/javascript" >
                                                 jQuery('#leave'+<?php echo $x ?>).attr('disabled', 'true')
                                                                       </script>
                           <?php }?>

                            </tr>
<?php } ?>

                        <tr>
                            <td colspan="10" style="padding:0px;">
                                <div id="add_ctrl"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="submit">

<?php if (($manager != 'manager') && ($flag != 'milestone')) { ?>
                    <input type="button" id="add_button" name="Add2" value="Add More" onClick="CheckPreviousRow1(this.form,'add_ctrl','1'); taInit();" style="margin-right:5px;" />
                    <input type="button" value="Remove" style="margin-right:5px;" id="remove_button" onClick="RemoveControl(this.form)" disabled="disabled"/>
<?php } ?>
            <?php if ($manager != 'manager') {
 ?>
                                <input name="sheet_status_save" type="button" class="taskbutton" value="Save Changes" id="SaveChanges" onClick="checkcon1(this.form, this.name , '0');">


            <?php if ($flag != 'milestone') {
 ?>
                                    <input name="sheet_status_manager" type="button" id="manager"value="Submit To Manager"  onClick="checkcon1(this.form,this.name, '1');">
<?php } ?>
                    
<?php } else { ?>
                    <input name="sheet_status_manager" type="button" class="taskbutton" value="Approved" id="Approved"  onClick="checkcon1(this.form,this.name, '2');">
                    <input name="Reject" id="reject" type="button" class="taskbutton" value="Reject"  onclick="return reject1('<?php echo $sno;?>','<?php echo $empdetail[1]?>')"/>
<?php } ?>
                        </div>
                        <div class="submit">
                            <input type="button" value="Back"  id="back_button" onClick="javascript:history.back(-1);" style="margin-right:5px;"/>
                        </div>


                        <div class="travel-voucher">

                            <div class="input-boxs">

                                <table width="100%" cellspacing="5" cellpadding="5" border="0">
                                    <tbody><tr>
                                            <td colspan="6" align="left"><div class="weekly-heading">Weekly Summary :</div></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><strong>Total Hours:</strong>  :</th>
                                            <td><input class='textBox' name="tothr" type="text" id="tothr"  value="<?php echo $rows['TOTHRS'][0]; ?>" size="8" readonly></td>
                                            <th scope="row"><strong>Total Forms</strong>  :</th>
                                            <td><td colspan="9"><input class='textBox' name="totfr" type="text" id="totfr" value="<?php echo $rows['TOTFRM'][0]; ?>" size="8"></td>
                                            <th scope="row"><strong>Total Reports</strong>  :</th>
                                            <td><input class='textBox'  name="totrep" type="text" id="totrep" value="<?php echo $rows['TOTREP'][0]; ?>" size="8"></td>

                                        </tr>

                                </table>
 <div id="dialog" title="Remark/Comment" style="display:none">
                         <div>
                            <textarea  name="reject_reson" id="cmnt" col="100" row="100" style="width: 550px; height:200px;" onKeypress="getcmtval()" > </textarea>
                            <div class="ui-widget" id="errdis" style="display:none">
                                <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
                                    <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                        <strong></strong> Please write rejection reason.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                            </div>
                        </div>
                   
                </form>


                <!-- SET AUTO SUGGESTION -->
                <script type="text/javascript">
                               //check form validation
                var ts_rec=1;
                function checkcon1(formname, submitbutton, mode) {
		    formname.tot_ctrl.value = jQuery('select[name^=milestone]').length;
        	    var errors_stdate = '',steddate='',errors_eddate='',errors_stime='',errors_etime='',errors_md='',errors_rem='',errors_pname='',errors_frm='',fname='';
                    fname=formname.name;
                    var tot_ctrl = formname.tot_ctrl.value;
                    var errorfinal='';
                    var k=0;
                    var i=parseInt(tot_ctrl);
                    steddate= checkText(fname, 'wstDate', 'Week StartDate');
                    steddate +=checkText(fname, 'wedDate', 'Week EndDate');
                    checkThisForm(fname, submitbutton, steddate);
                    var m=0;
                    for(;k<i;k++){
                        m=k+1;
                          if(document.getElementById('remarks'+k).disabled==false){
                               errors_rem += checkText(fname, 'remarks'+k, 'Remarks'+m);
                             //  if(document.getElementById('stTime'+k).value=='00:00' || document.getElementById('stTime'+k).value=='' || document.getElementById('edTime'+k).value=='' || document.getElementById('edTime'+k).value=='00:00' ||document.getElementById('hrs'+k).value=='00:00' || document.getElementById('hrs'+k).value=='' ){
                             //             var row=k+1;
                             //            alert("Enter valid start time and end time in row"+row);
                             //            document.getElementById('stTime'+k).focus();
                             //            return false;
                             //  }
                          }
    }
                    checkFinalcon(fname, submitbutton, errorfinal, mode);
                }

                function checkFinalcon(formname, submitbutton, errors, mode) {
                  
                        //	CheckTimesheetValidity();
                if (errors == '') {
		document.lveForm.is_manager.value=mode;
                (document.getElementById('add_button'))?document.getElementById('add_button').disabled=true:'';
                (document.getElementById('remove_button'))?document.getElementById('remove_button').disabled=true:'';
                (document.getElementById('manager'))?document.getElementById('manager').disabled=true:'';
                (document.getElementById('Approved'))?document.getElementById('Approved').disabled=true:'';
                (document.getElementById('reject'))?document.getElementById('reject').disabled=true:'';
                document.getElementById('back_button').disabled=true;
                eval('document.'+formname+'.'+submitbutton+'.disabled=true');
                eval('document.'+formname+'.method="POST"');
                document.lveForm.action='<?php echo $this->webroot; ?>Timesheet/saveinfo';
                document.lveForm.submit();

                    }
                }


</script>
 <script type="text/javascript">

    function reject1(sno,empid)
    {

        $('#dialog').dialog('open');
        return false;
    }

    function getcmtval()
    {
        var voucherno=document.getElementById("cmnt").value;
        var rjres=document.getElementById("rejectres").value=voucherno;

    }


</script>
<!-- Center Content Ends -->

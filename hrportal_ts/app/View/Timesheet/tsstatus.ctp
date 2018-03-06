<?php
App::import('Model', 'General');
$General = new General;
//App::import('Helper', 'Timesheet');
//$Timesheet = new Timesheet;
//pr($timesheet->getemployeetype($arr[]));
App::import('Component', 'Functions');
// We need to load the class
$Function = new FunctionsComponent();
 
 $con=$Function->connRet();
 $arrWeek=$Function->SQLYearWeek($con);

App::import('Component', 'Costings');
// We need to load the class
$Costings= new CostingsComponent();
?>

<script language="javascript">
    function redirect(val){

      // document.reportForm.action ="Timesheet/tsreportview?sort="+val;
        window.location.href="<?php echo $this->webroot;?>Timesheet/tsreportview?sort="+val;
    }

    function  ExpandCollapse(id){
        if(id!=''){
            var Obj=document.getElementById(id);
            if(Obj.style.display=="none"){
                Obj.style.display="";
            }else{
                Obj.style.display="none";
            }
        }
    }

    function SetYearDate(url){
        jQuery.ajax({
            url: '<?php echo $this->webroot . "Timesheet/tsstatus" ?>',
            data: url,
            success: function(data){
                YearWeekCombo(data);
               
            }
        });
}
function YearWeekCombo(index){
	var arrWeek=index.split(';;');
	document.getElementById('fromDateTD').innerHTML=arrWeek[0];
	document.getElementById('toDateTD').innerHTML=arrWeek[1];
	document.getElementById('YSD').value=arrWeek[2];
}
function DisableEnable(enableID , disableID, param){
   	if(document.getElementById(enableID))document.getElementById(enableID).disabled=false;
		if(document.getElementById(disableID))document.getElementById(disableID).disabled=true;
		if(param!=''){if(enableID=='from_date'){document.getElementById(param).disabled=false; }else if(disableID=='from_date'){document.getElementById(param).disabled=true;}}
}

function FetchWeekNo(val){
 
      var url='task=FetchWeekNo&month='+val+'&year='+document.getElementById('ts_year').value+'&YSD='+document.getElementById('YSD').value;

      jQuery.ajax({
            url: '<?php echo $this->webroot . "Timesheet/tsstatus" ?>',
            data: url,
            success: function(data){ 
                fetchComplete(data);
               
            }
        });
   }
function fetchComplete(data){
        var arrWeek=data.split('!!');
	document.getElementById('fromDateTD').innerHTML=arrWeek[0];
	document.getElementById('toDateTD').innerHTML=arrWeek[1];
}

function CheckDetais(Obj){
	var flg=1;
	if(Obj.Sch.checked=true){
		if(Obj.Sch[0].checked==true && Obj.month.value =='' ){
			alert("Please select month");
			Obj.month.focus();
			flg=0;
			return false;
		}else if(Obj.Sch[1].checked==true && Obj.from_date.value ==''  && Obj.to_date.value =='' ){
			alert("Please select from date & to date");
			Obj.from_date.focus();
			flg=0;
			return false;
		}
	}
	if(Obj.Rgn.checked=true){
		if(Obj.Rgn[1].checked==true && Obj.emp_id.value ==''){
			alert("Please select employee id");
			Obj.month.focus();
			flg=0;
			return false;
		}
	}
	if(flg==1){
		Obj.submit();
	}
}


function CheckDetais1(Obj){
	var flg=1;
	if(Obj.Sch.checked=true){
		if(Obj.Sch[0].checked==true && Obj.month.value =='' ){
			alert("Please select month");
			Obj.month.focus();
			flg=0;
			return false;
		}else if(Obj.Sch[1].checked==true && Obj.from_date.value ==''  && Obj.to_date.value =='' ){
			alert("Please select from date & to date");
			Obj.from_date.focus();
			flg=0;
			return false;
		}
	}
	if(Obj.Rgn.checked=true){
		if(Obj.Rgn[1].checked==true && Obj.emp_id.value ==''){
			alert("Please select employee id");
			Obj.month.focus();
			flg=0;
			return false;
		}
	}
	
}








</script>

<?php $strPer=''; ?>
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>

            <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li><?php echo $html->link(' Timesheet', $html->url('/selfservices/#timesheet', true)); ?> </li>
           
        </ul>
    </div>
</div>
<div class="travel-voucher">
<div class="input-boxs">
<table align="center" width="100%" rules="none" frame="void" class=pageHead>
	<tr>
		<th align="right">Time Sheet: <?php if(!empty($month)) { echo $arrMonth[$month-1]; }?> Status<br> Date/Time : <?php echo date("F j, Y, g:i a"); ?> </th>
	</tr>
</table>
<hr width="100%" style="color:black">
<form name="lveform" method="GET" action="">
	<table align="center" width="100%" border="0" class="style2" >
		<tr>
			<td width="24%"><b>Year :</b></td>
			<td colspan='6'>
                            <select name="year" id="ts_year" onChange="SetYearDate('year='+this.value+'&task=StatusYearWeek');">
				<?php
				for ($i=2008;$i<=date('Y');$i++){
					//$selected=($i==$_REQUEST['year'])?'SELECTED':(($i==date('Y'))?'SELECTED':'');
					if($_REQUEST['year'] !=''){
						$selected=($i==$_REQUEST['year'])?'SELECTED':'';
					}else{
						$selected=($i==date('Y'))?'SELECTED':'';
					}
					echo "<option value='".$i."' ".$selected.">".$i."</option>";
				}?>
			</select>
						<input type="hidden" id="YSD" name="YSD" value="<?php if(!empty($_REQUEST['YSD'])) { echo $_REQUEST['YSD']; }else { echo $arrWeek['YEAR_FIRST_WK_START_DATE_RRRR'];}?>">
                   
                        </td>
		</tr>
		<tr><?php  if (empty($_REQUEST['Sch'])) { $_REQUEST['Sch']=0;  }?>
			<td width="24%"><b>Period :</b></td>
			<td width="4%" ><input type="radio"  name="Sch" id="Sch" value="0" <?php  echo (!empty($_REQUEST['month']))?'CHECKED':(($_REQUEST['Sch']=='0')?'CHECKED':'')?> onClick="DisableEnable('month','','');">			</td>
			<td width="20%"><b>Month</b></td>
			<td colspan="4"><select name="month" class="textbox" id="month" <?php  if(!empty($_REQUEST['Sch'])) { if($_REQUEST['Sch']=='1') { 'DISABLED' ; } } else {'';  }?> onChange='FetchWeekNo(this.value);'>
					<option value="">Select Month</option>
					<?php for($i=1;$i<=12;$i++){
					$i=($i<10)?'0'.$i:$i;?>
					<option value="<?php echo $i?>" <?php if(!empty($_REQUEST['month'])){ echo ($_REQUEST['month']==$i)?'SELECTED':''; }?>><?php  echo $arrMonth[$i-1]?></option>
					<?php  }?>
				</select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td ><input type="radio" <?php if(!empty($_REQUEST['Sch'])) { if($_REQUEST['Sch']=='1'){ echo 'CHECKED'; } else { ''; } }?> name="Sch" value="1" onClick="DisableEnable('from_date','month','to_date');"></td>
			<td ><strong>From</strong></td>
			<td width="5%" id="fromDateTD"><?php
				$cur_from_week =(!empty($_REQUEST['from_date']))?$_REQUEST['from_date']:date('W');
				$fromAttrib = "class='textBox' name='from_date' id='from_date'";
				$year_start=(!empty($_REQUEST['YSD']))?$_REQUEST['YSD']:$arrWeekNo['YEAR_FIRST_WK_START_DATE_RRRR'];
		echo  $Function->StatusYearWeeksCombo($year_start,$cur_from_week,$fromAttrib);
?></td>
			<td width="10%" align="right"><b>To</b></td>
			<td colspan="2" id="toDateTD">
<?php

				if(!empty($_REQUEST['to_date'])){ $cur_to_week=$_REQUEST['to_date'];}else{ $cur_to_week=date('W') ;} ;
				$toAttrib = "class='textBox' name='to_date' id='to_date' ";
				$year_start=(!empty($_REQUEST['YSD']))?$_REQUEST['YSD']:$arrWeekNo['YEAR_FIRST_WK_START_DATE_RRRR'];

		                echo  $Function->StatusYearWeeksCombo1($year_start ,$cur_to_week,$toAttrib);
?>			</td>
		</tr>
		<tr>
			<td width="24%" colspan="7"><hr></td>
			
		</tr>

                <?php //pr($rwRegion); die; ?>
		<tr>
			<td><b>For :</b></td> 
			<td><input type="radio" name="Rgn" id="Rgn" value="0"<?php if(!empty($_REQUEST['Rgn'])) {  echo ($_REQUEST['Rgn']=='0')?'CHECKED':(($_REQUEST['emp_id']=='')?'CHECKED':''); }?> onClick="DisableEnable('region','emp_id','');"></td>
			<td><b>Region</b></td>
			<td  colspan="5"><select name="region" class="textbox" id="region" <?php echo ($_REQUEST['Rgn']=='1')?'DISABLED':'';?>>
					<option value="">All</option>
					<?php for($i=0;$i<$num_emp;$i++){?>
					<option value="<?php echo $rwRegion['VC_ZONE'][$i]?>" <?php if(!empty($_REQUEST['region'])) {if($_REQUEST['region']== $rwRegion['VC_ZONE'][$i]){ 'SELECTED';} else {'' ;} }?>><?php echo $rwRegion['REGION'][$i]?></option>
					<?php }?>
				</select>	</td>
		</tr>
		<tr>
			<td nowrap="nowrap" >&nbsp;</td>
			<td><input type="radio" name="Rgn" value="1" <?php if(!empty($_REQUEST['Rgn'])) {echo ($_REQUEST['Rgn']=='1')?'CHECKED':''; }?> onClick="DisableEnable('emp_id','region','');"></td>
			<td><b>Employee Id</b></td>
			<td colspan="4"><input type="text" <?php  //echo ($_REQUEST['emp_id']=='')?'DISABLED':''?> class="textbox"size='8' maxlength="8"name="emp_id"  id="emp_id"value="<?php //echo $_REQUEST['emp_id']?>">			</td>
		</tr>
		<tr>
			<td width="24%" colspan="7"><hr></td>
			
		</tr>
		<tr>
			<td nowrap="nowrap"  ><strong>Show: </strong></td>
			<!--td colspan="5" ><select name="defaulter" class="textbox">
					<option value="">All</option>
					<option value="1" <?php //echo ($_REQUEST['defaulter']=='1')?'SELECTED':''?>>Defaulter Employee</option>
					<option value="2" <?php //echo ($_REQUEST['defaulter']=='2')?'SELECTED':''?>>Non Defaulter Employee</option>
				</select>
			</td-->
			<td  ><input type="radio" name="defaulter" value="" <?php // echo ($_REQUEST['defaulter']=='')?'CHECKED':''?> onClick="DisableEnable('emp_id','region','');"></td>
			<td>All</td>
			<td  align="right" ><input type="radio" name="defaulter" value="1" <?php if(!empty($_REQUEST['defaulter'])) {echo ($_REQUEST['defaulter']=='1')?'CHECKED':''; }?> ></td>
			<td>Defaulter</td>
			<td width="5%" align="right" ><input type="radio" name="defaulter" value="2" <?php if(!empty($_REQUEST['defaulter'])) { echo ($_REQUEST['defaulter']=='2')?'CHECKED':''; }?> ></td>
			<td width="32%">Non-Defaulter</td>
                </tr>
                <tr>
			<td width="24%" colspan="7"><hr></td>
			
		</tr>
                <tr>
                    <td colspan="3"></td>
		<td  nowrap="nowrap" colspan='1' align="center"><input type="button" name="task"class="textbox"  onclick="CheckDetais(this.form);"value="Show List"></td>
                <td  nowrap="nowrap" colspan='1' align="center"><input type="submit" name="task1"class="textbox"  onclick="CheckDetais1(this.form);"value="Excel Summary"></td>
		<td colspan="2"></td>
                </tr>
	</table>
	<input type="hidden" name="empCode"  id="empCode"value="<?php if(!empty($_REQUEST['empCode'])) {echo $_REQUEST['empCode']; }?>">
</form>
<?php if($TotalEmployee==0){?>
<center>
	<p>
	<font style="color:red"><b>
	<h3>There is no record to view ! </h3>
	</b></font>
	</p>
</center>
<?php }else{ 


 for($j=0;$j<$TotalPeriod;$j++){
	$strPer .="<td  nowrap='nowrap'><b>". $arrDatePeriod[$j]['EndPeriod']."</b></td>";
}

?>
<form id="listing_form" name="listing_form" method="post" action="">
	<table align="center" width="100%"  cellspacing="0" cellpadding="2"  >
		<tr>
			<td colspan="10" align="left"><b>Remarks</b></td>
		</tr>
		<tr>
			<td colspan="10" align="left"><b><font size="1px;">1 : Summary are being displayed for all Employee (Defaulter And Non-defaulter).</font></b></td>
		</tr>
		<tr>
			<td colspan="10" align="left"><b><font size="1px;">2 : Marketing member's summary data are not included in the totals. </font></b><br/></td>
		</tr>
		<?php
			$i=1;
		$j=1;
		$tot=count($arrStatus);
		$OldRegion=array();
		$tot_hrs ='';
		$tot_frm='';
		$tot_reps='';
		$allForm='0';
		$allReps='0';
		$allHrs='0';
                $color='';
                $OldEmpId='';
                $totalLeave = '0';
                $allLeave = '0';
                $arr=array();
                $srr=array();
                $totalmktl=0;
                $totalmkthr=0;
                $totalmktemp=0;
                $totalengl=0;
                $totalenghr=0;
                $totalengemp=0;
                $totalotherl=0;
                $totalotherhr=0;
                $totalotheremp=0;
				//print_r($arrStatus); die;
		foreach($arrStatus as $k => $v){
		//print_r($v); 
		$str_colorChange=($color == "#EBF1FC")?"onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#ffffff'\" onclick=\"style.backgroundColor='yellow'\"":"onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#EBF1FC'\" onclick=\"style.backgroundColor='yellow'\"";
                $NewEmpId=$v['emp_id'];
				$NewRegion=$v['region_code'];

				if($NewEmpId ==$OldEmpId){
					//if(($NewEmpId == '624' || $oldEmpId == '624') && in_array())
					//$v['status'] = 'Yes';
					 if($v['status']=='No'){$flg='0';}else if($flg=='0' && $v['status']=='Yes'){$flg='0'; }else if(($flg=='1' || $flg=='') && $v['status']=='Yes'){$flg='1';}
					 $strLine.="<td align='center' nowrap='nowrap'>";

					if($v['status']=='Yes'){$strLine.="<a href='javascript:void(0);'   title='View Timesheet Details' onClick=\"javascript:window.open('tsview/".$v['s_no']."/".$v['emp_id'] ."/". strtoupper(date('d-M-Y',strtotime($v['start_date'])))."/". strtoupper(date('d-M-Y',strtotime($v['end_date'])))."/S/' , '',  'left=2,top=2,titlebar=no,toolbar=no,status=no, width=800 , height=700 , scrollbars=yes');\">".$v['status']."</a>";	}else{$strLine.=$v['status'];}
					$strLine.="</td>";
					 $strflg.=$flg;

				  //For Last records Display
					if($j==$tot){
						if(!empty($_REQUEST['defaulter'])){
								$strflg="'".$strflg."'";
								if($_REQUEST['defaulter']=='1'){
									if(strpos($strflg,'0')==true){echo $strLine; $dflg=1;}
								}else{
									if(strpos($strflg,'0')==false){$i++;echo $strLine;$dflg=1;}
								}
						}else{echo $strLine;}
						$allForm +=$tot_frm;
						$allReps+=$tot_reps;
						$allHrs+=$tot_hrs;
						$allLeave+= $totalLeave;
						 if(($dflg=='0') && !empty($_REQUEST['defaulter'])){
								echo "<tr height='10'><td colspan='".($TotalPeriod+4) ."' align='center'><strong><font color='red'>No records found</font></strong></td></tr>";
							}
						 echo "<tr height='10' bgcolor='#ffffff'>
                                                     <td align='left' ><b>Summary For:</b></td><td align='left' ><b>".$SMReg."</b></td>
                                                     <td align='right' ><b>Total Forms:</b></td><td align='Left' ><b>".$tot_frm."</b></td>
                                                     <td align='Left' ><b>Total Report:</b></td><td align='Left' ><b>".$tot_reps."</b>
                                                     </td><td align='Left' ><b>Total Hours:</b></td><td align='Left'  >	<b>".$Function->ConvertTime($tot_hrs , true)."</b></td>
                                                      <td align='Left' colspan='".($TotalPeriod-4) ."'  >&nbsp;<br><br><br></td>
                                                 </tr>";
                                                
                                                  echo "<tr   class='odpersonheading1'>
                                                     <td align='Left' class='ofperson'><b></b></td>
                                                     <td align='Left' class='ofperson' ><strong># of persons as on (".$arrDatePeriod[$TotalPeriod-1]['EndPeriod'].")</strong></td>
                                                     <td align='Left' class='ofperson'><strong># of Leave</strong></td>
                                                     <td align='Left' class='ofperson'><strong># of hrs</strong></td>
                                                     <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
                                                     <td align='Left' colspan='".($TotalPeriod-4) ."'  class='ofperson'>&nbsp;<br><br><br></td>
                                                 </tr>";
                                                 $mgr= $timesheet->checkEmployeemarkType($srr[$SMReg]);
                                                 $eng=   $timesheet->checkEmployeeEngType($srr[$SMReg]);
                                                  $oth= $timesheet->checkEmployeeOtherType($srr[$SMReg]);
                                                  $totalmktl+=$mgr['lv'];
                                                  $totalmkthr+=$mgr['hr'];
                                                  $totalmktemp+=$timesheet->getEmployeemarkType($arr[$SMReg]);
                                                  $totalengl+=$eng['lv'];
                                                  $totalenghr+=$eng['hr'];
                                                  $totalengemp+=$timesheet->getEmployeeEngType($arr[$SMReg]);
                                                  $totalotherl+=$oth['lv'];
                                                  $totalotherhr+=$oth['hr'];
                                                  $totalotheremp+=$timesheet->getEmployeeOtherType($arr[$SMReg]);
                                                  
                                                         echo "<tr bgcolor='#ffffff'>
                                                     <td align='Left' class='ofperson'><b>Marketing:</b></td>
                                                     <td align='Left' class='ofperson'><strong>".$timesheet->getEmployeemarkType($arr[$SMReg])."</strong></td>
                                                     <td align='Left' class='ofperson'><strong>".$mgr['lv']."</strong></td>
                                                     <td align='Left' class='ofperson'><strong>".$Function->ConvertTime($mgr['hr'], true)."</strong></td>
                                                     <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
                                                     <td align='Left' colspan='".($TotalPeriod-4) ."' class='ofperson' >&nbsp;<br><br><br></td>
                                                 </tr>";
                                                      
                                                         echo "<tr  bgcolor='#EBF1FC'>
                                                     <td align='Left' class='ofperson'><b>Engineer:</b></td>
                                                     <td align='Left' class='ofperson'><strong>".$timesheet->getEmployeeEngType($arr[$SMReg])."</strong></td>
                                                     <td align='Left' class='ofperson'><strong>".$eng['lv']."</strong></td>
                                                     <td align='Left' class='ofperson'><strong>".$Function->ConvertTime($eng['hr'], true)."</strong></td>
                                                     <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
                                                     <td align='Left' colspan='".($TotalPeriod-4) ."'  class='ofperson'>&nbsp;<br><br><br></td>
                                                 </tr>";
                                                        
                                                          echo "<tr  bgcolor='#ffffff'>
                                                     <td align='Left' class='ofperson'><b>Others:</b></td>
                                                     <td align='Left' class='ofperson'><strong>".$timesheet->getEmployeeOtherType($arr[$SMReg])."</strong></td>
                                                     <td align='Left' class='ofperson'><strong>".$oth['lv']."</strong></td>
                                                     <td align='Left' class='ofperson'><strong>".$Function->ConvertTime($oth['hr'], true)."</strong></td>
                                                     <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
                                                      <td align='Left' colspan='".($TotalPeriod-4) ."' class='ofperson' >&nbsp;<br><br><br></td>
                                                 </tr>";
					}
				
				
				$tot_hrs +=$Function->ConvertTime($v['region_hrs']);
				$tot_frm+=$v['region_frm'];
				$tot_reps+=$v['region_reps'];
				$totalLeave+=$v['leave'];
				$srr[$v['region_name']][$v['emp_id']]['leave'][]=$v['leave'];
				$srr[$v['region_name']][$v['emp_id']]['region_hrs'][]=$Function->ConvertTime($v['region_hrs']);
				
                                
			  }else{
                              if(!empty($strLine)){
						if(!empty($_REQUEST['defaulter'])){
								$strflg="'".$strflg."'";
								//Display Only defaulter List
								if($_REQUEST['defaulter']=='1'){
									if(strpos($strflg,'0')==true){$i++;	echo $strLine;$dflg=1;}
								}else{
									//Display Only Non-Defaulter List
									if(strpos($strflg,'0')==false){$i++;echo $strLine;$dflg=1;}
								}
						}else{$i++;
							//Display Complete List Defaulter/Non Defaulter
							echo $strLine;
						}
					}
                    if(!in_array($NewRegion, $OldRegion)){
						if(!empty($SMReg)){  
							$allForm +=$tot_frm;
							$allReps+=$tot_reps;
							$allHrs+=$tot_hrs;
                            $allLeave+=$totalLeave;
							if($dflg=='0' && !empty($_REQUEST['defaulter'])){ 
								echo "<tr height='10'>
										<td colspan='".($TotalPeriod+4) ."' align='center'>
										 <strong><font color='red'>No records found</font></strong>
										 </td>
									   </tr>";
							} 
							echo "<tr height='10' bgcolor='#ffffff'>
									<td align='left' ><b>Summary For:</b></td>
									<td align='left' ><b>".$SMReg."</b></td>
									<td align='right' ><b>Total Forms:</b></td>
									<td align='Left' ><b>".$tot_frm."</b></td>
									<td align='Left'><b>Total Report:</b></td>
									<td align='Left' ><b>".$tot_reps."</b></td>
									<td align='Left' ><b>Total Hours:</b></td>
									<td align='Left'><b>".$Function->ConvertTime($tot_hrs , true)."</b></td>
									
									<td align='Left'  >&nbsp;<br><br></td>
							   </tr>"; 
                                                      
							 echo "<tr  class='odpersonheading1'>
									 <td align='Left' class='ofperson'><b></b></td>
									 <td align='Left' class='ofperson '><strong># of persons as on (".$arrDatePeriod[$TotalPeriod-1]['EndPeriod'].") </strong></td>
									 <td align='Left' class='ofperson'><strong># of Leave</strong></td>
									 <td align='Left' class='ofperson'><strong># of hrs</strong></td>
									 <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
								 </tr>";
							$mgr= $timesheet->checkEmployeemarkType($srr[$SMReg]);
							$eng=   $timesheet->checkEmployeeEngType($srr[$SMReg]);
							$oth= $timesheet->checkEmployeeOtherType($srr[$SMReg]);
							  $totalmktl+=$mgr['lv'];
							  $totalmkthr+=$mgr['hr'];
							  $totalmktemp+=$timesheet->getEmployeemarkType($arr[$SMReg]);
							  $totalengl+=$eng['lv'];
							  $totalenghr+=$eng['hr'];
							  $totalengemp+=$timesheet->getEmployeeEngType($arr[$SMReg]);
							  $totalotherl+=$oth['lv'];
							  $totalotherhr+=$oth['hr'];
							  $totalotheremp+=$timesheet->getEmployeeOtherType($arr[$SMReg]);
							 echo "<tr  bgcolor='#ffffff'>
									 <td align='Left'class='ofperson'><b>Marketing:</b></td>
									 <td align='Left'class='ofperson'><strong>".$timesheet->getEmployeemarkType($arr[$SMReg])."</strong></td>
									 <td align='Left'class='ofperson'><strong>".$mgr['lv']."</strong></td>
									 <td align='Left'class='ofperson'><strong>".$Function->ConvertTime($mgr['hr'] , true)."</strong></td>
									 <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
								 </tr>";
							 
							 echo "<tr  bgcolor='#EBF1FC'>
									 <td align='Left' class='ofperson'><b>Engineer:</b></td>
									 <td align='Left' class='ofperson'><strong>".$timesheet->getEmployeeEngType($arr[$SMReg])."</strong></td>
									 <td align='Left' class='ofperson'><strong>".$eng['lv']."</strong></td>
									 <td align='Left' class='ofperson'><strong>".$Function->ConvertTime($eng['hr'], true)."</strong></td>
									 <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
								 </tr>";
							 
							 echo "<tr bgcolor='#ffffff'>
									 <td align='Left' class='ofperson'><b>Others:</b></td>
									 <td align='Left' class='ofperson'><strong>".$timesheet->getEmployeeOtherType($arr[$SMReg])."</strong></td>
									 <td align='Left' class='ofperson'><strong>".$oth['lv']."</strong></td>
									 <td align='Left' class='ofperson'><strong>".$Function->ConvertTime($oth['hr'], true)."</strong></td>
									 <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
								 </tr>";
							echo "<tr>
									  <td colspan='".($TotalPeriod-4) ."'></td>
								  </tr>
								  </table>
								 </td>
							 </tr>";
						}

						echo "<tr><td>
									<table width='100%' cellpadding='0' cellspacing='1' class='exp-voucher'>
									<tr><td colspan='".(3+$TotalPeriod) ."' style='font-color:red;vertical-align:middle;'align='Left' ><b>
									 <font color='red'>".$v['region_name']."</font></b></br></td>
									</tr>
									<tr class='head'>
									<th align='left'>S.No.</th>
									<th align='left'>Emp Id</th>
									<th align='left'>Employee Name</th>".$strPer."</tr>";
						  $OldRegion[]=$v['region_code'];//Assign/push new region into array.
						  $SMReg=$v['region_name'];//Summary Region Name
						  $i=1;
						  
						  $flag='';
							if($v['status']=='No'){$flg='0';}else if($flg=='0' && $v['status']=='Yes'){$flg='0';}else if(($flg=='1' || $flg=='') && $v['status']=='Yes'){$flg='1';}
						  
						  if(!empty($_REQUEST['defaulter']))
							{
								if($flg==0 && $_REQUEST['defaulter']==1){
									$tot_hrs=$Function->ConvertTime($v['region_hrs']); //Initialize Total Hours
						  $tot_frm=$v['region_frm']; //Initialize Total Forms
						  $tot_reps=$v['region_reps']; //Initialize Total Reports
                          $totalLeave=$v['leave'];
								}else if($flg==1 && $_REQUEST['defaulter']==2){
									$tot_hrs=$Function->ConvertTime($v['region_hrs']); //Initialize Total Hours
						  $tot_frm=$v['region_frm']; //Initialize Total Forms
						  $tot_reps=$v['region_reps']; //Initialize Total Reports
                          $totalLeave=$v['leave'];
								}
							}else{
									$tot_hrs=$Function->ConvertTime($v['region_hrs']); //Initialize Total Hours
						  $tot_frm=$v['region_frm']; //Initialize Total Forms
						  $tot_reps=$v['region_reps']; //Initialize Total Reports
                          $totalLeave=$v['leave'];
							}
						  
						  
                          /*$tot_hrs=$Function->ConvertTime($v['region_hrs']); //Initialize Total Hours
						  $tot_frm=$v['region_frm']; //Initialize Total Forms
						  $tot_reps=$v['region_reps']; //Initialize Total Reports
                          $totalLeave=$v['leave'];*/
						  $dflg=0; //Initialize Flag for No Records Found
						}else{
							
							$flag='';
							if($v['status']=='No'){$flg='0';}else if($flg=='0' && $v['status']=='Yes'){$flg='0';}else if(($flg=='1' || $flg=='') && $v['status']=='Yes'){$flg='1';}
						
							if(!empty($_REQUEST['defaulter']))
							{
								if($flg==0 && $_REQUEST['defaulter']==1){
									$tot_hrs+=$Function->ConvertTime($v['region_hrs']); //Initialize Total Hours
						  $tot_frm+=$v['region_frm']; //Initialize Total Forms
						  $tot_reps+=$v['region_reps']; //Initialize Total Reports
                          $totalLeave+=$v['leave'];
								}else if($flg==1 && $_REQUEST['defaulter']==2){
									$tot_hrs+=$Function->ConvertTime($v['region_hrs']); //Initialize Total Hours
						  $tot_frm+=$v['region_frm']; //Initialize Total Forms
						  $tot_reps+=$v['region_reps']; //Initialize Total Reports
                          $totalLeave+=$v['leave'];
								}
							}else{
									$tot_hrs+=$Function->ConvertTime($v['region_hrs']); //Initialize Total Hours
						  $tot_frm+=$v['region_frm']; //Initialize Total Forms
						  $tot_reps+=$v['region_reps']; //Initialize Total Reports
                          $totalLeave+=$v['leave'];
							}
							/*
							  $tot_hrs +=$Function->ConvertTime($v['region_hrs']);
						      $tot_frm+=$v['region_frm'];
						      $tot_reps+=$v['region_reps'];
                              $totalLeave+=$v['leave'];*/
						}
					$strLine='';
					$flg='';
					$strflg='';
                                            

					if($v['status']=='No'){$flg='0';}else if($flg=='0' && $v['status']=='Yes'){$flg='0';}else if(($flg=='1' || $flg=='') && $v['status']=='Yes'){$flg='1';}

					$color=($color=="#EBF1FC")?'#FFFFFF':'#EBF1FC';
					if(!empty($_REQUEST['defaulter']))
					{
						if($flg==0 && $_REQUEST['defaulter']==1){
							$arr[$v['region_name']][]=$v['emp_id'];				   
							$srr[$v['region_name']][$v['emp_id']]['leave'][]=$v['leave'];
							$srr[$v['region_name']][$v['emp_id']]['region_hrs'][]=$Function->ConvertTime($v['region_hrs']);
						}else if($flg==1 && $_REQUEST['defaulter']==2){
							$arr[$v['region_name']][]=$v['emp_id'];				   
							$srr[$v['region_name']][$v['emp_id']]['leave'][]=$v['leave'];
							$srr[$v['region_name']][$v['emp_id']]['region_hrs'][]=$Function->ConvertTime($v['region_hrs']);
						}
					}else{
							$arr[$v['region_name']][]=$v['emp_id'];				   
							$srr[$v['region_name']][$v['emp_id']]['leave'][]=$v['leave'];
							$srr[$v['region_name']][$v['emp_id']]['region_hrs'][]=$Function->ConvertTime($v['region_hrs']);
					}
                                       
					$strLine.= "</tr><tr col bgcolor=".$color." ". $str_colorChange."><td width='1%'>$i.</td><td align='left' nowrap='nowrap'>".$v['emp_id']."</td><td  nowrap='nowrap'>".$v['emp_name']."</td>";
					$strLine.="<td align='center' nowrap='nowrap'>";

					if($v['status']=='Yes'){$strLine.="<a href='javascript:void(0);'   title='View Timesheet Details' onClick=\"javascript:window.open('tsview/".$v['s_no']."/".$v['emp_id'] ."/". strtoupper(date('d-M-Y',strtotime($v['start_date'])))."/". strtoupper(date('d-M-Y',strtotime($v['end_date'])))."/S/' , '',  'left=2,top=2,titlebar=no,toolbar=no,status=no, width=800 , height=700 , scrollbars=yes');\">".$v['status']."</a>";}else{$strLine.=$v['status'];}
					$strLine.="</td>";

					$strflg=$flg;

					$OldEmpId=$v['emp_id']; 


                                }
			$j++;
			} //print_r($allHrs);
                      // pr($srr);
		}
?>
	<?php ?>
                <?php if($TotalEmployee > 0){ //$newhr = $allHrs * $TotalPeriod; ?>
	<table cellpadding="0" cellspacing="0" width="100%" border="">
		<tr  height='10' bgcolor="#0000CC">
			<td style=" color:#FFFFFF"><strong>Over All Summary</strong></td>
			<td style=" color:#FFFFFF" align="right"><strong>Total Forms:&nbsp;&nbsp;</strong></td>
			<td style=" color:#FFFFFF"><?php if(!empty($allForm)){ echo $allForm ;}?></td>
			<td style=" color:#FFFFFF" align="right"><strong>Total Reports:&nbsp;&nbsp;</strong></td>
			<td style=" color:#FFFFFF"><?php   if(!empty($allReps)){ echo $allReps; }?></td>
			<td style=" color:#FFFFFF"align="right"><strong>Total Hours:&nbsp;&nbsp;</strong></td>
			<td style=" color:#FFFFFF"><?php  if(!empty($allHrs)){ echo $Function->ConvertTime($allHrs , true) ;}?></td>
                        <td style=" color:#FFFFFF"align="right"><strong>Total Leave:&nbsp;&nbsp;</strong></td>
			<td style=" color:#FFFFFF"><?php  echo $allLeave ;?></td>
		</tr>
                                                <tr  class='odpersonheading1'>
                                                     <td align='Left' class='ofperson'><b></b></td>
                                                     <td align='Left' class='ofperson '><strong># of persons as on (<?php echo $arrDatePeriod[$TotalPeriod-1]['EndPeriod']?>) </strong></td>
                                                     <td align='Left' class='ofperson'><strong># of Leave</strong></td>
                                                     <td align='Left' class='ofperson'><strong># of hrs</strong></td>
                                                     <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
                                                 </tr>
                                                 
                
                                                 <tr  bgcolor='#ffffff'>
                                                     <td align='Left'class='ofperson'><b>Marketing:</b></td>
                                                     <td align='Left'class='ofperson'><strong><?php echo $totalmktemp;?></strong></td>
                                                     <td align='Left'class='ofperson'><strong><?php echo $totalmktl;?></strong></td>
                                                     <td align='Left'class='ofperson'><strong><?php echo $Function->ConvertTime($totalmkthr , true);?></strong></td>
                                                     <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
                                                 </tr>
                                                         
                                                 <tr  bgcolor='#EBF1FC'>
                                                     <td align='Left' class='ofperson'><b>Engineer:</b></td>
                                                     <td align='Left' class='ofperson'><strong><?php echo $totalengemp;?></strong></td>
                                                     <td align='Left' class='ofperson'><strong><?php echo $totalengl;?></strong></td>
                                                     <td align='Left' class='ofperson'><strong><?php echo $Function->ConvertTime($totalenghr , true);?></strong></td>
                                                     <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
                                                 </tr>
                                                         
                                                  <tr bgcolor='#ffffff'>
                                                     <td align='Left' class='ofperson'><b>Others:</b></td>
                                                     <td align='Left' class='ofperson'><strong><?php echo $totalotheremp;?></strong></td>
                                                     <td align='Left' class='ofperson'><strong><?php echo $totalotherl;?></strong></td>
                                                     <td align='Left' class='ofperson'><strong><?php echo $Function->ConvertTime($totalotherhr , true);?></strong></td>
                                                     <td align='Left' colspan='5' class='ofperson'>&nbsp;<br><br></td>
                                                 </tr>
	</table>
               <?php }?>
        </table>
</form>
</div>
</div>


<style>
    .ofperson{
        margin: 0px;
        padding: 0px 5px !important; line-height: 12px !important;
    }
    .odpersonheading1
    {
        color:#ffffff;
        background-color: #71af2f; 
    }
    .input-boxs input[type="submit"] {
    background-color: #3b5998 !important;
    border: medium none !important;
    color: #ffffff !important;
    cursor: pointer !important;
    font-size: 11px !important;
    font-weight: bold !important;
    padding: 3px !important;
    text-transform: uppercase !important;
}
</style>
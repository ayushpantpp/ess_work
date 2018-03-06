<?php
App::import('Model', 'General');
$General = new General;
App::import('Component', 'Functions');
// We need to load the class
$Function = new FunctionsComponent();

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
</script>


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

<h2 class="demoheaders">Report Query Form</h2>
  
<div>

   
    <center>
                <font face="Arial;Helvetica" weight="bold" color="#004282"><b></b></font>
                <h4><font color="#004282" face="Arial;Helvetica" weight="bold">
                    <?php if($fromdate !='' && $todate !=''){?>
                    <b>Employees TS Status During &nbsp;<?php echo $fromdate ?>&nbsp; and &nbsp;<?php echo $todate ?></b>
                    <?php } ?>
                </font></h4>
   </center>
<form name="reportForm" method="POST" action="">
    <table align="center" width="100%" rules="none" frame="void">
<!--        <tr>
            <td width="17%" align="left"><b>Sort Records By&nbsp;:</b></td>
            <td width="83%" align="left"><select name="sort"  id="sort"class="textBox" onChange="redirect(this.value)">
                    <option value="Vc_Emp_Name" <?php //echo ($_REQUEST['sort']=='Vc_Emp_Name')?'SELECTED':'' ?>>Employee Name</option>
                    <option value="vc_customer_name" <?php // echo ($_REQUEST['sort']=='vc_customer_name')?'SELECTED':'' ?>>Customer Name</option>
                    <option value="region" <?php //echo ($_REQUEST['sort']=='region')?'SELECTED':'' ?>>Region</option>
                </select>
            </td>
        </tr>-->
    </table>

</form>


<?php //if(count($empetail)>0) { ?>
<div class="travel-voucher1">
    
            <table width="100%" border="0"  cellpadding="0"  cellspacing="1" class="exp-voucher">
                <tr class="head">
                    <td   align="center" ><strong>Employee Name </strong></td>
                    <td  align="center"><strong>Manager Name </strong></td>
                    <td  align="center"><strong>Region</strong></td>
                    <td  align="center"><strong>Customer</strong></td>
                    <td  align="center"><strong>Start Date</strong></td>
                    <td  align="center"><strong>End Date</strong></td>
                    <td  nowrap="nowrap" align="left"><strong>Submitted On</strong></td>
					<td  nowrap="nowrap" align="left"><strong>Approved On</strong></td>
                    <td  align="center"><strong>Total Hours</strong></td>
<!--                   <td  align="center"><strong>Total Reports</strong></td>
                   <td  align="center"><strong>Total Forms</strong></td>-->
                    <td  align="center"><strong>TS Type</strong></td>
                    <td  align="center"><strong>Status</strong></td>
<td  align="center"><strong>Action</strong></td>
                </tr>

                    <?php
if ($num_rows == 0) {
?>
   
    <tr class="cont">
    <td style="text-align:center;" colspan="11">
    <em>--No Records Found--</em>
    </td>
    </tr>
                <?php } ?>


                <?php
                $arrCustomerHour = array();
                //pr($rwReport);
                for ($i = 0; $i < $num_rows; $i++) {
                    $SQlCustomerHour = "SELECT vc_hrs from hrpay.dt_timesheet where s_no='" . $rwReport['SNO'][$i] . "' AND NU_CUSTOMER_NO='" . $rwReport["NU_CUSTOMER_NO"][$i] . "'";
                    if ($fromdate != '' && $todate != '') {
                        $SQlCustomerHour .=" and DT_WK_DATE between to_date('" . $fromdate . "','DD-MM-YYYY') and to_date('" . $todate . "','DD-MM-YYYY')";
                    }
                    $ora_conn = $Function->connRet();

                  
                    $rsCustomerHour = ociparse($ora_conn, $SQlCustomerHour);
                    ociexecute($rsCustomerHour);
                    $rows_customer_hour = ocifetchstatement($rsCustomerHour, $rwCustomerHour);

                    $totalSecond = 0;

                
                    for ($x = 0; $x < $rows_customer_hour; $x++) {
                        if(!empty($rwCustomerHour['VC_HRS'][$x])){
                        $totalSecond +=$Function->ConvertTime($rwCustomerHour['VC_HRS'][$x]);
                        }
                    }
                    if (array_key_exists($rwReport["NU_CUSTOMER_NO"][$i], $arrCustomerHour)) {
                        $arrCustomerHour[$rwReport["NU_CUSTOMER_NO"][$i]]['Time']+=$totalSecond;
                    } else {
                        $arrCustomerHour[$rwReport["NU_CUSTOMER_NO"][$i]]['Time'] = $totalSecond;
                        $arrCustomerHour[$rwReport["NU_CUSTOMER_NO"][$i]]['Name'] = $rwReport["VC_CUSTOMER_NAME"][$i];
                        $arrCustomerHour[$rwReport["NU_CUSTOMER_NO"][$i]]['id'] = $rwReport["NU_CUSTOMER_NO"][$i];
                    }

                    /* if($_REQUEST['cust_name']!='' & $_REQUEST['cust_id']!=''){
                      $SingleCustHr +=$totalSecond;
                      } */
                    //$color=($color=="#EBF1FC")?'#FFFFFF':'#EBF1FC';
                    //$str_colorChange=($color == "#EBF1FC")?"onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#ffffff'\" ":"onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#EBF1FC'\" ";

                    if ($rwReport['VC_STATUS'][$i] == "S")
                        $tsstatus = "Approved";
                    else if ($rwReport["VC_STATUS"][$i] == "P")
                        $tsstatus = "Pending";
                    else if ($rwReport["VC_STATUS"][$i] == "R")
                        $tsstatus = "Rejected";
                    else
                        $tsstatus="Intermediate";
                ?>
                    <tr class="<?php if($i%2==0){ ?>cont1 <?php }else { ?> cont  <?php }?>">
                        <td height="26" nowrap="nowrap"><?php echo $rwReport["VC_EMP_NAME"][$i] ?></td>
                        <td nowrap="nowrap"><?php echo $rwReport["MGR"][$i] ?></td>
                        <td align="center"><?php echo $rwReport["REGION"][$i] ?></td>
                        <td align="left" nowrap="nowrap"><?php echo substr($rwReport["VC_CUSTOMER_NAME"][$i],0,25); ?></td>
                        <td ><?php echo $rwReport["DT_START_DATE"][$i]; ?></td>
                        <td ><?php echo $rwReport["DT_END_DATE"][$i]; ?></td>
                        <td align="center" nowrap="nowrap"><?php echo $rwReport["SUBMITTED_ON"][$i]; ?></td>
						<td align="center" nowrap="nowrap"><?php echo $rwReport["APPROVED_ON"][$i]; ?></td>
                        <td align="center"><?php if(!empty($totalSecond)) {echo $Function->ConvertTime($totalSecond, true); } ?> </td>
<!--                        <td align="center"><?php //echo $rwReport["VC_TOT_FRMS"][$i] ?></td>
                        <td align="center"><?php // echo $rwReport["VC_TOT_REPS"][$i] ?></td>-->
                        <td align="center"><?php echo ($rwReport["VC_TS_STATUS"][$i] == 'CO') ? 'Consolidate' : 'Normal' ?></td>
                        <td ><?php echo $tsstatus ?></td>
                        <td><ul class="edit-delete-icon">
        <li style="border:none;"> <a href="javascript:void(0);"   title="View <?php echo $rwReport["VC_EMP_NAME"][$i] ?>'s Timesheet Details" onClick="javascript:window.open('tsviewmngr/<?php echo $rwReport["SNO"][$i] ?>/<?php echo $rwReport["VC_EMP_ID"][$i] ?>/<?php echo $rwReport["DT_START_DATE"][$i] ?>/<?php echo $rwReport["DT_END_DATE"][$i] ?>/0/<?php echo $rwReport["VC_STATUS"][$i] ?>/<?php echo $rwReport["NU_CUSTOMER_NO"][$i] ?>' , '',  'left=2,top=2,titlebar=no,toolbar=no,status=no, width=800 , height=700 , scrollbars=yes');" class="view vtip" Title="Approved"></a></li></ul></td>
                    </tr>
<?php
                }
?>
            </table>
        <?php //} ?>

 <?php

 $SQLReport="SELECT   NU_CUSTOMER_NO , VC_CUSTOMER_NAME, c . VC_EMP_NAME, c . VC_EMP_ID,
         SUM (TO_NUMBER (    TO_NUMBER (SUBSTR (LPAD (a.vc_hrs, 5, '0'), 1, 2))
                           * 60
                         + TO_NUMBER (SUBSTR (vc_hrs,
                                              INSTR (a.vc_hrs, ':') + 1)
                                     )
                        )
             )*60 MIN
    FROM hrpay . dt_timesheet a, hrpay . mst_timesheet b, hrpay . persdet c
   WHERE a . s_no = b . s_no and c.VC_EMP_ID=a.VC_EMP_ID AND NU_CUSTOMER_NO is NOT  NULL ";


        if($emp_id!=''){
		$SQLReport .=" AND a.VC_EMP_id ='".$emp_id."'";
                 
	}
//          if($tsstatus!=''){
//		$SQLReport .=" AND b.vc_status ='".$tsstatus."'";
//
//	}
        if($cust_name!='' && $cust_id!=''){
		$SQLReport .=" AND a.nu_customer_no ='".$cust_id."'";
	    if(!empty($milestone)){
                $SQLReport .=" AND a.vc_milestone_id ='".$milestone."'";
            }

        }
         if (!empty($tsregion)) {

                  $SQLReport .=" and b.vc_region='" . $tsregion. "'";

        }

	 if($fromdate !='' && $todate !=''){
			$SQLReport .=" and a.DT_WK_DATE between to_date('".$fromdate."','DD-MM-YYYY') and to_date('". $todate."','DD-MM-YYYY')";
	 }

        
   $SQLReport.="GROUP BY VC_CUSTOMER_NAME,NU_CUSTOMER_NO,VC_EMP_NAME,c.VC_EMP_ID ORDER BY 2";

 // echo $SQLReport; die;
$Costings->db_query($SQLReport);
$rwReport=$Costings->db_fetch_array();
//pr($rwReport1); die;
$num_rows=$Costings->db_num_rows();


if($num_rows>0){
?>
<br/>
<br/>
</div>

    <div align="center" style="float:left; width:100%; text-align: center;  background-color: #3B5998; margin-bottom:10px; font-weight:bold; color:#fff;"><b>Total Working Hour For Listed Customer</b></div>
<br/>
<div style="border:1px solid #666;margin-left:220px; width: 500px; float:left; padding:8px; background-color:#ffffaa">
<table width="100%" cellpadding="4"  align="center" cellspacing="0" border="0">


    <?php
	$newCust=0;
        $color='';
        $oldCustomer='';
	for($i=0;$i<$num_rows;$i++){
		$color=($color=="#EBF1FC")?'#FFFFFF':'#EBF1FC';
		$str_colorChange=($color == "#EBF1FC")?"onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#ffffff'\" ":"onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#EBF1FC'\" ";
		 $newCustomer=$rwReport['NU_CUSTOMER_NO'][$i];
		if($newCustomer==$oldCustomer){
?>
<tr bgcolor="<?php echo $color;?>"<?php echo $str_colorChange;?>>
	<td>&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);"   title="View <?php echo $rwReport['VC_EMP_NAME'][$i]?> Activity Details" onClick="javascript:window.open('activityreport/<?php  echo $rwReport['NU_CUSTOMER_NO'][$i]?>/<?php  echo $rwReport['VC_EMP_ID'][$i]?>/<?php echo $fromdate; ?>/<?php echo $todate;?>','',  'left=2,top=2,titlebar=yes,toolbar=no,status=no, width=500 , height=400 , scrollbars=yes,resizable=yes');"><?php echo $rwReport['VC_EMP_NAME'][$i]?> </a></td>
	<td><?php  echo $Function->ConvertTime($rwReport['MIN'][$i],true) ;?> </td>
</tr>
<?php	}else{ if($i!=0){echo "</table>";}?>
<tr bgcolor='#FFFFAA'>
	<td colspan="2"><img  vspace="0"src="<?php echo $this->webroot?>img/PlusBullates1.jpg"  onclick="ExpandCollapse('<?php echo $rwReport['NU_CUSTOMER_NO'][$i];?>')" style="cursor:pointer;"/> <a href="javascript:void(0);"   title="View <?php echo $rwReport['VC_CUSTOMER_NAME'][$i]?> Activity Details" onClick="javascript:window.open('activityreport/<?php echo $rwReport['NU_CUSTOMER_NO'][$i]?>/<?php echo $rwReport['VC_EMP_ID'][$i];?>/<?php echo $fromdate; ?>/<?php echo $todate;?>','',  'left=2,top=2,titlebar=yes,toolbar=no,status=no, width=500 , height=400 , scrollbars=yes,resizable=yes');"><b><font color="#FF0000"><?php echo $rwReport['VC_CUSTOMER_NAME'][$i]?></font></b> </a></td>
</tr>
<tr id="<?php echo $rwReport['NU_CUSTOMER_NO'][$i];?>" style="display:none;"  >
	<td class="tdclass"><table width="100%" >
			<tr>
				<td><b>Employee Name</b></td>
				<td><b>Total Hour</b> </td>
			</tr>
			<tr bgcolor="<?php echo $color;?>"<?php echo $str_colorChange;?>>
				<td>&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);"   title="View <?php echo $rwReport['VC_EMP_NAME'][$i]?> Activity Details" onClick="javascript:window.open('activityreport/<?php echo $rwReport['NU_CUSTOMER_NO'][$i]?>/<?php echo $rwReport['VC_EMP_ID'][$i]?>/<?php echo $fromdate?>/<?php echo $todate;?>','',  'left=2,top=2,titlebar=yes,toolbar=no,status=no, width=500 , height=400 , scrollbars=yes,resizable=yes');"><?php echo $rwReport['VC_EMP_NAME'][$i]?> </a></td>
				<td><?php echo $Function->ConvertTime($rwReport['MIN'][$i],true) ;?> </td>
			</tr>
			<?php	$oldCustomer=$rwReport['NU_CUSTOMER_NO'][$i];

		}
	}
}
?>
		</table>
</table>
  </div>

</div>


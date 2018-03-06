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
                    <b>Employees TS Status During &nbsp;<?php echo $fromdate ?>&nbsp; and &nbsp;<?php echo $todate ?> For the client &nbsp;<?php echo $cust_name; ?></b>
                    <?php } ?>
                </font></h4>
   </center>
<form name="reportForm" method="POST" action="">
    <table align="center" width="100%" rules="none" frame="void">
    </table>
</form>
<?php //if(count($empetail)>0) { ?>
<div class="travel-voucher1">
    
            <table width="110%" border="0"  cellpadding="0"  cellspacing="1" class="exp-voucher">
                <tr class="head">
                    <td  align="center" width="20%" ><strong>Employee Name </strong></td>
                    <td  align="center" width="10%"><strong>Date </strong></td>
					<td  align="center" width="10%"><strong>TMS ID </strong></td>
                    <td  align="center" width="10%"><strong>Start_Time</strong></td>
                    <td  align="center" width="10%"><strong>End_Time</strong></td>
                    <td  align="center" width="10%"><strong>Hours</strong></td>
                    <td  align="center" width="10%"><strong>Module</strong></td>
       	            <td  align="center" width="10%"><strong>Milestone</strong></td>
   		    <td  align="center" width="30%"><strong>Remarks</strong></td>
		    <td  align="center" width="5%"><strong>Program Name</strong></td>	
		    <td  align="center" width="5%"><strong>Forms/Report</strong></td>	
                   

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
                    $SQlMilestone = "SELECT  b.VC_ACTIVITY AS MILESTONE FROM hrpay.hd_costing_sheet a, hrpay.dt_costing_sheet b 
WHERE  a.VC_SNO=b.VC_SNO and a.nu_cust_code='" . $rwReport["NU_CUSTOMER_NO"][$i] . "' and b.vc_dsno='" . $rwReport["VC_MILESTONE_ID"][$i] . "'";
                    $ora_conn = $Function->connRet();
                    $rsMilestone = ociparse($ora_conn, $SQlMilestone);
                    ociexecute($rsMilestone);
                    $rowsMilestone = ocifetchstatement($rsMilestone, $rwMilestone);
		    @$totalSecond +=$Function->ConvertTime($rwReport['VC_HRS'][$i]);
		    ?>
                    <tr class="<?php if($i%2==0){ ?>cont1 <?php }else { ?> cont  <?php }?>">
                    <td  align="center"><?php echo $rwReport["VC_EMP_NAME"][$i]; ?></td>
                    <td  align="center"><?php echo $rwReport["DT_WEEK_DATE"][$i]; ?></td>
					<td  align="center"><?php echo $rwReport["VC_SUBPROJECT"][$i]; ?></td>
                    <td  align="center"><?php echo $rwReport["VC_STRT_TIME"][$i]; ?></td>
                    <td  align="center"><?php echo $rwReport["VC_END_TIME"][$i]; ?></td>
		    <td  align="center"><?php echo $rwReport["VC_HRS"][$i]; ?></td>
                    <td  align="center"><?php echo $rwReport["VC_MODULE"][$i]; ?></td>
		    <td  align="center"><?php echo @$rwMilestone['MILESTONE'][0];?></td>
		    <td  align="center"><?php echo $rwReport["VC_REMARKS"][$i]; ?></td>
		    <td  align="center"><?php echo $rwReport["VC_FILE_NAME"][$i]; ?></td>	
		    <td  align="center"><?php echo $rwReport["VC_F_R"][$i]; ?></td>	
                    </tr>
<?php
                }
?>
             <tr class="head">
                    <td   align="center" ><strong>Total Hours</strong></td>
                    <td  align="center"><strong><?php echo $Function->ConvertTime($totalSecond,true) ;  ?></strong></td>

                   

                </tr>
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
$Costings->db_query($SQLReport);
$rwReport=$Costings->db_fetch_array();
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
	<td>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rwReport['VC_EMP_NAME'][$i]?></td>
	<td><?php  echo $Function->ConvertTime($rwReport['MIN'][$i],true) ;?> </td>
</tr>
<?php	}else{ if($i!=0){echo "</table>";}?>
<tr bgcolor='#FFFFAA'>
	<td colspan="2"><img  vspace="0"src="<?php echo $this->webroot?>img/PlusBullates1.jpg"  onclick="ExpandCollapse('<?php echo $rwReport['NU_CUSTOMER_NO'][$i];?>')" style="cursor:pointer;"/> <?php echo $rwReport['VC_CUSTOMER_NAME'][$i]?></font></b> </td>
</tr>
<tr id="<?php echo $rwReport['NU_CUSTOMER_NO'][$i];?>" style="display:none;"  >
	<td class="tdclass"><table width="100%" >
			<tr>
				<td><b>Employee Name</b></td>
				<td><b>Total Hour</b> </td>
			</tr>
			<tr bgcolor="<?php echo $color;?>"<?php echo $str_colorChange;?>>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rwReport['VC_EMP_NAME'][$i]?></td>
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


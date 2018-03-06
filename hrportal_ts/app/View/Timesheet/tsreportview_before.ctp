<?php
App::import('Model', 'General');
$General = new General;
App::import('Component', 'Functions');
// We need to load the class
$Function = new FunctionsComponent();
?>

<script language="javascript">
    function redirect(val){
        window.location.href="ts-report-view.php?<?php echo $_SERVER['QUERY_STRING'] ?>&sort="+val;
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

    <!-- Center Content Starts -->

    <div class="center-content">

        <div class="travel-voucher">

            <div class="input-boxs">
<?php
if ($num_rows == 0) {
?>
    <br>
    <br>
    <center>
        <p>
            <font style="color:red"><b>
                    <h3>There is no record to view ! </h3>
                </b></font><br>

        </p>
        <br>
        <p><a href="#" class="linkStyle" onClick="history.back()"><b>Click here to go back....</b></a></p>
    </center>
<?php
} else {
?>
    <h3><font face="Arial;Helvetica"></font>
        <center>
            <font face="Arial;Helvetica">Employee Time Sheet Records</font>
        </center>
    </h3>
    <center>
        <font face="Arial;Helvetica" weight="bold" color="#004282"><b></b></font>
        <h4><font color="#004282" face="Arial;Helvetica" weight="bold">
            <?php //if($_REQUEST['fromDate'] !='' && $_REQUEST['toDate'] !=''){?>
            <b>Employees TS Status During &nbsp;<?php // echo $_REQUEST['fromDate'] ?>&nbsp; and &nbsp;<?php //echo $_REQUEST['toDate'] ?></b>
            <?php //}?>
        </font></h4>
</center>
<form name="reportForm" method="GET" action="">
    <table align="center" width="100%" rules="none" frame="void">
        <tr>
            <td width="17%" align="left"><b>Sort Records By&nbsp;:</b></td>
            <td width="83%" align="left"><select name="sort"  id="sort"class="textBox" onChange="redirect(this.value)">
                    <option value="Vc_Emp_Name" <?php //echo ($_REQUEST['sort']=='Vc_Emp_Name')?'SELECTED':'' ?>>Employee Name</option>
                    <option value="vc_customer_name" <?php // echo ($_REQUEST['sort']=='vc_customer_name')?'SELECTED':'' ?>>Customer Name</option>
                    <option value="region" <?php //echo ($_REQUEST['sort']=='region')?'SELECTED':'' ?>>Region</option>
                </select>
            </td>
        </tr>
    </table>
</form>
<table border="0" width="100%" cellpadding="0" cellspacing="5" class="style2">
    <tr>
        <td width="97%" ><table width="100%" border="0"  cellpadding="5"  cellspacing="0" >
                <tr >
                    <td width="123" height="26" align="center" ><strong>Employee Name </strong></td>
                    <td width="102" align="center"><strong>Manager Name </strong></td>
                    <td width="55" align="center"><strong>Region</strong></td>
                    <td width="55" align="center"><strong>Customer</strong></td>
                    <td width="79" align="center"><strong>Start Date</strong></td>
                    <td width="67" align="center"><strong>End Date</strong></td>
                    <td  nowrap="nowrap" align="left"><strong>Submitted On/Approved On</strong></td>
                    <td width="65" align="center"><strong>Total Hours</strong></td>
                    <td width="83" align="center"><strong>Total Reports</strong></td>
                    <td width="70" align="center"><strong>Total Forms</strong></td>
                    <td width="67" align="center"><strong>TS Type</strong></td>
                    <td width="69" align="center"><strong>Status</strong></td>
                </tr>
                <?php
                $arrCustomerHour = array();
                //pr($rwReport);
                for ($i = 0; $i < $num_rows; $i++) {
                    $SQlCustomerHour = "SElECT vc_hrs from hrpay.dt_timesheet where s_no='" . $rwReport['SNO'][$i] . "' AND NU_CUSTOMER_NO='" . $rwReport["NU_CUSTOMER_NO"][$i] . "'";
                    if ($fromdate != '' && $todate != '') {
                        $SQlCustomerHour .=" and DT_WK_DATE between to_date('" . $fromdate . "','DD-MM-YYYY') and to_date('" . $todate . "','DD-MM-YYYY')";
                    }
                    $ora_conn = $Function->connRet();

                    $rsCustomerHour = ociparse($ora_conn, $SQlCustomerHour);
                    ociexecute($rsCustomerHour);
                    $rows_customer_hour = ocifetchstatement($rsCustomerHour, $rwCustomerHour);

                    $totalSecond = 0;

                    for ($x = 0; $x < $rows_customer_hour; $x++) {
                        //$totalSecond +=$Function->ConvertTime($rwCustomerHour['VC_HRS'][$x]);
                        
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
                    <tr bgcolor="<?php // echo $color;?>"<?php //echo $str_colorChange;?> >
                        <td height="26" nowrap="nowrap"><a href="javascript:void(0);"   title="View <?php echo $rwReport["VC_EMP_NAME"][$i] ?>'s Timesheet Details" onClick="javascript:window.open('ts-view.php?sno=<?php echo $rwReport["SNO"][$i] ?>&empid=<?php echo $rwReport["VC_EMP_ID"][$i] ?>&start=<?php echo $rwReport["DT_START_DATE"][$i] ?>&end=<?php echo $rwReport["DT_END_DATE"][$i] ?>&customer=<?php echo $rwReport["NU_CUSTOMER_NO"][$i] ?>&print=0&ts_status=<?php echo $rwReport["VC_STATUS"][$i] ?>' , '',  'left=2,top=2,titlebar=no,toolbar=no,status=no, width=800 , height=700 , scrollbars=yes');"><?php echo $rwReport["VC_EMP_NAME"][$i] ?></a></td>
                        <td nowrap="nowrap"><?php echo $rwReport["MGR"][$i] ?></td>
                        <td align="center"><?php echo $rwReport["REGION"][$i] ?></td>
                        <td align="left" nowrap="nowrap"><?php echo $rwReport["VC_CUSTOMER_NAME"][$i] ?></td>
                        <td nowrap="nowrap"><?php echo $rwReport["DT_START_DATE"][$i] ?></td>
                        <td nowrap="nowrap"><?php echo $rwReport["DT_END_DATE"][$i] ?></td>
                        <td align="center" nowrap="nowrap"><?php echo $rwReport["SUBMITTED_ON"][$i]; ?> / <?php echo $rwReport["APPROVED_ON"][$i]; ?></td>
                        <td align="center"><?php //echo $Function->ConvertTime($totalSecond, true); ?> </td>
                        <td align="center"><?php echo $rwReport["VC_TOT_FRMS"][$i] ?></td>
                        <td align="center"><?php echo $rwReport["VC_TOT_REPS"][$i] ?></td>
                        <td align="center"><?php echo ($rwReport["VC_TS_STATUS"][$i] == 'CO') ? 'Consolidate' : 'Normal' ?></td>
                        <td ><?php echo $tsstatus ?></td>
                    </tr>
<?php
                }
?>
            </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<?php
                if ($num_rows > 0) {
?>
                    <br/>
                    <br/>
                    <div align="center"><b>Total Working Hour For Listed Customer</b></div>
                    <br/>
                    <table width="50%" cellpadding="4"  align="center"cellspacing="0" border="0" class="">
<?php
                    $newCust = 0;
                    for ($i = 0; $i < $num_rows; $i++) {
                        //$color=($color=="#EBF1FC")?'#FFFFFF':'#EBF1FC';
                        //$str_colorChange=($color == "#EBF1FC")?"onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#ffffff'\" ":"onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#EBF1FC'\" ";
                        $newCustomer = $rwReport['NU_CUSTOMER_NO'][$i];
                        $oldCustomer = '';
                        if ($newCustomer == $oldCustomer) {
?>
                            <tr bgcolor="<?php //echo $color;?>"<?php //echo $str_colorChange;?>>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);"   title="View <?php //echo $rwReport['VC_EMP_NAME'][$i]?> Activity Details" onClick="javascript:window.open('activity-report.php?cust_id=<?php //echo $rwReport['NU_CUSTOMER_NO'][$i]?>&emp_id=<?php //echo $rwReport['VC_EMP_ID'][$i]?>&fromDate=<?php //echo $_REQUEST['fromDate']?>&toDate=<?php //echo $_REQUEST['toDate']?>','',  'left=2,top=2,titlebar=yes,toolbar=no,status=no, width=500 , height=400 , scrollbars=yes,resizable=yes');"><?php //echo $rwReport['VC_EMP_NAME'][$i]?> </a></td>
                                <td><?php //echo $Function->ConvertTime($rwReport['MIN'][$i],true) ;?> </td>
                            </tr>
<?php } else {
                            if ($i != 0) {
                                echo "</table>";
                            } ?>
                            <tr bgcolor='#FFFFAA'>
                                <td colspan="2"><img  vspace="0"src="<?php echo $this->webroot; ?>img/PlusBullates1.jpg"  onclick="ExpandCollapse('<?php //echo $rwReport['NU_CUSTOMER_NO'][$i]; ?>')" style="cursor:pointer;"/> <a href="javascript:void(0);"   title="View <?php //echo $rwReport['VC_CUSTOMER_NAME'][$i] ?> Activity Details" onClick="javascript:window.open('activity-report.php?cust_id=<?php //echo $rwReport['NU_CUSTOMER_NO'][$i] ?>&emp_id=<?php //echo $_REQUEST['emp_id'] ?>&fromDate=<?php //echo $_REQUEST['fromDate'] ?>&toDate=<?php //echo $_REQUEST['toDate'] ?>','',  'left=2,top=2,titlebar=yes,toolbar=no,status=no, width=500 , height=400 , scrollbars=yes,resizable=yes');"><b><font color="#FF0000"><?php //echo $rwReport['VC_CUSTOMER_NAME'][$i] ?></font></b> </a></td>
                            </tr>
                            <tr id="<?php echo $rwReport['NU_CUSTOMER_NO'][$i]; ?>" style="display:none;"  >
                                <td class="tdclass"><table width="100%" >
                                        <tr height="8">
                                            <td ><b>Employee Name</b></td>
                                            <td ><b>Total Hour</b> </td>
                                        </tr>
                                        <tr bgcolor="<?php echo $color; ?>"<?php echo $str_colorChange; ?>>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);"   title="View <?php echo $rwReport['VC_EMP_NAME'][$i] ?> Activity Details" onClick="javascript:window.open('activity-report.php?cust_id=<?php echo $rwReport['NU_CUSTOMER_NO'][$i] ?>&emp_id=<?php echo $rwReport['VC_EMP_ID'][$i] ?>&fromDate=<?php echo $_REQUEST['fromDate'] ?>&toDate=<?php echo $_REQUEST['toDate'] ?>','',  'left=2,top=2,titlebar=yes,toolbar=no,status=no, width=500 , height=400 , scrollbars=yes,resizable=yes');"><?php echo $rwReport['VC_EMP_NAME'][$i] ?> </a></td>
                                            <td><?php echo ConvertTime($rwReport['MIN'][$i], true); ?> </td>
                                        </tr>
                <?php
                            $oldCustomer = $rwReport['NU_CUSTOMER_NO'][$i];
                        }
                    }
                }
            }
                ?>
            </table>
                    </table>
                                        </div>



                    <!-- Center Content Ends -->

                </div>

            </div>


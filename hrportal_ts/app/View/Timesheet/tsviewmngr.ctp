<?php
App::import('Model', 'General');
$General = new General;
App::import('Component', 'Functions');
// We need to load the class
$Function = new FunctionsComponent();
?>

<!-- Header Ends -->
<!-- Center Content Starts -->
<div style="float:right; margin-bottom:10px;"><img src="<?php echo $this->webroot; ?>img/esslogo2.gif"></div>
<div class="travel-voucher">
        <div class="input-boxs">

                <table align="center" width="100%" cellpadding="3" cellspacing="0" >

                        <tr>
                                <td align="left" style="font-size:6pt; vertical-align:bottom;">Eastern Software Systems</td>
                                <td align="right" ><img src="webapp/images/esslogo2.gif"></td>
                        </tr>
                        <tr>
                                <td align="left" colspan="2"  style="font-size:6pt;border:#2A1F00 1px dashed;">Document Title : TIME SHEET</td>
                        </tr>
                        <tr>
                                <td align="left"  style="font-size:6pt;border:#2A1F00 1px dashed;">Document Number : ESS/PROJ/FRM/016/08</td>
                                <td align="right"  style="font-size:6pt;border:#2A1F00 1px dashed;">Date: 27-07-2006</td>
                        </tr>
                </table>
                <br>
        </div>
</div>
<div class="travel-voucher1">
        <div class="input-boxs-timesheet">
                <div> <?php // pr($emp_dtl); die;       ?>
                        <form id="view" name="view" method="post" action="<?php echo $this->webroot; ?>Timesheet/tsviewmngr/<?php echo $emp_dtl[0] ?>/<?php echo $emp_dtl[1]; ?>/<?php echo $emp_dtl[2]; ?>/<?php echo $emp_dtl[3]; ?>/<?php echo $emp_dtl[4]; ?>/<?php echo $emp_dtl[5]; ?>">
                                <table width="100%" cellpadding="3" cellspacing="3"  align="center" >

                                        <?php //pr($emp_dtl); die; ?>
                                        <input type="hidden" name="sno" value="<?php echo $emp_dtl[0]; ?>">
                                        <input type="hidden" name="empid" value="<?php echo $emp_dtl[1]; ?>" >
                                        <input type="hidden" name="start" value="<?php echo $emp_dtl[2]; ?>">
                                        <input type="hidden" name="end" value="<?php echo $emp_dtl[3]; ?>">
                                        <input type="hidden" name="print" value="<?php echo $emp_dtl[4]; ?>">
                                        <input type="hidden" name="ts_status" value="<?php echo $emp_dtl[5]; ?>">

                                        <?php //echo $customer1;  ?>
                                        <tr>
                                                <td width="14%" nowrap="nowrap"><strong>Customer:</strong></td>
                                                <td colspan="9" >
                                                        <select name="customer_filter" class="textBox" onChange="this.form.submit();">
                                                                <option value="">All</option>
                                                                        <?php for ($i = 0; $i < $numCus; $i++) { ?>
                                                                        <option value="<?php echo $rwCus['CID'][$i] ?>" <?php
                                                if (!empty($customer1))
                                                        if ($rwCus['CID'][$i] == $customer1) {
                                                                echo 'SELECTED';
                                                        }
                                                ?>>
                                                                                <?php echo $rwCus['CNAME'][$i] ?></option><?php } ?></select></td>
                                        </tr>
                                        <tr>
                                                <td  nowrap="nowrap"valign="top"><b>Employee Id:</b></td>
                                                <td colspan="2"  valign="top"><?php echo $empid; ?><?php // Customer : echo $rwTsRec['VC_CUSTOMER_NAME'][0]      ?></td>
                                                <td width="14%" nowrap="nowrap" ><strong>Employee Name:</strong></td>
                                                <td colspan="6" ><?php echo $rows['EMP_NAME']['0'] ?></td>
                                        </tr>
                                        <!--<tr>
                                                <td ><b>Employee ID:</b> </td>
                                                <td colspan="9" ></td>
                                        </tr>-->
                                        <tr>
                                                <td  nowrap="nowrap"><b>Week Start Date:</b> </td>
                                                <td colspan="2" ><?php echo $rows['START_DATE'][0] ?></td>
                                                <td   nowrap="nowrap"><b>Week End Date:</b> </td>
                                                <td  colspan="6" ><?php echo $rows['END_DATE'][0] ?>&nbsp;</td>
                                        </tr>

                                        <tr height="10">
                                                <td colspan="10"></td>
                                        </tr>

                                        <tr>
                                                <td colspan="10">
                                                        <table width="100%" border="0"  cellpadding="3" cellspacing="" style="border:solid 0px; border-color:black;"  >
                                                                <tr >
                                                                        <td colspan="6">&nbsp;</td>
                                                                        <td width="15%" colspan="2"  align="right" style="border:#2A1F00 2px solid; padding:0px 5px 0px 5px;">
                                                                                <div align="center"><strong>For ESS internal use</strong></div>
                                                                        </td>
                                                                </tr>
                                                                <tr >
                                                                        <td width="87" style="border-bottom:#2A1F00 2px solid;border-left:#2A1F00 2px solid; border-top:#2A1F00 2px solid;"height="44" align="center" valign="top" ><b>Date</b></td>
																		<td width="39"  style="border-left:#2A1F00 2px solid;border-right:#2A1F00 1px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;"align="center" valign="top"><b>TMS ID</b></td>
                                                                        <td width="39"  style="border-left:#2A1F00 2px solid;border-right:#2A1F00 1px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;"align="center" valign="top"><b>Start Time</b></td>
                                                                        <td width="36"  style="border-left:#2A1F00 1px solid;border-right:#2A1F00 1px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;" align="center" valign="top"><b>End Time</b></td>
                                                                        <td width="41" style="border-left:#2A1F00 1px solid;border-right:#2A1F00 1px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;" align="right"valign="top"><b>Hours</b></td>
                                                                        <td width="52"  style="border-left:#2A1F00 1px solid;border-right:#2A1F00 1px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;"align="left"valign="top"><b>Module</b></td>
                                                                        <td width="52"  style="border-left:#2A1F00 1px solid;border-right:#2A1F00 1px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;"align="left"valign="top"><b>Milestone</b></td>
                                                                        
                                                                        <td width="423" style="border-left:#2A1F00 1px solid;border-right:#2A1F00 1px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;"align="center"valign="top"><b>Remarks</b></td>
                                                                        <td width="100" style="border-left:#2A1F00 1px solid;border-right:#2A1F00 1px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;"align="center"valign="top"><b>Leave</b></td>

                                                                        <td width="54" style="border-left:#2A1F00 1px solid;border-right:#2A1F00 1px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;" align="center"valign="top"><b>Program Name</b></td>
                                                                        <td width="61"  style="border-left:#2A1F00 1px solid;border-right:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;border-top:#2A1F00 2px solid;"align="center"valign="top">
                                                                                <div align="center"><b>F(orm)<br>
                                                                                                /R(eport)</b></div>
                                                                        </td>
                                                                </tr>

                                                                <?php
                                                                $totalSecond = 0;
                                                                for ($x = 0; $x < $numTsRec; $x++) {
                                                                        if (!empty($rwTsRec['VC_HRS'][$x])) {
                                                                                $totalSecond +=$Function->ConvertTime($rwTsRec['VC_HRS'][$x]);
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" valign="top" ><?php echo $rwTsRec['WK_DATE'][$x]; ?></td>
																				<td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" align="right" valign="top"><?php echo $rwTsRec['VC_SUBPROJECT'][$x] ?> </td>
                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" align="right" valign="top"><?php echo $rwTsRec['VC_STRT_TIME'][$x] ?> </td>
                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" align="right" valign="top"><?php echo $rwTsRec['VC_END_TIME'][$x] ?></td>
                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" align="right" valign="top"><?php echo $rwTsRec['VC_HRS'][$x] ?></td>
                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" align="left"valign="top" ><?php echo ($rwTsRec['VC_MODULE'][$x]) ? $rwTsRec['VC_MODULE'][$x] : '-'; ?></td>
                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" align="left"valign="top" ><?php echo ($rwTsRec['VC_ACTIVITY'][$x]) ? $rwTsRec['VC_ACTIVITY'][$x] : '-'; ?></td>
                                                                                
                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" valign="top" align="left"><?php echo ($rwTsRec['VC_REMARKS'][$x] != '') ? nl2br($rwTsRec['VC_REMARKS'][$x]) : '-'; ?></td>
                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" valign="top" align="left">
                                                                                        <?php
                                                                                        if (!empty($rwTsRec['VC_LEAVE'][$x])) {
                                                                                                echo "Yes";
                                                                                        } else {
                                                                                                echo '-';
                                                                                        }
                                                                                        ?>
                                                                                </td>

                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid;" valign="top" align="left">

                                                                                        <?php echo ($rwTsRec['VC_FILE_NAME'][$x] != '') ? str_replace(",", " , ", $rwTsRec['VC_FILE_NAME'][$x]) : '-'; ?>
                                                                                </td>
                                                                                <td style="border-left:#2A1F00 2px solid;border-bottom:#2A1F00 2px solid; border-right:#2A1F00 2px solid;" align="left" valign="top"><?php echo ($rwTsRec['VC_F_R'][$x] != '') ? $rwTsRec['VC_F_R'][$x] : '-'; ?></td>
                                                                        </tr>
                                                                <?php } ?>
                                                        </table>	</td>
                                        </tr>



                                        <tr>
                                                <td colspan="10">

                                                        <table width="29%" border="0"  cellpadding="3" cellspacing="0" style="border:solid 2px; border-color:black;" >
                                                                <tr>
                                                                        <td colspan="10" style="border:#2A1F00 1px solid;"><b>Weekly Summary</b> </td>
                                                                </tr>
                                                                <tr>
                                                                        <td width="58%" style="border:#2A1F00 1px solid;"><b>Total Hours:</b> </td>
                                                                        <td width="42%" colspan="9" style="border:#2A1F00 1px solid;"><?php echo $Function->ConvertTime($totalSecond, true); ?>&nbsp;<?php //echo $rows['TOTHRS'][0];      ?></td>
                                                                </tr>
                                                                <?php if ($type == 'Consolidated' and !empty($_REQUEST['customer'])) { ?>
                                                                        <tr>
                                                                                <td style="border:#2A1F00 1px solid;"><b>Total Week Hours:</b></td>
                                                                                <td colspan="9" style="border:#2A1F00 1px solid;"><?php echo $tothrs1; ?></td>
                                                                        </tr>
                                                                <?php } ?>
                                                                <tr>
                                                                        <td style="border:#2A1F00 1px solid;"><b>Total Forms:</b></td>
                                                                        <td colspan="9" style="border:#2A1F00 1px solid;"><?php echo $rows['TOTFRM'][0]; ?></td>
                                                                </tr>
                                                                <tr>
                                                                        <td style="border:#2A1F00 1px solid;"><b>Total Reports</b> <strong>:</strong></td>
                                                                        <td colspan="9" style="border:#2A1F00 1px solid;"><?php echo $rows['TOTREP'][0]; ?></td>
                                                                </tr>
                                                        </table>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td colspan="10">
                                                        <table width="100%" border="0"  cellpadding="3" cellspacing="0" style="border:solid 2px; border-color:black;" >
                                                                <tr>
                                                                        <td width="17%"  style="border:#2A1F00 1px solid; height:100px; vertical-align:top;"><b>Signature of Engineer:<br/> <br/><br/><br /><center><?php echo $rows['EMP_NAME'][0]; ?></center></b> </td>
                                                                        <td width="25%"  style="border:#2A1F00 1px solid; height:100px; vertical-align:top;"><b>Signature of Customer:</b> </td>
                                                                        <td width="58%" style="border:#2A1F00 1px solid;height:100px; vertical-align:top;"><b>Signature of Project Manager/Chief Manager/General Manager: <br/> <br/><br/><br />
                                                                                        <center>
                                                                                                <?php
                                                                                                if (!empty($rows['MANAGER'][0])) {
                                                                                                        echo $rows['MANAGER'][0];
                                                                                                }
                                                                                                ?>
                                                                                        </center></b>
                                                                        </td>
                                                                </tr>

                                                        </table>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td colspan="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                                <td colspan="10"><b><i>This is system generated timesheet</i></b></td>
                                        </tr>
                                        <tr>
                                                <td colspan="10">
                                                        <table width="100%" border="0"  cellpadding="3" cellspacing="1" >

                                                                <?php if ($emp_dtl[4] != '1') { ?>
                                                                        <tr>
                                                                                <td colspan="10" style="font-size:10px;"><b>Instructions for filling up:</b><br/><br/> </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td  style="font-size:6pt;"><b>Week Start Date:</b> Week start date of every week should be Monday </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td style="font-size:6pt;"><b>Week End Date:</b> Week end date of every week should be Sunday</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td style="font-size:6pt;"><b>Start Time and End Time:</b> Start and end time should be specified in the 24 hours format</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td style="font-size:6pt;"><b>Total hours:</b> Total number of hours worked</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td style="font-size:6pt;"><strong>Program File Name:</strong> File name should be complete along with extention (.fmb/.rdf)</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td style="font-size:6pt;"><strong>Weekly Summary:</strong> It should contain the total number of hours worked, Forms and Reports. If work is done on a requirement for more than one day then CIs (Forms/Reports) for that requirement will be counted only once.</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td style="font-size:6pt;"><strong>F(orm)/R(eport)</strong>: Mention F for Form and R for Report. All CIs other than Reports will be categorised as F(orm).</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td style="font-size:6pt;"><strong>Remarks:</strong> In case of non-coding activities (i.e if the 'Program File Name' column is left blank), the 'Remarks' column should contain the details of the activity. </td>
                                                                        </tr>
                                                                <?php } ?>
                                                        </table></td></tr>
                                        <tr>
                                                <td  colspan="10" align="center"><?php if ($emp_dtl[4] != '1' && $emp_dtl[4] != 0 && $emp_dtl[3] != 1) { ?>
                                                                <input type="button" id="Print" class="taskbutton" name="Add2" value="Print" onClick="javascript:window.open('<?php echo $this->webroot; ?>/timesheet/tsviewmngr/<?php echo $emp_dtl[0] ?>/<?php echo $emp_dtl[1]; ?>/<?php echo $emp_dtl[2] ?>/<?php echo $emp_dtl[3] ?>/1/<?php echo $emp_dtl[5] ?>', '',  'left=2,top=2,titlebar=no,toolbar=no,status=no, width=800 , height=700 , scrollbars=yes');" />&nbsp;
                                            <!--                   <input type="button"  class="taskbutton" name="Back" id="Back"  value="<< Back" onClick="javascript:history.back(-1);"/><?php } ?>
                                                        --></td>

                                        <tr>
                                                <td colspan="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                                <td colspan="10">&nbsp;</td>
                                        </tr>
                                </table>
                        </form>
                </div>

        </div>

</div>

<?php if ($emp_dtl[4] == '1') { ?>
        <script language="javascript">window.print()</script>
<?php } ?>
  



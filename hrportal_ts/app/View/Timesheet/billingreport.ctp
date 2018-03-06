<!-- put this at the top of the page -->
<?php
App::import('Model', 'General');
$General = new General;
App::import('Component', 'Functions');
// We need to load the class
$Function = new FunctionsComponent();
?>
<script type="text/javascript">
    function InvlidEmployee1(id){
        if(document.getElementById("Timesheet_Reportemp_id").value!="" && document.getElementById("Timesheet_Reportemp_name").value==""){
            document.getElementById("Timesheet_Reportemp_id").value="";
            document.getElementById("Timesheet_Reportemp_name").focus();
        }else if(document.getElementById("Timesheet_Reportemp_name").value!="" && document.getElementById("emp_id").value==""){
            document.getElementById("Timesheet_Reportemp_name").focus();
        }
    }
    function InvlidCustomer1(ID , Name){
        if(document.getElementById(ID).value!="" && document.getElementById(Name).value==""){
            document.getElementById(ID).value="";
            document.getElementById(Name).focus();
        }else if(document.getElementById(Name).value!="" && document.getElementById(ID).value==""){
            document.getElementById(Name).focus();
        }
    }

</script>

<script type="text/javascript">
    function check(){
        if (document.getElementById("Timesheet_ReportFromDate").value=="")
        {
            alert("From Date Required !");
            return false;
        }
        if (document.getElementById("Timesheet_ReportToDate").value=="")
        {
            alert("To Date Required !");
            return false;
        }
    }
</script>

<?php echo $form->create('Timesheet_Report', array('url' => array('controller' => 'Timesheet', 'action' => 'billingreport'), 'id' => 'tsreport', 'name' => 'reportForm')); ?>

<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a></li>
            <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li><?php echo $html->link(' Timesheet', $html->url('/selfservices/#timesheet', true)); ?> </li>
            <li>Billing</li>
        </ul>
    </div>
</div>

<h2 class="demoheaders">Billing Report</h2>

<!-- Center Content Starts -->


<div class="travel-voucher">

    <div class="input-boxs"> <?php // pr($datedeail) ; ?>
        <table width="100%" border="0" cellspacing="5" cellpadding="5">
            <tr> <?php //pr($datedeail); ?>
                <th scope="row">From Date :</th>
                <td><input name="from_date" class="textBox"   value="<?php if(!empty($datedeail)){echo $datedeail['from_date']; } ?>" id="from_date" size="20"  maxlength="10" type="text" >
                <script type="text/javascript"> jQuery(function(){jQuery('#from_date').datepicker({ inline: true,changeMonth:true, changeYear:true, dateFormat: 'dd-mm-yy' });});</script></td>

                <th scope="row">To Date :</th>
                <td><input name="to_date"   value="<?php if(!empty($datedeail)){echo $datedeail['to_date']; } ?>" id="to_date"  size="20"  maxlength="10" type="text" class="textBox"  />
                    <script type="text/javascript"> jQuery(function(){jQuery('#to_date').datepicker({ inline: true,changeMonth:true, changeYear:true, dateFormat: 'dd-mm-yy' });});</script></td>

                <th scope="row">Select Region  :</th>
                <td> <select name="region"  id="desg"class="textbox" onChange="javascript:LastFormRecord('task=CustomerDetail&desg_code='+this.value);">
                        <option value="">Select Region</option>
                        <?php for ($i = 0; $i < $num_emp; $i++) { ?>
                            <option value="<?php echo $rwRegion['VC_ZONE'][$i] ?>" <?php if(!empty($datedeail['region'])){ echo ($datedeail['region']== $rwRegion['VC_ZONE'][$i])?'SELECTED':''; } ?>><?php echo $rwRegion['REGION'][$i] ?></option>
                        <?php } ?>
                    </select><td>

            </tr>
            <tr>
                <th scope="row">Customer Name :</th>
                <td valign="top" id='customer1'>
                    <input type="text" value="<?php if(!empty($datedeail['cust_name0'])){ echo $datedeail['cust_name0']; }else{ ''; }?>" id="Timesheet_Reportcust_name" name="cust_name0"  onselectstart='javascript:return false;' value="" onKeyDown="Show1('0','<?php echo $this->webroot . 'Timesheet' ?>');" onBlur="InvlidCustomer1('cust_id' , 'cust_name');"/>
                    <input type="hidden" id="Timesheet_Reportcust_id" name="cust_id0" value="<?php if(!empty($datedeail['cust_id0'])){ echo $datedeail['cust_id0']; }?>" style="font-size: 10px; width: 20px;"  readonly/>
                </td>
        </table>


    </div>

</div>
    <div class="submit-form">
    <?php echo $form->submit('Show Report', array('Show Report', 'onClick' => "return check()")); ?>
                    </div>
<!-- Center Content Ends -->

<?php
                        if ($num_rows == 0) {
?>                              
       <table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
     <tr class="head">
                                                <th>S.No </th>
                                                <th>Employee Name</th>
                                                <th>Total Days</th>
                                                <th>Total Hours</th>
                                                <th>Billing Rate</th>
                                                <th>Total Billable Amount (Rs.)</th>
                                                <th>Actual Billing Amount</th>
                                                <th>Diffrence</th>


                                            </tr>
                                 <tr class="cont">
    <td style="text-align:center;" colspan="8">
    <em>--No Records Found--</em>
    </td>
    </tr></table>
                       
<?php     } else { ?>
                        <h3><font face="Arial;Helvetica"></font> <?php // pr($datedeail); die;  ?>
                                <center>
                                    <font face="Arial;Helvetica">Customer Billing Records <?php if ($_REQUEST['from_date'] != '' && $_REQUEST['to_date'] != '') { ?>for period <?php echo $_REQUEST['from_date'] ?> to <?php echo $_REQUEST['to_date'] ?><?php } ?></font>
                                </center>
                            </h3>
                    <center>
                              <font face="Arial;Helvetica" weight="bold" color="#004282"><b></b></font>
                                <h4><font color="#004282" face="Arial;Helvetica" weight="bold">
                                <?php //if($_REQUEST['bb'] !='' && $_REQUEST['bb'] !=''){?>
<!--                                 <b>Billing Report  for period &nbsp;<?php //echo $_REQUEST['from_date'] ?>&nbsp; and &nbsp;<?php // echo $_REQUEST['from_date'] ?></b>-->
                                <?php // }?>
                        </font></h4>
                   </center>
                <table border="0" width="100%" cellpadding="0" cellspacing="5" >
                    <tr>
                        <td solspan="9"><?php
                            $totRec = count($arrBilling);
                            $OldCust = 0;
                            $custHr = 0;
                            $custPrice = 0;
                            $custDays = 0;
                            $flag = 1;
                            $j = 1;

                            foreach ($arrBilling as $key => $val) {
                                $color = '';
                                $color = ($color == "#EBF1FC") ? '#FFFFFF' : '#EBF1FC';
                                $str_colorChange = ($color == "#EBF1FC") ? "onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#ffffff'\" " : "onmouseover=\"style.backgroundColor='#BFC9F9';\"onmouseout=\"style.backgroundColor='#EBF1FC'\" ";
                                if ($OldCust != $val['cust_id']) {
                                    $OldCust = $val['cust_id'];
            ?>

            <?php if ($flag != 1) {
 ?>
                                    </td>
                                </tr>
                                <tr bgcolor='#FFFFAA'>
                                    <td  align="left"><b>Total</b></td>
                                    <td  align="right" colspan="3"><b><?php echo $custDays; ?></b></td>
                                    <td  align="right" colspan="2"><b><?php echo $Function->ConvertTime($custHr, true); ?></b></td>
                                    <td  align="right" ><b><?php echo number_format($custPrice); ?></b></td>
                                    <td  align="right" colspan="2">&nbsp;</td>
                                </tr>
    <?php
                                        $custHr = 0;
                                        $custPrice = 0;
                                        $j = 1;
                                    }
    ?>
                                </table>


                                        <table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                                            <tr bgcolor='#FFFFAA'>
                                                <td colspan='8'class="tdclass" align='left'><b><font color="#FF0000"><?php echo $val['cust_name'] ?></font></b></td>
                                            </tr>

                                            <tr class="head">
                                                <th>S.No </th>
                                                <th>Employee Name</th>
                                               <th>Designation</th>
                                                <th>Total Days</th>
                                                <th>Total Hours</th>
                                                <th>Billing Rate</th>
                                                <th>Total Billable Amount (Rs.) Actual Billing Amount</th>
                                              
                                                <th>Diffrence</th>


                                            </tr>
            <?php
                                }
                                $custHr +=$val['Time'];
                                $custPrice +=$val['Price'];
                                $custDays += $val['total_days'];
            ?>


                                <tr bgcolor="<?php echo $color; ?>"<?php echo $str_colorChange; ?>>
                                    <td class="tdclass"height="26" nowrap="nowrap"><?php echo $j ?>.</td>
                                   <td class="tdclass"height="26" nowrap="nowrap"> <a  target="_blank" href="empview?empCode=14&fromDate=<?php echo $_REQUEST['from_date'] ?>&toDate=<?php echo $_REQUEST['to_date'] ?>&region=<?php echo $_REQUEST['region'] ?>8&emp_name=<?php echo $val['emp_name'] ?>&emp_id=<?php  echo $val['emp_id'] ?>&custname=<?php echo $val['cust_name'] ?>&custid=<?php echo $val['cust_id'] ?>"><?php echo $val['emp_name'] ?></td>
                                    <td class="tdclass"height="26" nowrap="nowrap" ><?php echo $val['designation'] ?></td>
                                    <td  class="tdclass"align="right"><?php echo $val['total_days'] ?> </td>
                                    <td  class="tdclass"align="right"><?php echo $Function->ConvertTime($val['Time'], true) ?> </td>
                                    <td class="tdclass"nowrap="nowrap"  align="right"><?php echo $val['PriceRate'] ?></td>
                                    <td   class="tdclass"align="right"><?php echo number_format($val['Price']) ?></td>
                                    <td   class="tdclass"align="right">&nbsp;</td>

                                </tr>
<?php if ($flag == $totRec) { ?>
                                    <tr bgcolor='#FFFFAA'>
                                        	   <td></td>
				  <td></td>
			                <td  align="left"><b>Total</b></td>
                        	        <td  align="right" ><b><?php echo $custDays; ?></b></td>
                                        <td></td>
					<td  align="right" ><b><?php echo $Function->ConvertTime($custHr, true); ?></b></td>
                                        <td  align="right"><b><?php echo number_format($custPrice); ?></b></td>
                             	  <td></td>
                                    </tr>

            <?php
                                    $custHr = 0;
                                    $custPrice = 0;
                                }
                                $flag++;
                                $j++;
                            }
            ?>
                            <tr>
                                <td align="Center" Colspan="8">
                                </td>
                            </tr>
                        </table>

         <div class="submit"> <input type="button" name="Print" value="Print" class="taskbutton" onClick="javascript:window.print();"> </div>

        <?php } ?>

<!-- put this code at the bottom of the page -->
<?php
//echo $execution_time;
?>
<?php $form->end(); ?>
    
<script type="text/javascript">
    function Showemployee(id, url) {

        var region=document.getElementById("Timesheet_ReportRegion").value;
        jQuery(document).ready(function(){
            jQuery( "#Timesheet_Reportemp_name").autocomplete({
                source: url+'/autosuggestionbyemp/'+region,
                minLength: 1,
                select: function( event, ui ) {
                    jQuery('#Timesheet_Reportemp_id').attr('value', ui.item.id);
                },
                open: function() {
                    //jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                    //jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            });
            jQuery('#Timesheet_Reportemp_name').change(function(){
                if(jQuery('#Timesheet_Reportemp_name').val().length == 0 )
                    jQuery('#Timesheet_Reportemp_id').attr('value','');
            });

        });
    }
</script>

<script type="text/javascript">
    function Show1(id, url) {

        jQuery(document).ready(function(){
            jQuery( "#Timesheet_Reportcust_name").autocomplete({
                source: url+'/autosuggestion',
                minLength: 2,
                select: function( event, ui ) {
                    jQuery('#Timesheet_Reportcust_id').attr('value', ui.item.id);
                },
                open: function() {
                    //jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                    //jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            });
            jQuery('#Timesheet_Reportcust_name').change(function(){
                if(jQuery('#Timesheet_Reportcust_name').val().length == 0 )
                    jQuery('#Timesheet_Reportcust_id').attr('value','');
            });

        });
    }
</script>
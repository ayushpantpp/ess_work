<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#trvoucher").validate();
    });

</script>
<script type="text/javascript">
    
    function tot_allow()
    {
        var per_day_amt= jQuery('#daily_amt').val();
        var tot_days= jQuery('#daily_days').val();
        var total_daily_allow=tot_days*per_day_amt;
        jQuery('#VoucherDailyAllowDays').val(total_daily_allow);

	calTotal();

    }
     /* Total Amount In Travel */
    function calTotal()
    {
        var ticket_book=jQuery('#VoucherBookedAmt').val();
        var convayence_amt=jQuery('#VoucherConveyenceAmt').val();
        var hotel_exp_amt=jQuery('#VoucherHotelStayExpense').val();
        var voucher_mesicelleneous_amt=jQuery('#VoucherMiscellaneousExpDuringTravil').val();
        var voucher_telephone_exp_amt=jQuery('#VoucherTelephoneExpense').val();
        var voucher_bp_exp_amt=jQuery('#VoucherExpenseIncurredTravel').val();
        var voucher_another_exp_amt=jQuery('#VoucherAnotherExpense').val();
        var voucher_daily_allows_amt=jQuery('#VoucherDailyAllowDays').val();
        total=ticket_book*1+convayence_amt*1+hotel_exp_amt*1+voucher_mesicelleneous_amt*1+voucher_telephone_exp_amt*1+voucher_bp_exp_amt*1+voucher_another_exp_amt*1+voucher_daily_allows_amt*1;
        var total_exp=jQuery('#VoucherTotalExpenseIncurred').val(total);
        var other_total_exp=jQuery('#VoucherOtherTotalExpnse').val(total);

	var advntak=jQuery('#VoucherAdvanceTakenExpnse').val();
        var other_total_exp12=jQuery('#VoucherBalanceAmtPaid').val(total-advntak);

    }


    /* Support only . and digits only  */
    function checkIt(evt) {
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)&& (charCode !=45) && (charCode !=46)) {
            return false
        }
        return true
    }

 /* Total Amount */
    function calNet()
    {
      
        var advance_taken_antother_mem=jQuery("#VoucherAdvanceTakenEmployee").val();
      
        var tot_expense=jQuery("#VoucherOtherTotalExpnse").val();
        net=tot_expense*1-(advance_taken_antother_mem*1)
        if(net > 0)
        {
            jQuery("#VoucherBalanceAmtPaid").val(net);
            jQuery("#VoucherAmountReturnHeadOffice").val(0);
        }
        else
        {
            jQuery("#VoucherAmountReturnHeadOffice").val(Math.abs(net));
             jQuery("#VoucherBalanceAmtPaid").val(0);
        }
    }

</script>


<?php echo $this->Form->create('Voucher', array('url' => array('controller' => 'travels', 'action' => 'editaccountvoucher'), 'id' => 'trvoucher' , 'name' => 'trvoucher','autocomplete'=>'off')); ?>
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                   <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>
           <li><?php echo $this->Html->link('Self Services', $this->Html->url('/#', true)); ?> </li>
           <li><?php echo $this->Html->link('Travel Voucher', $this->Html->url('/#', true)); ?> </li>
           <li>Travel Expense Report :</li>
        </ul>
    </div>
</div>
 

<h2 class="demoheaders"> Edit</h2>


<div class="travel-voucher">
<div class="input-boxs">
<table width="98%" border="0" cellspacing="5" cellpadding="0" style="margin:0px auto;">
<tr>
    <td align="right"><b>Name :</b></td>
    <td><?php echo $empdetail[3]; ?></td>
    <td align="right"><b>Places to Visit :</b></td>
    <td><?php echo ucwords((strtolower($approval_detail['Travel']['vc_visit_place']))); ?> </td>
    <td align="right"><b>Tour Start Date :</td>
    <td><?php echo $empdetail[4]; ?> </td>
     <td align="right"><b>By :</b></td>
    <td >
        <?php echo $approval_detail['Travel']['vc_sttravel_mode']; ?>
        <strong><label>Time :</label></strong>
         <?php echo date("H:i",  strtotime($approval_detail[0]['dt_start_time'])); ?>
    </td>
</tr>
<tr>
    <td align="right"><b>Designation :</b></td> 
    <td><?php echo ucwords((strtolower($approval_detail['Travelmain']['vc_emp_desg']))); ?></td>
    <td align="right"><b>Department :</b></td>
    <td><?php echo ucwords((strtolower($approval_detail['Travelmain']['vc_dept_name']))); ?></td>
    <td align="right"><b>Tour End Date :</b></td>
    <td><?php echo $empdetail[5]; ?> </td>
    <td align="right"><b>By :</b></td>
    <td ><?php echo $approval_detail['Travel']['vc_edtravel_mode']; ?><strong><label>Time : </label></strong>
        <?php echo date("H:i",  strtotime($approval_detail[0]['dt_end_time'])); ?>
    </td>
</tr>
</table>
</div>
</div>

<div class="travel-voucher1">
    <div class="input-boxs">

        <table width="80%" border="0" cellspacing="5" cellpadding="0" style="margin:0px auto;">
            <tr>
                <td align="right">Expense Incurred On :</td>
                <td>Amount(in Rs.)</td> <td></td>
            </tr>
             
            <tr>
                <td align="right">Ticket Booked By self :</td>
                <td colspan="3"><?php echo $this->Form->input('Voucher.Booked_amt', array('label' => false, 'type' => 'text', 'class' => 'round', 'onKeyup' => 'calTotal()', 'value' => $approval_detail['Travel']['nu_ticket_amount'])); ?></td><td></td>
            </tr>
            <tr>
                <td align="right">Local Conveyence During Travel Period :</td>
                <td><?php echo $this->Form->input('Voucher.Conveyence_amt', array('label' => false, 'type' => 'text', 'class' => 'round','onKeyup' => 'calTotal()', 'value'=> $approval_detail['Travel']['nu_conv_expense'])); ?></td><td></td>
             </tr>
            <tr> <?php  @$rate=$approval_detail['Travel']['nu_total_allowance']/$approval_detail['Travel']['nu_hotel_stay'] ; ?>
                <td align="right">Daily Allowance For<input type="text" id="daily_days"  style="float:none; width:35px;" name="data[Voucher][days]" class ="round" , value= <?php echo $approval_detail['Travel']['nu_hotel_stay'];?> /> Days @<input type="text" id="daily_amt" style="float:none; width:35px;"  onkeyup="tot_allow()" class ="round" name="data[Voucher][daily_amt]"  value = <?php echo $rate; ?> /> per Day :</td>
                <td><?php echo $this->Form->input('Voucher.Daily_allow_days', array('label' => false, 'class' => 'round', 'readonly' => 'readonly', 'type' => 'text' , 'value'=> $approval_detail['Travel']['nu_total_allowance'])); ?></td><td></td>

            </tr>
            <tr>
                <td align="right">Hotel Stay Expense :</td>
                <td><?php echo $this->Form->input('Voucher.Hotel_stay_expense', array('label' => false, 'type' => 'text', 'class' => 'round','onKeyup' => 'calTotal()' , 'value'=>$approval_detail['Travel']['nu_hotel_expense'])); ?></td><td></td>
            </tr>
            <tr>
                <td align="right">Miscellaneous Expense Incurred During Travel Period :</td>
                <td><?php echo $this->Form->input('Voucher.Miscellaneous_exp_during_travil', array('label' => false, 'type' => 'text', 'class' => 'round','onKeyup' => 'calTotal()' , 'value'=>$approval_detail['Travel']['nu_misc_expense'])); ?></td><td></td>
              </tr>
            <tr>
                <td align="right">Telephone Expense :</td>
                <td><?php echo $this->Form->input('Voucher.Telephone_expense', array('label' => false, 'type' => 'text', 'class' => 'round','onKeyup' => 'calTotal()' , 'value'=>$approval_detail['Travel']['nu_tele_expense'])); ?></td><td></td>
            </tr>
            <tr>
                <td align="right">Expense Incurred For Client/B.P. During Travel :</td>
                <td><?php echo $this->Form->input('Voucher.Expense_incurred_travel', array('label' => false, 'type' => 'text', 'class' => 'round','onKeyup' => 'calTotal()' , 'value'=>$approval_detail['Travel']['nu_client_expense'])); ?></td><td></td>
            </tr>
            <tr>
                <td align="right">Any Other Expense :</td>
                <td><?php echo $this->Form->input('Voucher.Another_expense', array('label' => false, 'type' => 'text', 'class' => 'round','onKeyup' => 'calTotal()' , 'value'=>$approval_detail['Travel']['nu_other_expense'])); ?></td><td></td>
            </tr>
            <tr>
                <td align="right">Total Expense Incurred During Travel Period :</td>
                <td><?php echo $this->Form->input('Voucher.Total_expense_incurred', array('label' => false, 'type' => 'text', 'class' => 'round', 'readonly' => 'readonly','onKeyup' => 'calTotal()' , 'value'=>$approval_detail['Travel']['nu_total_expense'])); ?></td><td width="20%"></td>
            </tr>
                                 <tr>
                <td align="right">Advance Taken :</td>
                <td><?php echo $this->Form->input('Voucher.advance_taken_expnse', array('label' => false, 'type' => 'text', 'class' => 'round','readonly'=>'readonly', 'value'=>$approval_detail['Travel']['nu_other_advance'])); ?></td><td></td>
            </tr>
            <tr>
                <td align="right">Balance Amount to be Paid to Employee :</td>
                <td><?php echo $this->Form->input('Voucher.Balance_amt_paid', array('label' => false, 'type' => 'text', 'class' => 'round', 'value'=> $approval_detail['Travelmain']['nu_balance_amount'])); ?></td><td></td>
            </tr>
            <tr>
                <td align="right">Amount To Be Returned To Head Office :</td>
                <td><?php echo $this->Form->input('Voucher.Amount_return_head_office', array('label' => false, 'type' => 'text', 'class' => 'round' , 'value'=>$approval_detail['Travelmain']['nu_return_amount'])); ?></td><td></td>
            </tr>
        </table>
    </div>
</div>



       


    <div class="travel-voucher">

            <div class="input-boxs">
 <?php $getlvl = $this->Common->getlevelbytvid($approval_detail['Travelmain']['vc_voucher_no']);?>
                <table width="90%" border="0" cellspacing="5" cellpadding="0" style="margin:0px auto;">
                    <tr class="cont1">
                        <td width="100%" colspan="3">
                            <table width="100%">
                                <tr>
                                    <?php
                                    $i = 0;
                                    foreach ($getlvl as $v) {
                                        ?>
                                        <td>
                                            <strong><?php echo "Level-" . $i; ?></strong> <br/>
                                            <strong>
                                                <?php echo $this->Common->getempinfo($v['TravelWfLvl']['emp_code']); ?> 
                                            </strong> <br/>
                                            <strong>
                                                <?php
                                                if (!empty($v['TravelWfLvl']['fw_date'])) {
                                                    echo date('d-M-Y', strtotime($v['TravelWfLvl']['fw_date']));
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?>
                                            </strong>
                                        </td>
            <?php
            $i++;
        }
        ?>
                                <tr>
                            </table>
                        </td>
                    </tr>
                   
                 

                    
             </table>
  </div>
 </div>
 <input type="hidden" name="compCode" value=<?php echo $empdetail[0] ?> />
                            <input type="hidden" name="vouchNo" value=<?php echo $empdetail[1] ?> />
                            <input type="hidden" name="stDate" value=<?php echo $empdetail[4] ?> />
                            <input type="hidden" name="edDate" value=<?php echo $empdetail[5] ?> />
                            <input type="hidden" size="12" name="advAmount" value="<?php echo $approval_detail['Travel']['nu_other_advance'];?>"  />
<input type="hidden" name="vStatus" value="8">
     <div class="submit-form"><input type="submit"  name="trExpRpAp" value="Update Record"/> </div>
      <!-- Center Content Ends -->
<?php $this->Form->end(); ?>
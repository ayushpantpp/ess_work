
<!--View for the modal box-->
<?php $i = 1; ?>
<h3>Conveyance Expense Detail</h3>
<table class="uk-table uk-table-bordered">
    <thead>
        <tr>
            <th>Sr.No </th>
            <th>ID</th>
            <th>Mode</th>
            <th>Type</th>
            <th>From</th>
            <th>To</th>
            <th>Misc Amount</th>
            <th>Misc Description</th>
            <th>Distance</th>
            <th>Travel Expenses</th>
            <th>Total</th>
            <th>Claim Date</th>
            <th>Voucher Date</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>

        <?php if (empty($cdetails)) { ?>
            <tr class="even pointer">
                <td colspan="5">
                    <span class="uk-text-italic">--No Records Found--</span>
                </td>
            </tr>
        <?php } ?>
        <?php
        $tot_dist = 0; $tot_amt = 0;
        foreach ($cdetails as $cdetail) {
        $tot_dist+=$cdetail['ConveyencExpenseDetail']['distance'];   
        $tot_amt+=$cdetail['ConveyencExpenseDetail']['total_exp'];
        $tot_misc+=$cdetail['ConveyencExpenseDetail']['miscl_exp'];?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $cdetail['ConveyencExpenseDetail']['voucher_id']; ?></td>
                <td><?php echo $this->Common->getConveyenceTravelModeById($cdetail['ConveyencExpenseDetail']['travel_mode']); ?></td>
                <td><?php if($cdetail['ConveyencExpenseDetail']['wheeler_type'] == "1"){ echo "Personal"; }else{ echo "Commercial"; } ?></td>		
                <td><?php echo $cdetail['ConveyencExpenseDetail']['from_place'] ?></td>      		
                <td><?php echo $cdetail['ConveyencExpenseDetail']['to_place'];?></td>
                <td><?php echo $cdetail['ConveyencExpenseDetail']['miscl_exp'];?></td>
                <td><?php echo $cdetail['ConveyencExpenseDetail']['miscl_exp_desc'];?></td>
                <td><?php echo $cdetail['ConveyencExpenseDetail']['distance']."Km";?></td>
                <td><?php echo $cdetail['ConveyencExpenseDetail']['travel_exp'];?></td>
                <td><?php echo $cdetail['ConveyencExpenseDetail']['total_exp'];?></td>
                <td><?php echo date('d-m-Y', strtotime($cdetail['ConveyencExpenseDetail']['claim_date']));?></td>
                <td><?php echo date('d-m-Y', strtotime($cdetail['ConveyencExpenseDetail']['created_on']));?></td>
                <td><?php echo $cdetail['ConveyencExpenseDetail']['remark'];?></td>
                
            </tr>
<?php } ?>
        <tr>
            <td colspan="6" style="text-align:right;">
                <strong >Total Misc:</strong>
            </td>
            <td><strong><?php echo $tot_misc; ?></strong></td>
           
             <td colspan="1" style="text-align:right;">
                <strong >Total Distance:</strong>
            </td>
            <td><strong><?php echo $tot_dist.'KM'; ?></strong></td>
            <td colspan="1" style="text-align:right;">
                <strong >Total Amount:</strong>
            </td>
            <td><strong><?php echo $tot_amt; ?></strong></td>
   
   
            </tr>


    </tbody>

    

</table>



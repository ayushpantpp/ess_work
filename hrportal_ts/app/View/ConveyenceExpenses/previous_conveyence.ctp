   
<?php $i = 1; ?>
<h2>Previous Expense Voucher </h2>
<table class="uk-table uk-table-bordered">
    <thead>
        <tr class="headings">

            <th>Sr.No </th>
            <th>Voucher ID </th>
            <th>Travel Mode</th>
            <th>Wheeler Type</th>
            <th>From Place</th>
            <th>To Place</th>
            <th>Miscellaneous expenses</th>
            <th>Misc. exp description</th>
            <th>Distance</th>
            <th>Travel Expenses</th>
            <th>Total Expenses</th>
            <th>Claim Date</th>
            <th>Voucher Date</th>


        </tr>
    </thead>
    <tbody>

        <?php if (empty($previous)) { ?>
            <tr class="even pointer">
                <td style="text-align:center;" colspan="11">
                    <em>--No Records Found--</em>
                </td>
            </tr>
        <?php } ?>

        <?php foreach ($previous as $cdetail) {
            if ($i % 2 == 0)
                $class = 'even pointer';
            else
                $class = 'odd pointer';
            ?>
            <tr class="even pointer">
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
            </tr>
    <?php $i++;
} ?>
    </tbody>
</table>


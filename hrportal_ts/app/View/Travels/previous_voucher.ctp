<script>
    jQuery(document).ready(function () {
        $('#alerts').hide;

    });
    function Get_Previous(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>travels/copyprevious/' + id,
            success: function (data) {

                var obj = jQuery.parseJSON(data);

                $.each(obj, function (key, value) {

                    $('#VoucherPlaceVisit').val(value.DtTravelVoucher.place_visit);
                    var $datepicker = $("#VoucherTourStartDate");
                    $datepicker.datepicker();
                    $datepicker.datepicker('setDate', new Date(value.DtTravelVoucher.tour_start_date));
                    var $enddatepicker = $("#VoucherTourEndDate");
                    $enddatepicker.datepicker();
                    $enddatepicker.datepicker('setDate', new Date(value.DtTravelVoucher.tour_end_date));
                    $('#VoucherEmpDepartment').val(value.DtTravelVoucher.dept);
                    $('#VoucherGoingBy').val(value.DtTravelVoucher.start_mode);
                    $('#VoucherComingBy').val(value.DtTravelVoucher.end_mode);
                    $('#Daily_allow_days').val(value.DtTravelVoucher.Daily_allow_days);
                    $('#VoucherDailyAllowDays').val(value.DtTravelVoucher.da);
                    $('#VoucherConveyenceAmt').val(value.DtTravelVoucher.conv_expense);
                    $('#VoucherDetailLocalConceyence').val(value.DtTravelVoucher.conv_details);
                    $('#VoucherBookedAmt').val(value.DtTravelVoucher.ticket_amount);
                    $('#VoucherTelephoneExpense').val(value.DtTravelVoucher.telephone_exp);
                    $('#VoucherExpenseIncurredTravel').val(value.DtTravelVoucher.client_exp);
                    $('#VoucherAnotherExpense').val(value.DtTravelVoucher.other_exp);
                    $('#VoucherPlaceVisit').val(value.DtTravelVoucher.place_visit);
                    $('#daily_days').val(value.DtTravelVoucher.days);
                    $('#VoucherMiscellaneousExpDuringTravil').val(value.DtTravelVoucher.miscellaneous_exp);
                    $('#VoucherDetailMiscellaneousExp').val(value.DtTravelVoucher.miscellaneous_details);
                    $('#VoucherHotelStayExpense').val(value.DtTravelVoucher.hotel_stay);
                    $('#VoucherBalanceAmtPaid').val(value.DtTravelVoucher.return_amount);
                    $('#VoucherTotalExpenseIncurred').val(value.DtTravelVoucher.pending_amount);
                    $('#VoucherAdvanceTakenEmployee').val(value.DtTravelVoucher.adv_amount);
                    $('#VoucherOtherEmployeeName').val(value.DtTravelVoucher.empadv_name);
                    $('#VoucherAmountReturnHeadOffice').val(value.DtTravelVoucher.return_amount);
                });
                $('#popup1').remove();

            }
        });
    }


</script>	

<?php $i = 0; ?>



<h3>Travel Voucher </h3>
<table class="uk-table uk-table-bordered">
    <thead>
        <tr>

            <th>Sr.No </th>
            <th>Employee Name </th>
            <th>Place Visit</th>
            <th>Tour start Date </th>
            <th>By </th>
            <th>Tour End Date </th>
            <th>By</th>
            <th>Daily Allowance For </th>
           <!-- <th> Action</th>-->
        </tr>
    </thead>
    <tbody>

        <?php if (empty($travellist)) { ?>
            <tr class="even pointer">
                <td style="text-align:center;" colspan="11">
                    <em>--No Records Found--</em>
                </td>
            </tr>
        <?php } ?>

        <?php foreach ($travellist as $srcdet) {
            if ($i % 2 == 0)
                $class = 'even pointer';
            else
                $class = 'odd pointer';
            ?>
            <tr class="even pointer">
                <td><?php echo $i + 1; //echo $srcdet['MstEmpExpVoucher']['voucher_id']; ?></td> 

                <td><?php echo $this->Common->getempinfo($srcdet['DtTravelVoucher']['emp_code']); ?></td>
                <td><?php echo $srcdet['DtTravelVoucher']['place_visit']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($srcdet['DtTravelVoucher']['tour_start_date'])); ?></td>
                <td><?php echo $this->Common->findtravelamt($srcdet['DtTravelVoucher']['start_mode']); ?></td>
                <td><?php echo date('d-m-Y', strtotime($srcdet['DtTravelVoucher']['tour_end_date'])); ?></td>
                <td><?php echo $this->Common->findtravelamt($srcdet['DtTravelVoucher']['end_mode']); ?></td>
                <td><?php echo $srcdet['DtTravelVoucher']['da']; ?></td>
              <!--  <td>

                    <a href="#popup1" class="uk-badge uk-badge-success" onclick="Get_Previous('<?php echo $srcdet['DtTravelVoucher']['voucher_id']; ?>')" id ='copy[<?php echo $i ?>]' title="Click to copy.">copy</a>

                </td>-->
            </tr>
        <?php $i++;
    } ?>
    </tbody>
</table>
<div class="navigation navigation-left" >
<?php echo $this->Paginator->counter(); ?> Pages
<?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>
<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
</div>

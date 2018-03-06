   <script>
jQuery(document).ready(function(){
    $('#alerts').hide;
    	
}); 

</script>
<?php $i = 0; if($travellist){?>
<h2>Previous Expense Voucher </h2>
<table class="uk-table uk-table-bordered">
    <thead>
        <tr class="headings">

            <th ><b>Sr.No</b> </th>
            <th><b>Employee Name</b> </th>
            <th ><b>Place Visit</b></th>
            <th ><b>Tour start Date</b> </th>
            <th ><b>Tour End Date</b> </th>
            <th ><b>Total Amount</b> </th>


        </tr>
    </thead>
    <tbody>

        <tbody>

             <?php if(empty($travellist)) { ?>
                <tr class="even pointer">
                  <td style="text-align:center;" colspan="11">
                     <em>--No Records Found--</em>
                 </td>
                </tr>
              <?php } ?>

             <?php foreach($travellist as $srcdet){
               if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
               <tr class="even pointer">
                <td><?php echo $i+1;//echo $srcdet['MstEmpExpVoucher']['voucher_id'];?></td> 
                <td><?php echo $this->Common->getempinfo($srcdet['DtTravelVoucher']['emp_code']); ?></td>
                <td><?php echo $srcdet['DtTravelVoucher']['place_visit']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($srcdet['DtTravelVoucher']['tour_start_date']));?></td>
                <td><?php echo date('d-m-Y', strtotime($srcdet['DtTravelVoucher']['tour_end_date']));?></td>
                <td><?php if($srcdet['DtTravelVoucher']['return_amount']>0){
                    echo "-".$srcdet['DtTravelVoucher']['return_amount'];
                }else{
                    echo $srcdet['DtTravelVoucher']['pending_amount'];
                } ?></td>
              </tr>
             <?php $i++ ;} ?>
            </tbody>
    </tbody>
</table>

<div class="navigation navigation-left" >
     <?php echo $this->Paginator->counter(); ?> Pages
     <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
     <?php echo $this->Paginator->numbers(); ?>
     <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div>
<?php } else {?>
<p class='PendingLeave'>No previous Travel Voucher<p>
<?php } ?>

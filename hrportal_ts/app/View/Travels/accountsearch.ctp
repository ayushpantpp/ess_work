<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
             <li>
                <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>


           <li><?php echo $this->Html->link('Self Services', $this->Html->url('/#', true)); ?> </li>
          <li><?php echo $this->Html->link('Travel Voucher', $this->Html->url('/#', true)); ?> </li>
            
        </ul>
    </div>
</div>

<h2 class="demoheaders">Travel Expense Report Query Form </h2>
<script type="text/javascript">
  
</script>


        <div class="travel-voucher">

            <div class="input-boxs">
<?php echo $this->Form->create('Account_Voucher', array('url' => array('controller' => 'travels', 'action' => 'accountapproval'), 'id' => 'trvoucher')); ?>

                <table width="100%" border="0" cellspacing="5" cellpadding="5">
                    <tr>
                        <th scope="row">Tour Start Date :</th>
                        <td><?php echo $this->Form->input('Account_Voucher.from_date', array('label' => false, 'type' => 'text', 'class' => 'required')); ?>
                            <script type="text/javascript"> jQuery(function(){jQuery('#Account_VoucherFromDate').datepicker({ inline: true, changeMonth:true, changeYear:true,dateFormat: 'dd-mm-yy' });});</script></td>
               </tr>
                    <tr>
                        <th scope="row">Tour End Date :</th>
                        <td><?php echo $this->Form->input('Account_Voucher.to_date', array('label' => false, 'type' => 'text', 'class' => 'required')); ?>
                            <script type="text/javascript"> jQuery(function(){jQuery('#Account_VoucherToDate').datepicker({ inline: true, changeMonth:true, changeYear:true,dateFormat: 'dd-mm-yy'});});</script></td>

                  </tr>
 <tr>
 <?php $sort_record_by = array('Vc_Emp_Name' => 'Employee Name', 'Dt_App_Date' => 'Voucher Date', 'Ch_Vouch_Status' => 'Voucher Status') ?>

    <td align="right"><b>Sort Records By&nbsp;:</b></td>
    <td>
   <?php echo $this->Form->input('Account_Voucher.sort', array('type' => 'select', 'label' => false,  'options' => $sort_record_by, 'class' => 'required', 'class' => 'required')); ?>

    </td>
   </tr>
   <tr>
 <?php $sort_record_by = array('5' => 'Sanctioned Status', '8' => 'Checked Status', '6' => 'Paid Status','7' => 'Verified Status') ?>


    <td align="right"><b>Show Vouchers with&nbsp;:</b></td>
    <td><?php echo $this->Form->input('Account_Voucher.status', array('type' => 'select', 'label' => false,'options' => $sort_record_by, 'class' => 'required', 'class' => 'required')); ?>

    </td>
   </tr>
                    

                </table>
                    </div>

        </div>
        <div class="submit-form"><?php echo $this->Form->submit('Display', array('Display')); ?></div>
        




   



    <!-- Center Content Ends -->




<?php $this->Form->end(); ?>
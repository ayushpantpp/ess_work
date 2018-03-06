
<?php echo $form->create('Voucher', array('url' => array('controller' => 'travels', 'action' => 'editaccountvoucher'), 'id' => 'trvoucher' , 'name' => 'trvoucher')); ?>

<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
         <li>
                <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>


           <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
          <li><?php echo $html->link('Travel Voucher', $html->url('/selfservices/#travel', true)); ?> </li>

              <li>Travel Expense Report Query Form </li>




        </ul>
    </div>
</div>
   <h2 class="demoheaders">Travel Expense Report Form : <?php echo  $voucher_no;  ?> </h2>

        <div class="travel-voucher">

            <div class="input-boxs">

                <table width="100%" border="0" cellspacing="5" cellpadding="5">
                    <tr>
                        <th scope="row" width="30%">Name :</th>
                        <td><?php echo $all_approval_emp_detail[0][0]['vc_emp_name']; ?></td>
                        <th scope="row">Designation :</th>
                        <td><?php echo ucwords((strtolower($all_approval_emp_detail[0][0]['vc_emp_desg']))); ?></td>
                    </tr>
<?php $department = array('Products' => 'Products', 'Projects' => 'Projects', 'Finance' => 'Finance', 'HR and Admin' => 'HR and Admin', 'Marketing' => 'Marketing', 'Quality Assurance' => 'Quality Assurance') ?>
                    <tr>
                        <th scope="row">Places to Visit :</th>
                 <td><?php echo ucwords((strtolower($all_approval_emp_detail[0][0]['vc_visit_place']))); ?> </td>
                        <th scope="row">Department :</th>
                        <td><?php echo ucwords((strtolower($all_approval_emp_detail[0][0]['vc_dept_name']))); ?></td>
                    </tr>


                    
                   <tr>
                        <th scope="row">Tour Start Date :</th>
                        <td><?php echo $empdatail[2]; ?> </td>
                        
                        <th scope="row">By :</th>
                        <td colspan="2"><?php echo $all_approval_emp_detail[0][0]['vc_sttravel_mode']; ?>
                    <strong><label>
                         Time :</label></strong> <?php echo date('H:i',strtotime($all_approval_emp_detail[0][0]['dt_start_time'])); ?>
                     </td>
                  
                    </tr>


                    <tr>
                        <th scope="row">Tour End Date :</th>
                        <td><?php  echo $empdatail[3]; ?> </td>

                         <th scope="row">By :</th>

                        <td colspan="2"><?php echo $all_approval_emp_detail[0][0]['vc_edtravel_mode']; ?><strong><label>

                            Time : </label></strong><?php echo date('H:i',strtotime($all_approval_emp_detail[0][0]['dt_end_time'])); ?>
                            </td>

                     
                    </tr>
                  
                </table>

            </div>

        </div>

        <div class="travel-voucher1">
            <div class="input-boxs">

                <table width="100%" border="0" cellspacing="5" cellpadding="5">
                    <tr>
                        <th scope="row" width="30%">Expense Incurred On :</th>
                        <td width="20%">Amount (in Rs.)</td>
                        <th scope="row" width="37%">Miscellaneous Expense Incurred During Travel Period :</th>
                        <td><?php echo $all_approval_emp_detail[0][0]['nu_misc_expense']; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Ticket Booked By self :</th>
                        <td><?php echo $all_approval_emp_detail[0][0]['nu_ticket_amount']; ?></td>
                        <th scope="row">Telephone Expense :</th>
                        <td><?php echo $all_approval_emp_detail[0][0]['nu_tele_expense']; ?></td>

                    </tr>
                    <tr>
                        <th scope="row">Local Conveyence During Travel Period :</th>
                        <td><?php echo $all_approval_emp_detail[0][0]['nu_conv_expense']; ?></td>
                        <th scope="row">Expense Incurred For Client/B.P. During Travel :</th>
                        <td><?php echo $all_approval_emp_detail[0][0]['nu_client_expense']; ?></td>
                     </tr>
                    <tr> <?php  @$rate=$all_approval_emp_detail[0][0]['nu_total_allowance']/$all_approval_emp_detail [0][0]['nu_hotel_stay'] ; ?>
                        <th scope="row">Daily Allowance For <?php echo $all_approval_emp_detail[0][0]['nu_hotel_stay'];?>  Days @ <?php echo $rate; ?>  per Day :</th>
                        <td><?php echo  $all_approval_emp_detail[0][0]['nu_total_allowance']; ?></td>
                        <th scope="row">Any Other Expense :</th>
                        <td><?php echo $all_approval_emp_detail[0][0]['nu_other_expense']; ?></td>


                    </tr>
                    <tr>
                        <th scope="row">Hotel Stay Expense :</th>
                        <td><?php echo $all_approval_emp_detail[0][0]['nu_hotel_expense']; ?></td>
                        <th scope="row">Total Expense Incurred During Travel Period :</th>
                        <td><?php echo $all_approval_emp_detail[0][0]['nu_total_expense']; ?></td>

                    </tr>
                   
                </table>


            </div>

        </div>



        <div class="travel-voucher1">
            <div class="input-boxs">

                <table width="100%" border="0" cellspacing="5" cellpadding="5">
             
                     <tr>
                   <th scope="row" width="30%" valign="top">Tour Advance Taken From Head Office:</th>
                    <td width="20%" valign="top"><?php echo $all_approval_emp_detail[0][0]['nu_advance']; ?></td>
                     
                       <th scope="row" width="37%" valign="top">Advance Taken From Another Employee During Travel:</tth>

                      <td valign="top"><?php echo $all_approval_emp_detail[0][0]['nu_other_advance']; ?></td>
                     </tr>
                       <tr>
                       <th scope="row" valign="top">Name Of The Employee (*required if advance taken ):</th>

                      <td valign="top"><?php echo $all_approval_emp_detail[0][0]['vc_empadv_name']; ?></td>
                        <th scope="row" valign="top">Total Expense Incurred During Travel Period :</th>
                         <td valign="top"><?php echo $all_approval_emp_detail[0][0]['nu_total_expense']; ?></td>
                    </tr>
                    <tr>
                           <th scope="row" valign="top">Balance Amount to be Paid to Employee :</th>
                       <td valign="top"> <?php echo $all_approval_emp_detail[0][0]['nu_balance_amount']; ?></td>
                     <th scope="row" valign="top">Amount To Be Returned To Head Office :</th>
                     <td valign="top"><?php echo $all_approval_emp_detail[0][0]['nu_return_amount']; ?></td>
                    </tr>

               
                </table>
            </div>
        </div>


    <div class="travel-voucher">

            <div class="input-boxs">

                <table width="100%" border="0" cellspacing="5" cellpadding="5">

                    <tr>
                        <td><strong>Traveler's</strong></td>
                        <td><strong>Approved By</strong></td>
                          <td><strong>Sanctioned By</strong></td>
                   </tr> 
                  <tr>
                         <td><?php echo $all_approval_emp_detail[0][0]['dt_app_date']; ?></td>
                         <td><?php echo $all_approval_emp_detail[0][0]['dt_approve_date']; ?> </td>
                         <td><?php echo $all_approval_emp_detail[0][0]['dt_sanction_date']; ?> </td>
                       
                    </tr>

                    <tr>
                        <td><?php echo $all_approval_emp_detail[0][0]['vc_emp_name']; ?></td>
                        <td><?php echo $all_approval_emp_detail[0][0]['Mgr']; ?></td>
<?php 
if($all_approval_emp_detail[0][0]['Mgr']!="ANIL BAKHT")
{
?>
 <td>SANJAY AGARWALA</td>
<?php
}
else
{
?>
 <td><?php echo $all_approval_emp_detail[0][0]['Mgr']; ?></td>
<?php
}
?>

                     

                </table>

            </div>

        </div>






         <div class="travel-voucher">

            <div class="input-boxs">

                <table width="100%" border="0" cellspacing="5" cellpadding="5">

                    <tr>
                        <td><strong>Checked By</strong></td>
                        <td><strong>Re Checked By</strong></td>
                          <td><strong>Received By</strong></td>
                          <td><strong>JV Date</strong></td>

                   </tr>
      
                </table>

            </div>

        </div>


         <div class="travel-voucher">

            <div class="input-boxs">

                <table width="100%" border="0" cellspacing="5" cellpadding="5">

                    <tr>
                        <td><strong>Conveyence Details</strong></td>
                        <td><strong>Misc Details</strong></td>
                         
                   </tr>
                  <tr> <?php //pr($all_approval_emp_detail); die; ?>
                         <td><?php echo $all_approval_emp_detail[0][0]['conv']; ?></td>
                         <td><?php echo $all_approval_emp_detail[0][0]['misc']; ?> </td>
                         

                    </tr>

                </table>

            </div>

        </div>



                          

    <!-- Center Content Ends -->





<?php $form->end(); ?>
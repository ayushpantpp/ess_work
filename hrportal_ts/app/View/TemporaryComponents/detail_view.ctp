<style>
    .ForwardLeave{  color: #329ACF; font-weight:bold;}
    .PendingLeave{ color: #DF8040; font-weight:bold;}
    .RejectedLeave{ color: #CC0001; font-weight:bold;}
    .OpenLeave{ color: #00f303; font-weight:bold;}
    .ApprovedLeave{ color: #006300; font-weight:bold;}
    .RevertdLeave{ color: #9804F0; font-weight:bold;}
</style>

<?php $i=0; ?>    
      
            <h3 style="margin-top:0px">Temporary Amount Claim Details ( <span><?php  echo $emp_name;?> <span> </span><span><?php echo $lastname;?></span> - <span><?php echo $emp_id; ?></span></span>) </h3>
         
    <div class="x_content">
        <div class="table-responsive">
            <table class="uk-table uk-table-bordered">
                <thead>
                <tr>
                  <th>Sr.No</th>                  
                  <th>Temporary Component</th>
                  <th>Claim Date</th>
                  <th>Status</th>
                  <th width="120">Actual Amount</th>
                  <th width="120">Attached File</th>
                 </tr>
              </thead>
              <tbody>

                <?php if(empty($employeeSalMonDetail)) { ?>
                <tr class="even pointer">
                    <td style="text-align:center;" colspan="5">
                        <em>--No Records Found--</em>
                    </td>
                </tr>
              <?php } ?>

             <?php foreach($employeeSalMonDetail as $srcdet)  {
     //print_r($srcdet);
                    ?>
               <tr>
                    <td><?php echo $i+1;//echo $srcdet['MstEmpExpVoucher']['voucher_id'];?></td>                        
                    <td><?php echo $srcdet['OA']['name'];//echo $this->Common->getSectionDtl($srcdet['EmployeeSalMon']['sal_id']); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($srcdet['EmployeeSalMon']['claim_date'])); ?></td>                        
                    <?php if($srcdet['EmployeeSalMon']['status']== 1){?>
                         <td><span class="OpenLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } elseif($srcdet['EmployeeSalMon']['status']== 2){ ?>
                        <td><span class="ForwardLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } elseif($srcdet['EmployeeSalMon']['status']== 3) {?>
                          <td><span class="RevertdLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } elseif($srcdet['EmployeeSalMon']['status']== 4){?>
                           <td><span class="RejectedLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } elseif($srcdet['EmployeeSalMon']['status']== 5){?> 
                           <td><span class="ApprovedLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } else{?>  
                        <td><span class="PendingLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php }?>
                    <td><?php echo $srcdet['EmployeeSalMon']['sal_val']; ?></td>      
                     <td>
 <?php if($srcdet['EmployeeSalMon']['vc_file']!= ''){?> 
                            <a target="_blank" href="<?php echo $this->webroot ?>uploads/TempComp/<?php echo $srcdet['EmployeeSalMon']['vc_file']; ?>" >View/Download
                                
                            </a>
 <?php }else{
     echo 'N/A';
 } ?>              
                     </td>
                    
              </tr>
             <?php $i++ ;} ?>
            </tbody>
            </table>
        </div>
    </div>

                    
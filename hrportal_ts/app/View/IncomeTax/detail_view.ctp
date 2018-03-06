
<?php $i=0; ?>


    <h3>Income Tax Declaration Details For <?php  echo $this->Common->getempinfo($incometax[0]['EmpInvestDtl']['emp_code']); ?>  </h3>

   

            <table class="uk-table uk-table-bordered">
              <thead>
                <tr>
                  <th>Sr.No </th>
                  
                  <th> Section  </th>
                  <th> Investment</th>
                  <th> Investment Max Limit</th>
                  <th> Planned Amount</th>
                  <th> Actual Amount</th>
                 </tr>
              </thead>
              <tbody>

                

             <?php foreach($incometax as $srcdet)  {
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
               <tr>
                        <td><?php echo $i+1;//echo $srcdet['MstEmpExpVoucher']['voucher_id'];?></td> 
                        
                        <td><?php echo $this->Common->getSectionDtl($srcdet['EmpInvestDtl']['sect_id']); ?></td>
                        <td><?php echo $this->Common->getInvestmentDtl($srcdet['EmpInvestDtl']['invest_id']); ?></td>
                        <td><?php echo $this->Common->getInvestment($srcdet['EmpInvestDtl']['invest_id']); ?></td>
                        <td><?php echo $srcdet['EmpInvestDtl']['invest_amt']; ?></td>
                        <td><?php echo $srcdet['EmpInvestDtl']['actual_amt']; ?></td>
                           
              </tr>
             <?php $i++ ;} ?>
<?php if(empty($incometax)) { ?>
                <tr>
                <td style="text-align:center" colspan="11">
                        <em>--No Records Found--</em>
                </td>
                </tr>
              <?php } ?>
            </tbody>
            </table>

  

<!--<div class="navigation">
    <?php echo $this->Paginator->counter(); ?> Pages
            <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
         
  </div> -->

  

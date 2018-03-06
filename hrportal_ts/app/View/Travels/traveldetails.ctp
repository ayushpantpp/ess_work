<table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
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
                  <th>Miscellaneous Expense</th>
                  <th>Hotel Stay Expense: </th>
                  <th>Advance Taken </th>
                  <th>Travel Expense Incurred</th>
                  <th>Remark</th>
                  </tr>
              </thead>
              <tbody>

                  <?php if(empty($travellist)) {  ?>
                <tr class="even pointer">
                            <td style="text-align:center;" colspan="11">
                                    <em>--No Records Found--</em>
                            </td>
                </tr>
              <?php } ?>
              
             <?php  $i = 0; foreach($travellist as $srcdet)  {
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
               <tr class="even pointer">
                            <td><?php echo $i+1;//echo $srcdet['MstEmpExpVoucher']['voucher_id'];?></td> 
                            <td><?php echo $this->Common->getempinfo($srcdet['emp_code']); ?></td>
                            <td><?php echo $this->Common->getCityName($srcdet['place_visit']); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($srcdet['tour_start_date'])); ?></td>
                            <td><?php echo $this->Common->gettravelmode($srcdet['start_mode']); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($srcdet['tour_end_date'])); ?></td>
                            <td><?php echo $this->Common->gettravelmode($srcdet['start_mode']); ?></td>
                            <td><?php echo $srcdet['da']; ?></td>
                            <td><?php echo $srcdet['miscellaneous_exp'];?></td>
                            <td><?php echo $srcdet['hotel_stay'];?></td>
                            <td><?php echo $srcdet['adv_amount']; ?></td>
                            <td><?php echo $srcdet['total_expense']; ?></td>
                            <td><?php echo $srcdet['remark']; ?></td>
                            
              </tr>
             <?php $i++ ;} ?>
            </tbody>
            </table>
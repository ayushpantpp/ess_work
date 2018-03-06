<?php
// Turn off all error reporting
error_reporting(0);
?>
<div style="text-align:center"><h2>Request Tracking Details</h2></div>
<table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
              <thead>
                <tr>

                  <th>Sr.No </th>
                 
                  <th>Forwarded By</th>
                  <th>On Date </th>
				   <th>Forwarded To</th>
				  
                  <th>Total Time<br>Months Days Hours::Minutes::Seconds</th>
                  
               </tr>
              </thead>
              <tbody>

                  <?php if(empty($reqDetails)) {  ?>
                <tr class="even pointer">
                            <td style="text-align:center;" colspan="6">
                                    <em>--No Records Found--</em>
                            </td>
                </tr>
              <?php } ?>
              
             <?php  $i = 0; for($j=0; $j<count($reqDetails);$j++)  {
			 //echo '<pre>';print_r($reqDetails);
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
               <tr class="even pointer">
                            <td><?php echo $i+1;?></td> 
                           
                            <td><?php echo $this->Common->finddepEmpName($reqDetails[$j]['BMReceiveRequestForward']['req_forward_by']); ?></td>
                            <td><?php if($j==0){echo $reqDetails[$j]['BMReceiveRequestForward']['forward_date'];}else{echo $reqDetails[$j]['BMReceiveRequestForward']['forward_date']; }?></td>
							 <td><?php echo $this->Common->finddepEmpName($reqDetails[$j]['BMReceiveRequestForward']['req_receive_by']); ?></td>
                            
                            <td><?php 
							if($j == (count($reqDetails)-1)){
								if($reqDetails[$j]['BMReceiveRequest']['request_details_status']==1){
									$start_date = new DateTime($reqDetails[$j]['BMReceiveRequest']['created_date']);
								}else{
									$start_date ='';
								}
							}else{
								$start_date = new DateTime($reqDetails[$j+1]['BMReceiveRequestForward']['forward_date']);
							}
							//echo $reqDetails[$j]['BMReceiveRequest']['request_details_status'].' -> '.$start_date->format('Y-m-d').' ';
							if($start_date==''){echo 'Till Now';}else{
							$since_start = $start_date->diff(new DateTime($reqDetails[$j]['BMReceiveRequestForward']['forward_date']));
							echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';
							}
							
 ?></td>
 
                                                       
              </tr>
             <?php $i++ ;} ?>
            </tbody>
            </table>
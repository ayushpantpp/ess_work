<table class="table table-striped responsive-utilities jambo_table bulk_action" >
                  <thead>
                    <tr class="headings">
                    <th scope="row">Create By</th>
                    <th class="column-title">MOM Date</th>
                    <th class="column-title">MOM Member</th>
                    </tr>
                  </thead>
                       <tbody><?php //echo "<pre>";print_r($emp);?>
                             <tr>
                             <td><?php  echo $assignby['MomAssign']['createby']; ?></td>
                             <td><?php  echo $assignby['MomAssign']['date']; ?></td>
                             <td>

                               <?php 
                                 for($i=0;$i<count($emp);$i++){
                                     echo $emp[$i]['Name']['emp_firstname'].", ";
                                  } ?>
                                   
                              <!--  <select name="tk" id="tk" >
                                 <option value=''>Click to Show</option>
                                 <?php// foreach($emp as $k=>$val){?>
                                 <option value='<?php// echo $k; ?>'><?php //echo $val;?></option>
                                 <?php // } ?>
                               </select> -->
                                </td>
                                
                             
                           </tr>
                             
                      </tbody>
                </table>
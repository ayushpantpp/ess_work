<?php
// Turn off all error reporting
//error_reporting(0);
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
              
             <?php  
             //echo '<pre>';print_r($reqDetails);
             $i = 0; for($j=0; $j<=count($reqDetails['0']['DocumentReceiveRequestForward']);$j++)  {
			//echo $j;
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';
                    
                    ?>
                
               <tr class="even pointer">
                            <td><?php 
                            echo $i+1;
                            ?></td> 
                           
                            <td><?php 
                             if($j == (count($reqDetails['0']['DocumentReceiveRequestForward'])) && ($reqDetails['0']['DocumentRequest']['req_status']=='3') ){
                                 if(count($reqDetails['0']['DocumentReceiveRequestForward']) == 0){
                                     echo $this->Common->finddepEmpName($reqDetails['0']['DocumentRequest']['user_id']);
                                 }else{
                                     echo $this->Common->finddepEmpName($reqDetails['0']['DocumentReceiveRequestForward'][$j-1]['req_receive_by']);
                                 }
                              
                            }else{
                            echo $this->Common->finddepEmpName($reqDetails['0']['DocumentReceiveRequestForward'][$j]['req_forward_by']); 
                            } 
                            ?>
                            </td>
                            <td>
                                <?php 
                                if(($j == (count($reqDetails['0']['DocumentReceiveRequestForward']))) && ($reqDetails['0']['DocumentRequest']['req_status']=='3') ){
                                   
                                    echo $reqDetails['0']['DocumentRequest']['file_return_date'];
                                }elseif($j==0){
                                    echo $reqDetails['0']['DocumentReceiveRequestForward'][$j]['forward_date'];
                                    
                                }else{
                                    echo $reqDetails['0']['DocumentReceiveRequestForward'][$j]['forward_date']; 
                                    
                                }
                                ?>
                            </td>
			    <td><?php 
                            if(($j == (count($reqDetails['0']['DocumentReceiveRequestForward']))) && ($reqDetails['0']['DocumentRequest']['req_status']=='3')){
                                echo "Record Management System"; 
                            }else{
                            echo $this->Common->finddepEmpName($reqDetails['0']['DocumentReceiveRequestForward'][$j]['req_receive_by']);
                            }
                            ?>
                            </td>
                            <td><?php 
                          //echo count($reqDetails['0']['DocumentReceiveRequestForward']).$reqDetails['0']['DocumentReceiveRequestForward'][$j]['frwd_status'].$reqDetails['0']['DocumentRequest']['req_status'];
							if(count($reqDetails['0']['DocumentReceiveRequestForward'])==1 && $reqDetails['0']['DocumentReceiveRequestForward']['0']['frwd_status'] == '0' && $reqDetails['0']['DocumentRequest']['req_status']=='3' ){
                                                       
                                                            if($j == 0){ 
                                                        $start_date = new DateTime($reqDetails['0']['DocumentRequest']['file_receive_date']);
                                                        $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentReceiveRequestForward']['0']['forward_date']));
                                                        }elseif($j == 1){ 
                                                            $start_date = new DateTime($reqDetails['0']['DocumentReceiveRequestForward']['0']['forward_date']);
                                                            $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentRequest']['file_return_date']));
                                                        }
						        
								
							}elseif(count($reqDetails['0']['DocumentReceiveRequestForward'])==1 && $reqDetails['0']['DocumentReceiveRequestForward']['0']['frwd_status'] == '0' && $reqDetails['0']['DocumentRequest']['req_status']!='3' ){
                                                       
                                                            if($j == 0){ 
                                                        $start_date = new DateTime($reqDetails['0']['DocumentRequest']['file_receive_date']);
                                                        $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentReceiveRequestForward']['0']['forward_date']));
                                                        }elseif($j == 1){ 
                                                            $start_date = new DateTime($reqDetails['0']['DocumentReceiveRequestForward']['0']['forward_date']);
                                                            $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentRequest']['file_return_date']));
                                                        }
						        
								
							}elseif((count($reqDetails['0']['DocumentReceiveRequestForward']))==0 && ($reqDetails['0']['DocumentRequest']['req_status']=='3')){
//                                                            //echo "goodddd".$reqDetails['0']['DocumentRequest']['file_receive_date'];
                                                             $start_date = new DateTime($reqDetails['0']['DocumentRequest']['file_receive_date']);
                                                             $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentRequest']['file_return_date']));
                                                             
                                                        }elseif((count($reqDetails['0']['DocumentReceiveRequestForward']))>1 && $reqDetails['0']['DocumentRequest']['req_status']!='3'){
                                                            
                                                            if($j == 0){ //echo "asdfasfadsf".$reqDetails['0']['DocumentRequest']['file_receive_date']."/".$reqDetails['0']['DocumentReceiveRequestForward']['0']['forward_date'];
                                                             $start_date = new DateTime($reqDetails['0']['DocumentRequest']['file_receive_date']);
                                                             $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentReceiveRequestForward']['0']['forward_date']));
                                                            }else{ 
                                                             $start_date = new DateTime($reqDetails['0']['DocumentReceiveRequestForward'][$j]['forward_date']);
                                                             $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentReceiveRequestForward'][$j-1]['forward_date']));
                                                            }
                                                        }elseif((count($reqDetails['0']['DocumentReceiveRequestForward']))>=1 && $reqDetails['0']['DocumentRequest']['req_status']=='3'){
                                                           if($j == 0){ 
                                                               $start_date = new DateTime($reqDetails['0']['DocumentRequest']['file_receive_date']);
                                                               $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentReceiveRequestForward']['0']['forward_date']));
                                                           }elseif((count($reqDetails['0']['DocumentReceiveRequestForward'])-1)==$j){ 
                                                               $start_date = new DateTime($reqDetails['0']['DocumentReceiveRequestForward'][$j-1]['forward_date']);
                                                             $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentReceiveRequestForward'][$j]['forward_date']));
                                                           }elseif((count($reqDetails['0']['DocumentReceiveRequestForward']))==$j && $reqDetails['0']['DocumentReceiveRequestForward'][$j]['frwd_status']==0){ 
                                                                $start_date = new DateTime($reqDetails['0']['DocumentReceiveRequestForward'][$j-1]['forward_date']);
                                                             $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentRequest']['file_return_date']));
                                                           }
                                                            
                                                        }
//							elseif($j == (count($reqDetails['0']['DocumentReceiveRequestForward'])-1)){
//								 echo "goodss";die;
//                                                            if($reqDetails['0']['DocumentReceiveRequestForward'][$j]['frwd_status']==1){
//									$start_date = new DateTime($reqDetails[$j]['DocumentRequest']['created_date']);
//								}else{//echo "gooddddd".$reqDetails['0']['DocumentReceiveRequestForward'][$j]['forward_date'];
//									$start_date = new DateTime($reqDetails['0']['DocumentReceiveRequestForward'][$j]['forward_date']);
//								}
//                                                        }elseif((count($reqDetails['0']['DocumentReceiveRequestForward']))==0 && ($reqDetails['0']['DocumentRequest']['req_status']=='3')){
//                                                            //echo "goodddd".$reqDetails['0']['DocumentRequest']['file_receive_date'];
//                                                             $start_date = new DateTime($reqDetails['0']['DocumentRequest']['file_receive_date']);
//                                                        }
//                                                        
							
							
                                                        
//                                                        if(($j == (count($reqDetails['0']['DocumentReceiveRequestForward']))) && ($reqDetails['0']['DocumentRequest']['req_status']=='3')){
//                                                            
//                                                                echo $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentRequest']['file_return_date']));
//                                                      
//                                                        }elseif(count($reqDetails['0']['DocumentReceiveRequestForward'])==1 && $reqDetails['0']['DocumentReceiveRequestForward']['frwd_status']==0){ 
//                                                        $since_start = $start_date->diff(new DateTime($reqDetails['0']['DocumentRequest'][$j]['file_receive_date']));
//                                                           
//                                                        }
                                                        
                                                        
                                                        
//                                                        echo $j.count($reqDetails['0']['DocumentReceiveRequestForward']);
//                                                        if($j < (count($reqDetails['0']['DocumentReceiveRequestForward'])) && ($reqDetails['0']['DocumentRequest']['req_status']!='3') ){
//                                                            echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';
//                                                        }else{
                                                        
//                                                     if((count($reqDetails['0']['DocumentReceiveRequestForward']))>= 1 && ($reqDetails['0']['DocumentRequest']['req_status']=='3')){   
//                                                         if($j == 0){
//                                                             echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';
//                                                         }else{
//                                                             echo "null";
//                                                         }
//                                                     }else{
//                                                         echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';
//                                                     }
                                                     
                                                    // echo count($reqDetails['0']['DocumentReceiveRequestForward']).$reqDetails['0']['DocumentReceiveRequestForward']['0']['frwd_status'].$reqDetails['0']['DocumentRequest']['req_status'];
                                                     
                                                        if(((count($reqDetails['0']['DocumentReceiveRequestForward'])) > 1) && $reqDetails['0']['DocumentReceiveRequestForward'][$j]['frwd_status']==0 && ($reqDetails['0']['DocumentRequest']['req_status']=='3')){
                                                            echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';
                                                            
                                                        }elseif(((count($reqDetails['0']['DocumentReceiveRequestForward'])) > 1) && $reqDetails['0']['DocumentReceiveRequestForward']['0']['frwd_status']==1 && ($reqDetails['0']['DocumentRequest']['req_status']!='3')){
                                                            if($reqDetails['0']['DocumentReceiveRequestForward']['0']['frwd_status']==1 && $j<=1){
                                                                echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';
                                                            }
                                                            
                                                        }elseif(((count($reqDetails['0']['DocumentReceiveRequestForward'])) > 1) && $reqDetails['0']['DocumentReceiveRequestForward']['0']['frwd_status']==1 && ($reqDetails['0']['DocumentRequest']['req_status']=='3')){
                                                            if($reqDetails['0']['DocumentReceiveRequestForward']['0']['frwd_status']==1 && $j<=1){
                                                                echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';
                                                            }
                                                            
                                                        }else{ 
                                                            if($j==0 && ((count($reqDetails['0']['DocumentReceiveRequestForward']))==1) && $reqDetails['0']['DocumentReceiveRequestForward']['0']['frwd_status']==0 && ($reqDetails['0']['DocumentRequest']['req_status'] !='3')){
                                                            echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';
                                                            }elseif(((count($reqDetails['0']['DocumentReceiveRequestForward']))==1) && $reqDetails['0']['DocumentReceiveRequestForward']['0']['frwd_status']==0 && ($reqDetails['0']['DocumentRequest']['req_status']=='3')){
                                                              echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';  
                                                            }elseif($j==0 && ((count($reqDetails['0']['DocumentReceiveRequestForward']))==0) && ($reqDetails['0']['DocumentRequest']['req_status'] =='3')){
                                                            echo $since_start->m.'M '.$since_start->d.'D '.$since_start->h.'h '.$since_start->i.'m '.$since_start->s.'s ';  
                                                                
                                                            
                                                            }
                                                        }
                                                    //echo "null";
                                                   
                                                        
                                                        //}
							
                                                           
                                                           
 ?></td>
 
                                                       
              </tr>
             <?php $i++ ;} ?>
            </tbody>
            </table>
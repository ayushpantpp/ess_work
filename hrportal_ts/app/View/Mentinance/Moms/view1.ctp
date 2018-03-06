<?php //print_r($sr); echo "<h1>Hi i am view page..</h1>"?>
<!--<table class="table table-striped responsive-utilities jambo_table bulk_action" >
                  <thead>
                    <tr class="headings">
                    <th class="column-title">MOM Details</th>
                    </tr>
                  </thead>
                       <tbody>
                             <?php 
//                             if(isset($sr))
//                             {
//                             foreach ($sr as $k) { ?> 
                           <tr>
                               <td><?php  //echo $k['MomTopicFunction']['fname']; ?></td>  
                              
                           </tr>
                             <?php //} }?>
                      </tbody>
                </table>-->


<?php
echo "<h3>MOM Details:</h3>";?> <div class="ln_solid"></div><?php
if(isset($sr))
     {$i=1;
         foreach ($sr as $k) {
                 
                 echo "<h5>".$i.".&nbsp;&nbsp;".$k['MomTopicFunction']['fname']."<br/>";
                 $i++;
     
         }
         }  




?>






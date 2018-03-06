    <div id="page_content">
        <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            
            <h1>Documents List</h1>
            <span class="uk-text-upper uk-text-small">
                <?php foreach($bredcrum as $breC ){?>
                <a href="<?php echo $this->Html->url('currentfolder/'.$breC['Category']['id']); ?>"> <?php echo $breC ['Category']['name'];?></a>/  
                <?php }?>
            </span>
        </div>

        <div id="page_content_inner">
            <?php echo $this->Session->flash();?>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-overflow-container uk-margin-bottom">
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                            <thead>
                                <tr>
                                    <th class="uk-text-center">Key</th>
                                    <th>Remark</th>
                                    <th>Title</th>
                                    <!--<th>Priority</th>-->
                                    <th>Receiving Date</th>
                                    <!--<th>Updated</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php 
                                 function processtext($text,$nr=20)  {
                                    $mytext=explode(" ",trim($text));
                                    $newtext=array();
                                    foreach($mytext as $k=>$txt) {
                                        if (strlen($txt)>$nr) {
                                            $txt=wordwrap($txt, $nr, "<br>",1);
                                        }
                                        $newtext[]=$txt;
                                    }
                                    return implode(" ",$newtext);
                                } 
//                                echo "<pre>";
//                                print_r($allChildren);
                                  foreach($allChildren as $chld){
                                      if($chld['Category']['status']=='1'){
                                        ?>
                                      <tr>
                                    <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $chld['Category']['doc_reference_num'];?></span></td>
                                    <td >
                                        <span class=" uk-text-muted">
                                            <a  data-uk-tooltip="{cls:'long-text'}" title="<?php echo processtext($chld['Category']['remark']); ?>">
                                        <?php 
                                      echo substr($chld['Category']['remark'],0,26);
                                      if(strlen($chld['Category']['remark'])>26){
                                          echo "....";
                                          ?>
                                         <?php
                                           }
                                         ?>
                                           </a>
                                            </span>
                                    </td>
                                    <td><?php if($chld['Category']['name']==""){?>
                                            <a href="<?php echo $this->Html->url('download/'.$chld['Category']['id']);?>" ><?php echo $chld['Category']['file'];?></a>   
                                            <?php }else{
                                        ?>
                                        <a  href="<?php echo $this->Html->url('currentfolder/'.$chld['Category']['id']); ?>" ><?php echo $chld['Category']['name'];?></a>
                                            <?php }?>  
                                    </td>
                                    <td class="uk-text-small"><?php 
                                      if($chld['Category']['name'] == ""){
                                      $date=$chld['Category']['doc_receiving_date'];
                                      echo $d= date("d/m/Y", strtotime($date));
                                      }else{
                                          echo "N/A";
                                      }
                                    ?></td>
                                    <!--<td class="uk-text-small">
                                        <?php // if($chld['Category']['modify_date']!="0000-00-00 00:00:00"){
//                                             echo $chld['Category']['modify_date'];   
//                                            }else{
//                                             echo "N/A";      
//                                            }?>
                                    </td>-->
                                    <td>
                                        <?php if($chld['Category']['name']!=""){?>
                                        <span><a data-uk-modal="{target:'#modal_overflow_response'}" onclick="return getDocEdit(<?php echo $chld['Category']['id'];?>)" alt="Edit Folder" title="Edit Folder" class="uk-badge uk-badge-success">Edit</a></span> |
                                        <?php }?> 
                                        <span ><a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('docDelete/'.$chld['Category']['id']); ?>" onclick="return confirm('Are you sure?');" style="text-decoration: none">Delete</a></span>
                                        
                                    </td>
                                    
                                </tr>
                                  <?php    
                                    }
                                  }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>

<div class="uk-width-medium-1-2">
    <div id="modal_overflow_response" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-small">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>
    
    <!-- google web fonts -->
    <script>
        function getDocEdit(docId){   
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>Documents/doc_edit/'+docId,
            success: function(data){
             //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
    
    
        
    </script>

    
    
   
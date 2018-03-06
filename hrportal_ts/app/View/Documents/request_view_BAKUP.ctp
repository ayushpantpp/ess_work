<script>
    function remarkDisable(fileid){
        var remark=jQuery("#remark_"+fileid).val();
        if(remark==""){
            remark='NA';
        }
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/fileremark/' + remark +'/'+ fileid,
            //data:'project_id='+val,
            success: function (data) {
                location.reload(); 
            }
        });
      
 }
 
 function dwnlodzip(fileid){
        //alert(fileid);
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/dwnld/'+ fileid,
            //data:'project_id='+val,
            success: function (data) {
                location=<?php echo $this->webroot ?>+'app/webroot/'+data ;
                setTimeout(function(){
                    location='<?php echo $this->webroot ?>Documents/deletezip/'+data;
                  }, 1000);
               
            }
           
        });
        
        
        
      
 }
  
  function fileDownload(fileid){
        
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/download/' + fileid,
            //data:'project_id='+val,
            success: function (data) {
                //location.reload(); 
            }
        });
      
 }
</script>   

<div id="page_content">
    <div id="page_heading" >

        <h1>Requested File List</h1>
        <span class="uk-text-upper uk-text-small">
            <?php /* foreach($bredcrum as $breC ){?>
            <a href="<?php echo $this->Html->url('currentfolder/'.$breC['Category']['id']); ?>"> <?php echo $breC ['Category']['name'];?></a>/  
            <?php } */?>
        </span>
    </div>

    <div id="page_content_inner">
        <?php echo $this->Session->flash();?>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                <?php 
                if($currentUser==$recordUnit){
                ?>
                <select name="forma" onchange="location = this.value;" class="md-btn">
                <?php    
                $selected1='';
                $selected2='';
                if($process=='2' || $process==''){
                    $selected1="selected='selected'";
                }elseif($process=='3'){
                    $selected2="selected='selected'";
                }
                ?>
                <option value="<?php echo $this->Html->url('request_view/2'); ?>" <?php echo $selected1;?> >Under Processing</option>
                <option value="<?php echo $this->Html->url('request_view/3'); ?>" <?php echo $selected2;?>>Process Completed</option>
                </select>
                <?php }?> 
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">Request No.</th>
                                <th>File Reference No.</th>
                                <th>File Name</th>
                                <th>Manual Files Name</th>
                                <?php if($currentUser==$recordUnit && $process=='3'){?>
                                <th>Manually Returned Files(Apart From Requested files)</th>
                                <?php }elseif($currentUser!=$recordUnit ){ ?>
                                 <th>Manually Returned Files(Apart From Requested files)</th>   
                                <?php }?>
                                <th>Emp Code</th>
                                <th>Requester Name</th>
                                <th>Designation</th>
                                <th>Date of Request</th>
                                <?php if($currentUser==$recordUnit){?>
                                <th>Date of Return</th>
                                <?php }else{?>
                                <th>Date of Receive</th>
                                <?php }?>
                                <th>Reason</th>
                                <?php if($currentUser==$recordUnit){?>
                                <th>File Availability</th>
                                <th>Remark</th>
                                <th class=" uk-text-center filter-false remove sorter-false">Action</th>
                                <?php }else{ ?>
                                <th>Remark</th>    
                                <?php }?>
                                <th class="uk-text-center filter-false remove sorter-false">Status</th>
                                <?php if($currentUser!=$recordUnit){?>
                                <th class="uk-text-center filter-false remove sorter-false">Action</th>
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody>
                             <?php 
                              foreach($data as $rec){
                                  ?>
                                  <tr>
                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DocumentRequest']['request_num'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DocumentRequest']['file_ref_num'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        
                                              
                                    <?php 
                                        
                                        if($currentUser==$recordUnit && $rec['DocumentRequest']['req_status']!=2){?>
                                        <a onclick="dwnlodzip(<?=$rec['DocumentRequest']['document_id']?>)" ><span id="getzip"><?php  echo $rec['DocumentRequest']['file_name']; ?></span></a> 
                                        <!--<a href="<?php //echo $this->Html->url('download/'.$rec['DocumentRequest']['document_id']);?>" ><?php //echo $rec['DocumentRequest']['file_name'];?></a> -->   
                                        <?php }elseif($rec['DocumentRequest']['req_status']==2 && $currentUser!=$recordUnit){?>
                                       <!-- <a href="<?php //echo $this->Html->url('download/'.$rec['DocumentRequest']['document_id']);?>" ><?php // echo $rec['DocumentRequest']['file_name'];?></a>-->    
                                        <a onclick="dwnlodzip(<?=$rec['DocumentRequest']['document_id']?>)" ><span id="getzip"><?php  echo $rec['DocumentRequest']['file_name']; ?></span></a> 
                                        <?php 
                                        }else{
                                          echo $rec['DocumentRequest']['file_name'];  
                                        }?>
                                    </span>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php if($rec['DocumentRequest']['manual_files']!=''){echo $rec['DocumentRequest']['manual_files'];}else{echo "NA";}?></span></td>
                                <?php if($currentUser==$recordUnit && $process=='3'){?>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php  
                                        if($rec['DocumentRequest']['manual_files_byRequester']!=''){
                                        echo $rec['DocumentRequest']['manual_files_byRequester'];
                                        }else{
                                            echo "NA";
                                        }
                                        ?>
                                   </span>
                                </td>
                                <?php }elseif($currentUser!=$recordUnit){ ?>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php  
                                        if($rec['DocumentRequest']['manual_files_byRequester']!=''){
                                        echo $rec['DocumentRequest']['manual_files_byRequester'];
                                        }else{
                                            echo "NA";
                                        }
                                        ?>
                                    </span>
                                </td>
                                <?php }?>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['MyProfile']['emp_code'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo ucfirst($rec['MyProfile']['emp_full_name']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo ucfirst(strtolower($this->common->findDesignationName($rec['MyProfile']['desg_code'],$rec['MyProfile']['comp_code'])));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['DocumentRequest']['created_date']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php if($currentUser==$recordUnit){ 
                                                if($rec['DocumentRequest']['file_return_date']=='0000-00-00 00:00:00'){
                                                    echo "NA";
                                                }else{
                                                    echo date("d/m/Y", strtotime($rec['DocumentRequest']['file_return_date']));
                                                }
                                            }else{ 
                                                if($rec['DocumentRequest']['file_receive_date']=='0000-00-00 00:00:00'){
                                                    echo "NA";
                                                }else{
                                                    echo date("d/m/Y", strtotime($rec['DocumentRequest']['file_receive_date']));
                                                }
                                            }
                                    ?>
                                    </span>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php if($rec['DocumentRequest']['reason']!=''){echo $rec['DocumentRequest']['reason'];}else{echo "NA";}?></span></td>
                                <?php if($currentUser==$recordUnit){?>
                                <td>
                                    <?php if($rec['DocumentRequest']['req_status']==1 || $rec['DocumentRequest']['req_status']==3 || $rec['DocumentRequest']['req_status']==4){?>
                                        <span class="uk-badge uk-badge-warning" id="warining_<?php echo $rec['DocumentRequest']['id'];?>"  >
                                        <?php echo "Available";?>
                                        </span>
                                    <?php
                                    }elseif($rec['DocumentRequest']['req_status']==2){?>
                                        <span class="uk-badge uk-badge-danger">
                                        <?php echo "Not Available"; ?>
                                        </span>
                                    <?php }?>
                                    </span>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php if($rec['DocumentRequest']['remark']!='' || $rec['DocumentRequest']['remark']=='NA'){
                                           echo  $rec['DocumentRequest']['remark'];
                                        }else{?>
                                        <input type="text" name="remark<?php echo $rec['DocumentRequest']['id'];?>" id="remark_<?php echo $rec['DocumentRequest']['id'];?>" value="" placeholder="write here..." >
                                        <?php }?>
                                    </span>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">

                                        <?php if($rec['DocumentRequest']['req_status']==1){?>
                                        <button class="uk-badge uk-badge-primary" id="fileid_<?php echo $rec['DocumentRequest']['id'];?>" value="<?php echo $rec['DocumentRequest']['id'];?>"  onclick="remarkDisable(this.value);" style="cursor :pointer">Forward</button>
                                        |
                                        <span><a data-uk-modal="{target:'#modal_overflow_response'}" onclick="return fileReject(<?php echo $rec['DocumentRequest']['document_id'];?>,<?php echo $rec['DocumentRequest']['id'];?>)" alt="Edit Folder" title="Edit Folder" class="uk-badge uk-badge-primary">Reject</a></span>
                                        <?php }elseif($rec['DocumentRequest']['req_status']==2){?>
                                        <button class="uk-badge" id="fileid__<?php echo $rec['DocumentRequest']['id'];?>" value="<?php echo $rec['DocumentRequest']['id'];?>" disabled="disabled" onclick="remarkDisable(this.value);" >Forwarded</button>
                                        <?php }elseif($rec['DocumentRequest']['req_status']==4){?>
                                         <button class="uk-badge" id="fileid__<?php echo $rec['DocumentRequest']['id'];?>" value="<?php echo $rec['DocumentRequest']['id'];?>" disabled="disabled" onclick="remarkDisable(this.value);" >Rejected</button>
                                        <?php } ?>
                                    </span>
                                </td>
                                
                              <?php }else{?>
                                  <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php if($rec['DocumentRequest']['remark']!=''){
                                           echo  $rec['DocumentRequest']['remark'];
                                        }else{
                                            echo "Send By Record Unit..";
                                        }?>
                                    </span>
                                </td>
                                  <?php }?>
                                <td>
                                    <?php if($rec['DocumentRequest']['req_status']==1){?>
                                        <span class="uk-badge uk-badge-warning" id="warining_<?php echo $rec['DocumentRequest']['id'];?>"  >
                                        <?php echo "Under Proccessing...";?>
                                        </span>
                                    <?php
                                    }elseif($rec['DocumentRequest']['req_status']==2){?>
                                        <span class="uk-badge uk-badge-success">
                                        <?php 
                                         if($currentUser==$recordUnit){
                                        echo "Sent to requester"; 
                                        }else{
                                           echo "File Recieved";
                                           ?>
                                        </span> <!-- <span><a class="uk-badge uk-badge-primary" href="<?php echo $this->Html->url('request_complete/'.$rec['DocumentRequest']['id']."/".$rec['DocumentRequest']['document_id']); ?>" onclick="return confirm('Are you sure?');" style="text-decoration: none">Click To Return</a></span>-->
                                           <?php
                                        }?>

                                    <?php }elseif($rec['DocumentRequest']['req_status']==3){?>
                                        <span class="uk-badge uk-badge-primary" >    
                                    <?php echo "Returned";
                                    }elseif($rec['DocumentRequest']['req_status']==4){?>
                                        <span class="uk-badge uk-badge-primary" >    
                                    <?php echo "Rejected";
                                    }?>
                                    </span>
                                </td>
                                <?php if($currentUser!=$recordUnit){?>
                                <td>
                                    <?php if($rec['DocumentRequest']['req_status']==2){ ?>
                                    <span>
                                        <span><a data-uk-modal="{target:'#modal_overflow_response'}" onclick="return fileReturn(<?php echo $rec['DocumentRequest']['document_id'];?>,<?php echo $rec['DocumentRequest']['id'];?>)" alt="Edit Folder" title="Edit Folder" class="uk-badge uk-badge-primary">Click To Return</a></span>
                                        |
                                        <span><a data-uk-modal="{target:'#modal_overflow_response'}" onclick="return fileforward(<?php echo $rec['DocumentRequest']['document_id'];?>,<?php echo $rec['DocumentRequest']['id'];?>)" alt="Edit Folder" title="Edit Folder" class="uk-badge uk-badge-primary">Forward</a></span>
                                        <!--<a class="uk-badge uk-badge-primary" href="<?php //echo $this->Html->url('request_complete/'.$rec['DocumentRequest']['id']."/".$rec['DocumentRequest']['document_id']); ?>" onclick="return confirm('Are you sure?');" style="text-decoration: none">Click To Return</a></span>-->
                                    <?php }elseif($rec['DocumentRequest']['req_status']==5){
                                        ?>
                                        <span class="uk-badge uk-badge-primary">Forwarded to Other User</span>
                                        <?php 
                                    }else{
                                        echo "NA";
                                    }?>
                                </td>
                                <?php }?>

                            </tr>
                              <?php    

                              }
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        
    </div>
</div>

<div class="uk-width-large-1-1">
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
        function fileReturn(reqId,docID){ 
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>Documents/file_return/'+docID+'/'+reqId,
            success: function(data){
             //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
    
    function fileReject(docID,reqId){
   
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>Documents/file_reject/'+docID+'/'+reqId,
            success: function(data){
             //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
    
    function fileforward(docID,reqId){
   
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>Documents/file_forward/'+docID+'/'+reqId,
            success: function(data){
             //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
    
    
        
    </script>

    
    
   
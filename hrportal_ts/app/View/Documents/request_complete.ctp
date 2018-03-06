<script>
    function remarkDisable(fileid){
        
        var remark=jQuery("#remark_"+fileid).val();
        if(remark==""){
            remark='nothin';
        }
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/fileremark/' + remark +'/'+ fileid,
            //data:'project_id='+val,
            success: function (data) {
                location.reload(); 
//                $("#updremark"+fileid).show();
//                $("#fileid__"+fileid).show();
//                $("#success_"+fileid).show();
//                $("#remark_"+fileid).hide();
//                $("#fileid_"+fileid).hide();
//                $("#warining_"+fileid).hide();
//                
//                $("#updremark"+fileid).html(data);
            }
        });
      
 }
  
</script>   
<div id="page_content">
        <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="heading_actions">
                <div data-uk-dropdown>
                    <i class="md-icon material-icons">&#xE5D4;</i>
                    <div class="uk-dropdown uk-dropdown-small">
                        <ul class="uk-nav">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Other Action</a></li>
                            <li><a href="#">Other Action</a></li>
                        </ul>
                    </div>
                </div>
            </div>
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
                        
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                            <thead>
                                <tr>
                                    <th class="uk-text-center">Request No.</th>
                                    <th>File Reference No.</th>
                                    <th>File Name</th>
                                    <th>Manual Files Name</th>
                                    <th>Emp Code</th>
                                    <th>Requester Name</th>
                                    <th>Designation</th>
                                    <th>Date of Request</th>
                                    <th>Reason</th>
                                    <?php if($currentUser==$recordUnit){?>
                                    <th>File Availability</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                    <?php }else{ ?>
                                    <th>Remark</th>    
                                    <?php }?>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php 
                                  foreach($data as $rec){
                                      ?>
                                      <tr>
                                    <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DocumentRequest']['request_num'];?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DocumentRequest']['file_ref_num'];?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DocumentRequest']['file_name'];?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DocumentRequest']['manual_files'];?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DocumentRequest']['user_id'];?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DocumentRequest']['emp_full_name'];?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo ucfirst(strtolower($this->common->findDesignationName($rec['DocumentRequest']['desg_code'],$rec['DocumentRequest']['comp_code'])));?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['DocumentRequest']['created_date']));?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DocumentRequest']['reason'];?></span></td>
                                    <?php if($currentUser==$recordUnit){?>
                                    <td>
                                        <?php if($rec['DocumentRequest']['req_status']==1 || $rec['DocumentRequest']['req_status']==3){?>
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
                                            <?php if($rec['DocumentRequest']['remark']!='' || $rec['DocumentRequest']['remark']=='nothing'){
                                               echo  $rec['DocumentRequest']['remark'];
                                            }else{?>
                                            <input type="text" name="remark<?php echo $rec['DocumentRequest']['id'];?>" id="remark_<?php echo $rec['DocumentRequest']['id'];?>" value="" placeholder="write here..." >
                                            <?php }?>
                                        </span>
                                    </td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                            
                                            <?php if($rec['DocumentRequest']['req_status']==1){?>
                                            <button class="uk-badge uk-badge-primary" id="fileid_<?php echo $rec['DocumentRequest']['id'];?>" value="<?php echo $rec['DocumentRequest']['id'];?>"  onclick="remarkDisable(this.value);" style="cursor :pointer">Forward</button>
                                            <?php }else{?>
                                            <button class="uk-badge" id="fileid__<?php echo $rec['DocumentRequest']['id'];?>" value="<?php echo $rec['DocumentRequest']['id'];?>" disabled="disabled" onclick="remarkDisable(this.value);" >Forwarded</button>
                                            <?php }?>
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
                                            echo "Send to requester"; 
                                            }else{
                                               echo "File Recieved";
                                               ?>
                                            </span> | 
                                        <span>
                                        <a class="uk-badge uk-badge-primary" href="<?php echo $this->Html->url('request_complete/'.$rec['DocumentRequest']['id']); ?>" onclick="return confirm('Are you sure?');" style="text-decoration: none">
                                                Click To Return
                                                </a>
                                            </span>
                                               <?php
                                            }?>
                                            
                                        <?php }elseif($rec['DocumentRequest']['req_status']==3){?>
                                            <span class="uk-badge uk-badge-primary" >    
                                        <?php echo "Returned";
                                        }?>
                                        </span>
                                    </td>
                                    
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

    
    
   
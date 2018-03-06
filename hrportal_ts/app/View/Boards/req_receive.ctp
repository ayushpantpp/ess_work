<script>
    window.setInterval(function() {
$('#blinkText').toggle();
}, 700);
</script>
<div id="page_content">
<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">
            
        </div>
        <h1>Request Receiving</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">List of Request Received 
                
                <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('req_receive_save'); ?>">Request Entry</a></h3>
                
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Request Serial #</th>
								<th>Request Category</th>
                                <th>Reference Number</th>
                                <th>Signatory</th>
                                <th>Department</th>
                                <th>Marking Officer</th>
                                <th>Date of Request</th>
                                <th>Date of Received</th>
                                <th>Subject</th>
                                <th>Requested By</th>
                                <th>Request Status</th>
                                <th>File</th>
                                <th>Action</th>
								<th>View Request Tracking</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
							//echo '<pre>';print_r($allRecReq);die;
                            foreach($allRecReq as $rec){
								
								?>
                            <tr>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i;?></span></td>
								<td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMReceiveRequest']['req_ref_serial_no'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->findRequestType($rec['BMReceiveRequest']['request_type_id']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMReceiveRequest']['reference_num'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMReceiveRequest']['signatory_name'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->findDepNamebycode($rec['BMReceiveRequest']['dept_code']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->finddepEmpName($rec['BMReceiveRequest']['action_officer_id']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['BMReceiveRequest']['date_of_request']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['BMReceiveRequest']['date_of_receive']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMReceiveRequest']['subject'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-primery" ><?php echo $this->Common->finddepEmpName($rec['BMReceiveRequest']['created_by']);?></a></span></td>
                                
                                    <?php //if($EditaccessRight == "Yes"){
                                  
                                    if($rec['BMReceiveRequestForward']['req_receive_by']==$empID){ ?>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-warning" >Received Request</a></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php if($rec['BMReceiveRequest']['file'] !=""){?>
                                        <a href="<?php echo $this->Html->url('req_rec_file_download/'.$rec['BMReceiveRequest']['id']);?>" >View</a></span>
                                        <?php }else{ 
                                            echo "NA";
                                            
                                        }?>
                                 </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><b>NA</b> | <b>NA</b></span></td> 
                                    <?php }elseif($rec['BMReceiveRequest']['created_by']==$empID && $rec['BMReceiveRequest']['request_details_status']=='0'){
                                    ?>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-primery" >Raised Request</a></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php if($rec['BMReceiveRequest']['file'] !=""){?>
                                        <a href="<?php echo $this->Html->url('req_rec_file_download/'.$rec['BMReceiveRequest']['id']);?>" >View</a></span>
                                        <?php }else{ 
                                            echo "NA";
                                            
                                        }?>
                                            </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <!--<a class="uk-badge uk-badge-success" href="<?php //echo $this->Html->url('/Boards/req_receive_edit/'.$rec['BMReceiveRequest']['id']); ?>">Edit</a> | -->
								<?php
								$showDel = $this->Common->findIntialStatus($rec['BMReceiveRequest']['id']);
								if($showDel!=1){
								?>
                                        <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/Boards/req_receive_edit/'.$rec['BMReceiveRequest']['id']."/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a>
								<?php
								}
								?>		
								</span></td>
                                    <?php }elseif($rec['BMReceiveRequest']['created_by']==$empID && $rec['BMReceiveRequest']['request_details_status']=='1'){
                                        ?>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php if($rec['BMReceiveRequest']['file'] !=""){?>
                                        <a href="<?php echo $this->Html->url('req_rec_file_download/'.$rec['BMReceiveRequest']['id']);?>" >View</a></span>
                                        <?php }else{ 
                                            echo "NA";
                                            
                                        }?>
                                            </td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-primery" >Request Closed</a></span></td>        
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><b>NA</b></span></td>        
                                    <?php } ?>
                                   
                                    
                                    <?php //}?>
                               <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a data-uk-modal="{target:'#modal_overflow'}" onclick="return getRequestDetails(<?php echo $rec['BMReceiveRequest']['id'];?>)" alt="View Full Details" title="View Full Details" class="uk-badge uk-badge-success">Track Request</a></td>  
                            </tr>
                            <?php  $i++; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
   </div>
</div>

<div class="uk-width-medium-1-1">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <span id="reqDetails" class="verflow container"></span>            
            <div class="uk-overflow-container"></div>           
        </div>
    </div>
</div>
<script type="text/javascript" >
    function getRequestDetails(reqId) {  
      
         $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>boards/requestDetails/' + reqId,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#reqDetails").html(data);
            }
        });
    }
    
</script>
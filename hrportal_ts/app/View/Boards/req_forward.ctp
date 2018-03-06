<script>
    window.setInterval(function() {
$('#blinkText').toggle();
}, 700);
</script>
<div id="page_content">
<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">
            
        </div>
        <h1>Request Forward</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">List of forwarded request 
                
                <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('req_forward_save'); ?>">Forward Request</a></h3>
                
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
								<th>Request Serial #</th>
                                <th class="uk-text-center">Request Category</th>
                                <th>Reference Number</th>
                                <th>Signatory</th>
                                <th>Department</th>
                                <th>Marking Officer</th>
                                <th>Forward To</th>
								<th>Forward By</th>
                                <th>Date of Request</th>
                                <th>Date of Received</th>
                                <th>Subject</th>
								<!--<th>View Request Tracking</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            $i=1;
                            foreach($allRecReq as $rec){ ?>
                            <tr>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i;?></span></td>
								<td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMReceiveRequest']['req_ref_serial_no'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->common->findRequestType($rec['BMReceiveRequest']['request_type_id']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMReceiveRequest']['reference_num'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMReceiveRequest']['signatory_name'];
								//$this->common->finddepEmpName($rec['BMReceiveRequest']['signatory_name']);
								?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMReceiveRequest']['dept_code'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->common->finddepEmpName($rec['BMReceiveRequest']['action_officer_id']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->common->finddepEmpName($rec['BMReceiveRequestForward']['req_receive_by']);?></span></td>
								<td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->common->finddepEmpName($rec['BMReceiveRequestForward']['req_forward_by']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['BMReceiveRequest']['date_of_request']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['BMReceiveRequest']['date_of_receive']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMReceiveRequest']['subject'];?></span></td>
								<!--<td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a data-uk-modal="{target:'#modal_overflow'}" onclick="return getMomDetails(<?php echo $ar[$i]['MomAssign']['id'];?>)" alt="View Full Details" title="View Full Details" class="uk-badge uk-badge-success">View</a></span></td> -->
                                
                            </tr>
                            <?php  $i++; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
   </div>
</div>

<script>
    window.setInterval(function() {
$('#blinkText').toggle();
}, 700);

function ShowDet(val){ 
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/show_details/' + val,
            //data:'project_id='+val,
            success: function (data) {
                $("#showdata").html(data);
                
            }
        });
        
    }
</script>
<div id="page_content">
<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">
            
        </div>
        <h1>Meeting Decision</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">Finalized List of Meeting Decision
                
                <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('meeting_decision_save'); ?>">Enter Meeting Decision</a></h3>
                
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">Meeting Number</th>
                                <th class="uk-text-center">Request Reference Number</th>
                                <th>Subject</th>
                                <th>Date of Meeting</th>
                                <th>Finalized</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            foreach($MeetReq as $rec){ ?>
                            <tr>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMMeetingRequest']['meeting_number'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php 
                                    echo $rec['BMMeetingRequestRefnum']['BMReceiveRequest']['reference_num'];
//                                    $reqIDs = explode(",",$rec['BMMeetingRequest']['request_receive_id']);
//                                    foreach($reqIDs as $val){
//                                            echo $this->common->getReqRefNumByReqID($val).", ";
//                                        }
                                        ?>
                                    </span>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMMeetingRequest']['subject'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['BMMeetingRequest']['meeting_date']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="icheckbox_md checked" ></a></span></td>
                            </tr>
                            <?php  $i++; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
   </div>
</div>

                            <div class="uk-modal" id="modal_large">
                                <div class="uk-modal-dialog uk-modal-dialog-large" >
                                    <button type="button" class="uk-modal-close uk-close"></button>
                                    <div id="showdata"></div>
                                </div>
                            </div>
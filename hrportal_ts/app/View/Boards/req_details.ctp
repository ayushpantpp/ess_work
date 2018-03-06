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
        <h1>Request Details</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">List of Request Details 
                
                <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('req_details_save'); ?>">Enter Request Details</a></h3>
                
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">Serial No.</th>
                                <th class="uk-text-center">Request Reference Number</th>
                                <th>Officer Name(full name)</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th>Data Entry Type</th>
                                <th>Details</th>
                                <?php if($EditaccessRight == "Yes"){?>
                                <th>Action</th>
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            foreach($ReqDet as $rec){ ?>
                            <tr>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['BMRequestDetails']['serial_num'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->common->getReqRefNumByReqID($rec['BMRequestDetails']['request_id']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->common->getTitle($rec['BMRequestDetails']['title']).$rec['BMRequestDetails']['firstname'].$rec['BMRequestDetails']['surname'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php if($rec['BMRequestDetails']['gender']=='0'){ echo "Male"; }else{ echo "Female";} ?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['BMRequestDetails']['dob']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->common->getDataEntryTypebyID($rec['BMRequestDetails']['data_entry_type']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><button class="md-btn" data-uk-modal="{target:'#modal_large'}" onclick="ShowDet(<?php echo $rec['BMRequestDetails']['id'];?>)">View</button></span></td>
                               <?php if($EditaccessRight == "Yes"){
                                   ?>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-success" href="<?php echo $this->Html->url('/Boards/req_details_edit/'.$rec['BMRequestDetails']['id']); ?>">Edit</a> | <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/Boards/req_details_edit/'.$rec['BMRequestDetails']['id']."/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a></span></td>
                                    <?php }?>
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
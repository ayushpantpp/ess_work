<script>
    window.setInterval(function() {
$('#blinkText').toggle();
}, 700);

function ShowDet(val){ 
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>ComplianceAudit/show_details/' + val,
            //data:'project_id='+val,
            success: function (data) {
                $("#showdata").html(data);
                
            }
        });
        
    }
</script>
<div class="uk-modal" id="modal_large">
                                <div class="uk-modal-dialog uk-modal-dialog-large" >
                                    <button type="button" class="uk-modal-close uk-close"></button>
                                    <div id="showdata"></div>
                                </div>
                            </div>
<div id="page_content">
<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">
            
        </div>
        <h1>Compliant Registration</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                    <h3 class="heading_a uk-margin-small-bottom">Compliant List
                <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('compliant_invest_save'); ?>">Enter Compliant</a>
                </h3>
                
                <div class="clearfix"></div>
                
                <?php if(isset($InvestCompliants)){ ?>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair hasFilters" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">Compliant Category </th>
                                <th class="uk-text-center">Compliant Description</th>
                                <th class="uk-text-center">ID Details</th>
                                <th class="uk-text-center">Compliant Mode</th>
                                <th class="uk-text-center">Details</th>
                                <th class="uk-text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $p=1;
//                            echo "<pre>";
//                            print_r($InvestCompliants);
                            for($i=0;$i<count($InvestCompliants);$i++)
                      {
                                $ctr = (($this->params['paging']['CAInvestigation']['page']*$this->params['paging']['CAInvestigation']['limit'])-$this->params['paging']['CAInvestigation']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-small uk-text-center uk-text-muted uk-text-nowrap"><?php echo $p; ?> </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php  if($InvestCompliants[$i]['CAInvestigation']['compliant_category'] == '1'){
                                        echo "Anonymous Whistle blower";
                                    }elseif($InvestCompliants[$i]['CAInvestigation']['compliant_category'] == '2'){
                                        echo "Public Servant";
                                    }elseif($InvestCompliants[$i]['CAInvestigation']['compliant_category'] == '3'){
                                        echo "Others";
                                    }
                                    ?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $InvestCompliants[$i]['CAInvestigation']['compliant_description'];?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $InvestCompliants[$i]['CAInvestigation']['id_details'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php  if($InvestCompliants[$i]['CAInvestigation']['mode_of_compliant_received'] == '1'){
                                        echo "Email";
                                    }elseif($InvestCompliants[$i]['CAInvestigation']['mode_of_compliant_received'] == '2'){
                                        echo "Physical Mail";
                                    }
                                    ?></span>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><button class="md-btn" data-uk-modal="{target:'#modal_large'}" onclick="ShowDet(<?php echo $InvestCompliants[$i]['CAInvestigation']['id'];?>)">View</button></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                      <?php 
                                      if($InvestCompliants[$i]['CAInvestigation']['current_status'] == null){
                                      ?>
                                        <a class="uk-badge uk-badge-success" href="<?php echo $this->Html->url('/ComplianceAudit/compliant_invest_edit/' . base64_encode($InvestCompliants[$i]['CAInvestigation']['id'])); ?>">Edit</a>
                                    | <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/ComplianceAudit/compliant_invest_edit/' . base64_encode($InvestCompliants[$i]['CAInvestigation']['id'])."/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                                    | <a class="uk-badge uk-badge-primery" href="<?php echo $this->Html->url('/ComplianceAudit/compliant_invest_edit/' . base64_encode($InvestCompliants[$i]['CAInvestigation']['id'])."/del/send"); ?>" onclick="return confirm('Are you sure?');">Send to CEO</a>
                                      <?php  /*}elseif($InvestCompliants[$i]['CAInvestigation']['current_status'] == '2' && $InvestCompliants[$i]['CAInvestigation']['ceo_action'] == '2'){?>
                                    <a class="uk-badge uk-badge-warning" href="<?php echo $this->Html->url('/ComplianceAudit/compliant_invest_documents/' . base64_encode($InvestCompliants[$i]['CAInvestigation']['id'])); ?>">Upload Final Documents</a>
                                      <?php }else{ **/ }else{?>
                                    <span class="uk-badge uk-badge-success" >Compliant Forwarded</span>
                                      <?php }?>
                                    </span></td>
                            </tr>
                            <?php  
                            $p++;
                            
                            } ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                 <div  class="uk-width-medium-1-1">           
                        <ul class="uk-pagination uk-pagination-right">
                                <?php
                                  echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                  echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                ?>
                            </ul>
                    </div>
                    
            <?php } ?>
            </div>
        </div>
   </div>
</div>

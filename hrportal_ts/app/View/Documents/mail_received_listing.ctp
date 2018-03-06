<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media:960 }">
            <h1>Mails Received </h1> 
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">
                   Mails List
                </h3>
                
                <div class="clearfix"></div>
                <?php if(isset($ar)){?>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Serial No.</th>
                                <th>Received From</th>
                                <th>Date of Receiving</th>
                                <th>Subject</th>
                                <th>Remark</th>
                                <th>Reference</th>
                                <th>Uploaded Mails</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $p=1;
                           
                            for($i=0;$i<count($ar);$i++)
                      {
                                $ctr = (($this->params['paging']['MailOffice']['page']*$this->params['paging']['MailOffice']['limit'])-$this->params['paging']['MailOffice']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-small uk-text-center"><?php echo $ctr; ?> </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ar[$i]['MailOffice']['serial_no'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ar[$i]['MailOffice']['receive_from'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($ar[$i]['MailOffice']['receiving_date']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <a  data-uk-tooltip="{cls:'long-text'}" title="<?php echo $this->Common->processtext($ar[$i]['MailOffice']['subject']); ?>">
                                        <?php if($ar[$i]['MailOffice']['subject']!='' || $ar[$i]['MailOffice']['subject']=='NA'){ 
                                      echo substr($ar[$i]['MailOffice']['subject'],0,26);
                                      if(strlen($ar[$i]['MailOffice']['subject'])>26){
                                          echo "....";
                                          ?>
                                         <?php
                                           }
                                        }else{
                                            echo "NA";
                                        }
                                         ?>
                                           </a>
                                    </span></td>
                                <td>
                                    <span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a  data-uk-tooltip="{cls:'long-text'}" title="<?php echo $this->Common->processtext($ar[$i]['MailOffice']['remark']); ?>">
                                        <?php if($ar[$i]['MailOffice']['remark']!='' || $ar[$i]['MailOffice']['remark']=='NA'){ 
                                      echo substr($ar[$i]['MailOffice']['remark'],0,26);
                                      if(strlen($ar[$i]['MailOffice']['remark'])>26){
                                          echo "....";
                                          ?>
                                         <?php
                                           }
                                        }else{
                                            echo "NA";
                                        }
                                         ?>
                                           </a>
                                    </span>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <a  data-uk-tooltip="{cls:'long-text'}" title="<?php echo $this->Common->processtext($ar[$i]['MailOffice']['reference']); ?>">
                                        <?php if($ar[$i]['MailOffice']['reference']!='' || $ar[$i]['MailOffice']['reference']=='NA'){ 
                                      echo substr($ar[$i]['MailOffice']['reference'],0,26);
                                      if(strlen($ar[$i]['MailOffice']['reference'])>26){
                                          echo "....";
                                          ?>
                                         <?php
                                           }
                                        }else{
                                            echo "NA";
                                        }
                                         ?>
                                           </a>
                                    </span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <span>
                                            <?php if(!empty($ar[$i]['MailOffice'])){ ?>
                                            <a data-uk-modal="{target:'#modal_overflow_response'}" onclick="return viewFiles(<?php echo $ar[$i]['MailOffice']['id'];?>)" alt="View Files" title="View Files" class="uk-badge uk-badge-primary">View Mails</a></span>
                                            <?php }else{
                                                echo "NA";
                                            } ?>
                                </td>
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
                           <?php }else{ ?>
                        <div data-uk-alert="" class="uk-alert"> Right Now No Details !!!</div>                 
                    <?php } ?>
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
        function viewFiles(caseDetID){ 
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>ComplianceAudit/report_attach_files/'+caseDetID,
            success: function(data){
             //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
    
    
        
    </script>

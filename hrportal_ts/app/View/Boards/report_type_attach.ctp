<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media:960 }">
            <h1>Report Type Attachment Details </h1> 
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">
                   Attachment List
                
                <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('report_type_attach_save'); ?>">Enter Attachment Details</a></h3>
                
                <div class="clearfix"></div>
                <?php if(isset($ar)){?>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Report Type</th>
                                <th>Remark</th>
                                <th>Uploaded Date</th>
                                <th>Uploaded Files</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $p=1;
                           
                            for($i=0;$i<count($ar);$i++)
                      {
                                $ctr = (($this->params['paging']['BMReportTypeAttachment']['page']*$this->params['paging']['BMReportTypeAttachment']['limit'])-$this->params['paging']['BMReportTypeAttachment']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-small uk-text-center"><?php echo $ctr; ?> </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->common->getDataEntryTypebyID($ar[$i]['BMReportTypeAttachment']['data_type_id']);?></span></td>
                                <td>
                                    <span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php if($ar[$i]['BMReportTypeAttachment']['remark']!=''){
                                        echo ucfirst(substr(wordwrap($ar[$i]['BMReportTypeAttachment']['remark'],24,"<br>\n"),0,30));
                                        if(strlen($ar[$i]['BMReportTypeAttachment']['remark'])>=29){
                                        ?>
                                        <a data-uk-tooltip="{cls:'long-text'}" title="<?php echo ucfirst($ar[$i]['BMReportTypeAttachment']['remark']);?>">... read more</a>
                                        <?php
                                        }
                                    }else{
                                        echo "NA";
                                    }
                                    ?></span>
                                    
                                    </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($ar[$i]['BMReportTypeAttachment']['created_on']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <span>
                                            <?php if(!empty($ar[$i]['BMReportTypeAttachFiles'])){ ?>
                                            <a data-uk-modal="{target:'#modal_overflow_response'}" onclick="return viewFiles(<?php echo $ar[$i]['BMReportTypeAttachment']['id'];?>)" alt="View Files" title="View Files" class="uk-badge uk-badge-primary">View Files</a></span>
                                            <?php }else{
                                                echo "NA";
                                            } ?>
                                </td>
                                
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a class="uk-badge uk-badge-success" id="form_open" href="<?php echo $this->Html->url('report_type_attach_update/'.$ar[$i]['BMReportTypeAttachment']['id']); ?>">Edit</a>
                                        | <a class="uk-badge uk-badge-danger" id="form_open" href="<?php echo $this->Html->url('report_type_attach_update/'.$ar[$i]['BMReportTypeAttachment']['id'].'/'.$ar[$i]['BMReportTypeAttachFiles']['id'].'/del'); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                                    </span>
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
            url: '<?php echo $this->webroot ?>Boards/report_attach_files/'+caseDetID,
            success: function(data){
             //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
    
    
        
    </script>

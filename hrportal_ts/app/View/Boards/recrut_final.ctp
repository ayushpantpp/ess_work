<script>
    window.setInterval(function () {
        $('#blinkText').toggle();
    }, 700);

    function getDataTypeForm(val) {
        window.location.replace("<?php echo $this->webroot ?>Boards/data_type_detail_list/"+val);
    }
    
    function ShowDet(val,datatype){ 
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/bm_show_details/' + val+'/'+datatype,
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
        <h1>Recruitment Finalization</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        
        <?php //echo $flash = $this->Session->flash();
//        echo "<pre>";
//        print_r($RFlist);
       ?>
       
        <div class="md-card" >
            <div class="md-card-content">
                <h3 class="heading_a uk-margin-small-bottom">List of Recruitment Finalization
                
                <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('recrut_final_save'); ?>">Enter Data Type Details</a></h3>
                
                <div class="clearfix"></div>
                <?php if(isset($RFlist)){ ?>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">App Serial No.</th>
                                <th class="uk-text-center">Request Type.</th>
                                <th class="uk-text-center">Number Of Candidates</th>
                                <th>Date of Received</th>
                                <th>Subject</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $p=1;
                            
                            for($i=0;$i<count($RFlist);$i++)
                      {
                                $ctr = (($this->params['paging']['BMRecrutFinal']['page']*$this->params['paging']['BMRecrutFinal']['limit'])-$this->params['paging']['BMRecrutFinal']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-small uk-text-center uk-text-muted uk-text-nowrap"><?php echo $ctr; ?> </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $RFlist[$i]['BMRecrutFinal']['serial_num'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->common->findRequestType($RFlist[$i]['BMRecrutFinal']['request_type_id']);?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $RFlist[$i]['BMRecrutFinal']['num_of_candidates'];?></span></td>
                                <td class="uk-text-small uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($RFlist[$i]['BMRecrutFinal']['date_of_received']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $RFlist[$i]['BMRecrutFinal']['subject'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $RFlist[$i]['BMRecrutFinal']['notes'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-success" href="<?php echo $this->Html->url('/Boards/recrut_final_edit/' . $RFlist[$i]['BMRecrutFinal']['id']); ?>">Edit</a> | <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/Boards/recrut_final_edit/' . $RFlist[$i]['BMRecrutFinal']['id']."/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a></span></td>
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

<div class="uk-modal" id="modal_large">
    <div class="uk-modal-dialog uk-modal-dialog-large" >
        <button type="button" class="uk-modal-close uk-close"></button>
        <div id="showdata"></div>
    </div>
</div>
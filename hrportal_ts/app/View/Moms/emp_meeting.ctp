
<div id="page_content">
        <div id="page_content_inner">
            <h3 class="heading_b uk-margin-bottom">View Meeting</h3>
            <?php echo $flash = $this->Session->flash();?>
            <div class="md-card">
                <div class="md-card-content">
                    <?php if(isset($ar)){ ?>
                    <div class="uk-overflow-container uk-margin-bottom">                        
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                            <thead>
                                <tr>                                    
                                    <th class="uk-text-center">Sr.No.</th>
                                    <th>Meeting No.</th>
                                    <th>Subject</th>
                                    <th>Task</th>
                                    <th>Meeting Date Time</th>
                                    <th>Created By</th>
                                    <th class="filter-false remove sorter-false">Attachment</th>
                                    <th class="filter-false remove sorter-false">Response</th>
                                    <th class="filter-false remove sorter-false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //echo "<pre>";
                                //print_r($ar);
                                //die;
                          $p = 1;
                      for($i=0;$i<count($ar);$i++)
                      {
                        
                        $ctr = (($this->params['paging']['MomAssign']['page']*$this->params['paging']['MomAssign']['limit'])-$this->params['paging']['MomAssign']['limit'])+$p;?>
                     <tr>
                        <td class="uk-text-small"><?php echo $ctr; ?> </td>
                        <td class="uk-text-small"><?php echo "PSC-MOM-".$ar[$i]['MomAssign']['mid']; ?> </td>
                        <td><?php echo $ar[$i]['MomAssign']['subject'];?></td>
                        <td><?php echo $this->Common->findTaskName($ar[$i]['MomAssign']['task_id']);?></td>
                        <td><?php echo date("d-m-Y",  strtotime($ar[$i]['MomAssign']['meeting_date']))." ".$ar[$i]['MomAssign']['meeting_time'];?></td>
                        <td><?php echo $this->Common->findEmpName($ar[$i]['MomAssign']['createby']);?></td>
                        <td><?php  if($ar[$i]['MomAssign']['uploaded_file']!=Null){
                               echo "<a target='blank' href='".$this->webroot."uploads/mom/".$ar[$i]['MomAssign']['uploaded_file']."' class='md-btn md-btn-flat md-btn-flat-primary'>View File</a>"; 
                               
                               } else { echo "--N/A--";}  ?>
                        </td>
                        <td><a data-uk-modal="{target:'#modal_overflow_response'}" onclick="return getEmpResponse(<?php echo $ar[$i]['MomAssign']['id'];?>,'emp_meeting')" alt="Update Profile Picture" title="Update Profile Picture" class="uk-badge uk-badge-success">Click Here</a></td>
                        <td>
                            <a data-uk-modal="{target:'#modal_overflow'}" onclick="return getMomDetails(<?php echo $ar[$i]['MomAssign']['id'];?>)" alt="View Full Details" title="View Full Details" class="uk-badge uk-badge-success">View</a>
                        </td>
                          
                        </tr> 
                        
                     <?php $p++; }   ?>
                                
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
                        <div data-uk-alert="" class="uk-alert"> Right Now No Meeting for you. !!!</div>                 
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


<div class="uk-width-medium-1-1">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <span id="momDetails" class="verflow container"></span>            
            <div class="uk-overflow-container"></div>           
        </div>
    </div>
</div>

<div class="uk-width-medium-1-1">
    <div id="modal_overflow_response" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>

        
<script type="text/javascript" >
    function getMomDetails(momId) {        
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>moms/momdetails/' + momId,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#momDetails").html(data);
            }
        });
    }
    
    function getEmpResponse(momId,empMeeting){   
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>moms/response?momID='+momId+ '&empMeeting='+empMeeting,
            success: function(data){
          //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }

</script>
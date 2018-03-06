<div id="page_content">
        <div id="page_content_inner">
            <h3 class="heading_b uk-margin-bottom">View Meeting</h3>
            <?php echo $flash = $this->Session->flash();?>
            <span class="momStatus"></span>
            <div class="md-card">
                <div class="md-card-content">                    
                    <?php echo $this->Form->create('mom', array('url' =>array('controller' => 'moms', 'action' =>'viewMeeting'),'id'=>'form_validation','class' => 'uk-form-stacked')); ?>
                    <div class="uk-overflow-container uk-margin-bottom">
                        
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                            <thead>
                                <tr>                          
                                    <th class="filter-false remove sorter-false"><input type="checkbox" class="ts_checkbox_all"></th>
                                    <th>Meeting No.</th>
                                    <th>Subject</th>
                                    <th>Task</th>
                                    <th>Date Time</th>                           
                                    <th class="filter-false remove sorter-false">Attachment</th>
                                    <th class="filter-false remove sorter-false">Response</th>
                                    <th class="filter-false remove sorter-false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                      if(isset($ar)){
                          $p = 1;
                      for($i=0;$i<count($ar);$i++)
                      {
                        
                        $ctr = (($this->params['paging']['MomAssign']['page']*$this->params['paging']['MomAssign']['limit'])-$this->params['paging']['MomAssign']['limit'])+$p;
                        if($ar[$i]['MomAssign']['meeting_status'] == 5){
                            $meetingStatus = "checked='checked'";
                            $rowClass      = "row_highlighted";
                        }else{
                            $meetingStatus = "";
                            $rowClass      = "";
                        }
                        
                        ?>
                    <tr class="<?=$rowClass;?>">               
                        <td><input type="checkbox" data-md-icheck  <?php echo $meetingStatus;?> name="id[]" class="ts_checkbox" value="<?php echo $ar[$i]['MomAssign']['id'];?>"></td>
                        <td class="uk-text-small"><?php echo "PSC-MOM-".$ar[$i]['MomAssign']['mid']; ?> </td>
                        <td><?php echo $ar[$i]['MomAssign']['subject'];?></td>
                        <td><?php echo $this->Common->findTaskName($ar[$i]['MomAssign']['task_id']);?></td>
                        <td><?php echo date("d-m-Y",  strtotime($ar[$i]['MomAssign']['meeting_date']))." ".$ar[$i]['MomAssign']['meeting_time'];?></td>                       
                        <td><?php  if($ar[$i]['MomAssign']['uploaded_file']!= Null){
                               echo "<a target='blank' href='".$this->webroot."uploads/mom/".$ar[$i]['MomAssign']['uploaded_file']."' class='uk-text-small md-btn md-btn-flat md-btn-flat-primary'>View File</a>"; 
                               
                               } else { echo "<span class='uk-text-small'>--N/A--</span>";}  ?>
                        </td>
                        <td><a data-uk-modal="{target:'#modal_overflow_response'}" onclick="return getEmpResponse(<?php echo $ar[$i]['MomAssign']['id'];?>)" alt="Update Profile Picture" title="Update Profile Picture" class="uk-badge uk-badge-success">Click Here</a></td>
                        <td>
                            <a data-uk-modal="{target:'#modal_overflow'}" onclick="return getMomDetails(<?php echo $ar[$i]['MomAssign']['id'];?>)" alt="View Full Details" title="View Full Details" class="uk-badge uk-badge-success">View</a>
                            <a href="<?php echo $this->webroot;?>moms/momedit/<?php echo $ar[$i]['MomAssign']['id'];?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a>
                            <a href="momdelete/<?php echo $ar[$i]['MomAssign']['id'];?>"  title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a>
                        </td>                          
                    </tr> 
                        
                     <?php $p++; } }  ?>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="hobbies" class="uk-form-label">Meeting Status (1 minimum):</label>
                                <span class="icheck-inline">
                                    <input type="radio" value="5" name="meeting_status" id="meeting_status" required="" data-md-icheck />
                                    <label for="val_check_ski" class="inline-label">Finalized</label>
                                </span>
                                <span class="icheck-inline">
                                    <input type="radio" value="2" name="meeting_status" id="meeting_status" data-md-icheck />
                                    <label for="val_check_run" class="inline-label">Not Finalized</label>
                                </span>                              
                            </div>
                            <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Status Update</button>
                            <a href="<?php echo $this->Html->url('/moms/viewMeeting') ?>"><input type="button" name="reset" class="md-btn md-btn-primary" value="Reset" ></a>
                                
                        </div>
                        <div class="uk-width-medium-1-2">
                            <ul class="uk-pagination uk-pagination-right">
                                <?php
                                  echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                  echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php echo $this->Form->end();?>
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
    
    function getMomStatus(momId) {        
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>moms/momstatus/' + momId,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#momStatus").html(data);
            }
        });
    }

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
    
    function getEmpResponse(momId){   
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>moms/response/'+momId,
            success: function(data){
          //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }

</script>

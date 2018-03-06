<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">

        </div>
        <h1>Separation</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card" >
            <div class="md-card-content">
                <h3 class="heading_a uk-margin-small-bottom">List of Separation</h3>

                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Pending task</th>
                                <th>Assignee</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Completed date</th>
                            </tr>
                        </thead>
                        <tbody>
                    
                    <?php 
                    $ctr =1;
                    
                    foreach ($fnfs['FnfDetail'] as $value) {

                      ?>
                    <tr>
                      <td class="uk-text-small uk-text-center uk-text-muted uk-text-nowrap"><?php echo $ctr;?></td>
                      <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $value['Project']['name'];?></span></td>
                      <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $value['MyProfile']['emp_name'];?></span></td>
                      <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->findSatus($value['status']);?></span></td>
                      <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $value['approver_remark'];?></span></td>
                      <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo ($value['completion_date'])?date("d-M-Y",strtotime($value['completion_date'])):'NA';?></span></td>
                      
                    </tr>
                    <?php $ctr++;
                    }?>
                        </tbody>
                    </table>
                   <div class="col-md-12"> 
                  
                  <?php if(!isset($fnfs['Fnf']['status']) ) { ?>
                    <a class="btn btn-success" href="<?php echo $this->Html->url('/separations/add');?>"> Apply for separations first</a>
                  <?php }
                  else { 
                    ?> 
                    <label class="control-label"> FNFS status :</label>
                    <?php echo $this->Common->findSatus($fnfs['Fnf']['status']);?><br/>
                  <?php if($fnfs['Fnf']['status'] == 4) { /*
                    echo $this->Html->link('Edit', array('action'=>'fnf_edit',$fnfs['Fnf']['id']));*/
                    ?>
                     <label class="control-label"> FNFS Reject Remark :</label>
                      <?php echo $fnfs['Fnf']['reject_remark'];?><br/>
                    <?php
                   }

                  }
                  ?>
                  </div>
                    <div class="uk-grid" data-uk-grid-margin></div>
                    <br/>
                </div>
            </div>   
        </div>
    </div>
</div>
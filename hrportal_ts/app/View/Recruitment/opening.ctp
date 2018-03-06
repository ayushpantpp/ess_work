<style>
#grab {cursor: grab;}
</style>
<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="overflow container"></span>
            </div>          
        </div>
    </div>
</div>


<?php $i = 0; ?>
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  
        <div class="md-card-toolbar">
          

                            <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    //echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Latest Opening  List</b>
                            </h3>
                        </div>

            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>                
                                <th>Sr.No</th>
                                <th>Position Name</th>
                                 <th>Position Type</th>
                                 <th>Hiring Type</th>
                                <th>Department</th>
                                <th>Designation</th>
                                 <th>Location</th>
                                <th>Request Raised By</th>
                                <th>Expected On Boarding Date</th>
                                
                                <th>Required Experience</th>
                                <th>Download JD</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $auth = $this->Session->read('Auth');
                        

                            $i = 1;
                           
                            if (!empty($requirelist)) {

                                foreach ($requirelist as $list) {
                                    if ($list['RequirementDetail']['status'] == 1) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($list['RequirementDetail']['status']);
                                    } elseif ($list['RequirementDetail']['status'] == 2) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($list['RequirementDetail']['status']);
                                    } elseif ($list['RequirementDetail']['status'] == 3) {
                                        $btnClass = "uk-badge uk-badge-warning";
                                        $btnStatus = $this->Common->findSatus($list['RequirementDetail']['status']);
                                    } elseif ($list['RequirementDetail']['status'] == 4) {
                                        $btnClass = "uk-badge uk-badge-danger";
                                        $btnStatus = $this->Common->findSatus($list['RequirementDetail']['status']);
                                    } elseif ($list['RequirementDetail']['status'] == 5) {
                                        $btnClass = "uk-badge uk-badge-success";
                                        $btnStatus = $this->Common->findSatus($list['RequirementDetail']['status']);
                                    } else {
                                        $btnClass = "uk-badge uk-badge-danger";
                                        $btnStatus = $this->Common->findSatus($list['RequirementDetail']['status']);
                                    }
                                    ?>    
                                    <tr> 
                                        <td><?php echo $i; ?></td> 
                                        <td><?php echo $list['RequirementDetail']['position_name'];?></td>
                                        <td><?php if($list['RequirementDetail']['position_type']==2){echo 'Replacement';}else{ echo "NEW";}?></td>
                                        <td><?php if($list['RequirementDetail']['hiring_type']==1){echo 'Internal';}elseif($list['RequirementDetail']['hiring_type']==2) { echo "External";}else{ echo "Internal & External ";
                                        }?></td>
                                        <td><?php echo $this->Common->getdepartmentbyid($list['RequirementDetail']['dept_code']);?></td>   
                                        <td><?php echo $this->Common->findEmployeeGroupNameByCode($list['RequirementDetail']['desg_code']); ?></td>
                                           <td><?php echo $this->Common->findLocationNameByCode($list['RequirementDetail']['location_name']); ?></td>
                                        <td><?php echo $this->Common->findEmpnamebycode($list['RequirementDetail']['user_raised']);?></td>
                                        <td><?php echo date('d-M-Y', strtotime($list['RequirementDetail']['max_join_date'])); ?></td>
                                        
                                        <td>
                                        <?php echo  $list['RequirementDetail']['required_exp']; ?></td>
                                    <td> <a class="uk-badge uk-badge-sucess" href="<?php echo $this->webroot.'Recruitment/download1/'.base64_encode($list['RequirementDetail']['req_id']); ?>"><?php echo "Download"; ?></a></td>   
                                        <td>

                                            <input type="hidden" name="Element To Be Copied" id="copy-me" value="<?php echo "localhost". $this->webroot; ?>Recruitment/candidateprofile/<?php echo base64_encode($list['RequirementDetail']['id']);?>"/>
                                          <!--   <input type="hidden" value="<?php //echo $this->webroot; ?>Recruitment/candidateprofile/<?php //echo base64_encode($list['RequirementDetail']['id']);?>" id="link"> -->
                                          <br>
                                          <a class="uk-badge uk-badge-primary" id="fw-code-copy-button" onclick="alert('Link copied');">Copy Link</a><br/><br/>
                                           <code style="display:none"> <?php echo $_SERVER['SERVER_NAME']. $this->webroot; ?>Recruitment/candidateprofile/<?php echo base64_encode($list['RequirementDetail']['id']);?></code>
                                            <!-- <a  onclick="copyLink()" class="uk-badge uk-badge-success" title="Click to copy link." >Copy Link</a> -->
                                            
                                            <!-- </li> -->
                                            <?php $status = $this->Common->findSatus($list['RequirementDetail']['status']); 
                                           
                                            ?>

                                            <?php if ($status == 'Parked' || $status == 'Rejected') { ?>
                                                <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>Recruitment/editSubmit/<?php echo base64_encode($list['RequirementDetail']['id']); ?>/" title="Click to Edit.">Edit</a>

                                            <?php } ?>

                                            <?php if ($status == 'Parked' || $status == 'Posted') { ?>
                                                <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>Recruitment/deleteLeaveDetails/<?php echo base64_encode($list['RequirementDetail']['id']); ?>/" title="Click to Edit." onclick="return confirm('Are you sure?')" >Delete</a>    
                                                <?php
                                            }
                                            if (!empty($leave_level_sequence[$i - 1]) && $status != 'Rejected'):
                                                if ($leave_level_sequence[$i - 1]['WfDtAppMapLvl']['lvl_sequence'] <= $max_level_sequence && $leave_level_sequence[$i - 1] != null) :
                                                    ?>
                                                    <!-- <li style="border-right:none;"> -->
                                                    <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>Recruitment/revoke/<?php echo base64_encode($list['RequirementDetail']['leave_id']); ?>/" title="Click to Revoke.">Revoke</a>
                                                    <!-- </li> -->
                                                    <?php
                                                endif;
                                            endif;
                                            ?>

                                            <!-- </ul> -->
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            else {
                                ?>

                                <tr>
                                    <td colspan="12">
                                        No records found
                                    </td>
                                </tr>
                                <?php
                            }
                            ?> 

                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
                             

                            <?php
                            echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                            echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            ?>
                        </ul>
                    </div>

                </div>

            </div>

            <div id="container" ></div>
        </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.3/clipboard.min.js"></script>
       <script type="text/javascript">
         
new Clipboard("#fw-code-copy-button", {
  text: function(trigger) {
    return $(trigger).parent().find('code').first().text().trim();
  }
});
function get_paginate(val)
  {   
//var page= $("#paginate").val(val);
  window.location.href="<?php echo $this->webroot;?>Recruitment/view/"+val; 


 }

 </script>
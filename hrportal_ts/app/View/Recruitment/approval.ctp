<div id="page_content">
    <div id="page_content_inner">
    <?php echo $flash = $this->Session->flash(); ?>
       
        

        <span class="momStatus"></span>
              <div class="md-card">  
        <div class="md-card-toolbar">
          

                            <div class="md-card-toolbar-actions">
               <!--                 <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div> -->
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Requisition Approval List</b>
                            </h3>
                            
                          

                        
                            </div>
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">   
                    <table  class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false">Sr.No</th>
                               
                                <th>Position Name</th>
                                 <th>Position Type</th>
                                <th>Department Name </th>
                                <th>Designation Name</th>
                                <th>Location</th>                                    
                                <th>Requisition Raised BY</th>
                                <th>Expected On Boarding Date</th>
                                 <th>Requisition Raised Date</th>
                                 <th>Download JD</th>
                                 <th>Status</th>
                                <th class="filter-false remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $auth = $this->Session->read('Auth'); ?>
                            <?php if (count($pending_Requisition) == 0) { ?>
                                <tr class="cont">
                                    <td style="text-align:center;" colspan="8">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php
                            $i = 1;
                            foreach ($pending_Requisition as $pending_detail) {

                                $empname = $this->Common->getempinfo($pending_detail['RequirementDetail']['user_raised']);
                                @$ctr = (($this->params['paging']['RequirementDetail']['options']['page'] * $this->params['paging']['RequirementDetail']['options']['limit']) - $this->params['paging']['RequirementDetail']['options']['limit']) + $i;
                                ?>
                                <tr>
                                    <td><?php echo $ctr; ?></td>
                                    
                                    <td><?php echo $pending_detail['RequirementDetail']['position_name'] ; ?></td>
                                    <td><?php if($pending_detail['RequirementDetail']['position_type']==1){ echo "New";}
                                    else{
                                        echo "Replacement";
                                    }
                                        ; ?></td>
                                    <td><?php echo $this->Common->getdepartmentbyid($pending_detail['RequirementDetail']['dept_code']); ?>
                                    </td>
                                    <td><?php echo $this->Common->findEmployeeGroupNameByCode($pending_detail['RequirementDetail']['desg_code']); ?>
                                    </td>
                                    <td><?php echo $this->Common->findLocationNameByCode($pending_detail['RequirementDetail']['location_name']); ?>
                                    </td>
                                        <td><?php echo $this->Common->findEmpnamebycode($pending_detail['RequirementDetail']['user_raised']); ?></td>
                                        <td>
                                            <?php echo date('d-M-Y', strtotime($pending_detail['RequirementDetail']['max_join_date']));?>
                                        </td>

                                        <td>
                                           <?php 


                                            echo date('d-M-Y', strtotime($pending_detail['RequirementDetail']['created_date']));?>
                                        </td>
                                         <td> <a class="uk-badge uk-badge-success" href="<?php echo $this->webroot.'Recruitment/download1/'.base64_encode($pending_detail['RequirementDetail']['req_id']); ?>" ><?php echo "Download"; ?></a> </td>
                                        <td>   <?php if ($pending_detail['RequirementDetail'] == 1) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($pending_detail['RequirementDetail']['status']);
                                    } elseif ($pending_detail['RequirementDetail']['status'] == 2) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($pending_detail['RequirementDetail']['status']);
                                    } elseif ($pending_detail['RequirementDetail']['status'] == 6) {
                                        $btnClass = "uk-badge uk-badge-warning";
                                        $btnStatus = $this->Common->findSatus($pending_detail['RequirementDetail']['status']);
                                    } elseif ($pending_detail['RequirementDetail']['status'] == 4) {
                                        $btnClass = "uk-badge uk-badge-danger";
                                        $btnStatus = $this->Common->findSatus($pending_detail['RequirementDetail']['status']);
                                    } elseif ($pending_detail['RequirementDetail']['status'] == 5) {
                                        $btnClass = "uk-badge uk-badge-success";
                                        $btnStatus = $this->Common->findSatus($pending_detail['RequirementDetail']['status']);
                                    } else {
                                        $btnClass = "uk-badge uk-badge-warning";
                                        $btnStatus = $this->Common->findSatus($pending_detail['RequirementDetail']['status']);
                                    }

                                    ?>
                                       <a class="<?php echo $btnClass;?>"> <?php echo $btnStatus ; ?></a> 

                                    </td>
                                    <td>
                                       
                                            <!-- <ul class="edit-delete-icon">
                                                <li> -->
                                                    <?php 
if ($pending_detail['RequirementDetail']['position_type']==1)
{
 $getlevel=$this->Common->findAppLevel('22');
}
else{

$getlevel=$this->Common->findAppLevel('10');

}
$hr_approval_status=$this->Common->findappstatus($pending_detail['RequirementDetail']['req_id']);

if ($hr_approval_status==2&&$pending_detail['RequirementDetail']['status']==2||($hr_approval_status!=0&&$pending_detail['RequirementDetail']['hr_approval_status']==6&&$hr_approval_status!=3&&$pending_detail['RequirementDetail']['status']!=4))
{




  ?>
                                           
                    <?php  echo $this->Html->link('Proceed','forward_req/'.base64_encode($pending_detail['RequirementDetail']['id']),array('class'=>'uk-badge uk-badge-success'));?>
                   <!--  <?php  echo $this->Html->link('Edit','editSubmit/'.base64_encode($pending_detail['RequirementDetail']['id']),array('class'=>'uk-badge uk-badge-success'));?> -->
                  <!-- <a href="#popup1" data-uk-modal="{ center:true }" class="uk-badge uk-badge-danger"
                                       onclick="Get_Details('<?php echo $pending_detail['RequirementDetail']['id']; ?>')" class="view vtip" title="Click to Reject.">Reject</a> --></td><?php }
                                     
$level=$this->Common->findreqlevel($pending_detail['RequirementDetail']['req_id']);


            if(($hr_approval_status==3)) { 

                                        ?>
                                     <?php 
                                     echo $this->Html->link('Proceed','forward_req/'.base64_encode($pending_detail['RequirementDetail']['id']),array('class'=>'uk-badge uk-badge-success'));?><!-- / <?php  echo $this->Html->link('Edit','editSubmit/'.base64_encode($pending_detail['RequirementDetail']['id']),array('class'=>'uk-badge uk-badge-success'));?>/ -->
                 <!--  <a href="#popup1" data-uk-modal="{ center:true }" class="uk-badge uk-badge-danger"
                                       onclick="Get_Details('<?php echo $pending_detail['RequirementDetail']['id']; ?>')" class="view vtip" title="Click to Reject.">Reject</a> --></td>
                                      
                                       <?php }
                                       $hrlist=$this->common->gethrmasterlist(10);
									   
									  $emp_code=$auth['User']['emp_code'];
									 
                                       if ($pending_detail['RequirementDetail']['status'] == 5 && in_array($emp_code,$hrlist))
                                       {

                                       

                                     

                                       ?>
    
 <a  class="<?php echo $btnClass;?>" href="<?php echo $this->Html->url('select_consultant/'.$pending_detail['RequirementDetail']['req_id']); ?>" ><?php echo "Send Mail"; ?></a> 

                                    </td>

                                </tr>
    <?php $i++;
}
} ?>

                        </tbody>

                        <div id="dialog" title="Remark/Comment" style="display:none">
                            <div>
                                <textarea  name="reject_reson" id="cmnt" col="100" row="100" style="width: 600px; height:200px;" onKeypress="getcmtval()" > </textarea>
                                <div class="ui-widget" id="errdis" style="display:none">
                                    <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
                                        <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                            <strong></strong> Please write rejection reason.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="wf_id" name="wf_id" value=''/>
                        <input type="hidden" id="leaveno" name="leave_no" value=""/>
                        <input type="hidden" id="ccode" name="comp_code" value=""/>
                        <input type="hidden" id="stdate" name="start_date" value=""/>
                        <input type="hidden" id="eddate" name="end_date" value=""/>
                        <input type="hidden" id="rejectres" name="rejectreson" value=""/>
                    </table>
                </div>
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
        </div>
    </div>
</div>
      
 <div class="uk-modal" id="popup1">
    <div class="uk-modal-dialog">
        <div class= "HRcontent"></div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>

  <script type="text/javascript">
    function Get_Details(id)
{   
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>Recruitment/rejectId/'+id,
        success: function(data){
            //alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
 }
function get_paginate(val)
  {   
//var page= $("#paginate").val(val);
  window.location.href="<?php echo $this->webroot;?>leaves/approval/"+val; 


 }
 </script>
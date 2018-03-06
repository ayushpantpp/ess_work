<div id="page_content">
    <div id="page_content_inner">
    <?php echo $flash = $this->Session->flash(); ?>
       
        

        <span class="momStatus"></span>
              <div class="md-card">  
        <div class="md-card-toolbar">
          

                            <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    //echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Leave Approval List</b>
                            </h3>
                            
                          

                        
                            </div>
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">   
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false">Sr.No</th>
                                <th>Name</th>
                                <th>Applied Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>                                    
                                <th>Medical</th>
                                <th class="filter-false remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $auth = $this->Session->read('Auth'); ?>
                            <?php if (count($pending_leave_employee) == 0) { ?>
                                <tr class="cont">
                                    <td style="text-align:center;" colspan="8">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php
                            $i = 1;
                            foreach ($pending_leave_employee as $pending_detail) {
                                $empname = $this->Common->getempinfo($pending_detail['LeaveDetail']['emp_code']);
                                @$ctr = (($this->params['paging']['LeaveDetail']['options']['page'] * $this->params['paging']['LeaveDetail']['options']['limit']) - $this->params['paging']['LeaveDetail']['options']['limit']) + $i;
                                ?>
                                <tr>
                                    <td><?php echo $ctr; ?></td>
                                    <td><?php echo $empname; ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($pending_detail['MstEmpLeave']['applied_date'])); ?>
                                    </td>
                                    <td><?php echo date("d-m-Y", strtotime($pending_detail['MstEmpLeave']['start_date'])); ?>
                                    </td>
                                    <td><?php echo date("d-m-Y", strtotime($pending_detail['MstEmpLeave']['end_date'])); ?>
                                    </td>
                                        <?php if (empty($pending_detail['MstEmpLeave']['leave_image']) && $pending_detail['LeaveDetail']['leave_code'] != 'PAR0000527') { ?>
                                        <td>N/A</td>
                                        <?php } else { ?> <td><a href="<?php echo $this->webroot . $pending_detail['MstEmpLeave']['leave_image']; ?>" target = 'blank'>Download</a></td> <?php } ?>
                                    <td>
                                        <?php
                                        if ($pending_detail['LeaveWorkflow']['status'] == '4') {
                                            echo "<span class='uk-badge uk-badge-danger'>".$this->Common->findSatus(4)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['fw_date'] != null && $pending_detail['LeaveDetail']['leave_status'] == '6') {
                                            echo "<span class='uk-badge uk-badge-danger'>".$this->Common->findSatus(6)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['status'] == '5') {
                                            echo "<span class='uk-badge uk-badge-success'>".$this->Common->findSatus(5)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['fw_date'] == null && $pending_detail['LeaveWorkflow']['status'] == '3') {
                                            echo "<span class='uk-badge uk-badge-primary'>".$this->Common->findSatus(3)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['fw_date'] != null && $pending_detail['LeaveDetail']['leave_status'] == '2') {
                                            echo "<span class='uk-badge uk-badge-primary'>".$this->Common->findSatus(2)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['fw_date'] == null && $pending_detail['LeaveDetail']['leave_status'] != '5') {
                                            ?>
                                            <!-- <ul class="edit-delete-icon">
                                                <li> -->
                                            <a class="uk-badge uk-badge-warning" href="<?php
                                            echo $this->webroot . 'leaves/editleave/'
                                            . base64_encode($pending_detail['MstEmpLeave']['comp_code'])
                                            . '/' . base64_encode($pending_detail['MstEmpLeave']['leave_id'])
                                            . '/' . base64_encode($pending_detail['MstEmpLeave']['emp_code'])
                                            ;
                                            ?>"  Title="Process Leave">Approve/Reject</a>
                                            <!-- </li> -->
                                            <!-- <li style="border:none;">
                                                <a href="<?php
                                            echo $this->webroot . 'leaves/editleave/'
                                            . base64_encode($pending_detail['MstEmpLeave']['comp_code'])
                                            . '/' . base64_encode($pending_detail['MstEmpLeave']['leave_id'])
                                            . '/' . base64_encode($pending_detail['MstEmpLeave']['emp_code'])
                                            ?>" id="dialog_link" class="icon-thumbs-down" title="Reject" >

                                                </a>
                                            </li> -->
                                            <!-- </ul> -->
    <?php } ?>
                                            <a data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Details('<?php echo $pending_detail['MstEmpLeave']['leave_id']; ?>')" class="uk-badge uk-badge-success" title="Click to View." >View</a>
                                            

                                    </td>

                                </tr>
    <?php $i++;
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
  <script type="text/javascript">
function get_paginate(val)
  {   
//var page= $("#paginate").val(val);
  window.location.href="<?php echo $this->webroot;?>leaves/approval/"+val; 


 }
 function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/leavedetail/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
 </script>

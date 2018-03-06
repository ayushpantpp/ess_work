<script type="text/javascript">
    $(function () {
        history.pushState(null, null, location.href);
        window.onpopstate = function (event) {
            history.go(1);
        };

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            modal: true,
            buttons: {
                "Ok": function () {
                    var cmnt = $('#cmnt').val();
                    if (cmnt == ' ')
                    {
                        $('#errdis').show('slow', function () {
                            // Animation complete.
                        });
                        return false;
                    } else {
                        $(this).dialog("close");
                        document.conveyence.submit();
                    }
                },
                "Cancel": function () {
                    $(this).dialog("close");
                }
            }
        });
    });
    function reject(compcode, vno, cdate)
    {

        var compcode = document.getElementById("ccode").value = compcode;
        var conveyenceno = document.getElementById("conveyenceno").value = vno;
        var ctdate = document.getElementById("cdate").value = cdate;
        // edate=document.getElementById("eddate").value=edate;
        $('#dialog').dialog('open');
        return false;
    }

    function getcmtval()
    {
        var conveyenceno = document.getElementById("cmnt").value;
        var rjres = document.getElementById("rejectres").value = conveyenceno;
        //alert(rjres);
    }


</script>

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
                                <b>Expense Approval List</b>
                            </h3>
                        </div>

            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <?php echo $this->Form->create('Account_Conveyence', array('url' => array('controller' => 'conveyenceexpenses', 'action' => 'rejectconveyence'), 'id' => 'conveyence', 'name' => 'conveyence','class' => 'uk-form-stacked')); ?>
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false">Sr.No</th>
                                <th>Voucher ID</th>
                                <th>Name</th>
                                <th>Voucher Date</th>
                                <th>Claim Date</th>
                                <th class="filter-false remove sorter-false">Update Status</th>                                
                            </tr>
                        </thead>
                        <tbody>                           

                            <?php
                            $i = 1;
                            //pr($pending_leave_employee);
                            //pr($this->params['paging']);
                            
                            foreach ($pending_conveyence_employee as $pending_detail) {
                                $empname = $this->Common->getempinfo($pending_detail['ConveyencExpenseDetail']['emp_code']);
                                @$ctr = (($this->params['paging']['ConveyencExpenseDetail']['options']['page'] * $this->params['paging']['ConveyencExpenseDetail']['options']['limit']) - $this->params['paging']['ConveyencExpenseDetail']['options']['limit']) + $i;
                                ?>
                                <tr>
                                    <td><?php echo $ctr; ?></td>
                                    <td><?php echo $pending_detail['ConveyencExpenseDetail']['voucher_id']; ?></td>
                                    <td><?php echo $empname; ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($pending_detail['MstEmpConveyence']['voucher_date'])); ?>
                                    </td>
                                    <td><?php echo date("d-m-Y", strtotime($pending_detail['ConveyencExpenseDetail']['claim_date'])); ?>
                                    </td>
                                    <td>
                                        <?php
                                        //echo $pending_detail['ConveyencExpenseDetail']['leave_status'];
                                        //echo $pending_detail['LeaveWorkflow']['fw_date'];echo ','.$pending_detail['ConveyencExpenseDetail']['leave_status'].'<br/>';
                                        if ($pending_detail['ConveyencExpenseDetail']['conveyence_status'] == '4') {
                                            echo strtoupper($this->Common->findSatus(4));
                                        } else if ($pending_detail['ConveyenceWorkflow']['fw_date'] != null && $pending_detail['ConveyencExpenseDetail']['conveyence_status'] == '6') { ?>
                                        <a class="uk-badge uk-badge-warning" href="<?php
                                            echo $this->webroot . 'conveyence_expenses/editconveyence'
                                            . '/' . base64_encode($pending_detail['MstEmpConveyence']['voucher_id'])
                                            ;
                                            ?>" Title="Approve/Reject">Approve/Reject</a>
                                        <?php echo $this->Common->findSatus(6);
                                        } else if ($pending_detail['ConveyencExpenseDetail']['conveyence_status'] == '5') {
                                            ?> <a class="uk-badge uk-badge-success" > <?php  echo strtoupper($this->Common->findSatus(5)); ?> </a>
                                       <?php } else if ($pending_detail['ConveyenceWorkflow']['fw_date'] == null && $pending_detail['ConveyenceWorkflow']['status'] == '3') {
                                            echo strtoupper($this->Common->findSatus(3));
                                        } else if ($pending_detail['ConveyenceWorkflow']['fw_date'] != null && $pending_detail['ConveyencExpenseDetail']['conveyence_status'] == '2') {
                                            ?> <a class="uk-badge uk-badge-primary" > <?php echo strtoupper($this->Common->findSatus(2)); ?> </a>
                                      <?php  } else if ($pending_detail['ConveyenceWorkflow']['fw_date'] == null && $pending_detail['ConveyencExpenseDetail']['conveyence_status'] != '5') {
                                            ?>


                                        <a class="uk-badge uk-badge-warning" href="<?php
                                            echo $this->webroot . 'conveyence_expenses/editconveyence'
                                            . '/' . base64_encode($pending_detail['MstEmpConveyence']['voucher_id'])
                                            ;
                                            ?>" Title="Approve/Reject">Approve/Reject</a><br/>
                                          <!-- <a href="javascript:void(0)" id="dialog_link" class="icon-thumbs-down" title="Reject" onclick="return reject('<?php echo $pending_detail['MstEmpConveyence']['comp_code'] ?>','<?php echo $pending_detail['MstEmpConveyence']['voucher_id'] ?>,<?php echo $pending_detail['ConveyencExpenseDetail']['claim_date'] ?>')">
                                               Reject
                                           </a> -->
                                           <?php } ?>
                                    </td>
                                </tr>
                                        <?php $i++;
                                    } ?>

                        <div id="dialog" title="Remark/Comment" style="display:none">
                            <div>
                                <textarea  name="reject_reson" id="cmnt" col="100" row="100" style="width: 550px; height:200px;" onKeypress="getcmtval()" > </textarea>
                                <div class="ui-widget" id="errdis" style="display:none">
                                    <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
                                        <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                            <strong></strong> Please write rejection reason.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </tbody>
                        <input type="hidden" id="conveyenceno" name="conveyence_no" value=""/>
                        <input type="hidden" id="ccode" name="comp_code" value=""/>
                        <input type="hidden" id="cdate" name="cdate" value=""/>
                        <input type="hidden" id="rejectres" name="rejectreson" value=""/>
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
        </div>
    </div>
</div>

</div>
<?php $this->Form->end(); ?>
<script>


 
 function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>conveyence_expenses/approval/"+val; 

 }

</script>   

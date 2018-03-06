<script type="text/javascript">
    $(document).ready(function () {
        $('#alerts').hide();
    });

    $(function () {

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            modal: true,
            buttons: {
                "Ok": function () {
                    var cmnt = $('#cmnt').val();

                    if (cmnt === ' ')
                    {
                        $('#errdis').show('slow', function () {
                            // Animation complete.
                        });
                        return false;

                    } else {
                        $(this).dialog("close");
                        document.trvoucher.submit();
                    }

                },
                "Cancel": function () {
                    $(this).dialog("close");
                }
            }
        });


    });

</script>
<script>

    function reject(compcode, vno, sdate, edate)
    {

        var compcode = document.getElementById("ccode").value = compcode;
        var voucherno = document.getElementById("vouchno").value = vno;
        var stdate = document.getElementById("stdate").value = sdate;
        var edate = document.getElementById("eddate").value = edate;
        $('#dialog').dialog('open');
        return false;
    }

    function getcmtval()
    {
        var voucherno = document.getElementById("cmnt").value;
        var rjres = document.getElementById("rejectres").value = voucherno;

    }


         function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>travels/approval/"+val; 

 }



</script>

<div id="page_content">
    <div id="page_content_inner">
       

        <span class="momStatus"></span>
        <div class="md-card">
        <div class="md-card-toolbar">
                             <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                               <b>Travel Voucher Approval</b>
                            </h3>
                        </div>
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">


                    <?php echo $this->Form->create('Account_Voucher', array('url' => array('controller' => 'travels', 'action' => 'rejectvoucher'), 'id' => 'trvoucher', 'name' => 'trvoucher')); ?>
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>

                                <th class="filter-false remove sorter-false">Voucher No</th>
                                <th>Name</th>
                                <th>Voucher Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Balance Amount <span class="uk-text-small">(in Rs.)</span></th>
                                <th>Amount To Be Returned <span class="uk-text-small">(in Rs.)</span></th>
                                <th class="filter-false remove sorter-false">Update Status</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php if (count($pending_voucher_employee) == 0) { ?>
                                <tr>
                                    <td class="uk-text-center" colspan="7">
                                        <span class="uk-text-italic uk-text-primary">--No Records Found--</span>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php
//                            echo "<pre>";
//                            print_r($pending_voucher_employee);
//                            die('here');
                            $i = 1;
                            foreach ($pending_voucher_employee as $pending_detail) {
                                ?>
                                <tr <?php if ($i % 2 == 0) { ?>class="even-pointer" <?php } else { ?>class="odd-pointer" <?php } ?>>

                                    <td>
                                        <?php echo $pending_detail['DtTravelVoucher']['voucher_id']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $empname = $this->Common->getempinfo($pending_detail['mst']['emp_code']);
                                        echo $empname;
                                        ?>
                                    </td>                                    
                                    <td><?php echo date('d-m-Y', strtotime($pending_detail['mst']['voucher_date'])); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($pending_detail['DtTravelVoucher']['tour_start_date'])); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($pending_detail['DtTravelVoucher']['tour_end_date'])); ?></td>                                    
                                    <td><?php echo $pending_detail['DtTravelVoucher']['pending_amount']; ?></td>
                                    <td><?php echo $pending_detail['DtTravelVoucher']['return_amount']; ?></td>

                                    <td>
                                        <?php
                                       
                                        if ($pending_detail['TravelWfLvl']['voucher_status'] == '4') {
                                            echo '<span class="uk-badge uk-badge-danger">'.strtoupper($this->Common->findSatus(4))."</span>";
                                        } else if ($pending_detail['TravelWfLvl']['voucher_status'] == '6') {
                                            echo '<span class="uk-badge uk-badge-warning">'.$this->Common->findSatus(6)."</span>";
                                        } else if ($pending_detail['TravelWfLvl']['fw_date'] == null && $pending_detail['TravelWfLvl']['voucher_status'] == '5') {
                                            echo '<span class="uk-badge uk-badge-success">'.strtoupper($this->Common->findSatus(5)).'</span>';
                                        } else if ($pending_detail['TravelWfLvl']['fw_date'] == null && $pending_detail['TravelWfLvl']['voucher_status'] == '3') {
                                            echo '<span class="uk-badge uk-badge-primary">'.strtoupper($this->Common->findSatus(3))."</span>";
                                        } else if ($pending_detail['TravelWfLvl']['fw_date'] != null && $pending_detail['TravelWfLvl']['voucher_status'] == '2') {
                                            echo '<span class="uk-badge uk-badge-primary">'.strtoupper($this->Common->findSatus(2))."</span>";
                                        } else if ($pending_detail['TravelWfLvl']['fw_date'] != null && $pending_detail['TravelWfLvl']['voucher_status'] == '5') {    
                                            echo '<span class="uk-badge uk-badge-success">'.strtoupper($this->Common->findSatus(5)).'</span>';
                                        } else if ($pending_detail['TravelWfLvl']['fw_date'] == null && $pending_detail['TravelWfLvl']['voucher_status'] != '5') {
                                            
                                            ?>
                                            <a class="uk-badge uk-badge-primary" href="<?php echo $this->webroot . 'travels/edittravel/' . base64_encode($pending_detail['mst']['comp_code']) . '/' . base64_encode($pending_detail['DtTravelVoucher']['voucher_id']) . '/' . base64_encode($pending_detail['mst']['emp_code']);
                                            ?>" Title="Approved">Accept/Reject</a>
                                        <?php } ?>

                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?></tbody>
                    </table>
                    <input type="hidden" id="vouchno" name="voucher_no" value=""/>
                    <input type="hidden" id="ccode" name="comp_code" value=""/>
                    <input type="hidden" id="stdate" name="start_date" value=""/>
                    <input type="hidden" id="eddate" name="end_date" value=""/>
                    <input type="hidden" id="rejectres" name="rejectreson" value=""/>


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
    <div id="dialog" title="Remark/Comment" style="display:none">

        <textarea  name="reject_reson" id="cmnt" border='0' col="100" row="100" style="width: 600px; height:200px;" onKeypress="getcmtval()" > </textarea>
        <div class="ui-widget" id="errdis" style="display:none">
            <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
                <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                    <strong></strong> Please write rejection reason.</p>
            </div>
        </div>

    </div>

    <?php $this->Form->end(); ?>



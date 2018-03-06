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

<script>
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>medical/medicaldetailapproval/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
</script>

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


</script>

<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Medical Approval</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <span class="momStatus"></span>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">                    
                    <?php echo $this->Form->create('medical', array('url' => array('controller' => 'medical', 'action' => 'rejectvoucher'), 'id' => 'trvoucher', 'name' => 'trvoucher', 'class' => 'uk-form-stacked')); ?>
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false">Sr.No.</th>
                                <th>Name</th>
                                <th>Applied Date</th>
                                <th>Bill Amount </th>
                                <th>Location Type </th>
                                <th>View Bill</th>
                                <th class="filter-false remove sorter-false">Update Status</th>
                            </tr>
                        </thead>
                        <tbody>
 
                            <?php if (count($pending_medical_employee) == 0) { ?>
                                <tr class="even pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php
                            $i = 1;
                            foreach ($pending_medical_employee as $pending_detail) {
                                $empname = $this->Common->getempinfo($pending_detail['MedicalBillAmount']['emp_code']);
                                ?>
                                <tr>
                                    <td><?php echo $ctr = (($this->params['paging']['MedicalBillAmount']['page']*$this->params['paging']['MedicalBillAmount']['limit'])-$this->params['paging']['MedicalBillAmount']['limit'])+$i;?></td>
                                    <td><?php echo $empname;?></td>                                    
                                    <td><?php echo date('d-M-Y', strtotime($pending_detail['MedicalBillAmount']['created_at'])); ?></td>
                                    <td><?php echo $pending_detail['MedicalBillAmount']['bill_amount']; ?></td>
                                    <td><?php if($pending_detail['MedicalBillAmount']['loc_type'] == 'M') echo "Metro";elseif($pending_detail['MedicalBillAmount']['loc_type'] == 'N') echo "Non Metro"; ?></td>
                                     <td><?php if(!empty($pending_detail['MedicalBillAmount']['uploaded_file'])){?><a data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Details('<?php echo $pending_detail['MedicalBillAmount']['id']; ?>')" class="uk-badge uk-badge-success" title="Click to View." >View Bill</a><?php }else{echo 'NA';}?></td>
                                    <td>
                                        <?php
                                        $x = 0; //echo $pending_detail['ConveyencExpenseDetail']['leave_status'];
                                        //echo $pending_detail['LeaveWorkflow']['fw_date'];echo ','.$pending_detail['ConveyencExpenseDetail']['leave_status'].'<br/>';
                                        if ($pending_detail['medical']['medical_status'] == '4') {
                                            echo strtoupper($this->Common->findSatus(4));
                                        } else if ($pending_detail['medical']['fw_date'] != null && $pending_detail['medical']['medical_status'] == '6') {
                                            echo $this->Common->findSatus(6);
                                        } else if ($pending_detail['medical']['medical_status'] == '5') {
                                            echo strtoupper($this->Common->findSatus(5));
                                        } else if ($pending_detail['medical']['fw_date'] == null && $pending_detail['medical']['medical_status'] == '3') {
                                            echo strtoupper($this->Common->findSatus(3));
                                        } else if ($pending_detail['medical']['fw_date'] != null && $pending_detail['medical']['medical_status'] == '2') {

                                            echo strtoupper($this->Common->findSatus(2));
                                        } else if ($pending_detail['medical']['fw_date'] == null && $pending_detail['medical']['medical_status'] != '5') {
                                            ?>
                                            <a class="uk-badge uk-badge-primary" href="<?php
                                               echo $this->webroot . 'medical/fwmedical/'
                                               . '/' . base64_encode($pending_detail['MedicalBillAmount']['id']);
                                               ?>" Title="Approve/Reject">Approve/Reject</a>


                <!-- <a href="#" id="dialog_link" class="icon-thumbs-down"onclick="return reject('<?php echo $pending_detail['mst']['comp_code'] ?>','<?php echo $pending_detail['DtTravelVoucher']['voucher_id'] ?>','<?php echo $pending_detail['DtTravelVoucher']['tour_start_date']; ?>','<?php echo $pending_detail['DtTravelVoucher']['tour_end_date']; ?>')" title="Reject" >
                   
                </a> -->


    <?php } ?>

                                    </td>
                                </tr>
                                <?php
                                $i++;
                                $x++;
                            }
                            ?></tbody>
                    </table>
                    <input type="hidden" id="vouchno" name="voucher_no" value=""/>
                    <input type="hidden" id="ccode" name="comp_code" value=""/>
                    <input type="hidden" id="stdate" name="start_date" value=""/>
                    <input type="hidden" id="eddate" name="end_date" value=""/>
                    <input type="hidden" id="rejectres" name="rejectreson" value=""/>

                </div>
                <?php $this->Form->end(); ?>
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





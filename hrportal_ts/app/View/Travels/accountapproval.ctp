<script type="text/javascript">
    $(function() {

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            modal: true,
            buttons: {
                "Ok": function() {
                    var cmnt12 = $('#cmnt').val();

                    if (cmnt12 == ' ')
                    {
                        $('#errdis').show('slow', function() {
                            // Animation complete.
                        });

                        return false;

                    } else {
                        var compcode = document.getElementById("ccode").value;
                        var voucherno = document.getElementById("vouchno").value
                        var stdate = document.getElementById("stdate").value;
                        var edate = document.getElementById("eddate").value;
                        var rjres = document.getElementById("rejectres").value;
                        var rjres = document.getElementById("rejectres").value
                        jQuery.get('<?php echo $this->webroot; ?>travels/rejectbyaccount/' + compcode + '/' + voucherno + '/' + stdate + '/' + edate + '/' + rjres, {}, function(data) {
                        });
                        $('#vrejected').show('slow', function() {
                            // Animation complete.
                        });

                        $('#chgedit' + voucherno).hide('slow', function() {
                            // Animation complete.
                        });


                        $(this).dialog("close");


                    }

                },
                "Cancel": function() {
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
        edate = document.getElementById("eddate").value = edate;

        $('#dialog').dialog('open');
        return false;
    }

    function getcmtval()
    {
        var voucherno = document.getElementById("cmnt").value;
        var rjres = document.getElementById("rejectres").value = voucherno;

    }

</script>


<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot; ?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>
            <li><?php echo $this->Html->link('Self Services', $this->Html->url('/selfservices', true)); ?> </li>
            <li><?php echo $this->Html->link('Travel Voucher', $this->Html->url('/selfservices/#travel', true)); ?> </li>
            <li><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Travel Expense Report Query Form</a>  </li>
        </ul>
    </div>
</div>

<h2 class="demoheaders"><?php echo $fromDate; ?> to <?php echo $toDate; ?> </h2>
<div class="travel-voucher1">
    <div class="input-boxs">
        <div class="travel-voucher1">
            <div class="ui-widget" id="vrejected" style="display:none;">
                <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
                    <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                        <strong>Hey!</strong> Rejected Successfully</p>
                </div>
            </div>

            <?php echo $this->Form->create('Account_Voucher', array('url' => array('controller' => 'travels', 'action' => 'accountpaid_status'), 'id' => 'trvoucher')); ?>
            <table  frame="void" width="100%" align="center" cellspacing="1" cellpadding="0" border="0" class="exp-voucher">
                <thead class="vrTableHeader">
                    <tr class="head">
                        <th>Voucher No</th>
                        <th>Employee ID</th>
                        <th align="center">Name</th>
                        <th align="center">Department</th>
                        <th>Place of visit</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Tour Advance(in Rs.)</th>
                        <th>Travel Expense</th>
                        <th align="center">Balance</th>
                        <th align="center">Update Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (count($pending_emp_details) == 0) { ?>
                        <tr class="cont">
                            <td style="text-align:center;" colspan="11">
                                <em>--No Records Found--</em>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php $i = 1;
                    foreach ($pending_emp_details as $pending_detail) {
                        ?>
                        <tr <?php if ($i % 2 == 0) { ?>class="cont1" <?php } else { ?>class="cont" <?php } ?> id="grid<?php echo $pending_detail['Travelmain']['vc_voucher_no']; ?>">
                            <td><?php echo $pending_detail['Travelmain']['vc_voucher_no']; ?></td>
                            <td><?php echo $pending_detail['Travelmain']['vc_emp_code']; ?></td>
                            <td><?php $empname = $this->Common->getempinfo($pending_detail['Travelmain']['vc_emp_code']);
                    echo $empname;
                        ?></td>
                            <td><?php echo $this->Common->getdepartmentbyid($pending_detail['Travelmain']['vc_dept_name']); ?></td>
                            <td><?php echo $pending_detail['Travel']['vc_visit_place']; ?></td>
                            <td><?php echo date('d-M-Y', strtotime($pending_detail['Travel']['dt_start_date'])); ?></td>
                            <td><?php echo date('d-M-Y', strtotime($pending_detail['Travel']['dt_end_date'])); ?></td>

                            <td><?php echo $pending_detail['Travel']['nu_advance']; ?></td>
                            <td><?php echo $pending_detail['Travelmain']['nu_mgr_total']; ?></td>
                            <td><?php echo $pending_detail['Travelmain']['nu_balance_amount']; ?></td>

                            <?php if (($pending_detail['Travelmain']['ch_vouch_status'] == '8')) { ?>
                                <td>
                                    <select name="status<?php echo $i; ?>">
                                        <option value="8" selected></option>
                                        <option value="6">Paid</option>
                                        <option value="7">Verified</option>
                                    </select>
                                    <input type="hidden" name="comp<?php echo $i; ?>" value="<?php echo $pending_detail['Travelmain']['vc_comp_code']; ?>" />
                                    <input type="hidden" name="stDate<?php echo $i; ?>" value=<?php echo $pending_detail['Travel']['dt_start_date']; ?> />
                                    <input type="hidden" name="edDate<?php echo $i; ?>" value="<?php echo $pending_detail['Travel']['dt_end_date']; ?>" />
                                    <input type="hidden" name="voucherNo<?php echo $i; ?>" value="<?php echo $pending_detail['Travelmain']['vc_voucher_no']; ?>" />

                                </td>

                            <?php } else if (($pending_detail['Travelmain']['ch_vouch_status'] == '6') || ($pending_detail['Travelmain']['ch_vouch_status'] == '7')) { ?>

                                <td>
                                    <ul class="edit-delete-icon">
                                        <li style="border:none">
                                            <a href="<?php echo $this->webroot . '/travels/voucherreport/' . base64_encode($pending_detail['Travelmain']['vc_comp_code']) . '/' . base64_encode($pending_detail['Travelmain']['vc_voucher_no']) . '/' . base64_encode($pending_detail['Travelmain']['dt_start_date']) . '/' . base64_encode($pending_detail['Travelmain']['dt_end_date']) ?>"class="pay vtip" Title="View">
                                        </li>
                                    </ul>
                                </td>




                            <?php } else if ($pending_detail['Travelmain']['ch_vouch_status'] == '5') { ?>

                                <td>
                                    <ul class="edit-delete-icon">
                                        <li style="border:none">
                                            <div id="chgedit<?php echo $pending_detail['Travelmain']['vc_voucher_no']; ?>">
                                                <a href="<?php echo $this->webroot . 'travels/editaccountvoucher/' . base64_encode($pending_detail['Travelmain']['vc_comp_code']) . '/' . base64_encode($pending_detail['Travelmain']['vc_voucher_no']) . '/' . base64_encode($pending_detail['Travelmain']['vc_emp_code']) . '/' . base64_encode($empname) . '/' . base64_encode($pending_detail['Travelmain']['dt_start_date']) . '/' . base64_encode($pending_detail['Travelmain']['dt_end_date']) ?>" class="edit vtip" Title="Edit">
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            <?php } else { ?>
                                <td><?php $statusD = $this->Common->findSatus($pending_detail['Travelmain']['ch_vouch_status']);
                                echo $statusD;
                                ?></td>

                            <?php } ?>

                            <?php @$total_valueof_i+=$i; ?>


                        </tr>

                        <?php $i++;
                    } ?>

                <input type="hidden" id="vouchno" name="voucher_no" value=""/>
                <input type="hidden" id="ccode" name="comp_code" value=""/>
                <input type="hidden" id="stdate" name="start_date" value=""/>
                <input type="hidden" id="eddate" name="end_date" value=""/>
                <input type="hidden" id="rejectres" name="rejectreson" value=""/>
                <input type="hidden" name="totalivalue" value= "<?php if (!empty($total_valueof_i)) echo $total_valueof_i; ?>" />
                <?php
                if (!empty($emp_designation)) {
                    if (($emp_designation) && ($emp_designation == "ACCOUNTS") && (!empty($pending_detail['Travelmain']['ch_vouch_status'])) && ($pending_detail['Travelmain']['ch_vouch_status'] == "E")) {
                        ?>

                        <tr>
                            <td colspan="10" align="right"><div class="submit-form"><input type="submit"  name="subButton" value="Update Status" /></div>
                            </td>
                        </tr>


                        <?php
                    } else {
                        ?>
                        <td>&nbsp;</td> </tr>
                        <?php
                    }
                }
                ?>

<?php ?>


                </tbody>

            </table>
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
        </div>
    </div>
</div>
<?php $this->Form->end(); ?>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Separation Approval List </h3>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr >
                                <th>Sr.No</th>
                                <th>Emp Name</th>
                                <th>Resignation Date</th>
                                <th>Reject Reason/Forward Remark</th>
                                <th>Resign Reason</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $auth = $this->Session->read('Auth'); ?>

                            <?php if (count($pending_separation) == 0) { ?>
                                <tr class="cont">
                                    <td style="text-align:center;" colspan="8">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>




                            <?php
                            $i = 1;
                            //pr($pending_separation);
                            //pr($this->params['paging']);
                            foreach ($pending_separation as $pending_detail) {
                                ?>
                                <tr <?php if ($i % 2 == 0) { ?>class="cont1" <?php } else { ?>class="cont" <?php } ?>>
                                    <td>
                                        <?php
                                        @$ctr = (($this->params['paging']['Separation']['options']['page'] * $this->params['paging']['Separation']['options']['limit']) - $this->params['paging']['Separation']['options']['limit']) + $i;
                                        echo $ctr;
                                        ?>
                                    </td>
                                    <td><?php $empname = $this->Common->getempinfo($pending_detail['Separation']['emp_code']);
                                            echo $empname;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date("d-M-Y", strtotime($pending_detail['Separation']['created'])); ?>
                                    </td>
                                    <?php if ($pending_detail['Separation']['remark'] != " ") { ?>
                                        <td>
                                        <?php echo $pending_detail['Separation']['remark']; ?>
                                        </td>
                                <?php } else { ?>
                                        <td>N/A</td>
                                <?php } ?>


                                    <td><?php echo $this->Common->getReason($pending_detail['Separation']['reason']); ?></td>

                                    <td>
                                    <?php
                                    echo $this->Common->findSatus($pending_detail['Separation']['status']);
                                    ?>
                                    </td>
                                    <td>
                                        <?php
                                        $fnf_det = $this->Common->getFnfFromSeperationId($pending_detail['Separation']['id']);
                                        if ($pending_detail['Separation']['status'] == 1 || $pending_detail['Separation']['status'] == 2) {
                                            if ($this->Common->moreLevelExists($this->Common->findEmpLevelSequence($_SESSION['Auth']['MyProfile']['emp_code'], $appId), $appId)) {
                                                //process
                                                echo $this->Html->link('Process ', array('action' => 'process_approval', $pending_detail['Separation']['id']), array('class' => 'btn btn-success'));
                                            } else {
                                                //process
                                                echo $this->Html->link('Approve/Reject ', array('action' => 'process_approval', $pending_detail['Separation']['id']));
                                            }
                                        } else if ($pending_detail['Separation']['status'] == 6 && $fnf_det['status'] != 5) {
                                            //process

                                            echo $this->Html->link('Fill FNFS details', array('controller' => 'fnfs', 'action' => 'fnf_details', $fnf_det['id']));
                                        } else if ($pending_detail['Separation']['status'] == 5) {
                                            echo 'N/A';
                                        } else if ($pending_detail['Separation']['status'] == 4) {
                                            echo 'N/A';
                                        }

                                        if ($fnf_det['final_approver'] == $_SESSION['Auth']['MyProfile']['emp_code']) {
                                            echo $this->Html->link('View FNFS details', array('controller' => 'fnfs', 'action' => 'other_users', $fnf_det['id']));
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>

                        </tbody>

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
                        <input type="hidden" id="wf_id" name="wf_id" value=''/>
                        <input type="hidden" id="leaveno" name="leave_no" value=""/>
                        <input type="hidden" id="ccode" name="comp_code" value=""/>
                        <input type="hidden" id="stdate" name="start_date" value=""/>
                        <input type="hidden" id="eddate" name="end_date" value=""/>
                        <input type="hidden" id="rejectres" name="rejectreson" value=""/>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


</div>


<script type="text/javascript">
    $(function () {

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
                        document.leave.submit();
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

    function reject(wfid, compcode, vno, sdate, edate)
    {
        var wfid = document.getElementById("wf_id").value = wfid;
        var compcode = document.getElementById("ccode").value = compcode;
        var leaveno = document.getElementById("leaveno").value = vno;
        var stdate = document.getElementById("stdate").value = sdate;
        edate = document.getElementById("eddate").value = edate;
        $('#dialog').dialog('open');
        return false;
    }

    function getcmtval()
    {
        var leaveno = document.getElementById("cmnt").value;
        var rjres = document.getElementById("rejectres").value = leaveno;

    }


</script>
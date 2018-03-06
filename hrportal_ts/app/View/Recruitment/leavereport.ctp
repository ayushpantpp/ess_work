<script type="text/javascript">
    function change()
    {
        document.frm.selc.focus();
        document.forms["frm"].submit();

    }
</script>

<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb	module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li><?php echo $html->link('Leave', $html->url('/selfservices/#leave', true)); ?> </li>
        </ul>
    </div>
</div>
<h2 class="demoheaders">Employee Leave Records</h2>
<div class="travel-voucher1">

    <div class="input-boxs">

        <form name="frm" method="post">
        </form>
        <?php
        $SumVouch = $report;
        if (!empty($SumVouch) == 0) {
            ?>
            <br>
            <br>
            <center>

                <h3>There is no record to view ! <br>
                </h3>

                <br>
                <p><a href="../leaves/lvreptsearch" class="linkStyle"><b>Click here to go back....</b></a></p>
            </center>
        <?php } else { ?>
            <table border="1" width="100%" align="center"   cellpadding="1" cellspacing="1" class="exp-voucher">
                <colgroup>
                    <col width="30%" align="center" />
                    <col width="30%" align="center" />
                    <col width="10%" align="center" />
                    <col width="13%" align="center" />
                    <col width="10%" align="center" />
                    <col width="10%" align="center" />
                    <col width="10%" align="center" />
                    <col width="10%" align="center" />
                </colgroup>
                <thead>
                    <tr class="head">
                        <th>Employee Name</th>
                        <th>Manager's Name</th>
                        <th>Department</th>
                        <?php if (($status == 'elr') || ($status == 'pl') || ($status == 'rl')) { ?>   
                            <th>Submission Date</th><?php } ?>
                        <th>Leave From</th>
                        <th>Leave upto</th>
                        <th>Total Leaves</th>
                        <?php if ($status != 'pl' && $status != 'rl') { ?>
                            <th>Status</th>

                            <?php if (($status == 'lwp' || $status == 'el' || $status == 'cl' || $status == 'ml') && ($status != 'elr')) { ?> 
                                <th>No.of Days</th> <?php } ?>
                            <?php if ($status == 'elr') { ?>  
                                <th>Leave Type</th><?php } ?>
                        <?php } ?>
                    </tr>
                <tbody>

                    <?php
                    $i = 0;
                    foreach ($report as $result) {
                        if ($i % 2 == 0) {
                            $cls = "cont";
                        } else {
                            $cls = "cont1";
                        }
                        ?>


                        <tr class="<?php echo $cls; ?>">
                            <td> <?php echo $result[0]["VC_EMP_NAME"]; ?></td>
                            <td><?php echo $result[0]["MGR"]; ?></td>
                            <td><?php echo $result[0]["DEPT"]; ?></td>
                            <?php if (($status == 'elr') || ($status == 'pl') || ($status == 'rl')) { ?>  
                                <td><?php echo $result[0]["DT_APP_DATE"]; ?></td>
                            <?php } ?>
                            <td><?php echo $result[0]["DT_START_DATE"]; ?></td>
                            <td><?php echo $result[0]["DT_END_DATE"]; ?></td>
                            <td><?php echo $result [0]["NU_TOT_LEAVES"] ?></td>
                            <?php if ($status != 'pl' && $status != 'rl') { ?>
                                <td><?php echo $result[0]["CH_LVE_STATUS"]; ?></td>
                                <?php if (($status == 'lwp' || $status == 'el' || $status == 'cl' || $status == 'ml') && ($status != 'elr')) { ?> 
                                    <td><?php echo $result[0]["NU_TOT_LEAVES"]; ?></td><?php } ?>
                                <?php if ($status != 'lwp' && $status != 'el' && $status != 'cl' && $status != 'ml') { ?> 
                                    <td><?php echo $result[0]["VC_LEAVE_CODE"]; ?>
                                    <?php } ?></td>
                            <?php } ?>
                        </tr>
                        <?php
                    }
                }
                ?>

        </table>

    </div>

</div>




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
            <li>Leave List</li>
        </ul>
    </div>
</div>
<h2 class="demoheaders">Leave List</h2>
<div class="travel-voucher1">

    <div class="input-boxs">
        <div class="travel-voucher1">

            <table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                <tr class="head">
                    <th scope="row">Total Remain Leave :   <?php echo $remainleave; ?></th>

                </tr>

                <tr class="<?php //echo $class;  ?>">

                </tr>

            </table> 
            <form name="frm" method="post">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td><th>Select Year </th></td>
                        <td>
                            <select name="selc"  title="Year" class="txtBorderColor" onChange="javascript:change()"  >
                                <option value="0" >Select Year</option>
                                <?php
                                for ($i = 1992; $i <= $year; $i++) {
                                    $year1 = 0;
                                    if ($year1 == $i) {
                                        ?>
                                        <option value='<?php echo $i ?>' <?php if (!empty($years)) {
                                    if ($years == $i) {
                                        echo 'selected';
                                    }
                                } ?>><?php echo $i; ?></option>
    <?php } else { ?>
                                        <option value='<?php echo $i ?>' <?php if ($years == $i) {
            echo 'selected="selected"';
        } ?>><?php echo $i; ?></option>
                <?php }
            } ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            $clrClass = null;
            $statusD = null;
            $SumVouch = 0;
            if (!empty($rs)) {
                $SumVouch = $rs;
            }
            if (!empty($SumVouch) == 0) {
                ?>
                <br>
                <br>
                <center>

                    <h3>There is no record to view ! <br>
                    </h3>

                    <br>
                    <p><a href="../selfservices/#leave" class="linkStyle" ><b>Click here to go back....</b></a></p>
                </center>
    <?php
} else {
    ?>
                <table align="center" width="95%" cellpadding="2" rules="none" frame="void" class=pageHead>
                    <tr>
                        <th align="right">Employee Leave Status for <?php echo $years ?> </th>
                    </tr>
                </table>

                <hr width="95%" style="color:black">
                <table align="center" width="95%" cellpadding="0" rules="none" frame="void" >
                    <colgroup>
                        <col width="56%">
                        <col width="14%">
                    </colgroup>

                </table>
                <br>

                <table width="95%" align="center"   cellpadding="1" cellspacing="1" class="exp-voucher">
                    <colgroup>
                        <col width="20%" align="center" />
                        <col width="20%" align="center" />
                        <col width="10%" align="center" />
                        <col width="13%" align="center" />
                        <col width="10%" align="center" />
                        <col width="10%" align="center" />
                        <col width="10%" align="center" />
                        <col width="10%" align="center" />
                    </colgroup>
                    <thead>

                    <tbody>
                        <?php
                        if ($years != null) {
                            $casual = 0;
                            $optional = 0;
                            $medical = 0;
                            $earned = 0;
                            $lwp = 0;
                            ?>
                            <tr class="head">
                                <?php
                                $tRec = count($rs);

                                for ($i = 0; $i < $tRec; $i++) {
                                    $wdth = 100 / $tRec;
                                    ?>
                                    <th width="<?php echo $wdth; ?>%"><?php echo ucfirst(strtolower($rs[$i][0]["Leave_type"])); ?> Leave</th>

            <?php
        }
        ?>
                            </tr>
                            <tr class="clsEvenTableRow">
                                <?php
                                for ($i = 0; $i < $tRec; $i++) {
                                    ?>
                                    <td><?php echo ucfirst($rs[$i][0]["lvcount"]); ?></td>
                                    <?php
                                }
                                ?>
                            </tr>


                            <?php
                        }
                    }
                    ?>

            </table>

        </div>

    </div>

</div>




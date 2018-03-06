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
<?php
App::import('Model', 'LeaveEntit');
$LeaveEntit = new LeaveEntit;
$auth = $this->Session->read('Auth');
?>
<h2 class="demoheaders">Employee Total EL (As On Date)</h2>
<div class="travel-voucher1">

    <div class="input-boxs">

        <form name="frm" method="post">
        </form>
     
            <table border="1" width="100%" align="center"   cellpadding="1" cellspacing="1" class="exp-voucher">
                <colgroup>
                    <col width="20%" align="center" />
                    <col width="40%" align="center" />
                    <col width="20%" align="center" />
                    <col width="20%" align="center" />
                   
                </colgroup>
                <thead>
                    <tr class="head">
                        <th>Employee Id</th>
                        <th>Employee Name</th>
                        <th>Join Date</th>
                        <th>Total EL Leaves</th>
                   </tr>
                <tbody>

                    <?php
                    $i = 0;
                    foreach ($empinfo as $result) {
                        if ($i % 2 == 0) {
                            $cls = "cont";
                        } else {
                            $cls = "cont1";
                        }
                        ?>


                        <tr class="<?php echo $cls; ?>">
                            <td> <?php echo $result['Personaldetails']['vc_emp_id']; ?></td>
                            <td><?php echo $result['Personaldetails']['vc_emp_name']; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($result['Personaldetails']['dt_join'])); ?></td>
                           <td><?php echo $LeaveEntit->gettotalleave($result['Personaldetails']['vc_emp_code']); ?></td>
                        </tr>
                        <?php
                    }
              
                ?>

        </table>

    </div>

</div>




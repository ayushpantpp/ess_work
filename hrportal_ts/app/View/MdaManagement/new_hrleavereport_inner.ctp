<?php
App::import('Model', 'VwLeavereport');
$VwLeavereport = new VwLeavereport;
$auth = $this->Session->read('Auth');
?>
<div class="travel-voucher1">
        <?php
        if ($print)
                $overflow = 'visible'; else
                $overflow = 'auto';
        ?>
        <div class="input-boxs-timesheet" style="overflow: <?php echo $overflow; ?>;" id="display_inner_overflow">
                <div class="tab-fixed">
                        <?php 
                        if (empty($error['message'])) {
                                if (count($records) > 0) {
                                        ?>

                                        <div id="print_div" style="width: 100%; float: left;">
                                                <div style="width: 100%;">
                                                        <div style="float: left; width: 80%;">
                                                                <h2 style='margin: 10px;'>
                                                                        Employees Leave Status During &nbsp;<?php echo $this->data['Search']['fromdate']; ?>&nbsp; and &nbsp;<?php echo $this->data['Search']['todate']; ?>
                                                                </h2>
                                                        </div>
                                                        <?php if (!$print) { ?>
                                                                <div style="vertical-align: middle; padding: 5px; width: 15%; float: right;"><a class="button" target="_blank" href="<?php echo $this->webroot; ?>leaves/printhrleavereport/<?php echo $this->data['Search']['fromdate']; ?>/<?php echo $this->data['Search']['todate']; ?>/<?php echo $this->data['Search']['status']; ?>/<?php echo $this->data['Search']['app_leave_status']; ?>/<?php echo $this->data['Search']['vc_emp_code']; ?>">Print</a> </div>
                <?php } ?>
                                                </div>
                                                <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                                                        <tr class="head">
                                                                <th scope="row" width="5%">S. No.</th>
                                                                <th width="25%">Employee Name</th>
                                                                <th width="25%">Manager Name</th>
                                                                <th width="25%">Leave Date</th>
                                                                 <th width="20%">Apply Leave Status</th>
                                                        </tr>
                <?php $zebraClass = ""; ?>
                <?php foreach ($records as $key => $employee): ?>
                                                                <tr class="<?php echo $zebraClass = ($zebraClass == "cont") ? "cont1" : "cont"; ?>">
                                                                        <td><?php echo $key + 1; ?></td>
                                                                        <td><?php echo $employee['0']['vc_emp_name']; ?></td>
                                                                        <td><?php echo $employee['0']['MGR']; ?></td>
                                                                        <td><?php echo date('D, d-m-Y', strtotime($employee['0']['dt_wk_date'])); ?></td>
                                                                         <td> <?php 
                                                                         if($employee['0']['lvstatus']==1)
                                                                         {
                                                                             echo "Yes";
                                                                         }else{
                                                                             echo "No";
                                                                         }
                                                                         ?></td>
                                                                </tr>
                                        <?php endforeach; ?>
                                                </table>
                                        </div>
                                        <?php
                                } else {
                                        echo "<h2 style='margin: 10px;'>No Records Found</h2>";
                                }
                        } else {
                                echo "<h2 style='margin: 10px;'>" . $error['message'] . "</h2>";
                        }
                        ?>
                </div>
        </div>
</div>
<?php if ($print) { ?>
<script>window.print();</script>
<?php } ?>
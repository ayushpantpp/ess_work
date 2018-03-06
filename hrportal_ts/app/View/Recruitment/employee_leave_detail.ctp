<div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
      <div class="uk-width-large-1-1">
        <div class="uk-overflow-container uk-margin-bottom">
            <table class="uk-table uk-table-striped uk-text-nowrap">
                        <thead>
                                    <tr class="headings">
                                    <th class="column-title">Leave Type </th>
                                    <th class="column-title">1st January Opening Balance</th>
                                    <th class="column-title">Balance Leave</th>
                                    <th class="column-title">Approved Leaves</th>
                                    <th class="column-title">Applied Leaves</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($leaveType as $type) {
                                        ?>  
                                        <?php
                                        if ($i % 2 == 0)
                                            $class = "cont1";
                                        else
                                            $class = "cont";
                                        $bal = $type['MstEmpLeaveAllot']['leave_bal'];
                                        if($type['MstEmpLeaveAllot']['leave_op'] == ''){
                                            $total = 0;
                                        } else {$total = $type['MstEmpLeaveAllot']['leave_op'];}
                                        $applied = $this->Common->countAppliedLeave($type['MstEmpLeaveAllot']['emp_code'], $type['type']['id']);
                                        ?>
                                    <tr class="<?php echo $class; ?>">
                                        <td ><?php echo $type['type']['name']; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td id="bal_leave_<?php echo $type['type']['id'] ?>"><?php echo $bal; ?></td>
                                        <td><?php echo $applied; ?></td>
                                        <td id="pending_leave_<?php echo $type['type']['id'] ?>">
                                                <?php echo $this->Common->countPendingLeave($type['MstEmpLeaveAllot']['emp_code'], $type['type']['id']); ?> </td></tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
 
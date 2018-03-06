<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>KRA for the year <?php echo (date("Y") - 1) . "-" . date("Y") ?></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="x_title">
                            <h2>Appraisee Information - <?php echo $myprofile['MyProfile']['emp_firstname'] . " " . $myprofile['MyProfile']['emp_lastname']; ?> [<?php echo $myprofile['MyProfile']['emp_code']; ?>]</h2>
                        </div>
                        <br>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Appraisee Name [Code]</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $myprofile['MyProfile']['emp_firstname'] . " " . $myprofile['MyProfile']['emp_lastname']; ?> [<?php echo $myprofile['MyProfile']['emp_code']; ?>]
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Designation</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $this->common->findDesignationName($myprofile['MyProfile']['desg_code'], $myprofile['MyProfile']['comp_code']); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Branch</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo ""; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Department</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $this->common->getdepartmentbyid($myprofile['MyProfile']['dept_code']); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Joining Date</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $myprofile['MyProfile']['join_date']; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Appraisal Date</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo ""; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Last Date Of Submission</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $kraList[0]['KpiMapEmps']['to_date']; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Qualification</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo ""; ?>
                                    <?php echo $this->Form->input('assign_user_employee', array('type' => 'hidden', 'label' => false, 'value' => $myprofile['MyProfile']['emp_code'])); ?>
                                </div>
                            </div>
                            <?php
                            $checklvlapp = $this->Common->findAppLevel($appId);
                            if ($emp_codes == $this->Common->findFinalKraAssignEmployeeCheck($myprofile['MyProfile']['emp_code'])) {
                                $fwemplist = '';
                            } elseif ($checklvlapp > count($kraProcessCount)) {
                                $fwemplist = $this->Common->findPreviousLevel($myprofile['MyProfile']['emp_code']);
                            } elseif ($checklvlapp == count($kraProcessCount)) {
                                $fwemplist = $this->Common->findPreviousLevel($myprofile['MyProfile']['emp_code'], 'Final');
                            } else {
                                
                            }
                            if (!empty($fwemplist)) {
                                ?>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12" style="display: none;">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Forward To</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                        <?php
                                        $l = 0;
                                        foreach ($fwemplist as $key => $value) {
                                            if ($l == 0) {
                                                $forward_emp_code = $key;
                                                $forward_emp_name = $value;
                                                $l++;
                                            }
                                        }
                                        echo $forward_emp_name;
                                        ?>
                                        <?php echo $this->Form->input('employee_name', array('type' => 'hidden', 'label' => false, 'class' => 'form-control s-form-item s-form-all', 'value' => $forward_emp_code)); ?>
                                </div>
                            </div>
                            <?php } $i = 1;?>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <tr>
                                    <td>1:- Unsatisfactory (0.00-2.50)</td>
                                    <td>2:- Satisfactory (2.51-3.00)</td>
                                </tr>
                                <tr>
                                    <td>3:- Above Average (3.01-3.74)</td>
                                    <td>4:- Good (3.75-4.50)</td>
                                </tr>
                                <tr>
                                    <td>5:- Very Good (4.51-5.00)</td>
                                    <td></td>
                                </tr>
                            </table>
                            <?php if(!empty($krlist)){?>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <h2>KRA Competency Group</h2>
                            </div>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">Sr.No </th>
                                        <th> Competency</th>
                                        <th> Weightage(%)</th>
                                        <th> Priority</th>
                                        <?php
                                        if (!empty($kraProcessCount)) {
                                            foreach ($kraProcessCount as $key => $value) {
                                                if ($key == 0) {
                                                    echo "<th>Self Rating</th>";
                                                    echo "<th>Self Remark</th>";
                                                } else {
                                                    echo "<th>Superior " . $key . " Rating</th>";
                                                    echo "<th>Superior " . $key . " Remark</th>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($krlist as $kraListValue) {
                                        $kpiVal = $this->common->getKpiDetail($kraListValue['KpiMapEmps']['kpi_masters_id']);
                                        ?>
                                    <tr class="even pointer">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $this->common->getKraName($kpiVal['kpi_masters']['kra_id'])."<br/>".$kpiVal['kpi_masters']['kpi_name']; ?></td>
                                        <td><?php echo $kpiVal['kpi_masters']['weightage']; ?></td>
                                        <td><?php echo $this->common->getPriorityName($kpiVal['kpi_masters']['priority']); ?></td>
                                            <?php
                                            if (!empty($kraProcesslist)) {
                                                foreach ($kraProcesslist as $value) {
                                                    if ($value['KraKpiProcess']['kpi_masters_id'] == $kpiVal['kpi_masters']['id']) {
                                                        echo "<td>" . $value['KraKpiProcess']['units'] . "</td>";
                                                        $sum+=$value['KraKpiProcess']['units'];
                                                        echo "<td>" . $value['KraKpiProcess']['comment'] . "</td>";
                                                    }
                                                }
                                            }
                                            ?>
                                    </tr>
                                        <?php $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php }if(!empty($complist)){?>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <h2>Competency Competency Group</h2>
                            </div>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">Sr.No </th>
                                        <th> Competency</th>
                                        <th> Priority</th>
                                        <?php
                                        if (!empty($kraProcessCount)) {
                                            foreach ($kraProcessCount as $key => $value) {
                                                if ($key == 0) {
                                                    echo "<th>Self Rating</th>";
                                                    echo "<th>Self Remark</th>";
                                                } else {
                                                    echo "<th>Superior " . $key . " Rating</th>";
                                                    echo "<th>Superior " . $key . " Remark</th>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($complist as $kraListValue) {
                                        $kpiVal = $this->common->getKpiDetail($kraListValue['KpiMapEmps']['kpi_masters_id']);
                                        ?>
                                    <tr class="even pointer">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $this->common->getKraName($kpiVal['kpi_masters']['kra_id'])."<br/>".$kpiVal['kpi_masters']['kpi_name']; ?></td>
                                        <td><?php echo $this->common->getPriorityName($kpiVal['kpi_masters']['priority']); ?></td>
                                            <?php
                                            if (!empty($kraProcesslist)) {
                                                foreach ($kraProcesslist as $value) {
                                                    if ($value['KraKpiProcess']['kpi_masters_id'] == $kpiVal['kpi_masters']['id']) {
                                                        echo "<td>" . $value['KraKpiProcess']['units'] . "</td>";
                                                        $sum+=$value['KraKpiProcess']['units'];
                                                        echo "<td>" . $value['KraKpiProcess']['comment'] . "</td>";
                                                    }
                                                }
                                            }
                                            ?>
                                    </tr>
                                        <?php $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php }?>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <tr><th colspan="2">Comments</th></tr>
                                    <?php
                                    if (!empty($kraProcessCount)) {
                                        foreach ($kraProcessCount as $key => $value) {
                                            if ($key == 0) {
                                                echo "<tr><th>Self Comment</th>";
                                                echo "<td>".$kraProcessComment[$key]['KraKpiProcess']['kra_comments']."</td></tr>";
                                            } else {
                                                echo "<tr><th>Superior " . $key . " Comment</th>";
                                                echo "<td>".$kraProcessComment[$key]['KraKpiProcess']['kra_comments']."</td></tr>";
                                            }
                                        }
                                    }
                                    ?>
                            </table>
                            <div class="ln_solid"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--View for the modal box-->
<?php $i = 1; ?>
<h3>Training Detail</h3>
<table class="uk-table uk-table-bordered">
    <thead>
        <tr>
            <th>Course Name</th>
            <th>Training Date</th>
            <th>Training Duration Time</th>
            <th>Training Request Type</th>
            <?php
            if ($tdetails[0]['TrainingCreation']['status'] == 4) {
                echo '<th>Reject Remark</th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>

        <?php if (empty($tdetails)) { ?>
            <tr class="even pointer">
                <td colspan="5">
                    <span class="uk-text-italic">--No Records Found--</span>
                </td>
            </tr>
        <?php } ?>
        <?php
        //$tot = 0;
        $tr = count($tdetails[0]['TrainingWorkflow']);
        foreach ($tdetails as $cdetail) {
            ?>
            <tr>
                <td><?php echo $this->Common->getTrainingClassName($cdetail['TrainingCreation']['course_id']); ?></td>
                <td>
                    <?php echo date("d-m-Y", strtotime($cdetail['TrainingCreation']['training_date'])); ?>
                </td>
                <td>
                    <?php echo $cdetail['TrainingCreation']['training_start_time']; ?>
                </td>
                <td>
                    <?php
                    if ($cdetail['TrainingCreation']['initated_by'] == 'I')
                        echo 'Indentification';
                    elseif ($cdetail['TrainingCreation']['initated_by'] == 'E')
                        echo 'Enrollment';
                    elseif ($cdetail['TrainingCreation']['initated_by'] == 'P')
                        echo 'Perforamce Management System';
                    ?>
                </td>
                <?php
                if ($cdetail['TrainingCreation']['status'] == 4) {
                    echo '<td>' . $cdetail['TrainingWorkflow'][$tr - 1]['remarks'] . '</td>';
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<h4>List of Employee</h4>
<table class="uk-table uk-table-bordered">
    <thead>
        <tr>
            <th class="uk-text-center">S No.</th>
            <th class="uk-text-center">Employee Name</th>
            <!--<th class="uk-text-center">Desgination Code</th>-->
            <th class="uk-text-center">Designation Name</th>
            <th class="uk-text-center">Location</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($tdetails)) {
            $o = 1;
            foreach ($tdetails[0]['TrainingEmployee'] as $tdetail) {
                ?>
                <tr>
                    <td class="uk-text-center"><?php echo $o; ?></td>
                    <td class="uk-text-center"><?php echo $this->Common->findEmpName($tdetail['trainee_code'])." (".$this->Common->findEmpId($tdetail['trainee_code']).")"; ?></td>
                    <!--<td class="uk-text-center"><?php echo $tdetail['desg_code']; ?></td>-->
                    <td class="uk-text-center"><?php echo ucfirst(strtolower($this->Common->findDesignationName($tdetail['desg_code'], $tdetail['trainee_comp_code']))); ?></td>
                    <td class="uk-text-center"><?php if(!empty($this->Common->findLocationNameByCode($tdetail['location'], $tdetail['trainee_comp_code'])))echo ucfirst(strtolower($this->Common->findLocationNameByCode($tdetail['location'], $tdetail['trainee_comp_code']))); ?></td>
                </tr>
                <?php
                $o++;
            }
        }
        ?>
    </tbody>
</table>



            <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                <tr class="head">
                    <th scope="row"></th>
                    <th scope="row">Employee ID</th>
                    <th>Employee Name</th>
                    <?php foreach($application_names as $application_name): ?>
                        <th><?php echo $application_name['Applications']['vc_application_name']; ?></th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach($data as $employee): ?>
                <tr>
                    <td></td>
                    <td><?php echo $employee['UserDetail']['emp_code']; ?></td>
                    <td><?php echo $employee[0]['emp_name']; ?></td>
                    <?php if (isset($employee['Applications'])) { ?>
                    <?php foreach($application_names as $application_name): ?>
                        <?php $noaccess = true; ?>
                        <?php foreach($employee['Applications'] as $application): ?>
                            <?php if ($application_name['Applications']['id']==$application['Applications']['id']) { ?>
                            <?php $noaccess = false; ?>
                            <td>
                                <strong><?php echo $application['Roles']['name']; ?></strong>
                            </td>
                            <?php } ?>
                        <?php endforeach; ?>
                        <?php if ($noaccess) {?>
                        <td>
                            <?php echo '<em>--No Access--</em>'; ?>
                        </td>
                        <?php } ?>
                        
                    <?php endforeach; ?>
                            
                    <?php } else { ?>
                        <td>
                            <em>--Not Applicable--</em>
                        </td>
                    <?php } ?>
                </tr>
                <?php endforeach; ?>
            </table>

 

            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Project Name</th>
                    <?php foreach($stages as $stage): ?>
                    <th><?php echo $stage; ?></th>
                    <?php endforeach; ?>
                    <th>Total</th>
                </tr>
                <?php foreach($data as $row): ?>
                <?php $total=0;?>
                <tr>
                    <th><?php echo $row['vc_project_name']; ?></th>
                    <th><?php echo $row['vc_customer_name']; ?></th>
                    <?php foreach($stages as $stage): ?>
                    <th><?php echo isset($row[$stage])?$row[$stage]:0; ?></th>
                    <?php $value = isset($row[$stage])?$row[$stage]:0; ?>
                    <?php $total+=intval($value); ?>
                    <?php endforeach; ?>
                    <th><?php echo $total; ?></th>
                </tr>
                <?php endforeach; ?>
            </table>
<h3>View Rates</h3>
<table class="uk-table uk-table-striped">
    <tr>
        <th>Sr.No.</th>
        <th>Conveyance</th>
        <th>Wheeler Type</th>
        <th>Rate</th>
        <th>Effected Date</th>
    </tr>
    <?php
    foreach ($convenyence_detail as $wheeler_type) {
        $i++;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $this->Common->getVehicalByID($wheeler_type['a']['vehical']); ?></td>
            <td><?php
                if ($wheeler_type['a']['wheeler_type'] == '1') {
                    echo "Personal";
                } else {
                    echo "Commercial";
                }
                ?>
            </td>
            <td><?php echo $wheeler_type['a']['price'] . " /KM"; ?></td>
            <td><?php echo date("d/m/Y", strtotime($wheeler_type['a']['effected_date'])); ?></td>
        </tr>
<?php } ?>
    <tr><td colspan="5" align="right"><a href="<?php echo $this->Html->url('/ConveyenceExpenses/allrates'); ?>" target="blank">More</a></td></tr>
</table>
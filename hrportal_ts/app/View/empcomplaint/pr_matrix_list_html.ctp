<div class="travel-voucher1">
    <div class="input-boxs-timesheet">
        <div>
            <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                <tr class="head">
                    <th scope="row" width="25%">Customer Name</th>
                    <th scope="row" width="25%">Project Name</th>
                    <?php foreach($stages as $stage): ?>
                    <th><?php echo $stage; ?></th>
                    <?php endforeach; ?>
                    <th>Total</th>
                </tr>
                <?php $zebraClass = ""; ?>
                <?php foreach($data as $row): ?>
                <?php $total=0;?>
                <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
                    <td scope="row" width="25%"><?php echo $row['vc_project_name']; ?></td>
                    <td scope="row" width="25%"><?php echo $row['vc_customer_name']; ?></td>
                    <?php foreach($stages as $stage): ?>
                    <td><?php echo isset($row[$stage])?$row[$stage]:0; ?></td>
                    <?php $value = isset($row[$stage])?$row[$stage]:0; ?>
                    <?php $total+=intval($value); ?>                    
                    <?php endforeach; ?>
                    <td><?php echo $total; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="navigation">
            
            <?php echo $this->Paginator->counter(); ?> Pages
            <?php echo $this->Paginator->options(array('url'=>$this->passedArgs)); ?>
            <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
            </div>            
        </div>
    </div>
</div>
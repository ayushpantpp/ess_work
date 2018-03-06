<div id="invoice_preview">
    <div class="md-card-toolbar">
        <h3 id="invoice_name" class="md-card-toolbar-heading-text large">
            Designation List
        </h3>
    </div>
</div>       
<hr class="uk-grid-divider">
<div data-uk-grid-margin="" class="uk-grid">
    <div class="uk-width-medium-1-2 uk-row-first">        
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap">
                <thead>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Designation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($assignDesgList); $i++) {
                        //echo "<pre>";print_r($assignDesgList); die;
                        ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $assignDesgList[$i]['OptionAttribute']['name']; ?></td>               
                        </tr>
                    <?php } ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>





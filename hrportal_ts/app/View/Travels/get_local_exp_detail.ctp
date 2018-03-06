<div class="uk-accordion-content">
    <label>Detail of Local Conveyance:</label>

    <div class="parsley-row">
        <div class="uk-overflow-container">
            <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup">
                <tr>
                    <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Claim Date </th>
                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Mode</th>
                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Amount</th>
                </tr>
	<?php foreach($details as $led) {?>
                <tr>
                    <td class="uk-text-center uk-width-small-1-10">1<?php echo $this->Form->input("rowCount", array("type" => "hidden","id"=>"rowCount","value"=>"1")); ?></td>                            
                    <td><?php echo $led['LocalExp']['local_claim_date'];?></td>
                    <td><?php echo $led['LocalExp']['local_claim_mode']; ?></td>
                    <td><?php echo $led['LocalExp']['local_claim_amount']; ?></td>
                </tr>
	<?php } ?>
            </table>

        </div>
    </div>
</div>
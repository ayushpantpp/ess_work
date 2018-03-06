
<?php if ($val != '') { ?>

    <div class="parsley-row">
        <label for="act_off">Marking Officer <span class="req">*</span></label>

        <select name="act_off" required="required" class="md-input data-md-selectize label-fixed">
            <option value=" ">-- Select --</option>
            <?php
            foreach ($ActionOfficer as $key => $values) {
                $value = $key;
                $option = $values;
                echo "<option value='" . $value . "'>" . $option . "</option>";
            }
            ?>
        </select>
    </div>



<?php
}?>
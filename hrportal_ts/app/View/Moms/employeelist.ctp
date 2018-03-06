
<script src="<?php echo $this->webroot ?>js/js/pages/kendoui.min.js"></script>
    
<label for="kUI_multiselect_basic" class="uk-form-label">Select Employee</label>
<select id="kUI_multiselect_basic" name="employee_id[]" required="" id="employee_id" multiple="multiple" data-placeholder="Select Employee...">
  <?php foreach ($employee_list as $k => $val) { ?>
        <option  value='<?php echo $k ?>'> <?php echo $val ?></option>
    <?php } ?>
</select>

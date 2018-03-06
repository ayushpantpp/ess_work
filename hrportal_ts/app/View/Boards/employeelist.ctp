
<?php $this->common->getAllEmployeeListDepartment()?>


<label for="kUI_multiselect_basic" class="uk-form-label">Select Employee</label>
<select data-md-selectize name="employee_id" required="" id="employee_id" data-placeholder="Select Employee...">
    
  <?php foreach ($employee_list as $k => $val) { ?>
        <option  value='<?php echo $k ?>'> <?php echo $val ?></option>
    <?php } ?>
</select>
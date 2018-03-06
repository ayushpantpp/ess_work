
<?php $empList = $this->Common->findEmpListByDesgCode($desgCode, $deptCode); ?>
<label>Employee List</label>
<div class="parsley-row">
    <select name="data[emp_id]" required="" id="employee_id" class="md-input" data-placeholder="Select Employee..." data-md-selectize = "data-md-selectize">
        <option value=''> -- Select Employee -- </option>
        <?php
        $orgCode = ltrim($compCode, '0');
       
		foreach ($empList as $emp) {
	?>
	<option value="<?php echo $emp['MyProfile']['emp_code']; ?>"><?php echo $emp['0']['emp_full_name']; ?> </option>
	<?php		
		}
	?>
    </select>                                                     
</div>
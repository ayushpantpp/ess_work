
<?php $empList = $this->Common->kraEmpList($locationID); 

//echo "<pre>"; print_r($empList); die;?>
 

<div class="uk-width-medium-1-2">
    <label>Select Employee <span class='uk-text-small'>(Emp Name + Emp ID)</span></label>
    <div class="parsley-row">
        <select class="md-input" name="emp_id" required="" id="employee_id" data-placeholder="Select Employee..." data-md-selectize>
            <option value=''>Select Employee</option>
            <option value='0'>All</option>
            <?php foreach ($empList as $k => $val) {?>
                <option value='<?php echo $empList[$k]['myprofile']['emp_code'] ?>'> <?php echo $empList[$k]['myprofile']['emp_full_name']." - ".$empList[$k]['myprofile']['emp_id'];?></option>
            <?php } ?>
        </select>
    </div>
</div>

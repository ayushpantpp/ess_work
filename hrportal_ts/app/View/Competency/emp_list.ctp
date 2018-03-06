<script type="text/javascript">
   // jQuery.noConflict();
</script>

<script type="text/javascript">
    function toggle(source) {
        var aInputs = document.getElementsByTagName('input');
        for (var i=0;i<aInputs.length;i++) {
            if (aInputs[i] != source && aInputs[i].className == source.className) {
                aInputs[i].checked = source.checked;
            }
        }
    }
 </script>
<?php $empList = $this->Common->findEmpListByDesgCode($desgCode,$deptCode);?>
 
<input type='checkbox' class='md-input' onClick='toggle(this)' /> Select All<br /><br />
<?php foreach($empList as $key => $val){?>

<span class="icheck-inline">
    <input type="checkbox" class='md-input' required="" name="data[emp_id][]" value='<?=$key;?>' id="val_check_ski"/>
    <label for="val_check_ski" class="inline-label"><?=$val;?></label>
</span>
<?php }
?> 

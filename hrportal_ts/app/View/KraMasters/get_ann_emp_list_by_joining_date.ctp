<script type="text/javascript">
    function toggle(source) {
        var aInputs = document.getElementsByTagName('input');
        for (var i = 0; i < aInputs.length; i++) {
            if (aInputs[i] != source && aInputs[i].className == source.className) {
                aInputs[i].checked = source.checked;
            }
        }
    }
</script>


<!-- <script src="<?php echo $this->webroot ?>/js/js/pages/kendoui.min.js"></script> -->


<?php 

$empList = $this->Common->findAnnEmpListByJoiningDate($startDate, $endDate);

?>
<label for="message">Employee List</label>
<div class="parsley-row" >


    <br>
            <?php 
            if(isset($empList)){
            ?>
    <input type='checkbox' class='md-input' onClick='toggle(this)' /> Select All<br /><br />
            <?php foreach ($empList as $k => $val) { 
		$data = $this->Common->findFInancialYearDesc($val['MyProfile']['comp_code']);
        $currentFinancialYear = $data['FinancialYear']['id'];

		$empDetails = $this->Common->getEmpDetails($val['MyProfile']['emp_code']);
					$p = $auth['MyProfile']['comp_code'];
                    //echo $key;  echo $p;
					$totalKRA= $this->Common->getTotalKraTarge($val['MyProfile']['emp_code'], $currentFinancialYear); 
					$totalapprovedKRA= $this->Common->getKraTargetByEmpCodeForReviewer($val['MyProfile']['emp_code'], $currentFinancialYear); 
					if(($totalKRA == $totalapprovedKRA )&& ($totalapprovedKRA !=0 && $totalKRA !=0 )){
						$mid_rev= $this->Common->findAnnualList($val['MyProfile']['emp_code'], $currentFinancialYear); 
							if($mid_rev != 1){
					
                ?>
    <span class="icheck-inline" style="width:30%">
        <input type="checkbox" class='md-input' required="" name="emp_id[]" value='<?php echo $val['MyProfile']['emp_code']; ?>' id="val_check_ski"/>
        <label for="val_check_ski" class="inline-label uk-text-small"><?php echo ucfirst($val['MyProfile']['emp_full_name'])." - "?><?=$empDetails['MyProfile']['emp_id']?></label>
    </span>
            <?php
							}
					}
				}
            }
            ?>

</div>


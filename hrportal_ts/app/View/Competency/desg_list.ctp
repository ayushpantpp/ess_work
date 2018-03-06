<?php ?><!-- <script src="<?php echo $this->webroot ?>js/js/altair_admin_common.min.js"></script> -->
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
<!--
<?php
/*
$auth = $this->Session->read('Auth');
if($deptCode == "0" && $grp_id=="-1"){
    $desg = $this->Common->findAllDesignationInMyProfileandMgmtGrp($grp_id);
}elseif($deptCode != "0" && $grp_id !="-1"){
    $desg = $this->Common->getAllDesignationByDeptandMgmtGrp($deptCode,$grp_id);
}
elseif($deptCode == "0" && $grp_id !="-1"){
    $desg = $this->Common->getAllDesignationByDeptandMgmtGrp1($deptCode,$grp_id);
}
*/
?>
-->

<?php
$kra_config = $this->Session->read('sess_kra_config');
$auth = $this->Session->read('Auth');


if($kra_config['MstPmsConfig']['app_type'] == 1){
	if($deptCode == "0"){
		$desg = $this->Common->findAllDesignationInMyProfile();
	}else{
		$desg = $this->Common->getAllDesignationByDept($deptCode);
	}
}
if($kra_config['MstPmsConfig']['app_type'] == 2){
	if($deptCode == "0"){
		$desg = $this->Common->findDesignationListAll();
	}else{
		$desg = $this->Common->getAllDesignationByDept($deptCode);
	}
}
//print_r($desg); die;
?>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-1">
        <div class="parsley-row">
            <br>
            <?php 
            if(isset($desg)){
            ?>
            <input type='checkbox' class='md-input' onClick='toggle(this)' /> Select All<br /><br />
            <?php foreach ($desg as $key) {
                   $p = $auth['MyProfile']['comp_code'];
                    //echo $key;  echo $p;
					$name= ucwords(strtolower($this->Common->findDesignationName($key, $p)));
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						
					if(!strstr( $name, ucwords("operator") )){
					
                ?>
            <span class="icheck-inline" style="width:20%">
                    <input type="checkbox" class='md-input' required="" name="data[desg_id][]" value='<?php echo $key; ?>' id="val_check_ski"/>
                    <label for="val_check_ski" class="inline-label uk-text-small"><?php echo ucwords(strtolower($this->Common->findDesignationName($key, $p))); ?></label>
                </span>
            <?php }
					}else{
						
				?>
				 <span class="icheck-inline" style="width:20%">
                    <input type="checkbox" class='md-input' required="" name="data[desg_id][]" value='<?php echo $key; ?>' id="val_check_ski"/>
                    <label for="val_check_ski" class="inline-label uk-text-small"><?php echo ucwords(strtolower($this->Common->findDesignationName($key, $p))); ?></label>
                </span>
				<?php
					}
				}
            }
            ?>

        </div>
    </div>    
</div>

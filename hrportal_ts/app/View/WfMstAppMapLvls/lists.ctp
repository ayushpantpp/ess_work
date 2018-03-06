<style type="text/css">
    td{
        word-wrap: break-word;
        white-space: normal;

    }
    .td1{
        display:block;
        width:500px;
        overflow: hidden;
    }
    .highlight_word{

        background-color: #ACA;

    }
</style>
<?php

function match($mat) {
    return "^^^^^" . $mat[0] . "~~~~~";
}

function highlightWords($string, $words) {
    $search_exploded = explode(" ", $words);
    foreach ($search_exploded as $search_each) {
        //echo $search_each;
        $search_each = htmlspecialchars_decode($search_each, ENT_QUOTES);
        $search_each = preg_quote($search_each);
        //$string = preg_replace("/\b($search_each)\b/i", '<span class="highlight_word">\1</span>', $string);
        $string = preg_replace_callback("/$search_each/i", "match", $string);
    }
    $string = str_replace('^^^^^', '<span class="highlight_word">', $string);
    $string = str_replace('~~~~~', '</span>', $string);
    return $string;
    /*     * * return the highlighted string ** */
}

	
	
?>

<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
     <tr >
         

    </tr>
    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="5%">S. No.</th>
		<th width="15%"><?php echo $this->Paginator->sort('comp_name', 'Company Name'); ?></th>
		<th width="15%"><?php echo $this->Paginator->sort('dept_name', 'Department Name'); ?></th>
		<th width="20%"><?php echo $this->Paginator->sort('app_name', 'Application Name'); ?></th>
        <th width="10%"><?php echo $this->Paginator->sort('wf_max_lvl', 'Max Level'); ?></th>
		<th width="10%"><?php echo $this->Paginator->sort('wf_hr_approval', 'HR Approval'); ?></th>
                <th width="10%"><?php echo $this->Paginator->sort('manager_approval', 'Manager Approval'); ?></th>
        <th width="15%">Action</th>   


    </tr>
<?php $i = 1; ?>
<?php if (empty($list)) { ?>
        <tr class="cont">
            <td style="text-align:center;" colspan="6">
                <em>--No Records Found--</em>
            </td>
        </tr>
<?php } ?>
<?php
//pr($list);
// echo $this->Form->create('WfMstAppMapLvl', array('url' => 'WfMstAppMapLvl/edit', 'name' => 'searchForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));

foreach ($list as $res) {
	if ($i % 2 == 0) {
        $class = 'cont';
    } else {
        $class = 'cont1';
    }
    
        
	//	 echo $this->Form->create('WfMstAppMapLvl1', array('url' => '#', 'name' => 'msgForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));
?><!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['WfMstAppMapLvl']['wf_id']; ?>">
        <td><?php
			
			$ctr = (($this->params['paging']['WfMstAppMapLvl']['page'] * $this->params['paging']['WfMstAppMapLvl']['limit']) - $this->params['paging']['WfMstAppMapLvl']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
			<?php $comp_name=$this->Common->findCompanyNameByCode($res['WfMstAppMapLvl']['org_id']);
					echo $comp_name;?>
		</td>
		<td>
				<?php $dept_name=$this->Common->getdepartmentbyid($res['WfMstAppMapLvl']['wf_dept_id']);
					echo $dept_name;?>
		</td>
		<td>
			<?php echo $this->Common->getApplicationNamebyid($res['WfMstAppMapLvl']['wf_app_id']);?>
		</td>
		<td>
			<span id="empn<?php echo $res['WfMstAppMapLvl']['wf_max_lvl']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('wf_max_lvl', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName1' . $res['WfMstAppMapLvl']['wf_max_lvl'], 'value' => $res['WfMstAppMapLvl']['wf_max_lvl'])) ?></span>
		</td> 
		<td>
			<?php if($res['WfMstAppMapLvl']['wf_hr_approval']==0)
					echo'No';
				else
					echo'Yes';
			?>
		</td>
                <td>
			<?php if($res['WfMstAppMapLvl']['manager_approval']==0)
					echo'No';
				else
					echo'Yes';
			?>
		</td>
        <td> <a href="javascript:void(0);" mid="<?php echo $res['WfMstAppMapLvl']['wf_id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['WfMstAppMapLvl']['wf_id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
		
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['WfMstAppMapLvl']['wf_id']; ?>" style="display:none;">
		
            <td ><?php
                $ctr = (($this->params['paging']['WfMstAppMapLvl']['page'] * $this->params['paging']['WfMstAppMapLvl']['limit']) - $this->params['paging']['WfMstAppMapLvl']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
			<td>
			<?php $comp_name=$this->Common->findCompanyNameByCode($res['WfMstAppMapLvl']['comp_code']);
					echo $comp_name;?>
		</td>
		<td>
				<?php $dept_name=$this->Common->getdepartmentbyid($res['WfMstAppMapLvl']['wf_dept_id']);
					echo $dept_name;?>
		</td>
		<td>
			<?php echo $this->Common->getApplicationNamebyid($res['WfMstAppMapLvl']['wf_app_id']);?>
		</td>
        <td> 
            <?php echo $this->Form->input('wf_max_lvl', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['WfMstAppMapLvl']['wf_id'],'value'=>$res['WfMstAppMapLvl']['wf_max_lvl'])); ?>
			<div id="dnameErr<?php echo $res['WfMstAppMapLvl']['wf_id']; ?>" style="color:red"></div>
		</td>
		<td> 
            <?php 
			if($res['WfMstAppMapLvl']['wf_hr_approval']==1)
				$checkbox='checked';
			else
				$checkbox='';
			echo $this->Form->input('wf_hr_approval', array('label' => false,  'id' => 'appName_hr' . $res['WfMstAppMapLvl']['wf_id'],'value'=>$res['WfMstAppMapLvl']['wf_hr_approval'],'type'=>'checkbox','checked'=>$checkbox)); ?>
			<div id="dnameErr<?php echo $res['WfMstAppMapLvl']['wf_id']; ?>" style="color:red"></div>
		</td>
                
             <td> 
            <?php 
			if($res['WfMstAppMapLvl']['manager_approval']==1)
				$checkbox='checked';
			else
				$checkbox='';
			echo $this->Form->input('manager_approval', array('label' => false,  'id' => 'appName_hr' . $res['WfMstAppMapLvl']['wf_id'],'value'=>$res['WfMstAppMapLvl']['manager_approval'],'type'=>'checkbox','checked'=>$checkbox)); ?>
			<div id="dnameErr<?php echo $res['WfMstAppMapLvl']['wf_id']; ?>" style="color:red"></div>
            </td>

            <td > <a href="javascript:void(0);" mid="<?php echo $res['WfMstAppMapLvl']['wf_id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['WfMstAppMapLvl']['wf_id']; ?>" id="cancel">Cancel</a> </td>
			
	   </tr>
        <!-- End Edit --> 
        <?php $i++;
      
}?>

<?php //echo $this->Form->end();?>
</table>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>
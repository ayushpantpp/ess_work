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
		<th width="12%"><?php echo $this->Paginator->sort('comp_name', 'Company Name'); ?></th>
		<th width="12%"><?php echo $this->Paginator->sort('dept_name', 'Department Name'); ?></th>
        <th width="22%"><?php echo $this->Paginator->sort('wf_max_lvl', 'Max Level'); ?></th> 
        <th width="40%">Action</th>   


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
//pr($this->params);
 echo $this->Form->create('MstEmpLeaveAllot', array('url' => '#', 'name' => 'searchForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));

foreach ($list as $res) {
	if ($i % 2 == 0) {
        $class = 'cont';
    } else {
        $class = 'cont1';
    }
    
        
	//	 echo $this->Form->create('MstEmpLeaveAllot1', array('url' => '#', 'name' => 'msgForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));
?><!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['MstEmpLeaveAllot']['wf_id']; ?>">
        <td><?php
			
			$ctr = (($this->params['paging']['MstEmpLeaveAllot']['page'] * $this->params['paging']['MstEmpLeaveAllot']['limit']) - $this->params['paging']['MstEmpLeaveAllot']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
			<?php $comp_name=$this->Common->findCompanyNameByCode($res['MstEmpLeaveAllot']['comp_code']);
					echo $comp_name;?>
		</td>
		<td>
				<?php $dept_name=$this->Common->getdepartmentbyid($res['MstEmpLeaveAllot']['wf_dept_id']);
					echo $dept_name;?>
		</td>
		<td>
		<span id="empn<?php echo $res['MstEmpLeaveAllot']['wf_max_lvl']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('desg_name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName1' . $res['MstEmpLeaveAllot']['wf_max_lvl'], 'value' => $res['MstEmpLeaveAllot']['wf_max_lvl'])) ?></span>
			</td> 
					
         			
            <td> <a href="javascript:void(0);" mid="<?php echo $res['MstEmpLeaveAllot']['wf_id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['MstEmpLeaveAllot']['wf_id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
		
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['MstEmpLeaveAllot']['wf_id']; ?>" style="display:none;">
		
            <td ><?php
                $ctr = (($this->params['paging']['MstEmpLeaveAllot']['page'] * $this->params['paging']['MstEmpLeaveAllot']['limit']) - $this->params['paging']['MstEmpLeaveAllot']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
			<td>
			<?php $comp_name=$this->Common->findCompanyNameByCode($res['MstEmpLeaveAllot']['comp_code']);
					echo $comp_name;?>
		</td>
		<td>
				<?php $dept_name=$this->Common->getdepartmentbyid($res['MstEmpLeaveAllot']['wf_dept_id']);
					echo $dept_name;?>
		</td>
            <td> 
                <?php echo $this->Form->input('desg_name', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['MstEmpLeaveAllot']['wf_max_lvl'],'value'=>$res['MstEmpLeaveAllot']['wf_max_lvl'])); ?>
				<div id="dnameErr<?php echo $res['MstEmpLeaveAllot']['wf_id']; ?>" style="color:red"></div>
			</td>
		

            <td > <a href="javascript:void(0);" mid="<?php echo $res['MstEmpLeaveAllot']['wf_id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['MstEmpLeaveAllot']['wf_id']; ?>" id="cancel">Cancel</a> </td>
			
	   </tr>
        <!-- End Edit --> 
        <?php $i++;
      
}?>

<?php echo $this->Form->end();?>
</table>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>

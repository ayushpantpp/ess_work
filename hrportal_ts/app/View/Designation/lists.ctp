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
<div id="result">
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
     <tr >
         <td colspan="4"><b>Designation</b></td> 

    </tr>
    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%">S. No.</th>
        <th width="10%"><?php echo $this->Paginator->sort('company', 'Company Name'); ?></th> 
        <th width="20%"><?php echo $this->Paginator->sort('desc', 'Designation Name'); ?></th> 
	<th width="20%"><?php echo $this->Paginator->sort('desg_code', 'Desiganation Code'); ?></th> 
        <th width="20%"><?php echo $this->Paginator->sort('status', 'Status'); ?></th> 
        <th width="35%">Action</th>   


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
 echo $this->Form->create('Designation', array('url' => '#', 'name' => 'searchForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));

foreach ($list as $res) {
	if ($i % 2 == 0) {
        $class = 'cont';
    } else {
        $class = 'cont1';
    }
    
        
	//	 echo $this->Form->create('Designation1', array('url' => '#', 'name' => 'msgForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));
?><!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['Designation']['id']; ?>">
        <td><?php
			
			$ctr = (($this->params['paging']['Designation']['page'] * $this->params['paging']['Designation']['limit']) - $this->params['paging']['Designation']['limit']) + $i;
			echo $ctr;
			?>
		</td>
        <td>
             <?php 

             $company = $this->Common->findCompanyNameByCode($res['Designation']['comp_code']);?>
        <span id="empn<?php echo $res['Designation']['comp_code']; ?>" style="width:300px; word-wrap:break-word;">
            <?php echo  $company; ?></span>
            </td> 
        
		<td>
		<span id="empn<?php echo $res['Designation']['desc']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('desg_name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName1' . $res['Designation']['desc'], 'value' => $res['Designation']['desc'])) ?></span>
			</td> 
			<td>
		<span id="empc<?php echo $res['Designation']['desg_code']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('desg_code', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'desgCode1' . $res['Designation']['desg_code'], 'value' => $res['Designation']['desg_code'])) ?></span>
			</td>
		<td>
		<span id="empn<?php echo $res['Designation']['status']; ?>" style="width:300px; word-wrap:break-word;">
			<?php 
			$status = array('1'=>'Active','0'=>'Inactive');
			echo $status[$res['Designation']['status']];?></span></td> 
					
         			
            <td> <a href="javascript:void(0);" mid="<?php echo $res['Designation']['id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['Designation']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
		
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['Designation']['id']; ?>" style="display:none;">
		
            <td ><?php
                $ctr = (($this->params['paging']['Designation']['page'] * $this->params['paging']['Designation']['limit']) - $this->params['paging']['Designation']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
<td>
             <?php 

             $company = $this->Common->findCompanyNameByCode($res['Designation']['comp_code']);?>
        <span id="empn<?php echo $res['Designation']['comp_code']; ?>" style="width:300px; word-wrap:break-word;">
            <?php echo  $company; ?></span>
            </td> 


			
            <td> 
                <?php echo $this->Form->input('desg_name', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['Designation']['id'],'value'=>$res['Designation']['desc'])); ?>
				<div id="dnameErr<?php echo $res['Designation']['id']; ?>" style="color:red"></div>
			</td>
			 <td> 
                <?php echo $this->Form->input('desg_code', array('class' => 'round_select', 'label' => false,  'id' => 'desgCode' . $res['Designation']['id'],'value'=>$res['Designation']['desg_code'])); ?>
				<div id="dcodeErr<?php echo $res['Designation']['id']; ?>" style="color:red"></div>
			</td>
			<td>
		<span id="empn<?php echo $res['Designation']['status']; ?>" style="width:300px; word-wrap:break-word;">
			<?php 
			$status = array('1'=>'Active','0'=>'Inactive');
			echo $status[$res['Designation']['status']];?></span></td> 
		

            <td > <a href="javascript:void(0);" mid="<?php echo $res['Designation']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['Designation']['id']; ?>" id="cancel">Cancel</a> </td>
			
	   </tr>
        <!-- End Edit --> 
        <?php $i++;
      
}?>

<?php echo $this->Form->end();?>
</table></div>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>

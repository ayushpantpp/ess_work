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
         

    </tr>
    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%" style="text-align: center">S. No.</th>
	<th width="22%" style="text-align: center" ><?php echo $this->Paginator->sort('comp_name', 'Company Name'); ?></th> 
        <th width="15%" style="text-align: center"><?php echo $this->Paginator->sort('Appid', 'App ID'); ?></th> 
        <th width="15%" style="text-align: center"><?php echo $this->Paginator->sort('Apply_in_days', 'Apply In Days'); ?></th> 
        
        <th width="35%" style="text-align: center">Action</th>   


    </tr>
<?php $i = 1; ?>
<?php  

if (empty($list)) { ?>
        <tr class="cont">
            <td style="text-align:center;" colspan="6">
                <em>--No Records Found--</em>
            </td>
        </tr>
<?php } ?>
<?php
//pr($this->params);
 echo $this->Form->create('Masters', array('url' => '#', 'name' => 'msgForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));

foreach ($list as $res) {
	if ($i % 2 == 0) {
        $class = 'cont';
    } else {
        $class = 'cont1';
    }
    
        
	//	 echo $this->Form->create('Masters1', array('url' => '#', 'name' => 'msgForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));
?><!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['Appmaster']['id']; ?>">
        <td><?php
			
			$ctr = (($this->params['paging']['Appmaster']['page'] * $this->params['paging']['Appmaster']['limit']) - $this->params['paging']['Appmaster']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
			<?php //echo $res['Masters']['comp_code']; 
			$comp_name=$this->Common->findCompanyNameByCode($res['Appmaster']['org_id']);
					echo $comp_name;
			?>
		</td>
		<td>
		<span id="empn<?php echo $res['Appmaster']['app_id']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('app_name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName1' . $res['Appmaster']['id'], 'value' => $res['Appmaster']['app_id'])) ?></span>
			</td> 
			<td>
		<span id="empc<?php echo $res['Appmaster']['apply_in_days']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('apply_days', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'apply_max_days' . $res['Appmaster']['id'], 'value' => $res['Appmaster']['apply_in_days'])) ?></span>
			</td>
		
					
         			
<td> <a href="javascript:void(0);" mid="<?php echo $res['Appmaster']['id']; ?>" id="edit">Edit</a> | 
		 <a href="javascript:void(0);" mid="<?php echo $res['Appmaster']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
		
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['Appmaster']['id']; ?>" style="display:none;">
		
            <td ><?php
                $ctr = (($this->params['paging']['Appmaster']['page'] * $this->params['Appmaster']['Masters']['limit']) - $this->params['paging']['Appmaster']['limit']) + $i;

                 $ctr;
                 echo $i;
                    ?>
            </td>
			 <td><span id="empn<?php echo $res['Appmaster']['org_id']; ?>" style="width:300px; word-wrap:break-word;">
             <?php
                
                $company = $this->Common->findCompanyName();
                echo $this->Form->input('company', array('class' => 'round_select_tbl','disabled' => 'false',  'id' => 'org_id' . $res['Appmaster']['id'],'options'=>$company,'default'=>$res['Appmaster']['org_id'])); ?></span>
            </td>
            <td> 
                <?php echo $this->Form->input('appid', array('class' => 'round_select', 'disabled' => 'false',  'id' => 'app_id' . $res['Appmaster']['id'],'value'=>$res['Appmaster']['app_id'])); ?>
				<div id="dnameErr<?php echo $res['Appmaster']['app_id']; ?>" style="color:red"></div>
			</td>
			  <td> 
                <?php echo $this->Form->input('apply_days', array('class' => 'round_select', 'disabled' => 'false',  'id' => 'appdays' . $res['Appmaster']['id'],'value'=>$res['Appmaster']['apply_in_days'])); ?>
                <div id="dnameErr<?php echo $res['Appmaster']['apply_in_days']; ?>" style="color:red"></div>
            </td>
			
		

            <td > <a href="javascript:void(0);" mid="<?php echo $res['Appmaster']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['Appmaster']['id']; ?>" id="cancel">Cancel</a> </td>
			
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

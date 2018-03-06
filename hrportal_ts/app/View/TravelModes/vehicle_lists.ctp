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
<div id = "result">
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
  

    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%">S. No.</th>
        <th width="30%"><?php echo $this->Paginator->sort('name', 'Vehical Name'); ?></th> 
        <th width="30%"><?php echo $this->Paginator->sort('org_id', 'Related Organization'); ?></th> 
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
foreach ($list as $res) {
	if ($i % 2 == 0) {
        $class = 'cont';
    } else {
        $class = 'cont1';
    }
    ?>
        <!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['MstVehicleMode']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['MstVehicleMode']['page'] * $this->params['paging']['MstVehicleMode']['limit']) - $this->params['paging']['MstVehicleMode']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
		<span id="empn<?php echo $res['MstVehicleMode']['Vehical_name']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName' . $res['MstVehicleMode']['Vehical_name'], 'value' => $res['MstVehicleMode']['Vehical_name'])) ?></span>
			</td> 	
                         <td>
                <span id="empn<?php echo $res['MstVehicleMode']['org_id']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Common->findCompanyNameByCode($res['MstVehicleMode']['org_id']); ?></span>
			</td>
         			
            <td> <a href="javascript:void(0);" mid="<?php echo $res['MstVehicleMode']['id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['MstVehicleMode']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['MstVehicleMode']['id']; ?>" style="display:none;">
            <td ><?php
                $ctr = (($this->params['paging']['MstVehicleMode']['page'] * $this->params['paging']['MstVehicleMode']['limit']) - $this->params['paging']['MstVehicleMode']['limit']) + $i;

                echo $ctr;
                    ?>

            </td>
			
            <td> 
                                
               
                <?php echo $this->Form->input('name', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['MstVehicleMode']['id'],'value'=>$res['MstVehicleMode']['Vehical_name'])); ?>
				<div id="dcnameErr<?php echo $res['MstVehicleMode']['id']; ?>" style="color:red"></div>
			   </td > 
                <td><span id="empn<?php echo $res['MstVehicleMode']['org_id']; ?>" style="width:300px; word-wrap:break-word;">
             <?php
                
                $company = $this->Common->findCompanyName();
                echo $this->Form->input('org_id', array('class' => 'round_select_tbl','disabled' => 'false', 'label' => false,  'id' => 'org_id' . $res['MstVehicleMode']['id'],'options'=>$company,'default'=>$res['MstVehicleMode']['org_id'])); ?></span>
            </td>
              <td>  <a href="javascript:void(0);" mid="<?php echo $res['MstVehicleMode']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['MstVehicleMode']['id']; ?>" id="cancel">Cancel</a> </td>
        </tr>
        <!-- End Edit --> 
        <?php $i++;
    
}?>




  
</table>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>
</div>

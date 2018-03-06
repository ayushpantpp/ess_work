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
        <th width="30%"><?php echo $this->Paginator->sort('name', 'Travel Mode Name'); ?></th> 
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
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['MstTravelMode']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['MstTravelMode']['page'] * $this->params['paging']['MstTravelMode']['limit']) - $this->params['paging']['MstTravelMode']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
		<span id="empn<?php echo $res['MstTravelMode']['name']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName' . $res['MstTravelMode']['name'], 'value' => $res['MstTravelMode']['name'])) ?></span>
			</td> 	
                         <td>
                <span id="empn<?php echo $res['MstTravelMode']['org_id']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Common->findCompanyNameByCode($res['MstTravelMode']['org_id']); ?></span>
			</td>
         			
            <td> <a href="javascript:void(0);" mid="<?php echo $res['MstTravelMode']['id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['MstTravelMode']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['MstTravelMode']['id']; ?>" style="display:none;">
            <td ><?php
                $ctr = (($this->params['paging']['MstTravelMode']['page'] * $this->params['paging']['MstTravelMode']['limit']) - $this->params['paging']['MstTravelMode']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
			
            <td> 
                <?php echo $this->Form->input('name', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['MstTravelMode']['id'],'value'=>$res['MstTravelMode']['name'])); ?>
				<div id="dcnameErr<?php echo $res['MstTravelMode']['id']; ?>" style="color:red"></div>
			</td>
<td><span id="empn<?php echo $res['MstTravelMode']['org_id']; ?>" style="width:300px; word-wrap:break-word;">
             <?php
                
                $company = $this->Common->findCompanyName();
                echo $this->Form->input('org_id', array('class' => 'round_select_tbl','disabled' => 'false', 'label' => false,  'id' => 'org_id' . $res['MstTravelMode']['id'],'options'=>$company,'default'=>$res['MstTravelMode']['org_id'])); ?></span>
            </td>
            <td > <a href="javascript:void(0);" mid="<?php echo $res['MstTravelMode']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['MstTravelMode']['id']; ?>" id="cancel">Cancel</a> </td>
        </tr>
        <!-- End Edit --> 
        <?php $i++;
    
}?>





</table></div>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>

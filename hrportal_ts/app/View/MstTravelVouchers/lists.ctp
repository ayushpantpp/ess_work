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
        <th width="7%">S. No.</th>
        <th width="20%"><?php echo $this->Paginator->sort('travel_name', 'Name'); ?></th> 
        <th width="30%"><?php echo $this->Paginator->sort('org_id', 'Related Organization'); ?></th> 

        <th width="33%">Action</th>   


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
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['MstTravelVoucher']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['MstTravelVoucher']['page'] * $this->params['paging']['MstTravelVoucher']['limit']) - $this->params['paging']['MstTravelVoucher']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
		<span id="empn<?php echo $res['MstTravelVoucher']['desc']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('desc', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName1' . $res['MstTravelVoucher']['desc'], 'value' => $res['MstTravelVoucher']['desc'])) ?></span>
			</td> 
                        <td>
                <span id="empn<?php echo $res['MstTravelVoucher']['org_id']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Common->findCompanyNameByCode($res['MstTravelVoucher']['org_id']); ?></span>
			</td> 
                        
		
					
         			
            <td> <a href="javascript:void(0);" mid="<?php echo $res['MstTravelVoucher']['id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['MstTravelVoucher']['id']; ?>" id="delete">Delete</a> </td>
			  
</td>
        </tr>
        <!-- End View -->


        <!-- Edit -->
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['MstTravelVoucher']['id']; ?>" style="display:none;">
            <td ><?php
                $ctr = (($this->params['paging']['MstTravelVoucher']['page'] * $this->params['paging']['MstTravelVoucher']['limit']) - $this->params['paging']['MstTravelVoucher']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
			
            <td> 
                <?php echo $this->Form->input('desc', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['MstTravelVoucher']['id'],'value'=>$res['MstTravelVoucher']['desc'])); ?>
				<div id="dnameErr<?php echo $res['MstTravelVoucher']['id']; ?>" style="color:red"></div>
			</td>

		

            <td > <a href="javascript:void(0);" mid="<?php echo $res['MstTravelVoucher']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['MstTravelVoucher']['id']; ?>" id="cancel">Cancel</a> </td>
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

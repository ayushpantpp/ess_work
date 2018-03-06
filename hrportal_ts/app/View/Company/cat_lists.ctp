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
  

    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%">S. No.</th>
        <th width="30%"><?php echo $this->Paginator->sort('comp_name', 'Company Name'); ?></th>
		<th width="30%"><?php echo $this->Paginator->sort('comp_code', 'Catagory Desc'); ?></th> 
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
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['MstCat']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['MstCat']['page'] * $this->params['paging']['MstCat']['limit']) - $this->params['paging']['MstCat']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
            <?php $Company=$this->Common->findCompanyNameByCode($res['MstCat']['org_id']);?>

		<span id="empn<?php echo $res['MstCat']['org_id']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('comp_name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName' . $res['MstCat']['comp_name'], 'value' => $Company)) ?></span>
			</td> 
			<td>
		<span id="empn<?php echo $res['MstCat']['catagory_desc']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('Cat_desc', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appCode' . $res['Company']['catagory_desc'], 'value' => $res['MstCat']['catagory_desc'])) ?></span>
			</td> 		
         			
            <td><!--  <a href="javascript:void(0);" mid="<?php echo $res['MstCat']['id']; ?>" id="edit">Edit</a>   -->
		<a href="javascript:void(0);" mid="<?php echo $res['MstCat']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['MstCat']['id']; ?>" style="display:none;">
            <td ><?php
                $ctr = (($this->params['paging']['Company']['page'] * $this->params['paging']['Company']['limit']) - $this->params['paging']['Company']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
			
            <td> 
                <?php echo $this->Form->input('comp_name', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['Company']['id'],'value'=>$res['Company']['comp_name'])); ?>
				<div id="dnameErr<?php echo $res['Company']['id']; ?>" style="color:red"></div>
			</td>
		<td> 
                <?php echo $this->Form->input('comp_code', array('class' => 'round_select', 'label' => false,  'id' => 'appName1' . $res['Company']['id'],'value'=>$res['Company']['comp_code'])); ?>
				<div id="dnameErr<?php echo $res['Company']['id']; ?>" style="color:red"></div>
			</td>
		

            <td > <a href="javascript:void(0);" mid="<?php echo $res['Company']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['Company']['id']; ?>" id="cancel">Cancel</a> </td>
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

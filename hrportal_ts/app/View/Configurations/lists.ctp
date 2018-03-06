<style type="text/css">
    .td{
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
        <th width="7%">S. No.</th>
        <th width="30%"><?php echo $this->Paginator->sort('name', 'Name'); ?></th> 
        <th width="30%">Value</th> 


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
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['AdminOption']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['AdminOption']['page'] * $this->params['paging']['AdminOption']['limit']) - $this->params['paging']['AdminOption']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
		<span id="empn<?php echo $res['AdminOption']['name']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo  $res['AdminOption']['description']; ?></span>
			</td> 
		<td>
		<span id="empn<?php echo $res['ADMIN_ORG']['status']; ?>" class="option_values" style="width:300px; word-wrap:break-word;">
            <input type="hidden" class="id" value="<?php echo $res['AdminOption']['id'];?>" />
            <input type='checkbox' <?php echo ($res['ADMIN_ORG']['status'])?'checked':'';?> />
			

        </span></td> 
			
	
        </tr>
        <!-- End View -->


        <!-- Edit -->
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['AdminOption']['id']; ?>" style="display:none;">
            <td ><?php
                $ctr = (($this->params['paging']['AdminOption']['page'] * $this->params['paging']['AdminOption']['limit']) - $this->params['paging']['AdminOption']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
			
            <td> 
                <?php echo $this->Form->input('name', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['AdminOption']['id'],'value'=>$res['AdminOption']['name'])); ?>
				<div id="dnameErr<?php echo $res['AdminOption']['id']; ?>" style="color:red"></div>
			</td>
			<td>
		<span id="empn<?php echo $res['AdminOption']['value']; ?>" style="width:300px; word-wrap:break-word;">
			<?php 
			$status = array('1'=>'Active','0'=>'Inactive');
			echo $status[$res['AdminOption']['value']];?></span></td> 
            <td > <a href="javascript:void(0);" mid="<?php echo $res['AdminOption']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['AdminOption']['id']; ?>" id="cancel">Cancel</a> </td>
        </tr>
        <!-- End Edit --> 
        <?php $i++; }?>

</table>
 
</div> 
    


<tr>
        <td ><a href="<?php echo $this->webroot;?>Setup/finish"><button type="button" id="finish" class="successButton">Finish N Login</button></a></td>
        <td colspan=6><a href="<?php echo $this->webroot;?>Configurations/admin_option"><button type="button" id="Back" class="successButton">Back</button></a></td>
</tr>


   


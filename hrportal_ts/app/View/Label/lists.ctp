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
        <th width="30%">Name</th>
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
 echo $this->Form->create('Company', array('url' => '#', 'name' => 'searchForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));

foreach ($list as $res) {
	if ($i % 2 == 0) {
        $class = 'cont';
    } else {
        $class = 'cont1';
    }
    
        
	//	 echo $this->Form->create('Label1', array('url' => '#', 'name' => 'msgForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));
?><!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['Labels']['id']; ?>">
        <td><?php echo $res['Labels']['id']; ?>	</td>
		<td>
		<span id="empn<?php echo $res['Labels']['name']; ?>" style="width:300px; word-wrap:break-word;">
		<?php echo $this->Form->input('desg_name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName1' . $res['Labels']['name'], 'value' => $res['Labels']['name'])) ?></span>
		</td>  
					
         			
            <td> <a href="javascript:void(0);" mid="<?php echo $res['Labels']['id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['Labels']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
		
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['Labels']['id']; ?>" style="display:none;">
		
            <td >
            </td>
			
            <td> 
                <?php echo $this->Form->input('desg_name', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['Labels']['id'],'value'=>$res['Labels']['name'])); ?>
				<div id="dnameErr<?php echo $res['Labels']['id']; ?>" style="color:red"></div>
			</td> 
		    <td > <a href="javascript:void(0);" mid="<?php echo $res['Labels']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['Labels']['id']; ?>" id="cancel">Cancel</a> </td>
			
	   </tr>
        <!-- End Edit --> 
        <?php $i++;
      
}?>

<?php echo $this->Form->end();?>
</table>


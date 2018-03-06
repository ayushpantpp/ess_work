<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>-->
<script type="text/javascript">
function modal(id)
{
		$('#dialog').dialog('open');
		jQuery("#load").html('Loading...');
		$("#frm").hide();
		
		$.ajax({
        type:"GET",
        cache:false,         
		url:"<?php echo $this->webroot;?>Employees/findUserDetailByEmpCode/"+id,	
        success: function (data) {
		var list='';
		data = jQuery.parseJSON(data);
		 $.each(data,function(index,value){
			 list+=value;
			});
		$("#username").val(list);
		$("#emp_code").val(id);
		jQuery("#load").html('');
		$("#frm").show();
		}
      });
	
}
			$(function(){

			       // Dialog
				$('#dialog').dialog({
					
					autoOpen: false,
					width: 400,
                    modal:true,
					buttons: {
						"Ok": function() {
							
											var err=0;
                                            var user=$('#username').val();
											var pass=$('#password').val();
											var cpass=$('#confirm_password').val();
											if(user=='') {
											jQuery("#dnameErr").html("Enter Username");
											return false;
											}
											else{
												jQuery("#dnameErr").html("");
												}
											if(pass=='') {
											jQuery("#dpassErr").html("Enter Password");
											return false;
											}
											else{
												jQuery("#dpassErr").html("");
												}
											if(cpass=='') {
											jQuery("#dcpassErr").html("Enter Confirm Password");
											return false;
											}
											else{
												jQuery("#dcpassErr").html("");
												}
											if(err==0) {
												$('#dialog').dialog('close');
												 jQuery("#overlay").show();
												var emp_code=$("#emp_code").val();
												//alert(emp_code);
												$.ajax({
														type: "POST",
														url: "<?php echo $this->webroot ?>Employees/UpdateDetails/",
														data: {"username": user, "password": pass ,"confirm_password": cpass,"emp_code":emp_code},
														success: function(data_var)
														{
															data = jQuery.parseJSON(data_var);
															jQuery("#overlay").hide();
															createMsg(data.msg,data.type);
														}
														});
												} else {
												return false;
											}
                                         },
						"Cancel": function() {
							$(this).dialog("close");
						}
					}
				});
                    	   

			});

		</script>
		<script>
		jQuery(document).ready(function(){
	jQuery('#viewdetails').dialog({ 
		autoOpen: false,
		modal: true,
		width: 400,
		height: 300,
		 });
	
	
});  
function view(id)
{
	 jQuery('#viewdetails').dialog("open");
	  var data='Loading....'; 
    jQuery('#viewdetails').html(data);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>employees/getDetails/'+id,
        success: function(data){
			//alert(data);
			//data = jQuery.parseJSON(data);
            jQuery('#viewdetails').html(data);
        }
    });
}
		</script>
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
         <td colspan="4"><b>Employee Profile</b></td> 

    </tr>
    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="5%">S. No.</th>
        <th width="18%"><?php echo $this->Paginator->sort('emp_code', 'Company Name'); ?></th> 
       <th width="18%"><?php echo $this->Paginator->sort('dept_code', 'Dept. Name'); ?></th>
        <th width="18%"><?php echo $this->Paginator->sort('desg_code', 'Desg. Name'); ?></th> 
		<!--<th width="15%"><?php //echo $this->Paginator->sort('emp_firstname', 'Firstname'); ?></th>
		<th width="15%"><?php //echo $this->Paginator->sort('emp_lastname', 'Lastname'); ?></th>-->
		<th width="18%"><?php echo $this->Paginator->sort('comp_code', 'Employee Name'); ?></th>
        <th width="18%">Action</th>   


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
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['Employee']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['Employee']['page'] * $this->params['paging']['Employee']['limit']) - $this->params['paging']['Employee']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
		<span id="empn<?php echo $res['Employee']['comp_code']; ?>" style="width:300px; word-wrap:break-word;"></span>
					<?php $comp_name=$this->Common->findCompanyNameByCode($res['Employee']['comp_code']);
							echo $comp_name;
					?></span>
		</td>
		<td>
        <span id="empn<?php echo $res['Employee']['dept_code']; ?>" style="width:300px; word-wrap:break-word;">
			<?php $res['Employee']['dept_code']; 
				$dept_name=$this->Common->getdepartmentbyid($res['Employee']['dept_code']);
				echo $dept_name;
			?></span>
		</td>
		<td>
        <span id="empn<?php echo $res['Employee']['desg_code']; ?>" style="width:300px; word-wrap:break-word;">
			<?php  //echo $res['Employee']['desg_code'];
					$desg_name=$this->Common->findDesignationNameByCode($res['Employee']['desg_code']);
				echo $desg_name;

			?></span>
		</td> 
		<td>
		<span id="empn<?php echo $res['Employee']['emp_firstname']; ?>" style="width:300px; word-wrap:break-word;">
					<?php echo $res['Employee']['emp_firstname']." ".$res['Employee']['emp_lastname']; 
							
					?></span>
			</td> 
		    <td> <a href="#" mid="<?php echo $res['Employee']['id'];?>" id="dialog_link1" onclick="view(<?php echo $res['Employee']['emp_code']?>);">View</a> || <a href="#" mid="<?php echo $res['Employee']['id'];?>" id="dialog_link" onclick="modal(<?php echo $res['Employee']['emp_code']?>);" value="<?php echo $res['Employee']['emp_code'];?>">Credentials</a> || <a href="<?php echo $this->webroot ?>Employees/index/" mid="<?php echo $res['Employee']['id']; ?>" id="delete"> Edit</a></td>

        </tr>
        <!-- End View -->
		
        <?php $i++;
    
}?>





</table>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" >--> </div>


</div>
<div id="dialog" title="Employee Credentials" style="display:none">
<div id="load"></div>
    <div id="frm"><table>
       <tr><td> Username </td><td><input type="text" id="username"> </input></td></tr>
	   <tr><td></td><td><div id="dnameErr" style="color:red"></div></td></tr>
		<tr><td>Password </td><td><input type="password" name="password" id="password"> </input><br/></td></tr>
		<tr><td></td><td><div id="dpassErr" style="color:red"></div></td></tr>
		<tr><td>Confirm Password </td><td><input type="password" id="confirm_password"> </input></td></tr>
		<tr><td></td><td><div id="dcpassErr" style="color:red"></div></td></tr>
		<tr><td></td><td><input type="hidden" id="emp_code"> </input></td></tr>
        <div class="ui-widget" id="errdis" style="display:none">
            <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
            </div>
        </div>
		</table>
    </div>
</div>

<div id="viewdetails" title="Employee Details" style="width:590px;">
    <span id="display_details">Loading....</span>   
</div>

<style>
.ui-widget-overlay{z-index:1 !important;}
</style>
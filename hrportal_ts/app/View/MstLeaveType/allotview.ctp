<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#viewdetails').dialog({ 
		autoOpen: false,
		modal: true,
		 });
	
	
});  
function Get_Details(id)
{   
   jQuery('#viewdetails').dialog("open");
	
    var data='Loading....'; 
    jQuery('#viewdetails').html(data);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>leavestype/leavedetail/'+id,
        success: function(data){
            jQuery('#viewdetails').html(data);
        }
    });
}
function Edit_Details(id)
{   
   jQuery('#viewdetails').dialog("open");
	
    var data='Loading....'; 
    jQuery('#viewdetails').html(data);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>leavestype/editallot/'+id,
        success: function(data){
            jQuery('#viewdetails').html(data);
        }
    });
 }
</script>

<div class="breadCrumbHolder module">
	<div id="breadCrumb0" class="breadCrumb	module">
		<ul>
			<li><a href="#" class="vtip" title="Home">Home</a></li>
			<li>Alloted Leaves<?php //echo $this->html->link('Self Services', $this->html->url('/selfservices',	true));	?> </li>
			<li>Alloted Leave List</li>
		</ul>
	</div>
</div>

<h2 class="demoheaders">Leave List</h2>
<div class="travel-voucher1">
	<div class="input-boxs">
		<div class="travel-voucher1">
			<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
				<tr class="head">
					<th scope="row">Sr.No</th>
					<th>Employee Name</th>
					<th>Action</th>
				</tr>
				<?php if (empty($list)) { ?>
				<tr class="cont">
					<td style="text-align:center;" colspan="10"><em>--No Records Found--</em></td>
				</tr>
				<?php } 
				//$auth=$this->Session->read('Auth');
				$i=1; 
				foreach($list as $l)
				{ 
					if($i%2==0)$class='cont'; else $class='cont1';  ?>	  
					<tr class="<?php echo $class; ?>">
						<td><?php 
						 @$ctr = (($this->params['paging']['MstEmpLeaveAllot']['options']['page']*$this->params['paging']['MstEmpLeaveAllot']['options']['limit'])-$this->params['paging']['MstEmpLeaveAllot']['options']['limit'])+$i;
						   echo $ctr; ?>
						</td> 
						
						<td><?php  echo $this->Common->getempname($l['MstEmpLeaveAllot']['emp_code']); ?></td>
						<td>
							<ul class="edit-delete-icon">
								<li style="border-right:none;"><a href="#" onclick="Get_Details('<?php echo $l['MstEmpLeaveAllot']['emp_code']; ?>')" class="view vtip" title="Click to View.">View</a></li>
								<li style="border-right:none;"><a href="#" onclick="Edit_Details('<?php echo $l['MstEmpLeaveAllot']['emp_code']; ?>')" class="view vtip" title="Click to Edit.">Edit</a></li>
							</ul>
						</td>
					</tr>
				<?php $i++; } ?> 
			</table>
			<div class="navigation">
				<?php echo $this->Paginator->counter(); ?> Pages
				<?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
				<?php echo $this->Paginator->numbers(); ?>
				<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
			</div>  
		</div>
	</div>
</div>
<div id="viewdetails" title="Leave Details" style="width:590px;">
    <span id="display_details">Loading....</span>   
</div>

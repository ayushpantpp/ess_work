




<script>
jQuery(document).ready(function(){
    $('#alerts').hide;
      
}); 
function Get_Details(id)
{   
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>leaves/leavedetail/'+id,
        success: function(data){
            jQuery('.HRcontent').html(data);
        }
    });
 }


</script> 
<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" href="#">×</a>
    <div class="HRcontent"> </div>
  </div>
</div>
<div class="right_col" role="main"> 
    <!-- Content Header (Page header) -->
 
    
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
       	<div class="events form">
<?php echo $this->Form->create('Event'); ?>
	<fieldset>
		<legend><?php echo __('Add Event'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('event_date');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
      </div>

      <br />
    </div>
</div>
    <!-- /page content --> 

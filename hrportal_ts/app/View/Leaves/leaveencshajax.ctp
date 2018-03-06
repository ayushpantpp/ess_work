<div class="uk-grid">
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
        <?php echo $this->Form->input('maxlimit', array('label' => "Leave Encash Limit *", 'type' => 'text', 'value' => $max, 'id' => 'maxlimit', 'class' => 'md-input')); ?> 
  <?php echo $this->Form->input('leavetype', array('label' => false, 'type' => 'hidden','value'=>$leavetypename,'id'=>'maxlimit', 'class' => 'md-input')); ?>      
        </div>
    </div>
    <div class="uk-width-medium-1-2">
        <label>Balance Remaining *:</label>
        <div class="parsley-row">
  <?php echo  $pendingLeave; ?>
   <?php echo $this->Form->input('leavepen', array('label' => false, 'type' => 'hidden','value'=>$pendingLeave,'id'=>'maxbal', 'class' => 'md-input')); ?> 
   <?php echo $this->Form->input('saloneday', array('label' => false, 'type' => 'hidden','value'=>$saloneday,'id'=>'saloneday', 'class' => 'md-input')); ?>        
        </div>
    </div>
</div>
</div>
<script>
    $('#maxlimit').prop('readonly', true);
</script>

<tr class="cont1" id="row_<?php echo $this->request->data['rowCount'];?>">
<td><?php echo $this->Form->input('Claimdate.'.$this->request->data['rowCount'], array('id'=>"expense_".$this->request->data['rowCount'],"data-uk-datepicker" => "{format:DD-MM-YYYY,maxDate : date}", 'label' => false, 'type' => 'text', 'class' => 'required expenseTest', 'MAXLENGTH' => '20','autocomplete' => 'off')); ?>
  <script type="text/javascript"> 
    
     //jQuery(".expenseTest").datepicker({inline: true, changeMonth:true, changeYear:true,dateFormat: 'dd-mm-yy'  });
    </script>
</td>
<td>
<?php $travelmode=$this->Common->findAllVehical(); ?>

<?php echo $this->Form->input('Travel_mode.'.$this->request->data['rowCount'], array('id'=>'travel_'.$this->request->data['rowCount'],'type' => 'select', 'label' => false, 'options' => $travelmode, 'class' => 'requiredSelect')); ?></td>
    <td><?php echo $this->Form->textarea('description.'.$this->request->data['rowCount'], array('id'=>'description_'.$this->request->data['rowCount'],'rows' => '2', 'class' => 'required', 'MAXLENGTH' => '200','autocomplete' => 'off')); ?></td>
    <td><?php echo $this->Form->input('distance.'.$this->request->data['rowCount'] , array('id'=>'distance_'.$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required', 'MAXLENGTH' => '6','autocomplete' => 'off')); ?></td>
    <td><?php echo $this->Form->input('claim_amt.'.$this->request->data['rowCount'], array('id'=>'claim_amt_'.$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required', 'autocomplete' => 'off','onfocus' => 'calculate();', 'onClick' => 'calculate();')); ?></td>
</tr>

<style type="text/css">
    .required{
        width:182px;
        height:19px;
        padding:5px;
    }
    .requiredSelect{
        width:182px;
        height:32px;
        padding:5px;
    }
</style>

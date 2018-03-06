 <tr class="cont1" id="row_<?php echo $this->request->data['rowCount'];?>">
 <td>
 <select class="form-control" name="Investment.<?php echo $this->request->data['rowCount'];?>">
<?php   foreach($investment as $name){
foreach($name as $k=>$val)  {  
?>
<option value="<?php echo $k ?>"><?php echo $val;?></option>
<?php 

} }?>
  
 </select>
 </td>     
 
    <td><?php echo $this->Form->input('planned.'.$this->request->data['rowCount'], array('id'=>'planned.'.$this->request->data['rowCount'], 'label' => false,'type' => 'text',  'class' => 'required', 'autocomplete' => 'off')); ?></td>
    <td><?php echo $this->Form->input('actual.'.$this->request->data['rowCount'] , array('id'=>'actual.'.$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required',  'autocomplete' => 'off')); ?></td>
</tr>

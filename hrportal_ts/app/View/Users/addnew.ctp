<?php $i = $this->request->data['rowCount'];?>
<tr class="even pointer" id="row_<?php echo $this->request->data['rowCount'];?>">
<td><?php echo $this->Form->input('member.'.$this->request->data['rowCount'], array('id'=>'member_'.$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off','onkeypress'=>"changetext($i)")); ?> </td>
<td><?php echo $this->Form->input('relation.'.$this->request->data['rowCount'] , array('id'=>'relation_'.$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required', 'MAXLENGTH' => '20', 'autocomplete' => 'off','onkeypress'=>"changetext($i)")); ?></td>
<td><?php echo $this->Form->input('occupation.'.$this->request->data['rowCount'] , array('id'=>'occupation_'.$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required', 'MAXLENGTH' => '20', 'autocomplete' => 'off','onkeypress'=>"changetext($i)")); ?></td>
<td><?php echo $this->Form->input('dob.'.$this->request->data['rowCount'], array('id'=>'dob_'.$this->request->data['rowCount'],'label' => false, 'class' => 'required dob', 'autocomplete' => 'off','readonly'=>true)); ?></td>
<td> <select name='gender.<?php echo $this->request->data['rowCount']?>'>
<option value="PAR0000061">Male</option>
<option value="PAR0000062">Female</option>

</select></td>
</tr>
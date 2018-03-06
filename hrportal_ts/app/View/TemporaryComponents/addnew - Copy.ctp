

<tr class="cont1" id="row_<?php echo $this->request->data['rowCount'];?>">
<td><?php //echo $this->Form->input('Claimdate.'.$this->request->data['rowCount'], array('id'=>"claimdate_".$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required expenseTest', 'MAXLENGTH' => '20','autocomplete' => 'off')); ?>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
    <script>
    function hello() {
    $('select').change(function() {
      self = $(this);
      choosen = $(this).val();

      $('select').not(self).each(function() {

        if ($(this).val() == choosen) {

          // $(this).prop('disabled', true);
          alert('Temporary Component is already selected');
          $(self).val($(this).find("option:first").val());
        }

      });

    });
  });
  </script>
</td>
<td>
<?php $temp_code=$this->Common->findAllTempComponent();?>

<?php echo $this->Form->input('temp_code.'.$this->request->data['rowCount'], array('id'=>'temp_code_'.$this->request->data['rowCount'],'type' => 'select', 'label' => false, 'options' => $temp_code, 'empty' => ' -- Select --', 'class' => 'required form-control')); ?></td>
   <td><?php echo $this->Form->input('amount.'.$this->request->data['rowCount'], array('id'=>'amount_'.$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required form-control', 'autocomplete' => 'off','onfocus' => 'calculate();', 'onClick' => 'calculate();')); ?></td>
</tr>

 




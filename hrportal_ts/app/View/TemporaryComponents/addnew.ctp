

<tr class="cont1" id="row_<?php echo $this->request->data['rowCount'];?>">
<td><?php //echo $this->Form->input('Claimdate.'.$this->request->data['rowCount'], array('id'=>"claimdate_".$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required expenseTest', 'MAXLENGTH' => '20','autocomplete' => 'off')); ?>
  
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
  
    <script>
       
    $(document).ready(function(){
    $('select').change(function() {
      self = $(this);
      choosen = $(this).val();
//alert(choosen);
      $('select').not(self).each(function() {

        if ($(this).val() == choosen) {
//alert($(this).val());
          // $(this).prop('disabled', true);
          alert('Temporary Component is already selected');
          $(self).val($(this).find("option:first").val());
        }

      });

    });
  });
  
  
  
  </script>
<script type="text/javascript">
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }
    </script>
<?php $temp_code=$this->Common->findAllTempComponent($this->request->data['sal_typ']);?>

<?php echo $this->Form->input('temp_code.'.$this->request->data['rowCount'], array('id'=>'temp_code_'.$this->request->data['rowCount'],'type' => 'select', 'label' => false, 'options' => $temp_code, 'empty' => ' -- Select --', 'class' => 'md-input required form-control')); ?></td>


   <td><?php echo $this->Form->input('amount.'.$this->request->data['rowCount'], array('id'=>'amount_'.$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'md-input required form-control', 'autocomplete' => 'off','onkeypress' => 'return IsNumeric(event);')); ?>


 <td> <div class="input text"><div class="md-input-wrapper md-input-filled"> <div class="input text"><div class="md-input-wrapper md-input-filled"><input type="file" id="<?php echo 'file_'.$this->request->data['rowCount'] ;?>" required="required" readonly="readonly" maxlength="20" class="md-input required form-control avatar-input" autocomplete = "off" value="" name="<?php echo 'file.'.$this->request->data['rowCount'] ;?>" data-parsley-id="4"></div></div>  </div></div>

   <span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span></td>
</tr>

 




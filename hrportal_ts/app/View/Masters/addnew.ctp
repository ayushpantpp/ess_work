

<tr class="cont1" id="row_<?php echo $this->request->data['rowCount'];?>">
<td><?php //echo $this->Form->input('Claimdate.'.$this->request->data['rowCount'], array('id'=>"claimdate_".$this->request->data['rowCount'],'label' => false, 'type' => 'text', 'class' => 'required expenseTest', 'MAXLENGTH' => '20','autocomplete' => 'off')); ?>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
    <script>
    $(document).ready(function(){
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
  <span class="cont1" id="row_<?php echo $this->request->data['rowCount'];?>">
  <?php echo "asjhagsdjhagshjug";?>

  </span>


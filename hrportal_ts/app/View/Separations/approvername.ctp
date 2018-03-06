 <div class="col-md-8 col-sm-8 col-xs-12">
              <?php 
              echo $this->Form->input('user_name',array(
                'type' => 'select',
                'options' => $emplist,
                'empty' => false,
                'label' => false,
                'name'  => 'Fnf[%ctr%][approver_id]',
                'class' => "md-input",
                'data-md-selectize'
              ));
              ?>
</div>

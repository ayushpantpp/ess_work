<div role="main" class="right_col">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>FNF workflow</h3>
          </div>
          <?php echo $flash = $this->Session->flash(); ?>
          
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
             
              <div class="x_content"> <br>

                
                <?php echo $this->Form->create('fwleave', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
         'url' => array('controller' => 'fnfs', 'action' => 'saveworkflowinformation'), 'id' => 'fwleaveid', 'name' => 'fwleavename'));
        ?>

                 <?php

    $checllvl = $this->Common->findcheckLevel1($appId);
    if (!empty($checllvl)) {
        $fwemplist = $this->Common->findLevel1($checllvl,'Apply'); ?>

                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Forward :<span class="required">*</span> </label>
                    <div class="col-md-4 col-sm-8 col-xs-12">
                    
    
            <input type="hidden" value ="<?php echo $fnf; ?>" name="data[FnfWorkflow][fnf_id]"> 
                <?php echo $this->Form->input('FnfWorkflow.emp_code', array('type' => 'select', 'label' => false,  'options' => $fwemplist, 'class' => 'form-control col-md-7 col-xs-12','id'=>'fwlvempcode')); ?>

                      <ul id="parsley-id-8186" class="parsley-errors-list"></ul>
                    </div>
                  </div>
<?php } ?>

             
                  
                  
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                      
   <?php echo $this->Form->submit('SAVE', array('onClick' => 'return checkSubmit()','class'=>'btn btn-success')); ?>
                       
                      </div>
                  </div>
            <?php $this->Form->end(); ?>
              </div>
            </div>
          </div>
        </div>
      
      </div>
     <script type="text/javascript">
    function checkSubmit()
    {
        if($("#fwlvempcode").val() =='')
        {
            alert("Select the employee name.");
            return false;
        }else{
            return true;
        }
    }
</script> 
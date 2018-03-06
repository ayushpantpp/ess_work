<div role="main" class="right_col">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Temporary Component Add Form</h3>
          </div>
          <?php echo $flash = $this->Session->flash(); ?>
          
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
             
              <div class="x_content"> <br>

                
       <?php echo $this->Form->create('tempcomp', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
           'url' => array('controller' => 'TemporaryComponents', 'action' => 'add'), 'id' => 'tempcompid', 'name' => 'tempcomp'));
        ?>

                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Select Temp Component :<span class="required">*</span> </label>
                    <div class="col-md-4 col-sm-8 col-xs-12">
                     <?php echo $this->Form->input('tempComp.temp_code', array('type' => 'select', 'label' => false,  'options' => $temp, 'class' => 'form-control col-md-7 col-xs-12','id'=>'fwlvempcode')); ?>
                      <ul id="parsley-id-8186" class="parsley-errors-list"></ul>
                     </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Enter Amount :<span class="required">*</span> </label>
                    <div class="col-md-4 col-sm-8 col-xs-12">
                      <?php echo $this->form->input('tempComp.amount', array('label'=>false, 'type' => 'text', 'value' => '','class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'temp_amount')); ?>
                      <ul id="parsley-id-8186" class="parsley-errors-list"></ul>
                     </div>
                  </div>
                  
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <div class="col-md-2 col-sm-3 col-xs-3 col-md-offset-4">
                      <?php echo $this->Form->submit('APPLY', array('onClick' => 'return checkSubmit()','name'=>'data[tempComp][save]','class'=>'btn btn-success')); ?>
                    
                 </div>
                   <div class="col-md-2 col-sm-8 col-xs-12">    
                       <a class="btn btn-primary" href="<?php echo $this->webroot;?>Users/dashboard" title="Click to Cancel.">Cancel</a>   
                  </div>
                  </div>      
            <?php $this->Form->end(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
     <script type="text/javascript">
    function checkSubmit()
    {
        if($("#temp_amount").val() ==='')
        {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter Amount.!").show();
            $("html, body").animate({ scrollTop: 0 }, "slow");
            
            return false;
        }
        if($('#temp_amount').val() !== "") {
        var value = $('#temp_amount').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
        var intRegex = /^\d+$/;
        if(!intRegex.test(value)) {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Bill Amount Field must be numeric").show();
        return false;    
        
        }
        }
    }
</script>
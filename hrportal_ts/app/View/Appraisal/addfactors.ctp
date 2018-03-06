<div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Add Factor</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Factor Form</h2>
                
                <div class="clearfix"></div>
              </div>
             <?php
             echo $this->Form->create('Apprasialfactors', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'appraisal', 'action' => 'addfactors'), 'id' => 'appraisalfactor', 'name' => 'appraisalfactors'));
        ?>
   
              <div class="x_content"> <br>
                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-8" for="first-name">Factor Name<span class="required">*</span> </label>
                    <div class=" form-group col-md-4 col-sm-8 col-xs-8">
                  <?php echo $this->Form->input('factor_name', array('label' => false, 'type' => 'text', 'class' => 'form-control col-md-4 col-xs-12')); ?>
                  </div>
                  <div class="form-group col-md-8 col-sm-8 col-xs-8">
                    <label class="control-label col-md-6 col-sm-8 col-xs-12" for="last-name">Factor Type : <span class="required">*</span> </label>
                    <div class="form-group col-md-6 col-sm-8 col-xs-12">
                    <select name="data[factor_type]" class="form-control col-md-12 col-xs-12" id="leave">
                    <option value="1">First Appraisal</option>
                    <option value="2">After Two Appraisal</option>
                     </select>
                   </div>
                  </div>
                  <div class="form-group col-md-8 col-sm-12 col-xs-12">
                    <label for="middle-name" class="control-label col-md-6 col-sm-8 col-xs-12">Department<span class="required">*</span></label>
                    <div class=" form-group col-md-6 col-sm-12 col-xs-12">
                   <?php echo $this->Form->input('department_id', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $departments, 'class' => 'form-control col-md-4 col-xs-12')); ?>
                    </div>
                     
                  </div>
                
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-1 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                      <input type="submit" class="btn btn-success" value="Submit" >
                    </div>
                  </div>
                
              </div>
            </div>
          </div>
        </div>

</div>
</div> 
</div>    
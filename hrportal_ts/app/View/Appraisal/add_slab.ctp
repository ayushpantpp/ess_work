

    
<div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Add Slabs</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Slab Form</h2>
                
                <div class="clearfix"></div>
              </div>
             <?php
             echo $this->Form->create('AppraisalSlabs', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'appraisal', 'action' => 'addSlab'), 'id' => 'appraisalslab', 'name' => 'appraisalslab'));
        ?>
   
              <div class="x_content"> <br>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-8" for="last-name">Company code : <span class="required">*</span> </label>
                    <div class="form-group col-md-4 col-sm-8 col-xs-8">
                   <?php echo $this->Form->input('Company', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $company, 'class' => 'form-control s-form-item s-form-all')); ?> </div>
                  </div>
                  <div id = 'department'></div>
                      
                  <div id ='designation'></div>
                  
                  <div class="form-group col-md-8 col-sm-12 col-xs-12">
                    <label for="middle-name" class="control-label col-md-6 col-sm-8 col-xs-12">Rating<span class="required">*</span></label>
                    <div class=" form-group col-md-6 col-sm-12 col-xs-12">
                    <select name="rating" class="form-control col-md-12 col-xs-12" id="leave">
                    <option value="1">Below Average</option>
                    <option value="2">Average</option>
                    <option value="3">Good</option>
                    <option value="4">Very Good</option>
                    <option value="5">Excellent</option>
                     </select>
                    </div>
                     
                  </div>
                   <div class="form-group col-md-8 col-sm-12 col-xs-12">
                    <label for="middle-name" class="control-label col-md-6 col-sm-8 col-xs-12">Amount Increment<span class="required">*</span></label>
                    <div class=" form-group col-md-6 col-sm-12 col-xs-12">
                    <input  id="amt_inc" name ="amt_inc" required="" class="form-control col-md-7 col-xs-12" type="text">
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

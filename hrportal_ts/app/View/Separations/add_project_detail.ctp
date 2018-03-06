    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Separation Form</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Separation Form</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
                
                <?php
                echo $this->form->create('Separation', array('url' => '','action'=>'add','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));
                ?>

                <?php $auth=$this->Session->read('Auth');?>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Employee Name<span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
				<?php 
				echo $this->form->input('user_name', array('label'=>false, 'type' => 'text', 'value' => $auth['MyProfile']['emp_name'],'class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name'));

				echo $this->form->input('emp_code', array('label'=>false, 'type' => 'hidden', 'value' => $auth['MyProfile']['emp_code'],'class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name')); ?>
                    </div>
                  </div>
                
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Reason<span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    
                      <?php echo $this->form->textarea('reason', array('label'=>false,'class'=>"form-control", 'maxlength' => "145",'style'=>"width: 274px; height: 63px;")); ?>
                    </div>
                  </div>
                
                
                


                
                 
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-1 col-sm-6 col-xs-12">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                      <input type="submit" class="btn btn-success" value="Submit To Manager" onclick="return CheckSeparationCount(); ">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
 
      </div>



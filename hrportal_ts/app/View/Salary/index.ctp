    <!-- page content -->
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash();?>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-overflow-container uk-margin-bottom">
                <?php
                echo $this->form->create('Salary', array('url' => '','name'=>'Form1','action'=>'get_salary','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked'))));
                ?>
                <?php $auth=$this->Session->read('Auth');?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="mom_related">Select Month:<span class="req">*</span></label>
                            <?php echo $this->form->input('month', 
                            array('label'=>false, 'type' => 'select', 
                            'options' => $months,'default' =>$maxmonth,
                            'class' => "data-md-selectize",'required'=>true,'id'=>'first_name')); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="mom_related">Select Year:<span class="req">*</span></label>
                             <?php echo $this->form->input('year', 
                            array('label'=>false, 'type' => 'select', 
                            'options' => $years,'class' => "data-md-selectize",
                             'required'=>true)); ?>
                     </div>
                    </div>
                  </div>
                 <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <input type="submit" class="md-btn md-btn-primary" value="Submit" name='post_Salary'>
                        </div>
                    </div>
                 </div>
                </form>
              </div>
            </div>
          </div>
        </div>
     </div>

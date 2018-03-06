<?php 
$emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
$comp_code = $this->Common->findEmpCompany($emp_code);
$fwemplist = $this->Common->findLevel($emp_code,$comp_code);
?>
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  

             <div class="md-card">
             
        <div class="md-card-toolbar">
          <h3 class="md-card-toolbar-heading-text">
                              <b> Candidate Interview Rating Form</b>
                            </h3>
          </div>
            <div class="md-card-content large-padding">
                <?php 
                echo $this->Form->create('doc', array('url' =>array('controller' => 'Recruitment', 'action' =>'add'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked')); 
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Name<span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Position Name', array('label'=>false, 'value'=>'Auto Filled','type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'p_name'));
                               
                               ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department">Candidate Attitude<span class="req">*</span></label>
                            <?php 
                                echo $this->form->input('dept_name', array('label'=>false, 'type' => 'text', 'readonly' => true,'class' => "md-input",'required'=>true,'id'=>'first_name')); ?>
                        </div>
                    </div>
                </div>
            <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Overall Appearance and Personality<span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text', 'readonly' => true,'class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Communication Skills<span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('location', array('label'=>false, 'type' => 'select','readonly' => true, 'options' => $locName,'class' => "md-input",'required'=>true,'id'=>'l_name')); 
                            ?>                
                        </div>
                        </div>
                    </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Job Knowledge <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Current Organization <span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-1">
                                <div class="uk-accordion" data-uk-accordion>
                                    <h3 class="uk-accordion-title">Skill Rating</h3>
                                    <div class="uk-accordion-content">
                                            <div class="parsley-row">
                                            <div class="uk-overflow-container">
                                                <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup">
                                                    <tr>
                                                        <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Panel</th>
                                                        <th  class="uk-text-center md-bg-blue-100 uk-text-small">Skills </th>
                                                        <th  class="uk-text-center md-bg-blue-100 uk-text-small">Rating(Out of 5)</th>
                                                        <th  class="uk-text-center md-bg-blue-100 uk-text-small"></th>
                                                    </tr>

                                                    <tr>
                                                        <td class="uk-text-center uk-width-small-1-10">1<?php echo $this->Form->input("rowCount", array("type" => "hidden","id"=>"rowCount","value"=>"1")); ?></td>                            
                                                        <td><?php echo $this->Form->input('Voucher.local_claim_date.', array('class' => 'md-input LocalClaimDate')); ?></td>
                                                        <td><?php echo $this->Form->input('Voucher.local_claim_mode.', array('class' => 'md-input','type'=>'text')); ?></td>
                                                        <td><?php echo $this->Form->input('Voucher.local_claim_amount.', array('class' => 'md-input amt_local')); ?></td>
                                                 </tr>
                                                 <tr>
                                                        <td class="uk-text-center uk-width-small-1-10">2<?php echo $this->Form->input("rowCount", array("type" => "hidden","id"=>"rowCount","value"=>"1")); ?></td>                            
                                                        <td><?php echo $this->Form->input('Voucher.local_claim_date.', array('class' => 'md-input LocalClaimDate')); ?></td>
                                                        <td><?php echo $this->Form->input('Voucher.local_claim_mode.', array('class' => 'md-input','type'=>'text')); ?></td>
                                                        <td><?php echo $this->Form->input('Voucher.local_claim_amount.', array('class' => 'md-input amt_local')); ?></td>
                                                 </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                   
                    </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Candidate Status<span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'select','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Remarks<span class="req fixed">*</span></label>
                            <?php 
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text','class' => "md-input",'required'=>true,'id'=>'d_name')); 
                            ?>                
                        </div>
                    </div>
                </div>
                
                     
                    
                <div class="uk-grid">
                    <div class="uk-width-1-2 uk-margin-top">                            
                        <button type="submit" name="type" value="post" class="md-btn md-btn-success" >Submit</button>                    
                    </div>
                    <div class="uk-width-1-2 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/Recruitment/add') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </div>
</div>
</div>
</div>
</div>
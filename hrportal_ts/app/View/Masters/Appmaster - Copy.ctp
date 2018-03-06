
<div id="page_content" role="main">
    <div id="page_content_inner">        
        
        <h3 class="heading_b uk-margin-bottom"><?=$heading?></h3>
        
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('master', array('url' =>array('controller' => 'masters', 'action' => 'Appmaster'),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                    <div class="uk-grid" data-uk-grid-margin>                        
                        
                        <div class="uk-width-medium-1-21">
                            <div class="parsley-row">        

                            <?php $company_list = $this->Common->findCompanyName(); 
                            echo $this->form->input('org_id', array('label' => "Company List:", 'type' => "select",'empty' => ' -- Select Company--', 'options' => $company_list, 'class' => "md-input",'id' => 'companyName', 'required' => true,'data-md-selectize','onChange' =>'return getEmployee(this.value)')); ?>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-21">
                            <div class="parsley-row" >                                
                                <br>
                                   <?php 

                     $application = $this->Common->getApplicationList(); 
                
                                   echo $this->form->input('app_name', array('label' => "Application Name", 'type' => "select",'empty' => ' -- Select Application-', 'options' =>  $application, 'class' => "md-input",'id' => 'app_list', 'required' => true,'data-md-selectize')); ?>
                            </div>
                        </div> 
              <div class="uk-width-medium-1-21">
                            <div class="parsley-row" >                                
                                <br>
                                   <?php echo $this->form->input('max_days', array('label' => "Apply Max days", 'type' => "text", 'class' => "md-input",'id' => 'appmax', 'required' => true,'data-md-selectize')); ?>
                            </div>
                        </div> 
              
                    </div>                     
                    
                    <button type="submit" name="submit" class="md-btn md-btn-success"  style="margin-top: 30px;" href="#">Submit</button>                    
                    <?php echo $this->Form->end();?>
            </div>
        </div>
       
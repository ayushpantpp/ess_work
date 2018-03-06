    <div class="md-card-content large-padding" id="login_form">
    <div class="login_heading">
        <div class=""><img src="<?php echo $this->Html->url('/images', true);?>/<?php echo $logo; ?>"></img></div>
    </div>             
    <?php $flash = $this->Session->flash(); if($flash){  ?>
    <div data-uk-alert="" class="uk-alert uk-alert-danger">
        <a class="uk-alert-close uk-close" href="#"></a>
        <?php echo $flash;?>
    </div>
    <?php }?>
    <div class="clearfix"></div>
    <?php echo $this->Form->create('User', array('url' =>array('controller' => 'users', 'action' =>'reset/'.$token),'id'=>'loginemployee'));?>
        <div class="uk-form-row">            
            <?php echo $this->Form->input('password', array('type' => 'password','class' => 'md-input', 'style'=> 'text-transform:uppercase','autocomplete' => 'off','maxlength' => '25' ,'label' => 'New Password', 'required' => 'required')); ?>            
        </div>
        <div class="uk-form-row">            
            <?php echo $this->Form->input('password_confirm', array('type' => 'password','class' => 'md-input', 'autocomplete' => 'off','maxlength' => '25' ,'label' => 'Confirm Password', 'required' => 'required')); ?>
        </div>
        <div class="uk-margin-medium-top">            
            <input name="Login" type="submit" value="Change" class="md-btn md-btn-primary md-btn-block md-btn-large">
        </div>
    <?php $this->form->end(); ?>
</div>




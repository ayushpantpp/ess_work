
<div class="md-card-content large-padding" id="login_password_reset">
    <?php echo $flash = $this->Session->flash(); ?> 
    <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
    <h2 class="heading_a uk-margin-large-bottom">Forgot password</h2>   
    <form action="forgetpwd" method="post">
    <div class="uk-form-row">        
        <?php echo $this->Form->input('email', array('type' => 'text','class' => 'md-input', 'autocomplete' => 'off','maxlength' => '45' ,'label' => 'Your email address', 'required' => 'required')); ?>        
    </div>
    <div class="uk-margin-medium-top">
        <input name="Login" type="submit" value="Send Password" class="md-btn md-btn-primary md-btn-block">
        <div class="clearfix"></div>            
    </div>
    <?php $this->form->end(); ?>
    <div class="uk-margin-top uk-text-center">            
        <?php echo $this->Html->link("Login",array("controller"=>"users","action"=>"login")); ?>
    </div>
    </form>   
</div>


    <div class="md-card-content large-padding" id="login_form">
    <div class="login_heading">
        <div class=""><img src="<?php echo $this->Html->url('/images', true);?>/<?php echo $logo; ?>"></img></div>
    </div>             
    <?php echo $flash = $this->Session->flash(); if($flash){  ?>
    <div data-uk-alert="" class="uk-alert uk-alert-danger">
        <a class="uk-alert-close uk-close"></a>
        <?php echo $flash;?>
    </div>
    <?php }?>
    <div class="clearfix"></div>
    <?php echo $this->Form->create('UserDetail', array('url' =>array('controller' => 'users', 'action' =>'login'),'id'=>'loginemployee'));?>
        <?php            
            if($this->Common->get_admin_option('username_login')) {
        ?>
        <div class="uk-form-row">            
            <?php echo $this->Form->input('user_name', array('type' => 'text','class' => 'md-input', 'style'=> 'text-transform:uppercase','autocomplete' => 'off','maxlength' => '25' ,'label' => 'User Name', 'required' => 'required')); ?>            
        </div>
        <?php }else{ ?>
        <div class="uk-form-row">            
            <?php echo $this->Form->input('emp_id', array('type' => 'text','class' => 'md-input', 'autocomplete' => 'off','maxlength' => '25' ,'label' => 'User Code', 'required' => 'required')); ?>            
        </div>
        <?php } ?>
        <div class="uk-form-row">            
            <?php echo $this->Form->input('user_password', array('type' => 'password','class' => 'md-input', 'autocomplete' => 'off','maxlength' => '25' ,'label' => 'Password', 'required' => 'required')); ?>
        </div>
         <div class="uk-form-row">            
            <?php echo $this->Form->input('comp_code', array('type' => 'select','options'=>$company_list,'class' => 'md-input','label' => 'Company', 'required' => 'required')); ?>
        </div>
        <div class="uk-margin-medium-top">            
            <input name="Login" type="submit" value="Login" class="md-btn md-btn-primary md-btn-block md-btn-large">
        </div>
        <div class="uk-margin-top">            
            <?php echo $this->Html->link("Need help?", array("controller"=>"users","action"=>"forgetpwd"), array("class" => "uk-float-right")); ?>
            <?php echo $this->Html->link("Admin User? || ", array("controller"=>"admins","action"=>"login"), array("class" => "uk-float-right")); ?>
            
            <span class="icheck-inline">
            </span>
        </div>
    <?php $this->form->end(); ?>
</div>


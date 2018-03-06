


<div class="md-card-content large-padding" id="login_form">
    <div class="login_heading">
        <div class=""><img src="<?php echo $this->Html->url('/images', true);?>/<?php echo $logo; ?>" ></div>
    </div>             
    
    
    <?php $flash = $this->Session->flash(); if($flash){  ?>
    <div data-uk-alert="" class="uk-alert uk-alert-danger">
        <a class="uk-alert-close uk-close" href="#"></a>
        <?php echo $flash;?>
    </div>
    <?php }?>
    
    <div class="clearfix"></div>
    
    <?php echo $this->Form->create('UserDetail', array('url' =>array('controller' => 'admins', 'action' =>'login'),'id'=>'loginemployee'));?>
        <?php            
            if($this->Common->get_admin_option('username_login')) {
        ?>
        <div class="uk-form-row">            
            <?php echo $this->Form->input('UserDetail.user_name', array('type' => 'text','class' => 'md-input','autocomplete' => 'off','maxlength' => '25' ,'label' => 'User Name', 'required' => 'required')); ?>            
        </div>
        <?php }else{ ?>
        <div class="uk-form-row">            
            <?php echo $this->Form->input('UserDetail.user_name', array('type' => 'text','class' => 'md-input', 'autocomplete' => 'off','maxlength' => '25' ,'label' => 'User Code', 'required' => 'required')); ?>            
        </div>
        <?php } ?>
        <div class="uk-form-row">            
            <?php echo $this->Form->input('UserDetail.user_password', array('type' => 'password','class' => 'md-input', 'autocomplete' => 'off','maxlength' => '25' ,'label' => 'Password', 'required' => 'required')); ?>
            <?php echo $this->form->input('UserDetail.admin_login', array('label' => false, 'type' => 'hidden', 'class' => 'fiel','value'=>'admin_login')); ?>
        </div>
         <div class="uk-margin-top">            
            <?php //echo $this->Html->link("Need help?", array("controller"=>"users","action"=>"forgetpwd"), array("class" => "uk-float-right")); ?>
            <?php echo $this->Html->link("Employee Login? ", array("controller"=>"users","action"=>"login"), array("class" => "uk-float-right")); ?>
            
        </div>
    
        <?php /* ?><div class="uk-form-row">
            <?php            
                if($this->Common->get_admin_option('username_login')) {
            ?>
                <label for="login_username">User Name</label>
                <input class="md-input" type="text" id="login_username" name="login_username" />
                
                <?php //echo $this->Form->input('user_name',array('class' =>'md-input', 'type'=>'text','required'=>'required' ));?>
                
            <?php }else{ ?>
                <span for="login_username">User Code</span>
                <input class="md-input" type="text" id="login_username" name="login_username" />
                <input name="data[UserDetail][emp_id]"  class="md-input" required="required" maxlength="4" type="text">
                
                <?php //echo $this->Form->input('emp_id',array('type'=>'text' ,'class'=>'md-input','required'=>'required' ));?>
                
            <?php } ?>
        </div> 
        <div class="uk-form-row">
            <label for="login_password">Password</label>
            <?php echo $this->Form->input('user_password',array('type'=>'password','class'=>'md-input' ,'required'=>'required' ));?>
            
        </div><?php */ ?>
        <div class="uk-margin-medium-top">            
            <input name="Login" type="submit" value="Login" class="md-btn md-btn-primary md-btn-block md-btn-large">
        </div>
        <div class="uk-margin-top">            
            
            
            
        </div>
    <?php $this->form->end(); ?>
</div>

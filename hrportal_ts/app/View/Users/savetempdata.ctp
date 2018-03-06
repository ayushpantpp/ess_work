<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php 
 echo $this->Form->create('UserDetail', array('url' =>array('controller' => 'users', 'action' =>'login'),'id'=>'loginemployee'));
 ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your username and password'); ?>
        </legend>
        <label>User Name:</label>
        <?php echo $this->Form->input('user_name',array('label'=>false, 'type'=>'text' ,'class'=>'fiel' ,'required'=>'required' ));?>
        <label>Password:</label>
       <?php echo $this->Form->input('user_password',array('label'=>false, 'type'=>'password' ,'class'=>'fiel' ,'required'=>'required' ));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>
<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$this->Html->link("Forget Password ?",array("controller"=>"users","action"=>"forgetpwd")); ?>
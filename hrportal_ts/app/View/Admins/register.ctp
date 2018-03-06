<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Register Here!!'); ?></legend>
	<?php
		echo $this->Form->input('username');
                echo $this->Form->input('email');
		echo $this->Form->input('password');
                echo $this->Form->input('password_confirm', array(
                    'label' => 'Confirm Password *', 
                    'maxLength' => 255, 
                    'title' => 'Confirm password', 
                    'type'=>'password'));
                
                echo $this->Form->submit('Register', array('class' => 'form-submit',  'title' => 'Click here to register'));
	?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
<?php 
    if($this->Session->check('Auth.User')){
        echo $this->Html->link( "Return to Dashboard",   array('controller'=>'pages','action'=>'index') ); 
        echo "<br>";
        echo $this->Html->link( "Logout",   array('action'=>'logout') ); 
    }else{?>
<h3><?php echo $this->Html->link( "Return to Login Screen",   array('action'=>'login') ); 
    }
?></h3>
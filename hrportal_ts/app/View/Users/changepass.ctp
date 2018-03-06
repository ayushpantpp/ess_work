<div id="page_content" class="container">
    <div id="page_content_inner">
        
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">          
<div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                
                               
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                                <b>Change Password</b>
                            </h3>
                        </div>
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('change-profile', array('url' =>array('controller' => 'users', 'action' =>'changepass'),'id'=>'form_validation','class' => 'uk-form-stacked' , 'Onsubmit'=>'return passwordCompaire();')); ?>
                <h3 class="heading_a">Please fill out the form to change your password.</h3>                
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="fullname">Current Password <span class="req">*</span></label>
                                <input type="password" class="md-input" id="old_pass" name="old_pass" maxlength="25" required>                            
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="email">New Password <span class="req">*</span></label>
                                <input type="password" class="md-input" id="newpass" name="newpass" maxlength="25" required>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="val_birth">Confirm Password<span class="req">*</span></label>
                                <input type="password" class="md-input" id="connewpass" name="connewpass" maxlength="25" required>
                            </div>
                        </div>
                    </div>                    
                    <div class="uk-grid">
                        <div class="uk-width-1-3 uk-margin-top">                            
                            <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Submit</button>                    
                            <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/users/logout') ?>">Cancel</a>                       
                        </div>
                    </div>
                <?php echo $this->Form->end();?>
            </div>
        </div>


        
    </div>
</div>
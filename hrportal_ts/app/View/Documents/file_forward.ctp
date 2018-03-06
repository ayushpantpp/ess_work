<span class="uk-text-upper uk-text-small"><h3>Forward to other user !</h3></span>

<?php echo $this->Form->create('docs', array('url' => array('controller' => 'Documents', 'action' => 'file_forward'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
<div class="md-card">
    <div class="md-card-content large-padding">
        <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            
            <div class="uk-width-medium-1-1" >
                <div class="parsley-row">
                    <label for="cc_num">Select User*:</label>
                    
                        <?php 
                        $allusers = $this->Common->getAllEmpListWithID();
                        //echo "<pre>";print_r($allusers);
                        $all_users = array();
                        $all_users[''] =  "--Select--";
                        foreach($allusers as $user){
                           $recodUser = $this->Common->check_access_right($user['MyProfile']['emp_code'], $user['MyProfile']['comp_code'], 'doc_module', 'approval');
                            if($currentuser != $user['MyProfile']['id'] && $recodUser == 0 ){
                            $all_users[$user['MyProfile']['id']] =  $user['MyProfile']['emp_full_name'];
                            }
                        }
                        echo $this->form->input('users', array('type'=>'select','required'=>true,'options'=>$all_users,'label'=>false,'class'=>"md-input")); 
                        echo $this->Form->input('reqID', array('type' => 'hidden','value'=>$reqID, 'label' => false));
                        echo $this->Form->input('docID', array('type' => 'hidden','value'=>$docID, 'label' => false));
                        ?>
                    
                </div>
            </div>                   
        </div>
        <div class="uk-grid">
            <div class="uk-width-1-1">                        
                <input type='submit' class="md-btn md-btn-success"    value='Forward' >
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
 
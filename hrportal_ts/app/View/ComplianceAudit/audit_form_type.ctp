    <?php 
    foreach($AuditFormType as $form);
    $fields = explode(",",$form['CAAllLabelAM']['label']);
    ?><br>
    <hr>
    <h3 class="heading_a" style="text-align: center"><?php echo $form['CAAllLabelAM']['description'];?></h3>
    <hr>
    
    
    
        <?php 
        if(count($fields)%2==0){
            $cols = 2;
        }else{
            $cols = 3;
        }
        ?>
        <div id="clonefield">
            <div class="uk-grid" data-uk-grid-margin  >
            <?php 
    echo $this->form->input('model_name', array('label' => false, 'type' => "hidden", 'required'=>true,'value'=>$form['CAAllLabelAM']['model_name'], 'class' => "md-input"));
    echo $this->form->input('label_name', array('label' => false, 'type' => "hidden", 'required'=>true,'value'=>$form['CAAllLabelAM']['label'], 'class' => "md-input"));
    for($i = 0; $i<count($fields); $i++) { 
        
    ?>
        <div class="uk-width-medium-1-<?=$cols;?>" >
            <div class="parsley-row">
                <label for="department"><?php echo $fields[$i];?> <span class="req">*</span></label>
                <?php
                //echo $this->form->input($fields[$i], array('label' => false, 'type' => "text", 'required'=>true, 'class' => "md-input",'id'=>'ani'.$fields[$i].''));
                $fieldName = str_replace(" ", "_", strtolower($fields[$i]));
                ?>
                <div class="input text"><input name="data[<?php echo $fieldName; ?>][]" required="required" class="md-input" id="anieree" type="text"></div>
            </div>
        </div> 
        
     <?php 
        } ?>
            </div> 
             </div>
    <div id="newclone" >
        <input type="hidden" name="clone_count" id="clone_count" value="1">
    </div>
       
       
<div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-4 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-4 uk-margin-top"> 
                        <?php if($form_for == '1'){?>
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('audit_entry') ?>">Cancel</a>                       
                        <?php }elseif($form_for == '2'){ ?>
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('monitor_entry') ?>">Cancel</a>
                        <?php }?>
                    </div>
                    <div class="uk-width-1-4 uk-margin-top">                            
                        <div class="md-btn md-btn-primary" id="aaa" onclick="addmorefield();">Add More</div>                       
                    </div>
                    <div class="uk-width-1-4 uk-margin-top">                            
                        <div class="md-btn md-btn-danger" id="remove" style="display: none" onclick="removefield();">Remove</div>                       
                    </div>
                </div>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <h1>Enter Job Code</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); 
              foreach($Departments as $key=>$val){
                  $options .= '<option value="'.$key.'">'.$val.'</option>';
              }
        ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'masters', 'action' =>'jobcode'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                   ?>
                <h3 class="heading_a">Job Code</h3>
                
                     
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="court_location" class="md-input label-fixed">Department : <span class="req">*</span></label>
                                <select name="department[]" required="required" class="md-input data-md-selectize ">
                                    <option value=" ">-- SELECT --</option>
                                    <?php
                                    echo $options;
                                    ?>
                                </select>
                            </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="jobcode" class="md-input label-fixed">Job Code : <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('jobcode.', array('label'=>false,'type' => "text",'required'=>true,'class' => "md-input")); 
                                ?>
                            </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="sal_struc" class="md-input label-fixed">Salary Structure: <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('sal_struc.', array('label'=>false,'type' => "text",'required'=>true, 'class' => "md-input")); 
                                ?>
                            </div>
                    </div>
            </div>
                <div id='TextBoxesGroup' ></div>
            <div class="uk-grid" data-uk-grid-margin ></div>
            <div class="uk-grid" data-uk-grid-margin ></div>
            <div class="uk-width-1-1">                        
                <input type='button' class="md-btn md-btn-primary"  value='Add More' id='addButton'>
                <input type='button' class="md-btn md-btn-danger" value='Remove' id='removeButton'>         
            </div>
                
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('jobcode'); ?>">Reset</a>                       
                    </div>
                </div>
        
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>
<script src="<?php echo $this->webroot;?>js/jquery.min.js"></script>
<script src="<?php echo $this->webroot;?>js/jquery-ui.min.js"></script>
<script type="text/javascript">
 
$(document).ready(function(){
 
    var counter = 2;
 
    $("#addButton").click(function () {
 
    if(counter>10){
            alert("Only 10 files can upload at a time");
            return false;
    }
 
    var newTextBoxDiv = $(document.createElement('div'))
         .attr({id:'TextBoxDiv' + counter,class:'uk-grid-divider'});
 
    newTextBoxDiv.after().html('<hr class="uk-grid-divider"><div class="uk-grid">'+
                        '<div class="uk-width-medium-1-2"><div class="parsley-row">'+
                            '<label for="department" class="md-input label-fixed">Department : <span class="req"><sup>*</sup>&nbsp;</span></label>'+ 
                        '<select name="department[]" required="required" class="md-input data-md-selectize ">'+
                                '<option value=" ">-- SELECT --</option>'+
                                '<?php echo $options;?>'+
                                '</select></div></div>'+
                                '<div class="uk-width-medium-1-2"><div class="parsley-row">'+
                            '<label for="jobcode" class="md-input label-fixed">Job Code : <span class="req"><sup>*</sup>&nbsp;</span></label>'+ 
                                '<?php echo $this->form->input('jobcode.', array('label'=>false,'type' => "text",'required'=>true,'class' => "md-input")); ?>'+
                                '</div></div>'+
                                '<div class="uk-width-medium-1-2"><div class="parsley-row">'+
                            '<label for="jobcode" class="md-input label-fixed">Salary Structure : <span class="req"><sup>*</sup>&nbsp;</span></label>'+ 
                                '<?php echo $this->form->input('sal_struc.', array('label'=>false,'type' => "text",'required'=>true,'class' => "md-input")); ?>'+
                                '</div></div>');
 
    newTextBoxDiv.appendTo("#TextBoxesGroup");
 
 
    counter++;
     });
 
     $("#removeButton").click(function () {
    if(counter==1){
          alert("No more textbox to remove");
          return false;
       }
    counter--;
        $("#TextBoxDiv" + counter).remove();
     });    
  });
</script>

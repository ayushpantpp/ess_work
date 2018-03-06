<!-- page content -->
<script type="text/javascript">
$(document).ready(function(){
    $("#manualtext").hide();
    $('input[type="checkbox"]').click(function(){
        if ($(this).is(':checked')) {
            $("#manualtext").slideDown();
        } else {
        $("#manualtext").slideUp();
        }
    });
});

function getfolder(val,folderid){
   //alert(folderid);
   if(val == ''){
       val = '0';
   }
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/folder_container/'+val+'/'+folderid,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                folderid++;
                $("#folder_"+folderid).html(data);
            }
        });
    
        
}
</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="heading_actions">
                
            </div>
            <h1>Request For Files</h1>
            <span class="uk-text-upper uk-text-small">
                <?php /* foreach($bredcrum as $breC ){?>
                <a href="<?php echo $this->Html->url('currentfolder/'.$breC['Category']['id']); ?>"> <?php echo $breC ['Category']['name'];?></a>/  
                <?php } */?>
            </span>
        </div>
                                
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">            
            <div class="md-card-content large-padding">
                
                <?php echo $this->Form->create('requestraise', array('url' =>array('controller' => 'Documents', 'action' =>'request_raise'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); ?>
                <h3 class="heading_a">Create Request For Files</h3>
                
                <?php for($i=0 ; $i<=$listcount ; $i++){
                    if($i == '0'){
                        $leble = 'PSC';
                        $req = '*';
                    }elseif($i == '1'){
                        $leble = 'Ministry';
                    }elseif($i == '2'){
                        $leble = 'Department';
                    }elseif($i == '3'){
                        $leble = 'File Number';
                    }elseif($i == '4'){
                        $leble = 'Sub File Number';
                    }elseif($i == '5'){
                        $leble = 'Mails';
                        $req = '';
                    }
                    ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="folder"><?php echo $leble; ?><sup><?=$req ;?></sup></label>
                             </div>
                       </div>
                        <div class="uk-width-medium-1-3" >
                            <div class="parsley-row" id="folder_<?=$i; ?>">
                                <?php 
                                if($i=='0'){
                                    echo $this->form->input('folderName'.$i, array('label'=>false,'type' => "select",'id'=>'lable_'.$i,'required'=>true,'empty' => ' -- Please Select --', 'options' => $rootfile,'onchange'=>'getfolder(this.value,"'.$i.'")', 'class' => "md-input",'data-md-selectize')); 
                                }
                                if($i != '0' && $i!='5'){
                                    echo $this->form->input('folderName'.$i, array('label'=>false,'type' => "select",'id'=>'lable_'.$i,'required'=>true,'empty' => ' -- Please Select --', 'class' => "md-input",'data-md-selectize')); 
                                }
                                if($i=='5'){
                                    echo $this->form->input('filereff', array('label'=>false,'type' => "select",'id'=>'lable_'.$i,'empty' => ' -- Please Select --', 'class' => "md-input",'data-md-selectize')); 
                                }
                                ?>
                             </div>
                            
                       </div>
                        <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="folder"></label>
                                
                             </div>
                       </div>
                </div>
                <?php } ?>
                
                <div class="uk-grid" data-uk-grid-margin>
                        
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="folder">   </label>
                                <?php
                                //echo $this->form->input('filename', array('label'=>false,'type' => "select",'empty' => ' -- Select Folder --', 'options' => $fileName, 'class' => "md-input",'data-md-selectize')); 
                                ?>
                        </div>
                       </div>
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="folder"></label>
                                <?php 
                                //echo $this->form->input('filereff', array('label'=>false,'type' => "select",'required'=>true,'empty' => ' -- Select Folder --', 'options' => $fileRef, 'class' => "md-input",'data-md-selectize')); 
                                ?>
                                
                             </div>
                       </div>
                    
                    <div class="uk-width-medium-1-1" >
                            <div class="parsley-row">
                                <?php  
                                echo $this->form->input('manualchk', array('label'=>false,'value'=>'manualchks','type' => "checkbox")); 
                                ?><label for="folder">Any Manual Mails </label>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-1" >
                        <div class="parsley-row" id="manualtext">
                                <label for="manualchk">Enter Manual Mail Name </label>
                                <?php
                                echo $this->form->input('manualfiles', array('label'=>false,'type' => "text",'class'=>'md-input')); 
                                ?>
                                <span>eg.(File1,File2,...)</span>
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row">
                            <label for="remark">Remark </label>
                            <?php echo $this->form->textarea('reason', array('label'=>false,'class'=>"md-input",'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'onkeyblur'=> "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
                        </div>
                    </div>
                   
                    
                </div> 
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-2 uk-margin-top">                            
                        <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-2 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/Documents/request_raise') ?>">Reset</a>                       
                    </div>
                </div>
                
                <?php echo $this->Form->end();?>
            </div>
            
        </div>



    </div>
</div>

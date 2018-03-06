<script type="text/javascript">
    function getcasedet(case_id){
        
        if(case_id != '' && case_id != '0'){
            
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>legal_management/get_reference_case/'+case_id,
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                    $("#refcase").html(data);
                    
                }
            });
        }else if(case_id == '0'){
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>legal_management/get_receive_case',
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                    $("#refcase").html(data);
                    
                }
            });
        }
        
    }
</script> 
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            
            <h1>Case Receiving</h1>
            
        </div>
    
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'LegalManagement', 'action' =>'case_receive'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                echo $this->form->input('id', array('type' => "hidden",'value'=>$id)); 
                ?>
                <h3 class="heading_a">Petition/Case Receiving</h3>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="ref_case" class="md-input label-fixed" >Reference Case </label>
                                <?php echo $this->form->input('ref_case',array('type'=>'select','options'=>$ReferenceCase,'onchange'=>'getcasedet(this.value)','label'=>false,'class'=>'md-input  data-md-selectize'));?>
                                  
                             </div>
                       </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div id="refcase">
                    <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <div class="md-input-wrapper md-input-filled">
                                <label for="case_type">Case Type <span class="req">*</span></label>
                                <select name="case_type" required="required" class="md-input  label-fixed data-md-selectize">
                                    <option value="">-- Select --</option>
                                    <?php
                                    foreach($CaseType as $rt){
                                    $value = $rt['CaseType']['id'];
                                    $option = $rt['CaseType']['casetype'];
                                    if($rec['CaseReceive']['request_id']==$value){
                                        echo "<option value='".$value."' selected='selected'>".$option."</option>";
                                    }else{
                                        echo "<option value='".$value."'>".$option."</option>";
                                    }
                                 
                                }
                                    ?>
                                </select>
                                </div>
                             </div>
                       </div>
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="minstry" class="md-input label-fixed">Ministry/State Dept <span class="req">*</span></label>
                                <select name="ministry" required="required" class="md-input data-md-selectize ">
                                    <option value="">-- Select --</option>
                                    <?php
                                    foreach($Ministry as $rt){
                                 $value = $rt['Ministry']['id'];
                                 $option = $rt['Ministry']['ministry_name']." [".strtoupper($rt['Ministry']['ministry_code'])."]";
                                 if($rec['Ministry']['id']==$value){
                                        echo "<option value='".$value."' selected='selected'>".$option."</option>";
                                    }else{
                                        echo "<option value='".$value."'>".$option."</option>";
                                    }
                                }
                                    ?>
                                </select>
                                    <?php 
                                //echo $this->form->input('minstry', array('type' => "select",'label'=>false,'required'=>true,'empty' => ' -- Select --', 'options' => $Ministry, 'class' => "md-input",'data-md-selectize')); 
                                ?>
                        </div>
                       </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                    <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Respondents <span class="req">*</span></label>
                            <?php echo $this->form->textarea('resp', array('label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['respondents'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="peti" class="md-input label-fixed">Petitioners <span class="req">*</span></label>
                            <?php echo $this->form->textarea('peti', array('label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['petitioners'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="cc_num" class="md-input label-fixed">Court Case Number <span class="req">*</span></label>
                            <?php echo $this->form->input('cc_num', array('type'=>'text','label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['court_case_number'],'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="pfn" class="md-input label-fixed">PSC File Number <span class="req">*</span></label>
                            <?php echo $this->form->input('pfn', array('type'=>'text','label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['psc_file_number'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                    <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="subject" class="md-input label-fixed">Subject <span class="req">*</span></label>
                            <?php echo $this->form->textarea('subject', array('label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['subject'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="dos" class="md-input label-fixed">Date of Service <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('dos', array('type' => "text",'label'=>false,'required'=>true,'readonly'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY",maxDate:"'.date('d-m-Y').'"}', 'class' => "md-input")); 
                                ?>
                                <span class="md-input-bar"></span>
                        </div>
                    </div>
                    </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="act_off" class="md-input label-fixed">Action Officer <span class="req">*</span></label>
                                <select name="act_off" required="required" class="md-input data-md-selectize ">
                                    <option value="">-- Select --</option>
                                    <?php
                                    foreach($ActionOff as $rt){
                                 $value = $rt['MyProfile']['id'];
                                 $option = $rt['MyProfile']['emp_full_name'];
                                 if($rec['CaseReceive']['action_officer_id']==$value){
                                        echo "<option value='".$value."' selected='selected'>".$option."</option>";
                                    }else{
                                        echo "<option value='".$value."'>".$option."</option>";
                                    }
                                }
                                
                                    ?>
                                </select>
                                <?php 
                                //echo $this->form->input('act_off', array('type' => "select",'label'=>false,'required'=>true,'empty' => ' -- Select --', 'options' => $Folderlist, 'class' => "md-input",'data-md-selectize')); 
                                ?>
                        </div>
                       </div>
                    
                </div> 
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/LegalManagement') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>

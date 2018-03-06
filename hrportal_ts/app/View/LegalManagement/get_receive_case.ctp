<div class="uk-grid" data-uk-grid-margin></div>
                <?php 
                 
                 if(!empty($EditCaseReceive)){
                     foreach($EditCaseReceive as $rec);
                 }?>
                <div class="uk-grid" data-uk-grid-margin>
                        
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <div class="md-input-wrapper md-input-filled">
                                <label for="req_cat" class="md-input label-fixed">Case Type <span class="req">*</span></label>
                                <select name="case_type" required="required"   class="md-input  data-md-selectize">
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
                                <div class="md-input-wrapper md-input-filled">
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
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                    <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <div class="md-input-wrapper md-input-filled">
                            <label for="resp" class="md-input label-fixed">Respondents <span class="req">*</span></label>
                            <?php echo $this->form->textarea('resp', array('label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['respondents'],'class'=>"md-input")); ?>                
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <div class="md-input-wrapper md-input-filled">
                            <label for="peti" class="md-input label-fixed">Petitioners <span class="req">*</span></label>
                            <?php echo $this->form->textarea('peti', array('label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['petitioners'],'class'=>"md-input")); ?>                
                            </div>
                        </div>
                    </div>
                    </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <div class="md-input-wrapper md-input-filled">
                            <label for="cc_num" class="md-input label-fixed">Court Case Number <span class="req">*</span></label>
                            <?php echo $this->form->input('cc_num', array('type'=>'text','label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['court_case_number'],'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'class'=>"md-input")); ?>                
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <div class="md-input-wrapper md-input-filled">
                            <label for="pfn" class="md-input label-fixed">PSC File Number <span class="req">*</span></label>
                            <?php echo $this->form->input('pfn', array('type'=>'text','label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['psc_file_number'],'class'=>"md-input")); ?>                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                    <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <div class="md-input-wrapper md-input-filled">
                            <label for="subject" class="md-input label-fixed">Subject <span class="req">*</span></label>
                            <?php echo $this->form->textarea('subject', array('label'=>false,'required'=>true,'value'=>$rec['CaseReceive']['subject'],'class'=>"md-input")); ?>                
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <div class="md-input-wrapper md-input-filled">
                                <label for="dos" class="md-input label-fixed">Date of Service <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('dos', array('type' => "text",'label'=>false,'required'=>true,'readonly'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY",maxDate:"'.date('d-m-Y').'"}', 'class' => "md-input")); 
                                ?>
                                <span class="md-input-bar"></span>
                                </div>
                        </div>
                    </div>
                    </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <div class="md-input-wrapper md-input-filled">
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
                                </div>
                                <?php 
                                //echo $this->form->input('act_off', array('type' => "select",'label'=>false,'required'=>true,'empty' => ' -- Select --', 'options' => $Folderlist, 'class' => "md-input",'data-md-selectize')); 
                                ?>
                        </div>
                       </div>
                    
                </div> 
                
                
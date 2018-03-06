<script type="text/javascript">
    function fieldsDisable(val){ 
        if(val!='' && val!='0' && val=='1'){
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/fields_datatype/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#newfield").slideDown();
                $("#newfield").html(data);
                
            }
        });
        }else{
                $("#newfield").slideUp();
        }
    }
    
    function phydisbl(val){
        if(val=='0'){
            $("#disbl_det").removeAttr("disabled");
            $("#disbl_det").attr('required', true);
        }else{
            $("#disbl_det").attr('disabled', 'disabled');
            $("#disbl_det").removeAttr('required');
        }
    }
    
    function checkNumber()
    {
       
        var claimAmt =jQuery('#candi_num').val();
        
        if (isNaN(claimAmt)){
            alert('Please enter only number !! ');
            jQuery('#candi_num').val('');
            jQuery('#candi_num').focus();
            return false;
        }
    }
    
  
</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            
            <h1>Request Details</h1>
            
    </div>
    
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Boards', 'action' =>'recrut_final_save'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                ?>
                <h3 class="heading_a">Enter Request Details</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="req_cat">Serial Number</label>
                                <?php echo $this->form->input('seri_Num', array('type'=>'text','label'=>false, 'disabled'=>'disabled','value'=>$SeriNum,'required'=>true,'class'=>"md-input"));
                                echo $this->form->input('seriNum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$SeriNum,'class'=>"md-input"));
                                  ?>
                             </div>
                       </div>
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="ministry">Request Type <span class="req">*</span></label>
                                <?php 
                                array_unshift($RequestType,'--Select--');
                                echo $this->form->input('req_type_id', array('label'=>false,'type' => "select",'empty'=>'-- Select --','required'=>true,'options' => $RequestType,'class' => "md-input",'data-md-selectize')); 
                                ?>
                            </div>
                       </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="id_no">Number of Candidates <span class="req">*</span></label>
                                <?php echo $this->form->input('candidate_num', array('type'=>'text','label'=>false,'id'=>'candi_num','onkeyup'=>'checkNumber()','required'=>true,'class'=>"md-input"));
                                  ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="dob">Date of Received <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('dor', array('type' => "text",'label'=>false,'required'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY"}', 'class' => "md-input")); 
                                ?>
                                
                        </div>
                    </div>
                </div>
                
                <div class="uk-grid" data-uk-grid-margin  >
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="department">Subject<span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('subject', array('label'=>false,'type' => "text",'required'=>true,'class' => "md-input")); 
                                ?>
                            </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="department">Notes</label>
                                <?php 
                                echo $this->form->input('notes', array('label'=>false,'type' => "text",'class' => "md-input")); 
                                ?>
                            </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success"  href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/Boards/recrut_final') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>

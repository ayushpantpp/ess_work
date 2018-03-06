<?php if ($val == '0') { ?>
<div class="uk-grid" data-uk-grid-margin></div>
<div class="uk-grid" data-uk-grid-margin>
<div class="uk-width-medium-1-2">
                        <div class="parsley-row ">
                            <div class="md-input-wrapper md-input-filled">
                            <label for="remark" class="">Remark </label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"md-input label-fixed",'maxlength'=>'1000','onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'onkeyblur'=> "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
                        </div>
                      </div>
                        
                    </div>
<div class="uk-width-medium-1-2">
    <div class="parsley-row">
        <div class="md-input-wrapper md-input-filled">
        <label for="fname" >Create New File<span class="req">*</span></label>                                
        <?php
        echo $this->form->textarea('fname', array('label' => false,
            'type' => 'text',
            'class' => 'md-input',
            'maxlength'=>'100',
            'required' => true,
            'onkeyup' => "this.value=this.value.replace(/[^\w ]+$/g,'')",
            'onblur' => "this.value=this.value.replace(/[^\w ]+$/g,'')",
            'id' => 'fname'));
        ?>
        </div>
</div>
    </div>
</div>
<?php } elseif ($val == '1') { ?>
<div class="uk-grid" data-uk-grid-margin></div>
 <div class="uk-grid" data-uk-grid-margin>
<div class="uk-width-medium-1-2">
                        <div class="parsley-row md-input-wrapper md-input-filled">
                            <label for="subject">Date of Letter <span class="req">*</span></label>
                            <?php echo $this->form->input('dol', array('type'=>'text','id'=>'dol','label' => false,'data-uk-datepicker'=>"{format:'YYYY-MM-DD',maxDate:'".date('Y-m-d')."'}",'required' => true, 'readonly'=>true,'class' => "md-input label-fixed")); ?>                
                        </div>
    </div>

                    
<div class="uk-width-medium-1-2">
                        <div class="parsley-row md-input-wrapper md-input-filled">
                            <label for="subject">Date of Receiving <span class="req">*</span></label>
                            <?php echo $this->form->input('dor', array('type'=>'text','id'=>'dor','label' => false,'data-uk-datepicker'=>"{format:'YYYY-MM-DD',maxDate:'".date('Y-m-d')."'}",'required' => true, 'readonly'=>true,'class' => "md-input label-fixed")); ?>                
                        </div>
    </div>
    </div>
<div class="uk-grid" data-uk-grid-margin></div>
<div class="uk-grid" data-uk-grid-margin>
<div class="uk-width-medium-1-2">
                        <div class="parsley-row md-input-wrapper md-input-filled">
                            <label for="subject">Reference Letter <span class="req">*</span></label>
                            <?php echo $this->form->textarea('ref_let', array('type'=>'text','label' => false,'maxlength'=>'100','required' => true, 'class' => "md-input label-fixed")); ?>                
                        </div>
    </div>

                    
<div class="uk-width-medium-1-2">
                            <div class="parsley-row md-input-wrapper md-input-filled ">
                                <label for="type">Source of origin <span class="req">*</span></label>
                                <?php
                                echo $this->form->input('origin', array('label'=>false, 'type' => 'select', 'value' => '',
                    'options' => array('' => '--Select--', '0' => 'MDA','1' => 'individual'),
                    'class' => "md-input data-md-selectize label-fixed",'required'=>true,'id'=>'type','onChange'=>'ministrydata(this.value);')); ?>
                        </div>
                       </div>
</div>



<div class="uk-grid" data-uk-grid-margin></div>
<div class="uk-grid" data-uk-grid-margin>
<div class="uk-width-medium-1-2">
    <div class="parsley-row md-input-wrapper md-input-filled">
        <label for="falias">Subject:<span class="req">*</span></label>                                
        <?php
        echo $this->form->textarea('falias', array('label' => false,
            'type' => 'text',
            'class' => 'md-input label-fixed',
            'maxlength'=>'1000',
            'required' => true,
            'onkeyup' => "this.value=this.value.replace(/[^\w ]+$/g,'')",
            'onblur' => "this.value=this.value.replace(/[^\w ]+$/g,'')",
            'id' => 'falias'));
        ?>
    </div>
    </div>  
<div class="uk-width-medium-1-2">
    <div class="parsley-row ">
        <span class="icheck-inline">
            <input type="checkbox" name="public_doc" value="1" id="checkbox_demo_2" data-md-icheck />
            <label for="checkbox_demo_2" class="inline-label">Is it public document ?</label>
        </span>
    </div>

</div>
    
</div>
<div class="uk-grid" data-uk-grid-margin></div>
<div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row md-input-wrapper md-input-filled">
                            <label for="remark" class="">Remark </label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"md-input label-fixed",'maxlength'=>'1000','onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'onkeyblur'=> "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
                        </div>
                        
                    </div>
<div class="uk-width-medium-1-2" id="min" style="display:none;">
                            <div class="parsley-row md-input-wrapper md-input-filled ">
                                <label for="ministry">Ministry <span class="req">*</span></label>
                                <?php
                               $options =  $this->Common->getMinistryList();
                                echo $this->form->input('ministry', array('label'=>false, 'type' => 'select', 'value' => '',
                    'options' => $options,
                    'class' => "md-input data-md-selectize label-fixed",'id'=>'ministry')); ?>
                        </div>
                       </div>
                    
                </div>
<div class="uk-grid" data-uk-grid-margin></div>
<div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
                    <div class="uk-width-medium-1-2 " >
                        <div class="parsley-row md-input-filled">
                            <label for="cc_num"  >Select File To Upload: <span class="req"><sup>*</sup>&nbsp;</span> </label>
                        <div class="md-btn md-btn-primary">
                        <?php 
                        echo $this->form->input('upl_doc.', array('type'=>'file', 'id'=>'first_upload','required'=>true, 'class'=>'upl_doc','label'=>false)); 
                        ?>
                        </div>
                        </div>
                    </div>
    <div class="uk-width-1-2">                        
                    <input type='button' class="md-btn md-btn-primary"  value='Add More' id='addButton'>
                    <input type='button' class="md-btn md-btn-danger" value='Remove' id='removeButton'>         
                </div>
</div>
    <?php
}?>
<script type="text/javascript">

    $(document).ready(function () {

        var counter = 2;

        $("#addButton").click(function () {

            if (counter > 10) {
                alert("Only 10 files can upload at a time");
                return false;
            }

            var newTextBoxDiv = $(document.createElement('div'))
                    .attr({id: 'TextBoxDiv' + counter, class: "uk-width-medium-1-1 md-input-filled margin-bottom"});

            newTextBoxDiv.after().html('<br><label for="upl_doc">Select File To Upload: <span class="req"><sup>*</sup>&nbsp;</span></label>' +
                    '<div class="parsley-row  md-btn md-btn-primary">' +
                    '<?php echo $this->form->input('upl_doc.', array('type'=>'file','label'=>false,'class'=>'upl_doc','required'=>true)); ?>' +
                    '</div>');

            newTextBoxDiv.appendTo("#TextBoxesGroup");
            $('#first_upload').attr('required',true);

            counter++;
        });

        $("#removeButton").click(function () {
            
            if (counter == 3) {
                $('#first_upload').attr('required',false);
            }
            if (counter == 1) {
                alert("You can't delete default upload field !");
                return false;
            }
            counter--;
            $("#TextBoxDiv" + counter).remove();
        });
    });
</script>
<div class="parsley-row ">
                            <div class="md-input-wrapper md-input-filled">
<label for="folder" class="">Parent Files <span class="req">*</span></label>
                               <?php 
                                echo $this->form->input('folder', array('type' => "select",'label'=>false,'required'=>true,'empty' => ' -- Select File --', 'options' => $Folderlist, 'class' => "md-input data-md-selectize label-fixed")); 
                                ?>
                            </div>
</div>
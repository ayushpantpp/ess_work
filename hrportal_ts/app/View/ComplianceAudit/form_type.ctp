<?php
//if($Typeid == '2'){
//    $dsblFild = "'disabled'=>'disabled'";
//}else{
//    $dsblFild = "";
//}

if ($Typeid == '1') {
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Quantitative Data Type</h3>
    <hr>
    <div class="uk-grid" data-uk-grid-margin  >
    <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Performance Indicator <span class="req">*</span></label>
                <?php
                echo $this->form->input('per_indicator', array('label' => false, $dsblFild,'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $perf_indic,'onchange'=>'getmeaurtype(this.value)', 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3" id="measur">
            
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Comments</label>
                <?php
                echo $this->form->input('comment', array('label' => false,$dsblFild, 'type' => "text", 'class' => "md-input"));
                ?>
            </div>
        </div> 
    </div>
<?php }else if($Typeid == '2'){ ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Qualitative Data Type</h3>
    <hr>
    <div class="uk-grid" data-uk-grid-margin  >
    <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Description</label>
                <?php
                echo $this->form->input('description', array('label' => false, 'type' => "text", 'class' => "md-input"));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Performance Standards</label>
                <?php
                echo $this->form->input('perform_stantd', array('label' => false, 'type' => "text", 'class' => "md-input"));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Performance Indicator</label>
                <?php
                echo $this->form->input('perform_indicat', array('label' => false, 'type' => "text", 'class' => "md-input"));
                ?>
            </div>
        </div> 
    </div>
    <div class="uk-grid" data-uk-grid-margin  >
    <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Analysis of the findings</label>
                <?php
                echo $this->form->input('analysis_findings', array('label' => false, 'type' => "text", 'class' => "md-input"));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Progress achieved</label>
                <?php
                echo $this->form->input('progress_achieved', array('label' => false, 'type' => "text", 'class' => "md-input"));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Challenges faced</label>
                <?php
                echo $this->form->input('challeng_face', array('label' => false, 'type' => "text", 'class' => "md-input"));
                ?>
            </div>
        </div> 
    </div>
    <div class="uk-grid" data-uk-grid-margin  >
    <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Recommendations</label>
                <?php
                echo $this->form->input('recommend', array('label' => false, 'type' => "text", 'class' => "md-input"));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Conclusion</label>
                <?php
                echo $this->form->input('conclusion', array('label' => false, 'type' => "text", 'class' => "md-input"));
                ?>
            </div>
        </div> 
    </div>
 <?php  }  ?>
<div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('quant_qual_list') ?>">Cancel</a>                       
                    </div>
                </div>

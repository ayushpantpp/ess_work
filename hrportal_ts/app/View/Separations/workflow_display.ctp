<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Separation Work Flow</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">
                 
                <?php echo $this->Form->create('fwleave', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
         'url' => array('controller' => 'separations', 'action' => 'saveinfomation'), 'id' => 'fwleaveid', 'name' => 'fwleavename'));
        ?>

                 <?php  $fwemplist = $this->Common->findLevel(); ?>

                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                           <input type="hidden" value ="<?php echo $separation; ?>" name="data[SeparationWorkflow][separation_id]"> 
                           <?php echo $this->Form->input('SeparationWorkflow.emp_code', array('type' => 'select', 'label' => false,'options' => $fwemplist, 'class' => 'md-input','id'=>'fwlvempcode')); ?>
                        </div>
                    </div>
                </div>
                  <div class="uk-grid" data-uk-grid-margin>
                      <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                    
                        <?php echo $this->Form->submit('SAVE', array('onClick' => 'return checkSubmit()','name'=>'data[SeparationWorkflow][save]','class'=>'md-btn md-btn-success')); ?>
                          
                        
                        </div>
                      </div>
                      <div class="uk-width-medium-1-2 ">
                        <div class="parsley-row"> 
                        <a class="md-btn md-btn-danger" href="<?php echo $this->webroot;?>/separations" title="Click to Cancel.">Cancel</a>
                        </div>
                      </div>
                </div>  
                    <?php $this->Form->end(); ?>
            </div>            
        </div>
    </div>
</div>
<script type="text/javascript">
    function checkSubmit()
    {
        if ($("#fwlvempcode").val() == '')
        {
            alert("Select the employee name.");
            return false;
        } else {
            return true;
        }
    }
</script>
<script>
    var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
    ];
    $(document).ready(function () {
        $("#autocomplete").autocomplete({
            source: availableTags
        });
    });
</script>



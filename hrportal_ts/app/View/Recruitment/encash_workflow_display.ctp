<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Leave Encash Work Flow</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">

                <?php
                echo $this->Form->create('fwleave', array('inputDefaults' => array(
                        'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'my-error-class')),
                    'url' => array('controller' => 'leaves', 'action' => 'saveencashinformation'), 'id' => 'fwleaveid', 'name' => 'fwleavename'));
                ?>

                <?php
                $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
                $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

                $fwemplist = $this->Common->findLevel();
                ?>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <input type="hidden" value ="<?php echo $leaveencash; ?>" name="data[LeaveEncashWorkflow][leaveencash]"> 
                            <label>Forward *</label>
                            <?php echo $this->Form->input('LeaveEncashWorkflow.emp_code', array('type' => 'select', 'label' => "", 'options' => $fwemplist, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="data[LeaveWorkflow][save]" class="md-btn md-btn-success" href="#">Forward</button>
                        <a class="md-btn md-btn-primary" href="<?php echo $this->webroot;?>leaves/encashview/" title="Click to Cancel.">Cancel</a>   
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

<!-- page content -->
<?php $emp_code =  $this->Session->read('Auth.User.emp_code');?>
<script>
    function getmodule(val) {
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>tasks/module/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#mname").html(data);
            }
        });
    }
</script>
<script type="text/javascript">
    $('.tname').bind('keyup blur', function () {
        var node = $(this);
                node.val(node.val().replace(/[^\w ]/$, '')); }
    );
</script> 
<script type="text/javascript">
    $('.remark').bind('keyup blur', function () {
        var node = $(this);
                node.val(node.val().replace(/[^\w ]/$, '')); }
    );
</script> 

<script type="text/javascript" >

    function post1()
    {
        var text = document.getElementById("tname").value;
        if (text.charAt(0) == " ") {

            alert("First Character never be blank space..");
            document.getElementById("tname").focus();
            return false;
        }
        if (document.getElementById("startdate").value == '')
        {
            document.getElementById("startdate").focus();
            return false;
        }
        if (document.getElementById("enddate").value == '')
        {
            document.getElementById("enddate").focus();
            return false;
        }


        document.forms["task"].submit();

    }

    function post2()
    {
        alert("post2");
        document.forms.action = "tasks/cancel";
        document.forms["task"].submit();
    }
</script>
<script>
    function dateDiff(startDate, endDate) {
        var difdate = 0;
        //alert(startDate);
        //var difdate1 = 0;
        if (jQuery("#startdate").val() == '' && jQuery("#enddate").val() == '') {
            alert('Please select start date and end date');
            //jQuery('#total_leave').val('');
            return false;
        }
        difdate = (endDate.getTime() - startDate.getTime());
        if (difdate < 0) {
            $("#alerts").html('Total Days cannot be less than 0').show().delay(5000).fadeOut('slow');
            jQuery('#enddate').val('');
            return false;
        }

    }
</script>
<script>
    function assignMOM(val) {
        if (val == 0) {
            $('#mom_id_disp').show();
        } else if (val == 1) {
            $('#mom_id_disp').hide();
        }

    }
    $('#startdate').kendoDatePicker({
        start: "year",
        depth: "year",
        format: "MMMM yyyy"
    });
    $('#kUI_multiselect_basic').kendoMultiSelect();
</script>
<?php $priority=array(0=>'Very High',1=>'High',2=>'Medium',3=>'Low');
        $status = array(0=>'Recorded',1=>'Taken',2=>'Working',3=>'Closed');?>
<div id="page_content">
   

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">   
        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                
                               
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                               HELP DESK
Ticket Raise Form
                            </h3>
                        </div>         
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('helpdesk', array('url' => array('controller' => 'HelpDesks', 'action' => 'ticketraise'), 'id' => 'form_validation', 'class' => 'uk-form-stacked','enctype' => 'multipart/form-data', 'Onsubmit' => 'return passwordCompaire();')); ?>
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="ticket_id">Ticket No/ID: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="ticket_id" name="ticket_id" maxlength="25" value = '<?php echo $last_id + 1; ?>' readonly='readonly'>                            

                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="ticket_type">Ticket Type: <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('ticket_type', array('label' => false, 'type' => 'select', 'value' => '',
                                'options' => $cat_list,
                                'class' => "data-md-selectize", 'required' => true, 'id' => 'ticket_type'));
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="complainer_name">Complainer: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="ticket_id" name="complainer_name" maxlength="25" value = '<?php echo $complainer_name; ?>' readonly='readonly'>                            
                            <input type="hidden" class="md-input" id="complainer_id" name="complainer_id" maxlength="25" value = '<?php echo $complainer_id; ?>' readonly='readonly'>                            
                            
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            
                            <label for="complainer_email">Complainer Email: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="ticket_id" name="complainer_email" maxlength="50" value = '<?php echo $complainer_email; ?>' readonly='readonly'>                            

                        </div>
                    </div>
                    
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="status">Complaint Status: <span class="req">*</span></label>
                                <?php
                                echo $this->form->input('status', array('label' => false, 'type' => 'select',
                                    'options' => array('' => 'Select Status', $status),
                                    'value' => '0', 'class' => "data-md-selectize", 'required' => true, 'id' => 'status','disabled'=>'disabled'));
                                ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark">Complaint Description<span class="req">*</span></label>
                            <?php echo $this->form->textarea('remark', array('label' => false, 'class' => "md-input",'required' => true, 'onkeyup' => "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="priority">Ticket Priority: <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('priority', array('label' => false, 'type' => 'select',
                                'options' => array('' => 'Select Priority', $priority),
                                'value' => '', 'class' => "data-md-selectize", 'required' => true, 'id' => 'priority'));
                            ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                                            
                                <div class="uk-form-file md-btn md-btn-primary">
                                    Select
                                    <input id="doc_file" name="proof_file" type="file">
                                </div>
                                Attach File <span class="req"></span>
                            </div>
                    </div>
                </div>    

                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>                       
                    </div>
                </div>

<?php echo $this->Form->end(); ?>
            </div>
        </div>



    </div>
</div>

<script type="text/javascript">

    function getEmployee(val) {
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>moms/employeelist/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#empList").html(data);
            }
        });
    }
</script>  

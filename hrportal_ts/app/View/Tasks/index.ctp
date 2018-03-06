<!-- page content -->
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
    
    $(function () {
        $("#startdate").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            minDate: '<?php echo date('d-m-Y');?>',
            
            onSelect: function (selected) {
                jQuery("#enddate").datepicker("option", "minDate", selected);
                var diff = dateDiff(jQuery('#startdate').datepicker("getDate"));
                jQuery('#enddate').datepicker("getDate");

            }
        });
    });
     $(function () {
        $("#enddate").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            minDate: '<?php echo date('d-m-Y');?>',
            onSelect: function (selected) {
                jQuery("#startdate").datepicker("option", "maxDate", selected);
                var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                        jQuery('#enddate').datepicker("getDate"));
           }
        });
    });
    
    
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
    function assignMOM(val){
        if(val == 0) {
        $('#mom_id_disp').show();} else if(val== 1) { $('#mom_id_disp').hide(); }
       
    }
    $('#startdate').kendoDatePicker({
        start: "year",
        depth: "year",
        format: "MMMM yyyy"
    });
    $('#kUI_multiselect_basic').kendoMultiSelect();
</script>
<div id="page_content">
    <div class="uk-sticky-placeholder" style="height: 81px;"><div data-uk-sticky="{ top: 48, media: 960 }" id="page_heading" class="uk-sticky-init uk-active">
            <div class="heading_actions">
            </div>
            <h1>Task Allotment</h1>
            <span class="uk-text-upper uk-text-small"><a href="#">Project Name</a></span>
        </div></div>
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">            
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('task', array('url' =>array('controller' => 'tasks', 'action' =>'taskassign'),'id'=>'form_validation','class' => 'uk-form-stacked' , 'Onsubmit'=>'return passwordCompaire();')); ?>
                <h3 class="heading_a">Please fill to assign tasks.</h3>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="mom_related">Relate To MOM: <span class="req">*</span></label>
                            <?php echo $this->form->input('mom_related', array('label'=>false, 'type' => 'select', 'value' => '',
                            'options' => array('' => '--Select--', '0' => 'Yes','1' => 'No'),
                            'class' => "data-md-selectize",'required'=>true,'id'=>'mom_related','onChange'=>'assignMOM(this.value)')); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id="mom_id_disp" style="display: none">
                        <div class="parsley-row">
                            <label for="mom_id">MOM to Attach: <span class="req">*</span></label>
                            <?php echo $this->form->input('mom_id', array('label'=>false, 'type' => 'select',
                            'options' => array($mom_list),
                            'value' => '','class' => "data-md-selectize",'id'=>'mom_id')); ?>
                        </div>
                    </div>
                </div>
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tid">Task ID: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="tid" name="tid" maxlength="25" value = '<?php echo $last_id['TaskAssign']['id']+1; ?>' readonly='readonly'>                            

                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tname">Task Name: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="tname" name="tname" maxlength="25" required>                            
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tpriority">Task Priority <span class="req">*</span></label>                                
                            <?php echo $this->form->input('tpriority', array('label'=>false, 'type' => 'select', 'value' => '',
                    'options' => array('' => 'Select Priority', '0' => 'Very High','1' => 'High','2' => 'Medium','3' => 'Low'),
                    'class' => "data-md-selectize",'required'=>true,'id'=>'tpriority')); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="fullname">Project Name <span class="req">*</span></label>

                            <?php echo $this->form->input('pname', array('label'=>false, 'type' => 'select',
                        'options' => array('' => 'Select Project',$ar),
                        'value' => '','class' => "data-md-selectize",'required'=>true,'id'=>'pname', 'onChange'=>'getmodule(this.value)')); ?>

                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row" id = 'mname'>
                            
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="startdate">Start Date(d/m/y): <span class="req">*</span></label>
                            <?php 
                                echo $this->form->input('startdate', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' => 'startdate','readonly'=>true));
                                ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="enddate">End Date(d/m/y): <span class="req">*</span></label>
                            <?php echo $this->form->input('enddate', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' => 'enddate','readonly'=>true)); ?>
                        </div>
                    </div>
                    
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row" id = 'mname'>
                            
                        </div>
                    </div>
                </div>
                   <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark">Remark <span class="req">*</span></label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"md-input",'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
                    </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                
                           <?php echo $this->form->input('department_id', array('label' => "Department List", 'type' => "select",'empty' => ' -- Select Department--', 'options' => $department_list, 'class' => "md-input",'id' => 'department_list', 'required' => true,'data-md-selectize','onChange' =>'return getEmployee(this.value)')); ?>
                        </div>
                    </div>
                   </div>
                <div class="uk-grid">
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row">                                
                                <span id="empList"></span>
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
                
                <?php echo $this->Form->end();?>
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

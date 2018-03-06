<div id="page_content">
    <div class="uk-sticky-placeholder" style="height: 81px;"><div data-uk-sticky="{ top: 48, media: 960 }" id="page_heading" style="position: fixed; top: 48px; width: 1048px; left: 240px;" class="uk-sticky-init uk-active">
            <div class="heading_actions">
                <a title="Archive" data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>
                <a data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>
                
            </div>
            <h1>Task Edit</h1>
            <span class="uk-text-upper uk-text-small"><a href="#">Task Edit</a></span>
        </div></div>
    <div id="page_content_inner">
         <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">           
            <div class="md-card-content large-padding">
                <?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'taskupdate','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left')))); ?>
                <h3 class="heading_a">Please fill to assign tasks.</h3>
 
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tid">Task ID: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="tid" name="tid" maxlength="25" value = '<?php echo $asd; ?>'>                           
 
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tname">Task Name: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="tname" name="tname" maxlength="25" required value = "<?php echo $a['TaskAssign']['tname'];?>">                           
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tpriority">Task Priority <span class="req">*</span></label>                               
                             <?php echo $this->form->input('tpriority', array('label'=>false, 'type' => 'select', 'default'=> $a['TaskAssign']['tpriority'],
                            'options' => array('' => 'Select Priority', '0' => 'Very High','1' => 'High','2' => 'Medium','3' => 'Low'),
                            'class' => "data-md-selectize",'required'=>true,'id'=>'tpriority')); ?>
 
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="fullname">Project Name<span class="req">*</span></label>
                             <?php echo $this->form->input('pname', array('label'=>false, 'type' => 'select', 'default'=> $p['Tasksproject']['pid'],
                            'options' => array('' => 'Select Project',$ar),
                            'class' => "data-md-selectize",'required'=>true,'id'=>'pname', 'onChange'=>'getmodule(this.value)')); ?>
 
                        </div>
                    </div>
                </div>
 
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="startdate">Start Date(d/m/y): <span class="req">*</span></label>
                            <input type="text" class="md-input" data-uk-datepicker='{format:"DD-MM-YYYY"}' id="startdate" name="startdate" maxlength="25" value ="<?php echo $dt; ?>" required ="required">                           
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row" id = 'mname'>
                            <label for="fullname">Select Function <span class="req">*</span></label>
                            <?php echo $this->form->input('mname', array('label'=>false, 'type' => 'select','default'=>$md['Tasksprojectmodule']['mid'],
                                            'options' => array($sr),'class' => "data-md-selectize",'id'=>'mname')); ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="enddate">End Date(d/m/y): <span class="req">*</span></label>
                            <input type="text" class="md-input" data-uk-datepicker='{format:"DD-MM-YYYY"}' id="enddate" name="enddate" maxlength="25" value ="<?php echo $edt; ?>" required>                           
                        </div>
                        <div class="parsley-row">
                            <label for="remark">Remark <span class="req">*</span></label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"md-input",'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'value'=>$a['TaskAssign']['remark'])); ?>               
                        </div>
                        <div class="parsley-row">
                            <label for="kUI_multiselect_basic" class="uk-form-label">Select Employees</label>
                            <select id="kUI_multiselect_basic" multiple="multiple" name = 'ticker[]' id  = "ticker" data-placeholder="Select attendees...">
                                     <?php foreach($employee_name as $k=>$val){ ?>
                                <option  value='<?php echo $k ?>'> <?php foreach($employee_name as $t=>$value){if($value == $k ) echo 'selected';} ?> <?php echo $val ?></option>
                                    <?php } ?> 
                            </select>
                        </div>
                    </div>
                </div>
                 <?php // have to put the code for getting the related modules  ?>
                      
 
                <div class="uk-grid" data-uk-grid-margin>
 
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                           
                        <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Submit</button>                   
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>                      
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </div>
        </div>
 
 
 
    </div>
</div>


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
        // alert ("in fuction");
//       if(document.getElementById("tname").value=='')
//       {
//          document.getElementById("tname").focus();
//          return false;
//       }
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
        //if (endDate && startDate) //make sure we don't call .getTime() on a null
        //difdate = (endDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24);
 
        difdate = (endDate.getTime() - startDate.getTime());
        //if (jQuery('#enddate').val() != ""){
        //difdate1 = difdate + 1;
        //}
 
 
        if (difdate < 0) {
 
            $("#alerts").html('Total Days cannot be less than 0').show().delay(5000).fadeOut('slow');
            //alert('Total Days cannot be less than 0');
            //jQuery('#total_leave').val('');
            jQuery('#enddate').val('');
            return false;
        }
//        else {
//            //jQuery('').val(difdate1);
//
//        }
 
        //substract leaves on the basis of holidays
 
    }
 
</script>
<script>
    $('#startdate').kendoDatePicker({
        start: "year",
        depth: "year",
        format: "MMMM yyyy"
    });
    $('#kUI_multiselect_basic').kendoMultiSelect();
</script>

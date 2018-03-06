<script>
      
function getmodule(val) {
    //alert("--PROJECT ID--"+val);
    $.ajax({
    type: "POST",
    url: '<?php echo $this->webroot ?>tasks/module/'+val,
        
    //data:'project_id='+val,
    success: function(data){
                 //alert(data);
        $("#mname").html(data);
    }
    });
}
</script>
        
        
<script type="text/javascript" >
   
  function post1()
   {
         
       if(document.getElementById("startdate").value== '')
       {
          document.getElementById("startdate").focus();
          return false;
       }
       if(document.getElementById("enddate").value== '')
       {
          document.getElementById("enddate").focus();
          return false;
       }

        document.forms["task"].submit();
      
   }
    
      
</script>
<script type="text/javascript" >
  
     jQuery(document).ready(function() {
        jQuery("#startdate").datepicker({
                //inline: true,
                changeMonth: true,
                autoclose:true,
                //changeYear: true,
                format: 'dd-mm-yy',
                startDate: 'today',
        });
        jQuery("#enddate").datepicker({
                inline: true,
                changeMonth: true,
                autoclose:true,
                orientation: "right bottom",
                format: 'dd-mm-yy',
                startDate: 'today',              
        });
 
        jQuery('#enddate').change(function() {
            var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                    jQuery('#enddate').datepicker("getDate"));
              
        });
 
     jQuery('#startdate').change(function() {
            var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                    jQuery('#enddate').datepicker("getDate"));
            
        });
 

 
    });
</script>
<script>
    function dateDiff(startDate, endDate) {
  var difdate = 0;
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
            return false;       } 
    }
    
    </script>
<?php //echo "<pre>"; print_r($emp2); die;?>
     <?php //echo "<pre>"; print_r($emp2); echo "<pre>"; print_r($employee_name); die; ?>
   
<?php $auth=$this->Session->read('Auth'); ?>     
<div id="page_content">
     <div class="uk-sticky-placeholder" style="height: 81px;"><div data-uk-sticky="{ top: 48, media: 960 }" id="page_heading" style="position: fixed; top: 48px; width: 1048px; left: 240px;" class="uk-sticky-init uk-active">
            <div class="heading_actions">
                <a title="Archive" data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>
                <a data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>
                
            </div>
            <h1>Task Forward</h1>
            <span class="uk-text-upper uk-text-small"><a href="#">Task Edit</a></span>
        </div></div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">            
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('task', array('url' =>array('controller' => 'tasks', 'action' =>'taskassign'),'id'=>'form_validation','class' => 'uk-form-stacked' , 'Onsubmit'=>'return passwordCompaire();')); ?>
                <h3 class="heading_a">Please fill to assign tasks.</h3>
                <?php $auth=$this->Session->read('Auth');
                     $m= $auth['MyProfile']['desg_code']; ?>   
                <?php //echo $this->Form->create('tk',['method'=>'post','name'=>'tk','action'=>'tasks/taskassign']) ?>
                <?php if($auth['MyProfile']['desg_code']== 'PAR0000019'){?>  
                <?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'forwardto','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));
                        }else{?>
                  <?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'forwardemp','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));
                     }?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tid">Task ID: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="tid" name="tid" maxlength="25" value="<?php echo $asd;?>">                            

                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tname">Task Name: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="tname" name="tname" maxlength="25" value ="<?php echo $a['TaskAssign']['tname'];?>" required>                            
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tpriority">Task Priority <span class="req">*</span></label>                                
                            <?php echo $this->form->input('tpriority', array('label'=>false, 'type' => 'select', 'default'=> $a['TaskAssign']['tpriority'],
                    'options' => array('' => 'Select Priority', '0' => 'Very High','1' => 'High','2' => 'Medium','3' => 'Low' ),
                    'class' => "data-md-selectize",'required'=>true,'id'=>'tpriority')); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php ?>
                            <label for="fullname">Project Name <span class="req">*</span></label>
                                <?php echo $this->form->input('pname', array('label'=>false, 'type' => 'select','default'=> $p['Tasksproject']['pid'],
                                'options' => array('' => 'Select Project',$ar),
                                'class' => "data-md-selectize",'required'=>true,'id'=>'pname', 'onChange'=>'getmodule(this.value)')); ?>
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="startdate">Start Date(d/m/y): <span class="req">*</span></label>
                            <input type="text" class="md-input" data-uk-datepicker='{format:"DD-MM-YYYY"}' id="startdate" name="startdate" maxlength="25" value ="<?php echo $a['TaskAssign']['starttime']; ?>" required ="required">                            
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
                            <input type="text" class="md-input" data-uk-datepicker='{format:"DD-MM-YYYY"}' id="enddate" name="enddate" maxlength="25" value ="<?php echo $a['TaskAssign']['endtime']; ?>" required>                            
                        </div>
                        <div class="parsley-row">
                            <label for="remark">Remark <span class="req">*</span></label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"md-input",'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
                        </div>
                        <div class="parsley-row">
                            <label for="kUI_multiselect_basic" class="uk-form-label">Select Employees</label>
                            <select id="kUI_multiselect_basic" multiple="multiple" name = 'ticker[]' id  = "ticker" data-placeholder="Select attendees...">
                                     <?php foreach($employee_name as $k=>$val){ ?>
                                    <option  <?php foreach($emp2 as $t=>$value){ if($value == $k ) echo 'selected';} ?> value='<?php echo $k ?>'>  <?php echo $val ?></option>
                                    <?php } ?>  
                            </select>
                        </div>
                        
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>

                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Submit</button>                    
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

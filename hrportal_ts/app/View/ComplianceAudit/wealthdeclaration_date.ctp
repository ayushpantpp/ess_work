<script type="text/javascript">
    function checkDate(){
    
    var emp_start = $('#emp_from').val();
    var emp_end = $('#emp_to').val();
    var start = $('#commis_from').val();
    var end = $('#commis_to').val();
    
 if(emp_start!='' && emp_end!=''){ 
        var date11 = Date.parse(emp_start);
        var date22 = Date.parse(emp_end);

        if (date11 > date22) {
            alert ("From Date should be less than To Date For Employee !!");
            return false;
        }
        
   }
   
   if(start!='' && end!=''){
        var date1 = Date.parse(start);
        var date2 = Date.parse(end);

        if (date1 > date2) {
            alert ("From Date should be less than To Date For Commission!!");
            return false;
        }
        
   }
   
    var joininigdata = $('#days_joining').val();
    var exitdata = $('#days_exit').val();
    var numbers = /^[0-9]+$/;  
    
    if(joininigdata != ''){
      if(joininigdata.match(numbers)){
          //return true;
      }else{
          alert("Please enter valid number of days from joining !!");
            return false;
      }
  }
  if(exitdata != ''){
      if(exitdata.match(numbers)){
          //return true;
      }else{
          alert("Please enter valid number of days from exit !!");
            return false;
      }
  } 
}
</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">

        <h1>Wealth Declaration Date</h1>

    </div>


    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php
                if (!empty($declDate)) {
                    foreach ($declDate as $rec);
                    $emp_from = date("Y-m-d", strtotime($rec['CADeclarationDate']['emp_from']));
                    $emp_to = date("Y-m-d", strtotime($rec['CADeclarationDate']['emp_to']));
                    $commi_from = date("Y-m-d", strtotime($rec['CADeclarationDate']['commission_from']));
                    $commi_to = date("Y-m-d", strtotime($rec['CADeclarationDate']['commission_to']));
                    $joiningDays = $rec['CADeclarationDate']['days_from_joining'];
                    $exitDays = $rec['CADeclarationDate']['days_from_exit'];
                }
                ?>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'wealthdeclaration_date'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?>
                <h3 class="heading_a">Declaration Date</h3>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row">
                            <label for="dor">Declaration date for employee</label>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            
                            <label for="dor">From <span class="req">*</span></label>
                            <?php
                            echo $this->form->input("emp_from", array("type" => "text", "id"=>"emp_from","label" => false, "value"=>$emp_from,"required" => true, "data-uk-datepicker" => "{format:'YYYY-MM-DD',minDate:'".date('Y-m-d')."'}", "class" => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">To<span class="req">*</span> </label>
                            <?php
                            echo $this->form->input('emp_to', array('type' => "text", 'id'=>'emp_to','label' => false,'value'=>$emp_to,'required' => true, 'data-uk-datepicker' => '{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}', 'class' => "md-input"));
                            ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row">
                            <label for="dor">Declaration date for commission</label>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor">From <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('commi_from', array('type' => "text", 'id'=>'commis_from', 'value'=>$commi_from,'label' => false,'data-uk-datepicker' => '{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}', 'required' => true, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">To<span class="req">*</span> </label>
                            <?php
                            echo $this->form->input('commi_to', array('type' => "text", 'id'=>'commis_to','value'=>$commi_to,'label' => false,'data-uk-datepicker' => '{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}', 'required' => true, 'class' => "md-input"));
                            ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin ></div>
                <div class="uk-grid" data-uk-grid-margin ></div>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor">Declaration days from joining date <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('days_joining', array('type' => "text", 'id'=>'days_joining', 'value'=>$joiningDays,'label' => false,'required' => true,'maxlength'=>'2', 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Declaration days from exit date<span class="req">*</span> </label>
                            <?php
                            echo $this->form->input('days_exit', array('type' => "text", 'id'=>'days_exit','value'=>$exitDays,'label' => false,'required' => true, 'maxlength'=>'2','class' => "md-input"));
                            ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" onclick="return checkDate();" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                                <a  class="md-btn md-btn-primary"  href="<?php echo $this->Html->url('wealthdeclaration_date_listing'); ?>">Cancel</a>             
                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

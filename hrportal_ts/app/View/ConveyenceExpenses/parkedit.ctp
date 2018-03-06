<?php
        foreach($travelmode as $value){
            $listing .= '<option value='.$value['a']['vehical'].'>'.$this->Common->getVehicalByID($value['a']['vehical']).'</option>';
    }
        ?>
<!-- Center Content Starts -->
<?php //echo $this->Form->create('ConveyenceExpense', array('url' => array('action' => 'add'), 'id'=>'form_validation','class' => 'uk-form-stacked', 'name' => 'voucher')); ?>
<script>
    function getconveyence(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>conveyence_expenses/claimmaster/',
            success: function (data) {
                jQuery('#empResponse').html(data);
            }
        });
    }
</script>
<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>

<div id="page_content" role="main">
    <div id="page_content_inner">        
        <h3 class="heading_b uk-margin-bottom">Conveyance expense claim form</h3>
        <?php
        $auth = $this->Session->read('Auth');
        echo $flash = $this->Session->flash();
        ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">                   
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-condensed">                       

                        <tr>
                            <td>Employee Name :</td>
                            <td valign="middle"><?php echo ucwords(strtolower($auth['MyProfile']['emp_firstname'])) . " " . ucwords(strtolower($auth['MyProfile']['emp_lastname'])); ?></td>
                            <td>Voucher Date :</td>
                            <td><?php echo date('d-m-Y'); ?></td>
                        </tr>
                        <tr>
                            <td>Department :</td>
                            <?php $dept_name = $this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']); ?>

                            <td valign="middle"><?php echo $this->Form->input('Emp_department', array('type' => 'hidden', 'value' => $_SESSION['Auth']['MyProfile']['dept_code'])); ?>
                                <?php echo $this->Common->getdepartmentbyid($_SESSION['Auth']['MyProfile']['dept_code']); ?>
                            </td>
                            <td colspan="2"><a class="uk-badge uk-badge-success" data-uk-modal="{target:'#modal_overflow'}" id="dialog_link"  onclick="getconveyence();">Click here to view rates</a>

                                </th>
                        </tr>
                    </table>               
                    <div class="margin-bottom">&nbsp;</div>
                
                <div class="md-card-content">
                <?php echo $this->Form->create('ConveyenceExpenses', array('url' => array('controller'=>'conveyence_expenses','action' => 'parkedit'), 'id' => 'form_validation', 'name'=>'voucher','class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container">
                    <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup">
                        <tr>
                            <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Claim Date </th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Travel Mode </th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Wheeler Type</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">From (Place) </th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">To (Place) </th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Miscellaneous Expenses</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Misce. Exp. Description</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Distance (in Kms.)</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Travel Expenses</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Total Expense (in Rs.)</th>
                        </tr>

                            <?php $whTypelist = array('1'=>'Personal','2'=>'Commercial'); $n = 1;?>
                <?php foreach($empconveyencedetail as $rec) { ?>
                        <tr>
                            <td class="uk-text-center uk-width-small-1-10">1
                            <?php echo $this->Form->input("id", array("type" => "hidden","value"=>$rec['ConveyencExpenseDetail']['id']));
                                echo $this->Form->input("voucher_id.", array("type" => "hidden","value"=>$rec['ConveyencExpenseDetail']['voucher_id'])); ?>
                            </td>                            
                            <td><?php echo $this->Form->input("claimdate.", array("class" => "uk-width-medium-1-1 claimdate textarea_expand", "label" => "", "type" => "text","onchange"=>"calculate($n)","id"=>"claimdate_".$n,"readonly"=>true, "data-uk-datepicker"=>"{format:'DD-MM-YYYY',minDate:'01-01-2018'}", 'value'=>date("d-m-Y", strtotime($rec['ConveyencExpenseDetail']['claim_date'])),"required" => True)); ?></td>
                            <td><?php echo $this->Form->input("travelmode.", array("class" => "uk-width-medium-1-1 travelmode textarea_expand", "label" => "", "type" => "select","id"=>"travelmode_".$n,"onchange"=>"calculate($n)","empty"=>"--select--","default"=>$rec['ConveyencExpenseDetail']['travel_mode'], "options" => $travelmodev, "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("wheeler_type.", array("class" => "uk-width-medium-1-1 wheeler_type textarea_expand", "label" => "", "type" => "select" ,"id"=>"wheeler_type_".$n,"onchange"=>"calculate($n)","empty"=>"--select--","default"=>$rec['ConveyencExpenseDetail']['wheeler_type'], "options" => $whTypelist,"required" => True)); ?></td>
                            <td><?php echo $this->Form->input("from_place.", array("class" => "uk-width-medium-1-1 from_place textarea_expand", "label" => "","id"=>"from_place_".$n, "type" => "textarea","value"=>$rec['ConveyencExpenseDetail']['from_place'], "maxlength" => "2000", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("to_place.", array("class" => "uk-width-medium-1-1 to_place textarea_expand", "label" => "", "id"=>"to_place_".$n,"type" => "textarea", "value"=>$rec['ConveyencExpenseDetail']['to_place'],"maxlength" => "2000", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("misc_exp.", array("class" => "uk-width-medium-1-1 misc_exp textarea_expand", "label" => "","id"=>"misc_exp_".$n,"value"=>$rec['ConveyencExpenseDetail']['miscl_exp'], "onkeyup"=>"calculate1($n)","onkeypress" => "return isNumberKey(event)","type" => "text")); ?></td>
                            <td><?php echo $this->Form->input("misc_exp_desc.", array("class" => "uk-width-medium-1-1 misc_exp_desc textarea_expand", "label" => "","id"=>"misc_exp_desc_".$n, "value"=>$rec['ConveyencExpenseDetail']['miscl_exp_desc'],"type" => "textarea", "maxlength" => "2000")); ?></td>
                            <td><?php echo $this->Form->input("distance.", array("class" => "uk-width-medium-1-1 distance textarea_expand", "label" => "","id"=>"distance_".$n, "type" => "text","value"=>$rec['ConveyencExpenseDetail']['distance'],"maxlength" => "6","onkeyup"=>"calculate($n)","onkeypress" => "return isNumberKey(event)","required" => True)); ?></td>
                            <td><?php echo $this->Form->input("travel_exp.", array("class" => "uk-width-medium-1-1 travel_exp textarea_expand", "label" => "","id"=>"travel_exp_".$n, "value"=>$rec['ConveyencExpenseDetail']['travel_exp'],"onkeyup"=>"calculate1($n)","onkeypress" => "return isNumberKey(event)","type" => "text", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("total_exp.", array("class" => "uk-width-medium-1-1 total_exp textarea_expand", "label" => "", "id"=>"total_exp_".$n,"value"=>$rec['ConveyencExpenseDetail']['total_exp'],"onkeypress" => "return isNumberKey(event)","type" => "text","required" => True)); ?></td>
                        </tr>
                        <?php $n++; } ?>
                            
                    </table>

                </div>

                
                <br></br>
                <div class="uk-grid">
                    <div class="uk-width-1-1"> 
                    </div>
                </div>
            
            </div>
                        
           
                <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-margin-top">  
                        <!--<input type="submit" class="md-btn md-btn-warning"  value="Save as Draft" name="draft"  onclick="return confirmAction___();">-->
                        <input type="submit" class="md-btn md-btn-success" value="Apply" name="apply" onclick="return confirmAction___();">
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('view') ?>">Cancel</a>                       
                    </div>
                </div>
                </div>
        
                <?php echo $this->Form->end();?>
            
                </div>
                <br>
                <br>
            </div>                
        </div>
    </div>
</div>    
<?php //$this->Form->end(); ?>   


<script type="text/javascript">
    $(document).on('change', '#weightage', function () {
        if (Number($(this).val()) === 0) {
            $(this).val('');
            alert('Number must be greater than 0');
        } else if (Number($(this).val()) > 100) {
            $(this).val('');
            alert('Number must be less than 100');
        }
        ;
    });
    
    function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
                if (charCode == 46) {
                return false;
            }
            return true;
        }

    function confirmAction() {
        
        
        $(".claimdate").each(function () {
            var claimdate = $(this).val();
            if (claimdate !='') {
                return true;
            }else{
                alert("Please select claim date !!");
                return false;
            }
        });
        
        $(".travelmode").each(function () {
            var travelmode = $(this).val();
            if (travelmode !='') {
                return true;
            }else{
                alert("Please select travel mode !!");
                return false;
            }
        });
        
        $(".wheeler_type").each(function () {
            var wheeler_type = $(this).val();
            if (wheeler_type !='') {
                return true;
            }else{
                alert("Please select wheeler type !!");
                return false;
            }
        });
        
        
       
        var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
        $(".distance").each(function () {
            var distance = $(this).val();
            if (distance !='') {
                if(numberRegex.test(distance)) {
                return true;
                }else{
                    alert("Please enter number only !!");
                }
            }else{
                alert("Please enter the distance !!");
                return false;
            }
        });
        
        
    }
    
    function calculate(rowID)
    { 
      var claimdate = $("#claimdate_"+rowID).val();
      var travelmode = $("#travelmode_"+rowID).val();
      var wheeler_type = $("#wheeler_type_"+rowID).val();
      var distance = $("#distance_"+rowID).val();
      var misc_exp = $("#misc_exp_"+rowID).val();

        $.ajax({
            url: '<?php echo $this->webroot ?>conveyence_expenses/getVehicalRate/'+claimdate+'/'+travelmode+'/'+wheeler_type+'/'+distance,
            success: function (data) {
                $('#travel_exp_'+rowID).val(data);
                if(misc_exp!=''){
                   var result = round(data,2) + parseInt(misc_exp);
                    $('#total_exp_'+rowID).val(result);
                }else{
                    data = round(data,2);
                    $('#total_exp_'+rowID).val(data);
                }
                if(data == 0){
                    $("#travel_exp_"+rowID).prop("readonly", false); } else {$("#travel_exp_"+rowID).attr("readonly", true);}
            }
             
        });
        
    }
    function calculate1(rowID)
    { 
      var travel = $("#travel_exp_"+rowID).val();
      var misc_exp = $("#misc_exp_"+rowID).val();
      var result = parseInt(misc_exp) + parseInt(travel);
      $('#total_exp_'+rowID).val(result);
    }
    function round(value, decimals) {
       // return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
       return Math.round(value);
    }
    
    $(function(){
        $("textarea").keyup(function(e){
             $(this).val($(this).val().replace(/^\s/g, ""));
        });
    });


</script>




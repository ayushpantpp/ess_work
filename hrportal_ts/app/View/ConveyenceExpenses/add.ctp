<?php
        foreach($list as $k => $v){
            $listing .= '<option value='.$k.'>'.$this->Common->getVehicalByID($k).'</option>';
    }
        ?>
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
<div id="page_content" role="main">
    <div id="page_content_inner">        
        <?php
        $auth = $this->Session->read('Auth');
        echo $flash = $this->Session->flash();
        ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">                   
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-responsive">                       

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
                <?php echo $this->Form->create('ConveyenceExpenses', array('url' => array('controller'=>'conveyence_expenses','action' => 'add'), 'id' => 'form_validation', 'name'=>'voucher','class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container">
                    <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup">
                        <tr>
                            <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Claim Date </th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Vehicle Type </th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Wheeler Type</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">From</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">To</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Miscellaneous Expenses</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Misce. Exp. Description</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Distance (in Kms.)</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Travel Expenses</th>
                            <th  class="uk-text-center md-bg-blue-100 uk-text-small">Total Expense (in Rs.)</th>
                        </tr>

                            <?php  $whTypelist = array('1'=>'Personal','2'=>'Commercial');
                                                    ?>
                        <tr>
                            <td class="uk-text-center uk-width-small-1-10">1<?php echo $this->Form->input("rowCount", array("type" => "hidden","id"=>"rowCount","value"=>"1")); ?></td>                            
                            <td><?php echo $this->Form->input("claimdate.", array("class" => "uk-width-medium-1-1 claimdate textarea_expand", "label" => "", "type" => "text","onchange"=>"calculate('1')","id"=>"claimdate_1","readonly"=>true, "data-uk-datepicker"=>"{format:'DD-MM-YYYY',minDate:'01-01-2018',maxDate:'".date('d-m-Y'+1)."'}", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("travelmode.", array("class" => "uk-width-medium-1-1 travelmode textarea_expand", "label" => "", "type" => "select","id"=>"travelmode_1","onchange"=>"calculate('1')","empty"=>"--select--", "options" => $list, "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("wheeler_type.", array("class" => "uk-width-medium-1-1 wheeler_type textarea_expand", "label" => "", "type" => "select" ,"id"=>"wheeler_type_1","onchange"=>"calculate('1')","empty"=>"--select--", "options" => $whTypelist,"required" => True)); ?></td>
                            <td><?php echo $this->Form->input("from_place.", array("class" => "uk-width-medium-1-1 from_place textarea_expand", "label" => "","id"=>"from_place_1", "type" => "textarea", "maxlength" => "2000", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("to_place.", array("class" => "uk-width-medium-1-1 to_place textarea_expand", "label" => "", "id"=>"to_place_1","type" => "textarea", "maxlength" => "2000", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("misc_exp.", array("class" => "uk-width-medium-1-1 misc_exp textarea_expand", "label" => "","id"=>"misc_exp_1","value"=>0, "onkeyup"=>"calculate1('1')","onkeypress" => "return isNumberKey(event)","type" => "text")); ?></td>
                            <td><?php echo $this->Form->input("misc_exp_desc.", array("class" => "uk-width-medium-1-1 misc_exp_desc textarea_expand", "label" => "","id"=>"misc_exp_desc_1", "type" => "textarea", "maxlength" => "2000")); ?></td>
                            <td><?php echo $this->Form->input("distance.", array("class" => "uk-width-medium-1-1 distance textarea_expand", "label" => "","value"=>0,"id"=>"distance_1", "type" => "text","maxlength" => "6","onkeyup"=>"calculate('1')","onkeypress" => "return isNumberKey(event)","required" => True)); ?></td>
                            <td><?php echo $this->Form->input("travel_exp.", array("class" => "uk-width-medium-1-1 travel_exp textarea_expand", "label" => "","id"=>"travel_exp_1","onkeypress" => "return isNumberKey(event)","onkeyup"=>"calculate1('1')","type" => "text", "required" => True,"readonly"=>"readonly")); ?></td>
                            <td><?php echo $this->Form->input("total_exp.", array("class" => "uk-width-medium-1-1 total_exp textarea_expand", "label" => "", "id"=>"total_exp_1","onkeypress" => "return isNumberKey(event)","type" => "text","required" => True,"readonly"=>"readonly")); ?></td>
                        </tr>
                    </table>

                </div>

                
                <br></br>
                <div class="uk-grid">
                    <div class="uk-width-1-1"> 
                        <!--<input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();" name="submit" value="Submit">-->
                        <input type='button' class="md-btn md-btn-primary plusbtn"  value='Add More' id='addButton'>
                        <input type='button' class="md-btn md-btn-danger minusbtn" value='Remove' id='removeButton'>
                    </div>
                </div>
            
            </div>
                        
           
                <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-margin-top">  
                        <input type="submit" class="md-btn md-btn-warning"  value="Save as Draft" name="draft"  onclick="return confirmAction___();">
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
<?php //$this->Form->end(); ?>   


<script type="text/javascript">
    
         
    var counter = 2;
    var valu = '<?php echo $listing;?>';
    $('.plusbtn').click(function () {

        $("#TextBoxesGroup").append('<tr><?php echo $this->Form->create("ConveyenceExpenses"); ?>' +
                '<td class="uk-text-center uk-width-small-1-10">' + counter + '</td>' +
                '<td><input type="text" name="data[ConveyenceExpenses][claimdate][]" class="uk-width-medium-1-1 travelmode " id="claimdate_'+counter+'" required="true" data-uk-datepicker={format:"DD-MM-YYYY",minDate:"01-01-2018"}></input></td>'+
                //'<td><?php //echo $this->Form->input("travelmode.", array("class" => "uk-width-medium-1-1 travelmode textarea_expand", "label" => "", "type" => "select","options"=>$list,"id"=>"travelmode_".$count,  "required" => True)); ?></td>' +
                '<td><select name="data[ConveyenceExpenses][travelmode][]" class="uk-width-medium-1-1 travelmode textarea_expand" onchange="calculate('+counter+')" id="travelmode_'+counter+'" required="true"><option value="">--select--</option>'+valu+'</select></td>'+
                '<td><select name="data[ConveyenceExpenses][wheeler_type][]" class="uk-width-medium-1-1 wheeler_type textarea_expand" onchange="calculate('+counter+')" id="wheeler_type_'+counter+'" required="true">'+
                '<option value="">--select--</option>'+
                '<option value="1">Personal</option>'+
                '<option value="2">Commercial</option>'+
                '</select></td>'+
                '<td><input type="text" name="data[ConveyenceExpenses][from_place][]" class="uk-width-medium-1-1 travelmode " id="from_place_'+counter+'" required="true"></input></td>'+
                '<td><input type="text" name="data[ConveyenceExpenses][to_place][]" class="uk-width-medium-1-1 travelmode " id="to_place_'+counter+'" required="true"></input></td>'+
                '<td><input type="text" name="data[ConveyenceExpenses][misc_exp][]" class="uk-width-medium-1-1 travelmode " onchange="calculate1('+counter+')"  value = "0" id="misc_exp_'+counter+'" onkeypress = "return isNumberKey(event)" required="true"></input></td>'+
                '<td><input type="text" name="data[ConveyenceExpenses][misc_exp_desc][]" class="uk-width-medium-1-1 travelmode textarea_expand" id="misc_exp_desc_'+counter+'" required="false"></input></td>'+
                '<td><input type="text" name="data[ConveyenceExpenses][distance][]" class="uk-width-medium-1-1 travelmode " value = "0" onchange="calculate('+counter+')" id="distance_'+counter+'" required="true" onkeypress = "return isNumberKey(event)"></input></td>'+
                '<td><input type="text" name="data[ConveyenceExpenses][travel_exp][]" class="uk-width-medium-1-1 travelmode " id="travel_exp_'+counter+'" onkeyup="return calculate1('+counter+')" required="true" readonly="readonly"></input></td>'+
                '<td><input type="text" name="data[ConveyenceExpenses][total_exp][]" class="uk-width-medium-1-1 travelmode " id="total_exp_'+counter+'" required="true" readonly="readonly"></input></td>'+
                '</tr>');
         $('#rowCount').val(counter);
        counter++;
    });

    $('.minusbtn').click(function () {
        if ($("#TextBoxesGroup tr").length != 2) {
            $("#TextBoxesGroup tr:last-child").remove();
            counter--;
        }
        else {
            alert("You cannot delete first row");
        }
    });

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




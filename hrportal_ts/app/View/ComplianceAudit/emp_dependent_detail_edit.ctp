<?php
foreach ($travelmode as $value) {
    $listing .= '<option value=' . $value['a']['vehical'] . '>' . $this->Common->getVehicalByID($value['a']['vehical']) . '</option>';
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
                //alert(data);
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
        <?php
        $auth = $this->Session->read('Auth');
        echo $flash = $this->Session->flash();
        ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding"> 
                <h3 class="heading_b uk-margin-bottom">Dependent Details</h3>
                <div class="uk-overflow-container">
                    <div class="margin-bottom">&nbsp;</div>
                    <?php foreach($DependentDetail as $rec);?>
                    <div class="md-card-content">
                        <?php echo $this->Form->create('ComplianceAudit', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'emp_dependent_detail_edit'), 'id' => 'form_validation', 'name' => 'voucher', 'class' => 'uk-form-stacked')); ?>
                        <div class="uk-overflow-container">
                            <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup">
                                <tr>
                                    <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Dependent</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">First Name</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Surname</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Other Name</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Date of Birth </th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Status</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Comment </th>
                                </tr>

                                <?php
                                echo $this->Form->input("emp_dif_id", array("label" => "", "type" => "hidden", "value" => $rec['CADependentDetails']['emp_difini_id'], "required" => True));
                                echo $this->Form->input("depnd_id", array("label" => "", "type" => "hidden", "value" => $rec['CADependentDetails']['id'], "required" => True));
                                $depstatus = array('1' => 'Active', '2' => 'Inactive');
                                $dep_type = array('1' => 'Spouse', '2' => 'Children');
                                
                               $cur_date = date('d-m-Y');
                               $date = date_create(date('Y-m-d'));
                               date_sub($date, date_interval_create_from_date_string('18 year'));
                               $mydate = date_format($date, 'd-m-Y');
                                if($rec['CADependentDetails']['dependent_type']=='1'){
                                    $dob = '"data-uk-datepicker"=>"maxDate:"'.$cur_date.'"';
                                }elseif($rec['CADependentDetails']['dependent_type']=='2'){
                                $dob = 'maxDate:"'.$cur_date.'",minDate:"'.$mydate.'"';
                                }
                                
                                ?>
                                <tr>
                                    <td class="uk-text-center uk-width-small-1-10">1<?php echo $this->Form->input("rowCount", array("type" => "hidden", "id" => "rowCount", "value" => "1")); ?></td>                            
                                    <td><?php echo $this->Form->input("dependent", array("class" => "uk-width-medium-1-1 dependent textarea_expand", "label" => "", "type" => "select", "empty" => "--Select--",'default'=>$rec['CADependentDetails']['dependent_type'], "id" => "dependent_1", "onchange" => "calculate('1',this.value)", "options" => $dep_type, "required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("fname", array("class" => "uk-width-medium-1-1 fname textarea_expand", "label" => "", "type" => "text","value"=>$rec['CADependentDetails']['fname'], "id" => "fname_1", "required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("surname", array("class" => "uk-width-medium-1-1 surname textarea_expand", "label" => "", "type" => "text", "value"=>$rec['CADependentDetails']['surname'],"id" => "surname_1", "required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("othername", array("class" => "uk-width-medium-1-1 othername textarea_expand", "label" => "", "type" => "text", "value"=>$rec['CADependentDetails']['othername'],"id" => "othername_1")); ?></td>
                                    <td><?php echo $this->Form->input("dob", array("class" => "uk-width-medium-1-1 dob textarea_expand", "label" => "", "type" => "text", "id" => "dob_1","value"=>date("d/m/Y", strtotime($rec['CADependentDetails']['dob'])),"data-uk-datepicker"=>"{format:'DD-MM-YYYY',".$dob."}", "readonly" => true,  "required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("status", array("class" => "uk-width-medium-1-1 status textarea_expand", "label" => "", "type" => "select", "id" => "status_1", "onchange" => "status('1',this.value)", "options" => $depstatus,'default'=>$rec['CADependentDetails']['depend_status'], "required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("comment", array("class" => "uk-width-medium-1-1 comment textarea_expand", "label" => "", "id" => "comment_1", "type" => "textarea","value"=>$rec['CADependentDetails']['comment'],"maxlength" => "2000")); ?></td>
                                </tr>
                            </table>

                        </div>

                    </div>


                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-grid">
                            <div class="uk-width-1-1 uk-margin-top">  
                                <!--<input type="submit" class="md-btn md-btn-warning"  value="Save as Draft" name="draft"  onclick="return confirmAction___();">-->
                                <input type="submit" class="md-btn md-btn-success" value="Save" name="submit" onclick="return confirmAction___();">
                                <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('emp_definition') ?>">Cancel</a>                       
                            </div>
                        </div>
                    </div>

                    <?php echo $this->Form->end(); ?>

                </div>
                <br>
                <br>

                <!-- <div class="uk-grid">
                     <div class="uk-width-1-1">
                         <input type="submit" class="md-btn md-btn-warning"  value="Save as Draft"  onClick =" return checkSubmit();">
                         <input type="submit" class="md-btn md-btn-success" value="Apply" name='post_travel' onclick=" return post();">
 
                         <input type="button" class = 'md-btn md-btn-primary' value="Add New" onClick="return addmore()"/>
                         <input type="button" class = 'md-btn md-btn-danger' value="Remove" onClick="return removeRow()" id="removeButton"/>
 
                     </div>
                 </div>-->

            </div>                
        </div>
    </div>
</div>    
<?php //$this->Form->end(); ?>   


<script type="text/javascript">


    var counter = 2;
    var valu = '<?php echo $listing; ?>';
<?php $count = 2; ?>
    $('.plusbtn').click(function () {

        $("#TextBoxesGroup").append('<tr><?php echo $this->Form->create("ComplianceAudit"); ?>' +
                '<td class="uk-text-center uk-width-small-1-10">' + counter + '</td>' +
                '<td><select name="data[ComplianceAudit][dependent][]" class="uk-width-medium-1-1 dependent textarea_expand" id="dependent_' +<?php echo $count; ?> + '"  onchange="calculate('+<?php echo $count; ?>+',this.value)"  required="true">' +
                '<option value="">--Select--</option>' +
                '<option value="1">Spouse</option>' +
                '<option value="2">Children</option>' +
                '</select></td>' +
                '<td><?php echo $this->Form->input("fname.", array("class" => "uk-width-medium-1-1 fname textarea_expand", "label" => "", "type" => "text", "id" => "fname_" . $count, "required" => True)); ?></td>' +
                '<td><?php echo $this->Form->input("surname.", array("class" => "uk-width-medium-1-1 surname textarea_expand", "label" => "", "type" => "text", "id" => "surname_" . $count, "required" => True)); ?></td>' +
                '<td><?php echo $this->Form->input("othername.", array("class" => "uk-width-medium-1-1 othername textarea_expand", "label" => "", "type" => "text", "id" => "othername_" . $count)); ?></td>' +
                '<td><?php echo $this->Form->input("dob.", array("class" => "uk-width-medium-1-1 dob", "id" => "dob_" . $count, "label" => "", "required" => true, "readonly" => true, "type" => "text")); ?></td>' +
                '<td><?php echo $this->Form->input("comment.", array("class" => "uk-width-medium-1-1 comment textarea_expand", "label" => "", "id" => "comment_" . $count, "type" => "textarea", "maxlength" => "500")); ?></td>' +
                '<td><select name="data[ComplianceAudit][status][]" class="uk-width-medium-1-1 status textarea_expand" id="status_' +<?php echo $count; ?> + '" onchange="status('+<?php echo $count; ?>+',this.value)"  required="true">' +
                '<option value="1">Active</option>' +
                '<option value="2">Inactive</option>' +
                '</select></td>' +
                '</tr>');
<?php $count++; ?>
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
            if (claimdate != '') {
                return true;
            } else {
                alert("Please select claim date !!");
                return false;
            }
        });

        $(".travelmode").each(function () {
            var travelmode = $(this).val();
            if (travelmode != '') {
                return true;
            } else {
                alert("Please select travel mode !!");
                return false;
            }
        });

        $(".wheeler_type").each(function () {
            var wheeler_type = $(this).val();
            if (wheeler_type != '') {
                return true;
            } else {
                alert("Please select wheeler type !!");
                return false;
            }
        });



        var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
        $(".distance").each(function () {
            var distance = $(this).val();
            if (distance != '') {
                if (numberRegex.test(distance)) {
                    return true;
                } else {
                    alert("Please enter number only !!");
                }
            } else {
                alert("Please enter the distance !!");
                return false;
            }
        });






//        $(document).on('change', '#weightage', function () {
//        if (Number($(this).val()) === 0) {
//            $(this).val('');
//            alert('Number must be greater than 0');
//        } else if (Number($(this).val()) > 100) {
//            $(this).val('');
//            alert('Number must be less than 100');
//        }
//        ;
//    });







        // var calculated_total_sum = 0;            

//        $(".weightage").each(function () {
//            var get_textbox_value = $(this).val();
//            if ($.isNumeric(get_textbox_value)) {
//                calculated_total_sum += parseFloat(get_textbox_value);
//            }
//        });
//
//        if(calculated_total_sum !== 100){
//            alert("Weightage sum must be 100 %. !!!");
//            return false;
//        }else{
//            return true;
//        }
//
//        $("#total_sum_value").html(calculated_total_sum);       

    }

    function calculate(rowID,depndType)
    { 
        
        var date = new Date();
            date.setDate( date.getDate() );
            date.setMonth( date.getMonth() );
            date.setFullYear( date.getFullYear() - 18 );
            
        var curdate = new Date();
            curdate.setDate( curdate.getDate() );
            curdate.setMonth( curdate.getMonth()+1 );
            curdate.setFullYear( curdate.getFullYear());    
            
        var mydate = (date.getDate() ) + '-' + (date.getMonth()) + '-' + (date.getFullYear());
        var cur_date = (curdate.getDate() ) + '-' + (curdate.getMonth()) + '-' + (curdate.getFullYear());

        if(depndType == '1'){ 
            $("#dob_"+rowID).attr("data-uk-datepicker","{format:'DD-MM-YYYY',maxDate:'"+cur_date+"'}");
        }
        if(depndType == '2'){ 
            $("#dob_"+rowID).attr("data-uk-datepicker","{format:'DD-MM-YYYY',maxDate:'"+cur_date+"',minDate:'"+mydate+"'}");
        }
        
    }
    
    
    function status(rowID,depndStatus)
    { 
        
        if(depndStatus == '1'){ 
            $("#comment_"+rowID).attr("required",false);
        }
        if(depndStatus == '2'){ 
            $("#comment_"+rowID).attr("required",true);
        }
        
    }

//    function post()
//    {
//
//        document.voucher.action = "add";
//        return confirmAction();
//
//
//    }

    $(function () {
        $("textarea").keyup(function (e) {
            $(this).val($(this).val().replace(/^\s/g, ""));
        });
    });


</script>




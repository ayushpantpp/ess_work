 <?php if($formID%2!=0){
     $class = "style='background-color: #EEEEE4; border: 10px solid #EEEEE4'";
 }else{
     $class = "style='background-color: #EEEEE4; border: 10px solid #EEEEE4'";
 }
 ?>
<div id="allform<?php echo $formID;?>"  >
    <br>
    <div <?= $class; ?>>
    <div class="uk-grid" data-uk-grid-margin > 
                        <div class="uk-width-medium-1-3">
                                <label for="dor" class="label-fixed">Spouse<span class="req">*</span></label>
                                <?php
                                //$option = array('1' => 'Initial', '2' => 'Benial', '3' => 'Final');
                                echo $this->form->input('declar_depend_type'.$formID, array('type' => "select", 'label' => false, 'options' => $spouses, 'empty' => '--Select--', 'required' => true, 'class' => "md-input declar_type label-fixed"));
                                ?>
                        </div>
                    </div>
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-2"> 
                                    <span class="uk-form-help-block">(including, but not limited to, salary and emoluments and income from investment.
                                        The period is from the previous statement date to the current statement date. For an initial declaration, 
                                        the period is the year ending on the statement date.)</span>
                                </div>
                            </div>
                            <?php
                            $OpenFlage = '';
                            foreach ($EmpWealthDecla[0]['CAWealthAssets'] as $assrec) {
                                if ($assrec['assets_for'] == '1') {
                                    $OpenFlage = "Yes";
                                }
                            }
                            if ($OpenFlage == "Yes") {
                                ?>
                                <div class="uk-grid" data-uk-grid-margin > </div>
                                <div class="uk-grid" data-uk-grid-margin >     
                                    <div class="uk-width-1-2"> 
                                        <div class="uk-overflow-container">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Action</th>
                                                </tr>
                                                    <?php
                                                    if (!empty($EmpWealthDecla)) {
                                                        $x = 0;
                                                        $c = 1;

                                                        foreach ($EmpWealthDecla[0]['CAWealthAssets'] as $assrec) {
                                                            if ($assrec['assets_for'] == '1') {
                                                                ?>
                                                                <tr >
                                                                    <td class="uk-text-center uk-width-small-1-10" ><?php echo $c; ?></td>                            
                                                                    <td><?php echo wordwrap($assrec['description'], 40, "<br>\n"); ?></td>
                                                                    <td class="uk-text-center"><?php echo $assrec['approx_amount']; ?></td>
                                                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/ComplianceAudit/emp_wealthdeclaration/' . $emp_difin_id . "/" . $assrec['id'] . "/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a></span></td>
                                                                </tr>
                                                                <?php
                                                                $c++;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                            </table>

                                        </div>
                                    </div>
                                </div>
<?php } ?>

                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-2"> 
                                    <div class="uk-overflow-container">
                                        <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup1-<?= $formID; ?>">
                                            <tr>
                                                <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                                                <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                            </tr>

                                            <tr style="background-color: #F9F9F9;">
                                                <td class="uk-text-center uk-width-small-1-10">1<?php echo $this->Form->input("rowCount1-".$formID, array("type" => "hidden", "id" => "rowCount1-".$formID, "value" => "1")); ?></td>                            
                                                <td><?php echo $this->Form->input("desc_1_".$formID.".", array("class" => "uk-width-medium-1-1 desc1 textarea_expand", "label" => "", "id" => "desc1_1", "type" => "textarea", "maxlength" => "2000")); ?></td>
                                                <td><?php echo $this->Form->input("aprox_amt_1_".$formID.".", array("class" => "uk-width-medium-1-1 aprox_amt1 textarea_expand", "label" => "", "type" => "text", "id" => "aprox_amt1_1")); ?></td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <div class="uk-width-1-2"> 
                                    <!--<input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();" name="submit" value="Submit">-->
                                    <input type='button' class="md-btn md-btn-primary plusbtn1-1-<?= $formID?>"  value='Add More' id='addButton1'>
                                    <input type='button' class="md-btn md-btn-danger minusbtn1-1-<?= $formID?>" value='Remove' id='removeButton1'>
                                </div>

                            </div>
                            <hr>
                            
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-1">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Assets(as of the statement date)</label>
                                        <span class="uk-form-help-block">(Including, but not limited to, land, buildings, vehicles, investment and financial obligations
                                            owed to the person for whom the statement is made)</span>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $OpenFlage2 = '';
                            foreach ($EmpWealthDecla[0]['CAWealthAssets'] as $assrec) {
                                if ($assrec['assets_for'] == '2') {
                                    $OpenFlage2 = "Yes";
                                }
                            }
                            if ($OpenFlage2 == "Yes") {
                                ?>
                                <div class="uk-grid" data-uk-grid-margin > 
                                    <div class="uk-width-1-2"> 
                                        <div class="uk-overflow-container">
                                            <table border="1" class="uk-table uk-tab-responsive" >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Action</th>
                                                </tr>
                                                <?php
                                                if (!empty($EmpWealthDecla)) {
                                                    $x = 0;
                                                    $c = 1;

                                                    foreach ($EmpWealthDecla[0]['CAWealthAssets'] as $assrec) {
                                                        if ($assrec['assets_for'] == '2') {
                                                            ?>
                                                            <tr>
                                                                <td class="uk-text-center uk-width-small-1-10"><?php echo $c; ?></td>                            
                                                                <td><?php echo wordwrap($assrec['description'], 40, "<br>\n"); ?></td>
                                                                <td class="uk-text-center"><?php echo $assrec['approx_amount']; ?></td>
                                                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/ComplianceAudit/emp_wealthdeclaration/' . $emp_difin_id . "/" . $assrec['id'] . "/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a></span></td>
                                                            </tr>
                <?php $c++;
            }
        }
    } ?>
                                            </table>

                                        </div>
                                    </div>
                                </div>
<?php } ?>

                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-2"> 
                                    <div class="uk-overflow-container">
                                        <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup2-<?= $formID?>">
                                            <tr>
                                                <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                                                <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description<br>(include location of assets where applicable)</th>
                                                <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                            </tr>

                                            <tr style="background-color: #F9F9F9 ">
                                                <td class="uk-text-center uk-width-small-1-10">1<?php echo $this->Form->input("rowCount2-".$formID, array("type" => "hidden", "id" => "rowCount2-".$formID, "value" => "1")); ?></td>                            
                                                <td><?php echo $this->Form->input("desc_2_".$formID.".", array("class" => "uk-width-medium-1-1 desc_2 textarea_expand", "label" => "", "id" => "desc_2_1", "type" => "textarea", "maxlength" => "2000")); ?></td>
                                                <td><?php echo $this->Form->input("aprox_amt_2_".$formID.".", array("class" => "uk-width-medium-1-1 aprox_amt_2 textarea_expand", "label" => "", "type" => "text", "id" => "aprox_amt_2_1")); ?></td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <div class="uk-width-1-2"> 
                                    <!--<input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();" name="submit" value="Submit">-->
                                    <input type='button' class="md-btn md-btn-primary plusbtn2-1-<?= $formID?>"  value='Add More' id='addButton2'>
                                    <input type='button' class="md-btn md-btn-danger minusbtn2-1-<?= $formID?>" value='Remove' id='removeButton2'>
                                </div>

                            </div>

                            <hr>

                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-1">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Liabilities(as of the statement date)</label>
                                    </div>
                                </div>
                            </div>

<?php
$OpenFlage3 = '';
foreach ($EmpWealthDecla[0]['CAWealthAssets'] as $assrec) {
    if ($assrec['assets_for'] == '3') {
        $OpenFlage3 = "Yes";
    }
}
if ($OpenFlage3 == "Yes") {
    ?>
                                <div class="uk-grid" data-uk-grid-margin > 
                                    <div class="uk-width-1-2"> 
                                        <div class="uk-overflow-container">
                                            <table border="1" class="uk-table uk-tab-responsive" >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Action</th>
                                                </tr>
                                    <?php
                                    if (!empty($EmpWealthDecla)) {
                                        $x = 0;
                                        $c = 1;

                                        foreach ($EmpWealthDecla[0]['CAWealthAssets'] as $assrec) {
                                            if ($assrec['assets_for'] == '3') {
                                                ?>
                                                <tr>
                                                    <td class="uk-text-center uk-width-small-1-10"><?php echo $c; ?></td>                            
                                                    <td><?php echo wordwrap($assrec['description'], 40, "<br>\n"); ?></td>
                                                    <td class="uk-text-center"><?php echo $assrec['approx_amount']; ?></td>
                                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/ComplianceAudit/emp_wealthdeclaration/' . $emp_difin_id . "/" . $assrec['id'] . "/del"); ?>" onclick="return confirm('Are you sure?');">Delete</a></span></td>
                                                </tr>
                                                            <?php $c++;
                                                        }
                                                    }
                                                } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
<?php } ?>

                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-2"> 
                                    <div class="uk-overflow-container">
                                        <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup3-<?= $formID?>">
                                            <tr>
                                                <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                                                <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                            </tr>

                                            <tr style="background-color: #F9F9F9">
                                                <td class="uk-text-center uk-width-small-1-10">1<?php echo $this->Form->input("rowCount3-".$formID, array("type" => "hidden", "id" => "rowCount3-".$formID, "value" => "1")); ?></td>                            
                                                <td><?php echo $this->Form->input("desc_3_".$formID.".", array("class" => "uk-width-medium-1-1 desc_3 textarea_expand", "label" => "", "id" => "desc_3_1", "type" => "textarea", "maxlength" => "2000")); ?></td>
                                                <td><?php echo $this->Form->input("aprox_amt_3_".$formID.".", array("class" => "uk-width-medium-1-1 aprox_amt_3 textarea_expand", "label" => "", "type" => "text", "id" => "aprox_amt_3_1")); ?></td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <div class="uk-width-1-2"> 
                                    <!--<input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();" name="submit" value="Submit">-->
                                    <input type='button' class="md-btn md-btn-primary plusbtn3-1-<?= $formID?>"  value='Add More' id='addButton'>
                                    <input type='button' class="md-btn md-btn-danger minusbtn3-1-<?= $formID?>" value='Remove' id='removeButton'>
                                </div>

                            </div>

                            </p>
                            </div>
 </div>



<script type="text/javascript">

 var formid = <?= $formID ;?>;
 var counter<?= $formID ;?> = 2;
    $('#allform'+formid+' .plusbtn1-1-'+formid+'').click(function () {
        //alert($(this).parents('div:eq(3)').attr('id'));
        var divid=$(this).parents('div:eq(3)').attr('id');
        //formid=formid;
        formid = divid.split("allform");
        //alert(formid[1]+'===='+<?= $formID ;?>);
//alert(divid);
//formid--;
        $('#'+divid+' #TextBoxesGroup1-'+formid[1]+'').append('<tr style="background-color: #F9F9F9"><?php echo $this->Form->create("ComplianceAudit"); ?>' +
                '<td class="uk-text-center uk-width-small-1-10">' + counter<?= $formID ;?> + '</td>' +
                '<td><textarea name="data[ComplianceAudit][desc_1_'+formid[1]+'][]" class="uk-width-medium-1-1 desc1 textarea_expand" id="desc1_'+counter+'" maxlength="500" required="required"></textarea></td>' +
                '<td><input  name="data[ComplianceAudit][aprox_amt_1_'+formid[1]+'][]"  type="text" class="uk-width-medium-1-1 aprox_amt1 textarea_expand" id="aprox_amt1_'+counter+'" required="required" ></td>' +
                '</tr>');
        $('#rowCount1-'+formid[1]).val(counter<?= $formID ;?>);

        counter<?= $formID ;?>++;

    });
    $('#allform'+formid+' .minusbtn1-1-'+formid+'').click(function () {
        var divid=$(this).parents('div:eq(3)').attr('id');
        formid = divid.split("allform");
        if ($('#'+divid+' #TextBoxesGroup1-'+formid[1]+' tr').length != 2) {
            $('#'+divid+' #TextBoxesGroup1-'+formid[1]+' tr:last-child').remove();
            counter<?= $formID ;?>--;
        }
        else {
            alert("You cannot delete first row");
        }
    });




    //////////////// for sec ////////
    var formid = <?= $formID ;?>;
    var counter2<?= $formID ;?> = 2;
    $('#allform'+formid+' .plusbtn2-1-'+formid+'').click(function () {
        //alert($(this).parents('div:eq(3)').attr('id'));
        var divid=$(this).parents('div:eq(3)').attr('id');
        formid = divid.split("allform");
        //formid=formid;
//alert(formid);
//formid--;
  
        $('#'+divid+' #TextBoxesGroup2-'+formid[1]+'').append('<tr style="background-color: #F9F9F9"><?php echo $this->Form->create("ComplianceAudit"); ?>' +
                '<td class="uk-text-center uk-width-small-1-10">' + counter2<?= $formID ;?> + '</td>' +
                '<td><textarea name="data[ComplianceAudit][desc_2_'+formid[1]+'][]" class="uk-width-medium-1-1 desc_2 textarea_expand" id="desc_2_'+counter+'" maxlength="500" required="required"></textarea></td>' +
                '<td><input  name="data[ComplianceAudit][aprox_amt_2_'+formid[1]+'][]"  type="text" class="uk-width-medium-1-1 aprox_amt_2 textarea_expand" id="aprox_amt_2_'+counter+'" required="required" ></td>' +
                '</tr>');
        $('#rowCount2-'+formid[1]+'').val(counter2<?= $formID ;?>);

        counter2<?= $formID ;?>++;

    });
    

    $('#allform'+formid+' .minusbtn2-1-'+formid+'').click(function () {
        var divid=$(this).parents('div:eq(3)').attr('id');
        formid = divid.split("allform");
       // alert(divid);
        if ($('#'+divid+' #TextBoxesGroup2-'+formid[1]+' tr').length != 2) {
            $('#'+divid+' #TextBoxesGroup2-'+formid[1]+' tr:last-child').remove();
            counter2<?= $formID ;?>--;
        }
        else {
            alert("You cannot delete first row");
        }
    });
    





    //////////////// for third ////////
    var formid = <?= $formID ;?>;
    var counter3<?= $formID ;?> = 2;
    $('#allform'+formid+' .plusbtn3-1-'+formid+'').click(function () {
        //alert($(this).parents('div:eq(3)').attr('id'));
        var divid=$(this).parents('div:eq(3)').attr('id');
        formid = divid.split("allform");
        //formid=formid;
//alert(formid);
//formid--;
  
        $('#'+divid+' #TextBoxesGroup3-'+formid[1]+'').append('<tr style="background-color: #F9F9F9"><?php echo $this->Form->create("ComplianceAudit"); ?>' +
                '<td class="uk-text-center uk-width-small-1-10">' + counter3<?= $formID ;?> + '</td>' +
                '<td><textarea name="data[ComplianceAudit][desc_3_'+formid[1]+'][]" class="uk-width-medium-1-1 desc_3 textarea_expand" id="desc_3_'+counter+'" maxlength="500" required="required"></textarea></td>' +
                '<td><input  name="data[ComplianceAudit][aprox_amt_3_'+formid[1]+'][]"  type="text" class="uk-width-medium-1-1 aprox_amt_3 textarea_expand" id="aprox_amt_3_'+counter+'" required="required" ></td>' +
                '</tr>');
        $('#rowCount3-'+formid[1]+'').val(counter3<?= $formID ;?>);

        counter3<?= $formID ;?>++;

    });
    
    
    $('#allform'+formid+' .minusbtn3-1-'+formid+'').click(function () {
        var divid=$(this).parents('div:eq(3)').attr('id');
        formid = divid.split("allform");
       // alert(divid);
        if ($('#'+divid+' #TextBoxesGroup3-'+formid[1]+' tr').length != 2) {
            $('#'+divid+' #TextBoxesGroup3-'+formid[1]+' tr:last-child').remove();
            counter3<?= $formID ;?>--;
        }
        else {
            alert("You cannot delete first row");
        }
    });


</script>

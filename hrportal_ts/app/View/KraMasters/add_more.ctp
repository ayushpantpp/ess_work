<?php ?>
<div id="page_content" role="main">
    <div id="page_content_inner">        
        
        <div class="md-card">         
            
            
            <div class="md-card-content"><h3>Add Temporary Component</h3>
        
                
                <div class="uk-overflow-container">
                    <table border="1" class="uk-table uk-tab-responsive table1" id="TextBoxesGroup" >
                        <tr>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">KRA </th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Weightage (%)</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Measure (KPI)</th>
                            <th colspan="3" class="uk-text-center md-bg-blue-100 uk-text-small">Target</th>
                        </tr>

                        <tr>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Measure Type</th>
                            <!--<th class="uk-text-center md-bg-blue-100 uk-text-small">Qualifying</th>-->
			    <th class="uk-text-center md-bg-blue-100 uk-text-small">Target</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Stretched</th>
                        </tr>

                        <tr>
                            <td class="uk-text-center uk-width-small-1-10">1</td>                            
                                            <td><select>
                                <option value="--select--">--select--</option>
                                <option value="1">Volvo</option>
                                <option value="2">Saab</option>
                                <option value="3">VW</option>
                                <option value="4">Audi</option>
                            </select></td>
                            <td><?php echo $this->Form->input("weightage.", array("class" => "uk-width-medium-1-1 weightage", "id" => "weightage", "maxlength" => "3", "onkeyup" => "return isNumber(this);", "onkeypress" => "return isNumberKey(event)", "label" => "", "type" => "text", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("measure.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "", "type" => "textarea", "maxlength" => "500", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying","id" => "qualifying", "label" => "","maxlength" => "500", "type" => "text", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target","maxlength" => "500", "label" => "", "type" => "text", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched", "id" => "stretched","maxlength" => "500", "label" => "", "type" => "text", "required" => True)); ?></td>
                        </tr>
                        <tr>
                            <td class="uk-text-center uk-width-small-1-10">1</td>                            
                                            <td><select>
                                <option value="--select--">--select--</option>
                                <option value="1">Volvo</option>
                                <option value="2">Saab</option>
                                <option value="3">VW</option>
                                <option value="4">Audi</option>
                            </select></td>
                            <td><?php echo $this->Form->input("weightage.", array("class" => "uk-width-medium-1-1 weightage", "id" => "weightage", "maxlength" => "3", "onkeyup" => "return isNumber(this);", "onkeypress" => "return isNumberKey(event)", "label" => "", "type" => "text", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("measure.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "", "type" => "textarea", "maxlength" => "500", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying","id" => "qualifying", "label" => "","maxlength" => "500", "type" => "text", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target","maxlength" => "500", "label" => "", "type" => "text", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched", "id" => "stretched","maxlength" => "500", "label" => "", "type" => "text", "required" => True)); ?></td>
                        </tr>
                    </table>

                </div>

                
                <br></br>
                <div class="uk-grid">
                    <div class="uk-width-1-1"> 
                        <input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();" name="submit" value="Submit">
                        <input type='button' class="md-btn md-btn-primary plusbtn"  value='Add More' id='addButton'>
                        <input type='button' class="md-btn md-btn-danger minusbtn" value='Remove' id='removeButton'>
                    </div>
                </div>
            
            </div>
                          
            
        </div>        
    </div>
</div>

<script type="text/javascript">
    var counter = 2;
    $('.plusbtn').click(function () {

        $("#TextBoxesGroup").append('<tr><?php echo $this->Form->create("addKraTarget"); ?>' +
                '<td class="uk-text-center uk-width-small-1-10">' + counter + '</td>' +
                '<td><?php echo $this->Form->input("kra_name.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "", "type" => "textarea", "maxlength" => "2000", "required" => True)); ?></td>' +                
                '<td><?php echo $this->Form->input("weightage.", array("class" => "uk-width-medium-1-1 weightage", "id" => "weightage", "maxlength" => "3", "onkeyup" => "return isNumber(this);", "onkeypress" => "return isNumberKey(event)", "label" => "", "type" => "text", "required" => True)); ?></td>' +
                '<td><?php echo $this->Form->input("measure.", array("class" => "uk-width-medium-1-1 measure textarea_expand", "label" => "", "type" => "textarea", "maxlength" => "500", "required" => True)); ?></td>' +
                '<td><?php echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying", "id" => "qualifying", "maxlength" => "500", "label" => "", "type" => "text", "required" => True)); ?></td>' +                
                '<td><?php echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target", "maxlength" => "500", "label" => "", "type" => "text", "required" => True)); ?></td>' +
                '<td><?php echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched","id" => "stretched", "maxlength" => "500", "label" => "", "type" => "text", "required" => True)); ?></td>' +
                '</tr>');
        counter++;
    });

    $('.minusbtn').click(function () {
        if ($("#TextBoxesGroup tr").length != 3) {
            $("#TextBoxesGroup tr:last-child").remove();
            counter--;
        }
        else {
            alert("You cannot delete first row");
        }
    });

    


var $selects = $('.table1 tr td select').change(function() {
    if ($selects.find('option[value=' + this.value + ']:selected').length > 1) {
        alert('Option is already selected');
        this.options[0].selected = true;
    }    
});
</script>

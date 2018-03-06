<style>
    .hboxm{
        display: none;
        border: 1px solid #000;
        width: 200px;
        height: auto;
        background-color: #ccc;
        position: absolute;
        min-height: 30px;
        padding:10px;
        z-index: 999;
    }
</style>
<?php $auth = $this->Session->read('Auth'); ?>
<style>
    .uk-dropdown, .uk-dropdown-blank {
        width: auto !important;
    }
</style>
<div id="page_content" role="main">
    <div id="page_content_inner">
        
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                
                               
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                            Income Tax Declaration Forms
                            </h3>
                        </div>
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('IncomeTax', array('url' => array('controller' => 'IncomeTax', 'action' => 'add'), 'id' => 'add', 'name' => 'voucher', 'class' => 'uk-form-stacked')); ?>
                <div class="md-card-content" data-uk-grid-margin>
                    <div class="uk-overflow-container" role="main">
                        <div class="">
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="clearfix"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <?php if (!$decleration) { ?>
                                            <div class="uk-grid">
                                                <!--  <div class="uk-width-medium-1-2">
                                                      <div class="parsley-row">
                                                          <select class="md-input" name="fy_year">
                                                <?php foreach ($financial as $k => $val) { ?>    
                                                                          <option value=<?php echo $k ?>><?php echo $val; ?></option>
                                                <?php } ?>
                                                          </select>
                                                      </div>
                                                  </div>-->
                                                <div class="uk-width-medium-1-2"> </div>
                                                <div class="uk-width-medium-1-2">
                                                    <div class="parsley-row">
                                                        <select class="md-input" name="loc_type">
                                                            <option value="N">Non Metro</option>
                                                            <option value="M"> Metro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php echo $this->Form->input('fy_id', array('id' => "fy_id", 'class' => 'required', 'label' => false, 'type' => 'hidden', 'value' => $financial)); ?>
                                                <div class="clearfix"></div>
                                            </div>
                                            <table class="uk-table uk-text-nowrap table table-striped responsive-utilities jambo_table bulk_action" id = "myTable">
                                                <thead>
                                                    <tr style="background: rgb(51, 153, 255) none repeat scroll 0px 0px;">  
                                                        <th style="color: #fff">Particulars</th>
                                                        <th style="color: #fff">Limit</th>
                                                        <th style="color: #fff">Planned Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='mytbody'>

                                                    <?php
                                                    $i = 0;
                                                    foreach ($investment as $invest) {
                                                        ?>
                                                        <tr>
                                                            <td><span style="font-weight:bold"><?php echo $invest['op2']['name'] ?></span></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
        <?php $section = $this->Common->sectionname($invest['SectDtl']['sect_id']) ?>
                                                        <tr> <td>

        <?php echo '<span style="font-weight:bold">' . $section['OptionAttribute']['name'] . '</span>' ?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php $invest_id = $this->Common->findsection($invest['SectDtl']['sect_id'], $invest['SectDtl']['fy_id']) ?>
                                                        <?php
                                                        foreach ($invest_id as $invest_id) {
                                                            $name = $this->Common->findInvestName($invest_id['InvestDtl']['invest_id']);
                                                            ?>

                                                            <tr >

                                                                <td>
                                                                    <?php
                                                                    if ($invest_id['InvestDtl']['hover_description'] != '') {
                                                                        ?>
                                                                        <div data-uk-dropdown="" class="uk-button-dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span style="font-weight:bold"><?php echo $name['OptionAttribute']['name']; ?><i class="material-icons"></i></span>
                                                                            <div class="uk-dropdown uk-dropdown-bottom" style="min-width: 200px; top: 35px; left: 0px;">
                <?php echo $invest_id['InvestDtl']['hover_description']; ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    } else {
                                                                        echo '<span style="font-weight:bold">' . $name['OptionAttribute']['name'] . '</span>';
                                                                    }
                                                                    ?>

            <?php echo $this->Form->input('Investment_' . $i, array('id' => 'toggleSwitch_j', 'value' => $invest_id['InvestDtl']['invest_id'], 'type' => 'hidden', 'class' => 'required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off')); ?>   
                                                                </td>
                                                                <td><?php echo $invest_id['InvestDtl']['invest_max_limit']; ?></td> 
                                                                <td><?php echo $this->Form->input('planned_' . $i, array('id' => "planned_$i", 'class' => 'md-input required planned', 'label' => false, 'type' => 'text', 'autocomplete' => 'off', 'onkeypress' => "sschangetext($i)")); ?><span id="errmsg_<?php echo $i ?>"></span>

                                                                </td> 
                                                            </tr> 

                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>


    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div class="ln_solid"></div>   
                                            <div class='form-group'> 
    <?php $fwemplist = $this->Common->getHrList($auth['MyProfile']['emp_code']); ?>
    <?php echo $this->Form->input('forwardlvl', array('type' => 'hidden', 'label' => false, 'options' => $fwemplist, 'class' => ' form-control s-form-item s-form-all', 'id' => 'fwlvempcode')); ?>  


                                                <div class="uk-width-1-3 uk-margin-top">
                                                    <input type="button" class="md-btn md-btn-success" value="Apply" name='post_travel' onclick="return post();">  
                                                </div>


                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <h3>You have already declared income tax for this financial year. </h3>
<?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->Form->end(); ?>  
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        //called when key is pressed in textbox

    });
    function changetext(id) {
        var pattern = /^\d+$/;
        $("#planned_" + id).on("keydown", function (e) {
            console.log(e.which);
            if ($("#planned_" + id).val() != '' && !pattern.test($("#planned_" + id).val())) {
                //display error message
                $("#errmsg_" + id).html("Digits Only").show();
                return false;
            }
        });


    }
    function bigImg(x) {
        $("#toggleSwitch_j_" + x).hover(
                function () {
                    $("#theBox_" + x).slideDown(500);
                }, function () {
            $("#theBox_" + x).slideUp(500);
        });
    }

    function post()
    {

        var pattern = /^\d+$/;
        var arr = [];
        $(".planned").each(function (index) {
            
            if ($("#planned_" + index).val() !== '' && !pattern.test($("#planned_" + index).val())) {
                //display error message
                $("#errmsg_" + index).html("Digits Only").show();
                arr[index]= '1';
                //return false;
            } else {
                $("#errmsg_" + index).html("").hide();
                arr[index]= '2';
                //return true;
            }
        });
        //alert(arr);
        //alert(jQuery.inArray('1', arr));
        //return false;
        if (jQuery.inArray('1', arr) != -1) {
            return false;
        } else {
            document.voucher.action = "add";

            document.voucher.submit();
            return true;
        }

        // Submit the page
    }


</script>

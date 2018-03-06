<?php

$encshyear = count($checkencsh);
?>
<?php echo $this->Form->create('leaveencash', array('url' => array('controller' => 'leaves', 'action' => 'leaveencash'), 'id' => 'form_validation', 'class' => 'uk-form-stacked',"onsubmit" => "return checkSubmit();")); ?>
<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Leave Encashment</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">

                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-3">
                        <label>Employee ID </label>
                        <div class="parsley-row">
                            <input type="text" value="<?php echo $emp_id; ?>" class="md-input" disabled />
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <label>Employee Name </label>
                        <div class="parsley-row">
                        <?php
                        $v = $this->Common->option_attribute_name($gender);

                        if ($v[$gender] == 'MALE') {
                            ?>
                            <input type="text" value="<?php echo $emp_name; ?>" class="md-input" disabled /> 
                            <input name="title" type="hidden" value="<?php echo $emp_name; ?>" class="md-input" disabled>
                        <?php } else { ?>
                            <input type="text" value="<?php echo $emp_name; ?>" class="md-input" disabled /> 
                            <input name="title" type="hidden" value="<?php echo $emp_name; ?>" class="md-input" disabled>
                        <?php } ?>
                        <?php echo $this->Form->input('desg', array('label' => 'Employee Name', 'type' => 'hidden', 'value' => $desgcode, 'class' => 'md-input', "disabled")); ?>
                        </div>

                    </div>

                    <div class="uk-width-medium-1-3">
                        <label>Leave  Type :</label>
                        <div class="parsley-row">

                            <select name ='leavetype' id = 'leavetype' class='md-input' data-md-selectize >
                                <!--<option value="----">--Select--</option>    -->
                            <?php foreach ($leavetype as $type) {
                                foreach ($type as $k => $val) {
                                    ?> 
                                <option value="<?php echo $k ?>"><?php echo $val ?></option>
                                <?php }
                            }
                            ?>
                            </select>
                        </div>
                    </div>


                    <span id='leaveajax'></span>

                    <div class="uk-width-medium-1-2"  data-uk-grid-margin>
                        <div class="parsley-row">
                            <?php echo $this->Form->input('noofleavestoencash', array('label' => "Encash Leave *", 'type' => 'text', 'id' => 'leaveencash', 'class' => 'md-input', 'required' => TRUE)); ?> 
                        </div>
                    </div>

                    <div class="uk-grid">
                        <div class="uk-width-1-1 uk-margin-top">
                            <input type="submit" class="md-btn md-btn-success" value="Submit">  

                        </div>
                    </div>

                <?php $this->form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#leaveencashDesg').prop('readonly', true);
        $("#leavetype").change(function () {

            var id = $('#leavetype option:selected').val();
            jQuery.ajax({
                url: '<?php echo $this->webroot ?>leaves/leaveencshajax/' + id,
                success: function (data) {

                    $('#leaveajax').html(data);

                }
            });
        });
        var id = $('#leavetype option:selected').val();
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/leaveencshajax/' + id,
            success: function (data) {
                $('#leaveajax').html(data);
            }
        });
    });

    function checkSubmit()
    {
        var leaveencash = jQuery.trim(jQuery('#leaveencash').val());
        var leaveencashmaxlimit = jQuery('#maxlimit').val();
        var maxlimit = parseInt($('#maxbal').val());
        var leavebalafterencsh = maxlimit - leaveencash;

        var checkencsh = <?php echo $encshyear;?>;
        if (leaveencash === "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Leave to be  Encashed </div>").show();
            return false;
        } else if (checkencsh > 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Leave can be encash once in a year </div>").show();
            return false;
        } else if (leaveencash !== "") {
            var value = leaveencash.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            var intRegex = /^\d+$/;
            //var intRegex = /^\d+(\.\d{0,2})?$/;
            //var intRegex = /^(?!0)\d+(\.\d{0,2})?$/;
            if (!intRegex.test(value)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Leave Field must be integer.</div>").show();
                return false;
            } else if (leaveencash < 15) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Min 15 Leave can be Encashed.</div>").show();
                return false;

            } else if (maxlimit < 90) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Your Leave Balance is Less 90.</div>").show();
                return false;
            } else if (leaveencash % 15 !== 0) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>You can Encash Leave in multiple of 15.</div>").show();
                return false;
            } else if (jQuery.trim(leaveencash) > jQuery.trim(leaveencashmaxlimit)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Leave Encashed Exceed Maximum limit. </div>").show();
                return false;
            } else if (leavebalafterencsh < 90) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Your Leave Balance Should not go below 90.</div>").show();
                return false;
            } else if (maxlimit < leaveencash) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Your Opening Balance is not sufficient to apply Leave Encash </div>").show();
                return false;
            }
        }

    }


    function checkSubmit1()
    {
        var leaveencash = jQuery.trim(jQuery('#leaveencash').val());
        var leaveencashmaxlimit = jQuery('#maxlimit').val();
        var maxlimit = parseInt($('#maxbal').val());

        var checkencsh = <?php echo $encshyear;?>;
        if (leaveencash === "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Leave to be  Encashed </div>").show();
            return false;
        } else if (checkencsh > 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Leave can be encash once in a year </div>").show();
            return false;
        } else if (leaveencash !== "") {
            var value = leaveencash.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            //var intRegex = /^\d+$/;
            var intRegex = /^\d+(\.\d{0,2})?$/;
            //var intRegex = /^(?!0)\d+(\.\d{0,2})?$/;
            if (value == 0 || value == 0.00) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Bill Amount Field can not be zero.</div>").show();
                return false;
            }
            if (!intRegex.test(value)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Bill Amount Field must be numeric and it allow up to two decimal digit.</div>").show();
                return false;
            } else if (jQuery.trim(leaveencash) > jQuery.trim(leaveencashmaxlimit)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Leave Encashed Exceed Maximum limit </div>").show();
                return false;

            } else if (maxlimit < leaveencash) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Your Opening Balance is not sufficient to apply Leave Encash </div>").show();
                return false;
            }
        }

    }
</script>

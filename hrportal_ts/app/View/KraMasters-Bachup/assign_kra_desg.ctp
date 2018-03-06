<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Assign KRA</h2>
                        <div class="clearfix"></div>
                    </div>
                    <?php
             echo $this->Form->create('Kra', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'KraMasters', 'action' => 'kraKpiDesginationSave'), 'id' => 'addkra', 'name' => 'addkra'));
        ?>

                    <div class="x_content">
                        <br>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Position/Designation<span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->Form->input('designation_id', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $designation, 'class' => 'form-control col-md-4 col-xs-12')); ?>
                                    <input type="hidden" name="appid" value="<?php echo $appId; ?>" id="appid">
                                </div>
                            </div>
                            <div id="empselect">
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Start Date(y-m-d)<span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->form->input('kr_start_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 krDate",'type' => 'text', 'id' => 'startdate','readonly'=>true)); ?>
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">End Date(y-m-d)<span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->form->input('kr_end_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 krDate",'type' => 'text', 'id' => 'enddate','readonly'=>true)); ?>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group col-md-1 col-sm-6 col-xs-6">
                                <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                                    <input type="submit" class="btn btn-success" value="Submit">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"> jQuery(function () {
        jQuery('.krDate').datepicker({inline: true, changeMonth: true, changeYear: true, format: 'yyyy-mm-dd'});
    });</script>

<script>
    function chkForm(idd) {
        s = "p";
        str1 = "Please Select Department.\n";
        str2 = "Please Select KRA.\n";
        str3 = "Please Select Start Date.\n";
        str4 = "Please Select End Date.\n";
        str5 = "Please Select Employee Name.\n";

        if ((document.getElementById('KraDepartmentId').value == ""))
            s = s.concat(str1);

        if ((document.getElementById('kralist').value == ""))
            s = s.concat(str2);

        if ((document.getElementById('startdate').value == ""))
            s = s.concat(str3);

        if ((document.getElementById('enddate').value == ""))
            s = s.concat(str4);

        if (s != null)
        {
            if (s == 'p')
            {
                return true;
            } else
            {
                alert(s.substring(1, s.length));
                return false;
            }
        }

    }
</script>
<script>
    $('#KraDesignationId').change(function () {
        var dept = $("#KraDesignationId option:selected").val();

        var app = $('#appid').val();
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>kraMasters/levelKra/' + dept + '/' + app,
            success: function (data) {
                jQuery('#empselect').html(data);
            }
        });
    });

</script>
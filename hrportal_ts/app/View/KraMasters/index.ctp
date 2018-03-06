
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>PMS Master</li>
            <li>Update Configurations</li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Update Configurations<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('KraMasters', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>

                    <th width="253" scope="row"><strong>Company Name :</strong>  </th>
                    <?php $company = $this->Common->findCompanyName();
                    ?>
                    <td><?php echo $this->Form->input('comp_code', array('type' => 'select', "required" => True, 'options' => $company, 'empty' => 'Select Company Name', 'class' => 'round_select', 'id' => 'companyName')); ?>
                       <div id="dnameErr1" style="color:red"></div>
                    </td>
                </tr>
				
			
				
				<tr>
                    <th width="253" scope="row"><strong>Annual Appraisal Calculation Type:</strong>  </th>
                    <td>
					<?php echo $this->Form->input("Type", array("type" => "radio","id" => "calculation","name" => "data[KraMasters][calculation]","class" => "uk-width-medium-1-1 calculation","options" => array("1"=>"On the basis of Average Score","2"=>"On the basis of Total Score"), "default" => 1, "separator" => "<br>", "required" => True)); ?>
					<div id="dnameErr2" style="color:red"></div>
				
                    </td>
                </tr>
				
				
                <tr>
                    <th width="253" scope="row"><strong>HR/Admin Name (to be put in Cc):</strong>  </th>
                    <td><?php echo $this->Form->input('hr_name', array('class' => 'round_select', 'id' => 'appName', 'maxLength' => 90)); ?>
                        <div id="dnameErr3" style="color:red"></div>
                    </td>
                </tr>
				<tr>
                    <th width="253" scope="row"><strong>Mid Review Process (Halfyearly) :</strong>  </th>
                    <td>
					<?php echo $this->Form->input("mid_review", array("type" => "radio","id" => "mid_review","name" => "data[KraMasters][mid_review]","class" => "uk-width-medium-1-1 mid_review","options" => array("1"=>"Yes","2"=>"No"), "default" => 2, "separator" => "<br>", "required" => True)); ?>
					<div id="dnameErr3" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>
                            <?php echo $this->Form->button('Reset', array('type' => 'reset', 'class' => 'infoButton')); ?>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    <?php
    echo $this->Form->end();
    ?>
</div>

<div id="list_msg_div1">
    <h2 class="demoheaders">View Config Listing by Company</h2>
    <div class="travel-voucher1" style="min-height: 300px;">
        <div class="input-boxs">
            <div id="result"></div>                
        </div>
    </div>
    <div id="files"></div>
</div>
</div>


<script>
    jQuery(document).ready(function () {
        lists();
        // Delete function 
        jQuery("#delete").live('click', function () {
            var id = jQuery(this).attr('mid');
            if (confirm("Are you sure you want to delete?")) {
                jQuery("#overlay").show();
                jQuery.get('<?php echo $this->webroot; ?>KraMasters/delete/' + id, {}, function (data) {
                    if (data) {
                        jQuery("#overlay").hide();
                        createMsg(data.msg, data.type);
                        lists();
                    }
                }, 'json').error(function (e) {
                    alert("Error Occured : " + e.statusText);
                    jQuery("#overlay").hide();
                });
            }

        });

        // Edit Funtion
        jQuery("#edit").live('click', function () {
            var id = jQuery(this).attr('mid');
            jQuery("#appName" + id).val();
            jQuery("#appCode" + id).val();

            jQuery("#vw" + id).hide();
            jQuery("#update" + id).show();
        });

        /// Cancel Function
        jQuery("#cancel").live('click', function () {
            var id = jQuery(this).attr('mid');
            jQuery("#vw" + id).show();
            jQuery("#update" + id).hide();
        });

        // Save Function
        jQuery("#save").live('click', function () {
            var id = jQuery(this).attr('mid');
            var err = 0;
            var appName = jQuery("#appName" + id).val();
            var appName1 = jQuery("#appName1" + id).val();
            if (appName == '') {
                jQuery("#dcnameErr" + id).html("Enter Travel Mode Name.");
                jQuery("#appName" + id).focus();
                err++;
                return false;
            }

            if (err == 0) {
                jQuery("#appName" + id).removeAttr('disabled');
                jQuery("#appName" + id).val(appName);
                jQuery("#appName" + id).attr('disabled', true);
                jQuery("#overlay").show();
                var fdata = {'data[MstTravelMode][name]': appName};
                jQuery.post('<?php echo $this->webroot ?>travelmodes/edit/' + id, fdata, function (data) {
                    if (data) {
                        createMsg(data.msg, data.type);
                        jQuery("#overlay").hide();
                        if (data.type == 'success') {
                            jQuery("#vw" + id).show();
                            jQuery("#update" + id).hide();
                        }
                        lists();
                        return false;

                    }
                }, 'json').error(function (e) {
                    alert("Error : " + e.statusText);
                    jQuery("#overlay").hide();
                });
            } else {
                return false;
            }

        });
    });
    /*Add record script*/

    jQuery("#add").click(function () {
        doChk();
    });

    jQuery("form[name='msgForm']").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            doChk();
            return false;
        } else {

        }
    });

    jQuery('.navigation').find('a').live('click', function (e) {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';

        jQuery("#result").html(data);
        //
        var fdata = jQuery("#searchForm").serialize();
        current_page = jQuery(this).attr('href');
        jQuery.post(current_page, fdata, function (data) {
            jQuery("#result").html(data);

        }, 'html');
        return false;
    });

    jQuery('.head').find('a').live('click', function (e) {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
        jQuery("#result").html(data);
        var fdata = jQuery("#searchForm").serialize();
        current_page = jQuery(this).attr('href');

        jQuery.post(current_page, fdata, function (data) {
            jQuery("#result").html(data);

        }, 'html');
        return false;
    });



    function lists() {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
        jQuery("#result").html(data);
        var fdata = jQuery("#searchForm").serialize();
        jQuery.post('<?php echo $this->webroot; ?>KraMasters/lists',
                fdata,
                function (data) {

                    jQuery("#result").html(data);

                }, 'html'
                ).error(function (e) {
            alert("Error : " + e.statusText);
        });
    }

</script>
<script>

    jQuery(document).ready(function () {

        jQuery("#remove").live('click', function () {
            var vl = [];
            var f;
            var ln = jQuery("input[class='vl']:checked").length;


            if (ln == 0) {
                alert("Please checked atleast one record.");
                return false;
            } else {
                jQuery("input[class='vl']:checked").each(function () {
                    vl.push(parseInt(jQuery(this).val()));

                });
                if (confirm("Are you sure to delete selected records?")) {
                    jQuery("#overlay").show();
                    jQuery.post('<?php echo $this->webroot; ?>/messages/multiDelete', {vl: vl}, function (data) {
                        if (data) {
                            createMsg(data.msg, data.type);
                            lists();
                            jQuery("#overlay").hide();
                        }

                    }, 'json');
                }
                return false;
            }

        });

        jQuery("#ch").live('click', function () {
            var ch = jQuery(this).attr('checked');
            if (ch) {
                jQuery(".vl").each(function () {
                    jQuery(this).attr('checked', true);
                });

            } else {
                jQuery(".vl").each(function () {
                    jQuery(this).attr('checked', false);
                });

            }
        });

    });

    function doChk() {
        var err = 0;
        var companyName = jQuery.trim(jQuery("#companyName").val());
		var calculation = jQuery.trim(jQuery("input[name='data[KraMasters][calculation]']:checked").val());
		var appName = jQuery.trim(jQuery("#appName").val());

        if (companyName == '') {
            jQuery("#dnameErr1").html("<?php echo "Please Select Company Name."; ?>");
            jQuery("#companyName").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr1").html("");
        }
		if (calculation == '') {
            jQuery("#dnameErr2").html("<?php echo "Please Select Annual Appraisal Calculation Type."; ?>");
            jQuery("#calculation").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr2").html("");
        }
		if (appName == '') {
            jQuery("#dnameErr3").html("<?php echo "Please Enter HR/Admin email ID."; ?>");
            jQuery("#appName").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr3").html("");
        }
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>KraMasters/add/', fdata, function (data) {
                if (data) {
                    //alert("vivek");alert(data.msg);alert(data.type);return false;
                    createMsg(data.msg, data.type);
                    jQuery("#overlay").hide();
                    lists();

                    if (data.type == 'success') {
                        jQuery("#appName ").val('');
                        jQuery("#appCode ").val('');
                        return false;
                    }
                }
            }, 'json').error(function (e) {
                alert("Error : " + e.statusText);
                jQuery("#overlay").hide();
            });

        } else {
            return false;
        }
    }

</script>	

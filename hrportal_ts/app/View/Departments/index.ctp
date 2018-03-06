
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Masters
            </li>
            <li>
                Department Master
            </li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Department<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('Departments', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
    $company_name = array('Eastern Software Systems', 'Google', 'Microsoft');
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                    <?php $company = $this->Common->findCompanyName(); ?>
                    <th width = "253" scope="row"><strong>Company Name :</strong>  </th>
                    <td><?php echo $this->Form->input('company_name', array('type' => 'select', 'options' => $company, 'empty' => 'Select Company', 'class' => 'round_select', 'id' => 'companyName')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                    <th scope="row"><strong>Department Name :</strong>  </th>
                    <td><?php echo $this->Form->input('dept_name', array('class' => 'round_select', 'id' => 'appName')); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                    <th scope="row"><strong>Department Code :</strong>  </th>
                    <td><?php echo $this->Form->input('dept_code', array('class' => 'round_select', 'id' => 'deptCode')); ?>
                        <div id="dCodeErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <div align="center" class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>
                            &nbsp; 	&nbsp; 	&nbsp; 	&nbsp; 
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
    <h2 class="demoheaders">Departments List</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>departments/delete/' + id, {}, function (data) {
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
            if (appName == '') {
                jQuery("#dnameErr" + id).html("Enter Department Name.");
                jQuery("#appName" + id).focus();
                err++;
                return false;
            }
            var deptCode = jQuery("#deptCode" + id).val();
            if (deptCode == '') {
                jQuery("#dcodeErr" + id).html("Enter Department Code.");
                jQuery("#deptCode" + id).focus();
                err++;
                return false;
            }
            if (err == 0) {
                jQuery("#appName1" + id).removeAttr('disabled');
                jQuery("#appName1" + id).val(appName);
                jQuery("#appName1" + id).attr('disabled', true);
                jQuery("#deptCode1" + id).removeAttr('disabled');
                jQuery("#deptCode1" + id).val(appName);
                jQuery("#deptCode1" + id).attr('disabled', true);

                jQuery("#overlay").show();
                //var fdata=jQuery('#deptFrm').serialize();
                var fdata = {'data[Departments][dept_name]': appName, 'data[Departments][dept_code]': deptCode};
                //fdata ={'data[Departments][dept_code]':deptCode};
                //fdata=fdata + fdepdata;
                //alert(fdata);
                jQuery.post('<?php echo $this->webroot ?>departments/edit/' + id, fdata, function (data) {
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

        jQuery.post('<?php echo $this->webroot; ?>departments/lists',
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
        var appName = jQuery.trim(jQuery("#appName").val());
        var deptCode = jQuery.trim(jQuery("#deptCode").val());
        var compName = jQuery.trim(jQuery("#companyName option:selected").text());
        if (compName == 'Select Company') {
            jQuery("#dCnameErr").html("<?php echo "Please input company name."; ?>");
            jQuery("#dCnameErr").focus();
            err++;
            return false;
        } else {
            jQuery("#dCnameErr").html("");
        }
        if (appName == '') {
            jQuery("#dnameErr").html("<?php echo "Please input department name."; ?>");
            jQuery("#dnameErr").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr").html("");
        }
        if (deptCode == '') {
            jQuery("#dCodeErr").html("<?php echo "Please input department Code."; ?>");
            jQuery("#dCodeErr").focus();
            err++;
            return false;
        } else {
            jQuery("#dCodeErr").html("");
        }
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>departments/add/', fdata, function (data) {
                if (data) {
                    //alert("vivek");alert(data.msg);alert(data.type);return false;
                    createMsg(data.msg, data.type);
                    jQuery("#overlay").hide();
                    lists();

                    if (data.type == 'success') {
                        jQuery("#companyName ").val('Select Company');
                        jQuery("#appName ").val('');
                        jQuery("#deptCode ").val('');
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

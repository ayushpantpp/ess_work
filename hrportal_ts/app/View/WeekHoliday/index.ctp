
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>Week Holiday Management</li>
            <li>Add Week Holiday</li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Week Holiday<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('WeekHoliday', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="97%" cellspacing="10" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                    <?php $company = $this->Common->findCompanyName();?>
                    <th scope="row"><strong>Select Organization :</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type'=>'select','options'=>$company,'empty'=>'Select Company','class' => 'round_select', 'id' => 'org_name')); ?>
                        <div id="dorgnameErr" style="color:red"></div>
                    </td>
                </tr>
                 <tr>
                    <?php 


                    $emp_group = $this->Common->findEmployeeName();?>
                    <th scope="row"><strong>Select Employee Group :</strong>  </th>
                    <td><?php echo $this->Form->input('emp_group', array('type'=>'select','options'=>$emp_group,'empty'=>'Select Employee Group','class' => 'round_select', 'id' => 'emp_group_id')); ?>
                        <div id="dempnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    
                </tr>
                <tr>
                    <th width="253" scope="row"><strong>Day :</strong>  </th>
                    <td><?php
                        echo $this->Form->input('day_code', array('type' => 'select', 'class' => 'round_select', 'id' => 'appName', 'options' => $weekdays, 'empty' => 'Select weekdays'
                        ));
                        ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                    <th scope="row"><strong>Occurence :</strong>  </th>
                    <td>
                        <?php echo $this->Form->input('first', array('type' => 'checkbox','id'=>'c1')); ?> &nbsp; First &nbsp;
                        <?php echo $this->Form->input('second', array('type' => 'checkbox','id'=>'c2')); ?> &nbsp; Second &nbsp;
                        <?php echo $this->Form->input('third', array('type' => 'checkbox','id'=>'c3')); ?> &nbsp; Third &nbsp;
                        <?php echo $this->Form->input('fourth', array('type' => 'checkbox','id'=>'c4')); ?> &nbsp;Fourth &nbsp;
                        <?php echo $this->Form->input('fifth', array('type' => 'checkbox','id'=>'c5')); ?> &nbsp; Fifth &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>
                            <?php echo $this->Form->button('Reset', array('type' => 'reset','onclick'=>'location.reload();', 'class' => 'resetButton')); ?>
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
    <h2 class="demoheaders">Week Off List</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>week_holidays/delete/' + id, {}, function (data) {
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
                jQuery("#dcnameErr" + id).html("Enter Holiday Date.");
                jQuery("#appName" + id).focus();
                err++;
                return false;
            }

            if (err == 0) {
                jQuery("#appName" + id).removeAttr('disabled');
                jQuery("#appName" + id).val(appName);
                jQuery("#appName" + id).attr('disabled', true);
                jQuery("#overlay").show();
                jQuery("#appName1" + id).removeAttr('disabled');
                jQuery("#appName1" + id).val(appName);
                jQuery("#appName1" + id).attr('disabled', true);
                jQuery("#overlay").show();
                var fdata = {'data[Holiday][holiday_name]': appName, 'data[Holiday][holiday_date]': appName1};
                jQuery.post('<?php echo $this->webroot ?>holidays/edit/' + id, fdata, function (data) {
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
        jQuery.post('<?php echo $this->webroot; ?>week_holidays/lists',
                fdata,
                function (data) {

                    jQuery("#result").html(data);

                }, 'html'
                ).error(function (e) {
            alert("Error : " + e.statusText);
        });
    }
    
    function get_location() {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
        jQuery("#result").html(data);
        var fdata = jQuery("#searchForm").serialize();
        jQuery.post('<?php echo $this->webroot; ?>week_holidays/get_location',
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
 var dName = jQuery.trim(jQuery("#org_name").val());
        if (dName == '') {
            jQuery("#dorgnameErr").html("<?php echo "Please select Company."; ?>");
            jQuery("#org_name").focus();
            err++;
            return false;
        } else {
            jQuery("#dorgnameErr").html("");
        }
        var empName = jQuery.trim(jQuery("#emp_group_id").val());
        if (empName == '') {
            jQuery("#dempnameErr").html("<?php echo "Please select employee group."; ?>");
            jQuery("#emp_group_id").focus();
            err++;
            return false;
        } else {
            jQuery("#dempnameErr").html("");
        }
        var appName = jQuery.trim(jQuery("#appName").val());
        if (appName == '') {
            jQuery("#dnameErr").html("<?php echo "Please select day."; ?>");
            jQuery("#appName").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr").html("");
        }
var chkd = document.msgForm.c1.checked || document.msgForm.c2.checked || document.msgForm.c3.checked || document.msgForm.c4.checked;
if (chkd == true) {}
    else {
        alert ("please check at least one  checkbox");
        return false;
    }

        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>week_holidays/add/', fdata, function (data) {
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

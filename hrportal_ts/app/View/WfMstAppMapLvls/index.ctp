
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>Set Work Flow Level Master</li>
            <li>Set Work Flow Level</li>            
        </ul>
    </div>
</div>
<br>
<div id="add_msg_div">
    <h2 class="demoheaders">Add Maximum Work Flow Level<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('WfMstAppMapLvl', array('action' => 'add', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">

                <tr>

                    <th width="253" scope="row"><strong>Company Name :</strong>  </th>
                    <?php $company = $this->Common->findCompanyName();
                    ?>
                    <td><?php echo $this->Form->input('comp_code', array('type' => 'select', 'options' => $company, 'empty' => 'Select Company', 'class' => 'round_select', 'id' => 'companyName', 'onChange' => 'findDepartment(this.value);')); ?>
                        <div id="cnameErr" style="color:red"></div>
                    </td>
                </tr>

                <tr>

                    <th scope="row"><strong>Department Name :</strong>  </th>
                    <td><?php echo $this->Form->input('dept_code', array('type' => 'select', 'options' => '', 'empty' => 'Select Department', 'class' => 'round_select', 'id' => 'departmentName')); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>    
                    <th scope="row"><strong>Application Name :</strong>  </th>
                    <?php $application = $this->Common->getApplicationList(); ?>
                    <td><?php echo $this->Form->input('app_code', array('type' => 'select', 'options' => $application, 'empty' => 'Select Application', 'class' => 'round_select', 'id' => 'applicationName')); ?>
                        <div id="anameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>                   
                    <th scope="row"><strong>Max Work Flow Level :</strong>  </th>
                    <td><?php echo $this->Form->input('max_lvl', array('class' => 'round_select', 'id' => 'max_lvl')); ?>
                        <div id="mnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>                   
                    <th scope="row"><strong>HR Approval Required? :</strong>  </th>
                    <td><?php echo $this->Form->input('wf_hr_approval', array('id' => 'wf_hr_approval', 'type' => 'checkbox')); ?>
                        <div id="mnameErr" style="color:red"></div>
                    </td>
                    <th><strong>Manager Approval Required? :</strong>  </th>
                    <td><?php echo $this->Form->input('manager_approval', array('id' => 'manager_approval', 'type' => 'checkbox')); ?>
                        <div id="mnameErr" style="color:red"></div>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>  
                            <?php echo $this->Form->button('Search', array('type' => 'button', 'id' => 'search', 'class' => 'successButton')); ?>                             
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
    <h2 class="demoheaders">Max Work Flow List </h2>
    <div class="travel-voucher1" style="min-height: 300px;">
        <div class="input-boxs">

            <div id="result"></div>


        </div>
    </div>
<div id="files"></div>
</div>

<script>
    jQuery(document).ready(function () {
        lists();
        // Delete function 
        jQuery("#delete").live('click', function () {
            var id = jQuery(this).attr('mid');
            if (confirm("Are you sure you want to delete?")) {
                jQuery("#overlay").show();
                jQuery.get('<?php echo $this->webroot; ?>wfmstappmaplvls/delete/' + id, {}, function (data) {
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
            var maxlvl = jQuery("#appName" + id).val();
            if ($("#appName_hr" + id).is(':checked') == true)
                var hr_approval = 1;
            else
                var hr_approval = 0;
            if (maxlvl == '') {
                jQuery("#dCodeErr" + id).html("Enter max level.");
                err++;
                return false;
            }
            if (err == 0) {
                jQuery("#appName" + id).removeAttr('disabled');
                jQuery("#appName" + id).val(maxlvl);
                jQuery("#appName" + id).attr('disabled', true);
                jQuery("#overlay").show();
                var fdata = {'data[wf_max_lvl]': maxlvl, 'data[wf_id]': id, 'data[wf_hr_approval]': hr_approval};

                jQuery.post('<?php echo $this->webroot ?>WfMstAppMapLvls/edit/' + id, fdata, function (data) {
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
      jQuery("#search").click(function () {
        var org_id = jQuery.trim(jQuery("#companyName").val());
        search();
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
        jQuery.post('<?php echo $this->webroot; ?>WfMstAppMapLvls/lists',
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
        //alert("e2");
        var err = 0;
        var companyName = jQuery("#companyName").val();
        var departmentName = jQuery("#departmentName").val();
        var appName = jQuery("#applicationName").val();
        var max_lvl = jQuery("#max_lvl").val();
        //alert("e3 "+companyName+" e4 "+departmentName+" e5 "+appName+" e6 "+desgCode);

        if (companyName == '') {
            jQuery("#cnameErr").html("<?php echo "Please select Company name."; ?>");
            jQuery("#cnameErr").focus();
            err++;
            return false;
        } else {
            jQuery("#cnameErr").html("");
        }
        if (departmentName == '') {
            jQuery("#dnameErr").focus();
            jQuery("#dnameErr").html("<?php echo "Please select Department name."; ?>");
            err++;
            return false;
        } else {
            jQuery("#dnameErr").html("");
        }
        if (appName == '') {
            jQuery("#anameErr").html("<?php echo "Please select Application name."; ?>");
            jQuery("#anameErr").focus();
            err++;
            return false;
        } else {
            jQuery("#anameErr").html("");
        }
        if (max_lvl == '' && max_lvl <= '0') {
            jQuery("#mnameErr").html("<?php echo "Please input Maximum Level."; ?>");
            jQuery("#mnameErr").focus();
            err++;
            return false;
        } else {
            jQuery("#mnameErr").html("");
        }


        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>WfMstAppMapLvls/add/', fdata, function (data) {
                if (data) {
                    //alert("vivek");alert(data.msg);alert(data.type);return false;
                    createMsg(data.msg, data.type);
                    jQuery("#overlay").hide();
                    lists();

                    if (data.type == 'success') {
                        jQuery("#companyName").val('Select Company');
                        jQuery("#departmentName").val('Select Department');
                        jQuery("#applicationName").val('');
                        jQuery("#max_lvl").val('');
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
 function search() {
                     var err = 0;
       var appName = jQuery.trim(jQuery("#appName").val());

    
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();
            
             jQuery.post('<?php echo $this->webroot; ?>WfMstAppMapLvls/lists/',
                fdata,
                function(data) {
                    
                    jQuery("#result").html(data);
                    jQuery("#overlay").hide();                    
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });
        }




      }
  
    function findDepartment(comp_code)
    {
        $.ajax({
            type: "GET",
            cache: false,
            url: "<?php echo $this->webroot; ?>designations/getDepartment/" + comp_code,
            success: function (data) {
                data = jQuery.parseJSON(data);
                var list = '';
                jQuery("#departmentName").html();
                list += "<option value='' >Select Department Name</option>";
                $.each(data, function (index, value) {
                    list += "<option value='" + index + "'>" + value + "</option>";
                });
                jQuery("#departmentName").html(list);
            }
        });
    }
</script>	
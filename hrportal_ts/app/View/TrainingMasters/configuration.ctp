
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
               Training Configuration Management
            </li>
            <li>
                Training Configuration Master
            </li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Flash Configuration<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('TrainingMasters', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
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
                    <th scope="row"><strong>Email :</strong>  </th>
                    <td><?php echo $this->Form->input('email_check', array('id' => 'email_check', 'type' => 'checkbox')); ?>
                        <div id="memailErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                      <th scope="row"><strong>SMS :</strong>  </th>
                    <td><?php echo $this->Form->input('sms_check', array('id' => 'sms_check', 'type' => 'checkbox')); ?>
                        <div id="msmsErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                    <th scope="row"><strong>Open Attendance Flash Time :</strong>  </th>
                    <td><?php echo $this->Form->input('open_attendance_hour', array('class' => 'open_hour', 'id' => 'open_hour')); ?><span>hour</span>
                      <div id="mopenhErr" style="color:red"></div>
                    </td>
                    
                    <td><?php echo $this->Form->input('open_attendance_min', array('class' => 'round_select', 'id' => 'open_min')); ?><span>Min</span>
                        <div id="mopnemErr" style="color:red"></div>
                    </td>
                </tr>
                    <tr>

                    <th scope="row"><strong>Close Attendance Flash Time :</strong>  </th>
                    <td><?php echo $this->Form->input('close_attendance_hour', array('class' => 'round_select', 'id' => 'close_hour')); ?> <span>hour</span>            
                    </td>
                     <div id="mclosehErr" style="color:red"></div>
                    <td><?php echo $this->Form->input('close_attendance_min', array('class' => 'round_select', 'id' => 'close_min')); ?><span>Min</span>
                         <div id="mclosemErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <div align="center" class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>
                          
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
    <h2 class="demoheaders">Configuration List</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>TrainingMasters/delete/' + id, {}, function (data) {
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
                var fdata = {'data[TrainingCongfig][dept_name]': appName, 'data[Departments][dept_code]': deptCode};
                //fdata ={'data[Departments][dept_code]':deptCode};
                //fdata=fdata + fdepdata;
                //alert(fdata);
                jQuery.post('<?php echo $this->webroot ?>TrainingMasters/configEdit/' + id, fdata, function (data) {
                    if (data) {
                        alert(data);
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

        jQuery.post('<?php echo $this->webroot; ?>TrainingMasters/configList',
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
        var openhour = jQuery.trim(jQuery("#open_hour").val());
        var openmin = jQuery.trim(jQuery("#open_min").val());
        var closehour = jQuery.trim(jQuery("#close_hour").val());
        var closemin = jQuery.trim(jQuery("#close_min").val());
        var compName = jQuery.trim(jQuery("#companyName option:selected").text());
        if (compName == 'Select Company') {
            jQuery("#dCnameErr").html("<?php echo "Please input company name."; ?>");
            jQuery("#dCnameErr").focus();
            err++;
            return false;
        } else {
            jQuery("#dCnameErr").html("");
        }
        if (openhour == '') {
            jQuery("#dopenhErr").html("<?php echo "Please Enter Open Hour"; ?>");
           err++;
            return false;
        }
        if (openmin == '') {
            jQuery("#dopenmErr").html("<?php echo "Please input Open Min."; ?>");
          err++;
            return false;
        } 
        if (closehour == '') {
            jQuery("#dclosehErr").html("<?php echo "Please Enter Close Hour."; ?>");
           err++;
        } 
        if (err == 0) {
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>TrainingMasters/configAdd/', fdata, function (data) {
                if (data) {
                    alert(data);
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
                alert('hello');
                jQuery("#overlay").hide();
            });

        } else {
            return false;
        }
    }

</script>	

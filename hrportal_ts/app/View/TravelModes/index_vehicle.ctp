
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>Vehicle Management</li>
            <li> Add Vehicle   </li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Vehicle<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('MstVehicleMode', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>

                    <th width="253" scope="row"><strong>Company Name :</strong>  </th>
                    <?php $company = $this->Common->findCompanyName();
                    ?>
                    <td><?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company, 'empty' => 'Select Company Name', 'class' => 'round_select', 'id' => 'companyName')); ?>
                        <div id="dCCnameErr" style="color:red"></div>
                    </td>
                </tr>
                
                <tr>
                    <th width="253" scope="row"><strong>Vehicle Type :</strong>  </th>
                    <td><?php echo $this->Form->input('vehical_name', array('class' => 'round_select', 'id' => 'appName', 'maxLength' => 90)); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add_vehicle', 'class' => 'successButton')); ?>
                           
                            <?php echo $this->Form->button('search', array('type' => 'button', 'id' => 'search', 'class' => 'successButton')); ?>
                             <?php echo $this->Form->button('Reset', array('type' => 'reset', 'onclick'=>'location.reload();', 'class' => 'infoButton')); ?>
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
    <h2 class="demoheaders">Vehicle  Mode List</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>travelmodes/delete_vehicle/' + id, {}, function (data) {
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
            var org_id = jQuery("#org_id" + id).val();
            if (appName == '') {
                jQuery("#dcnameErr" + id).html("Enter Vehicle  Name.");
                jQuery("#appName" + id).focus();
                err++;
                return false;
            }

            if (err == 0) {
                jQuery("#appName" + id).removeAttr('disabled');
                jQuery("#appName" + id).val(appName);
                jQuery("#org_id" + id).val(org_id);
                jQuery("#appName" + id).attr('disabled', true);
                jQuery("#overlay").show();
                var fdata = {'data[MstVehicleMode][name]': appName,'data[MstVehicleMode][org_id]': org_id,};
                jQuery.post('<?php echo $this->webroot ?>travelmodes/edit_vehicle/' + id, fdata, function (data) {
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



    jQuery("#add_vehicle").click(function () {
        var org_id = jQuery.trim(jQuery("#org_id").val());
        doChk();
    });

  jQuery("#search").click(function () {
        var org_id = jQuery.trim(jQuery("#org_id").val());
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
        jQuery.post('<?php echo $this->webroot; ?>TravelModes/vehicle_lists',
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
        var company=jQuery.trim(jQuery("#companyName").val());

if(company=='')
{
     jQuery("#dCCnameErr").html("<?php echo "Please Select company Name."; ?>");
            jQuery("#companyName").focus();
            err++;
            return false;
        } else {
            jQuery("#dCCnameErr").html("");
        }  

        var appName = jQuery.trim(jQuery("#appName").val());

        if (appName == '') {
            jQuery("#dnameErr").html("<?php echo "Please Enter  Vehicle Type."; ?>");
            jQuery("#appName").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr").html("");
        }
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();
            
            jQuery.post('<?php echo $this->webroot ?>TravelModes/add_vehicle/', fdata, function (data) {
                if (data) {
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
 function search() {
                     var err = 0;
        var appName = jQuery.trim(jQuery("#appName").val());

    
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();
            
             jQuery.post('<?php echo $this->webroot; ?>TravelModes/vehicle_lists/',
                fdata,
                function(data) {
                    
                    jQuery("#result").html(data);
                    jQuery("#overlay").hide();                    
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });
        }




      }

</script>   





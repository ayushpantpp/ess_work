
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>Holiday Management</li>
            <li>Add Holiday </li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Holiday<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('Holiday', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                   <?php $company = $this->Common->findCompanyName();?>
                    <th scope="row"><strong>Select Organization :</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type'=>'select','options'=>$company,'empty'=>'Select Company','class' => 'round_select', 'id' => 'org_name','onchnage'=>'return get_location();')); ?>
                        <div id="OnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <?php $type_loc = $this->Common->findholidayLocationName();?>
                    <th scope="row"><strong>Select Location :</strong>  </th>
                    <td><?php 
                        array_unshift($type_loc, "All");
                    echo $this->Form->input('location_id', array('type'=>'select','options'=>$type_loc,'empty'=>'Select Location','class' => 'round_select', 'id' => 'location_id')); ?>
                        <div id="dlocErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                    <th width="253" scope="row"><strong>Holiday Name :</strong>  </th>
                    <td><?php echo $this->Form->input('holiday_name', array('class' => 'round_select', 'id' => 'appName', 'maxLength' => 90)); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong>Holiday Date :</strong>  </th>
                    <td><?php echo $this->Form->input('holiday_dates', array('class' => 'round_select', 'id' => 'appCode', 'maxLength' => 30,'readonly'=>true)); ?>
                        <div id="dateErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong>Is it optional :</strong>  </th>
                    <td><?php 
                    $list = array('0'=>'No','1'=>'Yes');
                    echo $this->Form->input('op_leave', array('id' => 'appOptional','type'=>'select', 'options'=>$list)); 
                    ?>
                        <div id="dcodeErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>
  <?php echo $this->Form->button('Search', array('type' => 'button', 'id' => 'search', 'class' => 'successButton')); ?>
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
    <h2 class="demoheaders">Holidays List</h2>
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
        jQuery("#appCode").datepicker({
            inline: true,
            changeMonth: true,
            autoclose: true,
            minDate: 'today',
            //changeYear: true,
            format: 'dd-mm-yyyy'

        });
        
        lists();
        // Delete function 
        jQuery("#delete").live('click', function () {
            var id = jQuery(this).attr('mid');
            if (confirm("Are you sure you want to delete?")) {
                jQuery("#overlay").show();
                jQuery.get('<?php echo $this->webroot; ?>holidays/delete/' + id, {}, function (data) {
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
            jQuery("#appOptional" + id).val();
            
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
            var appOpt = jQuery("#appOpt" + id).val();
            //if($("#appOpt" + id).is(':checked'))
                //alert("#appOpt" + id.val());
            
            
            if (!(/^\S{3,}$/.test(appName)) || appName == '' ) {
                jQuery("#dnameErr" + id).html("Enter Holiday Name.");
                jQuery("#appName" + id).focus();
                err++;
                return false;
            }
            
            if (appName1 == '') {
                jQuery("#dateErr" + id).html("Enter Holiday Date.");
                jQuery("#appName1" + id).focus();
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
                jQuery("#appOpt" + id).removeAttr('disabled');
                jQuery("#appOpt" + id).val(appOpt);
                jQuery("#appOpt" + id).attr('disabled', true);
                jQuery("#overlay").show();
                var fdata = {'data[Holiday][holiday_name]': appName, 'data[Holiday][holiday_date]': appName1, 'data[Holiday][op_leave]': appOpt};
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
        jQuery.post('<?php echo $this->webroot; ?>holidays/lists',
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
        var org_name = jQuery.trim(jQuery("#org_name").val());
        var appName = jQuery.trim(jQuery("#appName").val());
        var appCode = jQuery.trim(jQuery("#appCode").val());
              var loccode = jQuery.trim(jQuery("#location_id").val());
        if (org_name == '') {
            jQuery("#OnameErr").html("<?php echo "Please select organization name."; ?>");
            jQuery("#org_name").focus();
            err++;
            return false;
        } else {
            jQuery("#OnameErr").html("");
        }
        
 if (loccode == '') {
            jQuery("#dlocErr").html("<?php echo "Please Enter holiday name."; ?>");
            jQuery("#location_id").focus();
            err++;
            return false;
        } else {
            jQuery("#dlocErr").html("");
        }


        if (appName == '') {
            jQuery("#dnameErr").html("<?php echo "Please Enter holiday name."; ?>");
            jQuery("#appName").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr").html("");
        }
        if (appCode == '') {
            jQuery("#dateErr").html("<?php echo "Please select holiday dates."; ?>");
            jQuery("#appCode").focus();
            err++;
            return false;
        } else {
            jQuery("#dateErr").html("");
        }
        

        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>holidays/add/', fdata, function (data) {
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
    
     jQuery("#org_name").live('', function () {
        var org_id = jQuery("#org_name").val();
        var fdata =  jQuery("#searchForm").serialize();
        jQuery.post('<?php echo $this->webroot; ?>Holidays/get_location/'+org_id,
                fdata,
                function (data) {
                    jQuery("#result").html(data);
                    }, 'html'
                ).error(function (e) {
            alert("Error : " + e.statusText);
        });
    });
     function search() {
                     var err = 0;
        var appName = jQuery.trim(jQuery("#appName").val());

    
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();
            
             jQuery.post('<?php echo $this->webroot; ?>Holidays/lists/',
                fdata,
                function(data) {
                    
                    jQuery("#result").html(data);
                    jQuery("#overlay").hide();                    
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });
        }




      }


</script>	

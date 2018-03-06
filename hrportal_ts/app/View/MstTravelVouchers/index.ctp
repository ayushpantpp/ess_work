
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
               Travel Management
            </li>
            <li>
               Travel Master
            </li>            
        </ul>
    </div>
</div>

<br>
<div id="add_msg_div">
    <h2 class="demoheaders">ADD TRAVEL MODES<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('MstTravelVouchers', array('url' => 'add', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table width="100%" border="0" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                   <?php $company = $this->Common->findCompanyName();?>
                    <th scope="row"><strong>Select Organization :</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type'=>'select','options'=>$company,'empty'=>'Select Company','class' => 'round_select', 'id' => 'org_name')); ?>
                        <div id="dnameErr3" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th width="253" scope="row" align="center"><strong>Travel Type:</strong>  </th>
                    <td ><?php
                        $type_arr = $this->Common->findAllTravelMode();
                        echo $this->Form->input('type', array('type' => 'select', 'class' => 'round_select', 'id' => 'appName1', 'empty' => 'Select Travel Mode Type', 'options' => $type_arr));
                        ?>
                        <div id="dnameErr1" style="color:red"></div>
                    </td>
                </tr>           				
                <tr>
                    <th scope="row"><strong> Name  :</strong>  </th>
                    <td><?php echo $this->Form->input('travel_name', array('class' => 'round_select', 'id' => 'appName2')); ?>
                        <div id="dnameErr2" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>
                               <?php echo $this->Form->button('search', array('type' => 'button', 'id' => 'search', 'class' => 'successButton')); ?>
<?php echo $this->Form->button('Reset', array('type' => 'reset', 'onclick'=>'location.reload();', 'class' => 'infoButton')); ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php
    echo $this->Form->end();
    ?>

</div>

<div id="list_msg_div1">
    <h2 class="demoheaders">Travel Modes List</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>MstTravelVouchers/delete/' + id, {}, function (data) {
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
                jQuery("#dnameErr" + id).html("Enter Travel Mode Name.");
                jQuery("#appName" + id).focus();
                err++;
                return false;
            }
            if (err == 0) {
                jQuery("#appName1" + id).removeAttr('disabled');
                jQuery("#appName1" + id).val(appName);
                jQuery("#appName1" + id).attr('disabled', true);
                jQuery("#overlay").show();
                var fdata = {'data[MstTravelVoucher][desc]': appName};
                jQuery.post('<?php echo $this->webroot ?>MstTravelVouchers/edit/' + id, fdata, function (data) {
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
        jQuery.post('<?php echo $this->webroot; ?>MstTravelVouchers/lists',
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




    });

    function doChk() {
        var err = 0;
        var appName1 = jQuery.trim(jQuery("#appName1").val());
        var appName2 = jQuery.trim(jQuery("#appName2").val());
        var org_name = jQuery.trim(jQuery("#org_name").val());
        if (org_name == '') {
            jQuery("#dnameErr3").html("<?php echo "Please Select Orgnization."; ?>");
            jQuery("#org_name").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr3").html("");
        }
        if (appName1 == '') {
            jQuery("#dnameErr1").html("<?php echo "Please Select Travel Type."; ?>");
            jQuery("#appName1").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr1").html("");
        }
        if (appName2 == '') {
            jQuery("#dnameErr2").html("<?php echo "Please Enter Name."; ?>");
            jQuery("#appName2").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr2").html("");
        }
        
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>MstTravelVouchers/add/', fdata, function (data) {
                if (data) {
                   // alert("vivek");alert(data.msg);alert(data.type);alert(data.rec);return false;
                    createMsg(data.msg, data.type);
                    jQuery("#overlay").hide();
                    lists();

                    if (data.type == 'success') {
                        jQuery("#appName1 ").val('');
                        jQuery("#appName2 ").val('');
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
            
             jQuery.post('<?php echo $this->webroot; ?>MstTravelVouchers/lists/',
                fdata,
                function(data) {
                    
                    jQuery("#result").html(data);
                    jQuery("#overlay").hide();                    
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });
        }




      }

</script>	
<style>
    .submit{text-align:left;}
</style>
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Catagory Management
            </li>
            <li>
                 Catagory Master
            </li>            
        </ul>
    </div>
</div>
<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Catagory<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('Company', array('url' => '#', 'name' => 'msgForm','enctype'=>"multipart/form-data", 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr> 
                       <?php $company = $this->Common->findCompanyName();
                    ?>
                    <th scope="row" width="253"><strong>Parent Organization:</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company,  'empty'=>'Select company name' ,'class' => 'round_select', 'id' => 'orgName', 'maxLength' => 90)); ?>
                        <div id="dcodeErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong>Catagory Description :</strong>  </th>
                    <td><?php echo $this->Form->input('cat_desc', array('class' => 'round_select', 'id' => 'appName', 'maxLength' => 90)); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                <th scope="row"><strong> IS GALLERY :</strong>  </th>
                     <td><?php echo $this->Form->checkbox('is_gallery', array('class' => 'round_select', 'id' => 'check')); ?>
                   <div id="dCnameErr" style="color:red"></div>
                    </td>
					
                
                    </tr>
                
                <tr>
                <td colspan="4">
                    <div class="submit">
                        <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton'));         
                echo $this->Form->button('Reset', array('type' => 'reset', 'onclick'=>'location.reload();', 'class' => 'infoButton')); ?>
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
    <h2 class="demoheaders">Catagories List</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>companies/delete_cat/' + id, {}, function (data) {
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
                jQuery("#dcnameErr" + id).html("Enter Company Code.");
                jQuery("#appName" + id).focus();
                err++;
                return false;
            }
            if (appCode == '') {
                jQuery("#dnameErr" + id).html("Enter Company Name.");
                jQuery("#appCode" + id).focus();
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
                var fdata = {'data[Company][comp_name]': appName, 'data[Company][comp_code]': appName1};
                jQuery.post('<?php echo $this->webroot ?>companies/edit/' + id, fdata, function (data) {
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
        jQuery.post('<?php echo $this->webroot; ?>companies/cat_lists',
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
	jQuery("#check").live('click', function () {
                        
          if ($(this).is(":checked")) {
                $("#gallery").show();
                $("#check").val();
              
              
            } else {
                $("#gallery").hide();
                $("#check").val(0);
               
                
            }
           
        });

    function doChk() {
        var err = 0;
        var appName = jQuery.trim(jQuery("#appName").val());
        var orgName = jQuery.trim(jQuery("#orgName").val());
         if (orgName == '') {
            jQuery("#dcodeErr").html("<?php echo "Please Select Company Name."; ?>");
            jQuery("#orgName").focus();
            err++;
            return false;
        } else {
            jQuery("#dcodeErr").html("");
        }
        
        if (appName == '') {
            jQuery("#dnameErr").html("<?php echo "Please Enter catagory description."; ?>");
            jQuery("#appName").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr").html("");
        }
       
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>companies/add_cat/', fdata, function (data) {
        
                if (data) {
                
                    //alert("vivek");alert(data.msg);alert(data.type);return false;
                    createMsg(data.msg, data.type);
                    jQuery("#overlay").hide();
                    lists();

                    if (data.type == 'success') {
                        jQuery("#appName ").val('');
                        jQuery("#orgName ").val('');
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


<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>Wheeler Management</li>
            <li> Wheeler Master</li>
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Wheeler Price<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('MstWheelerType', array('url' => 'add', 'name' => 'msgForm', 'id' => 'MstWheelerType', 'onsubmit' => 'return doChk()', 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table width="100%"  border="0"  cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                   <?php $company = $this->Common->findCompanyName();?>
                    <th scope="row"><strong>Select Organization :</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type'=>'select','options'=>$company,'empty'=>'Select Company','class' => 'round_select', 'id' => 'org_id' ,'onChange' => 'findVehicle(this.value);')); ?>
                        <div id="nameErr1" style="color:red"></div>
                    </td>
                </tr>  
                <tr>
                    <?php
                    
                    //print_r($Wheeler); die;
                    ?>
                    <th width="253" scope="row"><strong>Vehicle :</strong>  </th>
                    <td><?php echo $this->Form->input('vehicle', array('type' => 'select', 'class' => 'round_select', 'id' => 'vehicle', 'empty' => 'Select Travel Mode')); ?>
                        <div id="nameErr0" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <?php
                    $Wheeler_type = array('1'=>'Personal','2'=>'Commercial');
                    ?>
                    <th width="253" scope="row"><strong>Wheeler type :</strong>  </th>
                    <td><?php echo $this->Form->input('wheeler_type', array('type' => 'select', 'class' => 'round_select', 'id' => 'wheeler_type', 'empty' => 'Select Wheeler Type', 'options' => $Wheeler_type)); ?>
                        <div id="nameErr2" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong> Price :</strong>  </th>
                    <td><?php echo $this->Form->input('price', array('type' => 'text', 'class' => 'round_select', 'id' => 'price')); ?>
                        <div id="priceErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong> Effected Date :</strong>  </th>
                    <td><?php echo $this->Form->input('eff_date', array('type' => 'text', 'class' => 'round_select', 'id' => 'eff_date')); ?>
                        <div id="nameErr3" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'id' => 'add', 'class' => 'successButton', 'value' => 'Submit'));?>
                           <?php echo $this->Form->button('Search', array('type' => 'button', 'id' => 'search', 'class' => 'successButton')); ?>
                            <?php echo $this->Form->button('Reset', array('type' => 'reset','onclick'=>'location.reload();', 'class' => 'infoButton')); ?>
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
    <h2 class="demoheaders">Wheeler Price List</h2>
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
        jQuery("#eff_date").datepicker({
            inline: true,
            changeMonth: true,
            autoclose: true,
           // maxDate: 'today',
            //changeYear: true,
            format: 'dd-mm-yyyy'

        });
        
        lists();
        // Delete function 
        jQuery("#delete").live('click', function () {
            var id = jQuery(this).attr('mid');
            if (confirm("Are you sure you want to delete?")) {
                jQuery("#overlay").show();
                jQuery.get('<?php echo $this->webroot; ?>MstWheelers/delete/' + id, {}, function (data) {
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
            jQuery("#name" + id).val();
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
            var org_id = jQuery("#org_id" + id).val();
            var vehicle = jQuery("#vehicle" + id).val();
            var wheeler_type = jQuery("#wheeler_type" + id).val();
            var price = jQuery("#price" + id).val();
            var eff_date = jQuery("#eff_date" + id).val();
            if (org_id == '') {
                jQuery("#nameErr1" + id).html("Please Select Orgnization !");
                jQuery("#org_name" + id).focus();
                err++;
                return false;
            }
            if (vehicle == '') {
                jQuery("#nameErr0" + id).html("Enter Travel Mode Name.");
                jQuery("#vehicle" + id).focus();
                err++;
                return false;
            }
            if (wheeler_type == '') {
                jQuery("#nameErr2" + id).html("Please Select Wheeler Type !");
                jQuery("#wheeler_type" + id).focus();
                err++;
                return false;
            }
            if (price == '') {
                jQuery("#priceErr" + id).html("Enter price.");
                jQuery("#price" + id).focus();
                err++;
                return false;
            }
            if (eff_date == '') {
                jQuery("#priceErr" + id).html("Select Date.");
                jQuery("#eff_date" + id).focus();
                err++;
                return false;
            }



            if (err == 0) {
                jQuery("#org_id" + id).removeAttr('disabled');
                jQuery("#org_id" + id).val(org_id);
                jQuery("#org_id" + id).attr('disabled', true);
                jQuery("#vehicle" + id).removeAttr('disabled');
                jQuery("#vehicle" + id).val(vehicle);
                jQuery("#vehicle" + id).attr('disabled', true);
                jQuery("#wheeler_type" + id).removeAttr('disabled');
                jQuery("#wheeler_type" + id).val(wheeler_type);
                jQuery("#wheeler_type" + id).attr('disabled', true);
                jQuery("#price" + id).removeAttr('disabled');
                jQuery("#price" + id).val(price);
                jQuery("#price" + id).attr('disabled', true);
                jQuery("#eff_date" + id).removeAttr('disabled');
                jQuery("#eff_date" + id).val(eff_date);
                jQuery("#eff_date" + id).attr('disabled', true);

                jQuery("#overlay").show();
                //var fdata=jQuery('#deptFrm').serialize();
                var fdata = {'data[MstWheelerType][org_id]': org_id,
                        'data[MstWheelerType][vehical]': vehicle,
                        'data[MstWheelerType][wheeler_type]': wheeler_type,
                        'data[MstWheelerType][price]': price,
                        'data[MstWheelerType][effected_date]': eff_date,
                        };
                //fdata ={'data[Designations][dept_code]':desgCode};
                //fdata=fdata + fdepdata;
                //alert(fdata);
                jQuery.post('<?php echo $this->webroot ?>MstWheelers/edit/' + id, fdata, function (data) {
                    console.log(data);
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
        jQuery.post('<?php echo $this->webroot; ?>MstWheelers/lists',
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
        var org_id = jQuery.trim(jQuery("#org_id").val());
        var vehicle = jQuery.trim(jQuery("#vehicle").val());
        var wheeler_type = jQuery.trim(jQuery("#wheeler_type").val());
        var price = jQuery.trim(jQuery("#price").val());
        var eff_date = jQuery.trim(jQuery("#eff_date").val());

        if (org_id == '') {
            jQuery("#nameErr1").html("<?php echo "Please Select Orgnization !"; ?>");
            jQuery("#org_id").focus();
            err++;
            return false;
        } else {
            jQuery("#nameErr1").html("");
        }
        if (vehicle == '') {
            jQuery("#nameErr0").html("<?php echo "Please Selelct Vehicle !"; ?>");
            jQuery("#vehicle").focus();
            err++;
            return false;
        } else {
            jQuery("#nameErr0").html("");
        }
        if (wheeler_type == '') {
            jQuery("#nameErr2").html("<?php echo "Please Select Wheeler Type !! "; ?>");
            jQuery("#wheeler_type").focus();
            err++;
            return false;
        } else {
            jQuery("#nameErr2").html("");
        }
        if (price == '') {
            jQuery("#priceErr").html("<?php echo "Please Enter Price "; ?>");
            jQuery("#price").focus();
            err++;
            return false;
        } else {
            jQuery("#priceErr").html("");
        }
        if (isNaN(price)) {
            jQuery("#priceErr").html("<?php echo "Please Enter Numeric Digit "; ?>");
            jQuery("#price").focus();
            err++;
            return false;
        } else {
            jQuery("#priceErr").html("");
        }
        if (eff_date == '') {
            jQuery("#nameErr3").html("<?php echo "Please Select Effected Date !! "; ?>");
            jQuery("#eff_date").focus();
            err++;
            return false;
        } else {
            jQuery("#nameErr3").html("");
        }
        }
        function findVehicle(comp_code)
    {

        $.ajax({
            type: "GET",
            cache: false,
            //sdata:{data1:comp_code}, 
            url: "<?php echo $this->webroot; ?>MstWheelers/getvehicle/" + comp_code,
            success: function (data) {
                //alert(data);
                data = jQuery.parseJSON(data);
                var list = '';
                jQuery("#vehicle").html();
                list += "<option value='' >Select Vehicle</option>";
                $.each(data, function (index, value) {
                    list += "<option value='" + index + "'>" + value + "</option>";
                });
                jQuery("#vehicle").html(list);
            }
        });
    }
         function search() {
                     var err = 0;
          var org_id = jQuery.trim(jQuery("#org_id").val());
        var vehicle = jQuery.trim(jQuery("#vehicle").val());
        var wheeler_type = jQuery.trim(jQuery("#wheeler_type").val());
        var price = jQuery.trim(jQuery("#price").val());
        var eff_date = jQuery.trim(jQuery("#eff_date").val());

    
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();
            
             jQuery.post('<?php echo $this->webroot; ?>MstWheelers/lists/',
                fdata,
                function(data) {
                    
                    jQuery("#result").html(data);
                    jQuery("#overlay").hide();                    
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });
        }
    }
</script>	

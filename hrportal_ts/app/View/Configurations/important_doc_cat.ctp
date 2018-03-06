<div id="page_content">
    <div class="breadCrumbHolder module">
        <div id="breadCrumb0" class="breadCrumb module">
            <ul>
                <li>
                    <a href="#" class="vtip" title="Home">Home</a>
                </li>
                <li>
                    Configuration
                </li>
                <li>
                    Important documents categories
                </li>            
            </ul>
        </div>
    </div>

    <br>

    <div id="add_msg_div">
        <h2 class="demoheaders">Add Category<a href="#" id="create"></a></h2>
        <?php
        echo $this->Form->create('ImportantDocCategory', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
        ?>
        <div class="travel-voucher">
            <div class="input-boxs">
                <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                    <tr>

                        <th width="253" scope="row"><strong>Company Name :</strong>  </th>
                        <?php $company = $this->Common->findCompanyName();
                        ?>
                        <td><?php echo $this->Form->input('comp_code', array('type' => 'select', 'options' => $company, 'empty' => 'Select Company Name', 'class' => 'round_select', 'id' => 'companyName')); ?>
                            <div id="dCCnameErr" style="color:red"></div>
                        </td>
                    </tr>
                    <tr>

                        <th scope="row"><strong>Category Name :</strong>  </th>
                        <td><?php echo $this->Form->input('title', array('class' => 'round_select', 'id' => 'catName')); ?>
                            <div id="dnameErr" style="color:red"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="submit">
                                <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>                                
                                <?php echo $this->Form->button('Reset', array('type' => 'reset', 'class' => 'resetButton')); ?>
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
        <h2 class="demoheaders">Category lists</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>designations/delete/' + id, {}, function (data) {
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
            jQuery("#catName" + id).val();
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
            var catName = jQuery("#catName" + id).val();
            if (catName == '') {
                jQuery("#dnameErr" + id).html("Enter Designation Name.");
                jQuery("#catName" + id).focus();
                err++;
                return false;
            }

            if (err == 0) {
                jQuery("#catName1" + id).removeAttr('disabled');
                jQuery("#catName1" + id).val(catName);
                jQuery("#catName1" + id).attr('disabled', true);

                jQuery("#overlay").show();
                //var fdata=jQuery('#deptFrm').serialize();
                var fdata = {'title': catName, 'id': id};
                //fdata ={'data[Designation][dept_code]':desgCode};
                //fdata=fdata + fdepdata;
                //alert(fdata);
                jQuery.post('<?php echo $this->webroot ?>configurations/update_important_doc_cat/' + id, fdata, function (data) {
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
        //	alert("e1");
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
        jQuery.post('<?php echo $this->webroot; ?>configurations/important_doc_cat_lists',
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
        var companyName = jQuery.trim(jQuery("#companyName option:selected").text());
        var catName = jQuery.trim(jQuery("#catName").val());
        //alert("e3 "+companyName+" e4 "+departmentName+" e5 "+catName+" e6 "+desgCode);

        if (companyName == 'Select Company Name') {
            jQuery("#dCCnameErr").html("<?php echo "Please input Company name."; ?>");
            jQuery("#dCCnameErr").focus();
            err++;
            return false;
        } else {
            jQuery("#dCCnameErr").html("");
        }

        if (catName == '') {
            jQuery("#dnameErr").html("<?php echo "Please input Category name."; ?>");
            jQuery("#dnameErr").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr").html("");
        }



        if (err == 0) {
            jQuery("#overlay").show();
            //var fdata=jQuery("form[name='msgForm']").serialize();
            var fdata = "id=" + jQuery("#companyName option:selected").val()
            console.log(fdata);

            jQuery.post('<?php echo $this->webroot ?>configurations/add_important_doc_cat/', fdata, function (data) {
                if (data) {
                    //alert("vivek");alert(data.msg);alert(data.type);return false;
                    createMsg(data.msg, data.type);
                    jQuery("#overlay").hide();
                    lists();

                    if (data.type == 'success') {
                        jQuery("#companyName").val('Select Company Name');
                        jQuery("#departmentName ").val('Select Department Name');
                        jQuery("#catName ").val('');
                        jQuery("#desgCode ").val('');
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

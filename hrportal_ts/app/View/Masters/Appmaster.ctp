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
                Application Master
            </li>            
        </ul>
    </div>
</div>
<div id="add_msg_div">
        
        
    <h2 class="demoheaders"> ADD APPLICATION <?=$heading?><a href="#" id="create"></a></h2>
    <?php echo $flash = $this->Session->flash(); ?> 
     <?php echo $this->Form->create('master', array('url' =>array('controller' => 'masters', 'action' => 'Appmaster'),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                    
                    <th width = "253" scope="row"><strong></strong>  </th>
                    <td> <?php $company_list = $this->Common->findCompanyName(); 
                            echo $this->form->input('org_id', array('label' => "Company List:", 'type' => "select",'empty' => ' -- Select Company--', 'options' => $company_list, 'class' => "md-input",'id' => 'companyName', 'required' => true,'data-md-selectize','onChange' =>'return getEmployee(this.value)')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                    <th scope="row"><strong></strong>  </th>
                    <td>  <?php 

                     $application = $this->Common->getApplicationList(); 
                
                                   echo $this->form->input('app_name', array('label' => "Application Name", 'type' => "select",'empty' => ' -- Select Application-', 'options' =>  $application, 'class' => "md-input",'id' => 'app_list', 'required' => true,'data-md-selectize')); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                    <th scope="row"><strong></strong>  </th>
                    <td><?php echo $this->form->input('max_days', array('type' => "text", 'class' => "md-input",'id' => 'appmax', 'required' => true,'data-md-selectize')); ?>
                        <div id="dCodeErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div  class="submit">
                            <button type="submit" name="submit" class="md-btn md-btn-success"  style="margin-top: 30px;" href="#">Submit</button>   
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
    <h2 class="demoheaders">Application List</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>masters/delete/' + id, {}, function (data) {
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
           
           
            if (err == 0) {
               

                var appName=jQuery("#org_id"+id).val();
               
               var  appid=jQuery("#app_id"+id).val();
        
               var applydays=jQuery("#appdays"+id).val();
               
                //var fdata=jQuery('#deptFrm').serialize();
                var fdata = {'data[Appmaster][org_id]': appName, 'data[Appmaster][app_id]': appid,'data[Appmaster][apply_in_days]':applydays};
                //fdata ={'data[Department][dept_code]':deptCode};
                //fdata=fdata + fdepdata;
                
                jQuery.post('<?php echo $this->webroot ?>masters/edit/' + id, fdata, function (data) {
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
     jQuery("#save").live('click', function () {
           
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
  jQuery("#search").click(function () {
       // var org_id = jQuery.trim(jQuery("#org_id").val());
        search();
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
        jQuery.post('<?php echo $this->webroot; ?>masters/lists',
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
 function search() {
                     var err = 0;
        var appName = jQuery.trim(jQuery("#appName").val());

    
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();
            
             jQuery.post('<?php echo $this->webroot; ?>departments/lists/',
                fdata,
                function(data) {
                    
                    jQuery("#result").html(data);
                    jQuery("#overlay").hide();                    
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });
        }




      }
</script>   

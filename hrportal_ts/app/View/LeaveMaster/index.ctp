
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>Leave   Management</li>
            <li>Leave  Master </li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Leave<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('LeaveMaster', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="leave">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                   <?php $company = $this->Common->findCompanyName();?>
                    <th scope="row"><strong>Select Organization :</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type'=>'select','options'=>$company,'empty'=>'Select Company','class' => 'round_select', 'id' => 'org_name', 'value'=>'0','onChange' => 'findLeave(this.value);')); ?>
                        <div id="OnameErr" style="color:red"></div>
                    </td>
                </tr> 
                <tr>
                    
                    <th scope="row"><strong>Leave Types :</strong>  </th>
                   <td><?php echo $this->Form->input('type', array('class' => 'round_select', 'type'=>'select' ,'options'=>array('SL','EL','LWP','OP','WL','PL'),'empty'=>'select Leave Type','id' => 'appName', 'maxLength' => 90)); ?>
                   <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
               
                <tr>
                      <?php $type_loc = $this->Common->findLeavecode();
                      ?>


<th width="253" scope="row"><strong>Leave Code:</strong>  </th>




                     <td><?php echo $this->Form->input('leave_code', array('type'=>'select','options'=>$type_loc,'empty'=>'select Leave Code','class' => 'round_select', 'id' => 'appCode')); ?>
                        <div id="dtypeErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong>Leave Max Days:</strong>  </th>
                     <td><?php echo $this->Form->input('Leavemaxdays', array('class' => 'round_select', 'id' => 'appleave', 'maxLength' => 90,'onkeypress'=>'return isNumber(event)')); ?>
                   <div id="dleaveErr" style="color:red"></div>
                    </td>
                    </td>
                </tr>
                <tr>
                    
                    <th scope="row"><strong>week off   :</strong>  </th>
                   <td><?php echo $this->Form->checkbox('wo', array( 'id' => 'weekoff', 'value'=>'0')); ?>
                   <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong>Halfday :</strong>  </th>
                     <td><?php echo $this->Form->checkbox('halfday', array( 'id' => 'apphd','value'=>'0')); ?>

                   <div id="dCnameErr" style="color:red"></div>
                    </td>
                    

                    </td>
 
                </tr>
                <tr>
                <th scope="row"><strong> File Upload :</strong>  </th>
                     <td><?php echo $this->Form->checkbox('file_upload', array( 'id' => 'check')); ?>
                   <div id="dCnameErr" style="color:red"></div>
                    </td>
  <td><?php echo $this->Form->input('nfiles', array('class' => 'round_select', 'id' => 'nleave','placeholder'=> 'Number of Files Upload', 'maxLength' => 100,'onkeypress'=>'return isNumber(event)')); ?>
                   <div id="dCnameErr" style="color:red"></div>
                    </td>
                    </tr>
  <tr>
                <th scope="row"><strong> Details :</strong>  </th>
                     <td><?php echo $this->Form->textarea('info', array('class' => 'round_select', 'id' => 'details','placeholder'=> 'Details', 'maxLength' => 90)); ?>
                   <div id="dCnameErr" style="color:red"></div>
                    </td>
                    </tr>
                <tr>
                    <td colspan="2">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>

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
    <h2 class="demoheaders">Leave List</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>LeaveMaster/delete/' + id, {}, function (data) {
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
            jQuery("#leave" + id).val();
            
            jQuery("#vw" + id).hide();
			 jQuery("#update" + id).show();
			 
			if ($("#check"+ id).is(":checked")) {
			alert(0);
                jQuery("#nleave" + id).attr("disabled", "disabled");
			     }
                 else {

              return true;
                 
                
            }
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

     	 if ($("#weekoff"+id).is(":checked")) {
           
                $("#weekoff"+id).val(1);
                
             
            } else {
               
                $("#weekoff"+id).val(0);
              
            }
 if ($("#apphd"+id).is(":checked")) {
           
                $("#apphd"+id).val(1);
               
             
            } else {
               
                $("#apphd"+id).val(0);
           
            }
if ($("#check"+id).is(":checked")) {
           
                $("#check"+id).val(1);
             
            } else {
               
                $("#check"+id).val(0);
 
            }

             var org_name = jQuery.trim(jQuery("#org_id"+id).val());
             
        var appName= jQuery.trim(jQuery("#appName"+id).val());
        var appCode = jQuery.trim(jQuery("#appCode"+id).val());
         var leave_days = jQuery.trim(jQuery("#appLeave"+id).val());
         
        var halfday = jQuery.trim(jQuery("#apphd"+id).val());
     
      
      var weekoff = jQuery.trim(jQuery("#weekoff"+id).val());
                var fileupload = jQuery.trim(jQuery("#check"+id).val());
               
                        var filenumber = jQuery.trim(jQuery("#nleave"+id).val());
                        var details = jQuery.trim(jQuery("#details"+id).val());
            

                        //alert(org_name+","+appName+","+appCode+","+filenumber);
             if (err == 0) {
                
               
                var fdata = {'data[LeaveMaster][comp_code]': org_name, 'data[LeaveMaster][leave_type]': appName, 'data[LeaveMaster][leave_code]': appCode,'data[LeaveMaster][max_days]': leave_days,'data[LeaveMaster][week_off]': weekoff,'data[LeaveMaster][half_day_chk]': halfday,'data[LeaveMaster][file_upload]': fileupload,'data[LeaveMaster][file_upload_no]': filenumber,'data[LeaveMaster][details]': details};
                jQuery.post('<?php echo $this->webroot ?>LeaveMaster/edit/' + id, fdata, function (data) {
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
          jQuery("#check").live('click', function () {
                        
          if ($(this).is(":checked")) {
                $("#nleave").show();
                $("#check").val(1);
              
              
            } else {
                $("#nleave").hide();
                $("#check").val(0);
               
                
            }
           
        });
jQuery("#apphd").live('click', function () {
                        
          if ($(this).is(":checked")) {
           
                $("#apphd").val(1);
              
              
            } else {
               
                $("#apphd").val(0);
               
                
            }
           
        });
jQuery("#weekoff").live('click', function () {
                        
          if ($(this).is(":checked")) {
           
                $("#weekoff").val(1);
                
              
            } else {
               
                $("#weekoff").val(0);
               
                
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


 function findLeave(comp_code)
    {

        $.ajax({
            type: "GET",
            cache: false,
            //sdata:{data1:comp_code}, 
            url: "<?php echo $this->webroot; ?>LeaveMaster/getleavecode/" + comp_code,
            success: function (data) {
                
data = jQuery.parseJSON(data);
                var list = '';
                jQuery("#appCode").html();
                list += "<option value='' >Select leave Code </option>";
                $.each(data, function (index, value) {
                    list += "<option value='" + index + "'>" + value + "</option>";
                });
                jQuery("#appCode").html(list);            }
        });
    }
    function lists() {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
        jQuery("#result").html(data);
        var fdata = jQuery("#searchForm").serialize();
        jQuery.post('<?php echo $this->webroot; ?>LeaveMaster/lists',
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
$("#nleave").hide();
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
         var leave_days = jQuery.trim(jQuery("#appleave").val());
        var halfday = jQuery.trim(jQuery("#apphd").val());
        var fullday = jQuery.trim(jQuery("#appfd").val());
          var weekoff = jQuery.trim(jQuery("#weekoff").val());
                var file = jQuery.trim(jQuery("#check").val());
                        var filenumber = jQuery.trim(jQuery("#nleave").val());
                         var details = jQuery.trim(jQuery("#details").val());

                        
                         if (org_name == '') {
            jQuery("#OnameErr").html("<?php echo "Please select organization name."; ?>");
            jQuery("#org_name").focus();
            err++;
            return false;
        } else {
            jQuery("#OnameErr").html("");
        }
 if (appName == '') {
            jQuery("#dCnameErr").html("<?php echo "Please Enter Leave types."; ?>");
            jQuery("#appName").focus();
            err++;
            return false;
        } else {
            jQuery("#dCnameErr").html("");
        }
       
          if (appCode == '') {
            jQuery("#dtypeErr").html("<?php echo "Please select leave Code."; ?>");
            jQuery("#appCode").focus();
            err++;
            return false;
        } else {
            jQuery("#dtypeErr").html("");
        }
         if (leave_days == '') {
            jQuery("#dleaveErr").html("<?php echo "Please select max leave days."; ?>");
            jQuery("#appleave").focus();
            err++;
            return false;
        } else {
            jQuery("#dleaveErr").html("");
        }
		
		if ($("#check").is(":checked")) {
               
                 if(filenumber=='')
                 {
                    alert("please Enter Number Of Files Upload ");
					$("#nleave").focus();
                    return false;
                 }

                  } else {
 
                  
                 
               
            }
if(filenumber>leave_days)
{
alert("Numer of file upload can not be greater then Leave Max Days");
 jQuery("#nleave").focus();
return false;
}

         if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();

            jQuery.post('<?php echo $this->webroot ?>LeaveMaster/add/', fdata, function (data) {
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
     function get_location(){
        var org_id = jQuery("#org_name").val();
        alert(org_id);

        var fdata =  jQuery("#searchForm").serialize();
        jQuery.post('<?php echo $this->webroot; ?>LeaveMaster/get_location/'+org_id,
                fdata,
                function (data) {
                    jQuery("#result").html(data);
                    }, 'html'
                ).error(function (e) {
            alert("Error : " + e.statusText);
        });
       
    }

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>   

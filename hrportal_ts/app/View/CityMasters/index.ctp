
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
                City Master
            </li>            
        </ul>
    </div>
</div>

<br>
<div id="add_msg_div">
    <h2 class="demoheaders">ADD CITY GROUP<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('CityGroup', array('url' => 'add', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
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
                    <th scope="row"><strong> Name  :</strong>  </th>
                    <td><?php echo $this->Form->input('group_name', array('class' => 'round_select', 'id' => 'appName2')); ?>
                        <div id="dnameErr2" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton')); ?>
							<?php echo $this->Form->button('Search', array('type' => 'button', 'id' => 'search', 'class' => 'infoButton')); ?>
							<?php echo $this->Form->button('Reset', array('type' => 'reset', 'class' => 'infoButton')); ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
	
	<div id="list_msg_div1">
		<h2 class="demoheaders">City Groups List</h2>
		<div class="travel-voucher1" style="min-height: 300px;">
			<div class="input-boxs">

				<div id="result"></div>


			</div>
		</div>
		<div id="files"></div>
	</div>
</div>
	<script>
		jQuery(document).ready(function(){
			lists();
		});
		jQuery("#add").click(function () {
			doChk();
		});
		
		function doChk() {
        var err = 0;
        var appName2 = jQuery.trim(jQuery("#appName2").val());
        var org_name = jQuery.trim(jQuery("#org_name").val());
        if (appName2 == '') {
            jQuery("#dnameErr2").html("<?php echo "Please Enter Group Name."; ?>");
            jQuery("#appName2").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr2").html("");
        }
        if (org_name == '') {
            jQuery("#dnameErr3").html("<?php echo "Please Select Orgnization."; ?>");
            jQuery("#org_name").focus();
            err++;
            return false;
        } else {
            jQuery("#dnameErr3").html("");
        }
        if (err == 0) {
            jQuery("#overlay").show();
            var fdata = jQuery("form[name='msgForm']").serialize();
			//console.log(fdata);
			jQuery.ajax({
				type : 'POST',
				url  : '<?php echo $this->webroot ?>city_masters/add/',
				dataType : 'json',
				data : fdata,
				success : function(data) {
				//console.log(data);
					if (data) {
					   //alert("vivek");alert(data.msg);alert(data.type);alert(data.rec);return false;
						createMsg(data.msg, data.type);
						jQuery("#overlay").hide();
						lists();

						if (data.type == 'success') {
							jQuery("#org_name ").val('');
							jQuery("#appName2 ").val('');
							lists();
							return false;
						}
					}
				},
				error : function (e){
					alert("Error : " + e.statusText);
					jQuery("#overlay").hide();
				}
			});

        } else {
            return false;
        }
    }
	

	function lists() {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
        jQuery("#result").html(data);
        //var fdata = jQuery("#searchForm").serialize();
        jQuery.get('<?php echo $this->webroot; ?>city_masters/lists/',
                function (data) {
		    jQuery("#result").html(data);
                }, 'html'
                ).error(function (e) {
            alert("Error : " + e.statusText);
        });
    }
	
	
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
		
		// Delete function 
        jQuery("#delete").live('click', function () {
            var id = jQuery(this).attr('mid');
            if (confirm("Are you sure you want to delete?")) {
                jQuery("#overlay").show();
                jQuery.get('<?php echo $this->webroot; ?>city_masters/delete/' + id, {}, function (data) {
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
		
		jQuery("form[name='msgForm']").keypress(function (e) {
			if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
				doChk();
				return false;
			} else {

			}
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
                var fdata = {'data[CityGroup][group_name]': appName};
				jQuery.ajax({
						type : 'POST',
						url  : '<?php echo $this->webroot ?>citymasters/edit/' + id,
						dataType : 'json',
						data : fdata,
						success : function(data) {
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
						},
						error : function (e){
							alert("Error : " + e.statusText);
							jQuery("#overlay").hide();
						}
				});
            } else {
                return false;
            }

        });
		
		jQuery("#search").live('click', function () {
			var err = 0;
			var org_name = jQuery.trim(jQuery("#org_name").val());
			if (org_name == '') {
				jQuery("#dnameErr3").html("<?php echo "Please Select Orgnization."; ?>");
				jQuery("#org_name").focus();
				err++;
				return false;
			} else {
				jQuery("#dnameErr3").html("");
				jQuery("#appName2").val("");
			}
			if (err == 0) {
				jQuery("#appName2").attr('disabled','disbaled');
				var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
				jQuery.ajax({
				type : 'POST',
				url  : '<?php echo $this->webroot; ?>citymasters/lists/',
				data : {'group_id':org_name},
				success : function(data) {
					jQuery("#appName2").removeAttr('disabled');
					jQuery("#result").html(data);
				},
				error : function (e){
					alert("Error : " + e.statusText);
					jQuery("#overlay").hide();
					jQuery("#appName2").removeAttr('disabled');
				}
			});
				
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
		
		
	</script>
	
	
	
	
	
<style>
    .submit{text-align:left;}
</style>

<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Set WorkFlow Level Master
            </li>
            <li>
                Set WorkFlow Level
            </li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Maximum WorkFlow Level<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('Designation', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
   ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="97%" cellspacing="10" cellpadding="0" align="center" style="margin:0px auto;">
				<tr>
                   
                    <th scope="row"><strong>Application Name :</strong>  </th>
					<?php $company = $this->Common->findCompanyName();
					
					?>
                    <td><?php echo $this->Form->input('comp_code', array('type'=>'select','options'=>$company,'empty'=>'Select Company','class' => 'round_select', 'id' => 'companyName','onChange'=>'findDepartment(this.value);')); ?>
                        <div id="dCCnameErr" style="color:red"></div>
                    </td>
                </tr>

				<tr>
                   
                    <th scope="row"><strong>Company Name :</strong>  </th>
					<?php $company = $this->Common->findCompanyName();
					
					?>
                    <td><?php echo $this->Form->input('comp_code', array('type'=>'select','options'=>$company,'empty'=>'Select Company','class' => 'round_select', 'id' => 'companyName','onChange'=>'findDepartment(this.value);')); ?>
                        <div id="dCCnameErr" style="color:red"></div>
                    </td>
                </tr>

				<tr>
                   
                    <th scope="row"><strong>Department Name :</strong>  </th>
                    <td><?php echo $this->Form->input('dept_code', array('type'=>'select','options'=>'','empty'=>'Select Department','class' => 'round_select', 'id' => 'departmentName')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                   
                    <th scope="row"><strong>Max WorkFlow Level :</strong>  </th>
                    <td><?php echo $this->Form->input('desg_name', array('class' => 'round_select', 'id' => 'appName')); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
				    <td colspan="4" align="center">
					<div align="center" class="submit">
					<?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add','class'=>'successButton')); ?>
                        &nbsp; 	&nbsp; 	&nbsp; 	&nbsp; 
                        <?php echo $this->Form->button('Reset', array('type' => 'reset','class'=>'successButton')); ?>
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
        <h2 class="demoheaders">Max WorkFlow List </h2>
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
        // Delete function 
        jQuery("#delete").live('click',function() {      
            var id=jQuery(this).attr('mid'); 
            if(confirm("Are you sure you want to delete?")) {
                jQuery("#overlay").show();
                jQuery.get('<?php echo $this->webroot; ?>designations/delete/'+id,{},function(data) {
                    if(data) {
						jQuery("#overlay").hide();
                        createMsg(data.msg,data.type);
                        lists();
                    }
				},'json').error(function(e) {  alert("Error Occured : "+e.statusText); jQuery("#overlay").hide();   });
            }
            
        });
        
        // Edit Funtion
        jQuery("#edit").live('click',function() {
           var id=jQuery(this).attr('mid');
           jQuery("#appName"+id).val();
           jQuery("#vw"+id).hide();
           jQuery("#update"+id).show();
        });
       
        /// Cancel Function
        jQuery("#cancel").live('click',function() {
            var id=jQuery(this).attr('mid');
            jQuery("#vw"+id).show();
            jQuery("#update"+id).hide();
        });
        
        // Save Function
        jQuery("#save").live('click', function() {
            var id=jQuery(this).attr('mid'); 
            var err=0;
            var appName=jQuery("#appName"+id).val();
            if(appName=='') {
                jQuery("#dnameErr"+id).html("Enter Designation Name.");
                jQuery("#appName"+id).focus();
                err++;
                return false;
            }
			var companyName=jQuery("#companyName"+id).val();
            if(companyName=='') {
                jQuery("#dcnameErr"+id).html("Enter Company Name.");
                jQuery("#companyName"+id).focus();
                err++;
                return false;
            }
			var departmentName=jQuery("#departmentName"+id).val();
            if(departmentName=='') {
                jQuery("#dpnameErr"+id).html("Enter Department Name.");
                jQuery("#departmentName"+id).focus();
                err++;
                return false;
            }
			var desgCode=jQuery("#desgCode"+id).val();
            if(desgCode=='') {
                jQuery("#dCodeErr"+id).html("Enter Designation Code.");
                jQuery("#desgCode"+id).focus();
                err++;
                return false;
            }
            if(err==0) {
				jQuery("#appName1"+id).removeAttr('disabled');
				jQuery("#appName1"+id).val(appName);
				jQuery("#appName1"+id).attr('disabled',true);
				jQuery("#desgCode1"+id).removeAttr('disabled');
				jQuery("#desgCode1"+id).val(desgCode);
				jQuery("#desgCode1"+id).attr('disabled',true);
				
				jQuery("#overlay").show();
                //var fdata=jQuery('#deptFrm').serialize();
                var fdata={'data[Designation][desc]':appName,'data[Designation][desg_code]':desgCode};
				
                jQuery.post('<?php echo $this->webroot ?>designations/edit/'+id,fdata,function(data) {   
                    if(data) {
                        createMsg(data.msg,data.type);
                        jQuery("#overlay").hide();
						if(data.type=='success') {
                            jQuery("#vw"+id).show();
                            jQuery("#update"+id).hide();
                        }
						lists();
                        return false;
                        
                    }
                },'json').error(function(e) {  alert("Error : "+e.statusText); jQuery("#overlay").hide();   });
            } else {
                return false;
            }
            
        });
	});
        /*Add record script*/ 
        
        jQuery("#add").click(function() { 
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
        
        jQuery('.navigation').find('a').live('click',function(e){
            var data='<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
            
            jQuery("#result").html(data);
            //
            var fdata=jQuery("#searchForm").serialize();
            current_page = jQuery(this).attr('href');
            jQuery.post(current_page,fdata,function(data){
                jQuery("#result").html(data);
                
            },'html');
            return false;
        });
        
        jQuery('.head').find('a').live('click',function(e){
            var data='<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
            jQuery("#result").html(data); 
            var fdata=jQuery("#searchForm").serialize();
            current_page = jQuery(this).attr('href');
            
            jQuery.post(current_page,fdata,function(data){
                jQuery("#result").html(data);
                
            },'html');
            return false;
        });
        
        
        
        function lists() {
            var data='<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
            jQuery("#result").html(data);
            var fdata=jQuery("#searchForm").serialize();
            jQuery.post('<?php echo $this->webroot; ?>WfMstAppMapLvls/lists',
				fdata,
				function(data) {
					
					jQuery("#result").html(data);
					
				},'html'
			).error(function(e) {  alert("Error : "+e.statusText);   });
        }

 </script>
 <script>
    
    jQuery(document).ready(function() {

        jQuery("#remove").live('click',function() {
            var vl=[];
            var f;
            var ln=jQuery("input[class='vl']:checked").length;

	
            if(ln==0) {
                alert("Please checked atleast one record.");
                return false;
            } else {
                jQuery("input[class='vl']:checked").each(function() {   
                    vl.push(parseInt(jQuery(this).val()));
	    
                });
                if(confirm("Are you sure to delete selected records?")) {
                    jQuery("#overlay").show();
                    jQuery.post('<?php echo $this->webroot; ?>/messages/multiDelete',{vl:vl},function(data) {
                    if(data) {
                        createMsg(data.msg,data.type);
                        lists();
                        jQuery("#overlay").hide();
                    }

                },'json');
            }
            return false;
        }

    });

    jQuery("#ch").live('click',function() {
        var ch=jQuery(this).attr('checked');
        if(ch) {
            jQuery(".vl").each(function(){
                jQuery(this).attr('checked',true);
            });

        } else {
            jQuery(".vl").each(function(){
                jQuery(this).attr('checked',false);
            });

        }
    });

});

function doChk() {
	//alert("e2");
    var err=0;
	var companyName=jQuery.trim(jQuery("#companyName option:selected").text());
	var departmentName=jQuery.trim(jQuery("#departmentName option:selected").text());
    var appName=jQuery.trim(jQuery("#appName").val());
    var desgCode=jQuery.trim(jQuery("#desgCode").val());
	//alert("e3 "+companyName+" e4 "+departmentName+" e5 "+appName+" e6 "+desgCode);
	
	 if(companyName=='Select Company') {
        jQuery("#dCCnameErr").html("<?php echo "Please input Company name."; ?>");
        jQuery("#dCCnameErr").focus();
        err++;
        return false;
    } else {
        jQuery("#dCCnameErr").html("");
    }
	if(departmentName=='Select Department') {
        jQuery("#dCnameErr").focus();
        jQuery("#dCnameErr").html("<?php echo "Please input Department name."; ?>");
        err++;
        return false;
    } else {
        jQuery("#dCnameErr").html("");
    }
    if(appName=='') {
        jQuery("#dnameErr").html("<?php echo "Please input Designation name."; ?>");
        jQuery("#dnameErr").focus();
        err++;
        return false;
    } else {
        jQuery("#dnameErr").html("");
    }
	  if(desgCode=='') {
        jQuery("#dCodeErr").html("<?php echo "Please input designation Code."; ?>");
        jQuery("#dCodeErr").focus();
        err++;
        return false;
    } else {
        jQuery("#dCodeErr").html("");
    }
	 
    
   if(err==0) {
        jQuery("#overlay").show();
        var fdata=jQuery("form[name='msgForm']").serialize();
        
        jQuery.post('<?php echo $this->webroot ?>designations/add/',fdata,function(data) {   
        if(data) {
		//alert("vivek");alert(data.msg);alert(data.type);return false;
               createMsg(data.msg,data.type);
                jQuery("#overlay").hide();
                lists();
                
				if(data.type=='success') {
					jQuery("#companyName").val('Select Company');
					jQuery("#departmentName ").val('Select Department');
					jQuery("#appName ").val('');
					jQuery("#desgCode ").val('');
                    return false;
                }
            }
        },'json').error(function(e) {  alert("Error : "+e.statusText); jQuery("#overlay").hide();   });
	   
    } else {
        return false;
    }
}
function findDepartment(comp_code)
{
	var companyName=jQuery("#companyName").val();//alert(companyName);
	if(companyName=='') {
		var list = '';
		list += "<option value='' >Select Department </option>";
        jQuery("#departmentName").html(list);
        return false;
    }
	$.ajax({
        type:"GET",
        cache:false,        
        //sdata:{data1:comp_code}, 
		url:"<?php echo $this->webroot;?>designations/getDepartment/"+comp_code,	
        success: function (data) {
		//alert(data);
		data = jQuery.parseJSON(data);
		var list = '';
		jQuery("#departmentName").html();
		list += "<option value='' >Select Department </option>";
		$.each(data,function(index,value){
			list += "<option value='" + index + "'>" + value + "</option>";	
		});
		jQuery("#departmentName").html(list);
        }
      });
}
</script>	

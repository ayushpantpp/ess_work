
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Allot Leaves 
            </li>
            <li>
                Leave Allot
            </li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Alloted leaves to employee<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('MstEmpLeaveAllot', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
   ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0"  cellspacing="10" cellpadding="0" align="center" style="margin:0px auto;">
				<tr><?php $employee = array();
				
                  $employee[] = $this->Common->getemplist();
				   
				   ?>
                    <th scope="row"><strong>Employee Name :</strong>  </th>
                    <td><?php echo $this->Form->input('emp_code', array('type'=>'select','options'=>$employee,'empty'=>'Select Employee','class' => 'round_select', 'id' => 'employeeName')); ?>
                        <div id="dCCnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
				<?php $leave = array();
				
                  $leave[] = $this->Common->getLeaveType();
				   
				   ?>
                   
                    <th scope="row"><strong>Leave Name :</strong>  </th>
                    <td><?php echo $this->Form->input('leave_code', array('type'=>'select','options'=>$leave,'empty'=>'Select Leave','class' => 'round_select', 'id' => 'leaveName')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
				<tr>
                   
                    <th scope="row"><strong>No of Leaves:</strong>  </th>
                    <td><?php echo $this->Form->input('allot_leave', array('class' => 'round_select', 'id' => 'appName')); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
				
                <tr>
				    <td colspan="4" align="center">
					<div align="center" class="submit">
					<?php echo $this->Form->button('Submit', array('type' => 'button','class'=>'successButton','id'=>'add')); ?>
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
	echo $this->Form->end
    ?>

</div>

<script>
jQuery("#add").click(function() {       
            doChk();
        });
        
        jQuery("form[name='msgForm']").keypress(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                doChk();
                return false;
            } else {
                
            }
        });
        

        /*Add record script*/       
        function allotlists() {
            var data='<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
            jQuery("#result").html(data);
            var fdata=jQuery("#searchForm").serialize();
            jQuery.post('<?php echo $this->webroot; ?>',
				fdata,
				function(data) {
					
					jQuery("#result").html(data);
					
				},'html'
			).error(function(e) {  alert("Error : "+e.statusText);   });
        }

 </script>
 <script>

function doChk() {
	
    var err=0;
	var employeeName=jQuery.trim(jQuery("#employeeName option:selected").text());
	var leaveName=jQuery.trim(jQuery("#leaveName option:selected").text());
    var appName=jQuery.trim(jQuery("#appName").val());
	//alert("e3 "+employeeName+" e4 "+leaveName+" e5 "+appName+" e6");
	
	 if(employeeName=='Select Employee') {
        jQuery("#dCCnameErr").html("<?php echo "Please input Employee name."; ?>");
        jQuery("#dCCnameErr").focus();
        err++;
        return false;
    } else {
        jQuery("#dCCnameErr").html("");
    }
	if(leaveName=='Select Leave') {
        jQuery("#dCnameErr").focus();
        jQuery("#dCnameErr").html("<?php echo "Please input Leave name."; ?>");
        err++;
        return false;
    } else {
        jQuery("#dCnameErr").html("");
    }
    if(appName=='') {
        jQuery("#dnameErr").html("<?php echo "Please input leaves to be alloted ."; ?>");
        jQuery("#dnameErr").focus();
        err++;
        return false;
    } else {
	jQuery("#dnameErr").html("");}
    
  if(err==0) {
        jQuery("#overlay").show();
        var fdata=jQuery("form[name='msgForm']").serialize();
        
        jQuery.post('<?php echo $this->webroot ?>LeavesType/addallot/',fdata,function(data) {   
        if(data) {
		//alert("vivek");alert(data.msg);alert(data.type);return false;
               createMsg(data.msg,data.type);
                jQuery("#overlay").hide();
                //lists();
                
				if(data.type=='success') {
					jQuery("#employeeName").val('');
					jQuery("#leaveName").val('');
					jQuery("#appName").val('');
					
                    return false;
                }
            }
        },'json').error(function(e) {  alert("Error : "+e.statusText); jQuery("#overlay").hide();   });
	   
    } else {
        return false;
    }
}
</script>	

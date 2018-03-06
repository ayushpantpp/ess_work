<?php
$auth = $this->Session->read('Auth');
//$auth['User']['comp_code'];

?><div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Configurations
            </li>
            <li>
                Access Control
            </li>            
        </ul>
    </div>
</div>
<br>
<div id="add_msg_div" style=" margin-bottom: 160px;">
    <h2 class="demoheaders">Add/View Modules<a href="#" id="create"></a></h2>
    <?php echo $this->Form->create('Module', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
    <div class="travel-voucher" style="padding-bottom: 0;padding-top: 0;height:140px">
        <div class="input-boxs">
            <table  border="0" width="97%" cellspacing="10" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                    <td>
                <tr>
                   <?php $company = $this->Common->findCompanyName();?>
                    <th scope="row"><strong>Select Organization :</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type'=>'select','options'=>$company,'empty'=>'Select Company','class' => 'round_select', 'id' => 'org_name')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
                
   

    	<tr id="serch">
                    <th scope="row"><strong>Search Employee by Name :</strong>  </th>
                    <td><?php echo $this->Form->input('search_text', array('type'=>'text', 'id' => 'search_text')); ?>
                       
			
                    </td>
                </tr>
		<tr>
                     <th scope="row"> </th>
                    <td>
                       
			<?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'search','class'=>'submit-btn')); ?>
                      
                        &nbsp; 	&nbsp; 	&nbsp; 	&nbsp; 
                        <?php echo $this->Form->button('Reset', array('type' => 'reset','class'=>'submit-btn')); ?>
                      
			
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
        
        <h2 class="demoheaders">List Of Employees</h2>
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
       



    });
        /*Add record script*/ 
        
        jQuery("#add").click(function() {   
            	var org_id = jQuery("#org_name").val();
		if(org_id!=''){
		var search_text='';
		userslists(org_id,search_text);
		jQuery("#org_name").css("border","none");
		//jQuery("#serch").css("display","block");
		}else{
		jQuery("#org_name").css("border","1px solid red");
		return false;
		}
		
        });

	jQuery("#reset1").click(function() {   
            	jQuery("#org_name").val('');
		jQuery("#search_text").val('');
		jQuery("#org_name").css("border","none");
		
        });

	
	jQuery("#search").click(function() {   
            var org_id = jQuery("#org_name").val();
            var search_text = jQuery.trim(jQuery("#search_text").val());
		if(org_id==''){
			jQuery("#org_name").css("border","1px solid red");
			return false;
		}else{
			jQuery("#org_name").css("border","none");
			jQuery("#search_text").css("border","none");
	            userslists(org_id,search_text);
		}
        });
       
        
        
        jQuery("form[name='msgForm']").keypress(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                doChk();
                return false;
            } else {
                
            }
        });
        
        jQuery('.option_values').find('input[type=checkbox]').live('click',function(e){
            if($(this).is(':checked')) {
                val = 1;
            }
            else {
                val = 0;
            }
            var org_id = jQuery("#org_name").val();
            var fdata = 'id='+$(this).parent().find('.id').val()+'&value='+val+'&org='+org_id
            console.log(fdata);
            jQuery.post('<?php echo $this->webroot; ?>Configurations/update_value',
                fdata,
                function(data) {
                    // jQuery("#result").html(data);
                    
                    console.log(data);
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });

        });
 
         jQuery('.navigation').find('a').live('click', function (e) {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';

        jQuery("#result").html(data);
        //
       // var fdata = jQuery("#searchForm").serialize();
       
        current_page = jQuery(this).attr('href');
       var org_id = jQuery("#org_name").val();
       //alert(org_id);
        var search_text = jQuery.trim(jQuery("#search_text").val());
        jQuery.post(current_page,  {id:org_id,search_text:search_text}, function (data) {
            jQuery("#result").html(data);

        }, 'html');
        return false;
    });

    jQuery('.head').find('a').live('click', function (e) {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
        jQuery("#result").html(data);
        //var fdata = jQuery("#searchForm").serialize();
        current_page = jQuery(this).attr('href');
        var org_id = jQuery("#org_name").val();
        //alert(org_id);
        var search_text = jQuery.trim(jQuery("#search_text").val());
        jQuery.post(current_page,  {id:org_id,search_text:search_text}, function (data) {
            jQuery("#result").html(data);

        }, 'html');
        return false;
    });
        function userslists(id,search_text) { 
            var data='<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
            jQuery("#result").html(data);
            var fdata=jQuery("#searchForm").serialize();
	    
            jQuery.post('<?php echo $this->webroot; ?>configurations/userslists/',
                {id:id,search_text:search_text},
                function(data) {
                    
                    jQuery("#result").html(data);                    
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });
        }



</script> 
  
<style>
.submit{text-align:left;}
</style>

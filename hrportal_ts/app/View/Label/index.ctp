
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Label Management
            </li>
                       
        </ul>
    </div>
</div>
<br>
<div id="list_msg_div1">
        <h2 class="demoheaders">Label List</h2>
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
                jQuery.get('<?php echo $this->webroot; ?>Labels/delete/'+id,{},function(data) {
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
		   jQuery("#appCode"+id).val();
		
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
           
	    var appName1=jQuery("#appName1").val();
           
            if(err===0) {
				jQuery("#appName"+id).removeAttr('disabled');
				
				jQuery("#appName"+id).attr('disabled',true);
				jQuery("#overlay").show();
				jQuery("#appName1"+id).removeAttr('disabled');
				jQuery("#appName1"+id).val(appName1);
				jQuery("#appName1"+id).attr('disabled',true);
				jQuery("#overlay").show();
                var fdata={'data[Labels][name]':appName1};
                jQuery.post('<?php echo $this->webroot ?>Labels/edit/'+id,fdata,function(data) {  
 
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
            jQuery.post('<?php echo $this->webroot; ?>Labels/lists',
				fdata,
				function(data) {
					
					jQuery("#result").html(data);
					
				},'html'
			).error(function(e) {     });
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
    var err=0;
    var appName=jQuery.trim(jQuery("#appName").val());
	var appCode=jQuery.trim(jQuery("#appCode").val());
    
    if(appName=='') {
        jQuery("#dnameErr").html("<?php echo "Please select company name."; ?>");
        jQuery("#appName").focus();
        err++;
        return false;
    } else {
        jQuery("#dnameErr").html("");
    }
	    if(appCode=='') {
        jQuery("#dcodeErr").html("<?php echo "Please select company code."; ?>");
        jQuery("#appCode").focus();
        err++;
        return false;
    } else {
        jQuery("#dcodeErr").html("");
    }
   if(err==0) {
        jQuery("#overlay").show();
        var fdata=jQuery("form[name='msgForm']").serialize();
        
        jQuery.post('<?php echo $this->webroot ?>Labels/add/',fdata,function(data) {   
        if(data) {
		//alert("vivek");alert(data.msg);alert(data.type);return false;
               createMsg(data.msg,data.type);
                jQuery("#overlay").hide();
                lists();
                
				if(data.type=='success') {
					jQuery("#appName ").val('');
					jQuery("#appCode ").val('');
                    return false;
                }
            }
        },'json').error(function(e) {  alert("Error : "+e.statusText); jQuery("#overlay").hide();   });
	   
    } else {
        return false;
    }
}

</script>	

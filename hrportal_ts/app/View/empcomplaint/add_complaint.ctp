<?php
App::import('Model', 'General');
$General = new General;

App::import('Component', 'Functions');
$Functions = new FunctionsComponent();

?>

 <div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>
           <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li>
               Ticket Master
            </li>
        </ul>
    </div>
</div>

<h2 class="demoheaders">Ticket Master</h2>
      

            <div class="travel-voucher">

      

                    <form name="complaintmaster" method="post" action="/portal/empcomplaint/add_complaint" onsubmit=" return isRadioChecked();">
					 <input type="hidden" name="data[Mstcomplaintmaster][id]" value="<?php echo @$id;?>" />
					 <input type="hidden" name="data[Mstcomplaintmaster][type]" value="<?php echo @$type;?>" />
                        <div class="input-boxs">
                    <fieldset><legend>Add Section: </legend>
                        <table width="100%" cellspacing="1" cellpadding="0" border="0" class="exp-voucher">
                                <tr>
                                    <td align="left" colspan="4"><font size="2pt"><b>Type: </b></font></td>
                                </tr>
								
								 <tr>
								 
                                  <td colspan="4">
								  <?php 
								  foreach($complaintdetails as $index=>$value){?>
								    <font size="2pt"><input type="radio" name="data[Mstcomplaintmaster][status]"<?php if(@$complainData['Mstcomplaintmaster']['status']==$index){?> checked <?php }?>Value="<?php echo $index;?>"  class="rad"/>
								       <?php echo $value; ?>
								    </font> &nbsp;&nbsp;
								  <?php }?>
								
								 </td>
                                 
								</tr> 
                                <tr>

                                
                                    <td align="left" colspan="4"><font size="2pt">
									Enter Value :<input type="text" name="data[Mstcomplaintmaster][formvalue]" id="feed"  maxlength="200" value="<?php echo @$complainData['Mstcomplaintmaster']['formvalue'];?>" ></textarea></font></td>
                               
                                </tr>
								<td align="center" colspan="2">
                                       <?php if(isset($type) && $type=='E'){?>
									         <div class="submit-form"><input type="submit" value="Update" name="data[Update]"></div>
									   <?php }else {?>
                                           <div class="submit-form"><input type="submit" value="Submit" name="data[Submit]"></div>
									   <?php }?>
                                    </td>
                            
                                                                
                                
                            </table>
							</fieldset>
                        </form>
					
					<form name="view" method="post" action="/portal/empcomplaint/add_complaint">
						 <fieldset><legend>Search Section: </legend><table>
						
						 <tr class="vrTableHeader head" align="center">
							 <td><font size="2pt"><b>Search By Type:</b></font></td>
							 <td><select name="data[Mstcomplaintmaster][stat1]">  
                                                                  <option value="0">--Select Type--</option>  
                                <?php if(count($complaintdetails)>0){ foreach($complaintdetails as $key=>$val):?>
                                                                                             
                                 <option value="<?php echo $key; ?>" <?php 
                                ?><?php if(isset($postedid)){echo ($key==$postedid)?'selected':''; }?>><?php echo $val; ?></option>
                                 <?php endforeach; } ?>
                               </select>
							 </td>&nbsp;&nbsp;
							
                                
								<td>
                                           
                                 <div class="submit-form"><input type="submit" value="Search" name='viewsubmit'   ></div>
                                 </td></tr>
								
						
			          </table>
					  <br>
					  <table width="100%" cellspacing="1" cellpadding="0" border="0" class="exp-voucher">
		 <?php if(isset($listdata) && count($listdata)>0 && $len>0){ ?>
						<tr> 
						<td><b>S.no</b></td>
						<td><b>FORM NAME</b></td>
						<td><b>ACTION</b></td>
						</tr>
						 <?php $i=1; 
						 foreach($listdata as $data){ ?>
						<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $data['Mstcomplaintmaster']['formvalue'] ;?></td>
						<td><a href="<?php echo $this->webroot;?>empcomplaint/add_complaint/E/<?php echo $data['Mstcomplaintmaster']['id'];?>"  title="Edit">Edit</a> &nbsp;/&nbsp;
						<a href="<?php echo $this->webroot;?>empcomplaint/add_complaint/D/<?php echo $data['Mstcomplaintmaster']['id'];?>" title="Delete">Delete</a></td>
							  														
						</tr>
						
						<?php $i++;}?>
						
                      <?php  }?>
					  
					     
			          	</table>
						</fieldset>
						
						</form>


                </div>

            </div>
<script>
    
function isRadioChecked(){ 
    //alert(atLeastOneRadio());
if(!$('input[type=radio]:checked').size() > 0){
alert('Please select compaint type');
return false;
}
if($('#feed').val()=='') {
alert('Please Enter the  details.');
return false;
}

return true;


}  

 </script><html><head></head><body></body></html>
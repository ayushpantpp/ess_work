		     <div class="div-pedding2" align="left" style="padding-top:0px;">
			<div align="left" class="div-border1">			   
             <div> <table width="100%" border="0" cellspacing="5" cellpadding="5">
			   <tr>
    <td colspan="2" height="8"></td>
  </tr>
 <tr>
    <td class="label-txt" width="41%" valign="top"></td>
  	<td align="left">
	</td>
   </tr> 
   
  <tr>
    <tD colspan="2" height="8"></tD>
  </tr>
  <tr>
    <td class="label-txt">Upload Coordinates File :</td>
  <td align="left">	
	
	    
	<div id="div-left">
                   
<?php  echo $this->Form->create('Uploadcoordinates',array('url' =>array('controller' => 'Uploadcoordinates', 'action' =>'add'),'type'=>'file','enctype'=>'multipart/form-data','method'=>'post'));
  //echo $this->Form->submit('Upload', array('label' => false, 'required' => true, 'type' => 'submit', 'class' => 'fontSize1')); 

        ?> <label for="req_cat">Upload <span class="req">*</span></label>
	 <?php 
                               echo $this->form->input('file', array('label'=>false, 'type' => 'file', 'class' => "md-input",'required'=>true,'id'=>'first_name'));
                               
                               echo $this->form->input('Mda_code', array('label'=>false, 'type' => 'hidden', 'value' =>$auth['MyProfile']['comp_code'],'class' => "md-input",'readonly'=>true,'required'=>true,'id'=>''));
                               ?>
	</div>
	 <div class="uk-width-1-2uk-margin-top">                            
                        <button type="submit" name="upload" id="add" class="md-btn md-btn-danger" >Upload</button>

                    </div>
	<div class="right1" id="div-right"></div>
	<div class="div-clear"></div>
	</div>
	
			
	</td>
  </tr>
  <tr>
    <tD colspan="2" height="8"></tD>
  </tr>
  
</table></div>

</form>

			 </div>	 
			
			 </div>
		     <div class="div-clear"></div>
		
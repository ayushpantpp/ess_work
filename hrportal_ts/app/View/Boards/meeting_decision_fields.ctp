<?php if($reqID != '' && $flag=='open'){ $reqRef[0]['BMMeetingRequest']['id'];
    ?>
                        <br>

                        <br>
				<div  class="uk-grid" data-uk-grid-margin>

					<div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="req_cat">Meeting Number <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('meet__Num', array('label'=>false,'type' => "text",'disabled'=>'disabled','value'=>$reqRef[0]['BMMeetingRequest']['meeting_number'],'class' => "md-input")); 
                                ?>
                                
                             </div>
                       </div>
                  
                   <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="req_ref">Subject <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('subject', array('label'=>false,'type' => "text",'disabled'=>'disabled','value'=>$reqRef[0]['BMMeetingRequest']['subject'],'required'=>true,'class' => "md-input")); 
                                ?>
                            </div>
                       </div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="dob">Date of Decision <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('dom', array('type' => "text",'label'=>false,'disabled'=>'disabled','required'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY"}','value'=>date("d-m-Y", strtotime($reqRef[0]['BMMeetingRequest']['meeting_date'])),'class' => "md-input")); 
                                ?>
                        </div>
                    </div>
                        </div>
						
        <?php 
//        echo "<pre>";
//        print_r($reqRef);
        
    foreach($reqRef as $keyval=>$rec){
        if($rec['BMMeetingRequestRefnum']['finalize_status']=='0'){
       $reqDet = $this->Common->getReqRefDetailByReqID($rec['BMMeetingRequestRefnum']['request_receive_id']);
       //print_r($reqDet);
    ?>
	<hr style="border-width:5px;border-color: #1976D2;">
<br>

<div  class="uk-grid" data-uk-grid-margin>
 <div class="uk-width-medium-1-4">
        <div class="parsley-row">
            <label for="subject">Request Serial # </label>
            <?php echo $this->form->input('doc.req_ref_serial_no', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>$reqDet['BMReceiveRequest']['req_ref_serial_no'], 'required' => true, 'class' => "md-input"));
                    echo $this->form->input('doc.req_ref_serial_no.', array('type'=>'hidden','label' => false, 'value'=>$reqDet['BMReceiveRequest']['req_ref_serial_no'],'class' => "md-input"));  
            ?>                
        </div>
    </div>
    <div class="uk-width-medium-1-4">
        <div class="parsley-row">
            <label for="subject">Request Number </label>
            <?php echo $this->form->input('reqnum', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>$reqDet['BMReceiveRequest']['reference_num'], 'required' => true, 'class' => "md-input"));
                    echo $this->form->input('reqID.', array('type'=>'hidden','label' => false, 'value'=>$reqDet['BMReceiveRequest']['id'],'class' => "md-input"));  
            ?>                
        </div>
    </div>
    <div class="uk-width-medium-1-4">
        <div class="parsley-row">
            <label for="subject">Subject </label>
            <?php echo $this->form->input('subject', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>$reqDet['BMReceiveRequest']['subject'], 'required' => true, 'class' => "md-input")); ?>                
        </div>
    </div>

 <div class="uk-width-medium-1-4">
        <div class="parsley-row">
            <label for="subject">Date of Ref </label>
            <?php echo $this->form->input('exp', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>date("d/m/Y", strtotime($reqDet['BMReceiveRequest']['date_of_request'])) ,'required' => true, 'class' => "md-input")); ?>                
        </div>
 </div>   
</div>
<div  class="uk-grid" data-uk-grid-margin>

 <div class="uk-width-medium-1-4">
        <div class="parsley-row">
            <label for="subject">Transfer to Committee </label>
            <select name="doc[trns_commi][<?php echo $keyval;?>]" class="md-input data-md-selectize">
                <?php
                $option = $this->Common->findDepartmentList();
                $list = "<option value=' '>--Select--</option>";
                foreach($option as $key=>$rt){
                    $list .= "<option value='".$key."'>".$rt."</option>";
                    }
                echo $list;
                ?>
            </select>
        </div>
    </div>
    
	<div class="uk-width-medium-1-4">
        <div class="parsley-row">
            <label for="subject">Remark  </label>
            <?php echo $this->form->textarea('doc.remark.'.$keyval, array('type'=>'checkbox','label' => false, 'class' => "md-input")); 
            ?>
            
        </div>
    </div>
    <div class="uk-width-medium-1-4">
        <div class="parsley-row">
            <label for="subject">Finalized  </label>
            <?php echo $this->form->input('doc.final.'.$keyval, array('type'=>'checkbox','label' => false, 'class' => "md-input")); 
            //echo $this->Form->checkbox('final.', array('value'=>$reqDet['BMReceiveRequest']['id'],'label' => false, 'class' => "md-input"));
            //echo $keyval."==";
            ?>
            
        </div>
    </div>

    
</div>
        <?php  }elseif($rec['BMMeetingRequestRefnum']['finalize_status']=='1'){
            $reqDet = $this->Common->getReqRefDetailByReqID($rec['BMMeetingRequestRefnum']['request_receive_id']);
    ?>
<br>

<div  class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-5">
        <div class="parsley-row">
            <label for="subject">Request Number </label>
            <?php echo $this->form->input('reqnum', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>$reqDet['BMReceiveRequest']['reference_num'], 'required' => true, 'class' => "md-input"));
                    echo $this->form->input('reqID.', array('type'=>'hidden','label' => false, 'value'=>$reqDet['BMReceiveRequest']['id'],'class' => "md-input"));  
            ?>                
        </div>
    </div>
    <div class="uk-width-medium-1-5">
        <div class="parsley-row">
            <label for="subject">Subject </label>
            <?php echo $this->form->input('subject', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>$reqDet['BMReceiveRequest']['subject'], 'required' => true, 'class' => "md-input")); ?>                
        </div>
    </div>
    <div class="uk-width-medium-1-5">
        <div class="parsley-row">
            <label for="subject">Date of Ref </label>
            <?php echo $this->form->input('exp', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>date("d/m/Y", strtotime($reqDet['BMReceiveRequest']['date_of_request'])) ,'required' => true, 'class' => "md-input")); ?>                
        </div>
    </div>

    <div class="uk-width-medium-1-5">
        <div class="parsley-row">
            <label for="subject">Transfer to Committee </label>
            <select disabled="disabled" class="md-input data-md-selectize">
                <?php
                $option = $this->Common->findDepartmentList();
                $list = "<option value=' '>--Select--</option>";
                foreach($option as $key=>$rt){
                    $list .= "<option value='".$key."'>".$rt."</option>";
                    }
                echo $list;
                ?>
            </select>
        </div>
    </div>
    <div class="uk-width-medium-1-5">
        <div class="parsley-row">
            <label for="subject">Finalized  </label>
            <?php //echo $this->form->input('doc.final.'.$keyval, array('type'=>'checkbox','label' => false,'checked'=>'checked', 'class' => "md-input")); 
            //echo $this->Form->checkbox('final.', array('value'=>$reqDet['BMReceiveRequest']['id'],'label' => false, 'class' => "md-input"));
            echo "<br>"."&#10004;";
            ?>
            
        </div>
    </div>

    
</div>
<?php }   
        }
?>
<hr style="border-width:5px">		
<?php
}else{
	
    echo "<br/>Sorry, there is no record !!!!";
    
} ?>

<?php
        //$listing = '<option value=" ">--Select--</option>';
$counter = count($reqRef);
        foreach($reqRef as $key=>$rt){
            $listing .= '<option value='.$key.'>'.$rt.'</option>';
            $keies .= $key;
    }
        ?>
<script>
//    $(document).ready(function(){
//    $('#reqref').change(function() { 
//      self = $(this);
//      choosen = $(this).val();
// 
//      $('#reqref').not(self).each(function() {
// 
//        if ($(this).val() == choosen) {
// 
//          // $(this).prop('disabled', true);
//          alert('Temporary Component is already selected');
//          $(self).val($(this).find("option:first").val());
//        }
// 
//      });
// 
//    });
//  });
  </script>
<script>
  function fieldsDisable(val,divid){ 
      
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/meeting_fields/' + val,
            //data:'project_id='+val,
            success: function (data) {
                $("#"+divid).html(data);
                
            }
        });
        
    }
    
</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <h1>Enter Meeting Request</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                  <h3 class="heading_a">Meeting Request</h3>
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Boards', 'action' =>'req_meeting_save'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                ?><br>
                  <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="req_cat">Meeting Number</label>
                                <?php echo $this->form->input('meet_Num', array('type'=>'text','label'=>false, 'disabled'=>'disabled','value'=>$MeetNum,'required'=>true,'class'=>"md-input"));
                                echo $this->form->input('meetNum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$MeetNum,'class'=>"md-input"));
                                  ?>
                             </div>
                       </div>
                       <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="req_ref">Subject <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('subject', array('label'=>false,'type' => "text",'required'=>true,'class' => "md-input")); 
                                ?>
                        </div>
                       </div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="dob">Date of Meeting <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('dom', array('type' => "text",'label'=>false,'required'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY"}','class' => "md-input")); 
                                ?>
                        </div>
                    </div>
                </div>
				<div class="uk-grid data-uk-grid-margin uk-grid-margin uk-row-first" >
					<div class="uk-width-medium-1-3">
						<div class="parsley-row">
							<label for="subject">Subject </label>
							<div class="input text"><input name="data[sub]" value="" class="md-input" id="sub" type="text"></div>                
						</div>
					</div>

					<div class="uk-width-medium-1-3">
						<div class="parsley-row">
							<label for="subject">Department</label>
							<div class="input text"><input name="data[dep]" value="" class="md-input" id="dep" type="text"></div>                     
						</div>
					</div>

					<div class="uk-width-medium-1-3">
						<div class="parsley-row">
							<label for="subject">Date of Request</label>
							<div class="input text"><input name="data[dor]" value="" data-uk-datepicker='{format:"DD-MM-YYYY"}' class="md-input" id="dor" type="text"></div>                    
						</div>
					</div>
				</div>
				
				<div class="uk-grid data-uk-grid-margin uk-grid-margin uk-row-first" >
					<div class="uk-width-medium-1-2">
						<div class="parsley-row">
							<label for="subject">Attachement <br/>(to be send as attachment in mails) </label>
							<div class="input text  md-btn md-btn-primary uk-file-form"><input class="doc_upload" type="file" data-parsley-id="10" id="form-file" name="data[doc_upload]"></div>                
						</div>
					</div>

					<div class="uk-width-medium-1-2">
						<div class="parsley-row">
                            <label for="kUI_multiselect_basic" class="uk-form-label">List of Users<br/>(to send meeting mails)</label>
							<?php
							$allUsers = $this->Common->getAllEmpList();
										//print_r($allUsers);
							?>
                            
                            <select id="kUI_multiselect_basic" name="data[users][]" required="" id="users_id" multiple="multiple" data-placeholder="Select Users...">
                                <?php 
										
                                        foreach ($allUsers as $k => $val) {
									
                                           /*  if($k == $editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['competency_id']){
                                                $selected = "selected = 'selected'";                                                
                                            }else{
                                                $selected = "";
                                            } */
                                    ?>
                                    <option value='<?php echo $val['MyProfile']['emp_id'] ?>' <?=$selected?>> <?php echo ucfirst($val['MyProfile']['emp_full_name']);?></option>
                            <?php } ?>
                            </select>
                                <?php ?>
                        </div>
					</div>
					
				</div>
                  
                  
                  
               <div id='TextBoxesGroup'   data-uk-grid-margin>
                    <br>
                            <div class="uk-grid"  data-uk-grid-margin>
                            <div class="uk-width-medium-1-3" >
                                <div class="parsley-row">
                                    <label for="cc_num">Request Reference Number: <span class="req">*</span></label>
                                    <select name="req_ref[]" id="reqref_1" required="true" onchange="fieldsDisable(this.value,'1')" class="md-input data-md-selectize">

                                                    <?php
                                                    $list = "<option value=' '>--Select--</option>";
                                                    foreach($reqRef as $key=>$rt){
                                                        $list .= "<option value='".$key."'>".$rt."</option>";
                                                }
                                                    echo $list;
                                                    ?>
                                                </select>
                                </div>
                            </div>
                            </div>
                    <div class="uk-grid data-uk-grid-margin" id="1"></div>
                    </div>
        
                <div class="uk-grid" data-uk-grid-margin><br>
                    <div class="uk-width-1-1">      <br>                  
                <input type='button' class="md-btn md-btn-primary"  value='Add More' id='addButton'>
                <input type='button' class="md-btn md-btn-danger" value='Remove' id='removeButton'>         
            </div>
                    </div>
                
                <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('req_meeting') ?>">Cancel</a>                       
                    </div>
                </div>
                </div>
        
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>



<script type="text/javascript">
 
$(document).ready(function(){
  
    var counter = 2;
    var val = '<?php echo $listing;?>';
   
   
    $("#addButton").click(function () { 
   
    if(counter>5){
            alert("Only 5 request can arange for this meeting !");
            return false;
    }
 
    var newTextBoxDiv = $(document.createElement('div'))
         .attr({id:'TextBoxDiv' + counter,class:"'uk-grid'  data-uk-grid-margin"});
 
    newTextBoxDiv.after().html('<br><div class="uk-width-medium-1-3" margin-bottom><div class="parsley-row ">'+
                            '<label for="upl_doc">Requst Reference Number: <span class="req"><sup>*</sup>&nbsp;</span></label>'+
                                '<select name="req_ref[]" onchange="fieldsDisable(this.value,'+counter+')"  required="required" class="md-input data-md-selectize ">'+
                                '<option value=" ">--select--</option>'+
                                   val+'</select>'+
                        '</div></div>'+
                        '<div class="uk-grid data-uk-grid-margin" id="'+counter+'"></div>');
 
    newTextBoxDiv.appendTo("#TextBoxesGroup");
 
 
    counter++;
     });
 
     $("#removeButton").click(function () {
    if(counter==1){
          alert("No more textbox to remove");
          return false;
       }
    counter--;
        $("#TextBoxDiv" + counter).remove();
     });    
  });
</script>


<!-- page content -->

<?php $Folder_list = array('1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E');?>
<script type="text/javascript">
    $('.remark').bind('keyup blur', function () {
        var node = $(this);
                node.val(node.val().replace(/[^\w ]/$, '')); }
    );
</script> 

<script>
    
    function check(){
         var dol = $('#dol').val();
    var dor = $('#dor').val();
   
 if(dol!='' && dor!=''){ 
        var date11 = Date.parse(dol);
        var date22 = Date.parse(dor);

        if (date11 > date22) {
            alert ("Receiving Date should be greater than  Date of Letter !!");
            return false;
        }
        
   }
    }
    
    
    
    function fieldsDisable(){
        var val=jQuery("#type").val();
        var level=jQuery("#level").val();
        
        if(level != '' && val !=''){
        if((level != '4' && val=='0') || (level == '4' && val=='1')){
           
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/fields/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#newfield").html(data);
            }
        });
        }else{
         alert('Please select valid TYPE !');
            return false;
        }
        }
       
    }
    
    function getlevelfolder(val){
        
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/levelfolder/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#forfolder").html(data);
                
                
            }
        });
        if(val != '' && val != '4'){
            var fieldval = '0';
            $("#typemail").hide();
            $("#typefile").show();
            $("#type_mail").attr('disabled',true);
        }else{
            var fieldval = '1';
            $("#typemail").show();
            $("#typefile").hide();
            $("#type_mail").attr('disabled',false);
            $("#type_file").attr('disabled',true);
        }
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/fields/' + fieldval,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#newfield").html(data);
            }
        });
        
    }
    
  function ministrydata(val){
  
  if(val == '0'){
      $("#min").show();
      $("#ministry").attr('required',true);
      $("#ministry").attr('disabled',false);
  }else{
       $("#min").hide();
       $("#ministry").attr('required',false);
       $("#ministry").attr('disabled',true);
  }
  
  
  }  
  
</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="heading_actions">
                
            </div>
            <h1>Project Tracking System </h1>
            </div>
    
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Documents', 'action' =>'createFolder'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); ?>
               <!-- <h3 class="heading_a">Budget Information</h3>-->
                
                <!--<div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row md-input-wrapper md-input-filled ">
                                <font color='red' size='2'><b> Notes* =></b> Level-0:PSC/ Level-1:Ministry code/ Level-2:Department code/ Level-3:File number/ Level-4:Sub file number</font>
                        </div>
                       </div>
                </div>-->
                  <div class="uk-width-medium-1-1"  style="float:right; text-align:right;" >
                       <a class="md-btn md-btn-primary" id="showdiv1"> View</a> 
                        <a class="md-btn md-btn-success" id="showdiv2"> Edit</a>                      
                                           
                   
               </div>
              <div class="uk-width-medium-1-1" id="div1">
              
             
             
  <h3>Budget Information List</h3>
 
  
   
                
                
                
                
    <div class="uk-overflow-container uk-margin-bottom uk-width-medium-1-1" style="margin-top:10px;">
      <table id="example" class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" width="100%;">
        <thead>
          <tr class="headings">
            <th>Sr.No. </th>
            <th>Type </th>
            <th>Billable Amount </th>
            <th>Received Amount </th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr class="even pointer">
            <td class=" ">01</td>
            <td class=" ">License</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>
          <tr class="odd pointer">
            <td class=" ">02</td>
            <td class=" ">Implementation Cost</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>
          <tr class="even pointer">
            <td class=" ">03</td>
            <td class=" ">Configuration Charges</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>
          <tr class="odd pointer">
            <td class=" ">04</td>
            <td class=" ">Other Charges</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>
          <tr class="even pointer">
            <td class=" ">05</td>
            <td class=" ">Miscleneous Cost</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>
          <tr class="odd pointer">
            <td class=" ">06</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>
          <tr class="even pointer">
            <td class=" ">07</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>
          <tr class="odd pointer">
            <td class=" ">08</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>
         <!-- <tr class="even pointer">
            <td class=" ">09</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>
          <tr class="odd pointer">
            <td class=" ">10</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
            <td class=" ">&nbsp;</td>
          </tr>-->
        </tbody>
      </table>
    </div>
    <div class="clearfix"></div>
</div>

<div class="uk-width-medium-1-1" id="div2" style="display:none;">
 <h3>Budget Information</h3>
 
               
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" id="forfolder">
                            <div class="parsley-row md-input-wrapper md-input-filled" >
                                <label for="folder" class="">Type <span class="req">*</span></label>
                                <select id="ContractType" class="data-md-selectize label-fixed" required>
                      <option value="press" selected="Fixed">License</option>
                      <option value="">License1</option>
                      <option value="net">Select</option>
                    </select>
                               
                             </div>
                       </div>
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row md-input-wrapper md-input-filled " id="typefile">
                                <label for="type">Status <span class="req">*</span></label>
                                 <input type="text" id="Status" name="ProjectID" required class="md-input">
                               
                            </div>
                           
                       </div>
                    </div>
 
 <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row md-input-wrapper md-input-filled " id="typefile">
                                <label for="type">Budgeted Effort <span class="req">*</span></label>
                                 <input type="text" id="BudgetedEffort" name="BudgetedEffort" required class="md-input">
                               
                            </div>
                           
                       </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row md-input-wrapper md-input-filled " id="typefile">
                                <label for="type">Billable Amount <span class="req">*</span></label>
                               
                                 <input type="text" class=" md-input" disabled="disabled" placeholder="Billable Amount" id="BillableAmount">
                                
                            </div>
                           
                       </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-2">
                            <div class="parsley-row md-input-wrapper md-input-filled " id="typefile">
                                <label for="type">Received Amount <span class="req">*</span></label>
                               
                                 <input type="text" class=" md-input" disabled="disabled" placeholder="Billable Amount" id="ReceivedAmount">
                                
                            </div>
                           
                       </div>
                
                    <div class="uk-width-medium-1-2" id = "reason_div">
                        <div class="parsley-row">
                            <label for="message">Remark*</label>
                             <textarea id="message" required class="md-input" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                          data-parsley-validation-threshold="10"></textarea>
                             </div>
                    </div>
                    
                       
                </div>
                
                 
                
                
                
                
            
                
                 
                



               
                
                
                
                
               
                    
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit"  class="md-btn md-btn-success" onclick="return check();" href="#">Save</button> 
                         <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>                        
                    </div>
                </div>
                
                </div>
                <?php echo $this->Form->end();?>
                
            </div>
            
           </div>
   </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
$(function() {
    $('#showdiv1').click(function() {
        $('div[id^=div]').hide();
        $('#div1').show();
    });
    $('#showdiv2').click(function() {
        $('div[id^=div]').hide();
        $('#div2').show();
    });

    $('#showdiv3').click(function() {
        $('div[id^=div]').hide();
        $('#div3').show();
    });

    $('#showdiv4').click(function() {
        $('div[id^=div]').hide();
        $('#div4').show();
    });

});
});
</script>

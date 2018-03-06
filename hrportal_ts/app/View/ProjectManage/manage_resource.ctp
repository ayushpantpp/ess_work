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
  <h3>Manage Resource List</h3>
    <div class="uk-overflow-container uk-margin-bottom uk-width-medium-1-1" style="margin-top:10px;">
   
      <table id="example" class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" width="100%;">
                <thead>
                  <tr class="headings">
                    <th>Sr.No. </th>
                    <th>Role </th>
                    <th>Name </th>
                    <th>Reporting To</th>
                    <th>Region </th>
                    <th>Zone </th>
                    <th>Joining Date </th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="even pointer">
                    <td class=" ">01</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                  <tr class="odd pointer">
                    <td class=" ">02</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td><td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                  <tr class="even pointer">
                    <td class=" ">03</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td><td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                  <tr class="odd pointer">
                    <td class=" ">04</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td><td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                  <tr class="even pointer">
                    <td class=" ">05</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td><td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                  <tr class="odd pointer">
                    <td class=" ">06</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td><td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                  <tr class="even pointer">
                    <td class=" ">07</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td><td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                  <tr class="odd pointer">
                    <td class=" ">08</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td><td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                  <tr class="even pointer">
                    <td class=" ">09</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td><td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                  <tr class="odd pointer">
                    <td class=" ">10</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td><td class=" ">&nbsp;</td>
                    <td class=" ">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
    </div>
    <div class="clearfix"></div>
</div>
<div class="uk-width-medium-1-1" id="div2" style="display:none;">
 <h3>Manage Resource</h3>
 
 				<div class="uk-grid" data-uk-grid-margin>
               <div class="uk-width-medium-1-2" id="forfolder">
                            <div class="parsley-row md-input-wrapper md-input-filled" >
                  <label class="" for="first-name">Role <span class="required">*</span> </label>
                 
                     <select id="ContractType" class="data-md-selectize label-fixed" required>
                      <option value="press" selected="Active">Active</option>
                      <option value="">Inactive</option>
                      <option value="net">Select</option>
                    </select>
                  </div>
                  
                </div>
               <div class="uk-width-medium-1-2" id="forfolder">
                            <div class="parsley-row md-input-wrapper md-input-filled" >
                  <label class="" for="last-name">Reporting To<span class="required">*</span> </label>
                 
                  <select id="ContractType" class="data-md-selectize label-fixed" required>
                      <option value="press" selected="Active">Active</option>
                      <option value="">Inactive</option>
                      <option value="net">Select</option>
                    </select>
                   
                  </div>
                </div>
                </div>
                 <div class="uk-grid" data-uk-grid-margin>
               <div class="uk-width-medium-1-2" id="forfolder">
                            <div class="parsley-row md-input-wrapper md-input-filled" >
                  <label for="middle-name" class="">Name</label>
                 
                     <input type="text" id="ProjectID" name="ProjectID" required class="md-input">
                  </div>
                </div>
               <div class="uk-width-medium-1-2" id="forfolder">
                            <div class="parsley-row md-input-wrapper md-input-filled" >
                  <label for="middle-name" class="">Region		</label>
                 
                      <select id="ContractType" class="data-md-selectize label-fixed" required>
                      <option value="press" selected="Active">Active</option>
                      <option value="">Inactive</option>
                      <option value="net">Select</option>
                    </select>
                  </div>
                </div>
                </div>
                 <div class="uk-grid" data-uk-grid-margin>
               <div class="uk-width-medium-1-2" id="forfolder">
                            <div class="parsley-row md-input-wrapper md-input-filled" >
                  <label for="middle-name" class="">Zone</label>
                 
                     <select id="ContractType" class="data-md-selectize label-fixed" required>
                      <option value="press" selected="Fixed">Fixed</option>
                      <option value="">Variable</option>
                      <option value="net">Select</option>
                    </select>
                  </div>
                </div>
               <div class="uk-width-medium-1-2" id="forfolder">
                            <div class="parsley-row md-input-wrapper md-input-filled" >
                  <label for="CRRDate" class="">Joining Date</label>
                 
                    <input type="text" id="ExpectedDate" name="Expected Date" data-uk-datepicker = "{format:'DD-MM-YYYY',minDate:'01-01-2018'}" required class="md-input">
                   </div>
                </div>
                </div>
                <div class="uk-grid">
                  <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit"  class="md-btn md-btn-success" onclick="return check();" href="#">Save</button> 
                         <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>                        
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

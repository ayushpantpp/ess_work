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
                 <div class="uk-width-medium-1-1" style="float:right; text-align:right;">
                       <a class="md-btn md-btn-primary" id="showdiv1"> View</a> 
                        <a class="md-btn md-btn-success" id="showdiv2"> Edit</a>                      
                                           
                   
                </div>
                <!--<div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row md-input-wrapper md-input-filled ">
                                <font color='red' size='2'><b> Notes* =></b> Level-0:PSC/ Level-1:Ministry code/ Level-2:Department code/ Level-3:File number/ Level-4:Sub file number</font>
                        </div>
                       </div>
                </div>-->
              <div class="uk-width-medium-1-1" id="div1">
  <div class="">
    <h3>Budget Information List</h3>
    <div class="uk-overflow-container uk-margin-bottom">
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
</div>

<div class="uk-width-medium-1-1" id="div2" style="display:none;">
 <h3>Budget Information</h3>
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" >
                            <div class="parsley-row md-input-wrapper md-input-filled">
                                <label for="folder" class="">Levels <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('level', array('type' => "select",'id'=>'level','label'=>false,'required'=>true,'empty' => ' -- Select File --', 'options' => $Folder_list,'onchange'=>'getlevelfolder(this.value)', 'class' => " data-md-selectize label-fixed")); 
                                ?>
                             </div>
                       </div>
                       
                    </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" id="forfolder">
                            <div class="parsley-row md-input-wrapper md-input-filled" >
                                <label for="folder" class="">Parent Files <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('folder', array('type' => "select",'label'=>false,'required'=>true,'empty' => ' -- Select File --', 'options' => $Folder_list, 'class' => " data-md-selectize label-fixed")); 
                                ?>
                             </div>
                       </div>
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row md-input-wrapper md-input-filled " id="typefile">
                                <label for="type">Type <span class="req">*</span></label>
                                <?php
                                echo $this->form->input('typefile', array('label'=>false, 'type' => 'text','value'=>'File','class' => "md-input"));
                               
                                
//                                echo $this->form->input('type', array('label'=>false, 'type' => 'select','readonly'=>true, 
//                    'options' => array(' '=>'--Select--','0' => 'File'),
//                    'class' => "data-md-selectize",'required'=>true,'id'=>'type_file','default'=>'0','onChange'=>'fieldsDisable(this.value);')); 
                                ?>
                            </div>
                           <div class="parsley-row md-input-wrapper md-input-filled " id="typemail" style="display: none">
                                <label for="type">Type <span class="req">*</span></label>
                                <?php
                                echo $this->form->input('typemail', array('label'=>false, 'type' => 'text','value'=>'Mail','class' => "md-input", 'disabled'=>true));
                                echo $this->form->input('type', array('label'=>false, 'id'=>'type_mail','value'=>'1' ,'disabled'=>true ));

//                                echo $this->form->input('type', array('label'=>false, 'type' => 'select','readonly'=>true,
//                    'options' => array(' '=>'--Select--','1' => 'Mail'),
//                    'class' => "data-md-selectize",'required'=>true,'id'=>'type_mail','default'=>'1','onChange'=>'fieldsDisable(this.value);')); 
                                ?>
                        </div>
                       </div>
                    </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div id="newfield" ></div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin>
                    
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

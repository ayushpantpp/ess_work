<script>
	function addmorefield(){
        //alert('hiiii');
         $('#clonefield').clone().appendTo('#newclone');
         var c = $('#clone_count').val();
         c++;
        $('#clone_count').val(c);
        if($('#clone_count').val()>='2'){
             $('#remove').show();
         }
    }
    
    function removefield(){
        $("#newclone #clonefield:last").remove();
        var c = $('#clone_count').val();
         c--;
         if(c=='1'){
             $('#remove').hide();
         }
        $('#clone_count').val(c);
    }
  function getDataTypeForm(val){ 
      
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/data_type_details_form/' + val,
            //data:'project_id='+val,
            success: function (data) {
                $("#TextBoxesGroup").html(data);
                
            }
        });
        
    }
    
</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <h1>Capture Data Type Details</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                  <h3 class="heading_a">Data Type Details</h3>
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Boards', 'action' =>'data_type_details'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                ?><br>
                  <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" style="height:75px" >
                            <div class="parsley-row">
                                <label for="req_cat">Data Type <span class="req">*</span></label>
                                <select name="data_type_id" required="true" onchange="getDataTypeForm(this.value)" class="md-input data-md-selectize">
                                    <?php
                                    $list = "<option value=' '>--Select--</option>";
                                    foreach($DataType as $key=>$rt){
                                        $list .= "<option value='".$key."'>".$rt."</option>";
                                        }
                                    echo $list;
                                    ?>
                                </select>
                                
                             </div>
                       </div>
                  </div>
                      <div  id='TextBoxesGroup'></div>
                  
               
        
                
                
                
        
                <?php echo $this->Form->end();?>
            
           </div>
   </div>
</div>

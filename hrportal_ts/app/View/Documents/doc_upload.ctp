<script>
    function fieldsDisable(){
        if($('#chk').is(':checked')){
             $('#Restrict').attr('disabled','disabled'); 
          } else {
             $('#chk').attr('disabled','disabled');
          }
    }
    function fileDownload(fileid){
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Documents/download/' + fileid,
            //data:'project_id='+val,
            success: function (data) {
                //location.reload(); 
            }
        });
      
 }
</script>
<div id="page_content">
    <div id="page_content_inner">
       <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
        <div class="md-card-toolbar">
           <?php $page=$_SESSION['page'];?>
                            <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                             //echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$page)); ?>
                              </div>
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                               <b>Document Management</b>
                            </h3>
                        </div>
            <div class="md-card-content large-padding">
                 
                <?php echo $this->Form->create('document', array('url' =>array('controller' => 'Documents', 'action'=>'add'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked','enctype'=>"multipart/form-data" )); ?>
                <h3 class="heading_a">Document Upload </h3>
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="folder">Catagory <span class="req">*</span></label>
                                <?php   $catagory = $this->Common->finddocumentlist();
		                echo $this->form->input('catagory', array('type' => 'select', 'options' => $catagory, 'label'=>false,'required'=>true, 'id'=>'appName', 'class' => "md-input")); 
								   
															  ?>
								
                             </div>
                       </div>
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="folder">Document Name <span class="req">*</span></label>
                                <?php
                                echo $this->form->input('doc_name', array('label'=>false, 'type' => 'text', 'id'=>'docName', 'class' => "md-input",
                   
                    'required'=>true)); ?>
                        </div>
                       </div>

                   
                </div> 
                 <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                               <label for="remark">Document Description</label>
                            <?php echo $this->form->textarea('Desc', array('label'=>false,'class'=>"md-input",'id'=>'docdesc')); ?>   
                           
                             </div>
                       </div>
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="remark">Document Upload</label>
                           
                            <?php echo $this->form->input('files', array('label'=>false,'type'=>'file','class'=>"md-input",'id'=>'appfile','required'=>true)); ?> <font color="red">"Documents extension should be jpg*,txt*,png*,pdf*,doc*,docx* only";<br>
                          "Office Gallery extensions should be jpg* or png* only".</font>   
                        </div>

                       </div>

                  
                 <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                               <label for="remark">Open For All </label>
                            <?php echo $this->form->checkbox('all', array('label'=>false,'id'=>'chk','onclick'=>'return fieldsDisable(this.value);')); ?>   
                           
                             </div>
                       </div>
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="remark">Restricted for All</label>
                           <?php echo $this->form->checkbox('Access', array('label'=>false,'id'=>'Restrict','onclick'=>'return fieldsDisable(this.value);' )); ?>     
                        </div>
                       </div>
                   </div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <input type="submit" class="md-btn md-btn-primary" value="Submit"  id="add" name='post_Salary'>          
                    </div>
                    <div></div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('/Documents/doc_upload') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </div>
           
           </div>

   </div>

 
   <div>
<div>
</div>

    <div >
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
            <div class="md-card-toolbar">
           <?php $page=$_SESSION['page'];?>
                            <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                                echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$page)); ?>
                              </div>
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                               <b>List of Document List</b>
                            </h3>
                        </div>
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">Sr.No</th>
                                    <th>Catagory </th>
                                    <th>Document Name</th>
                                    <th>Document Description </th>
                                    <th>Open for All </th>
                                    <th>Restricted Access</th>
                                    <th>Download</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
                            $i=1;

                            foreach($Documentlist as $Docmaster){ 
                              //print_r($Docmaster);?>
                            <tr>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->finddocumentlistBycode($Docmaster['Documentlist']['catagory']);?></span></td>
                               
                             
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $Docmaster['Documentlist']['document_name'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $Docmaster['Documentlist']['document_desc'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php 
  
if($Docmaster['Documentlist']['open_all']=='1')
{
    
             echo $this->Form->checkbox('openall', array('class' => 'round_select', 'checked' => 'true', 'label' => false, 'id' => 'apphd' . $Docmaster['Documentlist']['restricted_access'], 'value' => $Docmaster['Documentlist']['restricted_access']))?></span>
            </td> 
            <?php 
}
else if($Docmaster['Documentlist']['open_all']=='0')
{
    
  echo $this->Form->checkbox('open_all', array('class' => 'round_select',  'label' => false, 'id' => 'apphd' . $Docmaster['Documentlist']['open_all'], 'value' => $res['Documentlist']['open_all']))?></span>
            </td> 
            <?php }?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"> <?php 
  
if($Docmaster['Documentlist']['restricted_access']=='1')
{
    
             echo $this->Form->checkbox('access', array('class' => 'round_select', 'checked' => 'true', 'label' => false, 'id' => 'apphd' . $Docmaster['Documentlist']['restricted_access'], 'value' => $Docmaster['Documentlist']['restricted_access']))?></span>
            </td> 
            <?php 
}
else if($Docmaster['Documentlist']['restricted_access']=='0')
{
    
  echo $this->Form->checkbox('access', array('class' => 'round_select',  'label' => false, 'id' => 'apphd' . $Docmaster['Documentlist']['restricted_access'], 'value' => $res['Documentlist']['restricted_access']))?></span>
            </td> 
            <?php }?></span></td>

            <?php 

             $filename=$Docmaster['Documentlist']['file'];
             $extension=explode(".",$filename);
                   $ext=$extension[1];

            if(!( $ext == 'doc' || $ext == 'docx' || $ext=='xls'))
            {
              
              ?>
 <td><span class="uk-text-small uk-text-muted uk-text-nowrap"> <input data-file="<?php echo $this->Html->url('/uploads/document/'.$Docmaster['Documentlist']['file']);?>" class="btnShow" type="button" value="View" /></a> 

</span></td>
<?php }
else{ 

 ?>
  <td><span class="uk-text-small uk-text-muted uk-text-nowrap">  <a class="uk-badge uk-Primary-Primary" href="<?php echo $this->webroot.'Documents/download/'.$Docmaster['Documentlist']['file']; ?>" target="_blank">Download</a> 

</span></td>
<?php }
?>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php 
//                                        echo $this->Html->link(__('Update'), array('action' => 'edit', $Docmaster['Docmaster']['id'])); ?> 
                                                    <?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $Docmaster['Docmaster']['id'])
//                                , array(), __('Are you sure you want to delete # %s?', $Docmaster['Docmaster']['id'])); ?>
                                        
                                       
                                        <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/Documents/delete/'.$Docmaster['Documentlist']['id']); ?>" onclick="return confirm('Are you sure?');">Delete</a></span>
                                </td>
                                
                            </tr>
                            <?php  $i++; }?>
                        </tbody>
                    </table>
                </div>
        <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-1">
              <ul class="uk-pagination uk-pagination-right">
                  
                  <?php
                  echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                  echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                  ?>
              </ul>
                </div>
            </div>
            </div>
        </div>
   </div>
</div>


</div>


<script type="text/javascript">
    $(function () {
	
       
        $(".btnShow").click(function () {
		 var fileName = $(this).data("file");
    
        $("#dialog").dialog({
                modal: true,
                title: fileName,
                width: 800,
                height: 550,
                buttons: {
                    Close: function () {
                        $(this).dialog('close');
                    }
                },
				
                open: function () {
                    var object = "<object data=\"{FileName}\"  width=\"800px\" height=\"400px\">";
                    object += "If you are unable to view file, you can download from <a href = \"{FileName}\">here</a>";
                    
                    object += "</object>";
                    object = object.replace(/{FileName}/g, "" + fileName);
                    
                    $("#dialog").html(object);
                }
            });
        });
    });
     function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>Documents/doc_upload/"+val; 

 }
</script>

<div id="dialog" style="display: none">
</div>


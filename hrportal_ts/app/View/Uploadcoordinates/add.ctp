                  
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Upload Data</h1>
    </div>
    <div id="page_content_inner">
      <?php $flash = $this->Session->flash(); if($flash){  ?>
    <div data-uk-alert="" class="uk-alert uk-alert-Success">
        <a class="uk-alert-close uk-close" href="#"></a>
        <?php echo $flash;?>
    </div>
    <?php }?>
        <div id="alerts"></div>
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php  echo $this->Form->create('Uploadcoordinates',array('url' =>array('controller' => 'Uploadcoordinates', 'action' =>'add'),'type'=>'file','enctype'=>'multipart/form-data','method'=>'post','class' => 'uk-form-stacked'));
                 
                
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat">Upload <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('file', array('label'=>false, 'type' => 'file', 'class' => "md-input",'required'=>true,'id'=>'first_name'));
                               
                               echo $this->form->input('Mda_code', array('label'=>false, 'type' => 'hidden', 'value' =>$auth['MstMda']['mda_code'],'class' => "md-input",'readonly'=>true,'required'=>true,'id'=>''));
                               ?>
                        </div>
                    </div>
                   



                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-2uk-margin-top">                            
                        <button type="submit" name="upload" id="add" class="md-btn md-btn-primary" >Upload</button>

                    </div>
                    
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('/Users/dashboard') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>

</div>
</div>

</div>

        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
             <h3 class="heading_b uk-margin-bottom">Upload DataList </h3>
                </div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>

                               <th>Sr.No</th>
                                    <th>MDA NAME </th>
                                    <th>KRA ID</th>
                                    <th>User Name </th>
                                   
                                    <th>email</th>
                                    <th>Personal Number</th>
                                    <th>Status</th>
                                
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (empty($Documentlist)) { ?>
                                <tr class="even-pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                       
                            <?php 
                            $i=1;

                            foreach($Documentlist as $Docmaster){ 

                            
                             ?> 
                                <tr class = "<?php echo $class; ?>">
                                    <td><?php echo $i;?></td> 
                                    <td> <span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $this->Common->findMdaNameByCode($Docmaster['UserDetail']['comp_code']); ?></span></td>
                                    <td> <span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $Docmaster['UserDetail']['emp_id'];?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $Docmaster['UserDetail']['user_name'];?></span></td>
                                   
                                    <td><span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $Docmaster['UserDetail']['email'];?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $Docmaster['UserDetail']['personal_number'];?></span></td>   <?php 

                         $status=$Docmaster['UserDetail']['status'];
if($status==1)
{
                

                        ?>  <td><span class="uk-text-small uk-text-muted uk-text-truncate">Active</span></td><?php }
                        else {
 
                          ?>                        
                      <td><span class="uk-text-small uk-text-muted uk-text-truncate"> Inactive </span>                 
                    </td><?php }?>
                                   
                    <?php 

                         $status=$Docmaster['UserDetail']['status'];
if($status==1)
{
                

                        ?> <td><span class="uk-text-small uk-text-muted uk-text-truncate"> <a href="javascript:void(0);" 
                          mid="<?php  echo $Docmaster['UserDetail']['id'];?>"  class="update"><i class="md-btn md-btn-primary">Inactive</i></a><span>                 
                    </td><?php }
                        else {
 
                          ?>                        
                      <td><span class="uk-text-small uk-text-muted uk-text-truncate">Inactive </span>                 
                    </td><?php }?>
                                   
                                </tr>
                                <?php
                                $i++;
                                
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
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
            <div id="container" ></div>
        </div>
</div>


</div>

<div id="page_content">
    <div id="page_content_inner">
        
    </div>
</div>

                



<script >

 jQuery(document).ready(function () {

        jQuery(".update").on('click', function () {
          
            var id = jQuery(this).attr('mid');
   
            if (confirm("Are you sure you want to inactive?")) {
                jQuery("#overlay").show();
                jQuery.get('<?php echo $this->webroot; ?>Uploadcoordinates/update/' + id, {}, function (data) {
                    if (data) {
                       location.reload();
                    }
                }, 'json').error(function (e) {
                    alert("Error Occured : " + e.statusText);
                    jQuery("#overlay").hide();
                });
            }

        });

        });
</script>

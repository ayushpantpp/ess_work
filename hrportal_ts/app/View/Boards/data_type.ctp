<script>
    function formOpen(create=null) {
        if(create!=''){
            location.replace("<?php echo $this->Html->url('data_type/'); ?>");
        }else{
            jQuery("#addform").slideToggle('medium');
        }
        
    }


</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Data Type Setup</h1>
    </div>
    <div id="page_content_inner" >
        <?php echo $flash = $this->Session->flash();
        
        if($CTid==''){
            $display="display: none;";
        }else{
            $display="display: block;";
        }
        ?> 
        <div class="md-card uk-width-medium-1-1"  id="addform"  style="<?php echo $display;?>">  
            <div class="md-card-content">

                <?php echo $this->Form->create('frm', array('url' => array('controller' => 'Boards', 'action' => 'data_type'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked padding-left-lg')); ?>
                <h3 class="heading_a">Data Type</h3>
                <?php 
                if(!empty($EditData)){ foreach($EditData as $eData);}?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            
                            <?php
                            echo $this->form->input('courttype', array('type' => "text", 'label' => "Data Type", 'required' => true,'value'=>$eData['DataType']['datatype'], 'class' => "md-input"));
                            echo $this->form->input('ctid', array('type' => "hidden", 'label' => false, 'value'=>$CTid, 'class' => "md-input"));
                            ?>
                        </div>
                    </div>                  
                    <div class="uk-width-medium-1-2" >
                        <button type="submit" name="submit"  class="md-btn md-btn-success" value="submit">Save</button>                    
                      
                        <?php if($CTid == ""){ ?>
                            <a class="md-btn md-btn-primary" id="form_open" onclick="return formOpen('')">Cancel</a> 
                            <?php }else{ ?>
                            <a class="md-btn md-btn-primary" id="form_open" onclick="return formOpen('<?php echo $create;?>')">Cancel</a> 
                        <?php }?>                       
                    </div>
                </div> 
                

                <div class="uk-grid">
                    
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">List of Data Type 
                    <?php if($CTid == ""){ ?>
                <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create;?>')">Create Data Type</a></h3>
                <?php }else{ ?>
                <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create;?>')">Cancel</a></h3>
                <?php }?>
                
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Data Type</th>
                                <th>Created On</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            $i=1;
                            foreach($data as $rec){ 
							 $ctr = (($this->params['paging']['DataType']['page'] * $this->params['paging']['DataType']['limit']) - $this->params['paging']['DataType']['limit']) + $i;
							 ?>
                            <tr>
                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ctr;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['DataType']['datatype'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['DataType']['created_on']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php //if($rec['DataType']['id'] != '1'){?>
                                        <a class="uk-badge uk-badge-success" id="form_open" href="<?php echo $this->Html->url('data_type/'.$rec['DataType']['id']); ?>">Edit</a>
                                        <!-- | <a class="uk-badge uk-badge-danger" id="form_open" href="<?php //echo $this->Html->url('data_type/'.$rec['DataType']['id'].'/del');  ?>" onclick="return confirm('Are you sure?');">Delete</a></span></td> -->
                                        <?php// }else{ echo "NA"; } ?>
                                         
                            </tr>
                            <?php  $i++; }?>
                        </tbody>
                    </table>
                </div>
            </div>
			<div class="clearfix"></div>
                    <div class="uk-grid" data-uk-grid-margin>
						<div class="uk-width-medium-1-2">
                                                           
                        </div>
                       
                        <div class="uk-width-medium-1-2">
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

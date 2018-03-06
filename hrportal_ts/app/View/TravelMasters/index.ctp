

<div id="page_content">


    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
       <div class="md-card-toolbar">
                          <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                             <b> List of Travel-Master</b>
                            </h3>
                        </div>
            <div class="md-card-content ">
            
                
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">Sr.No</th>
                                    <th>Department </th>
                                    <th>Designation</th>
                                    <th>City Group</th>
                                    <th>Cash Allowance Daily </th>
                                    <th>Hotel Entitlement</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
                            $i=1;

                            foreach($travelmasters as $travelmaster){ ?>
                            <tr>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->getdepartmentbyid($travelmaster['TravelMaster']['department_id']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->findDesignationName($travelmaster['TravelMaster']['designation_id'],'01');?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $travelmaster['TravelMaster']['city_type'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $travelmaster['TravelMaster']['amount'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $travelmaster['TravelMaster']['hotel_amount'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <?php 
//                                        echo $this->Html->link(__('Update'), array('action' => 'edit', $travelmaster['TravelMaster']['id'])); ?> 
                                                    <?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $travelmaster['TravelMaster']['id'])
//                                , array(), __('Are you sure you want to delete # %s?', $travelmaster['TravelMaster']['id'])); ?>
                                        
                                        <a class="uk-badge uk-badge-success" href="<?php echo $this->Html->url('/TravelMasters/edit/'.$travelmaster['TravelMaster']['id']); ?>">Edit</a> | 
                                        <a class="uk-badge uk-badge-danger" href="<?php echo $this->Html->url('/TravelMasters/delete/'.$travelmaster['TravelMaster']['id']); ?>" onclick="return confirm('Are you sure?');">Delete</a></span>
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

<script>
      function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>TravelMasters/index/"+val; 

 }
</script>
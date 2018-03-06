<div id="page_content">
        <div id="page_content_inner">
            <h3 class="heading_b uk-margin-bottom">View Meeting</h3>
            <?php echo $flash = $this->Session->flash();?>
            <span class="momStatus"></span>
            <div class="md-card">
                <div class="md-card-content">                    
                    <div class="uk-overflow-container uk-margin-bottom">
                        
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                            <thead>
                                <tr>                          
                                    <th class="filter-false remove sorter-false">Sr No.</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Title</th>                           
                                </tr>
                            </thead>
                    <tbody>
                        <?php $i = 1; foreach($events as $e){
                        ?>
                        <tr class="">   
                        <td><?php echo $i;?></td>
                        <td><?php echo $e['EmpEvent']['start'];?></td>
                        <td class="uk-text-small"><?php echo $e['EmpEvent']['end']; ?> </td>
                        <td><?php echo $e['EmpEvent']['title'];?></td>
                        </tr> 
                        <?php $i++; }  ?>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="uk-grid" data-uk-grid-margin>
                        
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
    </div>

<div id="page_content" role="main">
    <div id="page_content_inner">

  
    <?php echo $this->Session->flash(); ?>

    <div class="md-card">
        <div class="md-card-content">      <h3>Assigned Competency Group to Designation List</h3>                
            <?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => 'addGroup'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
            <div class="uk-overflow-container uk-margin-bottom">

                <table class="uk-table uk-table-nowrap">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Financial Year</th>
                            <th>Group Name</th>                           
                            <th>Created Date</th>                                   
                            <th class="filter-false remove sorter-false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //echo "<pre>";
                        //print_r($assignGroupToDesgList);
                        //die;
                        if (isset($assignGroupToDesgList)) {
                            $p = 1;
                            for ($i = 0; $i < count($assignGroupToDesgList); $i++) {

                                $ctr = (($this->params['paging']['AssignGroupToDesg']['page'] * $this->params['paging']['AssignGroupToDesg']['limit']) - $this->params['paging']['AssignGroupToDesg']['limit']) + $p;
                                
                                ?>
                                <tr>
                                    <td><?php echo $ctr; ?></td>
                                    <td><?php echo $this->Common->findfyDesc($assignGroupToDesgList[$i]['AssignGroupToDesg']['financial_year']); ?></td>
                                    <td><?php echo $this->Common->findGroupMasterName($assignGroupToDesgList[$i]['AssignGroupToDesg']['group_comp_id']); ?></td>
                                               
                                    <td><?php echo date('d-m-Y', strtotime($assignGroupToDesgList[$i]['AssignGroupToDesg']['created_date'])); ?></td>                                    
                                    <td> 
                                        <a data-uk-modal="{target:'#modal_overflow_response'}" onclick="return getAssignEmpDetails(<?php echo $assignGroupToDesgList[$i]['AssignGroupToDesg']['id'];?>)" alt="Assign Designation List" title="Assign Designation List" class="uk-badge uk-badge-success">Click Here</a>
                                        <!-- <a href="<?php echo $this->webroot; ?>Competency/addGroup/groupEdit/<?php echo $assignGroupToDesgList[$i]['AssignGroupToDesg']['id']; ?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a> -->
                                        <a href="<?php echo $this->webroot; ?>Competency/AssignGroupToDesgDelete/<?php echo $assignGroupToDesgList[$i]['AssignGroupToDesg']['id']; ?>" onClick="return confirm('Are you sure you want to delete??');" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a>
                                    </td>                          
                                </tr> 

                                <?php 
                                $p++;
                            }
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
            <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="uk-width-small-2-3">
    <div id="modal_overflow_response" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="assignEmpList" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>
<script type="text/javascript">
function getAssignEmpDetails(assignId){   
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>Competency/AssignGroupToDesgDetails/'+assignId,
            success: function(data){
          //alert(data);
                jQuery('#assignEmpList').html(data);
            }
        });
    }
</script>

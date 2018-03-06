<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Evolution Matrix Employee Lists</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <!-- Start Type---->
                        <div class="uk-overflow-container uk-margin-bottom">
                            <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                                <thead>
                                    <tr>
                                        <th class="uk-text-center">S No.</th>
                                        <th>Employee Name</th>
                                        <th>Employee Designation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                if (!empty($lists)) {
                                    $i = 1;
                                    foreach ($lists as $list) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ctr = (($this->params['paging']['TrainingMatrixAssignEmployee']['page'] * $this->params['paging']['TrainingMatrixAssignEmployee']['limit']) - $this->params['paging']['TrainingMatrixAssignEmployee']['limit']) + $i; ?></span></td>
                                                <td>
                                                    <?php echo $this->Common->findEmpName($list['TrainingMatrixAssignEmployee']['matrix_assign_emp_code']); ?>
                                                </td>
                                                <td>
                                                    <?php echo ucfirst(strtolower($this->Common->findDesignationName($this->Common->findDesignationByEmpCode($list['TrainingMatrixAssignEmployee']['matrix_assign_emp_code']), $list['TrainingMatrixAssignEmployee']['matrix_assign_comp_code']))); ?>
                                                </td>
                                                <td>
                                                    <span class="uk-text-upper">
                                                        <a class="md-btn md-btn-small uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>training/deleteMatrixEmployeee/<?php echo base64_encode($list['TrainingMatrixAssignEmployee']['id']); ?>/" title="Are you sure." onclick="return confirm('Are you sure?')" >Delete</a>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        $i++;
                                    }
                                } else {
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td>
                                                No Record Found
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php }
                                ?>
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
</div>
<?php

$i = 0;$p=1; ?>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Encashment Details For(<span><?php echo $emp_name; ?> </span>
        </span>- <span><?php echo $emp_id; ?></span></span>)</h3>
        <?php echo $flash = $this->Session->flash(); ?>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-overflow-container uk-margin-bottom">
            <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                <thead>
                    <tr>
                        <th class="filter-false remove sorter-false">Sr.No</th>
                        <th>Company Name</th>
                        <th>Department</th>
                        <th>Encash Leave</th>
                        <th>Leave Opening Balance </th>
                        <th>Leave Avail</th>
                        <th>Leave Balance </th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th class="filter-false remove sorter-false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($enchdetails)) { ?>
                    <tr class="even-pointer">
                        <td style="text-align:center;" colspan="11">
                            <em>--No Records Found--</em>
                        </td>
                    </tr>
                    <?php
                    } foreach ($enchdetails as $ench) {
                       
                        if ($ench['LeaveEncsh']['encsh_status'] == 1) {
                            $btnClass = "uk-badge uk-badge-primary";
                            $btnStatus = $this->Common->findSatus($ench['LeaveEncsh']['encsh_status']);
                        } elseif ($ench['LeaveEncsh']['encsh_status'] == 2) {
                            $btnClass = "uk-badge uk-badge-primary";
                            $btnStatus = $this->Common->findSatus($ench['LeaveEncsh']['encsh_status']);
                        } elseif ($ench['LeaveEncsh']['encsh_status'] == 3) {
                            $btnClass = "uk-badge uk-badge-warning";
                            $btnStatus = $this->Common->findSatus($ench['LeaveEncsh']['encsh_status']);
                        } elseif ($ench['LeaveEncsh']['encsh_status'] == 4) {
                            $btnClass = "uk-badge uk-badge-danger";
                            $btnStatus = $this->Common->findSatus($ench['LeaveEncsh']['encsh_status']);
                        } elseif ($ench['LeaveEncsh']['encsh_status'] == 5) {
                            $btnClass = "uk-badge uk-badge-success";
                            $btnStatus = $this->Common->findSatus($ench['LeaveEncsh']['encsh_status']);
                        } else {
                            $btnClass = "uk-badge uk-badge-danger";
                            $btnStatus = $this->Common->findSatus($ench['LeaveEncsh']['encsh_status']);
                        }
                        $comp_name = $this->Common->findCompanyNameByCode($ench['LeaveEncsh']['comp_code']);
                        $dept_name = $this->Common->getdepartmentbyid($ench['LeaveEncsh']['dept_code']);
                        ?>

                    <tr>
                        <td><?php echo $ctr = (($this->params['paging']['LeaveEncshDt']['page']*$this->params['paging']['LeaveEncshDt']['limit'])-$this->params['paging']['LeaveEncshDt']['limit'])+$p;?></td>
                        <td><span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $comp_name;?></span></td>
                        <td><?php echo $dept_name;?></td>
                        <td><?php echo $this->Common->findLeaveType($ench['LeaveEncshDt']['leave_id']); ?></td>
                        <td><?php echo $ench['LeaveEncshDt']['leave_op']; ?></td>
                        <td><?php echo $ench['LeaveEncshDt']['leave_avail']; ?></td>
                        <td><?php echo $ench['LeaveEncshDt']['leave_bal']; ?></td>
                        <td><span class="<?php echo $btnClass; ?>"><?php echo $btnStatus; ?></span></td>
                        <td><?php echo date('d-m-Y', strtotime($ench['LeaveEncshDt']['created_at'])); ?></td>
                        <td><?php if ($ench['LeaveEncshDt']['leaveencash_status'] == 1) { ?>
                            <a class="uk-badge uk-badge-primary" href="<?php echo $this->webroot; ?>leaves/encash_workflow_display/<?php echo $ench['LeaveEncshDt']['leave_encsh_id']; ?>" title="Click to Forward.">Forward</a>
                                <?php } else { ?>
                            N/A
                            <?php } ?>
                        </td>

                    </tr>
                    <?php $i++;$p++; } ?>
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
</div>
</div>
</div>


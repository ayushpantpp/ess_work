
<div class="uk-modal" id="new_issue">
    <div class="uk-modal-dialog">
        <ul class="uk-tab" data-uk-tab="{connect:'#tabs_4'}">
            <li class="uk-active"><a href="#">Add Course Type</a></li>
            <li><a href="#">Add Course Category</a></li>
            <li><a href="#">Add Course Validity</a></li>
        </ul>
        <ul id="tabs_4" class="uk-switcher uk-margin">
            <li>
                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'addCourseType'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return addtype(this)', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-margin-medium-bottom">
                    <label for="task_title">Course Type<span class="req">*</span></label>
                    <input type="text" class="md-input" id="type_name" name="type_name"/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company_lists, 'class' => 'md-input', 'label' => 'Company', 'required' => 'required')); ?>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="task_priority" class="uk-form-label">Status</label>
                    <div>
                        <span class="icheck-inline">
                            <input type="radio" name="status" value="0" checked data-md-icheck />
                            <label for="task_priority_minor" class="inline-label uk-badge uk-badge-success">Enable</label>
                        </span>
                        <span class="icheck-inline">
                            <input type="radio" name="status" value="1" data-md-icheck />
                            <label for="task_priority_critical" class="inline-label uk-badge uk-badge-warning">Disable</label>
                        </span>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="submit" class="md-btn md-btn-flat md-btn-flat-primary">Save</button>
                </div>
                <?php echo $this->Form->end(); ?>
            </li>
            <li>
                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'addCourseCategory'), 'id' => 'form_validation1', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return addtype(this)', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-margin-medium-bottom">
                    <label for="task_title">Course Category<span class="req">*</span></label>
                    <input type="text" class="md-input" id="category_name" name="category_name"/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company_lists, 'class' => 'md-input', 'label' => 'Company', 'required' => 'required')); ?>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="task_priority" class="uk-form-label">Status</label>
                    <div>
                        <span class="icheck-inline">
                            <input type="radio" name="status" value="0" checked data-md-icheck />
                            <label for="task_priority_minor" class="inline-label uk-badge uk-badge-success">Enable</label>
                        </span>
                        <span class="icheck-inline">
                            <input type="radio" name="status" value="1" data-md-icheck />
                            <label for="task_priority_critical" class="inline-label uk-badge uk-badge-warning">Disable</label>
                        </span>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="submit" class="md-btn md-btn-flat md-btn-flat-primary">Save</button>
                </div>
                <?php echo $this->Form->end(); ?>
            </li>
            <li>
                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'addCourseValidity'), 'id' => 'form_validation3', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return addtype(this)', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-margin-medium-bottom">
                    <label for="task_title">Course Validity<span class="req">*</span></label>
                    <?php echo $this->Form->input('validity_name', array('type' => 'select', 'options' => $this->Common->getTrainingValidityList(), 'class' => 'md-input', 'label' => false, 'required' => 'required', 'id' => 'validity_name')); ?>
                    <!--<input type="text" class="md-input" id="validity_name" name="validity_name"/>-->
                </div>
                <div class="uk-margin-medium-bottom">
                    <?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company_lists, 'class' => 'md-input', 'label' => 'Company', 'required' => 'required')); ?>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="task_priority" class="uk-form-label">Status</label>
                    <div>
                        <span class="icheck-inline">
                            <input type="radio" name="status" value="0" checked data-md-icheck />
                            <label for="task_priority_minor" class="inline-label uk-badge uk-badge-success">Enable</label>
                        </span>
                        <span class="icheck-inline">
                            <input type="radio" name="status" value="1" data-md-icheck />
                            <label for="task_priority_critical" class="inline-label uk-badge uk-badge-warning">Disable</label>
                        </span>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="submit" class="md-btn md-btn-flat md-btn-flat-primary">Save</button>
                </div>
                <?php echo $this->Form->end(); ?>
            </li>
        </ul>

    </div>
</div>

<div class="uk-modal" id="new_model">
    <div class="uk-modal-dialog">
        <div id="empResponse">

        </div>
    </div>
</div>


<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom">Course Masters</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <ul class="uk-tab" data-uk-tab="{connect:'#tabs_1'}">
                            <li class="uk-active"><a href="#">Course Master Type</a></li>
                            <li><a href="#">Course Master Category</a></li>
                            <li><a href="#">Course Master Validity</a></li>
                        </ul>
                        <ul id="tabs_1" class="uk-switcher uk-margin">
                            <li>
                                <!-- Start Type---->
                                <div class="uk-overflow-container uk-margin-bottom">
                                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair">
                                        <thead>
                                            <tr>
                                                <th class="uk-text-center">S No.</th>
                                                <th>Type Name</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        if (!empty($courseTypeLists)) {
                                            $i = 1;
                                            foreach ($courseTypeLists as $courseTypeList) {
                                                ?>
                                                <tbody>
                                                    <tr>
                                                        <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ctr = (($this->params['paging']['CourseTypeMaster']['page'] * $this->params['paging']['CourseTypeMaster']['limit']) - $this->params['paging']['CourseTypeMaster']['limit']) + $i; ?></span></td>
                                                        <td>
                                                            <?php echo $courseTypeList['CourseTypeMaster']['name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($courseTypeList['CourseTypeMaster']['status'] == 0)
                                                                echo 'Enable';
                                                            else
                                                                echo 'Disable';
                                                            ?>
                                                        </td>
                                                        <td><span class="uk-badge"><?php echo date("d-m-Y", strtotime($courseTypeList['CourseTypeMaster']['created_at'])); ?></span></td>
                                                        <td>
                                                            <span class="uk-text-upper">
                                                                <a href="#new_model" data-uk-modal="{ center:true }" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light" onclick="typeEdit(<?php echo $courseTypeList['CourseTypeMaster']['type_id']; ?>)">Edit</a><?php if (empty($this->Common->chkTypeAsgnCourse($courseTypeList['CourseTypeMaster']['type_id'], $courseTypeList['CourseTypeMaster']['org_id']))) { ?>
                                                                    <a class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light" href="<?php echo $this->webroot; ?>training/deleteCourseType/<?php echo base64_encode($courseTypeList['CourseTypeMaster']['type_id']); ?>/" title="Delete" onclick="return confirm('Are you sure?')" >Delete</a>
                                                                <?php } ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
<!--                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-1">
                                        <ul class="uk-pagination uk-pagination-right">
                                            <?php
                                            echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                            echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                            echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                            ?>
                                        </ul>
                                    </div>
                                </div>-->
                                <!-- Ends Type---->
                            </li>
                            <li>
                                <div class="uk-overflow-container uk-margin-bottom">
                                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair">
                                        <thead>
                                            <tr>
                                                <th class="uk-text-center">S No.</th>
                                                <th>Category Name</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        if (!empty($courseCategoryLists)) {
                                            $j = 1;
                                            foreach ($courseCategoryLists as $courseCategoryList) {
                                                ?>
                                                <tbody>
                                                    <tr>
                                                        <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $j; ?></span></td>
                                                        <td>
                                                            <?php echo $courseCategoryList['CourseCategoryMaster']['name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($courseCategoryList['CourseCategoryMaster']['status'] == 0)
                                                                echo 'Enable';
                                                            else
                                                                echo 'Disable';
                                                            ?>
                                                        </td>
                                                        <td><span class="uk-badge"><?php echo date("d-m-Y", strtotime($courseCategoryList['CourseCategoryMaster']['created_at'])); ?></span></td>
                                                        <td><span class="uk-text-upper"><a href="#new_model" data-uk-modal="{ center:true }" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light" onclick="categoryEdit(<?php echo $courseCategoryList['CourseCategoryMaster']['category_id']; ?>)">Edit</a>
                                                                <?php if (empty($this->Common->chkCategoryAsgnCourse($courseCategoryList['CourseCategoryMaster']['category_id'], $courseCategoryList['CourseCategoryMaster']['org_id']))) { ?>
                                                                    <a class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light" href="<?php echo $this->webroot; ?>training/deleteCategoryType/<?php echo base64_encode($courseCategoryList['CourseCategoryMaster']['category_id']); ?>/" title="Delete" onclick="return confirm('Are you sure?')" >Delete</a>
                                                                <?php } ?>
                                                            </span></td>
                                                    </tr>
                                                </tbody>
                                                <?php
                                                $j++;
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>

                            </li>
                            <li>
                                <div class="uk-overflow-container uk-margin-bottom">
                                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair">
                                        <thead>
                                            <tr>
                                                <th class="uk-text-center">S No.</th>
                                                <th>Validity Name</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        if (!empty($courseValidityLists)) {
                                            $k = 1;
                                            foreach ($courseValidityLists as $courseValidityList) {
                                                ?>
                                                <tbody>
                                                    <tr>
                                                        <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $k; ?></span></td>
                                                        <td>
                                                            <?php echo $this->Common->getTrainingValidityMasterName($courseValidityList['CourseValidityMaster']['validity_master_id']); ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($courseValidityList['CourseValidityMaster']['status'] == 0)
                                                                echo 'Enable';
                                                            else
                                                                echo 'Disable';
                                                            ?>
                                                        </td>
                                                        <td><span class="uk-badge"><?php echo date("d-m-Y", strtotime($courseValidityList['CourseValidityMaster']['created_at'])); ?></span></td>
                                                        <td><span class="uk-text-upper"><a href="#new_model" data-uk-modal="{ center:true }" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light" onclick="validityEdit(<?php echo $courseValidityList['CourseValidityMaster']['validity_id']; ?>)">Edit</a>
                                                                <?php if (empty($this->Common->chkValidityAsgnCourse($courseValidityList['CourseValidityMaster']['validity_id'], $courseValidityList['CourseValidityMaster']['org_id']))) { ?>
                                                                    <a class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light" href="<?php echo $this->webroot; ?>training/deleteValidityType/<?php echo base64_encode($courseValidityList['CourseValidityMaster']['validity_id']); ?>/" title="Delete" onclick="return confirm('Are you sure?')" >Delete</a>
                                                                <?php } ?>
                                                            </span></td>
                                                    </tr>
                                                </tbody>
                                                <?php
                                                $k++;
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="md-fab-wrapper">
    <a class="md-fab md-fab-accent" href="#new_issue" data-uk-modal="{ center:true }">
        <i class="material-icons">&#xE145;</i>
    </a>
</div>

<script>
    function addtype(idd) {
        frd = jQuery(idd).find("input[type!=hidden]:first");
        if ((jQuery(frd).attr("id") == 'type_name') && (jQuery.trim(jQuery(frd).val()) == "")) {
            alert("Please enter the Course Type Name");
            return false;
        } else if ((jQuery(frd).attr("id") == 'category_name') && (jQuery.trim(jQuery(frd).val()) == "")) {
            alert("Please enter the Course Category Name");
            return false;
        } else if ((jQuery(frd).attr("id") == 'validity_name') && (jQuery.trim(jQuery(frd).val()) == "")) {
            alert("Please enter the Course Validity Name");
            return false;
        } else {
            return true;
        }
    }

    function updatetype(idd) {
        frd = jQuery(idd).find("input[type!=hidden]:first");
        if ((jQuery(frd).attr("id") == 'type_name') && (jQuery.trim(jQuery(frd).val()) == "")) {
            alert("Please enter the Course Type Name");
            return false;
        } else if ((jQuery(frd).attr("id") == 'category_name') && (jQuery.trim(jQuery(frd).val()) == "")) {
            alert("Please enter the Course Category Name");
            return false;
        } else if ((jQuery(frd).attr("id") == 'validity_name') && (jQuery.trim(jQuery(frd).val()) == "")) {
            alert("Please enter the Course Validity Name");
            return false;
        } else {
            return true;
        }
    }

    function typeEdit(idd) {
        jQuery('#empResponse').html('');
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>training/typedetail/' + idd,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
    function categoryEdit(idd) {
        jQuery('#empResponse').html('');
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>training/categorydetail/' + idd,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
    function validityEdit(idd) {
        jQuery('#empResponse').html('');
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>training/validitydetail/' + idd,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
</script>


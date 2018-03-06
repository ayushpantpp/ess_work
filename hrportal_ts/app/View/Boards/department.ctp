<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Department List</h3>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div data-uk-grid-margin="" class="uk-grid">                    
                    <div class="uk-width-medium-1-2 uk-row-first">
                        <div class="md-input-wrapper"><label for="contact_list_search">Find Department</label><input type="text" id="contact_list_search" class="md-input"><span class="md-input-bar"></span></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="contact_list" class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-grid-width-xlarge-1-5" style="position: relative; margin-left: -20px; height: 402px;">
        
            <?php 
            $departmentList = $this->common->findAllDepartmentWithIconsAndName();            
            //echo "<pre>";
            //print_r($departmentList);            
            for($i=0;$i<count($departmentList);$i++){ ?>
            <div data-uk-filter="<?php echo $departmentList[$i]['Department']['dept_name'];?>, <?php echo $departmentList[$i]['Department']['dept_name'];?>" data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 20px; padding-bottom: 20px; top: 0px; left: 0px; opacity: 1;">
               
                <div class="md-card-content" >
                    <div class="md-card md-card-hover">
                        <div class="md-card-head md-bg-cyan-600">
                            <div class="md-card-head-menu" data-uk-dropdown="{pos:'bottom-right'}">
                                <i class="md-icon material-icons md-icon-light">&#xE5D4;</i>
                                <div class="uk-dropdown uk-dropdown-small">
                                    <ul class="uk-nav">
                                        <li><a href="<?php echo $this->webroot; ?>boards/dept_employee/<?php echo base64_encode($departmentList[$i]['Department']['dept_code']);?>" target="_blank">View All Employee</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="uk-text-center">
                                <img class="md-card-head-avatar" src="<?php echo $this->webroot?>img/department_icons/<?php echo $departmentList[$i]['Department']['icon_style'];?>" alt=""/>
                            </div>
                            <h3 class="md-card-head-text uk-text-center md-color-white">
                                <?php echo $departmentList[$i]['Department']['dept_name'];?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>            
            <?php } ?>
        </div>
    </div>        
</div>
<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom">Employee List : <?php echo $this->common->getdepartmentbyid($departmentId);?> Department </h3>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div data-uk-grid-margin="" class="uk-grid">
                    <div class="uk-width-medium-1-2 uk-row-first">
                        <div class="uk-vertical-align">
                            <div class="uk-vertical-align-middle">
                                <ul class="uk-subnav uk-subnav-pill uk-margin-remove" id="contact_list_filter">
                                    <li data-uk-filter="" class="uk-active"><a href="#">All</a></li>
                                    <li data-uk-filter="MANAGER"><a href="#">Manager</a></li>
                                    <li data-uk-filter="SENIOR MANAGER"><a href="#">Senior Manager</a></li>
                                    <li data-uk-filter="OFFICER"><a href="#">Officer </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="md-input-wrapper"><label for="contact_list_search">Find Employee</label><input type="text" id="contact_list_search" class="md-input"><span class="md-input-bar"></span></div>

                    </div>
                </div>
            </div>
        </div>

        <div id="contact_list" class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-grid-width-xlarge-1-4" style="position: relative; margin-left: -20px; height: 402px;">
            <?php 
            for($i=0;$i<count($profile);$i++){ 
                 $designation =  $this->common->findDesignationName($profile[$i]['MyProfile']['desg_code'],$profile[$i]['MyProfile']['comp_code']);
                 $emailArray = $this->common->findUserDetailByEmpCode($profile[$i]['MyProfile']['emp_code']);
                 $emailId = $emailArray[0]['UserDetail']['email'];
                 
            ?>
            
            <div data-uk-filter="<?php echo $designation;?>, <?php echo $profile[$i]['MyProfile']['emp_name']?>" data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 20px; padding-bottom: 20px; top: 0px; left: 0px; opacity: 1;">
                <div class="md-card md-card-hover">
                    <div class="md-card-head">
                        <div data-uk-dropdown="{pos:'bottom-right'}" class="md-card-head-menu">
                            <i class="md-icon material-icons"></i>
                            <div class="uk-dropdown uk-dropdown-small">
                                <ul class="uk-nav">
                                    <li><a href="<?php echo $this->webroot;?>users/myprofile/<?php echo base64_encode($profile[$i]['MyProfile']['emp_code']);?>">View Full Profile</a></li>                                    
                                </ul>
                            </div>
                        </div>
                        <div class="uk-text-center">
                            <?php 
                            
                            if(!empty($profile[$i]['MyProfile']['image'])){ ?>
                                <img src="<?php echo $this->webroot.'uploads/profile/'.$profile[$i]['MyProfile']['image']; ?>" alt="User Image" class="md-card-head-avatar"/>
                            <?php } else { 
                                $genderName = $this->common->findGenderName($profile[$i]['MyProfile']['gender']);
                                if($genderName == "MALE"){
                                    $genderImage = "male_82X82.jpg";
                                }else{
                                    $genderImage = "female_82X82.jpg";
                                }?>
                                <img src="<?php echo $this->webroot."images/$genderImage"; ?>"  alt="User Imagess" class="md-card-head-avatar"/>
                            <?php } ?>
                        </div>
                        <h3 class="md-card-head-text uk-text-center">
                            <?php echo $profile[$i]['MyProfile']['emp_name']?>
                            <span class="uk-text-truncate"><?php echo $designation;?></span>
                        </h3>
                    </div>
                    <div class="md-card-content">
                        <ul class="md-list">
<!--                            <li>
                                <div class="md-list-content">
                                    <span class="md-list-heading">Info</span>
                                    <span class="uk-text-small uk-text-muted">Corrupti eos qui perspiciatis corrupti qui aspernatur velit.</span>
                                </div>
                            </li>-->
                            <li>
                                <div class="md-list-content">
                                    <span class="md-list-heading">Email</span>
                                    <span class="uk-text-small uk-text-muted uk-text-truncate"><?php if($emailId){echo $emailId;}else { echo "Not Available";}?></span>
                                </div>
                            </li>
                            <li>
                                <div class="md-list-content">
                                    <span class="md-list-heading">Phone</span>
                                    <span class="uk-text-small uk-text-muted"><?php if($profile[$i]['MyProfile']['contact']) {echo $profile[$i]['MyProfile']['contact'];}else{ echo "Not Available";}?></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>

    

</div>